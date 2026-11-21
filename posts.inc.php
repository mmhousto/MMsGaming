<?php 
require_once "config.php";


function getPosts($link) {
    // Newest first; posts from the same day by the order they were added.
    $sql = "SELECT * FROM posts ORDER BY posted DESC, aid DESC";
    $result = mysqli_query($link, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='card'>
      <h2>".$row['title']."</h2>
      <h5>".$row['summary']."</h5><p style='color: #969696'>".$row['posted']."</p>
      <img src='".$row['image']."' style='max-width:100%;height:auto;' alt='".$row['alt']."'>
      <p><a class='read-Btn' href='".e($row['href'])."'>Read more &raquo;</a></p>
      </div>";
        
    }
}


/*
 * The article for the blog post page being viewed, found by the page's own
 * file name (posts.href is e.g. "Best-Io-Games.php" or a full address).
 * Older "Read more" buttons posted the article id instead; still accepted.
 */
function getArticle($link) {
    if (isset($_POST['readSubmit'], $_POST['aid'])) {
        $result = db_query($link, 'SELECT * FROM posts WHERE aid = ?', [(int) $_POST['aid']]);
    } else {
        $page = basename((string) ($_SERVER['SCRIPT_NAME'] ?? ''));
        $result = db_query($link, 'SELECT * FROM posts WHERE href = ? OR href LIKE ? LIMIT 1', [$page, '%/' . $page]);
    }
    if (!$result) {
        return;
    }
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='card'>
      <h1>".$row['title']."</h1>
      <p>Author: ".$row['author']."</p>
      <p>Posted: ".$row['posted']."</p>
      <h4>".$row['summary']."</h4>
      <img src='".$row['image']."' style='max-width:100%;height:auto;' alt='".e($row['title'])."'><br><br>
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
       display: inline-block;
       text-decoration: none;
       }
.read-Btn:hover, .read-Btn:focus { color: white; text-decoration: none; }
       
.read-Btn:hover {
    opacity: 1.0;
}
</style>