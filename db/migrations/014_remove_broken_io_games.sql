/*
 * 014: remove three io games that no longer work.
 *   - Slush.io (game 25): its domain is parked.
 *   - Hole.io (game 12): hole-io.com now redirects to the publisher's site.
 *   - Carjack.io (game 6): carjack.io now redirects to an unrelated domain.
 * Their pages are gone; old links redirect to the IO Games page (.htaccess).
 * Run in phpMyAdmin (SQL tab) after merging.
 */

/* Check first: should show three rows, Carjack.io, Hole.io and Slush.io */
SELECT gid, title, img FROM games WHERE gid IN (6, 12, 25);

/* Remove them from every game list */
DELETE FROM games
WHERE (gid = 6 AND title LIKE 'Carjack%')
   OR (gid = 12 AND title LIKE 'Hole%')
   OR (gid = 25 AND title LIKE 'Slush%');

/* Check: should return no rows */
SELECT gid, title FROM games WHERE gid IN (6, 12, 25);
