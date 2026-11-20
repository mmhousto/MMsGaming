    <?php
    session_start(); 
    require_once "config.php";

    // Only logged-in players earn points, and at most once every 25 seconds
    // (the game pages call this every 30 seconds while you play).
    if (!is_logged_in()) {
        http_response_code(401);
        exit('0');
    }
    $now = time();
    $mmsgCanAward = empty($_SESSION['lastPointAward']) || ($now - $_SESSION['lastPointAward']) >= 25;

    $total = "";
    $username = $_SESSION['username'];

$mmsgStats = player_stats($link, $username ?? null);
$points = $mmsgStats['points'];
$totalPoints = $mmsgStats['totalPoints'];
$rank = $mmsgStats['rank'];
$total = $mmsgStats['total'];
   

    if ($mmsgCanAward) {
        $_SESSION['lastPointAward'] = $now;
        $u1 = "UPDATE users SET points = points + 2, totalPoints = totalPoints + 2 WHERE id = ?";
        db_query($link, $u1, [(int) $_SESSION['id']]) or die('Error querying database.');
        $points += 2;
        $totalPoints += 2;
    }
        
        echo progress_for($totalPoints, rank_for($totalPoints)['total'])['count'];
    ?>