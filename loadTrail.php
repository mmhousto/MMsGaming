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

$ot = "SELECT ownTrail FROM custom WHERE UID = ?";
$result1 = db_query($link, $ot, [$id]);
while($row = mysqli_fetch_assoc($result1)) {
	$ownTrail = $row["ownTrail"];
}

$tc = "SELECT Trail FROM custom WHERE UID = ?";
$result2 = db_query($link, $tc, [$id]);
while($row = mysqli_fetch_assoc($result2)) {
	$TrailC = $row["Trail"];
}

$TrailC = safe_css_color($TrailC);
if ($ownTrail == 1 && $TrailC !== null) {
	echo $TrailC;
} 	else {
	echo 'none';
}

	


?>