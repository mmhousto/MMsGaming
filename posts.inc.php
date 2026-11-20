<?php 
require_once "config.php";


function getPosts($link) {
    $sql = "SELECT * FROM posts";
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='card'>
      <h2>".$row['title']."</h2>
      <h5>".$row['summary']."</h5><p style='color: #969696'>".$row['posted']."</p>
      <img src='".$row['image']."' style='max-width:100%;height:auto;' alt='".$row['alt']."'>
      <form method='POST' action='".$row['href']."'>
            <input type='hidden' name='aid' value='".$row['aid']."'>
            <button class='read-Btn' type='submit' name='readSubmit'>Read more &raquo;</button>
      </form>
      </div>";
        
    }
}


function getArticle($link) {
    if (isset($_POST['readSubmit'])) {
    $aid = $_POST['aid'];
    }
    $sql = "SELECT * FROM posts WHERE aid = ?";
    $result = db_query($link, $sql, [$aid]);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='card'>
      <h1>".$row['title']."</h1>
      <p>Author: ".$row['author']."</p>
      <p>Posted: ".$row['posted']."</p>
      <h4>".$row['summary']."</h4>
      <img src='".$row['image']."' style='max-width:100%;height:auto;' alt='Slither.io is an epic, free online 2D survival, IO game, multiplayer game you can play with friends, on MM's Gaming Co.' title='Play Slither.io'><br><br>
      <div class='aContent'>".$row['content']."</div>
    </div>";
        
    }
}



?>
<style>

.img {
    
}

.aContent {
    font-size: 24px;
}

.read-Btn {
       width: auto;
       height: 40px;
       font-size: 14px;
       font-weight: 400;
       border-radius: 25px;
       padding: 10px;
       margin-top: 5px;
       background-color: #333;
       opacity: 0.8;
       color: white;
       border: none;
       }
       
.read-Btn:hover {
    opacity: 1.0;
}
</style>