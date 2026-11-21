/*
 * 007: UNO Online is now "Duo with Friends" (game 29).
 * The page moved from /UNO/ to /Duo/ (old links redirect).
 * Run in phpMyAdmin (SQL tab) right after merging.
 */

/* Step 1: name, picture and link used on the game lists */
UPDATE games
SET title = 'Duo with Friends',
    img = 'Duo',
    imgDesc = 'Duo with Friends is a free online multiplayer card game you can play with friends on MM''s Gaming Co.'
WHERE gid = 29;

/* Step 2: replace the old name inside the description texts */
UPDATE games
SET Description = REPLACE(REPLACE(REPLACE(Description, 'UNO Online', 'Duo with Friends'), 'UNO', 'Duo'), 'Uno', 'Duo'),
    HowToPlay   = REPLACE(REPLACE(REPLACE(HowToPlay,   'UNO Online', 'Duo with Friends'), 'UNO', 'Duo'), 'Uno', 'Duo'),
    Controls    = REPLACE(REPLACE(REPLACE(Controls,    'UNO Online', 'Duo with Friends'), 'UNO', 'Duo'), 'Uno', 'Duo'),
    Tips        = REPLACE(REPLACE(REPLACE(Tips,        'UNO Online', 'Duo with Friends'), 'UNO', 'Duo'), 'Uno', 'Duo')
WHERE gid = 29;

/* Check: should show Duo with Friends and no "UNO" left */
SELECT gid, title, img, imgDesc, Description, HowToPlay, Controls, Tips FROM games WHERE gid = 29;
