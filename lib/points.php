<?php
/*
 * Points and ranks: the ONE place the rank ladder is defined.
 * Every page and endpoint uses player_stats() / rank_for() from here, so
 * changing a rank name or threshold means editing only RANK_TIERS below.
 */

/*
 * Each tier: [points needed to reach the NEXT rank, rank name].
 * A player is in the first tier whose limit is above their total points.
 * The last tier has no upper limit; its number is only used to draw the
 * progress bar.
 */
const RANK_TIERS = [
    [100,    'Noob'],
    [200,    'Novice'],
    [400,    'Experienced'],
    [800,    'Specialist'],
    [1600,   'Expert'],
    [3200,   'Bada**'],
    [6400,   'Noble'],
    [12800,  'Spartan'],
    [25600,  'Legend'],
    [52000,  'Game Game Junkie'],
    [104000, 'Godsent'],
    [208000, 'INSANE'],
];

/**
 * Rank for a number of total points.
 * Returns ['rank' => name, 'total' => the tier's limit].
 */
function rank_for($totalPoints): array
{
    $totalPoints = (int) $totalPoints;
    foreach (RANK_TIERS as [$limit, $name]) {
        if ($totalPoints < $limit) {
            return ['rank' => $name, 'total' => $limit];
        }
    }
    [$limit, $name] = RANK_TIERS[count(RANK_TIERS) - 1];
    return ['rank' => $name, 'total' => $limit];
}

/**
 * Points, total points and rank for a player, read from the database.
 * Also saves the player's current rank (used by the Scoreboard) when it
 * has changed. A guest or unknown user gets zero points and the first rank.
 *
 * Returns ['points', 'totalPoints', 'rank', 'total'].
 */
function player_stats(mysqli $link, $username): array
{
    $points = 0;
    $totalPoints = 0;
    $storedRank = null;

    if ($username !== null && $username !== '') {
        $res = db_query($link, 'SELECT points, totalPoints, `rank` FROM users WHERE username = ?', [(string) $username]);
        if ($res && ($row = mysqli_fetch_assoc($res))) {
            $points = (int) $row['points'];
            $totalPoints = (int) $row['totalPoints'];
            $storedRank = $row['rank'];
        }
    }

    $tier = rank_for($totalPoints);

    if ($storedRank !== null && $storedRank !== $tier['rank']) {
        db_query($link, 'UPDATE users SET `rank` = ? WHERE username = ?', [$tier['rank'], (string) $username]);
    }

    return [
        'points' => $points,
        'totalPoints' => $totalPoints,
        'rank' => $tier['rank'],
        'total' => $tier['total'],
    ];
}

/**
 * Progress toward the next rank, for the "Next Rank" bar.
 * Each rank starts at half of its limit (except the first), so progress is
 * measured from there. Returns ['count', 'goal', 'percent'].
 */
function progress_for($totalPoints, $total): array
{
    $totalPoints = (int) $totalPoints;
    $total = (int) $total;
    if ($total <= 100) {
        return ['count' => $totalPoints, 'goal' => 100, 'percent' => $totalPoints];
    }
    $start = $total / 2;
    return [
        'count' => $totalPoints - $start,
        'goal' => $total - $start,
        'percent' => (($totalPoints - $start) / $start) * 100,
    ];
}
