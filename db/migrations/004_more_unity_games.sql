/* Phase 4 (part 2): the rest of your games on game.php.
   Run once in phpMyAdmin (SQL tab) BEFORE merging the PR that converts
   ZombCube, Imprecision, Magnet-Destroyer and RetroSpaceBall. */

/* launch_url: the "PLAY GAME" button opens this full-window player page.
   credits: music/art credits shown on the game page. */
ALTER TABLE unity_games
  ADD COLUMN launch_url varchar(255) NOT NULL DEFAULT '',
  ADD COLUMN credits text;

/* ZombCube: landing page with a PLAY GAME button that opens the full-window
   player at /ZombCube/Play-ZombCube/ (as before). */
INSERT INTO unity_games (slug, title, tagline, description, how_to_play, controls, tips, credits, thumbnail,
  play_type, launch_url, steam_url, itch_url, xbox_url, app_store_url, privacy_url, meta_description, sort_order)
VALUES ('ZombCube', 'ZombCube', 'A 3D FPS, wave-based, zombie survival game on PC, Xbox, MacOS, tvOS and iOS.',
  'ZombCube is a first-person, cross-platform, zombie survival, wave based game. Play solo or with friends all over the world destroying the evil ZombCubes. Use teamwork, leadership, and skills to be the best and rank on the leaderboards.\n\nZombCube was designed to allow students to follow along and incorporate a lot of cross-platform features. We look into Unity Ads, In-App Purchases, Unity''s New Input System, Pathfinding, and networking.\n\nFeatures: multiplayer, singleplayer, blasters, skins, music, stats, leaderboards and achievements.\n\nZombCube is in early access. Report bugs through the Contact Me page.',
  'Survive wave after wave of ZombCubes, alone or with friends. Swap between blasters, pick the right weapon for each wave and climb the leaderboards.',
  'Left Stick | to move\nSwipe/Right Stick | to look\nSpace/Bottom Button | to jump\nLMB/Right Trigger | to fire\nQ/Top Button | to swap weapons (hold for weapon select)\n1 2 3 4/D-Pad | to quick switch\nE/Button Left | to interact (hold)\nEsc/P/Start | to pause',
  '',
  'Music: blackSnow by airtone.',
  '/ZombCubeLogo.jpg', 'launch', '/ZombCube/Play-ZombCube/',
  'https://store.steampowered.com/app/3035180/ZombCube/', 'https://mms-gaming-co.itch.io/zombcube',
  'https://www.xbox.com/en-us/games/store/zombcube/9pd5qmlqxw5j', 'https://apps.apple.com/us/app/zombcube/id1606013960',
  '/ZombCube/PrivacyPolicy.html',
  'Play ZombCube, a 3D fps, wave-based, zombie survival game for free online on PC, Xbox, MacOS, tvOS, and iOS.', 30)
ON DUPLICATE KEY UPDATE slug = slug;

/* Imprecision: no web version here; store buttons (Steam, Xbox, itch.io,
   Google Play, TestFlight). */
INSERT INTO unity_games (slug, title, tagline, description, how_to_play, controls, tips, credits, thumbnail,
  play_type, steam_url, itch_url, xbox_url, app_store_url, play_store_url, meta_description, sort_order)
