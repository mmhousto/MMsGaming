<?php
// Initialize the session
session_start();   
require_once "../config.php";  
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
}
$total = "";
$secure = $_SESSION['secure'];
$username = $_SESSION['username'];
$rank = $_SESSION['rank'];
$id = $_SESSION['id'];
$isD = "SELECT Donor FROM custom WHERE UID = '$id'";
$result10 = mysqli_query($link, $isD);
while($row = mysqli_fetch_assoc($result10)) {
  $isDonor = $row["Donor"];
}
$p = "SELECT points FROM users WHERE username = '$username'";
$result1 = mysqli_query($link, $p);//"SELECT points FROM users WHERE username = $username";
while($row = mysqli_fetch_assoc($result1)) {
  $points = $row["points"];
}
$tp = "SELECT totalPoints FROM users WHERE username = '$username'";
$result = mysqli_query($link, $tp);//"SELECT points FROM users WHERE username = $username";
while($row = mysqli_fetch_assoc($result)) {
  $totalPoints = $row["totalPoints"];
}
if($totalPoints < 100){
    $rank = "Noob";
    $total = 100;
} else if($totalPoints >= 100 && $totalPoints < 200){                            
    $rank = "Novice";
    $total = 200;
    $sql1 = "UPDATE users SET rank = '$rank' WHERE username = '$username'";
        mysqli_query($link, $sql1);
} else if($totalPoints >= 200 && $totalPoints < 400){
    $rank = "Experienced";
    $total = 400;
    $sql1 = "UPDATE users SET rank = '$rank' WHERE username = '$username'";
        mysqli_query($link, $sql1);
} else if($totalPoints >= 400 && $totalPoints < 800){
    $rank = "Specialist";
    $total = 800;
    $sql1 = "UPDATE users SET rank = '$rank' WHERE username = '$username'";
        mysqli_query($link, $sql1);
} else if($totalPoints >= 800 && $totalPoints < 1600){
    $rank = "Expert";
    $total = 1600;
    $sql1 = "UPDATE users SET rank = '$rank' WHERE username = '$username'";
        mysqli_query($link, $sql1);
} else if($totalPoints >= 1600 && $totalPoints < 3200){
    $rank = "Bada**";
    $total = 3200;
    $sql1 = "UPDATE users SET rank = '$rank' WHERE username = '$username'";
        mysqli_query($link, $sql1);
} else if($totalPoints >= 3200 && $totalPoints < 6400){
    $rank = "Noble";
    $total = 6400;
    $sql1 = "UPDATE users SET rank = '$rank' WHERE username = '$username'";
        mysqli_query($link, $sql1);
} else if($totalPoints >= 6400 && $totalPoints < 12800){
    $rank = "Spartan";
    $total = 12800;
    $sql1 = "UPDATE users SET rank = '$rank' WHERE username = '$username'";
        mysqli_query($link, $sql1);
} else if($totalPoints >= 12800 && $totalPoints < 25600){
    $rank = "Legend";
    $total = 25600;
    $sql1 = "UPDATE users SET rank = '$rank' WHERE username = '$username'";
        mysqli_query($link, $sql1);
}  else if($totalPoints >= 25600 && $totalPoints < 52000){
    $rank = "Game Game Junkie";
    $total = 52000;
    $sql1 = "UPDATE users SET rank = '$rank' WHERE username = '$username'";
        mysqli_query($link, $sql1);
} else if($totalPoints >= 52000 && $totalPoints < 104000){
    $rank = "Godsent";
    $total = 104000;
    $sql1 = "UPDATE users SET rank = '$rank' WHERE username = '$username'";
        mysqli_query($link, $sql1);
} else {
    $rank = "INSANE";
    $total = 208000;
    $sql1 = "UPDATE users SET rank = '$rank' WHERE username = '$username'";
        mysqli_query($link, $sql1);
}   

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
  <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->

    <title>Play Slither.io Online Free | Snake Game [IO Gaming]</title>
    <meta name="description" content="Playing Slither.io, also called the snake game, will gain you points to spend in my store. This HTML5, io, online game with multiplayer is free. Play on MM's Gaming Co.">
    
    <link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png">
    <link rel="manifest" href="../site.webmanifest">
    <link rel="stylesheet" type="text/css" href="../footer.css">
    <link rel="stylesheet" href="../basic.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="canonical" href="https://mms-gaming.com/Slither/">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>
