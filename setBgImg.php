<?php
    session_start(); 
    require_once "config.php";

    $username = $_SESSION['username'];
    $bgImg = $_SESSION['BgImg'];   
    $id = $_SESSION['id']; 
	$image = "$_POST[image]";
	$ownImg = $_SESSION['ownImg'];
	$lastSet = $_SESSION['lastSet'];

$ls = "SELECT lastSet FROM custom WHERE UID = '$id'";
$result1 = mysqli_query($link, $ls);
while($row = mysqli_fetch_assoc($result1)) {
	$lastSet = $row["lastSet"];
}

$oi = "SELECT ownImg FROM custom WHERE UID = '$id'";
$result2 = mysqli_query($link, $oi);
while($row = mysqli_fetch_assoc($result2)) {
	$ownImg = $row["ownImg"];
}
if ($ownImg == 1) {
$sql = "UPDATE custom SET BgImg = '$_POST[image]' WHERE UID = '$id'";
mysqli_query($link, $sql) or die('Error querying database.');
$sql2 = "UPDATE custom SET lastSet = 'Image' WHERE UID = '$id'";
mysqli_query($link, $sql2) or die('Error querying database.');
header("location: index.php");
} else {
	echo '<script type="text/javascript"> alert("You Do Not Own Background Image, get GOOD!"); </script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
}

?>