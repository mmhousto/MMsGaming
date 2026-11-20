-- MM's Gaming Community database structure (used by the automated tests).
--
-- NOTE: this was reconstructed from the PHP code, not exported from the
-- live database (e.g. the live users table has no created_at column). To make tests match production exactly, export the real
-- structure from phpMyAdmin (Export -> Custom -> Structure only, no data)
-- and replace this file. Never commit data or passwords here.

SET NAMES utf8mb4;

CREATE TABLE users (
  id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  Email varchar(255) DEFAULT NULL,
  username varchar(50) NOT NULL UNIQUE,
  password varchar(255) NOT NULL,
  points int DEFAULT 0,
  totalPoints int NOT NULL DEFAULT 0,
  `rank` varchar(255) NOT NULL DEFAULT 'Noob',
  email_verified_at datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE custom (
  UID int NOT NULL PRIMARY KEY,
  ownTrail int DEFAULT 0,
  ownBg int DEFAULT 0,
  ownImg int DEFAULT 0,
  ownImage int DEFAULT 0,
  ownCursor int DEFAULT 0,
  ownFont int DEFAULT 0,
  lastSet varchar(50) DEFAULT '',
  BgColor varchar(255) DEFAULT '',
  Trail varchar(255) DEFAULT '',
  BgImg varchar(600) DEFAULT '',
  CursorC varchar(600) DEFAULT '',
  Font varchar(100) DEFAULT '',
  Donor int DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE comments (
  cid int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  uid varchar(50) DEFAULT NULL,
  date datetime DEFAULT NULL,
  message text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE replies (
  rid int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  cid int DEFAULT NULL,
  uid varchar(50) DEFAULT NULL,
  date datetime DEFAULT NULL,
  message text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE secondReplies (
  srid int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  rid int DEFAULT NULL,
  cid int DEFAULT NULL,
  uid varchar(50) DEFAULT NULL,
  date datetime DEFAULT NULL,
  message text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE posts (
  aid int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title varchar(255), summary text, posted varchar(50), image varchar(255),
  alt varchar(255), href varchar(255), author varchar(100), content text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE games (
  gid int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  title varchar(255), img varchar(255), imgDesc varchar(255), genre varchar(255),
  SRC text, Description text, HowToPlay text, Controls text, Tips text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE pwdReset (
  pwdResetId int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  pwdResetEmail text, pwdResetSelector text, pwdResetToken longtext, pwdResetExpires text
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE rate_limits (
  id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  kind varchar(20) NOT NULL,
  subject varchar(255) NOT NULL,
  ip varchar(45) NOT NULL DEFAULT '',
  attempted_at datetime NOT NULL,
  KEY kind_subject (kind, subject, attempted_at),
  KEY kind_ip (kind, ip, attempted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE email_verifications (
  id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id int NOT NULL,
  email varchar(255) NOT NULL,
  selector varchar(32) NOT NULL,
  token_hash char(64) NOT NULL,
  expires_at datetime NOT NULL,
  UNIQUE KEY selector (selector),
  KEY user_id (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE unity_games (
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
  launch_url varchar(255) NOT NULL DEFAULT '',
  credits text,
  UNIQUE KEY slug (slug)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
