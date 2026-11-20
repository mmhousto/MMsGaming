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

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
    <meta name="viewport" content="width=1250, initial-scale=1"> <!-- Ensures optimal rendering on mobile devices. -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->
    <title>MM's Gaming Co.</title>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../footer.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <script src="../mouse.js" type="text/javascript"></script>
    <script src="../script.js" type="text/javascript"></script>
    <script src="../jquery.js" type="text/javascript"> </script>
    <script src="../jquery-idleTimeout-iframes.min.js" type="text/javascript"> </script>
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
  font-family: Arial;
}
.btn-warning {
  margin-top: 3px;
  margin-right: 3px;
  font-size: 16px;
}

.btn-danger {
  margin-top: 3px;
  margin-right: 3px;
  font-size: 16px;
}

.btn-success {
  font-size: 16px;
  margin-top: 3px;
  margin-right: 3px;
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

.pointer {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 40px;
  height: 40px;
  background: <?php include "../loadTrail.php";?>;
  border: 1px solid <?php include "../loadTrail.php";?>;
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

#sep {border-bottom: dashed; border-width: 5px;}

#game {
  border: dashed;
  border-width: 5px;
  width: 1020px;
  height: 655px;
  padding-top: 5px;
}
.footer {
            display: block;
            position: static;
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

<body onload="playing()" style="background-color: <?php include "../loadBg.php"; ?>;">
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
            echo '<a href="../register.php" class="btn btn-success">Sign Up!</a>&nbsp;';
            echo '<a href="../login.php" class="btn btn-warning">Login!</a>';
        } else {
         echo '<a href="../reset-password.php" class="btn btn-warning">Reset Your Password</a>&nbsp;';
         echo '<a href="../logout.php" class="btn btn-danger">Sign Out of Your Account</a>';
        }
        ?>
      </p>
    </div>     
    <div id="info" class="info">
        <h3>Gamer: <b><div id="Gamer" class="pointCount"><?php echo htmlspecialchars($username); ?></div></b></h3>
        <h4>Rank: <div id="Rank" class="pointCount"><?php echo htmlspecialchars($rank); ?></div></h4>
        <h4>Points: <div id="points" class="pointCount"><?php echo $points; ?></div></h4>
        <div class="Progress">Next Rank: <div id="pntCount" class="pointCount"><?php if($total == 100){
                                                echo $totalPoints;
                                               }else{echo ($totalPoints - ($total/2));}?> 
                                               </div>/<div id="total" class="total"><?php if($total == 100){
                                                echo $total;}else{echo ($total-($total/2));} ?></div>
          <div class="meter" id="meter">
           <span id="myBar" class="myBar" style="width: <?php if($total == 100){echo $totalPoints;}
            else{echo ((($totalPoints - ($total/2))/($total/2)) * 100);}?>%"></span>
          </div>
        </div>
    </div><br>
    <center>
      <div id="logo" class="logo" align="center">
        <a href="../"><img src="../MMsGCoo.png" alt="MM Gaming"  height="150" width="400" vspace="5"></a>
      </div>
    </center>
</div>

<br><br><br><br><br><br><br><br><br>
<div id="sep"></div>
<center>
<br><br>
<br>
	<p style="color:black; margin: -30px 10px 10px;"><font size="+2">GAME ON!</font></p>
	<br><br>
<div id="game" onmouseleave="stopAdding(); notPlaying();" onmouseenter="startAdding(); playing();">
  <div>
<iframe src="https://www.gameflare.com/embed/battle-royale/" frameborder="0" scrolling="no" width="1000" height="635" allowfullscreen></iframe></div>
</div>
<br>
<br>
<br>

</center>
</div>
<footer id="gradient" class="footer">
  <span class="alignLeft">MM's Gaming Co © 2019-2020. All Rights Reserved.</span><span class="alignRight"><a href="../sitemap.xml">Sitemap</a> | <a href="../terms.html">Terms & Conditions</a> | <a href="../privacyPolicy.html">Privacy Policy</a> | <a href="../contactform.htm">Contact Me!</a></span>
</footer>
</div>
</body>

<script type="text/javascript">
  var info = {
    Gamer   : "<?php echo $username;?>",
    Rank    : "<?php echo $rank;?>",
    Points  : <?php echo $points;?>,
    PntCount: <?php if($total == 100){echo $totalPoints;}else{echo ($totalPoints - ($total/2));}?>,
    Total   : <?php if($total == 100){echo $total;}else{echo ($total-($total/2));}?>,
    Prog    : <?php if($total == 100){echo $totalPoints;}
                    else{echo ((($totalPoints - ($total/2))/($total/2)) * 100);}?>,
    Perc    : function(){return this.Prog;}
  };
//=========================================================================================================//
//set Points===============================================================================================//
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
      pnts.innerHTML = $('#pntCount').load('../addPoints.php', 'info.PntCount');
      gamer.innerHTML = $('#Gamer').load('../gamer.php', 'info.Gamer');
      rank.innerHTML = $('#Rank').load('../rank.php', 'info.Rank');
      points.innerHTML = $('#points').load('../points.php', 'info.Points');
      total.innerHTML = $('#total').load('../total.php', 'info.Total');
      progress = (progress/total.innerHTML)* 100;
      percent = info.Perc;
      perc = $(".myBar").load('../Bar.php', 'info.Perc');
      elem = $(".meter").load('../Bar.php', 'info.Prog');
      
      

    }
}
var isPlaying;
var idleTime = 0;
var idle;

function playing() {
  clearInterval(idle)
  idleTime = 0;
  isPlaying = true;
}
function notPlaying() {
  var idle = setInterval(timerIncrement, 60000); // 1 minute
  isPlaying = false;
}

if (isPlaying == false) {
  clearInterval(id);
}

$(document).onmousemove = function(){
  clearTimeout(idle);
  idle = setInterval(timerIncrement, 60000);
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

$(document).ready(function() {

});
    </script>

</html>