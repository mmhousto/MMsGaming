<?php
    session_start(); 
    require_once "config.php";

    $username = $_SESSION['username'];

$p = "SELECT points FROM users WHERE username = '$username'";
	$result1 = mysqli_query($link, $p);//"SELECT points FROM users WHERE username = $username";
	while($row = mysqli_fetch_assoc($result1)) {
		$points = $row["points"];
	}

$points = $points - 5000;
$sql2 = "UPDATE users SET points = '$points' WHERE username = '$username'";
mysqli_query($link, $sql2);


echo $points;

?>