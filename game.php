<?php
/*
 * One page for every game in the unity_games table.
 * Each game's folder keeps its address: /HGWK/index.php just sets
 * $gameSlug = 'HGWK' and includes this file. /game.php?slug=HGWK also works.
 */
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . '/config.php';

$gameSlug = $gameSlug ?? (string) ($_GET['slug'] ?? '');
$game = unity_game($link, $gameSlug);
if ($game === null) {
    http_response_code(404);
    echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><title>Game not found</title></head>'
        . '<body style="font-family: Arial; background-color: #38b6ff; text-align: center; padding: 60px 16px;">'
        . '<h1>Game not found</h1><p><a href="/Unity-Games.php">See all my games</a></p></body></html>';
    exit;
}

$loggedIn = is_logged_in();
$username = $_SESSION['username'] ?? null;
$id = $_SESSION['id'] ?? null;
$isDonor = player_custom($link, $id)['Donor'];
$mmsgStats = player_stats($link, $username);
$points = $mmsgStats['points'];
$totalPoints = $mmsgStats['totalPoints'];
$rank = $mmsgStats['rank'];
$total = $mmsgStats['total'];

$playable = $game['play_type'] !== 'store';
$storeLinks = unity_game_store_links($game);
$pageTitle = 'Play ' . $game['title'] . " for Free | MM's Gaming Community";
$canonical = 'https://mms-gaming.com/' . rawurlencode($game['slug']) . '/';
?>
<!DOCTYPE html>
<html lang="en-us">
  <head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-162871090-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-162871090-1');
</script>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e($pageTitle); ?></title>
    <meta name="description" content="<?php echo e($game['meta_description'] ?: $game['tagline']); ?>">
    <link rel="canonical" href="<?php echo e($canonical); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="stylesheet" type="text/css" href="/footer.css">
    <link rel="stylesheet" href="/basic.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="/css/game-page.css">
    <style type="text/css">
      /* This player's own look (cursor, font, trail colour). */
      body {
        cursor: <?php include __DIR__ . '/loadCursor.php'; ?>;
        font-family: <?php include __DIR__ . '/loadFont.php'; ?>;
      }
      .pointer {
        background: <?php include __DIR__ . '/loadTrail.php'; ?>;
        border: 1px solid <?php include __DIR__ . '/loadTrail.php'; ?>;
      }
<?php if (!$loggedIn) { ?>
      .info { display: none; } .logo { min-width: 60%; width: 60%; align-items: right; text-align: right; }
      #rightHd { width: 100%; } .ctrlBtns { width: 40%; }
<?php } ?>
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="/mouse.js" type="text/javascript"></script>
    <script data-ad-client="ca-pub-8251399081266327" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
  </head>
<?php if ($loggedIn) { ?>
<body onload="playing()" style="background-color: <?php include __DIR__ . '/loadBg.php'; ?>">
<?php } else { ?>
<body>
<?php } ?>
<div id="page-container">
   <div id="content-wrap">

  <div id="trail" class="trail">
    <div class="pointer pointer1"></div>
    <div class="pointer pointer2"></div>
    <div class="pointer pointer3"></div>
    <div class="pointer pointer4"></div>
    <div class="pointer pointer5"></div>
  </div>

<?php include __DIR__ . '/templates/topbar.php'; ?>

<?php $menuExtra = 'bookmark'; include __DIR__ . '/templates/menu.php'; ?>
<br><br>
<center>
<br>
<?php if ($playable) { ?>
    <p style="color:black; margin: -30px 10px 10px;"><font size="+2">GAME ON!</font></p>
<?php } ?>

<?php if ($game['thumbnail'] !== '' || $storeLinks) { ?>
<div class="paddle-box" id="store-links">
<?php if ($game['thumbnail'] !== '') { ?>
    <img alt="<?php echo e($game['title']); ?>" src="<?php echo e($game['thumbnail']); ?>" width="120"><br>
<?php } ?>
    <h2><strong><u><?php echo e($game['title']); ?></u></strong></h2>
<?php if ($game['tagline'] !== '') { ?>
    <h3><?php echo e($game['tagline']); ?></h3>
<?php } ?>
<?php foreach ($storeLinks as $label => $url) { ?>
<?php if ($label === 'App Store') { ?>
    <a class="store-badge" href="<?php echo e($url); ?>" target="_blank" rel="noopener"><img alt="Download on the App Store" src="/appStore.svg" width="225"></a>
<?php } elseif ($label === 'Google Play') { ?>
    <a class="store-badge" href="<?php echo e($url); ?>" target="_blank" rel="noopener"><img alt="Get it on Google Play" src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png" width="250"></a>
<?php } else { ?>
    <a class="button store-badge" href="<?php echo e($url); ?>" target="_blank" rel="noopener"><?php echo e($label); ?></a>
<?php } ?>
<?php } ?>
</div>
<?php } ?>

