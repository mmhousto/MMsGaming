<?php 
// Initialize the session
session_start();   
require_once "../config.php";

date_default_timezone_set('America/Chicago');
$total = "";
$secure = "1";
$username = $_SESSION['username'];
$rank = $_SESSION['rank'];
$ownTrail = $_SESSION['ownTrail'];
$ownBg = $_SESSION['ownBg'];
$ownImg = $_SESSION['ownImg'];
$ownFont = $_SESSION['ownFont'];
$bgColor = $_SESSION['BgColor'];
$bgImg = $_SESSION['BgImg'];
$TrailC = $_SESSION['Trail'];
$CursorC = $_SESSION['CursorC'];
$font = $_SESSION['Font'];
$isDonor = $_SESSION['Donor'];
$id = $_SESSION['id'];

if (isset($_GET['box'])) {
  $TrailC = $_GET['box'];
} 
if (isset($_POST['box2'])) {
  $bgColor = $_GET['box2'];
}
if (isset($_GET['image'])){
    $bgImg = $_GET['image'];
}

$isDonor = player_custom($link, $id ?? null)['Donor'];

$ownTrail = player_custom($link, $id ?? null)['ownTrail'];

$ownImg = player_custom($link, $id ?? null)['ownImg'];

$ownBg = player_custom($link, $id ?? null)['ownBg'];

$ownCursor = player_custom($link, $id ?? null)['ownCursor'];

$bgColor = player_custom($link, $id ?? null)['BgColor'];

$font = player_custom($link, $id ?? null)['Font'];

$mmsgStats = player_stats($link, $username ?? null);
$points = $mmsgStats['points'];
$totalPoints = $mmsgStats['totalPoints'];
$rank = $mmsgStats['rank'];
$total = $mmsgStats['total'];
  

function hasBg() {
  if ($ownBg = 1) {
    echo '$ownBg';
  } else {
    echo '$ownBg';
  }
}
function hasImg() {
  if ($ownImg = 1) {
    echo true;
  } else {
    echo false;
  }
}
function hasTrail() {
  if ($ownTrail = 1) {
    echo true;
  } else {
    echo false;
  }
}
$_SESSION['secure'] = $secure;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include __DIR__ . '/../templates/analytics.php'; ?>

	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Ensures optimal rendering on mobile devices. -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> <!-- Optimal Internet Explorer compatibility -->

    <title>[Gaming Blog] GTA VI: Things You Missed in the First Mission (and How to Get Them)</title>
    <meta name="description" content="A quick, spoiler-free GTA VI guide to everything you can miss in the opening missions, from Lucia&#039;s Prologue to Jason&#039;s Gone Fishing, including the missable trailer cash.">
    <link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png">
    <link rel="manifest" href="../site.webmanifest">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="/css/blog.css?v=<?php echo @filemtime(__DIR__ . '/../css/blog.css') ?: 1; ?>">
    <link rel="canonical" href="https://mms-gaming.com/blog/GTA-VI-First-Mission-Things-You-Missed.php">
    <meta property="og:type" content="article">
    <meta property="og:site_name" content="MM's Gaming Co.">
    <meta property="og:title" content="GTA VI: Things You Missed in the First Mission (and How to Get Them)">
    <meta property="og:description" content="A quick, spoiler-free GTA VI guide to everything you can miss in the opening missions, from Lucia&#039;s Prologue to Jason&#039;s Gone Fishing, including the missable trailer cash.">
    <meta property="og:url" content="https://mms-gaming.com/blog/GTA-VI-First-Mission-Things-You-Missed.php">
    <meta property="og:image" content="https://mms-gaming.com/blog/images/gta-vi-first-mission/gta-vi-first-mission-feature.jpg">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="GTA VI guide: things you missed in the first mission">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:site" content="@MMs_Gaming_Co">
    <meta name="twitter:title" content="GTA VI: Things You Missed in the First Mission (and How to Get Them)">
    <meta name="twitter:description" content="A quick, spoiler-free GTA VI guide to everything you can miss in the opening missions, from Lucia&#039;s Prologue to Jason&#039;s Gone Fishing, including the missable trailer cash.">
    <meta name="twitter:image" content="https://mms-gaming.com/blog/images/gta-vi-first-mission/gta-vi-first-mission-feature.jpg">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script> 
    <script defer data-ad-client="ca-pub-8251399081266327" src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    

</head>

<?php 
include '../comments.inc.php';
include '../posts.inc.php';
?>

<style type="text/css">

body {
  cursor: <?php include '../loadCursor.php'; ?>;
}

