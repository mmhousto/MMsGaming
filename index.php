<?php
// Initialize the session
session_start();   
include "config.php";                                             
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
$username = $_SESSION['username'];
$rank = $_SESSION['rank'];
$totalPoints = $_SESSION['totalPoints'];//"SELECT points FROM users WHERE username = $username";
if($totalPoints < 100){
    $rank = "Noob";
    $total = 100;
} else if($totalPoints < 200){                            
    $rank = "Novice";
    $total = 200;
} else if($totalPoints < 400){
    $rank = "Experienced";
    $total = 400;
} else if($totalPoints < 800){
    $rank = "Specialist";
    $total = 800;
} else if($totalPoints < 1600){
    $rank = "Expert";
    $total = 1600;
} else if($totalPoints < 3200){
    $rank = "Bada**";
    $total = 3200;
} else if($totalPoints < 6400){
    $rank = "Noble";
    $total = 6400;
} else if($totalPoints < 12800){
    $rank = "Spartan";
    $total = 12800;
} else if($totalPoints < 25600){
    $rank = "Legend";
    $total = 25600;
} else if($totalPoints < 52000){
    $rank = "Godsent";
    $total = 52000;
} else {
    $rank = "Holy shit get a life!";
    $total = 104000;
}    

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
    <title>MM's Gaming Co.</title>
    <link rel="shortcut icon" href="favicon2.ico" type="image/x-icon">
	<link rel="icon" href="favicon2.ico" type="image/x-icon">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    

</head>

<style type="text/css">
	html{
  height: 100%;
  font-family: Arial;
}

body {
  background-color: #38b6ff;
  height: 100%;
  font-family: Arial;
}

ul {
  text-align: center;
  columns: 4;
  -webkit-columns: 4;
  -moz-columns: 4;
}

.btn-warning {
  margin-top: 3px;
}

.btn-danger {
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
  padding: 100px 20px;
  height: 100vh;
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
  float: left;
  height: 150px;  
  width: 250px; 
  margin-left: 0px;
  padding: 12px;
}
.logo {
  float: left;
  height: 150px; 
  width: 300px; 
  margin-left: 550px;
  margin-bottom: -20px;
}

#info-logo {float: center; display: inline; height: 150px; width: 550px;}
#tabs {height: 100vh;}
#Home {background-color: yellow;}
#MyGames {background-color: green;}
#Contact {background-color: blue;}
#About {background-color: orange;}
</style>

<body>

	 	<p align="right">
          <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
          <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
    	</p>
    	
<div class="info-logo" id="info-logo">
    <div id="info" class="info">
        <h3>Gamer: <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b></h3>
        <h4>Rank: <?php echo htmlspecialchars($rank); ?></h4>
        <h4>Points: <?php echo htmlspecialchars($_SESSION["points"]); ?></h4>
        <div class="Progress">Next Rank: <div id="pntCount" class="pointCount"><?php echo ($totalPoints - ($total/2)); ?></div>/<div id="total" class="total"><?php echo $total; ?></div>
          <div class="meter">
  			<span id="myBar" style="width: 10%"></span>
		  </div>
		</div>
    </div><br>
    <div id="logo" class="logo">
	  	<img src="MMsGCo.png" alt="MM Gaming"  height="150" width="300" vspace="5">
	</div>
</div>
	<center>
<br><br><br><br><br><br><br><br>
<button class="tablink" onclick="openPage('Home', this, 'yellow')">Home</button>
<button class="tablink" onclick="openPage('MyGames', this, 'green')" id="defaultOpen">My Games</button>
<button class="tablink" onclick="openPage('Contact', this, 'blue')">Contact</button>
<button class="tablink" onclick="openPage('About', this, 'orange')">About</button>

