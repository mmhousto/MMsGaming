/* Phase 4: the games you make and publish (third-party games stay in the
   `games` table). One row per game; game.php shows any of them.
   Run once in phpMyAdmin (SQL tab) BEFORE merging the Phase 4 PR, because
   /HGWK/ is served from this table once that PR is live. */

CREATE TABLE IF NOT EXISTS unity_games (
  id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  slug varchar(50) NOT NULL,
  title varchar(100) NOT NULL,
  tagline varchar(255) NOT NULL DEFAULT '',
  description text,
  how_to_play text,
  controls text,
  tips text,
  thumbnail varchar(255) NOT NULL DEFAULT '',
  play_type varchar(20) NOT NULL DEFAULT 'unity',
  build_path varchar(255) NOT NULL DEFAULT '',
  build_name varchar(100) NOT NULL DEFAULT '',
  build_ext varchar(20) NOT NULL DEFAULT '',
  template_path varchar(255) NOT NULL DEFAULT '',
  streaming_assets varchar(255) NOT NULL DEFAULT '',
  embed_url varchar(500) NOT NULL DEFAULT '',
  width int NOT NULL DEFAULT 960,
  height int NOT NULL DEFAULT 600,
  steam_url varchar(255) NOT NULL DEFAULT '',
  itch_url varchar(255) NOT NULL DEFAULT '',
  xbox_url varchar(255) NOT NULL DEFAULT '',
  app_store_url varchar(255) NOT NULL DEFAULT '',
  play_store_url varchar(255) NOT NULL DEFAULT '',
  privacy_url varchar(255) NOT NULL DEFAULT '',
  meta_description varchar(300) NOT NULL DEFAULT '',
  published tinyint NOT NULL DEFAULT 1,
  sort_order int NOT NULL DEFAULT 0,
  UNIQUE KEY slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

/* Paddle Balls: modern Unity WebGL build (the setup new games use). */
INSERT INTO unity_games (slug, title, tagline, description, how_to_play, controls, tips, thumbnail,
  play_type, build_path, build_name, template_path, streaming_assets, width, height, privacy_url, app_store_url, play_store_url, meta_description, sort_order)
VALUES ('Gravity-Balls', 'Paddle Balls', 'Pong with gravity: a casual arcade game, also on mobile.',
  'Paddle Balls is like the classic arcade game pong in a way, but with a twist. It takes gravity into effect! There are two available game modes. Good Luck!',
  'Bounce multiple balls, with your paddle, to gain score and be the best! Move left and right doing your best to juggle all the balls bouncing around. Collect coins and powerups to help you out.',
  'A D | to move paddle',
  'If you go all the way to your left you will come out on the right side, and vice-versa. It is kind of like in Pac-man.',
  '/appIcon2.png', 'unity', '/Gravity-Balls/Build', 'WebGl', '/Gravity-Balls/TemplateData', '/Gravity-Balls/StreamingAssets', 960, 600,
  '/GravBallsPrivacyPolicy.html', 'https://apps.apple.com/us/app/paddle-balls/id1549834349',
  'https://play.google.com/store/apps/details?id=com.MorganHouston.GravityBalls',
  'Play Paddle Balls, a casual, arcade game for free online. This game is like old-school pong, but better and can be played at MM''s Gaming Co. or on your mobile device.', 20)
ON DUPLICATE KEY UPDATE slug = slug;

/* HGWK: the first game moved onto game.php (still the 2019 Unity player). */
INSERT INTO unity_games (slug, title, tagline, description, how_to_play, controls, tips, thumbnail,
  play_type, build_path, build_name, template_path, width, height, meta_description, sort_order)
VALUES ('HGWK', 'Have Gun, Will Kill', 'A 2D platform shooter made in Unity.',
  'HGWK is a platform game made in Unity. Like other platform games, advance through the level jumping from platform to platform. Shoot enemies with your hand gun. This was a group project I worked on. You are Robotron, the only one who can save your planet from the alien invasion. Move throughout the levels, defeating aliens to get to the end and stop the mothership!',
  'Defeat the aliens that stand in your way. Jump and dodge bullets, while firing back to destroy enemies. Advance to the end to kill the boss and reach the mothership.',
  'WASD | to move\nJ | to fire weapon\nK | to use super attack\nL | to levitate\nSpace | to jump',
  'Either fight all the enemies or try to make a break for the mother ship! It is easier to take it slow and eliminate the alien invasion slowly.',
  '', 'unity2019', '/HGWK/Build', 'HGWK', '/HGWK/TemplateData', 960, 600,
  'Play my first game developed with unity, Have Gun Will Kill, only at MM''s Gaming Co.', 10)
ON DUPLICATE KEY UPDATE slug = slug;
