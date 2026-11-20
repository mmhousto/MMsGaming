<?php
/*
 * sitemap.xml, generated from the site itself (.htaccess serves it at
 * /sitemap.xml): the main pages, every published game in unity_games, the
 * third-party game pages, blog posts and policy pages. Account and utility
 * pages are left out (they're marked noindex).
 */
require_once __DIR__ . '/config.php';

$urls = [];
function sitemap_add(array &$urls, string $path, string $file, string $priority): void
{
    if (is_file($file)) {
        // No <lastmod>: every deploy rewrites the files, so their dates aren't real edit dates.
        $urls[$path] = $priority;
    }
}

// Main pages
sitemap_add($urls, '/', __DIR__ . '/index.php', '1.0');
sitemap_add($urls, '/Unity-Games.php', __DIR__ . '/Unity-Games.php', '0.9');
foreach (['Free-Games.php', 'IO-Games.php', 'Multiplayer-Games.php', 'FPS-Games.php', 'Car-Games.php', 'Card-Games.php', 'Strategy-Games.php'] as $page) {
    sitemap_add($urls, '/' . $page, __DIR__ . '/' . $page, '0.7');
}
foreach (['Store.php', 'Scoreboard.php', 'about.php'] as $page) {
    sitemap_add($urls, '/' . $page, __DIR__ . '/' . $page, '0.5');
}

// Our games (from the unity_games table) come first after the main pages.
$ours = [];
foreach (unity_games_published($link) as $game) {
    $dir = __DIR__ . '/' . $game['slug'];
    sitemap_add($urls, '/' . rawurlencode($game['slug']) . '/', $dir . '/index.php', '0.9');
    $ours[$game['slug']] = true;
}

// Third-party game pages: every top-level folder with an index.php that isn't ours.
foreach (glob(__DIR__ . '/*/index.php') as $index) {
    $slug = basename(dirname($index));
    if (isset($ours[$slug]) || in_array($slug, ['blog', 'lib', 'templates', 'tests', 'db', 'docs', 'css', 'social'], true)) {
        continue;
    }
    // Hidden games of ours have a row with published = 0 and a game.php page: leave them out.
    if (strpos((string) file_get_contents($index), "game.php") !== false) {
        continue;
    }
    sitemap_add($urls, '/' . rawurlencode($slug) . '/', $index, '0.6');
}

// Blog
sitemap_add($urls, '/blog/', __DIR__ . '/blog/index.php', '0.7');
foreach (glob(__DIR__ . '/blog/*.php') as $post) {
    if (basename($post) !== 'index.php') {
        sitemap_add($urls, '/blog/' . rawurlencode(basename($post)), $post, '0.6');
    }
}

// Contact and policy pages
foreach (array_merge(['contactform.html', 'terms.html', 'privacyPolicy.html'], array_map('basename', glob(__DIR__ . '/*PrivacyPolicy.html'))) as $page) {
    sitemap_add($urls, '/' . $page, __DIR__ . '/' . $page, '0.3');
}

header('Content-Type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
foreach ($urls as $path => $priority) {
    echo '  <url><loc>' . htmlspecialchars(SITE_URL . $path, ENT_XML1) . '</loc><priority>' . $priority . "</priority></url>\n";
}
echo "</urlset>\n";
