-- Phase 3: limits on repeated login attempts and password-reset emails.
-- Run once on the live database (phpMyAdmin -> SQL tab) BEFORE or right
-- after deploying. Until it exists, the site works but skips the limits.
CREATE TABLE IF NOT EXISTS rate_limits (
  id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  kind varchar(20) NOT NULL,
  subject varchar(255) NOT NULL,
  ip varchar(45) NOT NULL DEFAULT '',
  attempted_at datetime NOT NULL,
  KEY kind_subject (kind, subject, attempted_at),
  KEY kind_ip (kind, ip, attempted_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
