<?php
    session_start(); 
    require_once "config.php";

    $username = $_SESSION['username'];
    $TrailC = $_SESSION['Trail'];   
    $id = $_SESSION['id'];
	$ownTrail = $_SESSION['ownTrail'];

$tc = "SELECT Trail FROM custom WHERE UID = '$id'";
$result1 = mysqli_query($link, $tc);
while($row = mysqli_fetch_assoc($result1)) {
	$TrailC = $row["Trail"];
}

$ot = "SELECT ownTrail FROM custom WHERE UID = '$id'";
$result2 = mysqli_query($link, $ot);
while($row = mysqli_fetch_assoc($result2)) {
	$ownTrail = $row["ownTrail"];
}

if ($ownTrail == 1) {
$sql = "UPDATE custom SET Trail = '$_POST[color]' WHERE UID = '$id'";
mysqli_query($link, $sql) or die('Error querying database.');
header("location: index.php");
} else {
	echo '<script type="text/javascript"> alert("You Do Not Own the Circle Trail!"); </script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
}

?>