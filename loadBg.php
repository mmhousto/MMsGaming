<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    require_once "config.php";

    $username = $_SESSION['username'];
    $bgColor = $_SESSION['BgColor']; 
    $bgImg = $_SESSION['BgImg'];  
    $id = $_SESSION['id'];
	$ownBg = $_SESSION['ownBg'];
	$ownImg = $_SESSION['ownImg'];
	$lastSet = $_SESSION['lastSet'];

$ls = "SELECT lastSet FROM custom WHERE UID = '$id'";
$result1 = mysqli_query($link, $ls);
while($row = mysqli_fetch_assoc($result1)) {
	$lastSet = $row["lastSet"];
}

$bg = "SELECT BgColor FROM custom WHERE UID = '$id'";
$result3 = mysqli_query($link, $bg);
while($row = mysqli_fetch_assoc($result3)) {
	$bgColor = $row["BgColor"];
}

$bgi = "SELECT BgImg FROM custom WHERE UID = '$id'";
$result4 = mysqli_query($link, $bgi);
while($row = mysqli_fetch_assoc($result4)) {
	$bgImg = $row["BgImg"];
}

$ob = "SELECT ownBg FROM custom WHERE UID = '$id'";
$result2 = mysqli_query($link, $ob);
while($row = mysqli_fetch_assoc($result2)) {
	$ownBg = $row["ownBg"];
}

$oi = "SELECT ownImg FROM custom WHERE UID = '$id'";
$result5 = mysqli_query($link, $oi);
while($row = mysqli_fetch_assoc($result5)) {
	$ownImg = $row["ownImg"];
}

if ($ownBg == 1 && $lastSet == "Background") {
	echo $bgColor."; background-image: none";
} else if ($ownImg == 1 && $lastSet == "Image") {
	echo "none ; background-image: url($bgImg) !important";
} else {
	echo '#38b6ff';
}

	


?>