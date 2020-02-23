<?php

if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 

require_once "config.php";  

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
	header('Location: index.php');
	exit();
}
	$username = $_SESSION['username'];
    $id = $_SESSION['id'];
    $points = $_SESSION['points'];
    $isDonor = $_SESSION['Donor'];
	$postFields = 'cmd=_notify-validate';

	$p = "SELECT points FROM users WHERE username = '$username'";
	$result1 = mysqli_query($link, $p);//"SELECT points FROM users WHERE username = $username";
	while($row = mysqli_fetch_assoc($result1)) {
		$points = $row["points"];
	}
	$isD = "SELECT Donor FROM custom WHERE UID = '$id'";
	$result2 = mysqli_query($link, $isD);//"SELECT points FROM users WHERE username = $username";
	while($row = mysqli_fetch_assoc($result2)) {
		$isDonor = $row["Donor"];
	}

		foreach ($_POST as $key => $value) {
			$postFields .= "&$key=".urlencode($value);
		}


		$ch = curl_init();

		curl_setopt_array($ch, array(
			CURLOPT_URL => 'https://ipnpb.paypal.com/cgi-bin/webscr',
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYHOST => false,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $postFields
		));

		$result = curl_exec($ch);
		curl_close($ch);

		if ($result == 'VERIFIED') {
			$pointsRecieved = $_POST['mc_gross'] * 1000;
			$sql = "UPDATE users SET points += '$pointsRecieved' WHERE username = '$username'";
			mysqli_query($link, $sql);
			$isDonor = 1;
			$sql2 = "UPDATE custom SET Donor = '$isDonor' WHERE UID = '$id'";
			mysqli_query($link, $sql2);
		}

		exit();

?>