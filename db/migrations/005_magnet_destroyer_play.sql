/* Magnet Destroyer now has a web build: PLAY GAME opens its full-window
   player (like ZombCube). Run once in phpMyAdmin (SQL tab) AFTER merging
   the PR that adds Magnet-Destroyer/Play-Magnet-Destroyer/index.html. */
UPDATE unity_games
SET play_type = 'launch', launch_url = '/Magnet-Destroyer/Play-Magnet-Destroyer/'
WHERE slug = 'Magnet-Destroyer';
