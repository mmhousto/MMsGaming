<?php
    session_start(); 
    require_once "config.php";

    $username = $_SESSION['username'];
    $bgColor = $_SESSION['BgColor'];   
    $id = $_SESSION['id']; 
	$color = "$_POST[box2]";
	$ownBg = $_SESSION['ownBg'];
	$lastSet = $_SESSION['lastSet'];

$ls = "SELECT lastSet FROM custom WHERE UID = '$id'";
$result1 = mysqli_query($link, $ls);
while($row = mysqli_fetch_assoc($result1)) {
	$lastSet = $row["lastSet"];
}

$ob = "SELECT ownBg FROM custom WHERE UID = '$id'";
$result2 = mysqli_query($link, $ob);
while($row = mysqli_fetch_assoc($result2)) {
	$ownBg = $row["ownBg"];
}

if ($ownBg == 1) {
$sql = "UPDATE custom SET BgColor = '$_POST[box2]' WHERE UID = '$id'";
mysqli_query($link, $sql) or die('Error querying database.');
$sql2 = "UPDATE custom SET lastSet = 'Background' WHERE UID = '$id'";
mysqli_query($link, $sql2) or die('Error querying database.');
header("location: index.php");
} else {
	echo '<script type="text/javascript"> alert("You Do Not Own Background Color!"); </script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
}

?>