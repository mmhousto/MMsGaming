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

  $isDonor = player_custom($link, $id ?? null)['Donor'];
$mmsgStats = player_stats($link, $username ?? null);
$points = $mmsgStats['points'];
$totalPoints = $mmsgStats['totalPoints'];
$rank = $mmsgStats['rank'];
$total = $mmsgStats['total'];
    


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
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->
	
    <title>Thank You for Donating to MM's Gaming Co. [Donations]</title>
    <meta name="description" content="Confirmation page, to thank you for donating to MM's Gaming Co! Donations Welcome! Anything helps!">
    
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    <link rel="canonical" href="https://mms-gaming.com/thankYou.php">
    
        <?php

$useragent=$_SERVER['HTTP_USER_AGENT'];

if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))) {
    echo '<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />';
    echo '<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>';
} else {
    echo '<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha256-pasqAKBDmFT4eHoN2ndd6lN370kFiGUFyTiUHWhU7k8=" crossorigin="anonymous"></script>';
    echo '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">';
}
?>
    
    <script src="mouse.js" type="text/javascript"></script>
    <script src="select.js" type="text/javascript"></script>

	
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
  overflow: hidden;
}
body {
  cursor: <?php include 'loadCursor.php'; ?>;
  background-color: #38b6ff;
  height: 100%;
  margin: 0;
  font-family: <?php include 'loadFont.php'; ?>;
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
        <h3><b>Donor:</b> <div id="Gamer" class="pointCount"><a href="profile.php"><?php echo htmlspecialchars($username); ?></a></div></h3>
        <h4><b>Rank:</b> <div id="Rank" class="pointCount"><?php echo htmlspecialchars($rank); ?></div></h4>
        <h4><b>Points:</b> <div id="points" class="pointCount"><?php echo $points; ?></div></h4>
        
    </div><br>
    <center>
      <div id="logo" class="logo" align="center">
        <picture>
            <source srcset="MMsGCoo.webp" type="image/webp">
            <source srcset="MMsGCoo.jp2" type="image/jp2">
	  	    <a href="index.php" ><img src="MMsGCoo.png" alt="The logo of MMs Gaming company, meant to look like a controller and the letters 'MM'" title="MMs Gaming Logo" style="max-width:100%;max-height:300px;" vspace="0"></a>
	     </picture>
      </div>
    </center>
</div>
</div>

<br><br><br><br><br><br><br><br><br>
<div id="sep"></div>
<center>
<br><br>
    <h1>Thank You For Donating</h1>
	<p><span2>Thank You <?php echo e($username); ?>, for your kindly donation.</span2></p><br><p><span>It really helps me continue updating and maintaining the site! <br> Your points are added automatically as soon as PayPal confirms the payment, usually within a few minutes.</span></p><br><p><span style="font-size: 24px;">Since you have donated, your name will now be displayed in green,<br> on the Scoreboard, for others to see and on your account stats for you. <br>Soon I will update this to incorporate whatever color you wish for!</span></p>

</center>
<div id="gradient" class="footer">
  <span1 class="alignLeft">© 2019-2024 MM's Gaming Community LLC. All Rights Reserved.</span1><span1 class="alignRight"><a href="sitemap.xml">Sitemap</a> | <a href="terms.html">Terms & Conditions</a> | <a href="privacyPolicy.html">Privacy Policy</a> | <a href="contactform.html">Contact Me!</a></span1>
</div>
</body>

</html>