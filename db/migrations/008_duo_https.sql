/*
 * 008: load Duo with Friends over https. Browsers block http games inside
 * an https page, and the site is always https, so the http address never
 * loaded. Run in phpMyAdmin (SQL tab) after merging.
 */
UPDATE games
SET SRC = REPLACE(SRC, 'http://duowfriends.eu', 'https://duowfriends.eu')
WHERE gid = 29;

/* Check: SRC should contain https://duowfriends.eu */
SELECT gid, title, SRC FROM games WHERE gid = 29;
