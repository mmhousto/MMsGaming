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
  $bgColor = $_POST['box2'];
}
if (isset($_GET['image'])){
    $bgImg = $_GET['image'];
}

$ot = "SELECT ownTrail FROM custom WHERE UID = '$id'";
$result4 = mysqli_query($link, $ot);
while($row = mysqli_fetch_assoc($result4)) {
  $ownTrail = $row["ownTrail"];
}

$oi = "SELECT ownImg FROM custom WHERE UID = '$id'";
$result3 = mysqli_query($link, $oi);
while($row = mysqli_fetch_assoc($result3)) {
  $ownImg = $row["ownImg"];
}

$ob = "SELECT ownBg FROM custom WHERE UID = '$id'";
$result2 = mysqli_query($link, $ob);
while($row = mysqli_fetch_assoc($result2)) {
  $ownBg = $row["ownBg"];
}

$oc = "SELECT ownCursor FROM custom WHERE UID = '$id'";
$result5 = mysqli_query($link, $oc);
while($row = mysqli_fetch_assoc($result5)) {
  $ownCursor = $row["ownCursor"];
}

$bgC = "SELECT BgColor FROM custom WHERE UID = '$id'";

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
} else if($totalPoints >= 25600 && $totalPoints < 52000){
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
    $rank = "Holy Shit, Get a Life!";
    $total = 208000;
    $sql1 = "UPDATE users SET rank = '$rank' WHERE username = '$username'";
        mysqli_query($link, $sql1);
}  

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
	<meta charset="UTF-8">
  <meta name="viewport" content="width=1250, initial-scale=1"> <!-- Ensures optimal rendering on mobile devices. -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->

    <title>MM's Gaming Co.</title>
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="mouse.js" type="text/javascript"></script>
    <script src="layout.js" type="text/javascript"></script>
    <script src="jquery.js" type="text/javascript"></script>
    <script data-ad-client="ca-pub-8251399081266327" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    
   

    <script type="text/javascript">
function startTab() {
    document.getElementById("defaultOpen").click();
}

function setTrail() {
  if (<?php echo $ownTrail = 0; ?>) {
    $('#circleBuy').prop('disabled', true);
    $('#circleSelect').prop('disabled', false );
  } else {
    $('.trail').css("display", "none");
    $('#circleBuy').prop('disabled', false);
    $('#circleSelect').prop('disabled', true );
  }
}

function setBg() {
  if ( <?php echo $ownBg = 0; ?>) {
    $('#bgBuy').prop('disabled', true);
    $('#bgSelect').prop('disabled', false );
  } else {
    $('#bgBuy').prop('disabled', false);
    $('#bgSelect').prop('disabled', true );
  }
}

function setImg() {
  if ( <?php echo $ownImg = 0; ?>) {
    $('#bgImgBuy').prop('disabled', true);
    $('#bgImgSelect').prop('disabled', false );
  } else {
    $('#bgImgBuy').prop('disabled', false);
    $('#bgImgSelect').prop('disabled', true );
  }
}

