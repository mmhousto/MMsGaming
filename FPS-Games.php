<?php 
// Initialize the session
session_start();   
require_once "config.php";
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
}

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
    <!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-162871090-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-162871090-1');
</script>

	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Ensures optimal rendering on mobile devices. -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> <!-- Optimal Internet Explorer compatibility -->
  
   <!-- For facebook share button -->
  <meta property="og:url" content="https://mms-gaming.com/FPS-Games.php" />
  <meta property="og:type"  content="website" />
  <meta property="og:title" content="Play FPS Games Online in Browser [First Person Shooter Gaming]" />
  <meta property="og:description" content="Play online first person shooter games, such as, Krunker.io, Cartoon Strike and more in browser! Free FPS fun @ MM's Gaming Co!" />
  <meta property="og:image" content="https://mms-gaming.com/MM.png" />
  <!--- ----->

    <title>Play FPS Games Online in Browser [First Person Shooter Gaming]</title>
    <meta name="description" content="Play online first person shooter games, such as, Krunker.io, Cartoon Strike and more in browser! Free FPS fun @ MM's Gaming Co!">
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="stylesheet" href="basic.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="canonical" href="https://mms-gaming.com/FPS-Games.php">
    
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>

    <script type="text/javascript">
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
/////////////////

//=========================================================================================================//
  (function($){
    var initialContainer = $('.columns'),
        columnItems = $('.columns li'),
        columns = null,
        column = 1; // account for initial column
    function updateColumns(){
        column = 0;
        columnItems.each(function(idx, el){
            if (idx !== 0 && idx > (columnItems.length / columns.length) + (column * idx)){
                column += 1;
            }
            $(columns.get(column)).append(el);
        });
    }
    function setupColumns(){
        columnItems.detach();
        while (column++ < initialContainer.data('columns')){
            initialContainer.clone().insertBefore(initialContainer);
            column++;
        }
        columns = $('.columns');
    }

    $(function(){
        setupColumns();
        updateColumns();
    });
})(jQuery);
//======================================================================================================//
    //Column layout=====================================================================================//
var bgBuy = document.getElementById("bgBuy");
var bgSelect = document.getElementById("bgSelect");
var bgImgBuy = document.getElementById("bgImgBuy");
var bgImgSelect = document.getElementById("bgImgSelect");
var circleBuy = document.getElementById("circleBuy");
var circleSelect = document.getElementById("circleSelect");
var points = document.getElementById("points");
var bodyColor = document.getElementById("body");

<?php
        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    // Guest: safe defaults for the (hidden) points bar, avoids division by zero
    $total = 100; $totalPoints = 0; $points = 0;
} else {
echo "function setTrail() {
  if ($ownTrail) {
    $('#circleBuy').prop('disabled', true);
    $('#circleSelect').prop('disabled', false );
  } else {
    $('.trail').css('display', 'none');
    $('#circleBuy').prop('disabled', false);
    $('#circleSelect').prop('disabled', true );
  }
}

function setBg() {
  if ($ownBg) {
    $('#bgBuy').prop('disabled', true);
    $('#bgSelect').prop('disabled', false );
  } else {
    $('#bgBuy').prop('disabled', false);
    $('#bgSelect').prop('disabled', true );
  }
}

function setImg() {
  if ($ownImg) {
    $('#bgImgBuy').prop('disabled', true);
    $('#bgImgSelect').prop('disabled', false );
  } else {
    $('#bgImgBuy').prop('disabled', false);
    $('#bgImgSelect').prop('disabled', true );
  }
}

function setCursor() {
  if ($ownCursor) {
    $('#cursorBuy').prop('disabled', true);
    $('#cursorSelect').prop('disabled', false );
  } else {
    $('#cursorBuy').prop('disabled', false);
    $('#cursorSelect').prop('disabled', true );
  }
}

window.onload = function () {
  startTab();
  setTrail();
  setBg();
  setImg();
  setCursor();
}
    var custom = { ";
            echo "Points  : " . js((string) $points) . ", ";
            echo "BgColor : " . js((string) $bgColor) . ", ";
            echo "Trail   : " . js((string) $TrailC) . ", ";
            echo "BgImg   : " . js((string) $bgImg) . ", ";
            echo "Cursor  : " . js((string) $cursor) . ", ";
            echo "Font    : " . js((string) $font) . ", ";
            echo "Donor   : " . js((string) $isDonor) . ", ";
            echo "hasTrail: " . js((string) $ownTrail) . ", ";
            echo "hasBg   : " . js((string) $ownBg) . ", ";
            echo "hasImg  : " . js((string) $ownImg);
            echo "};";
        }?>

