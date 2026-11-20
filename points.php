    <?php
    session_start(); 
    require_once "config.php";

    $total = "";
    $username = $_SESSION['username'];
    
$mmsgStats = player_stats($link, $username ?? null);
$points = $mmsgStats['points'];
$totalPoints = $mmsgStats['totalPoints'];
$rank = $mmsgStats['rank'];
$total = $mmsgStats['total'];
    

echo $points;


?>