function setCursor() {
  if ( <?php echo $ownCursor = 0; ?>) {
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
};

//=========================================================================================================//
</script>



</head>

<style type="text/css">
	html{
  height: 100%;
  font-family: Arial;
  overflow: hidden;
}

body {
  cursor: <?php include 'loadCursor.php'; ?>;
  background-color: #38b6ff;
  height: 100%;
  font-family: Arial;
  background-image: none;
  overflow: auto;
  overflow-x:hidden;
  overflow-y:scroll;
}

ul {
  text-align: center;
  columns: 4;
  -webkit-columns: 4;
  -moz-columns: 4;
}

.btn-warning {
  margin-top: 3px;
  margin-right: 3px;
  font-size: 18px;
}

.btn-danger {
  margin-top: 3px;
  margin-right: 3px;
  font-size: 18px;
}

.btn-success {
  font-size: 18px;
  margin-top: 3px;
  margin-right: 3px;
}

/* Style tab links */
.tablink {
  background-color: #555;
  color: black;
  float: left;
  border: solid black 1px;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  font-size: 17px;
  width: 25%;
}

.tablink:hover {
  background-color: #777;
  color: white;
}

/* Style the tab content (and add height:100% for full page content) */
.tabcontent {
  color: black;
  display: left;
  padding: 50px 20px;
  height: 100vh;
  overflow: hidden;
}

.columns{
    float: center;
    position: relative;
    margin-right: 20px;
}

.columns1{
    float: center;
    position: relative;
    margin-left: 0;
    margin-right: 0;
    padding-left: 275px;
}

.meter { 
	margin-left: -2px;
	margin-top: 2px;
	height: 26px;  /* Can be anything */
	position: relative;
	background: #555;
	-moz-border-radius: 25px;
	-webkit-border-radius: 25px;
	border-radius: 25px;
	padding: 3px;
	box-shadow: inset 0 -1px 1px rgba(255,255,255,0.3);
}

.meter > span {
  display: block;
  height: 100%;
  border-top-right-radius: 20px;
  border-bottom-right-radius: 20px;
  border-top-left-radius: 20px;
  border-bottom-left-radius: 20px;
  background-color: rgb(43,194,83);
  background-image: linear-gradient(
    center bottom,
    rgb(43,194,83) 37%,
    rgb(84,240,84) 69%
  );
  box-shadow: 
    inset 0 2px 9px  rgba(255,255,255,0.3),
    inset 0 -2px 6px rgba(0,0,0,0.4);
  position: relative;
  overflow: hidden;
}

.meter > span:after {
  content: "";
  position: absolute;
  top: 0; left: 0; bottom: 0; right: 0;
  background-image: linear-gradient(
    -45deg, 
    rgba(255, 255, 255, .2) 25%, 
    transparent 25%, 
    transparent 50%, 
    rgba(255, 255, 255, .2) 50%, 
    rgba(255, 255, 255, .2) 75%, 
    transparent 75%, 
    transparent
  );
  z-index: 1;
  background-size: 50px 50px;
  animation: move 2s linear infinite;
  border-top-right-radius: 20px;
  border-bottom-right-radius: 20px;
  border-top-left-radius: 20px;
  border-bottom-left-radius: 20px;
  overflow: hidden;
}

.heading {
    width: 445px;
    position: relative;
  float: right;
  padding: 3px;
  display: inline;
  vertical-align: right;
}

.pointCount {
  display: inline-block;
}

.total {
  display: inline-block;
}

.Progress {
  margin-bottom: -10px;
}

.info {
  display: inline;
  float: left;
  height: 150px;  
  width: 275px; 
  margin-left: 0px;
  padding: 12px;
  vertical-align: left;
}
.logo {
  display: inline;
  vertical-align: middle;
  height: 150px; 
  width: 350px; 
  margin-bottom: -20px;
  margin-left: 150px;
}

.selection {
  position: relative;
  padding: 2px;
}

input { margin-bottom: 10px; }

.select-items {
  width: 20px;
  height: 10px;
}
.pointer {
  position: fixed;
  display: block;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 40px;
  height: 40px;
  background: <?php include "loadTrail.php";?>;
  border: 1px solid <?php include "loadTrail.php";?>;
  opacity: 0.4;
  border-radius: 50%;
  pointer-events: none;
  box-sizing: border-box;
}

.pointer1{
  transition: 0.05s;
}

.pointer2{
  transition: 0.10s;
  width: 35px;
  height: 35px;
}

.pointer3{
  transition: 0.15s;
  width: 30px;
  height: 30px;
}

.pointer4{
  transition: 0.20s;
  width: 25px;
  height: 25px;
}

.pointer5{
  transition: 0.25s;
  width: 20px;
  height: 20px;
}

#logo {float: center;} 

#info-logo {float: left; display: inline; height: 150px; width: 100%;}
#tabs {height: 100vh;}
#Home {background-color: yellow; height: 300vh;}
#MyGames {background-color: green;}
#Store {background-color: cyan;}
#About {background-color: orange; height: 175vh;}

#myStore {
  height: 25%; 
  width: 75%; 
  table-layout: fixed;
}

td {
  position: relative;
  word-wrap: break-word;
  text-align: center;
  vertical-align: top;
  font-size: 24px;
}
#page-container {
  position: relative;
  min-height: 100%;
}

#content-wrap {
  padding-bottom: 3rem;    /* Footer height */
}
.footer {
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

</style>

<?php
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    echo '<style type="text/css">.info{display: none;} .logo{margin-left:445px;}</style>';
} else {
}
?>
<body id="body" style="background-color: <?php include "loadBg.php"; ?>;">
    
<div id="page-container">
   <div id="content-wrap">
  <div id="trail" class="trail" style="disa">
    <div class="pointer pointer1"></div>
    <div class="pointer pointer2"></div>
    <div class="pointer pointer3"></div>
    <div class="pointer pointer4"></div>
    <div class="pointer pointer5"></div>
  </div>
    	
    <div class="info-logo" id="info-logo">
        <div class="heading">
	 	<p align="right">
	 	<?php
        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
            echo '<a href="register.php" class="btn btn-success" style="width: 125px;">Sign Up!</a>&nbsp;';
            echo '<a href="../login.php" class="btn btn-warning" style="width: 125px;">Login!</a>';
        } else {
         echo '<a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>&nbsp;';
         echo '<a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>';
        }
        ?>

    	</p>
