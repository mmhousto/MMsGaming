<?php
/*
 * The logged-in player's store items and customizations (the `custom`
 * table), loaded with ONE query per page view and then reused.
 */

/**
 * The player's `custom` row as an array. Guests and unknown players get
 * the defaults (nothing owned, nothing set).
 */
function player_custom(mysqli $link, $uid): array
{
    static $cache = [];
    $defaults = [
        'UID' => 0, 'ownTrail' => 0, 'ownBg' => 0, 'ownImg' => 0, 'ownImage' => 0,
        'ownCursor' => 0, 'ownFont' => 0, 'lastSet' => '', 'BgColor' => '', 'Trail' => '',
        'BgImg' => '', 'CursorC' => '', 'Font' => '', 'Donor' => 0,
    ];
    $uid = (int) $uid;
    if ($uid <= 0) {
        return $defaults;
    }
    if (!isset($cache[$uid])) {
        $row = null;
        $res = db_query($link, 'SELECT * FROM custom WHERE UID = ?', [$uid]);
        if ($res) {
            $row = mysqli_fetch_assoc($res);
        }
        $cache[$uid] = $row ? array_merge($defaults, $row) : $defaults;
    }
    return $cache[$uid];
}
