<?php
    session_start(); 
    require_once "config.php";

    $username = $_SESSION['username'];
    $ownImg = $_SESSION['ownImg'];   
    $id = $_SESSION['id']; 
    $points = $_SESSION['points'];

$p = "SELECT points FROM users WHERE username = '$username'";
	$result1 = mysqli_query($link, $p);//"SELECT points FROM users WHERE username = $username";
	while($row = mysqli_fetch_assoc($result1)) {
		$points = $row["points"];
	}
$oi = "SELECT ownImg FROM custom WHERE UID = '$id'";
$result2 = mysqli_query($link, $oi);
while($row = mysqli_fetch_assoc($result2)) {
	$ownImg = $row["ownImg"];
}

if ($points >= 5000 && $ownImg == 0) {
$points = $points - 5000;
$sql2 = "UPDATE users SET points = '$points' WHERE username = '$username'";
mysqli_query($link, $sql2) or die('Error querying database.');

$ownImg = 1;
$sql = "UPDATE custom SET ownImg = '$ownImg' WHERE UID = '$id'";
mysqli_query($link, $sql) or die('Error querying database.');

header("location: index.php");
}else if ($ownImg == 1) {
	echo '<script type="text/javascript">alert("Already Own!");</script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
}else {
	echo '<script type="text/javascript">alert("Not enough points!");</script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
}
exit();


?>