</div>
        <div id="info" class="info">
        <h3>Gamer: <b><?php echo htmlspecialchars($username); ?></b></h3>
        <h4>Rank: <?php echo htmlspecialchars($rank); ?></h4>
        <h4>Points: <div id="points" class="pointCount"><?php echo $points; ?></div></h4>
        <div class="Progress">Next Rank: <div id="pntCount" class="pointCount"><?php if($total == 100){
        																				echo $totalPoints;
        																			 }else{echo ($totalPoints - ($total/2));}?>	
        																			 </div>/<div id="total" class="total"><?php if($total == 100){
        																				echo $total;}else{echo ($total-($total/2));} ?></div>
          <div class="meter">
  			<span id="myBar" style="width: <?php if($total == 100){echo $totalPoints;}
  				else{echo ((($totalPoints - ($total/2))/($total/2)) * 100);}?>%"></span>
		      </div>
		    </div>
        </div><br>
        <center>
        <div id="logo" class="logo" align="center">
	  	<img src="MMsGCoo.png" alt="MM Gaming"  height="150" width="400" vspace="5">
	    </div>
        </center>
    </div>
<br>

	<center>
<br><br><br><br><br><br><br><br>
<button class="tablink" onclick="openPage('Home', this, 'yellow')"><b>Home</b></button>
<button class="tablink" onclick="openPage('MyGames', this, 'green')" id="//defaultOpen"><b>My Games</b></button>
<button class="tablink" onclick="openPage('Store', this, 'cyan')"><b>Store</b></button>
<button class="tablink" onclick="openPage('About', this, 'orange')"><b>About</b></button>

<div id="tabs">
<div id="Home" class="tabcontent">
      <a href="Scoreboard.php" target="popup" onclick="window.open('Scoreboard.php', 'popup', 'width=1000, height=1000'); return false;"><font size="+3">Scoreboard</a></font>
  <h3><font size="+7">Play Games & Earn Points!</font></h3>
  <p><font size="+2">The points you earn can be used in the store to buy items to customize the site your way.<br>You can change the background color or add an image, as well as purchase a trail or custom cursor!<br>Note: You MUST be actively playing to earn points!</font></p>
  	<ul class="columns" data-columns="2" style="list-style-type:none;">
      <li><a href="Krunker"><img src="Krunker.jpg"><br><font size="+3">Krunker.io</font></a></li>
      <br>
      <li><a href="Krew"><img src="Krew.png"><br><font size="+3">Krew.io</font></a></li>
      <br>
      <li><a href="WinterClash"><img src="WinterClash.jpg"><br><font size="+3">Winter Clash 3D</font></a></li>
      <br>
  		<li><a href="SA2"><img src="SA2.jpg"><br><font size="+3">Soldier Attack 2</font></a></li>
  		<br>
  		<li><a href="Pinball"><img src="Pinball.jpg"><br><font size="+3">Pinball</font></a></li>
  		<br>
  		<li><a href="NeonJump"><img src="NeonJump.jpg"><br><font size="+3">Neon Jump</font></a></li>
  		<br>
  		<li><a href="UNO"><img src="UNO.jpg"><br><font size="+3">UNO Online</font></a></li>
  		<br>
  		<li><a href="Slither"><img src="Slither.jpg"><br><font size="+3">Slither.io</font></a></li>
  		<br>
  		<li><a href="Minecraft"><img src="Minecraft.jpg"><br><font size="+3">Paper Minecraft</font></a></li>
  		<br>
  		<li><a href="Survivio"><img src="Survivio.jpg"><br><font size="+3">Surviv.io</font></a></li>
  		<br>
  		<li><a href="LA2"><img src="LA2.png"><br><font size="+3">Little Alchemy 2</font></a></li>
  		<br>
  		<li><a href="Cats"><img src="Cats.jpg"><br><font size="+3">Cats 1010</font></a></li>
      <br>
  		<li><a href="CartoonStrike"><img src="CartoonStrike.png"><br><font size="+3">Cartoon Strike</font></a></li>
  		<br>
  		<li><a href="8Ball"><img src="8Ball.jpg"><br><font size="+3">8 Ball Pool Multiplayer</font></a></li>
  		<br>
  		<li><a href="SBK2"><img src="SBK2.jpg"><br><font size="+3">Super Buddy Kick 2</font></a></li>
  		<br>
  		<li><a href="AngryBirds"><img src="AngryBirds.jpg"><br><font size="+3">Angry Birds</font></a></li>
  		<br>
  		<li><a href="SuperBowmasters"><img src="SuperBowmasters.jpg"><br><font size="+3">Super Bowmasters</font></a></li>
  		<br>
  		<li><a href="BattleRoyale"><img src="BattleRoyale.jpg"><br><font size="+3">Battle Royale</font></a></li>
  		<br>
  		<li><a href="Hide"><img src="Hide.jpg"><br><font size="+3">Hide Online</font></a></li>
  		<br>
  		<li><a href="CityTycoon"><img src="CityTycoon.jpg"><br><font size="+3">City Tycoon</font></a></li>
  		<br>
  		<li><a href="FlyWings"><img src="FlyWings.jpg"><br><font size="+3">Flight Simulator - FlyWings 2016</font></a></li>
  		<br>
  		<li><a href="Madalin"><img src="Madalin.jpg"><br><font size="+3">Madalin Stunt Cars 2</font></a></li>
  		<br>
  		<li><a href="CoV"><img src="CoV.jpg"><br><font size="+3">Clash of Vikings</font></a></li>
  		<br>
      <li><a href="SwordHit"><img src="swordHit.jpg"><br><font size="+3">Sword Hit</font></a></li>
      <br>
	</ul>
	<h3><font size="+4">See a HTML5 game not on here you would love to play?</font></h3><br>
	<p><font size="+2">Send me an email through my <a href="contactform.htm">contact page</a> for ease of access or email me directly at:<br>morgan.houston@mms-gaming.com<br>I will add it as soon as I get a chance!</font></p>

