<?php
    session_start(); 
    require_once "config.php";

    $username = $_SESSION['username'];
    $font = $_SESSION['Font'];   
    $id = $_SESSION['id']; 
	$ownFont = $_SESSION['ownFont'];

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
$sql = "UPDATE custom SET Font = '$_POST[myFont]' WHERE UID = '$id'";
mysqli_query($link, $sql) or die('Error querying database.');
header("location: index.php");
} else {
	echo '<script type="text/javascript"> alert("You Do Not Own Fonts, keep earning points!"); </script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
}

?>