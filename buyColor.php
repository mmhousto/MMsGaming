<?php
    session_start(); 
    require_once "config.php";

    $ownBg = $_SESSION['ownBg'];   
    $id = $_SESSION['id']; 
    $username = $_SESSION['username'];
    $points = $_SESSION['points'];

$p = "SELECT points FROM users WHERE username = '$username'";
$result1 = mysqli_query($link, $p);//"SELECT points FROM users WHERE username = $username";
while($row = mysqli_fetch_assoc($result1)) {
	$points = $row["points"];
}
$ob = "SELECT ownBg FROM custom WHERE UID = '$id'";
$result2 = mysqli_query($link, $ob);
while($row = mysqli_fetch_assoc($result2)) {
	$ownBg = $row["ownBg"];
}

if ($points >= 2500 && $ownBg == 0) {
$points = $points - 2500;
$sql2 = "UPDATE users SET points = '$points' WHERE username = '$username'";
mysqli_query($link, $sql2) or die('Error querying database.');

$ownBg = 1;
$sql = "UPDATE custom SET ownBg = '$ownBg' WHERE UID = '$id'";
mysqli_query($link, $sql) or die('Error querying database.');

header("location: index.php");
}else if ($ownBg == 1) {
	echo '<script type="text/javascript">alert("Already Own!");</script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
}else {
	echo '<script type="text/javascript">alert("Not enough points!");</script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
}
exit();


?>