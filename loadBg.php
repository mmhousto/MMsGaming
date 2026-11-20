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

$lastSet = player_custom($link, $id ?? null)['lastSet'];

$bgColor = player_custom($link, $id ?? null)['BgColor'];

$bgImg = player_custom($link, $id ?? null)['BgImg'];

$ownBg = player_custom($link, $id ?? null)['ownBg'];

$ownImg = player_custom($link, $id ?? null)['ownImg'];

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