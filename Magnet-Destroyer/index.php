<?php
// This game's page is built by /game.php from its row in the unity_games
// table. There's no web build yet, so it shows the store buttons; once a
// WebGL build is in Play-Magnet-Destroyer/, set play_type = 'launch' (see
// db/migrations/004_more_unity_games.sql).
$gameSlug = 'Magnet-Destroyer';
require __DIR__ . '/../game.php';