</div>

<div id="MyGames" class="tabcontent">
  <h3><font size="+7">These are games I have made/worked on</font></h3>
    <ol style="list-style-type:none;">
  		<li><a href="HGWK"><font size="+3">Have Gun, Will Kill<br>
  		(Assets didn't load right when converted to WebGL)</font></a></li>
	</ol>
	<p><font size="+2">***Will be updating HGWK soon to display all enemies and buttons so you can actually play the game***</font></p>
	<p><font size="+2">Have Gun, Will Kill was my first game developed in the Unity Engine. It was a group project I worked on while I attended Rogers State University, in Claremore. I learned a lot about Unity, but due to school and work I have not had much time to work on games. During this summer I plan to create a few new titles with Unity and upload them to my site!<br><br>If you have a good idea for a game and are passionate about Game Development <a href="contactform">contact me!</a></font></p>
	
</div>

<div id="Store" class="tabcontent">
  <h3><font size="+7">Welcome to my store!</font></h3>
  <table border='2' style='width:75%, height: 10px;' id='myStore'>
    <tr>
      <td style='padding: 20px'>Colored Background<br>Cost: 2500
                        <div class="selection">
                          <form name="myForm" action="setBgColor.php" method="POST">
                            <input type="text" placeholder="Enter color" id="box2" name="box2" size="6">
                            
                            <input type="submit" id="bgSelect" value="Select">
                            
                          </form>
                          <form name="myForm2" action="buyColor.php" method="POST">
                            <input type="hidden" id="own1" name="own1" value="<?php echo $ownBg;?>">
                            <input type="submit" id="bgBuy" value="Buy">
                          </form>
                        </div>
                        Click <a href="http://www.colors.commutercreative.com/grid/"  target="_blank">Here</a> For A List Of Colors!
      </td>
      <td style='padding: 20px'>Image Background<br>Cost: 5000
          <div class="selection">
              <form name="myForm" action="setBgImg.php" method="POST">
                  <input type="url" placeholder="Enter url" id="image" name="image" size="6">
                  <input type="submit" id="bgImgSelect" value="Select">
                            
              </form>
              <form name="myForm2" action="buyImg.php" method="POST">
                  <input type="hidden" id="own2" name="own2" value="<?php echo $ownImg;?>">
                  <input type="submit" id="bgImgBuy" value="Buy">
              </form>
          </div>

      </td>
      <td style='padding: 20px'>Colored Circle Trail<br>Cost: 5000
                                <span id="circlePrice"></span>
                        <div class="selection">
                          <form name="myForm" action="setTrail.php" method="POST">
                            <input type="text" placeholder="Enter color" id="color" name="color" size="6">
                            <input type="submit" id="circleSelect" value="Select">
                            
                          </form>
                          <form name="myForm3" action="buyTrail.php" method="POST">
                            <input type="hidden" id="own3" name="own3" value="<?php echo $ownTrail;?>">
                            <input type="submit" id="circleBuy" value="Buy">
                          </form>
                        </div>
      </td>
      <td style='padding: 20px'>Custom Cursor<br>Cost: 5000
          <div class="selection">
              <form name="myForm" action="setCursor.php" method="POST">
                    <input type="url" placeholder="Enter url" id="cursorC" name="cursorC" size="6">
                    <input type="submit" id="cursorSelect" value="Select">
              </form>
              <form name="myForm2" action="buyCursor.php" method="POST">
                  <input type="hidden" id="own4" name="own4" value="<?php echo $ownCursor;?>">
                    <input type="submit" id="cursorBuy" value="Buy">
              </form>
          </div>
          Click <a href="http://www.cursors-4u.com/" target="_blank">Here</a> For Custom Cursors!
      </td>
      <td style='padding: 20px'>Donate<br>Recieve: $Donated x 1000 in Points<br><br>
        <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
          <input type="hidden" name="cmd" value="_s-xclick" />
          <input type="hidden" name="hosted_button_id" value="Y9PERZA6GR25A" />
          <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" title="PayPal - The safer, easier way to pay online!" alt="Donate with PayPal button" />
          <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1" />
        </form>

      </td>
    </tr>
  </table>
  <br>
  <p><font size="+2">After playing games and accumulating a good amount of points or donating to recieve points,<br> you can buy items to customize the website any way you like. Tired of the same boring background?<br> Spice it up with vibrant colors from a long list you can choose from and even buy a trail that follows your mouse wherever it goes. Soon I will be adding more ways to customize the site, like different fonts and new trails!</font></p>

</div>

<div id="About" class="tabcontent">
  <h3><font size="+7">About Page</font></h3>
  <p><font size="+3">Gamers welcome to MM's Gaming Company!<br>
  	I have created this site for you to play free games on. You can customize the website anyway you like by buying items in the store, after gaining points by playing the games. Not only was this a fun project for me, I am using it as a portfolio to show off my work and what I can do.<br>I Hope you enjoy!<br><br>
  	Game Development is my career goal. I have been playing games my whole life and am determined to make a living off of them. I know the following languages pretty well:<br>
  	<ul align="center" class="columns1">
  		<li>JavaScript</li>
  		<li>C/C++</li>
  		<li>C#</li>
  		<li>PHP</li>
  		<li>MySQL</li>
  		<li>HTML & CSS</li>
  		<li>Swift</li>
  	</ul>
  I am a Computer Science Major studying at Oklahoma State University - Tulsa & Stillwater!<br> GO Pokes!</font></p>
  <img src="osu.png" alt="OSU"  height="250" width="450" vspace="5">
  
      <h2><font size="+5"><a href="contactform.htm">Contact Me</a></font></h2>
  <p><font size="+2" align="left">If you want to see another HTML5 game or your very own game on my website,<br> feel free to contact me by clicking the 'Contact Me' header above.<br>Then fill out the form on the next page and I will get back to you shortly...<br>I look forward to hearing from you, your feedback helps improve my website!<br></font></p>

</div>

</div></center>
</div>
<footer id="gradient" class="footer">
  <span class="alignLeft">MM's Gaming Co © 2019-2020. All Rights Reserved.</span><span class="alignRight"><a href="sitemap.xml">Sitemap</a> | <a href="terms.html">Terms & Conditions</a> | <a href="privacyPolicy.html">Privacy Policy</a> | <a href="contactform.htm">Contact Me!</a></span>
</footer>
</div>

</body>

<script type="text/javascript">
    //Column layout=====================================================================================//
var bgBuy = document.getElementById("bgBuy");
var bgSelect = document.getElementById("bgSelect");
var bgImgBuy = document.getElementById("bgImgBuy");
var bgImgSelect = document.getElementById("bgImgSelect");
var circleBuy = document.getElementById("circleBuy");
var circleSelect = document.getElementById("circleSelect");
var points = document.getElementById("points");
var bodyColor = document.getElementById("body");
</script>

<?php
        if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){

        } else {
            echo '<script type="text/javascript">';
            echo 'var custom = {';
            echo "Points  : $points,";
            echo "BgColor : $bgColor,";
            echo "Trail   : $TrailC,";
            echo "BgImg   : $bgImg,";
            echo "Cursor  : $cursor,";
            echo "Font    : $font,";
            echo "Donor   : $isDonor,";
            echo "hasTrail: $ownTrail,";
            echo "hasBg   : $ownBg,";
            echo "hasImg  : $ownImg";
            echo '}</script>';
        }
        ?>

<script type="text/javascript">

window.onload = function () {
  
}

  </script>


</html>