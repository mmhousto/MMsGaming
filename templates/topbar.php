<?php
/*
 * Top bar shared by every page: player name, rank, points, progress to the
 * next rank, sign-in buttons and the logo.
 * Uses the page's $isDonor, $username, $rank, $points, $totalPoints, $total.
 */
$mmsgProgress = progress_for($totalPoints ?? 0, $total ?? 100);
?>
<div id="heading1" class="heading1">
        <div id="info" class="info">
        <h3><b><?php if (!empty($isDonor)) { echo "Donor"; } else { echo "Gamer"; } ?>:</b> <span id="Gamer"><a href="/profile.php"><?php echo e($username ?? ''); ?></a></span></h3>
        <h4><b>Rank:</b> <span id="Rank"><?php echo e($rank ?? ''); ?></span></h4>
        <h4><b>Points:</b> <span id="points" class="pointCount"><?php echo (int) ($points ?? 0); ?></span></h4>
        <div class="Progress"><b>Next Rank:</b> <div id="pntCount" class="pointCount"><?php echo $mmsgProgress['count']; ?>
        </div>/<div id="total" class="total"><?php echo $mmsgProgress['goal']; ?></div>
          <div class="meter">
            <span id="myBar" style="width: <?php echo $mmsgProgress['percent']; ?>%"></span>
          </div>
        </div>
        </div>
    <div id="rightHd">
        <div class="ctrlBtns" align="right">
            <p style="width: 100%;" align="right">
            <?php if (!is_logged_in()) { ?>
                <a href="/register.php" class="btn btn-success" style="width: 125px;">Sign Up!</a>&nbsp;<a href="/login.php" class="btn btn-warning" style="width: 125px;">Login!</a>
            <?php } else { ?>
                <a href="/reset-password.php" class="btn btn-warning">Reset Your Password</a>&nbsp;<a href="/logout.php" class="btn btn-danger">Sign Out</a>
            <?php } ?>
            </p>
        </div>
        <div id="logo" class="logo" align="center">
         <picture>
            <source srcset="/MMsGCoo.webp" type="image/webp">
            <source srcset="/MMsGCoo.jp2" type="image/jp2">
            <a href="/index.php"><img src="/MMsGCoo.png" alt="The logo of MMs Gaming company, free online games, meant to look like a controller and the letters 'MM'" title="MMs Gaming Logo" style="max-width:100%;max-height:300px;" vspace="0"></a>
         </picture>
        </div>
    </div>
</div>
