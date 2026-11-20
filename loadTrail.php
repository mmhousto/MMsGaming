<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    require_once "config.php";

    $username = $_SESSION['username'];
    $id = $_SESSION['id'];
	$ownTrail = $_SESSION['ownTrail'];
	$TrailC = $_SESSION['Trail'];

$ownTrail = player_custom($link, $id ?? null)['ownTrail'];

$TrailC = player_custom($link, $id ?? null)['Trail'];

$TrailC = safe_css_color($TrailC);
if ($ownTrail == 1 && $TrailC !== null) {
	echo $TrailC;
} 	else {
	echo 'none';
}

	


?>