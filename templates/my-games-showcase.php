<?php
/*
 * "Play Our Games" showcase: a card for every published game in the
 * unity_games table, in sort order. New rows appear automatically.
 * Optional before including: $showcaseCompact = true for a smaller strip
 * (used on the Games page), $showcaseTitle to change the heading.
 */
$showcaseCompact = $showcaseCompact ?? false;
$showcaseTitle = $showcaseTitle ?? 'PLAY OUR GAMES';
$mmsgShowcase = unity_games_published($link);
if ($mmsgShowcase) {
?>
<link rel="stylesheet" href="/css/showcase.css">
<section class="showcase<?php echo $showcaseCompact ? ' showcase-compact' : ''; ?>" id="our-games" aria-label="Our games">
  <h2 class="showcase-title"><strong><?php echo e($showcaseTitle); ?></strong></h2>
<?php if (!$showcaseCompact) { ?>
  <p class="showcase-intro">Made and published by MM's Gaming Community. Play in your browser or get them on Steam, Xbox and mobile.</p>
<?php } ?>
  <div class="showcase-grid">
<?php foreach ($mmsgShowcase as $g) {
    $mmsgPlayable = in_array($g['play_type'], ['unity', 'unity2019', 'embed', 'launch'], true);
    $mmsgHref = '/' . rawurlencode($g['slug']) . '/';
?>
    <a class="showcase-card" href="<?php echo e($mmsgHref); ?>">
      <?php if ($g['thumbnail'] !== '') { ?>
      <img class="showcase-thumb" src="<?php echo e($g['thumbnail']); ?>" alt="<?php echo e($g['title']); ?>" loading="lazy">
      <?php } else { ?>
      <span class="showcase-thumb showcase-thumb-text"><?php echo e($g['title']); ?></span>
      <?php } ?>
      <span class="showcase-name"><?php echo e($g['title']); ?></span>
      <?php if (!$showcaseCompact && $g['tagline'] !== '') { ?>
      <span class="showcase-tagline"><?php echo e($g['tagline']); ?></span>
      <?php } ?>
      <span class="showcase-button"><?php echo $mmsgPlayable ? 'Play' : 'Get it'; ?></span>
    </a>
<?php } ?>
  </div>
  <p class="showcase-more"><a href="/Unity-Games.php">See all our games &raquo;</a></p>
</section>
<?php } ?>
