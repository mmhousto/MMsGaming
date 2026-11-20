<?php
/*
 * Search and social-sharing tags, added to every PHP page automatically by
 * the same output filter that adds the form tokens (see csrf_protect()).
 *
 *  - Open Graph / Twitter card tags from the page's own <title> and meta
 *    description (pages that set their own og:title are left alone).
 *  - noindex on account and utility pages, so search results show games
 *    and articles, not login forms.
 */

const SITE_NAME = "MM's Gaming Community";
const SITE_URL = 'https://mms-gaming.com';
const SITE_DEFAULT_IMAGE = '/MMsGCoo.png';

/** Pages search engines shouldn't list (they still follow their links). */
const SEO_NOINDEX_PAGES = [
    'login.php', 'register.php', 'forgot-password.php', 'create-new-password.php',
    'reset-password.php', 'verify-email.php', 'resend-verification.php', 'profile.php',
    'editComment.php', 'editReply.php', 'editSReply.php', 'replyComment.php', 'replyReply.php',
    'thankYou.php', 'logout.php', 'freecontactforminstall.php',
];

/** The page's address without query string, e.g. "/HGWK/" or "/Store.php". */
function seo_request_path(): string
{
    $path = (string) parse_url((string) ($_SERVER['REQUEST_URI'] ?? '/'), PHP_URL_PATH);
    return $path === '' ? '/' : $path;
}

function seo_is_noindex_page(): bool
{
    return in_array(basename((string) ($_SERVER['SCRIPT_NAME'] ?? '')), SEO_NOINDEX_PAGES, true);
}

/** Output filter: add social tags (and noindex where needed) to the page's <head>. */
function seo_enrich_head(string $html): string
{
    if (stripos($html, '</head>') === false || stripos($html, '<html') === false) {
        return $html;
    }
    $add = [];

    if (seo_is_noindex_page() && stripos($html, 'name="robots"') === false) {
        $add[] = '<meta name="robots" content="noindex, follow">';
    }

    if (stripos($html, 'property="og:title"') === false) {
        $title = preg_match('/<title>(.*?)<\/title>/is', $html, $m) ? trim(html_entity_decode(strip_tags($m[1]), ENT_QUOTES, 'UTF-8')) : SITE_NAME;
        $desc = preg_match('/<meta\s+name="description"\s+content="([^"]*)"/i', $html, $m) ? html_entity_decode($m[1], ENT_QUOTES, 'UTF-8') : '';
        $url = preg_match('/<link\s+rel="canonical"\s+href="([^"]*)"/i', $html, $m) ? html_entity_decode($m[1], ENT_QUOTES, 'UTF-8') : SITE_URL . seo_request_path();
        $add[] = '<meta property="og:site_name" content="' . e(SITE_NAME) . '">';
        $add[] = '<meta property="og:type" content="website">';
        $add[] = '<meta property="og:title" content="' . e($title) . '">';
        if ($desc !== '') {
            $add[] = '<meta property="og:description" content="' . e($desc) . '">';
        }
        $add[] = '<meta property="og:url" content="' . e($url) . '">';
        $add[] = '<meta property="og:image" content="' . e(SITE_URL . SITE_DEFAULT_IMAGE) . '">';
        $add[] = '<meta name="twitter:card" content="summary">';
    }

    if (!$add) {
        return $html;
    }
    return preg_replace('/<\/head>/i', "    " . implode("\n    ", $add) . "\n  </head>", $html, 1);
}

/** A JSON-LD <script> block for structured data. */
function seo_json_ld(array $data): string
{
    return '<script type="application/ld+json">'
        . json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP)
        . '</script>';
}

/** Structured data for one of our games (game.php). */
function seo_game_json_ld(array $game, string $canonical, array $storeLinks): string
{
    $platforms = [];
    if (in_array($game['play_type'], ['unity', 'unity2019', 'embed', 'launch'], true)) {
        $platforms[] = 'Web browser';
    }
    $labels = ['Steam' => 'PC (Steam)', 'Xbox' => 'Xbox', 'itch.io' => 'PC (itch.io)', 'App Store' => 'iOS', 'Google Play' => 'Android'];
    foreach (array_keys($storeLinks) as $label) {
        $platforms[] = $labels[$label] ?? $label;
    }
    $data = [
        '@context' => 'https://schema.org',
        '@type' => 'VideoGame',
        'name' => $game['title'],
        'url' => $canonical,
        'description' => trim((string) ($game['meta_description'] ?: $game['tagline'])),
        'author' => ['@type' => 'Organization', 'name' => SITE_NAME, 'url' => SITE_URL . '/'],
        'publisher' => ['@type' => 'Organization', 'name' => SITE_NAME, 'url' => SITE_URL . '/'],
        'gamePlatform' => array_values(array_unique($platforms)),
        'applicationCategory' => 'Game',
    ];
    if ($game['thumbnail'] !== '') {
        $data['image'] = SITE_URL . $game['thumbnail'];
    }
    if ($storeLinks) {
        $data['sameAs'] = array_values($storeLinks);
    }
    if (in_array('Web browser', $platforms, true)) {
        $data['offers'] = ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'USD', 'url' => $canonical];
    }
    return seo_json_ld($data);
}