//=========================================================================================================//
</script>



</head>
<?php include 'games.inc.php'; ?>
<style type="text/css">

body {
  cursor: <?php include 'loadCursor.php'; ?>;
  font-family: <?php include 'loadFont.php'; ?>;
}

.pointer{
  background: <?php include "loadTrail.php";?>;
  border: 1px solid <?php include "loadTrail.php";?>;
}

/* Style the tab content (and add height:100% for full page content) */
.tabcontent {
  color: black;
  display: left;
  padding: 50px 20px;
  height: 100%;
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

.green {
  color: #00fffb;
}

.green:visited {
  color: #00fffb;
}

.green:hover, .green:active, .green:focus {
  color: #000000;
}

.yellow {
  color: #002BEB;
}

.yellow:visited {
  color: #002BEB;
}

.yellow:hover, .yellow:active, .yellow:focus {
  color: #000000;
}

.blue {
  color: #0025CC;
}

.blue:visited {
  color: #0025CC;
}

.blue:hover, .blue:active, .blue:focus {
  color: #000000;
}

.orange {
  color: #0023BD;
}

.orange:visited {
  color: #0023BD;
}

.orange:hover, .orange:active, .orange:focus {
  color: #000000;
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

#logo { min-width: 50%;
    width:50%;
}

#rightHd {
    width: 66.6%;
    display: flex;
    flex-direction: row-reverse;
}

.heading1 {
    width: 100%;
    height: 100%;
    display: flex;
    justify-content: center;
    text-align:center;
    top:0;
    left:0;
    padding-bottom: 10px;
}

.heading1 > .google-auto-placed {
display:none !important;
}

.info {
    float:left;
  font-size: 18px;
  text-align: left;
  justify-content: left;
  height: 100%;  
  width: 33.3%;
  margin-left: 0px;
  padding: 12px;
  left:0;
}

.logo {
    float:left;
  text-align: center;
  align-items:center;
  justify-content: center;
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

div.meter {
    width:275px;
}
.adsbygoogle {
    width: 85%;
    }

#sep {border-bottom: dashed; border-width: 5px;}

.footer {position: static; margin-top: -48px;}

@media screen and (max-width: 1240px) {

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
}

@media screen and (max-width: 916px) {
    .ctrlBtns {
        width:45%;
    }
    
    #logo{
        width: 55%;
    }
    
    #info { width: 50%;}
    
    .adsbygoogle {
    width: 600px;
    }
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
    #logo {
        width:; 50%;
    }

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
    
    .tablink {
        width: 100%;
    }
}

#tabs {height: 100%;}
#Home {background-color: transparent; height: auto;}
#MyGames {background-color: #009E00; height: auto;}
#Store {background-color: cyan; height: auto;}
#About {background-color: orange; height: auto;}

td {
  position: relative;
  word-wrap: break-word;
  text-align: center;
  vertical-align: top;
  font-size: 24px;
}

#myStore {
  height: 75px; 
  width: 1020px; 
  table-layout: fixed;
}

