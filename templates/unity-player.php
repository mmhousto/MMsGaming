<?php
/*
 * The game player for one unity_games row ($game), chosen by play_type.
 * Paths in the row are site-root paths, e.g. /Gravity-Balls/Build.
 */
$w = max(320, (int) $game['width']);
$h = max(240, (int) $game['height']);
$build = rtrim((string) $game['build_path'], '/');
$name = (string) $game['build_name'];
$ext = (string) $game['build_ext'];
$tpl = rtrim((string) $game['template_path'], '/');
?>
<?php if ($game['play_type'] === 'unity') { ?>
<?php if ($tpl !== '') { ?><link rel="stylesheet" href="<?php echo e($tpl); ?>/style.css"><?php } ?>
<div id="unity-container" class="unity-desktop">
  <canvas id="unity-canvas" width="<?php echo $w; ?>" height="<?php echo $h; ?>" tabindex="-1"></canvas>
  <div id="unity-loading-bar">
    <div id="unity-logo"></div>
    <div id="unity-progress-bar-empty"><div id="unity-progress-bar-full"></div></div>
  </div>
  <div id="unity-warning"></div>
  <div id="unity-footer">
    <div id="unity-webgl-logo"></div>
    <div id="unity-fullscreen-button"></div>
    <div id="unity-build-title"><?php echo e($game['title']); ?></div>
  </div>
</div>
<script>
  (function () {
    var buildUrl = <?php echo js($build); ?>;
    var config = {
      dataUrl: buildUrl + "/" + <?php echo js($name . '.data' . $ext); ?>,
      frameworkUrl: buildUrl + "/" + <?php echo js($name . '.framework.js' . $ext); ?>,
      codeUrl: buildUrl + "/" + <?php echo js($name . '.wasm' . $ext); ?>,
      streamingAssetsUrl: <?php echo js((string) ($game['streaming_assets'] ?: 'StreamingAssets')); ?>,
      companyName: "MM's Gaming Community",
      productName: <?php echo js($game['title']); ?>,
      productVersion: "1.0"
    };
    var container = document.querySelector("#unity-container");
    var canvas = document.querySelector("#unity-canvas");
    var loadingBar = document.querySelector("#unity-loading-bar");
    var progressBarFull = document.querySelector("#unity-progress-bar-full");
    var fullscreenButton = document.querySelector("#unity-fullscreen-button");
    var warning = document.querySelector("#unity-warning");
    if (/iPhone|iPad|iPod|Android/i.test(navigator.userAgent)) {
      container.className = "unity-mobile";
      config.devicePixelRatio = 1;
    } else {
      canvas.style.width = "<?php echo $w; ?>px";
      canvas.style.height = "<?php echo $h; ?>px";
    }
    loadingBar.style.display = "block";
    var script = document.createElement("script");
    script.src = buildUrl + "/" + <?php echo js($name . '.loader.js'); ?>;
    script.onload = function () {
      createUnityInstance(canvas, config, function (progress) {
        progressBarFull.style.width = 100 * progress + "%";
      }).then(function (unityInstance) {
        window.gameInstance = unityInstance;
        loadingBar.style.display = "none";
        fullscreenButton.onclick = function () { unityInstance.SetFullscreen(1); };
      }).catch(function (message) {
        warning.textContent = "Sorry, the game could not start: " + message;
        warning.style.display = "block";
      });
    };
    document.body.appendChild(script);
  })();
</script>
<?php } elseif ($game['play_type'] === 'unity2019') { ?>
<?php if ($tpl !== '') { ?><script src="<?php echo e($tpl); ?>/UnityProgress.js"></script><?php } ?>
<script src="<?php echo e($build); ?>/UnityLoader.js"></script>
<div class="webgl-content" style="height: 100%; margin-top: 0px">
  <div id="gameContainer" style="width: <?php echo $w; ?>px; height: <?php echo $h; ?>px"></div>
  <div class="footer">
    <div class="webgl-logo"></div>
    <div class="fullscreen" onclick="gameInstance.SetFullscreen(1)"></div>
    <div class="title"><?php echo e($game['title']); ?></div>
  </div>
</div>
<script>
  var gameInstance = UnityLoader.instantiate("gameContainer", <?php echo js($build . '/' . $name . '.json'); ?><?php echo $tpl !== '' ? ', {onProgress: UnityProgress}' : ''; ?>);
</script>
<?php } elseif ($game['play_type'] === 'embed' && preg_match('#^https://#i', (string) $game['embed_url'])) { ?>
<iframe src="<?php echo e($game['embed_url']); ?>" width="<?php echo $w; ?>" height="<?php echo $h; ?>" style="border: 0; max-width: 100%;" allowfullscreen loading="lazy" title="<?php echo e($game['title']); ?>"></iframe>
<?php } ?>
