<?php
/*
 * PayPal donations: $1 = 1,000 points and Donor status.
 *
 * The Donate button (Store page) sends PayPal a signed code for the player
 * in the "custom" field. PayPal then posts a payment notice (IPN) to
 * donate.php, which credits the player only after:
 *   - PayPal confirms the notice is genuine,
 *   - the money went to YOUR PayPal account (PAYPAL_RECEIVER in the private
 *     MMsGamingconfig.php: your PayPal email address or merchant account ID),
 *   - the payment is Completed and in USD,
 *   - this payment hasn't been credited before (PayPal re-sends notices).
 * Refunds and reversals take the points back.
 */

const DONATION_POINTS_PER_DOLLAR = 1000;
const DONATION_CURRENCY = 'USD';

function donation_secret(): string
{
    // A dedicated secret if one is configured, otherwise one derived from the
    // (private) database password, so nothing extra has to be set up.
    $base = defined('DONATION_SECRET') ? DONATION_SECRET : ('mmsg-donations|' . (defined('DB_PASSWORD') ? DB_PASSWORD : ''));
    return hash('sha256', $base, true);
}

/** Signed code identifying a player, sent to PayPal as "custom". */
function donation_custom_token(int $uid): string
{
    return 'u' . $uid . '.' . substr(hash_hmac('sha256', 'u' . $uid, donation_secret()), 0, 20);
}

/** The player id in a signed code, or null if it's missing or forged. */
function donation_custom_user(string $token): ?int
{
    if (!preg_match('/^u([1-9][0-9]{0,9})\.([0-9a-f]{20})$/', $token, $m)) {
        return null;
    }
    return hash_equals(donation_custom_token((int) $m[1]), $token) ? (int) $m[1] : null;
}

/** Ask PayPal whether a notice really came from PayPal. */
function paypal_ipn_verified(string $rawBody): bool
{
    // MMSG_PAYPAL_VERIFY_URL lets the automated tests use a stand-in for PayPal.
    $url = getenv('MMSG_PAYPAL_VERIFY_URL') ?: 'https://ipnpb.paypal.com/cgi-bin/webscr';
    $ch = curl_init($url);
    curl_setopt_array($ch, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => 'cmd=_notify-validate&' . $rawBody,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTPHEADER => ['Connection: Close', 'User-Agent: MMsGaming-IPN'],
    ]);
    $result = curl_exec($ch);
    curl_close($ch);
    return is_string($result) && trim($result) === 'VERIFIED';
}

/** Whether the notice's receiver is your PayPal account. */
function paypal_receiver_ok(array $ipn): bool
{
    if (!defined('PAYPAL_RECEIVER') || trim((string) PAYPAL_RECEIVER) === '') {
        return false;
    }
    $mine = array_map('strtolower', array_map('trim', explode(',', (string) PAYPAL_RECEIVER)));
    foreach (['receiver_email', 'business', 'receiver_id'] as $field) {
        if (isset($ipn[$field]) && in_array(strtolower(trim((string) $ipn[$field])), $mine, true)) {
            return true;
        }
    }
    return false;
}

/**
 * Handle one PayPal notice. Returns what happened (for logs and tests):
 * credited, credited-guest, refunded, duplicate, ignored-status, invalid,
 * wrong-receiver, wrong-currency, not-configured, error.
 */
function handle_paypal_ipn(mysqli $link, string $rawBody, array $ipn): string
{
    if (!paypal_ipn_verified($rawBody)) {
        return 'invalid';
    }
    if (!defined('PAYPAL_RECEIVER')) {
        error_log('MMsGaming: PayPal notice ignored, PAYPAL_RECEIVER is not set in MMsGamingconfig.php');
        return 'not-configured';
    }
    if (!paypal_receiver_ok($ipn)) {
        return 'wrong-receiver';
    }

    $status = (string) ($ipn['payment_status'] ?? '');
    $txn = substr((string) ($ipn['txn_id'] ?? ''), 0, 64);
    if ($txn === '') {
        return 'ignored-status';
    }

    try {
        if (in_array($status, ['Refunded', 'Reversed'], true)) {
            return donation_refund($link, $txn, substr((string) ($ipn['parent_txn_id'] ?? ''), 0, 64), $status);
        }
        if ($status !== 'Completed') {
            return 'ignored-status';
        }
        if (strtoupper((string) ($ipn['mc_currency'] ?? '')) !== DONATION_CURRENCY) {
            return 'wrong-currency';
        }

        $amount = round((float) ($ipn['mc_gross'] ?? 0), 2);
        $uid = donation_custom_user((string) ($ipn['custom'] ?? ''));
        $points = ($uid !== null && $amount > 0) ? (int) floor($amount * DONATION_POINTS_PER_DOLLAR) : 0;

        mysqli_begin_transaction($link);
        // The unique txn_id makes a re-sent notice fail here instead of crediting twice.
        try {
            db_query($link, 'INSERT INTO donations (txn_id, user_id, amount, currency, points, status, payer_email, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)', [
                $txn, $uid, (string) $amount, DONATION_CURRENCY, $points, 'completed',
                substr((string) ($ipn['payer_email'] ?? ''), 0, 255), date('Y-m-d H:i:s'),
            ]);
        } catch (mysqli_sql_exception $e) {
            mysqli_rollback($link);
            if ((int) $e->getCode() === 1062) {
                return 'duplicate';
            }
            throw $e;
        }
        if ($uid !== null && $points > 0) {
            db_query($link, 'UPDATE users SET points = points + ? WHERE id = ?', [$points, $uid]);
            db_query($link, 'UPDATE custom SET Donor = 1 WHERE UID = ?', [$uid]);
        }
        mysqli_commit($link);
        return $uid !== null ? 'credited' : 'credited-guest';
    } catch (Throwable $t) {
        @mysqli_rollback($link);
        error_log('MMsGaming: PayPal notice failed: ' . $t->getMessage());
        return 'error';
    }
}

/** A refund or chargeback: take back the points from the original donation. */
function donation_refund(mysqli $link, string $txn, string $parentTxn, string $status): string
{
    if ($parentTxn === '') {
        return 'ignored-status';
    }
    mysqli_begin_transaction($link);
    $res = db_query($link, 'SELECT id, user_id, points, status FROM donations WHERE txn_id = ? FOR UPDATE', [$parentTxn]);
    $orig = $res ? mysqli_fetch_assoc($res) : null;
    if (!$orig || $orig['status'] !== 'completed') {
        mysqli_rollback($link);
        return $orig ? 'duplicate' : 'ignored-status';
    }
    db_query($link, 'UPDATE donations SET status = ? WHERE id = ?', [strtolower($status), (int) $orig['id']]);
    if ($orig['user_id'] !== null && (int) $orig['points'] > 0) {
        db_query($link, 'UPDATE users SET points = GREATEST(points - ?, 0) WHERE id = ?', [(int) $orig['points'], (int) $orig['user_id']]);
    }
    mysqli_commit($link);
    return 'refunded';
}
