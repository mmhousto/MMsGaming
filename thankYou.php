<?php
// Initialize the session
if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

require_once "config.php";               


// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

    $username = $_SESSION['username'];
    $id = $_SESSION['id'];
    $points = $_SESSION['points'];
    $isDonor = $_SESSION['Donor'];
    $pointsRecieved = "";

      $p = "SELECT points FROM users WHERE username = '$username'";
  $result1 = mysqli_query($link, $p);//"SELECT points FROM users WHERE username = $username";
  while($row = mysqli_fetch_assoc($result1)) {
    $points = $row["points"];
  }
  $isD = "SELECT Donor FROM custom WHERE UID = '$id'";
  $result2 = mysqli_query($link, $isD);//"SELECT points FROM users WHERE username = $username";
  while($row = mysqli_fetch_assoc($result2)) {
    $isDonor = $row["Donor"];
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
    $rank = "Godsent";
    $total = 52000;
    $sql1 = "UPDATE users SET rank = '$rank' WHERE username = '$username'";
        mysqli_query($link, $sql1);
} else {
    $rank = "Holy shit get a life!";
    $total = 104000;
    $sql1 = "UPDATE users SET rank = '$rank' WHERE username = '$username'";
        mysqli_query($link, $sql1);
}    


?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->
	
    <title>MM's Gaming Co.</title>
    
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="mouse.js" type="text/javascript"></script>
    <script src="select.js" type="text/javascript"></script>
    <script src="layout.js" type="text/javascript"></script>
    <script src="jquery.js" type="text/javascript"> </script>

	
    <script type="text/javascript">

    </script>
    <script src="script.js" type="text/javascript">
    	window.onload = function () {
    
};
    </script>

</head>

<style type="text/css">
html{
  height: 100%;
  margin: 0;
  font-family: Arial;
  overflow: hidden;
}
body {
  cursor: <?php include 'loadCursor.php'; ?>;
  background-color: #38b6ff;
  height: 100%;
  margin: 0;
  font-family: Arial;
  overflow: auto;
}
.btn-warning {
  margin-top: 3px;
}

.btn-danger {
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
  position: relative;
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
  vertical-align: right;
}
.logo {
  display: inline;
  vertical-align: middle;
  height: 150px; 
  width: 350px; 
  margin-bottom: -20px;
  margin-left: -275px;
}

.pointer {
  position: absolute;
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

span { 
    background-color: white;
    font-size: 32px;
}
span2 {
    background-color: white;
    font-size: 52px;
}

#logo {float: center;}

#info-logo {float: left; display: inline; height: 150px; width: 100%;}

#sep {border-bottom: dashed; border-width: 5px;}

.footer {
            display: block;
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
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

<body style="background-color: <?php include "loadBg.php"; ?>;">

  <div id="trail" class="trail" style="disa">
    <div class="pointer pointer1"></div>
    <div class="pointer pointer2"></div>
    <div class="pointer pointer3"></div>
    <div class="pointer pointer4"></div>
    <div class="pointer pointer5"></div>
  </div>

<div class="heading">
      <p align="right">
          <a href="reset-password.php" class="btn btn-warning">Reset Your Password</a>
          <a href="logout.php" class="btn btn-danger">Sign Out of Your Account</a>
      </p>
      
<div class="info-logo" id="info-logo">
    <div id="info" class="info">
        <h3>Gamer: <b><div id="Gamer" class="pointCount"><?php echo htmlspecialchars($username); ?></div></b></h3>
        <h4>Rank: <div id="Rank" class="pointCount"><?php echo htmlspecialchars($rank); ?></div></h4>
        <h4>Points: <div id="points" class="pointCount"><?php echo $points; ?></div></h4>
        
    </div><br>
    <center>
      <div id="logo" class="logo" align="center">
        <a href="index.php"><img src="MMsGCoo.png" alt="MM Gaming"  height="150" width="400" vspace="10"></a>
      </div>
    </center>
</div>
</div>

<br><br><br><br><br><br><br><br><br>
<div id="sep"></div>
<center>
<br><br>

	<p><span2>Thank You <?php echo $username; ?>, for your kindly donation.</span2></p><br><p><span>It really helps me continue updating and maintaining the site! <br> Expect your points to be added within 24 hours!</span></p><br><p><span style="font-size: 24px;">Since you have donated, your name will now be displayed in green,<br> on the Scoreboard, for others to see and on your account stats for you. <br>Soon I will update this to incorporate whatever color you wish for!</span></p>

</center>
<div id="gradient" class="footer">
  <span1 class="alignLeft">MM's Gaming Co © 2019-2020. All Rights Reserved.</span1><span1 class="alignRight"><a href="sitemap.xml">Sitemap</a> | <a href="terms.html">Terms & Conditions</a> | <a href="privacyPolicy.html">Privacy Policy</a> | <a href="contactform.htm">Contact Me!</a></span1>
</div>
</body>

</html>