.pointer{
  background: <?php include "../loadTrail.php";?>;
  border: 1px solid <?php include "../loadTrail.php";?>;
}

.col-lg-10{
  column-count:4;
}

.col-lg-12{
  column-count:4;
}

.col-lg-14{
    column-count:1;
}

#logo { width: 50%; height: 150px;}

#rightHd {
    width: 66.6%;
    height: 150px;
    display: flex;
    flex-direction: row-reverse;
}

.heading1 {
    width: 100%;
    height: auto;
    display: flex;
    justify-content: center;
    text-align:center;
    top:0;
    left:0;
    padding-bottom: 10px;
}

.info {
    float:left;
  font-size: 18px;
  text-align: left;
  justify-content: left;
  height: 180px;  
  width: 33.3%;
  margin-left: 0px;
  padding: 12px;
  left:0;
}

div.meter {
    width:275px;
}



.logo {
    float:left;
  text-align: center;
  align-items:center;
  justify-content: center;
  height: 150px;
  max-width: 100%;
  margin: 10px 0;
}
.ctrlBtns {
    float:left;
  text-align: right;
  align-items: right;
  height: 100%; 
  width: 50%; 
  margin: 10px 0;
}

p, h1, h2, h3, h4, h5, h6 {
  width: 100%;
  line-height: 200%;
}

.col-lg-10, .col-lg-12, .col-lg-14 {
    align-items: center;
    text-align: center;
    width: 100%;
}

.col-lg-12 {
  text-decoration: underline;
}

.bgW {
    width:90%;
    height: auto;
    background-color: #FFC675;
    border: solid black 1px;
    border-radius: 25px;
    padding: 10px;
    margin: 15px;
}

/* Style the tab content (and add height:100% for full page content) */
.tabcontent {
  color: black;
  display: left;
  padding: 50px 20px;
  height: auto;
  width:auto;
  overflow-x: auto;
}

/* Add a black background color to the top navigation */
.topnav {
    position: -webkit-sticky; /* Safari */  
position: sticky;
    width: 100%;
    z-index: 1;
    top: 0px;
  left: 0px;
  background-color: #333;
  overflow: hidden;
  align-items:center;
  justify-content: center;
  text-align: center;
}

/* Style the links inside the navigation bar */
.topnav a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 20px;
  text-decoration: none;
  font-size: 17px;
  vertical-align: center;
  height: 64px;
  width: 134px;
}
.topnav button {
  float: left;
  display: block;
  background-color: #333;
  color: #f2f2f2;
  text-align: center;
  padding: 20px;
  text-decoration: none;
  font-size: 17px;
  vertical-align: center;
  height: 64px;
  width: 134px;
}

/* Change the color of links on hover */
.topnav a:hover {
  background-color: #4CAF50;
  color: black;
}

.topnav a.active {
  background-color: #4CAF50;
  color: white;
}

.tablink {
} 

/* Add a color to the active/current link */
a.tablink:active {
  color: black;
}

.topnav .icon {
  display: none;
}

.fb-share-button {
    align-items: center;
    justify-content: center;
    text-align: center;
    position: relative;
    top: 15px;
    left: 0px;
}

.heading1 > .google-auto-placed {
display:none !important;
}

/* Header/Blog Title */
.header {
  padding: 20px;
  font-size: 40px;
  text-align: center;
  background: white;
}

/* Create two unequal columns that floats next to each other */
/* Left column */
.leftcolumn { 
    margin-top: 20px;
    height: auto;
    background-color: white;
    display: block;
  float: left;
  width: 75%;
    border: solid black 1px;
    border-radius: 25px;
}

/* Right column */
.rightcolumn {
    display: block;
  float: left;
  height: auto;
  width: 25%;
}

/* Fake image */
.fakeimg {
  background-color: #aaa;
  width: 100%;
  padding: 20px;
}

/* Add a card effect for articles */
.card {
  background-color: white;
  padding: 20px;
  border-radius: 5px;
  width: 90%;
}

.row{
    padding-bottom: 20px;
    width:75%;
}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Style all font awesome icons */
.fa {
  padding: 10px;
  font-size: 30px;
  height: 50px;
  width: 50px;
  text-align: center;
  text-decoration: none;
  border-radius: 50%;
}

/* Add a hover effect if you want */
.fa:hover {
  opacity: 0.9;
  text-decoration: none;
}

/* Set a specific color for each brand */

/* Facebook */
.fa-facebook {
  background: #3B5998;
  color: white;
}

/* Twitter */
.fa-twitter {
  background: #55ACEE;
  color: white;
}