p, h1, h2, h3, h4, h5, h6 {
  width: 90%;
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

.bestGames {
    width:65%;
    display: inline-block;
    text-align: center;
    align-items: center;
}

ol {
    column-count:1;
    float: left;
    text-align: center;
    align-items:center;
    width:100%;
}

ol li {
    display: inline-block;
    width:100%;
}

ol a {
    text-decoration:underline;
}

.bgO {
    width:90%;
    height: auto;
    background-color: #FFC675;
    border: solid black 1px;
    border-radius: 25px;
    padding: 10px;
    margin: 15px;
}

.bgY {
    width:90%;
    height: auto;
    background-color: white;
    border: solid black 1px;
    border-radius: 25px;
    padding: 20px;
    margin: 15px;
}

.bgB {
    width:90%;
    height: auto;
    background-color: #8affff;
    border: solid black 1px;
    border-radius: 25px;
    padding: 10px;
    margin: 15px;
}

.bgG {
    width:90%;
    height: auto;
    background-color: #32e34a;
    border: solid black 1px;
    border-radius: 25px;
    padding: 10px;
    margin: 15px;
}

.button {
    display: inline-block;
    text-align: center;
    vertical-align: middle;
    margin: 10px;
    padding: 12px 24px;
    border: 1px solid #113fd8;
    border-radius: 25px;
    background: #2076ff;
    background: -webkit-gradient(linear, left top, left bottom, from(#2076ff), to(#113fd8));
    background: -moz-linear-gradient(top, #2076ff, #113fd8);
    background: linear-gradient(to bottom, #2076ff, #113fd8);
    -webkit-box-shadow: #268eff 0px 0px 40px 0px;
    -moz-box-shadow: #268eff 0px 0px 40px 0px;
    box-shadow: #268eff 0px 0px 40px 0px;
    text-shadow: #0a257f 1px 1px 1px;
    font: normal normal bold 20px arial;
    color: #ffffff;
    text-decoration: none;
}
.button:hover,
.button:focus {
    border: 1px solid ##144afe;
    background: #268eff;
    background: -webkit-gradient(linear, left top, left bottom, from(#268eff), to(#144cff));
    background: -moz-linear-gradient(top, #268eff, #144cff);
    background: linear-gradient(to bottom, #268eff, #144cff);
    color: #ffffff;
    text-decoration: none;
}
.button:active {
    background: #113fd8;
    background: -webkit-gradient(linear, left top, left bottom, from(#113fd8), to(#113fd8));
    background: -moz-linear-gradient(top, #113fd8, #113fd8);
    background: linear-gradient(to bottom, #113fd8, #113fd8);
}

<?php
$useragent=$_SERVER['HTTP_USER_AGENT'];
if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
    echo '.topnav {position: static;}
    .topnav div {display: none;}
    .footer {position: static; margin-top: -50px;}';
}
?>

</style>

<?php
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo '<style type="text/css">.info{display: none;} #logo { min-width: 60%; width:60%; align-items: right; text-align: right;}
    #rightHd { width: 100%;} .ctrlBtns {width: 40%;}</style>';
} else {
}
?>
<body id="body" style="background-color: <?php include "loadBg.php"; ?>;">
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
    	
        <?php include __DIR__ . '/templates/topbar.php'; ?>
    <br>
    <?php $shareUrl = 'https://mms-gaming.com/FPS-Games.php'; include __DIR__ . '/templates/menu.php'; ?>

	<center>
<div id="tabs">
<div id="Home" class="tabcontent">

<div class="bgY">
    <h1 style="text-align: center;"><font size="+3"><strong>Play FPS Games Online</strong></font></h1>
<br><br>
  	<ul class="col-lg-10" data-columns="2" style="list-style-type:none;">
      <?php echo getFPSGames($link); ?>
	</ul>
<br><br>
    <h2 style="text-align: center;"><font size="+5"><b>FPS Gaming</b></font></h2>
        <p><font size="+1">Play fps games here at MM's Gaming Co for free. FPS stands for first person shooter, which are games that give you a first person view and usually involve a gun and eliminating the enemy team. Fps games are played, competitvely or casually, online with people from all over the world.</font></p>
 </div><br>
 <script defer src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
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
<div class="bgY">
    <h4 style="text-align: center;"><font size="+3"><strong>More Online Gaming</strong></font></h4>
    <p style="font-size: 16px;">Select other genres, if you do not see a first person shooter game you want to play at the moment. Want to see more games? Send me the best HTML5, fps games and I will add them soon.</p>
    <a class="button" href="IO-Games.php">IO Gaming</a>
    <a class="button" href="Strategy-Games.php">Strategy Gaming</a>
    <a class="button" href="Multiplayer-Games.php">Multiplayer Gaming Online</a>
    <a class="button" href="Car-Games.php">Car Racing Gaming</a>
    <a class="button" href="Card-Games.php">Card Gaming</a>
</div>
	
<!--	<div class="bgO">
      <h3 style="text-align: center;">Credits</h3>
      Icons made by <a rel="external nofollow" href="https://www.flaticon.com/authors/freepik" title="Freepik">Freepik</a> from <a rel="external nofollow" href="https://www.flaticon.com/" title="Flaticon"> www.flaticon.com</a>
  </div> -->

</div>

</center>

</div>
<?php include __DIR__ . '/templates/footer.php'; ?>
</main>

</body>

</html>