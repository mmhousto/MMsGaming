<?php
/*
 * Account safety rules: password strength and limits on repeated attempts.
 */

const PASSWORD_MIN_LENGTH = 10;

/** Very common passwords that are rejected no matter how long they are. */
const COMMON_PASSWORDS = [
    '1234567890', '12345678910', '0123456789', '1111111111', '0000000000', '1234512345',
    '9876543210', '1q2w3e4r5t', 'qwertyuiop', 'asdfghjkl;', 'zxcvbnm123', 'qwerty1234',
    '1qaz2wsx3edc', 'password', 'password1', 'password12', 'password123', 'password1234',
    'passw0rd123', 'p@ssw0rd123', 'iloveyou12', 'iloveyou123', 'princess123', 'football123',
    'baseball123', 'basketball', 'basketball1', 'superman123', 'batman1234', 'starwars123',
    'pokemon123', 'minecraft1', 'minecraft12', 'minecraft123', 'fortnite123', 'roblox1234',
    'letmein123', 'welcome123', 'welcome1234', 'trustno1234', 'monkey1234', 'dragon1234',
    'sunshine123', 'shadow1234', 'master1234', 'michael123', 'jennifer123', 'computer123',
    'whatever123', 'abcdefghij', 'abcd123456', 'abc1234567', 'qwerty12345', 'qwerty123456',
    'gaming1234', 'gamer12345', 'mmsgaming1', 'mmsgaming123', 'changeme123', 'administrator',
    'admin12345', 'admin123456', 'test123456', 'testtest123', 'hello12345', 'helloworld',
    'helloworld1', 'freedom123', 'liverpool1', 'chelsea123', 'arsenal123', 'charlie123',
];

/**
 * Problem with a new password, as a message to show, or null if it's fine.
 */
function password_problem(string $password, string $username = ''): ?string
{
    if (strlen($password) < PASSWORD_MIN_LENGTH) {
        return 'Password must have at least ' . PASSWORD_MIN_LENGTH . ' characters.';
    }
    if (strlen($password) > 72) {
        return 'Password must be 72 characters or fewer.';
    }
    $lower = strtolower($password);
    if (in_array($lower, COMMON_PASSWORDS, true) || preg_match('/^(.)\1+$/', $password)) {
        return 'That password is too common. Please choose something harder to guess.';
    }
    if ($username !== '' && strlen($username) >= 3 && strpos($lower, strtolower($username)) !== false) {
        return 'Password must not contain your username.';
    }
    return null;
}

/*
 * Limits on repeated attempts (wrong passwords, reset emails), stored in
 * the rate_limits table. If that table hasn't been created yet the limits
 * are skipped (and logged) rather than breaking login.
 */

function client_ip(): string
{
    return substr((string) ($_SERVER['REMOTE_ADDR'] ?? ''), 0, 45);
}

/** How many attempts of this kind for this subject (or IP) in the window. */
function rate_count(mysqli $link, string $kind, ?string $subject, ?string $ip, int $windowSeconds): int
{
    try {
        $since = date('Y-m-d H:i:s', time() - $windowSeconds);
        if ($subject !== null) {
            $res = db_query($link, 'SELECT COUNT(*) AS n FROM rate_limits WHERE kind = ? AND subject = ? AND attempted_at >= ?', [$kind, strtolower($subject), $since]);
        } else {
            $res = db_query($link, 'SELECT COUNT(*) AS n FROM rate_limits WHERE kind = ? AND ip = ? AND attempted_at >= ?', [$kind, $ip, $since]);
        }
        return $res ? (int) mysqli_fetch_assoc($res)['n'] : 0;
    } catch (mysqli_sql_exception $e) {
        error_log('MMsGaming: rate limit check skipped: ' . $e->getMessage());
        return 0;
    }
}

function rate_record(mysqli $link, string $kind, string $subject): void
{
    try {
        db_query($link, 'INSERT INTO rate_limits (kind, subject, ip, attempted_at) VALUES (?, ?, ?, ?)',
            [$kind, strtolower($subject), client_ip(), date('Y-m-d H:i:s')]);
        // Keep the table small: forget anything older than a day.
        if (random_int(1, 50) === 1) {
            db_query($link, 'DELETE FROM rate_limits WHERE attempted_at < ?', [date('Y-m-d H:i:s', time() - 86400)]);
        }
    } catch (mysqli_sql_exception $e) {
        error_log('MMsGaming: rate limit record skipped: ' . $e->getMessage());
    }
}

function rate_clear(mysqli $link, string $kind, string $subject): void
{
    try {
        db_query($link, 'DELETE FROM rate_limits WHERE kind = ? AND subject = ?', [$kind, strtolower($subject)]);
    } catch (mysqli_sql_exception $e) {
        error_log('MMsGaming: rate limit clear skipped: ' . $e->getMessage());
    }
}

const LOGIN_WINDOW = 900;          // 15 minutes
const LOGIN_MAX_PER_ACCOUNT = 5;
const LOGIN_MAX_PER_IP = 20;

/** True when logins for this username (or from this IP) are paused. */
function login_blocked(mysqli $link, string $username): bool
{
    return rate_count($link, 'login', $username, null, LOGIN_WINDOW) >= LOGIN_MAX_PER_ACCOUNT
        || rate_count($link, 'login', null, client_ip(), LOGIN_WINDOW) >= LOGIN_MAX_PER_IP;
}