<script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script defer src="../jquery-idleTimeout-iframes.min.js" type="text/javascript"> </script>
    <script defer data-ad-client="ca-pub-8251399081266327" src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    
</head>

<style type="text/css">
/* Set height of body and the document to 100% to enable "full page tabs" */
html{
  height: 100%;
  margin: 0;
  font-family: Arial;
}
body {
  cursor: <?php include '../loadCursor.php'; ?>;
  background-color: #38b6ff;
  height: 100%;
  margin: 0;
  font-family: <?php include '../loadFont.php'; ?>;
}

.pointer{
  background: <?php include "../loadTrail.php";?>;
  border: 1px solid <?php include "../loadTrail.php";?>;
}

#logo { width: 50%;}

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

div.meter {
    width:275px;
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

p, h1, h2, h3, h4, h5, h6 {
  width: 100%;
  line-height: 200%;
}

.heading1 > .google-auto-placed {
display:none !important;
}

#bookmark-this {
  padding: 25px 10px;
  background-color: #ec971f;
  border: 1px solid #eea236;
  font-size: 12px;
  color: #fff;
  vertical-align: center;
  text-decoration: none;
  text-shadow: 0 -1px 0 rgba(0, 0, 0, .2);
  -webkit-box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2);
  box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.4), 0 1px 1px rgba(0, 0, 0, 0.2);
  -webkit-user-select:none;
  -moz-user-select:none;
  -ms-user-select:none;
  user-select:none;
}

#bookmark-this:hover {
  background-color: #f0ad4e;
  border: 1px solid #d58512;
  text-decoration: none;
}

#bookmark-this:active {
  background-color: #ec971f;
  border: 1px solid #d58512;
  -webkit-box-shadow: inset 0 1px 4px rgba(0, 0, 0, 0.2);
  box-shadow: inset 0 1px 4px rgba(0, 0, 0, 0.2);
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

@media screen and (max-width: 938px) {
    
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
    
}

@media screen and (max-width: 620px) {
    
    #info { width: 50%;}

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
    
}

#sep {border-bottom: dashed; border-width: 5px;}

#game {
  border: dashed;
  border-width: 5px;
  width: 90%;
  height: 720px;
  padding-top: 5px;
}

.game {
    position: relative;
    overflow: hidden;
    padding-top: 56.25%;
}

.gameFrame {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: 0;
}

.desc-box {
    width:90%;
    height: auto;
    background-color: white;
    border: solid black 1px;
    border-radius: 25px;
    padding: 10px;
    margin: 15px;
    align-items: left;
    text-align: left;
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
    border: 1px solid #144afe;
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

kbd {
    background-color: #eee;
    border-radius: 3px;
    border: 1px solid #b4b4b4;
    box-shadow: 0 1px 1px rgba(0, 0, 0, .2), 0 2px 0 0 rgba(255, 255, 255, .7) inset;
    color: #333;
    display: inline-block;
    font-size: .85em;
    font-weight: 700;
    line-height: 1;
    padding: 2px 4px;
    white-space: nowrap;
   }

   p {
    font-size: 16px;
}

.adsbygoogle {
    width: 85%;
    }

</style>

<?php
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo '<style type="text/css">.info{display: none;} .logo { min-width: 60%; width:60%; align-items: right; text-align: right;}
    #rightHd { width: 100%;} .ctrlBtns {width: 40%;}</style>';
    echo '<body>';
} else {
    echo '<body onload="playing()" style="background-color:'; include "../loadBg.php"; echo'">';
}
?>
<main id="page-container">
   <div id="content-wrap">

  <div id="trail" class="trail" style="disa">
    <div class="pointer pointer1"></div>
    <div class="pointer pointer2"></div>
    <div class="pointer pointer3"></div>
    <div class="pointer pointer4"></div>
    <div class="pointer pointer5"></div>
  </div>