h2, h3, h4, h5, h6 {
    margin-top: -10px;
}

  .rightcolumn > .card > a {
      color: white;
  }
  
  .leftcolumn > .card {text-align: left;}
  
  .rightcolumn > .card {
    float:left;
    width:100%;
    background-color: white;
    text-align: center;
    height: auto;
    background-color: white;
    border: solid black 1px;
    border-radius: 25px;
    padding: 20px;
    margin: 20px;
}
  
  .rightcolumn > .card > a:hover {
      color: black;
  }
  
    .topnav a {
      padding-top: 25px;
      vertical-align: center;
      height: 78px;
  }
  
  @media screen and (max-width: 898px) {
    
        .topnav a:not(:first-child) {display: none;}
  .topnav a.icon {
    padding: 15px;
    float: right;
    display: block;
  }
  
  .topnav.responsive {position: relative;}
  .topnav.responsive a.icon {
    position: absolute;
    right: 0;
    top: 0;
    width: 25%;
  }
  .topnav.responsive a {
    float: none;
    display: block;
    width: 75%;
  }
  
  .topnav.responsive div {
    float: none;
    display: block;
    width: 75%;
    top: 0px;
    margin-top: 10px;
    margin-bottom: 20px;
  }
    
}

@media screen and (max-width: 1222px) {
    
    #heading1 {
        display:flex;
        flex-direction: column-reverse;
    }
    
    #rightHd{
        width: 100%;
    }
    
    #logo{width: 66.6%;float: left;
        display: inline;
        align-items:right;
        justify-content:right;
        text-align:right;}
    #info { width: 50%;}
    
    .info {
        display: block;
        float: none;
        width: 100%;
    }
    .ctrlBtns {
        display: inline;
        float: left;
        width:33.3%;
    }
    
  .col-lg-10{
    column-count:3;
  }

  .col-lg-12{
    column-count:3;
  }
  
  .leftcolumn, .rightcolumn { 
    width: 100%;
    padding: 0;
  }
  
  .rightcolumn > .card {margin-left:0px;}
  
  
}

@media screen and (max-width: 916px) {
    .ctrlBtns {
        width:45%;
    }
    
    #logo{
        width: 55%;
    }
    
    #info { width: 50%;}
}

@media screen and (max-width: 800px) {
    
    .ctrlBtns {
        width:50%;
    }
    
    #logo{
        width: 50%;
    }
    
    #info { width: 50%;}

    .footer {
        display:inline-block;
        height: auto;
    }

    .alignLeft {
        width: 100%;
        display: inline-block;
        justify-contents: center;
        align-items: center;
        text-align: center;
    }
    .alignRight {
        width: 100%;
        display: inline-block;
        justify-contents: center;
        align-items: center;
        text-align: center;
    }
    
  .col-lg-10{
    column-count:2;
  }

  .col-lg-12{
    column-count:2;
  }
  
}

@media screen and (max-width: 620px) {
    
    #info { width: 50%;}

    .col-lg-10{
    column-count:1;
  }
    
    .col-lg-12{
        column-count:1;
    }
    
    .info {
        width: 100%;
        display: block;
        align-items: baseline;
        text-align: left;
    }
    
    .logo {
        width: 100%;
        left: 50%;
        display: block;
        align-items: center;
        text-align: center;
        vertical-align: left;
    }
    
    .footer {
        display:inline-block;
        height: auto;
    }
    
    .alignLeft {
        width: 100%;
        display: inline-block;
        justify-content: center;
        align-items: center;
        text-align: center;
    }
    .alignRight {
        width: 100%;
        display: inline-block;
        justify-content: center;
        align-items: center;
        text-align: center;
    }
    
}

.myimg {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border-radius: 50%;
}

<?php
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
    echo '.topnav {position: static;}
    .topnav div {display: none;}
        .leftcolumn {width: 100%; display: block;}
        .card {width: 90%; display: block;}
        .rightcolumn > .card {margin-left: 0px;}
        .row {width: 95%;}
        .footer {position: static;}';
}
?>


</style>

<?php
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo '<style type="text/css">.info{display: none;} .logo{ min-width: 60%; width:60%; align-items: right; text-align: right;}
    #rightHd { width: 100%;} .ctrlBtns {width: 40%;}</style>';
    echo '<body>';
} else {
    echo '<body style="background-color:'; include "../loadBg.php"; echo'">';
}
?>
    
