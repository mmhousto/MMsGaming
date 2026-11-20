<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    require_once "config.php";

    $username = $_SESSION['username'];
    $id = $_SESSION['id'];
	$ownFont = $_SESSION['ownFont'];
	$font = $_SESSION['Font'];

$ownFont = player_custom($link, $id ?? null)['ownFont'];

$font = player_custom($link, $id ?? null)['Font'];

$font = safe_font_name($font);
if ($ownFont == 1 && $font !== null) {
	echo $font;
} 	else {
	echo 'arial';
}

	


?>