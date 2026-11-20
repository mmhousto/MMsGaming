    <?php
    session_start(); 
    require_once "config.php";

    $total = "";
    $username = $_SESSION['username'];
    $rank = $_SESSION['rank'];

$mmsgStats = player_stats($link, $username ?? null);
$points = $mmsgStats['points'];
$totalPoints = $mmsgStats['totalPoints'];
$rank = $mmsgStats['rank'];
$total = $mmsgStats['total'];
  

echo $rank;



?>