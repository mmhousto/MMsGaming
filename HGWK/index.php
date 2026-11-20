<?php
// Initialize the session
session_start();   
require_once "../config.php";                                             
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
}
$total = "";
$username = $_SESSION['username'];
$rank = $_SESSION['rank'];
$id = $_SESSION['id'];
$isDonor = player_custom($link, $id ?? null)['Donor'];
$mmsgStats = player_stats($link, $username ?? null);
$points = $mmsgStats['points'];
$totalPoints = $mmsgStats['totalPoints'];
$rank = $mmsgStats['rank'];
$total = $mmsgStats['total'];
  

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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->
    
    <title>MM's Gaming Co. | Play free Unity games</title>
    <meta name="description" content="Play my first game developed with unity, Have Gun Will Kill, only at MM's Gaming Co.">
    
    <link rel="apple-touch-icon" sizes="180x180" href="../apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon-16x16.png">
    <link rel="manifest" href="../site.webmanifest">
    <link rel="stylesheet" type="text/css" href="../footer.css">
    <link rel="stylesheet" href="../basic.css">
    <link rel="canonical" href="https://mms-gaming.com/HGWK/">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>

    <script src="../mouse.js" type="text/javascript"></script>
    <script defer src="../jquery-idleTimeout-iframes.min.js" type="text/javascript"> </script>
    <script defer data-ad-client="ca-pub-8251399081266327" src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="TemplateData/UnityProgress.js"></script>
    <script src="Build/UnityLoader.js"></script>
    <script>
      var gameInstance = UnityLoader.instantiate("gameContainer", "Build/HGWK.json", {onProgress: UnityProgress});
    </script>
    <script data-ad-client="ca-pub-8251399081266327" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

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

.footer2 {
            display: block;
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            height: 3rem;
            background-color: gray;
            color: black;
            padding: 5px;
        }
        .alignLeft {
            float: left;
        }
        .alignRight {
            float: right;
        }
        #gradient {
            background-image: linear-gradient(
                to top right, 
                #a7fbfc, #ff80bd
                );
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

    .footer2 {
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
  width: 1025px;
  height: 700px;
  padding-top: 5px;
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
<div id="page-container">
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
        <div class="Progress"><b>Next Rank:</b> <div id="pntCount" class="pointCount"><?php echo progress_for($totalPoints, $total)['count']; ?>	
        																			 </div>/<div id="total" class="total"><?php echo progress_for($totalPoints, $total)['goal']; ?></div>
          <div class="meter">
  			<span id="myBar" style="width: <?php echo progress_for($totalPoints, $total)['percent']; ?>%"></span>
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
<br><br>
<center>
<br>
	<p style="color:black; margin: -30px 10px 10px;"><font size="+2">GAME ON!</font></p>

    
    	<?php
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo '<div id="game">';
} else {
    echo '<div id="game" onmouseleave="stopAdding(); notPlaying();" onmouseenter="startAdding(); playing();">';
}
?>
<div class="webgl-content" style="height: 100%; margin-top: 0px">
      <div id="gameContainer" style="width: 960px; height: 600px"></div>
      <div class="footer">
        <div class="webgl-logo"></div>
        <div class="fullscreen" onclick="gameInstance.SetFullscreen(1)"></div>
        <div class="title">HGWK</div>
      </div>
    </div>
    </div>
    <br>
<!-- LikeBtn.com BEGIN -->
<span class="likebtn-wrapper" data-theme="drop" data-ef_voting="wobble"></span>
<script>(function(d,e,s){if(d.getElementById("likebtn_wjs"))return;a=d.createElement(e);m=d.getElementsByTagName(e)[0];a.async=1;a.id="likebtn_wjs";a.src=s;m.parentNode.insertBefore(a, m)})(document,"script","//w.likebtn.com/js/w/widget.js");</script>
<!-- LikeBtn.com END -->
<br>
<div class="desc-box">
    <h1><strong>Play Have Gun, Will Kill for Free</strong></h1>
    <p style="text-align: left;">HGWK is a platform game made in Unity. Like other platform games, advance through the level jumping from platform to platform. Shoot enemies with your hand gun. This was a group project I worked on. You are Robotron, the only one who can save your planent from the alien invasion. Move throughout the levels, defeating aliens to get to the end and stop the mothership!</p>
    <h2><strong>How to play HGWK</strong></h2>
    <p style="text-align: left;">Defeat the aliens that stand in your way. Jump and dodge bullets, while firing back to destroy enemies. Advance to the end to kill the boss and reach the mothership.</p><h2><strong>HGWK Controls</strong></h2><ul class="col-lg-12" style="column-count: 1; text-align: left; font-size: 18px;"><li><kbd>WASD</kbd> to move</li><li><kbd>J</kbd> to fire weapon</li><li><kbd>K</kbd> to use super attack</li><li><kbd>L</kbd> to levitate</li><li><kbd>Space</kbd> to jump</li></ul><h3><strong>HGWK Tips</strong></h3><p>Either fight all the enemies or try to make a break for the mother ship! It is easier to take it slow and eliminate the alien invasion slowly.</p>
</div>
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
    <h4 style="text-align: center;"><font size="+3"><strong>More Free Gaming</strong></font></h4>
    <a class="button" href="../IO-Games.php">IO Gaming</a>
    <a class="button" href="../Strategy-Games.php">Strategy Gaming</a>
    <a class="button" href="../Multiplayer-Games.php">Multiplayer Gaming Online</a>
    <a class="button" href="../FPS-Games.php">FPS Gaming</a>
    <a class="button" href="../Car-Games.php">Car Racing Gaming</a>
    <a class="button" href="../Card-Games.php">Card Racing Gaming</a>
</div>
<br><br><br>

</div>
<footer id="gradient" class="footer2">
  <span class="alignLeft">© 2019-2024 MM's Gaming Community LLC. All Rights Reserved.</span><span class="alignRight"><a href="../sitemap.xml">Sitemap</a> | <a href="../terms.html">Terms & Conditions</a> | <a href="../privacyPolicy.html">Privacy Policy</a> | <a href="../contactform.htm">Contact Me!</a></span>
</footer>
</div>
  </body>
  
<?php
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    // Guest: safe defaults for the (hidden) points bar, avoids division by zero
    $total = 100; $totalPoints = 0; $points = 0;
} else {
    echo "<script type='text/javascript'>
  var info = {
    Gamer   : '$username',
    Rank    : '$rank',
    Points  : '$points',
    PntCount: " . progress_for($totalPoints, $total)['count'] . ",
    Total   : " . progress_for($totalPoints, $total)['goal'] . ",
    Prog    : " . progress_for($totalPoints, $total)['percent'] . ',
    Perc    : function(){return this.Prog;}
  };

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

    </script>';
}
?>
</html>
