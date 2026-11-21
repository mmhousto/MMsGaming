/*
 * 009: remove Slither.io (game 24). It only runs over http, and browsers
 * block http games inside the always-https site, so it never loaded.
 * The /Slither/ page is gone; old links redirect to the IO Games page.
 * Run in phpMyAdmin (SQL tab) after merging.
 */

/* Check first: should show one row, Slither.io */
SELECT gid, title, img FROM games WHERE gid = 24;

/* Remove it from every game list */
DELETE FROM games WHERE gid = 24 AND title LIKE 'Slither%';
