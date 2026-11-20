<?php
// Initialize the session
session_start();   
require_once "config.php";                                             
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
}

$username = $_SESSION['username'];

echo'<br><br><center><a href="index.php"><img src="MMsGCoo.png" alt="MM Gaming"  height="150" width="400" vspace="10"></a><br><br>';
echo"<table border='2' style='width:75%' id='myTable'>";
echo"<tr><td style='padding: 10px; font-size:48px'>#</td><td style='padding: 10px; font-size:48px'>Username</td><td style='padding: 10px; font-size:48px; width:25%'>Points</td><td style='padding: 10px; font-size:48px'>Rank</td></tr>";
$u = "SELECT username, totalPoints, rank FROM users ORDER BY totalPoints DESC";
$result1 = mysqli_query($link, $u);//"SELECT points FROM users WHERE username = $username";
while($row = mysqli_fetch_assoc($result1)) {
	$users = $row["username"];
	$totalPoints = $row["totalPoints"];
  $rank = $row["rank"];
	if($username === $users){
	echo"<tr><td class='counterCell' style='padding: 10px; font-size:48px'></td><td style='padding: 10px; font-size:48px'><b>{$users}</b></td><td style='padding: 10px; font-size:48px'><b>{$totalPoints}</b></td><td style='padding: 10px; font-size:48px'><b>{$rank}</b></td></tr>\n";
	}else {
	echo"<tr><td class='counterCell' style='padding: 10px; font-size:48px'></td><td style='padding: 10px; font-size:48px'>{$users}</td><td style='padding: 10px; font-size:48px'>{$totalPoints}</td><td style='padding: 10px; font-size:48px'>{$rank}</td></tr>\n";
	}
}
echo"</table>";
echo"</center>";

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1"> <!-- Ensures optimal rendering on mobile devices. -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->

    <title>MM's Gaming Co.</title>
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <script data-ad-client="ca-pub-8251399081266327" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <script src="mouse.js" type="text/javascript"></script>
    <script src="select.js" type="text/javascript"></script>
    <script src="layout.js" type="text/javascript"></script>
    <script src="jquery.js" type="text/javascript"> </script>
    <script  type="text/javascript">
    	window.onload = function () {
    notPlaying();
};
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
  overflow: auto;
}

table {
    counter-reset: tableCount;     
}
.counterCell:before {              
    content: counter(tableCount); 
    counter-increment: tableCount; 
}

td {
  position: relative;
  word-wrap: normal;
  text-align: left;
  vertical-align: center;
  font-size: 48px;
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

<link rel="stylesheet" type="text/css" href="footer.css" />

<body style="background-color: <?php include "loadBg.php"; ?>;">
<div id="page-container">
   <div id="content-wrap">
    
  <div id="trail" class="trail" style="disa">
    <div class="pointer pointer1"></div>
    <div class="pointer pointer2"></div>
    <div class="pointer pointer3"></div>
    <div class="pointer pointer4"></div>
    <div class="pointer pointer5"></div>
  </div>

</div>
<footer id="gradient" class="footer">
  <span class="alignLeft">MM's Gaming Co © 2019-2020. All Rights Reserved.</span><span class="alignRight"><a href="sitemap.xml">Sitemap</a> | <a href="terms.html">Terms & Conditions</a> | <a href="privacyPolicy.html">Privacy Policy</a> | <a href="contactform.htm">Contact Me!</a></span>
  </footer>
</div>
</body>

</html>