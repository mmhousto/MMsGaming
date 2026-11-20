<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
    require_once "config.php";

    $username = $_SESSION['username'];
    $id = $_SESSION['id'];
	$ownCursor = $_SESSION['ownCursor'];
	$cursor = $_SESSION['CursorC'];

$ownCursor = player_custom($link, $id ?? null)['ownCursor'];

$cursor = player_custom($link, $id ?? null)['CursorC'];

$cursor = safe_image_url($cursor);
if ($ownCursor == 1 && $cursor !== null) {
	echo "url(\"$cursor\"), auto";
} 	else {
	echo 'auto';
}

	


?>