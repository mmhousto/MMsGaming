<?php
/*
 * Shared security helpers. Loaded by config.php, so every page that
 * includes config.php can use them.
 */

/**
 * Run a query with ? placeholders as a prepared statement.
 * Returns a mysqli_result for SELECTs, true for other successful
 * statements, and false on failure.
 */
function db_query(mysqli $link, string $sql, array $params = [])
{
    $stmt = mysqli_prepare($link, $sql);
    if ($stmt === false) {
        return false;
    }
    if ($params) {
        $types = '';
        foreach ($params as $p) {
            $types .= is_int($p) ? 'i' : (is_float($p) ? 'd' : 's');
        }
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    if (!mysqli_stmt_execute($stmt)) {
        mysqli_stmt_close($stmt);
        return false;
    }
    $GLOBALS['mmsgAffectedRows'] = mysqli_stmt_affected_rows($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if ($result === false) {
        // Not a SELECT (UPDATE/INSERT/DELETE): report success instead.
        $ok = mysqli_stmt_errno($stmt) === 0;
        mysqli_stmt_close($stmt);
        return $ok;
    }
    mysqli_stmt_close($stmt);
    return $result;
}

/** Rows changed by the most recent db_query() UPDATE/INSERT/DELETE. */
function db_affected_rows(): int
{
    return (int) ($GLOBALS['mmsgAffectedRows'] ?? 0);
}

function is_logged_in(): bool
{
    return isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true
        && !empty($_SESSION['id']);
}

/** For endpoints that change data: must be logged in and use POST. */
function require_login_post(): void
{
    if (!is_logged_in()) {
        header('Location: login.php');
        exit;
    }
    if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
        header('Location: index.php');
        exit;
    }
}

/** Escape text for HTML output. */
function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Encode a value for use inside a <script> block. */
function js($value): string
{
    return json_encode($value, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
}

/**
 * A safe CSS color: #rgb, #rgba, #rrggbb, #rrggbbaa, or a plain
 * color name like "red" / "darkslateblue". Returns null if invalid.
 */
function safe_css_color($value): ?string
{
    $value = trim((string) $value);
    if (preg_match('/^#(?:[0-9a-fA-F]{3,4}|[0-9a-fA-F]{6}|[0-9a-fA-F]{8})$/', $value)
        || preg_match('/^[a-zA-Z]{3,30}$/', $value)) {
        return $value;
    }
    return null;
}

/** A safe font name like "Comic Sans MS" or "Roboto-Bold". Returns null if invalid. */
function safe_font_name($value): ?string
{
    $value = trim((string) $value);
    return preg_match('/^[A-Za-z0-9 \-]{1,40}$/', $value) ? $value : null;
}

/**
 * A safe https image URL for use inside CSS url(...). Rejects anything
 * containing characters that could break out of the CSS value.
 * Returns null if invalid.
 */
function safe_image_url($value): ?string
{
    $value = trim((string) $value);
    if (strlen($value) > 500 || !filter_var($value, FILTER_VALIDATE_URL)) {
        return null;
    }
    if (strtolower((string) parse_url($value, PHP_URL_SCHEME)) !== 'https') {
        return null;
    }
    if (preg_match('/[\s"\'()\\\\<>;{}]/', $value)) {
        return null;
    }
    return $value;
}

/**
 * Buy a one-time store item atomically: marks the item owned and
 * deducts the cost in one transaction, so it can't be bought twice
 * or push points below zero, even with simultaneous requests.
 * Returns 'ok', 'owned' or 'poor'.
 */
function buy_item(mysqli $link, int $userId, string $flagColumn, int $cost): string
{
    $allowed = ['ownBg', 'ownImg', 'ownTrail', 'ownCursor', 'ownFont'];
    if (!in_array($flagColumn, $allowed, true)) {
        throw new InvalidArgumentException('Unknown store item');
    }
    mysqli_begin_transaction($link);
    try {
        db_query($link, "UPDATE custom SET $flagColumn = 1 WHERE UID = ? AND $flagColumn = 0", [$userId]);
        if (db_affected_rows() !== 1) {
            mysqli_rollback($link);
            return 'owned';
        }
        db_query($link, 'UPDATE users SET points = points - ? WHERE id = ? AND points >= ?', [$cost, $userId, $cost]);
        if (db_affected_rows() !== 1) {
            mysqli_rollback($link);
            return 'poor';
        }
        mysqli_commit($link);
        return 'ok';
    } catch (Throwable $t) {
        mysqli_rollback($link);
        throw $t;
    }
}

/*
 * Protection against forged form submissions (CSRF).
 *
 * Every page that loads config.php gets csrf_protect():
 *  - a POST without the session's secret token is refused, and
 *  - every <form method="post"> on the page that submits to this site
 *    automatically gets the token as a hidden field.
 * So new forms are protected without any extra code.
 */
const CSRF_FIELD = 'csrf_token';

/** Requests that legitimately arrive without a browser session. */
const CSRF_EXEMPT_SCRIPTS = [
    'donate.php', // PayPal's server-to-server payment notification
];

function csrf_token(): string
{
    if (empty($_SESSION[CSRF_FIELD])) {
        $_SESSION[CSRF_FIELD] = bin2hex(random_bytes(32));
    }
    return $_SESSION[CSRF_FIELD];
}

function csrf_valid(): bool
{
    $sent = $_POST[CSRF_FIELD] ?? '';
    return is_string($sent) && !empty($_SESSION[CSRF_FIELD])
        && hash_equals($_SESSION[CSRF_FIELD], $sent);
}

/** Output filter: add the hidden token to this site's POST forms. */
function csrf_inject_forms(string $html): string
{
    if (stripos($html, '<form') === false || session_status() !== PHP_SESSION_ACTIVE) {
        return $html;
    }
    $field = '<input type="hidden" name="' . CSRF_FIELD . '" value="' . csrf_token() . '">';
    return preg_replace_callback('/<form\b[^>]*>/i', function ($m) use ($field) {
        $tag = $m[0];
        if (!preg_match('/\bmethod\s*=\s*["\']?post\b/i', $tag)) {
            return $tag; // GET forms (search etc.) don't change anything
        }
        if (preg_match('/\baction\s*=\s*["\']?\s*(https?:)?\/\//i', $tag)
            && !preg_match('/\baction\s*=\s*["\']?\s*(https?:)?\/\/(www\.)?mms-gaming\.com\b/i', $tag)) {
            return $tag; // submits to another site (e.g. PayPal): don't leak the token
        }
        return $tag . $field;
    }, $html);
}

function csrf_protect(): void
{
    static $done = false;
    if ($done) {
        return;
    }
    $done = true;

    if (session_status() === PHP_SESSION_NONE && !headers_sent()) {
        session_start();
    }
    $script = basename($_SERVER['SCRIPT_NAME'] ?? '');
    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST' && !in_array($script, CSRF_EXEMPT_SCRIPTS, true) && !csrf_valid()) {
        http_response_code(403);
        echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>Form expired</title></head>'
            . '<body style="font-family: Arial; background-color: #38b6ff; text-align: center; padding: 60px 16px;">'
            . '<h1>This form has expired</h1><p>For your security, please go back, refresh the page and try again.</p>'
            . '<p><a href="/index.php">Back to MM\'s Gaming</a></p></body></html>';
        exit;
    }
    // One output filter for every page: form tokens, then search/social tags (lib/seo.php).
    ob_start(function (string $html): string {
        $html = csrf_inject_forms($html);
        return function_exists('seo_enrich_head') ? seo_enrich_head($html) : $html;
    });
}
