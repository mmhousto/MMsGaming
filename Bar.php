    <?php
    session_start(); 
    require_once "config.php";

    $percent = "";
    $total = "";
    $username = $_SESSION['username'];
    $rank = $_SESSION['rank'];

$mmsgStats = player_stats($link, $username ?? null);
$points = $mmsgStats['points'];
$totalPoints = $mmsgStats['totalPoints'];
$rank = $mmsgStats['rank'];
$total = $mmsgStats['total'];
    

            $percent = progress_for($totalPoints, $total)['percent'];
    echo $percent."%";



?>