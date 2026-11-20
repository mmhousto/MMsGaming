<?php
/*
 * The games you make and publish (the unity_games table).
 * Third-party games stay in the `games` table.
 *
 * play_type says how a game is played on the site:
 *   unity      a modern Unity WebGL build (createUnityInstance / *.loader.js)
 *   unity2019  the old Unity 2019 player (UnityLoader.js + *.json)
 *   embed      a build hosted elsewhere, shown in a frame (embed_url)
 *   store      no web version: just the store links
 */

const UNITY_PLAY_TYPES = ['unity', 'unity2019', 'embed', 'store'];

/** One published game by its slug (its folder name, e.g. "HGWK"), or null. */
function unity_game(mysqli $link, string $slug): ?array
{
    if (!preg_match('/^[A-Za-z0-9_-]{1,50}$/', $slug)) {
        return null;
    }
    try {
        $res = db_query($link, 'SELECT * FROM unity_games WHERE slug = ? AND published = 1', [$slug]);
    } catch (mysqli_sql_exception $e) {
        error_log('MMsGaming: unity_games not available: ' . $e->getMessage());
        return null;
    }
    $row = $res ? mysqli_fetch_assoc($res) : null;
    if (!$row || !in_array($row['play_type'], UNITY_PLAY_TYPES, true)) {
        return null;
    }
    return $row;
}

/** All published games, in display order. */
function unity_games_published(mysqli $link): array
{
    try {
        $res = db_query($link, 'SELECT * FROM unity_games WHERE published = 1 ORDER BY sort_order, title');
    } catch (mysqli_sql_exception $e) {
        error_log('MMsGaming: unity_games not available: ' . $e->getMessage());
        return [];
    }
    $games = [];
    while ($res && ($row = mysqli_fetch_assoc($res))) {
        $games[] = $row;
    }
    return $games;
}

/** Store links that are filled in, as [label => url]. */
function unity_game_store_links(array $game): array
{
    $labels = [
        'steam_url' => 'Steam',
        'xbox_url' => 'Xbox',
        'itch_url' => 'itch.io',
        'app_store_url' => 'App Store',
        'play_store_url' => 'Google Play',
    ];
    $links = [];
    foreach ($labels as $column => $label) {
        $url = trim((string) ($game[$column] ?? ''));
        if ($url !== '' && preg_match('#^https://#i', $url)) {
            $links[$label] = $url;
        }
    }
    return $links;
}

/** Controls text ("KEY | action" per line) as [[keys, action], ...]. */
function unity_game_controls(array $game): array
{
    $controls = [];
    foreach (preg_split('/\r?\n|\\\\n/', (string) ($game['controls'] ?? '')) as $line) {
        if (trim($line) === '') {
            continue;
        }
        [$keys, $action] = array_pad(array_map('trim', explode('|', $line, 2)), 2, '');
        $controls[] = [preg_split('/\s+/', $keys), $action];
    }
    return $controls;
}

/** Plain text with blank-line paragraphs, escaped, as <p> tags. */
function unity_game_paragraphs(?string $text): string
{
    $html = '';
    foreach (preg_split('/\n\s*\n/', trim((string) $text)) as $para) {
        if (trim($para) !== '') {
            $html .= '<p style="text-align: left;">' . nl2br(e(trim($para))) . "</p>\n";
        }
    }
    return $html;
}