<div id="heading1" class="heading1">
        <div id="info" class="info">
        <h3><b><?php if($isDonor){echo "Donor";}else{echo "Gamer";} ?>:</b> <span id="Gamer"><a href="../profile.php"><?php echo htmlspecialchars($username); ?></a></span></h3>
        <h4><b>Rank:</b> <span id="Rank"><?php echo htmlspecialchars($rank); ?></span></h4>
        <h4><b>Points:</b> <span id="points" class="pointCount"><?php echo $points; ?></span></h4>
        <div class="Progress"><b>Next Rank:</b> <div id="pntCount" class="pointCount"><?php if($total == 100){
        																				echo $totalPoints;
        																			 }else{echo ($totalPoints - ($total/2));}?>	
        																			 </div>/<div id="total" class="total"><?php if($total == 100){
        																				echo $total;}else{echo ($total-($total/2));} ?></div>
          <div class="meter">
  			<span id="myBar" style="width: <?php if($total == 100){echo $totalPoints;}
  				else{echo ((($totalPoints - ($total/2))/($total/2)) * 100);}?>%"></span>
		      </div>
		    </div>
        </div>
    <div id="rightHd">
        <div class="ctrlBtns" align="right">
	 	    <p style="width: 100%;" align="right">
	 	    <?php
            if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
               echo '<a href="../register.php" class="btn btn-success" style="width: 125px;">Sign Up!</a>&nbsp;';
                echo '<a href="../login.php" class="btn btn-warning" style="width: 125px;">Login!</a>';
            } else {
             echo '<a href="../reset-password.php" class="btn btn-warning">Reset Your Password</a>&nbsp;';
             echo '<a href="../logout.php" class="btn btn-danger">Sign Out</a>';
            }
            ?>
    	    </p>
    	</div>
        <div id="logo" class="logo" align="center">
         <picture>
            <source srcset="../MMsGCoo.webp" type="image/webp">
            <source srcset="../MMsGCoo.jp2" type="image/jp2">
	  	    <a href="../index.php" ><img src="../MMsGCoo.png" alt="The logo of MMs Gaming company, meant to look like a controller and the letters 'MM'" title="MMs Gaming Logo" style="max-width:100%;max-height:300px;" vspace="0"></a>
	     </picture>
	    </div>
	 </div>
	 
    </div>
    
<header class="topnav" id="myTopnav">
        <a class="tablink" href="../index.php">Home</a>
        <a class="tablink" href="../Free-Games.php">Games</a>
        <a class="tablink" href="../Unity-Games.php">My Games</a>
        <a class="tablink" href="../Store.php">Store</a>
        <a class="tablink" href="../Scoreboard.php">Scoreboard</a>
        <a class="tablink" href="../blog">Blog</a>
        <a class="tablink" href="../about.php">About</a>
        <a id="bookmark-this" href="#" title="Bookmark This Game">Bookmark Game</a>
        <a href="javascript:void(0);" class="icon" onclick="myFunction()">
            <i class="fa fa-bars"></i>
        </a>
    </header>

<center>
<br><br>
<br>
	<p style="color:black; margin: -30px 10px 10px; text-align: center"><font size="+2">GAME ON!</font></p>
<?php
if (!empty($_SERVER['HTTPS'])) 
{
  echo '<div class="desc-box"><h2 style="text-align: center;"><font size="+3">Why is Slither.io not working?</font></h2><p><font size="+2">Slither.io must be played in http, change the address from "<b>https</b>://mms-gaming.com/Slither/" to "<b>http</b>://mms-gaming.com/Slither/" to play the game!<br>If that does not work, allow insecure content. You can do this by going to "Site settings" and scrolling down to "Insecure content" set this to "Allow"</font></p></div>';
}
include '../games.inc.php';
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo '<div id="game">';
} else {
    echo '<div id="game" onmouseleave="stopAdding(); notPlaying();" onmouseenter="startAdding(); playing();">';
}
    echo getSelectedGame($link, 24); ?>
<br>
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
<div class="desc-box" align="center" style="text-align: center;">
    <h3 style="text-align: center;"><font size="+3"><strong>More Online Gaming</strong></font></h3>
     <p>Done Playing Slither.io? Choose other genres of games to play for free! Games similar to this are multiplayer or io ones. Select 'IO Gaming' or 'Multiplayer Gaming Online' to view more cool games. I also think you would enjoy playing fps type games. They are first person shooters. Usually multiplayer, like this game, and can be played with friends.</p>
    <a class="button" href="../IO-Games.php">IO Gaming</a>
    <a class="button" href="../Strategy-Games.php">Strategy Gaming</a>
    <a class="button" href="../Multiplayer-Games.php">Multiplayer Gaming Online</a>
    <a class="button" href="../FPS-Games.php">FPS Gaming</a>
    <a class="button" href="../Car-Games.php">Car Racing Gaming</a>
    <a class="button" href="../Card-Games.php">Card Gaming</a>
