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

$of = "SELECT ownFont FROM custom WHERE UID = '$id'";
$result1 = mysqli_query($link, $of);
while($row = mysqli_fetch_assoc($result1)) {
	$ownFont = $row["ownFont"];
}

$f = "SELECT Font FROM custom WHERE UID = '$id'";
$result2 = mysqli_query($link, $f);
while($row = mysqli_fetch_assoc($result2)) {
	$font = $row["Font"];
}

if ($ownFont == 1) {
	echo $font;
} 	else {
	echo 'arial';
}

	


?>