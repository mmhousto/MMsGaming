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

$ls = "SELECT lastSet FROM custom WHERE UID = ?";
$result1 = db_query($link, $ls, [$id]);
while($row = mysqli_fetch_assoc($result1)) {
	$lastSet = $row["lastSet"];
}

$bg = "SELECT BgColor FROM custom WHERE UID = ?";
$result3 = db_query($link, $bg, [$id]);
while($row = mysqli_fetch_assoc($result3)) {
	$bgColor = $row["BgColor"];
}

$bgi = "SELECT BgImg FROM custom WHERE UID = ?";
$result4 = db_query($link, $bgi, [$id]);
while($row = mysqli_fetch_assoc($result4)) {
	$bgImg = $row["BgImg"];
}

$ob = "SELECT ownBg FROM custom WHERE UID = ?";
$result2 = db_query($link, $ob, [$id]);
while($row = mysqli_fetch_assoc($result2)) {
	$ownBg = $row["ownBg"];
}

$oi = "SELECT ownImg FROM custom WHERE UID = ?";
$result5 = db_query($link, $oi, [$id]);
while($row = mysqli_fetch_assoc($result5)) {
	$ownImg = $row["ownImg"];
}

$bgColor = safe_css_color($bgColor);
$bgImg = safe_image_url($bgImg);
if ($ownBg == 1 && $lastSet == "Background" && $bgColor !== null) {
	echo $bgColor."; background-image: none";
} else if ($ownImg == 1 && $lastSet == "Image" && $bgImg !== null) {
	echo "none ; background-image: url(\"$bgImg\") !important";
} else {
	echo '#38b6ff';
}

	


?>