<main id="page-container">
    <div class="fb-root"></div>
        <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v6.0"></script>
        
   <div id="content-wrap">
  <div id="trail" class="trail" style="disa">
    <div class="pointer pointer1"></div>
    <div class="pointer pointer2"></div>
    <div class="pointer pointer3"></div>
    <div class="pointer pointer4"></div>
    <div class="pointer pointer5"></div>
  </div>
    <?php include __DIR__ . '/../templates/topbar.php'; ?>
   
<?php $menuActive = 'blog'; $shareUrl = 'https://mms-gaming.com/blog/'; include __DIR__ . '/../templates/menu.php'; ?>

    <br>
<center>
 <div class="row blog-layout">
  <div class="leftcolumn">
      <?php echo getArticle($link);
    ?>
    </div>
  <div class="rightcolumn">
    <div class="card">
      <h2>About Me</h2>
      <img class="myimg" src="../me.JPG"/>
      <p>I am a computer science student. Starting this blog to help inform gamers of new games, updates, and anything related to gaming. Play awesome browser games, while staying up to date on the latest news.</p>
    </div>
    <div class="card">
      <h3>Popular Post</h3>
      <div class="fakeimg">Image</div><br>
      <div class="fakeimg">Image</div><br>
      <div class="fakeimg">Image</div>
    </div>
    <div class="card">
      <h3>Follow Me</h3>
      <a href="https://www.facebook.com/MMsGamingCo/" class="fa fa-facebook"></a>&nbsp;
      <a href="https://twitter.com/MM6sGamingCo" class="fa fa-twitter"></a>
    </div>
<?php include __DIR__ . '/../templates/ad-banner.php'; ?>
  </div>
  <div class="leftcolumn">
    <div class="card">
        <?php
        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
            echo "<center><p style='font-size: 18px;'>Please login to make a comment! Feel free to like and share!</p>
            <span class='likebtn-wrapper' data-theme='drop' data-ef_voting='wobble'></span></center>";
} else {
    echo "<center><span class='likebtn-wrapper' data-theme='drop' data-ef_voting='wobble'></span></center><br>
        <form method='POST' action='".setComments($link)."'>
            <input type='hidden' name='uid' value='".e($username)."'>
            <input type='hidden' name='date' value='".date('Y-m-d H:i:s')."'>
            <textarea class='myTextArea' name='message'></textarea><br>
            <button class='comment-btn' name='commentSubmit' type='submit'>Comment</button>
        </form><br>";
}
    echo getComments($link);
        ?>
    </div>
  </div>
</div>
<br>
</center>

</div>

</div>
<?php include __DIR__ . '/../templates/footer.php'; ?>
</main>

</body>

<?php
        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
            echo '<script> 
            (function(d,e,s){if(d.getElementById("likebtn_wjs"))return;a=d.createElement(e);m=d.getElementsByTagName(e)[0];a.async=1;a.id="likebtn_wjs";a.src=s;m.parentNode.insertBefore(a, m)})(document,"script","//w.likebtn.com/js/w/widget.js");
            
            function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
//mouse follow
$(document).mousemove(function(e){
      $(".pointer").css({left:(window.Event) ? e.pageX : event.clientX + (document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft), top:(window.Event) ? e.pageY : event.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop)});
    });
/////////////////</script>';
        } else {
            echo '<script type="text/javascript">
            (function(d,e,s){if(d.getElementById("likebtn_wjs"))return;a=d.createElement(e);m=d.getElementsByTagName(e)[0];a.async=1;a.id="likebtn_wjs";a.src=s;m.parentNode.insertBefore(a, m)})(document,"script","//w.likebtn.com/js/w/widget.js");
            
            function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
//mouse follow
$(document).mousemove(function(e){
      $(".pointer").css({left:(window.Event) ? e.pageX : event.clientX + (document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft), top:(window.Event) ? e.pageY : event.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop)});
    });
/////////////////';
            echo 'var points = document.getElementById("points");
                var bodyColor = document.getElementById("body");';
            echo 'var custom = {';
            echo "Points  : " . js((string) $points) . ",";
            echo "BgColor : " . js((string) $bgColor) . ",";
            echo "Trail   : " . js((string) $TrailC) . ",";
            echo "BgImg   : " . js((string) $bgImg) . ",";
            echo "Cursor  : " . js((string) $cursor) . ",";
            echo "Font    : " . js((string) $font) . ",";
            echo "Donor   : " . js((string) $isDonor) . ",";
            echo "hasTrail: " . js((string) $ownTrail) . ",";
            echo "hasBg   : " . js((string) $ownBg) . ",";
            echo "hasImg  : " . js((string) $ownImg);
            echo '}</script>';
        }
        ?>


</html>
