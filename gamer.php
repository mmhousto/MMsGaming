<?php
    session_start(); 
    require_once "config.php";

    $total = "";
    $username = $_SESSION['username'];
    $rank = $_SESSION['rank'];

    $p = "SELECT points FROM users WHERE username = ?";
	$result1 = db_query($link, $p, [$username]);//"SELECT points FROM users WHERE username = $username";
	while($row = mysqli_fetch_assoc($result1)) {
		$points = $row["points"];
	}

	$tp = "SELECT totalPoints FROM users WHERE username = ?";
	$result = db_query($link, $tp, [$username]);//"SELECT points FROM users WHERE username = $username";
	while($row = mysqli_fetch_assoc($result)) {
		$totalPoints = $row["totalPoints"];
	}
    if($totalPoints < 100){
    $rank = "Noob";
    $total = 100;
} else if($totalPoints >= 100 && $totalPoints < 200){                            
    $rank = "Novice";
    $total = 200;
    $sql1 = "UPDATE users SET rank = ? WHERE username = ?";
        db_query($link, $sql1, [$rank, $username]);
} else if($totalPoints >= 200 && $totalPoints < 400){
    $rank = "Experienced";
    $total = 400;
    $sql1 = "UPDATE users SET rank = ? WHERE username = ?";
        db_query($link, $sql1, [$rank, $username]);
} else if($totalPoints >= 400 && $totalPoints < 800){
    $rank = "Specialist";
    $total = 800;
    $sql1 = "UPDATE users SET rank = ? WHERE username = ?";
        db_query($link, $sql1, [$rank, $username]);
} else if($totalPoints >= 800 && $totalPoints < 1600){
    $rank = "Expert";
    $total = 1600;
    $sql1 = "UPDATE users SET rank = ? WHERE username = ?";
        db_query($link, $sql1, [$rank, $username]);
} else if($totalPoints >= 1600 && $totalPoints < 3200){
    $rank = "Bada**";
    $total = 3200;
    $sql1 = "UPDATE users SET rank = ? WHERE username = ?";
        db_query($link, $sql1, [$rank, $username]);
} else if($totalPoints >= 3200 && $totalPoints < 6400){
    $rank = "Noble";
    $total = 6400;
    $sql1 = "UPDATE users SET rank = ? WHERE username = ?";
        db_query($link, $sql1, [$rank, $username]);
} else if($totalPoints >= 6400 && $totalPoints < 12800){
    $rank = "Spartan";
    $total = 12800;
    $sql1 = "UPDATE users SET rank = ? WHERE username = ?";
        db_query($link, $sql1, [$rank, $username]);
} else if($totalPoints >= 12800 && $totalPoints < 25600){
    $rank = "Legend";
    $total = 25600;
    $sql1 = "UPDATE users SET rank = ? WHERE username = ?";
        db_query($link, $sql1, [$rank, $username]);
} else if($totalPoints >= 25600 && $totalPoints < 52000){
    $rank = "Game Game Junkie";
    $total = 52000;
    $sql1 = "UPDATE users SET rank = ? WHERE username = ?";
        db_query($link, $sql1, [$rank, $username]);
} else if($totalPoints >= 52000 && $totalPoints < 104000){
    $rank = "Godsent";
    $total = 104000;
    $sql1 = "UPDATE users SET rank = ? WHERE username = ?";
        db_query($link, $sql1, [$rank, $username]);
} else {
    $rank = "Holy Shit, Get a Life!";
    $total = 208000;
    $sql1 = "UPDATE users SET rank = ? WHERE username = ?";
        db_query($link, $sql1, [$rank, $username]);
}   

echo e($username);



?>