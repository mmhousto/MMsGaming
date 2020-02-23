<?php
    session_start(); 
    require_once "config.php";

    $ownCursor = $_SESSION['ownCursor'];   
    $id = $_SESSION['id']; 
    $username = $_SESSION['username'];
    $points = $_SESSION['points'];

$p = "SELECT points FROM users WHERE username = '$username'";
$result1 = mysqli_query($link, $p);//"SELECT points FROM users WHERE username = $username";
while($row = mysqli_fetch_assoc($result1)) {
	$points = $row["points"];
}
$oc = "SELECT ownCursor FROM custom WHERE UID = '$id'";
$result2 = mysqli_query($link, $oc);
while($row = mysqli_fetch_assoc($result2)) {
	$ownCursor = $row["ownCursor"];
}

if ($points >= 5000 && $ownCursor == 0) {
$points = $points - 5000;
$sql2 = "UPDATE users SET points = '$points' WHERE username = '$username'";
mysqli_query($link, $sql2) or die('Error querying database.');

$ownCursor = 1;
$sql = "UPDATE custom SET ownCursor = '$ownCursor' WHERE UID = '$id'";
mysqli_query($link, $sql) or die('Error querying database.');

header("location: index.php");
}else if ($ownCursor == 1) {
	echo '<script type="text/javascript">alert("Already Own!");</script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
}else {
	echo '<script type="text/javascript">alert("Not enough points!");</script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
}
exit();


?>