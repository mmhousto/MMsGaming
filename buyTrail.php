<?php
    session_start(); 
    require_once "config.php";

    $username = $_SESSION['username'];
    $ownTrail = $_SESSION['ownTrail'];   
    $id = $_SESSION['id']; 
    $points = $_SESSION['points'];

$p = "SELECT points FROM users WHERE username = '$username'";
	$result1 = mysqli_query($link, $p);//"SELECT points FROM users WHERE username = $username";
	while($row = mysqli_fetch_assoc($result1)) {
		$points = $row["points"];
	}
$ot = "SELECT ownTrail FROM custom WHERE UID = '$id'";
$result2 = mysqli_query($link, $ot);
while($row = mysqli_fetch_assoc($result2)) {
	$ownTrail = $row["ownTrail"];
}

if ($points >= 5000 && $ownTrail == 0) {
$points = $points - 5000;
$sql2 = "UPDATE users SET points = '$points' WHERE username = '$username'";
mysqli_query($link, $sql2) or die('Error querying database.');

$ownTrail = 1;
$sql = "UPDATE custom SET ownTrail = '$ownTrail' WHERE UID = '$id'";
mysqli_query($link, $sql) or die('Error querying database.');

header("location: index.php");
}else if ($ownTrail == 1) {
	echo '<script type="text/javascript">alert("Already Own!");</script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
}else {
	echo '<script type="text/javascript">alert("Not enough points!");</script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
}
exit();


?>