<?php
    session_start(); 
    require_once "config.php";

    $ownImage = $_SESSION['ownImage'];   
    $id = $_SESSION['id']; 
    $username = $_SESSION['username'];
    $points = $_SESSION['points'];

$p = "SELECT points FROM users WHERE username = '$username'";
$result1 = mysqli_query($link, $p);//"SELECT points FROM users WHERE username = $username";
while($row = mysqli_fetch_assoc($result1)) {
	$points = $row["points"];
}
$oi = "SELECT ownImage FROM custom WHERE UID = '$id'";
$result2 = mysqli_query($link, $oi);
while($row = mysqli_fetch_assoc($result2)) {
	$ownImage = $row["ownImage"];
}

if ($points >= 1500 && $ownImage == 0) {
$points = $points - 1500;
$sql2 = "UPDATE users SET points = '$points' WHERE username = '$username'";
mysqli_query($link, $sql2) or die('Error querying database.');

$ownImage = 1;
$sql = "UPDATE custom SET ownImage = '$ownImage' WHERE UID = '$id'";
mysqli_query($link, $sql) or die('Error querying database.');

header("location: index.php");
}else if ($ownImage == 1) {
	echo '<script type="text/javascript">alert("Already Own!");</script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
}else {
	echo '<script type="text/javascript">alert("Not enough points!");</script>';
	echo '<meta http-equiv="refresh" content="1;url=index.php">';
}
exit();


?>

?>