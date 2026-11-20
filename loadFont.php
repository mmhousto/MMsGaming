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

$of = "SELECT ownFont FROM custom WHERE UID = ?";
$result1 = db_query($link, $of, [$id]);
while($row = mysqli_fetch_assoc($result1)) {
	$ownFont = $row["ownFont"];
}

$f = "SELECT Font FROM custom WHERE UID = ?";
$result2 = db_query($link, $f, [$id]);
while($row = mysqli_fetch_assoc($result2)) {
	$font = $row["Font"];
}

$font = safe_font_name($font);
if ($ownFont == 1 && $font !== null) {
	echo $font;
} 	else {
	echo 'arial';
}

	


?>