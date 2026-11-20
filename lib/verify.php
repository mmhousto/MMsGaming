<?php
/*
 * Email verification for new accounts.
 *
 * New players get an email with a link; until they click it they can log in
 * and play, but can't comment, earn points or use the Store. Accounts that
 * existed before this feature are marked verified by the database migration
 * (db/migrations/002_email_verification.sql). Until that migration has run,
 * every account counts as verified, so nothing is locked by accident.
 */

const VERIFY_LINK_HOURS = 48;

/** Whether the database has the verification column yet. */
function verification_ready(mysqli $link): bool
{
    static $ready = null;
    if ($ready === null) {
        try {
            $res = mysqli_query($link, "SHOW COLUMNS FROM users LIKE 'email_verified_at'");
            $ready = $res && mysqli_num_rows($res) === 1;
        } catch (mysqli_sql_exception $e) {
            $ready = false;
        }
    }
    return $ready;
}

function is_email_verified(mysqli $link, $uid): bool
{
    static $cache = [];
    $uid = (int) $uid;
    if ($uid <= 0) {
        return false;
    }
    if (!verification_ready($link)) {
        return true;
    }
    if (!isset($cache[$uid])) {
        $res = db_query($link, 'SELECT email_verified_at FROM users WHERE id = ?', [$uid]);
        $row = $res ? mysqli_fetch_assoc($res) : null;
        $cache[$uid] = $row !== null && $row['email_verified_at'] !== null;
    }
    return $cache[$uid];
}

/** True for a logged-in player who still needs to confirm their email. */
function needs_email_verification(mysqli $link): bool
{
    return is_logged_in() && !is_email_verified($link, $_SESSION['id']);
}

/**
 * Send an email from the site. Uses PHP mail(); the sender comes from
 * MAIL_FROM in MMsGamingconfig.php. For automated tests, MMSG_MAIL_LOG
 * makes it write the email to a file instead of sending it.
 */
function site_mail(string $to, string $subject, string $html): bool
{
    $log = getenv('MMSG_MAIL_LOG');
    if ($log) {
        return file_put_contents($log, json_encode(['to' => $to, 'subject' => $subject, 'html' => $html]) . "\n", FILE_APPEND | LOCK_EX) !== false;
    }
    $from = defined('MAIL_FROM') ? MAIL_FROM : 'no-reply@mms-gaming.com';
    $headers = "From: MM's Gaming Community <$from>\r\n"
        . "Content-Type: text/html; charset=utf-8\r\n";
    return mail($to, $subject, $html, $headers);
}

/**
 * Email a fresh verification link to the player. Older links stop working.
 * Limited to 3 emails per account per hour. Returns false if not sent.
 */
function send_verification_email(mysqli $link, int $uid, string $email): bool
{
    if (!verification_ready($link) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    if (rate_count($link, 'verify', (string) $uid, null, 3600) >= 3) {
        return false;
    }
    rate_record($link, 'verify', (string) $uid);

    $selector = bin2hex(random_bytes(8));
    $validator = random_bytes(32);
    db_query($link, 'DELETE FROM email_verifications WHERE user_id = ?', [$uid]);
    db_query($link, 'INSERT INTO email_verifications (user_id, email, selector, token_hash, expires_at) VALUES (?, ?, ?, ?, ?)', [
        $uid, $email, $selector, hash('sha256', $validator), date('Y-m-d H:i:s', time() + VERIFY_LINK_HOURS * 3600),
    ]);

    $url = 'https://mms-gaming.com/verify-email.php?selector=' . $selector . '&validator=' . bin2hex($validator);
    $html = '<p>Welcome to MM\'s Gaming Community!</p>'
        . '<p>Please confirm your email address to start earning points, commenting and using the Store:</p>'
        . '<p><a href="' . e($url) . '">Confirm my email address</a></p>'
        . '<p>This link works for ' . VERIFY_LINK_HOURS . ' hours. If you didn\'t create an account, you can ignore this email.</p>';
    return site_mail($email, "Confirm your email for MM's Gaming Community", $html);
}

/**
 * Check a verification link. On success marks the account verified and
 * returns true.
 */
function confirm_email(mysqli $link, string $selector, string $validatorHex): bool
{
    if (!verification_ready($link) || !ctype_xdigit($selector) || !ctype_xdigit($validatorHex) || strlen($validatorHex) !== 64) {
        return false;
    }
    $res = db_query($link, 'SELECT id, user_id, email, token_hash, expires_at FROM email_verifications WHERE selector = ?', [$selector]);
    $row = $res ? mysqli_fetch_assoc($res) : null;
    if (!$row || strtotime($row['expires_at']) < time()
        || !hash_equals($row['token_hash'], hash('sha256', hex2bin($validatorHex)))) {
        return false;
    }
    // Only verify the address the link was sent to (the email may have changed since).
    db_query($link, 'UPDATE users SET email_verified_at = ? WHERE id = ? AND Email = ?', [date('Y-m-d H:i:s'), (int) $row['user_id'], $row['email']]);
    $ok = db_affected_rows() === 1;
    db_query($link, 'DELETE FROM email_verifications WHERE user_id = ?', [(int) $row['user_id']]);
    return $ok;
}
