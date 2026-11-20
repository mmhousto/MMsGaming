<?php
/*
 * Main menu shared by every page.
 * Optional settings before including:
 *   $menuActive       which tab is highlighted: home, games, mygames, store,
 *                     scoreboard, blog or about (default: none)
 *   $menuActiveOnclick  JavaScript for the highlighted tab instead of a link,
 *                     e.g. "openPage('Store', this, 'white')"
 *   $menuActiveId     id attribute for the highlighted tab
 *   $menuExtra        'share' (Facebook share button, default) or 'bookmark'
 *   $shareUrl         address the Share button shares (default the home page)
 *   $menuIconClass    class of the small-screen menu icon (default "icon")
 */
$menuActive = $menuActive ?? null;
$menuExtra = $menuExtra ?? 'share';
$shareUrl = $shareUrl ?? 'https://mms-gaming.com';
$menuIconClass = $menuIconClass ?? 'icon';

$mmsgTabs = [
    'home' => ['/index.php', 'Home'],
    'games' => ['/Free-Games.php', 'Games'],
    'mygames' => ['/Unity-Games.php', 'My Games'],
    'store' => ['/Store.php', 'Store'],
    'scoreboard' => ['/Scoreboard.php', 'Scoreboard'],
    'blog' => ['/blog/', 'Blog'],
    'about' => ['/about.php', 'About'],
];
?>
<header class="topnav" id="myTopnav">
<?php foreach ($mmsgTabs as $mmsgKey => [$mmsgHref, $mmsgLabel]) {
    $mmsgAttrs = 'class="tablink"';
    if ($mmsgKey === $menuActive && !empty($menuActiveOnclick)) {
        $mmsgAttrs .= ' onclick="' . e($menuActiveOnclick) . '"';
    } else {
        $mmsgAttrs .= ' href="' . $mmsgHref . '"';
    }
    if ($mmsgKey === $menuActive) {
        if (!empty($menuActiveId)) {
            $mmsgAttrs .= ' id="' . e($menuActiveId) . '"';
        }
        $mmsgAttrs .= ' style="color: black; background-color: white;"';
    }
    echo "        <a $mmsgAttrs>$mmsgLabel</a>\n";
} ?>
<?php if ($menuExtra === 'bookmark') { ?>
        <a id="bookmark-this" href="#" title="Bookmark This Game">Bookmark Game</a>
<?php } else { ?>
        <div class="fb-share-button" data-href="<?php echo e($shareUrl); ?>" data-layout="button_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fmms-gaming.com%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>
<?php } ?>
        <a href="javascript:void(0);" class="<?php echo e($menuIconClass); ?>" onclick="myFunction()">
            <i class="fa fa-bars"></i>
        </a>
    </header>
