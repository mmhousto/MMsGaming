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

$oc = "SELECT ownCursor FROM custom WHERE UID = ?";
$result1 = db_query($link, $oc, [$id]);
while($row = mysqli_fetch_assoc($result1)) {
	$ownCursor = $row["ownCursor"];
}

$cr = "SELECT CursorC FROM custom WHERE UID = ?";
$result2 = db_query($link, $cr, [$id]);
while($row = mysqli_fetch_assoc($result2)) {
	$cursor = $row["CursorC"];
}

$cursor = safe_image_url($cursor);
if ($ownCursor == 1 && $cursor !== null) {
	echo "url(\"$cursor\"), auto";
} 	else {
	echo 'auto';
}

	


?>