<?php if ($playable) {
    // The game box: Unity's modern template fills the page width, so its box
    // is 90% wide (as the old Paddle Balls page); the 2019 player is fixed size.
    $gameBoxStyle = $game['play_type'] === 'unity2019'
        ? 'width: ' . ((int) $game['width'] + 65) . 'px; max-width: 98%; height: ' . ((int) $game['height'] + 100) . 'px;'
        : 'width: 90%; height: ' . ((int) $game['height'] + 70) . 'px;';
} ?>
<?php if ($playable && $loggedIn) { ?>
<div id="game" style="<?php echo $gameBoxStyle; ?>" onmouseleave="stopAdding(); notPlaying();" onmouseenter="startAdding(); playing();">
<?php } elseif ($playable) { ?>
<div id="game" style="<?php echo $gameBoxStyle; ?>">
<?php } ?>
<?php if ($playable) { include __DIR__ . '/templates/unity-player.php'; ?>
</div>
<?php } ?>

<br>
<!-- LikeBtn.com BEGIN -->
<span class="likebtn-wrapper" data-theme="drop" data-ef_voting="wobble"></span>
<script>(function(d,e,s){if(d.getElementById("likebtn_wjs"))return;a=d.createElement(e);m=d.getElementsByTagName(e)[0];a.async=1;a.id="likebtn_wjs";a.src=s;m.parentNode.insertBefore(a, m)})(document,"script","//w.likebtn.com/js/w/widget.js");</script>
<!-- LikeBtn.com END -->
<br>
<div class="desc-box" id="game-description">
    <h1><strong><?php echo $playable ? 'Play ' . e($game['title']) . ' for Free' : e($game['title']); ?></strong></h1>
    <?php echo unity_game_paragraphs($game['description']); ?>
<?php if (trim((string) $game['how_to_play']) !== '') { ?>
    <h2><strong>How to play <?php echo e($game['title']); ?></strong></h2>
    <?php echo unity_game_paragraphs($game['how_to_play']); ?>
<?php } ?>
<?php if ($controls = unity_game_controls($game)) { ?>
    <h2><strong><?php echo e($game['title']); ?> Controls</strong></h2>
    <ul class="col-lg-12" style="column-count: 1; text-align: left; font-size: 18px;">
<?php foreach ($controls as [$keys, $action]) { ?>
        <li><?php foreach ($keys as $k) { echo '<kbd>' . e($k) . '</kbd>&nbsp;'; } ?><?php echo e($action); ?></li>
<?php } ?>
    </ul>
<?php } ?>
<?php if (trim((string) $game['tips']) !== '') { ?>
    <h3><strong><?php echo e($game['title']); ?> Tips</strong></h3>
    <?php echo unity_game_paragraphs($game['tips']); ?>
<?php } ?>
<?php if (trim((string) $game['privacy_url']) !== '') { ?>
    <p style="text-align: left;"><a href="<?php echo e($game['privacy_url']); ?>"><?php echo e($game['title']); ?> privacy policy</a></p>
<?php } ?>
</div>
<br>
<!-- square -->
<ins class="adsbygoogle"
     style="display:block; width: 90%;"
     data-ad-client="ca-pub-8251399081266327"
     data-ad-slot="9538800012"
     data-ad-format="auto"
     data-full-width-responsive="true"></ins>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({});
</script>
<br>
<div class="desc-box" align="center" style="text-align: center;">
    <h4 style="text-align: center;"><font size="+3"><strong>More Games</strong></font></h4>
    <a class="button" href="/Unity-Games.php">My Games</a>
    <a class="button" href="/IO-Games.php">IO Gaming</a>
    <a class="button" href="/Strategy-Games.php">Strategy Gaming</a>
    <a class="button" href="/Multiplayer-Games.php">Multiplayer Gaming Online</a>
    <a class="button" href="/FPS-Games.php">FPS Gaming</a>
    <a class="button" href="/Car-Games.php">Car Racing Gaming</a>
    <a class="button" href="/Card-Games.php">Card Gaming</a>
</div>
<br><br><br>
</center>
</div>
<?php $footerClass = $game['play_type'] === 'unity2019' ? 'footer2' : 'footer'; include __DIR__ . '/templates/footer.php'; ?>
</div>

<?php if ($playable && $loggedIn) { ?>
<script type="text/javascript">
  // Points: while the mouse is over the game, ask the server for points every
  // 30 seconds (the server decides whether to award them).
  var gamer = document.getElementById("Gamer");
  var rankEl = document.getElementById("Rank");
  var total = document.getElementById("total");
  var pnts = document.getElementById("pntCount");
  var pointsEl = document.getElementById("points");
  var perc = document.getElementById("myBar");

  function addPoints() {
    $("#pntCount").load("/addPoints.php");
    $("#Rank").load("/rank.php");
    $("#points").load("/points.php");
    $("#total").load("/total.php");
    $.get("/Bar.php", function (width) { perc.style.width = width; });
  }

  var isPlaying;
  var idleTime = 0;
  var idle;
  function playing() { clearInterval(idle); idleTime = 0; isPlaying = true; }
  function notPlaying() { idle = setInterval(timerIncrement, 60000); isPlaying = false; }
  function timerIncrement() {
    idleTime = idleTime + 1;
    if (idleTime > 1) { isPlaying = false; idleTime = 0; }
  }

  var id;
  function startAdding() { clearInterval(id); id = setInterval(addPoints, 30000); }
  function stopAdding() { clearInterval(id); }
</script>
<?php } ?>
</body>
</html>
