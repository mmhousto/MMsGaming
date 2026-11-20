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

$ot = "SELECT ownTrail FROM custom WHERE UID = '$id'";
$result1 = mysqli_query($link, $ot);
while($row = mysqli_fetch_assoc($result1)) {
	$ownTrail = $row["ownTrail"];
}

$tc = "SELECT Trail FROM custom WHERE UID = '$id'";
$result2 = mysqli_query($link, $tc);
while($row = mysqli_fetch_assoc($result2)) {
	$TrailC = $row["Trail"];
}

if ($ownTrail == 1) {
	echo $TrailC;
} 	else {
	echo 'none';
}

	


?>