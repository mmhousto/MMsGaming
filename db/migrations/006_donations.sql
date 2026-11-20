/* Phase 6: PayPal donations are recorded and credited automatically.
   Run once in phpMyAdmin (SQL tab) BEFORE merging the donations PR.
   Also add your PayPal account to MMsGamingconfig.php (see the PR). */
CREATE TABLE IF NOT EXISTS donations (
  id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  txn_id varchar(64) NOT NULL,
  user_id int DEFAULT NULL,
  amount decimal(10,2) NOT NULL,
  currency char(3) NOT NULL,
  points int NOT NULL DEFAULT 0,
  status varchar(20) NOT NULL,
  payer_email varchar(255) NOT NULL DEFAULT '',
  created_at datetime NOT NULL,
  UNIQUE KEY txn_id (txn_id),
  KEY user_id (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
