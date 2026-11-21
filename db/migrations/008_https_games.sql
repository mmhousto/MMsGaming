/*
 * 008: load Duo with Friends and Krew.io over https. Browsers block http
 * games inside an https page, and the site is always https, so the http
 * addresses never loaded. Run in phpMyAdmin (SQL tab) after merging.
 */

/* Duo with Friends (game 29) */
UPDATE games
SET SRC = REPLACE(SRC, 'http://duowfriends.eu', 'https://duowfriends.eu')
WHERE gid = 29;

/* Krew.io (game 13) moved to yumina.io */
UPDATE games
SET SRC = REPLACE(SRC, 'http://krew.io', 'https://yumina.io/krew?entry=krew.io')
WHERE gid = 13;

/* Check: both should show the https address */
SELECT gid, title, SRC FROM games WHERE gid IN (13, 29);
