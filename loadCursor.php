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

$oc = "SELECT ownCursor FROM custom WHERE UID = '$id'";
$result1 = mysqli_query($link, $oc);
while($row = mysqli_fetch_assoc($result1)) {
	$ownCursor = $row["ownCursor"];
}

$cr = "SELECT CursorC FROM custom WHERE UID = '$id'";
$result2 = mysqli_query($link, $cr);
while($row = mysqli_fetch_assoc($result2)) {
	$cursor = $row["CursorC"];
}

if ($ownCursor == 1) {
	echo "url($cursor), auto";
} 	else {
	echo 'auto';
}

	


?>