VALUES ('Imprecision', 'Imprecision', 'A first/third person action-adventure game set in the Scandinavian Middle Ages.',
  'Imprecision is a first/third person, action-adventure game set in the Scandinavian Middle Ages. Imprecision is in Early Access. In Imprecision, you play as a lone archer, Örvar, who is training to take down The Black Knights of Bjørn and their kingdom. King Bjørn the Bloodthirsty and The Black Knights have taken over the nation destroying a lot of the land and enslaving towns. If you are not part of the royal kingdom then you are a thrall. You are determined to take back what is yours.\n\nNote: During Early Access, player data may be reset. Missing Story Cutscenes and levels are WIP. Precision Levels and Level 1 of the story are available. Price is reduced during this period.\n\nFeatures: archery, medieval, voxel art style, third/first person, precision levels. 3D models created in MagicaVoxel.',
  'Story Mode: fight your way through monsters on each level, to reach the castle and take down The Black Knights of Bjørn.\n\nPrecision Mode: 50 levels that test your accuracy and preciseness. Shoot the targets that spawn. Each ring gives a different amount of points. Aim for the bullseye! When all targets are destroyed the level will end and you will receive a star rating for the level.',
  'WASD/Left Stick | to move\nMouse/Right Stick | to look\nRMB/Left Trigger | to aim\nLMB/Right Trigger | to pull back and fire\nShift/Left Stick Click | to run\nSpacebar/Button South | to jump',
  '',
  'Background music: Medieval Loop One by Alexander Nakarada (serpentsoundstudios.com), promoted by free-stock-music.com, licensed under Creative Commons Attribution 4.0 International (CC BY 4.0).',
  '/ImprecisionLogoTilt.png', 'store',
  'https://store.steampowered.com/app/2466820/Imprecision', 'https://mms-gaming-co.itch.io/imprecision',
  'https://www.xbox.com/en-us/games/store/imprecision-early-access/9pftxqfp0p4w', 'https://testflight.apple.com/join/6XiUZTWe',
  'https://play.google.com/store/apps/details?id=com.MorganHouston.Imprecision',
  'Imprecision is a first/third person, action game set in The Middle Ages. Play as a lone archer, Örvar, training to take down The Black Knights of Bjørn.', 5)
ON DUPLICATE KEY UPDATE slug = slug;

/* Magnet Destroyer: there is no web build on the site yet (its Play page
   held an old ZombCube player), so store buttons only. Once a WebGL build
   is uploaded to /Magnet-Destroyer/Play-Magnet-Destroyer/, switch it on with:
   UPDATE unity_games SET play_type = 'launch', launch_url = '/Magnet-Destroyer/Play-Magnet-Destroyer/' WHERE slug = 'Magnet-Destroyer'; */
INSERT INTO unity_games (slug, title, tagline, description, how_to_play, controls, tips, thumbnail,
  play_type, app_store_url, play_store_url, meta_description, sort_order)
VALUES ('Magnet-Destroyer', 'Magnet Destroyer', 'A free, casual arcade game available on iOS and Android.',
  'You play as a magnet that has a hatred towards mega corporations and must use your magnetic forces to keep going and destroy the rooms and objects in them. Magnet Destroyer is a game created for ScoreSpace Jam #18, by a Solo Unity Developer. The goal is to get the highest score. The genre is a Hyper Casual, Arcade style, Endless Runner. You have magnetized an office building and everything in it. Wreak havoc and keep going to gain score.',
  'You play as a Magnet and you rack up score by destroying an endless office building and staying alive. Avoid blue magnetic support beams when you are red and avoid red magnetic support beams when you are blue. Launch objects at green neutral walls to destroy them with your magnetic powers or use them as a shield.',
  'A/D or Left/Right or Left Stick | to move\nSpace/Enter or Button South or Right Trigger | to change polarity',
  '',
  '/Magnet-Destroyer/MagnetDestroyerIcon-120.png', 'store',
  'https://apps.apple.com/us/app/magnet-destroyer/id1622929531',
  'https://play.google.com/store/apps/details?id=com.MorganHouston.MagnetDestroyer',
  'Play Magnet Destroyer, a free, casual, arcade endless runner available on iOS and Android.', 40)
ON DUPLICATE KEY UPDATE slug = slug;

/* Retro Space Ball: build hosted on itch.io, shown in a frame. It wasn't
   listed on My Games before; hide it with
   UPDATE unity_games SET published = 0 WHERE slug = 'RetroSpaceBall';  */
INSERT INTO unity_games (slug, title, tagline, description, how_to_play, controls, tips, thumbnail,
  play_type, embed_url, meta_description, sort_order)
VALUES ('RetroSpaceBall', 'Retro Space Ball', 'A space shooter with a pinball twist.',
  'Retro Space Ball is a new space shooter that adds concepts of pinball. This twist on the genre makes the game fun and exciting.',
  '',
  'W A S D | to move player\nSpacebar | to jump\nRMB | to aim in\nLMB | to shoot\nShift | to crouch',
  'Spam your bullets to balance the ball and get maximum speed.',
  '/RSB.jpg', 'embed', 'https://v6p9d9t4.ssl.hwcdn.net/html/2032191/WebGL_b1.2.0/index.html',
  'Play Retro Space Ball online for free. This is a space shooter, but with pinball to add a twist!', 50)
ON DUPLICATE KEY UPDATE slug = slug;