</div>
<br>

</center>
</div>
<footer id="gradient" class="footer">
  <span class="alignLeft">© 2019-2024 MM's Gaming Community LLC. All Rights Reserved.</span><span class="alignRight"><a href="../sitemap.xml">Sitemap</a> | <a href="../terms.html">Terms & Conditions</a> | <a href="../privacyPolicy.html">Privacy Policy</a> | <a href="../contactform.htm">Contact Me!</a></span>
</footer>
</main>
</body>

<?php
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo '<script type="text/javascript">
    (function(d,e,s){if(d.getElementById("likebtn_wjs"))return;a=d.createElement(e);m=d.getElementsByTagName(e)[0];a.async=1;a.id="likebtn_wjs";a.src=s;m.parentNode.insertBefore(a, m)})(document,"script","//w.likebtn.com/js/w/widget.js");
    
    jQuery(function ($) {

  $("#bookmark-this").click(function (e) {
    var bookmarkURL = window.location.href;
    var bookmarkTitle = document.title;

    if ("addToHomescreen" in window && addToHomescreen.isCompatible) {
      // Mobile browsers
      addToHomescreen({ autostart: false, startDelay: 0 }).show(true);
    } else if (/CriOS\//.test(navigator.userAgent)) {
      // Chrome for iOS
      alert("To add to Home Screen, launch this website in Safari, then tap the Share button and select, Add to Home Screen.");
    } else if (window.sidebar && window.sidebar.addPanel) {
      // Firefox <=22
      window.sidebar.addPanel(bookmarkTitle, bookmarkURL, "");
    } else if ((window.sidebar && /Firefox/i.test(navigator.userAgent) && !Object.fromEntries) || (window.opera && window.print)) {
      // Firefox 23-62 and Opera <=14
      $(this).attr({
        href: bookmarkURL,
        title: bookmarkTitle,
        rel: "sidebar"
      }).off(e);
      return true;
    } else if (window.external && ("AddFavorite" in window.external)) {
      // IE Favorites
      window.external.AddFavorite(bookmarkURL, bookmarkTitle);
    } else {
      // Other browsers (Chrome, Safari, Firefox 63+, Opera 15+)
      alert("Press " + (/Mac/i.test(navigator.platform) ? "Cmd" : "Ctrl") + "+D to bookmark this page.");
    }

    return false;
  });

});
    
    function myFunction() {
  var x = document.getElementById("myTopnav");
  if (x.className === "topnav") {
    x.className += " responsive";
  } else {
    x.className = "topnav";
  }
}
    
    function init() {
    var vidDefer = document.getElementsByTagName("iframe");
    for (var i=0; i<vidDefer.length; i++) {
        if(vidDefer[i].getAttribute("data-src")) {
        vidDefer[i].setAttribute("src",vidDefer[i].getAttribute("data-src"));
    } } }