<div id="tabs">
<div id="Home" class="tabcontent">
  <h3><font size="+7">Play Games!</font></h3>
  	<ul class="columns" data-columns="2" style="list-style-type:none;">
  		<li><a href="RollerRider"><font size="+3">Roller Rider</font></a></li>
  		<br>
  		<li><a href="NSP"><font size="+3">New Splinter Pals</font></a></li>
  		<br>
  		<li><a href="N"><font size="+3">N</font></a></li>
  		<br>
  		<li><a href="SNM"><font size="+3">Sticky Ninja Missions</font></a></li>
  		<br>
  		<li><a href="Run"><font size="+3">Run 3</font></a></li>
  		<br>
  		<li><a href="LtFI"><font size="+3">Learn to Fly Idle</font></a></li>
  		<br>
  		<li><a href="GDTD"><font size="+3">Giants and Dwarves TD</font></a></li>
  		<br>
  		<li><a href="Divide"><font size="+3">Divide</font></a></li>
  		<br>
  		<li><a href="SB2"><font size="+3">Soccer Balls 2</font></a></li>
  		<br>
  		<li><a href="Arkandian"><font size="+3">Arkandian Explorer</font></a></li>
  		<br>
  		<li><a href="Drift"><font size="+3">Drift Runners 3D</font></a></li>
  		<br>
  		<li><a href="EffingFruits"><font size="+3">Effing Fruits</font></a></li>
  		<br>
  		<li><a href="Zomball"><font size="+3">Zomball</font></a></li>
  		<br>
  		<li><a href="NSP"><font size="+3">New Splinter Pals</font></a></li>
  		<br>
  		<li><a href="N"><font size="+3">N</font></a></li>
  		<br>
  		<li><a href="SNM"><font size="+3">Sticky Ninja Missions</font></a></li>
  		<br>
  		<li><a href="Run"><font size="+3">Run 3</font></a></li>
  		<br>
  		<li><a href="LtFI"><font size="+3">Learn to Fly Idle</font></a></li>
  		<br>
  		<li><a href="GDTD"><font size="+3">Giants and Dwarves TD</font></a></li>
  		<br>
  		<li><a href="Divide"><font size="+3">Divide</font></a></li>
  		<br>
  		<li><a href="SB2"><font size="+3">Soccer Balls 2</font></a></li>
  		<br>
  		<li><a href="Arkandian"><font size="+3">Arkandian Explorer</font></a></li>
  		<br>
  		<li><a href="Drift"><font size="+3">Drift Runners 3D</font></a></li>
  		<br>
  		<li><a href="EffingFruits"><font size="+3">Effing Fruits</font></a></li>
  		<br>
	</ul>
</div>

<div id="MyGames" class="tabcontent">
  <h3><font size="+7">These are games I have made</font></h3>
    <ol style="list-style-type:none;">
  		<li><a href="HGWK"><font size="+3">Have Gun, Will Kill<br>
  		(Assets didn't load right when converted to WebGL)</font></a></li>
	</ol>
</div>

<div id="Contact" class="tabcontent">
  <h3><font size="+7">Contact</font></h3>
  <p><font size="+3">If you want to see your game on my website contact me!<br>
  	Or for any other reason<br>
  	Email: mmhouston6@live.com<br>
  Phone: (918) 606-2038</font></p>
</div>

<div id="About" class="tabcontent">
  <h3><font size="+7">About</font></h3>
  <p><font size="+3">Gamers welcome to MM's Gaming Company!<br>
  	I have created this site for you to play free games. I Hope you enjoy!<br>
  	Game Development is my career goal. I know the following languages pretty well:<br>
  	<ul align="center" class="columns1">
  		<li>JavaScript</li>
  		<li>C/C++</li>
  		<li>C#</li>
  		<li>PHP</li>
  		<li>MySQL</li>
  		<li>HTML & CSS</li>
  	</ul>
  I am a Computer Science Major studying at Oklahoma State University - Tulsa! GO Pokes!</font></p>
  <img src="osu.png" alt="OSU"  height="250" width="450" vspace="5">
</div>

</div></center>

<script src="script.js">
</script>
<script type="text/javascript">
// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
//
//Progress Bar==========================================================================================//
function addPoints() {
  var total = document.getElementById("total");
  var elem = document.getElementById("myBar"); 
  var pnts = document.getElementById("pntCount");
  var progress = <?php echo $_SESSION['totalPoints']; ?>;
  var id = setInterval(frame, 1000);

  function frame() {
    if (progress >= total.innerHTML) {
      clearInterval(id);
      progress = 0;
      total.innerHTML = total.innerHTML * 2;
      elem.style.width = 0;
      pnts.innerHTML = 0;
      addPoints();
    } else {
      progress += 10;
      elem.style.width = progress/total.innerHTML * 100 + '%'; 
      pnts.innerHTML = progress * 1;
      <?php

      $u1 = "UPDATE users SET points = points + 10 WHERE username = '$username'";
      mysqli_query($link, $u1) or die('Error querying database.');
      $u2 = "UPDATE users SET totalPoints = totalPoints + 10 WHERE username = '$username'";
      mysqli_query($link, $u2) or die('Error querying database.');
	  ?>
    }
  }
}
addPoints();
//=========================================================================================================//
</script>


</body>

</html>