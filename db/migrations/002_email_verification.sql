/* Phase 3: email verification for new accounts.
   Run once on the live database (phpMyAdmin -> SQL tab) after deploying.
   Until it runs, every account counts as verified (nothing is locked). */

/* Remember when each account confirmed its email. */
ALTER TABLE users ADD COLUMN email_verified_at datetime DEFAULT NULL;

/* Everyone who signed up before this feature counts as verified. */
UPDATE users SET email_verified_at = NOW() WHERE email_verified_at IS NULL;

/* Pending verification links (one per account; the token is stored hashed). */
CREATE TABLE IF NOT EXISTS email_verifications (
  id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  user_id int NOT NULL,
  email varchar(255) NOT NULL,
  selector varchar(32) NOT NULL,
  token_hash char(64) NOT NULL,
  expires_at datetime NOT NULL,
  UNIQUE KEY selector (selector),
  KEY user_id (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
