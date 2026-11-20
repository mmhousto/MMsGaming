# Publishing a Unity game on mms-gaming.com

Every game you make has one row in the `unity_games` table and is shown by
`game.php`. Third-party games stay in the `games` table.

## 1. Build for the web (Unity 2021 or newer)

1. **File → Build Settings → WebGL → Switch Platform.**
2. **Player Settings → Publishing Settings:**
   - **Compression Format: Gzip**
   - **Decompression Fallback: ON.** Files end in `.unityweb` and the browser
     unpacks them itself, so the server needs no extra setup.
   - **Name Files As Hashes: OFF.** Keeps file names predictable.
3. **Player Settings → Resolution and Presentation:** pick the canvas size
   (default 960 × 600) and use the **Default** WebGL template.
4. **Build** into a folder named after the game, e.g. `MyNewGame/Play/`.

You get `Build/` (four files: `NAME.loader.js`, `NAME.data.unityweb`,
`NAME.framework.js.unityweb`, `NAME.wasm.unityweb`), `TemplateData/`, and
maybe `StreamingAssets/`. You can delete the generated `index.html`.

## 2. Add the files to the repo

Put the build in the repo, e.g. `MyNewGame/Play/Build/...`, and create
`MyNewGame/index.php` containing:

```php
<?php
$gameSlug = 'MyNewGame';
require __DIR__ . '/../game.php';
```

Commit and push to `Chad`, then merge the PR. The page appears at
`https://mms-gaming.com/MyNewGame/` once step 3 is done.

## 3. Add the game's row (phpMyAdmin → SQL)

```sql
INSERT INTO unity_games
  (slug, title, tagline, description, how_to_play, controls, tips, thumbnail,
   play_type, build_path, build_name, build_ext, template_path, streaming_assets,
   width, height, steam_url, itch_url, xbox_url, app_store_url, play_store_url,
   privacy_url, meta_description, sort_order)
VALUES
  ('MyNewGame', 'My New Game', 'One line about the game.',
   'A paragraph or two about the game.\n\nA blank line starts a new paragraph.',
   'How to play, in a sentence or two.',
   'WASD | to move\nSpace | to jump\nMouse | to aim',
   'A tip or two.',
   '/MyNewGame/icon.png',
   'unity', '/MyNewGame/Play/Build', 'NAME', '.unityweb', '/MyNewGame/Play/TemplateData', '/MyNewGame/Play/StreamingAssets',
   960, 600, '', '', '', '', '',
   '/MyNewGame/PrivacyPolicy.html', 'What search engines show (about 150 characters).', 30);
```

- `build_name` is the part before `.loader.js` (e.g. `ZombCube WebGL`).
- `build_ext` is `.unityweb` with the settings above. Use `''` for an
  uncompressed build (like Paddle Balls).
- Controls: one per line, `KEY | what it does`; several keys separated by spaces
  (`A D | to move`).
- Leave a store link `''` if the game isn't there. Only `https://` links are shown.
- `play_type` can also be `store` (no web version, just the store buttons),
  `embed` (set `embed_url` to a build hosted elsewhere, e.g. on itch.io), or
  `unity2019` (old Unity 2019 builds with `UnityLoader.js`).
- To hide a game without deleting it: `UPDATE unity_games SET published = 0 WHERE slug = 'MyNewGame';`

## Updating a game

Replace the files in its `Build/` folder with the new build and push. If the
file name changed, update `build_name` in its row.
