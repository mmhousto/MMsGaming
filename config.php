<?php
/*
 * Config loader. This file holds NO secrets and is safe to commit.
 *
 * The real credentials live in MMsGamingconfig.php, which must NOT be
 * inside the website folder (public_html) or the git repository.
 * Upload it to the folder ABOVE public_html on the server, e.g.:
 *
 *   /home/<account>/domains/mms-gaming.com/MMsGamingconfig.php   <- secrets
 *   /home/<account>/domains/mms-gaming.com/public_html/          <- this site
 *
 * The account home folder (/home/<account>/MMsGamingconfig.php) also works.
 *
 * Or set the MMSG_CONFIG environment variable to its full path.
 *
 * MMsGamingconfig.php must define DB_SERVER, DB_USERNAME, DB_PASSWORD and
 * DB_NAME (it may also open $link itself, like the old config.php did).
 */

$mmsgConfigCandidates = array_filter([
    getenv('MMSG_CONFIG') ?: null,
    dirname(__DIR__) . '/MMsGamingconfig.php',
    dirname(__DIR__, 2) . '/MMsGamingconfig.php',
    dirname(__DIR__, 3) . '/MMsGamingconfig.php', // account home, e.g. /home/<account>/
]);

$mmsgConfigFile = null;
foreach ($mmsgConfigCandidates as $candidate) {
    if (is_readable($candidate)) {
        $mmsgConfigFile = $candidate;
        break;
    }
}

if ($mmsgConfigFile === null) {
    error_log('MMsGaming: MMsGamingconfig.php not found. Looked in: ' . implode(', ', $mmsgConfigCandidates));
    http_response_code(500);
    exit('Site configuration error. Please try again later.');
}

require_once $mmsgConfigFile;

if (!isset($link) || !($link instanceof mysqli)) {
    try {
        $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    } catch (mysqli_sql_exception $e) {
        $link = false;
    }
    if ($link === false) {
        // Log the details privately; never show them to visitors.
        error_log('MMsGaming: database connection failed: ' . mysqli_connect_error());
        http_response_code(500);
        exit('Could not connect to the database. Please try again later.');
    }
}
mysqli_set_charset($link, 'utf8mb4');

require_once __DIR__ . '/lib/security.php';
require_once __DIR__ . '/lib/points.php';
require_once __DIR__ . '/lib/player.php';
require_once __DIR__ . '/lib/accounts.php';
require_once __DIR__ . '/lib/verify.php';
require_once __DIR__ . '/lib/unity-games.php';
csrf_protect();
