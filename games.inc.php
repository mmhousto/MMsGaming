<?php 
require_once "config.php";


function getGames($link) {
    $sql = "SELECT title, img, imgDesc FROM games";
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>
        <a href='".$row['img']."'><picture><source srcset='".$row['img'].".webp' type='image/webp'><source srcset='".$row['img'].".jp2' type='image/jp2'><img src='".$row['img'].".png' style='max-width:100%;height:200px;' alt='".$row['imgDesc']."' title='Play ".$row['title']."'></picture><br>
        <font size='+3'>".$row['title']."</font>
        </a>
        </li>
        <br/>";
        
    }
}

function getMultGames($link) {
    $sql = "SELECT title, img, imgDesc FROM games WHERE genre like '%Multiplayer%'";
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>
        <a href='".$row['img']."'><picture><source srcset='".$row['img'].".webp' type='image/webp'><source srcset='".$row['img'].".jp2' type='image/jp2'><img src='".$row['img'].".png' style='max-width:100%;height:200px;' alt='".$row['imgDesc']."' title='Play ".$row['title']."'></picture><br>
        <font size='+3'>".$row['title']."</font>
        </a>
        </li>
        <br/>";
        
    }
}

function getStratGames($link) {
    $sql = "SELECT title, img, imgDesc FROM games WHERE genre like '%Strategy%'";
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>
        <a href='".$row['img']."'><picture><source srcset='".$row['img'].".webp' type='image/webp'><source srcset='".$row['img'].".jp2' type='image/jp2'><img src='".$row['img'].".png' style='max-width:100%;height:200px;' alt='".$row['imgDesc']."' title='Play ".$row['title']."'></picture><br>
        <font size='+3'>".$row['title']."</font>
        </a>
        </li>
        <br/>";
        
    }
}

function getIOGames($link) {
    $sql = "SELECT title, img, imgDesc FROM games WHERE genre like '%IO%'";
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>
        <a href='".$row['img']."'><picture><source srcset='".$row['img'].".webp' type='image/webp'><source srcset='".$row['img'].".jp2' type='image/jp2'><img src='".$row['img'].".png' style='max-width:100%;height:200px;' alt='".$row['imgDesc']."' title='Play ".$row['title']."'></picture><br>
        <font size='+3'>".$row['title']."</font>
        </a>
        </li>
        <br/>";
        
    }
}

function getFPSGames($link) {
    $sql = "SELECT title, img, imgDesc FROM games WHERE genre like '%FPS%'";
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>
        <a href='".$row['img']."'><picture><source srcset='".$row['img'].".webp' type='image/webp'><source srcset='".$row['img'].".jp2' type='image/jp2'><img src='".$row['img'].".png' style='max-width:100%;height:200px;' alt='".$row['imgDesc']."' title='Play ".$row['title']."'></picture><br>
        <font size='+3'>".$row['title']."</font>
        </a>
        </li>
        <br/>";
        
    }
}

function getCarGames($link) {
    $sql = "SELECT title, img, imgDesc FROM games WHERE genre like '%Car%' AND genre NOT LIKE '%Card%'";
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>
        <a href='".$row['img']."'><picture><source srcset='".$row['img'].".webp' type='image/webp'><source srcset='".$row['img'].".jp2' type='image/jp2'><img src='".$row['img'].".png' style='max-width:100%;height:200px;' alt='".$row['imgDesc']."' title='Play ".$row['title']."'></picture><br>
        <font size='+3'>".$row['title']."</font>
        </a>
        </li>
        <br/>";
        
    }
}

function getCardGames($link) {
    $sql = "SELECT title, img, imgDesc FROM games WHERE genre like '%Card%'";
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<li>
        <a href='".$row['img']."'><picture><source srcset='".$row['img'].".webp' type='image/webp'><source srcset='".$row['img'].".jp2' type='image/jp2'><img src='".$row['img'].".png' style='max-width:100%;height:200px;' alt='".$row['imgDesc']."' title='Play ".$row['title']."'></picture><br>
        <font size='+3'>".$row['title']."</font>
        </a>
        </li>
        <br/>";
        
    }
}

function getSelectedGame($link, $gid) {
    $sql = "SELECT * FROM games WHERE gid = ?";
    $result = db_query($link, $sql, [$gid]);
    while ($row = mysqli_fetch_assoc($result)) {
        echo $row['SRC']."</div>
        <br/>
        <!-- LikeBtn.com BEGIN -->
        <span class='likebtn-wrapper' data-theme='drop' data-ef_voting='wobble'></span>
        <!-- LikeBtn.com END -->
        <br>
        <div class='desc-box'>;
          <h1><strong>Play ".$row['title']." with Friends</strong></h1>
          <p style='text-align: left;'>".$row['Description']."</p>
          <h2><strong>How to play ".$row['title']."</strong></h2>
          <p style='text-align: left;''>".$row['HowToPlay']."</p>
          <h2><strong>".$row['title']." Controls</strong></h2>
          ".$row['Controls']."
          <h3><strong>".$row['title']." Tips</strong></h3>
          <p>".$row['Tips']."</p>
        </div>";
      }
}




?>