window.onload = init;</script>';
} else {
    echo "<script type='text/javascript'>
    (function(d,e,s){if(d.getElementById('likebtn_wjs'))return;a=d.createElement(e);m=d.getElementsByTagName(e)[0];a.async=1;a.id='likebtn_wjs';a.src=s;m.parentNode.insertBefore(a, m)})(document,'script','//w.likebtn.com/js/w/widget.js');
    
    jQuery(function ($) {

  $('#bookmark-this').click(function (e) {
    var bookmarkURL = window.location.href;
    var bookmarkTitle = document.title;

    if ('addToHomescreen' in window && addToHomescreen.isCompatible) {
      // Mobile browsers
      addToHomescreen({ autostart: false, startDelay: 0 }).show(true);
    } else if (/CriOS\//.test(navigator.userAgent)) {
      // Chrome for iOS
      alert('To add to Home Screen, launch this website in Safari, then tap the Share button and select, Add to Home Screen.');
    } else if (window.sidebar && window.sidebar.addPanel) {
      // Firefox <=22
      window.sidebar.addPanel(bookmarkTitle, bookmarkURL, '');
    } else if ((window.sidebar && /Firefox/i.test(navigator.userAgent) && !Object.fromEntries) || (window.opera && window.print)) {
      // Firefox 23-62 and Opera <=14
      $(this).attr({
        href: bookmarkURL,
        title: bookmarkTitle,
        rel: 'sidebar'
      }).off(e);
      return true;
    } else if (window.external && ('AddFavorite' in window.external)) {
      // IE Favorites
      window.external.AddFavorite(bookmarkURL, bookmarkTitle);
    } else {
      // Other browsers (Chrome, Safari, Firefox 63+, Opera 15+)
      alert('Press ' + (/Mac/i.test(navigator.platform) ? 'Cmd' : 'Ctrl') + '+D to bookmark this page.');
    }

    return false;
  });

});
    
    function myFunction() {
  var x = document.getElementById('myTopnav');
  if (x.className === 'topnav') {
    x.className += ' responsive';
  } else {
    x.className = 'topnav';
  }
}

//mouse follow
$(document).mousemove(function(e){
      $('.pointer').css({left:(window.Event) ? e.pageX : event.clientX + (document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft), top:(window.Event) ? e.pageY : event.clientY + (document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop)});
    });
/////////////////
    
  var info = {
    Gamer   : '$username',
    Rank    : '$rank',
    Points  : '$points',
    PntCount: ";if($total == 100){echo "'$totalPoints'";}else{echo "('$totalPoints' - ('$total'/2))";} echo",
    Total   : ";if($total == 100){echo "'$total'";}else{echo "('$total'-('$total'/2))";} echo",
    Prog    : ";if($total == 100){echo "'$totalPoints'";}
                    else{echo "((('$totalPoints' - ('$total'/2))/('$total'/2)) * 100)";} echo',
    Perc    : function(){return this.Prog;}
  };
//=======================================================================================================//
//set Points===========================================================================================//
    var gamer = document.getElementById("Gamer");
    var rank = document.getElementById("Rank");
    var total = document.getElementById("total");
    var elem = document.getElementById("meter"); 
    var pnts = document.getElementById("pntCount");
    var points = document.getElementById("points");
    var progress = pnts.innerHTML;
    var perc = document.getElementById("myBar");


function addPoints() {
  var percent = 2;
    if (progress >= (total.innerHTML * 2)) {
      elem.style.width = 0;
      pnts.innerHTML = 0;
      progress = pnts.innerHTML;
    } else {
      pnts.innerHTML = $("#pntCount").load("../addPoints.php", "info.PntCount");
      gamer.innerHTML = $("#Gamer").load("../gamer.php", "info.Gamer");
      rank.innerHTML = $("#Rank").load("../rank.php", "info.Rank");
      points.innerHTML = $("#points").load("../points.php", "info.Points");
      total.innerHTML = $("#total").load("../total.php", "info.Total");
      perc.style.width = $("#myBar").load("../Bar.php", "info.Prog");

    }
}

var isPlaying;
var idleTime = 0;
var idle;

function playing() {
  clearInterval(idle);
  idleTime = 0;
  isPlaying = true;
}
function notPlaying() {
  var idle = setInterval(timerIncrement, 60000); // 1 minute
  isPlaying = false;
}

$(document).onmousemove = function(){
  clearTimeout(idle);
  idle = setInterval(timerIncrement, 60000);
}

if (isPlaying == false) {
  clearInterval(id);
}

function timerIncrement() {
    idleTime = idleTime + 1;
    if (idleTime > 1) { // 4 minutes
        isPlaying = false;
        idleTime = 0;
      //  alert("You have Timed Out!");
    }
}

var id;
function startAdding() {
  id = setInterval(addPoints, 30000);
}
function stopAdding() {
  clearInterval(id);
}

function init() {
    var vidDefer = document.getElementsByTagName("iframe");
    for (var i=0; i<vidDefer.length; i++) {
        if(vidDefer[i].getAttribute("data-src")) {
        vidDefer[i].setAttribute("src",vidDefer[i].getAttribute("data-src"));
    } } }
window.onload = init;

    </script>';
}
?>

</html>