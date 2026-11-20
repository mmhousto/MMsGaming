// Phase 4: your own games (unity_games table) shown by game.php.
const { test, expect } = require('@playwright/test');
const { registerUser, login, insertUserDirect } = require('../helpers/site');

test('HGWK (Unity 2019 player) keeps its address and loads from the table', async ({ request }) => {
  const res = await request.get('/HGWK/');
  expect(res.status()).toBe(200);
  const body = await res.text();
  expect(body).toContain('<title>Play Have Gun, Will Kill for Free | MM&#039;s Gaming Community</title>');
  expect(body).toContain('<script src="/HGWK/Build/UnityLoader.js"></script>');
  expect(body).toContain('UnityLoader.instantiate("gameContainer", "\\/HGWK\\/Build\\/HGWK.json", {onProgress: UnityProgress})');
  expect(body).toContain('<kbd>WASD</kbd>&nbsp;to move');
  expect(body).toContain('<link rel="canonical" href="https://mms-gaming.com/HGWK/">');
});

test('Paddle Balls (modern Unity player) builds the right file names', async ({ request }) => {
  const body = await (await request.get('/Gravity-Balls/')).text();
  expect(body).toContain('<canvas id="unity-canvas" width="960" height="600"');
  expect(body).toContain('var buildUrl = "\\/Gravity-Balls\\/Build";');
  expect(body).toContain('"WebGl.data"');
  expect(body).toContain('"WebGl.framework.js"');
  expect(body).toContain('"WebGl.wasm"');
  expect(body).toContain('"WebGl.loader.js"');
  expect(body).toContain('<a href="/GravBallsPrivacyPolicy.html">Paddle Balls privacy policy</a>');
  expect(body).toContain('<kbd>A</kbd>&nbsp;<kbd>D</kbd>&nbsp;to move paddle');
});

test('a store-only game shows store buttons, no player, and only https links', async ({ request }) => {
  const body = await (await request.get('/game.php?slug=TestStoreGame')).text();
  expect(body).not.toContain('GAME ON!');
  expect(body).toContain('id="store-links"');
  expect(body).toContain('href="https://store.steampowered.com/app/1/Test"');
  expect(body).toContain('href="https://example.itch.io/test"');
  expect(body).not.toContain('javascript:alert(1)');
});

test('an embedded game shows its frame', async ({ request }) => {
  const body = await (await request.get('/game.php?slug=TestEmbedGame')).text();
  expect(body).toContain('<iframe src="https://example.com/game/index.html" width="960" height="600"');
});

test('unpublished and unknown games are not found', async ({ request }) => {
  for (const slug of ['TestHiddenGame', 'NoSuchGame', '../config']) {
    const res = await request.get(`/game.php?slug=${encodeURIComponent(slug)}`);
    expect(res.status(), slug).toBe(404);
    expect(await res.text()).toContain('Game not found');
  }
});

test('the points timer is only on playable games for logged-in players', async ({ request }) => {
  let body = await (await request.get('/Gravity-Balls/')).text();
  expect(body).not.toContain('function addPoints()');

  const name = await registerUser(request);
  await login(request, name);
  body = await (await request.get('/Gravity-Balls/')).text();
  expect(body).toContain('function addPoints()');
  expect(body).toContain('onmouseenter="startAdding(); playing();"');
  body = await (await request.get('/game.php?slug=TestStoreGame')).text();
  expect(body).not.toContain('function addPoints()');
});

test("game pages' points script doesn't run code hidden in an old username", async ({ request }) => {
  const evil = insertUserDirect("z';alert(9)//");
  await login(request, evil);
  const body = await (await request.get('/8Ball/index.php')).text();
  expect(body).not.toContain("'z';alert(9)//'");
  expect(body).toContain('Gamer   : "z\\u0027;alert(9)\\/\\/"');
});

test('ZombCube: PLAY GAME opens its full-window player; store buttons; credits', async ({ request }) => {
  const body = await (await request.get('/ZombCube/')).text();
  expect(body).toContain('<a class="button" id="play-game" href="/ZombCube/Play-ZombCube/">PLAY GAME</a>');
  for (const href of ['https://store.steampowered.com/app/3035180/ZombCube/', 'https://mms-gaming-co.itch.io/zombcube',
    'https://www.xbox.com/en-us/games/store/zombcube/9pd5qmlqxw5j', 'https://apps.apple.com/us/app/zombcube/id1606013960']) {
    expect(body).toContain(`href="${href}"`);
  }
  expect(body).toContain('<h3><strong>Credits</strong></h3>');
  expect(body).toContain('blackSnow by airtone');
  expect(body).toContain('<a href="/ZombCube/PrivacyPolicy.html">ZombCube privacy policy</a>');
  expect(body).not.toContain('function addPoints()'); // no points on the landing page itself
  // The full-window player page is still there.
  expect((await request.get('/ZombCube/Play-ZombCube/')).status()).toBe(200);
});

test('Imprecision is a store page; Magnet Destroyer launches its own build', async ({ request }) => {
  const imp = await (await request.get('/Imprecision/')).text();
  expect(imp).not.toContain('id="play-game"');
  expect(imp).toContain('href="https://store.steampowered.com/app/2466820/Imprecision"');
  expect(imp).toContain('CC BY 4.0');

  const mag = await (await request.get('/Magnet-Destroyer/')).text();
  expect(mag).toContain('<a class="button" id="play-game" href="/Magnet-Destroyer/Play-Magnet-Destroyer/">PLAY GAME</a>');
  expect(mag).toContain('href="https://apps.apple.com/us/app/magnet-destroyer/id1622929531"');
  expect(mag).toContain('href="https://play.google.com/store/apps/details?id=com.MorganHouston.MagnetDestroyer"');

  // Its player page loads Magnet Destroyer's own build (it used to hold an old ZombCube player).
  const player = await (await request.get('/Magnet-Destroyer/Play-Magnet-Destroyer/')).text();
  expect(player).toContain('"/MagnetDestroyerWebGLBuild.loader.js"');
  expect(player).toContain('"/MagnetDestroyerWebGLBuild.data.unityweb"');
  expect(player).not.toContain('ZombCube');
  for (const f of ['MagnetDestroyerWebGLBuild.loader.js', 'MagnetDestroyerWebGLBuild.data.unityweb',
    'MagnetDestroyerWebGLBuild.framework.js.unityweb', 'MagnetDestroyerWebGLBuild.wasm.unityweb']) {
    expect((await request.head(`/Magnet-Destroyer/Play-Magnet-Destroyer/Build/${f}`)).status(), f).toBe(200);
  }
});

test('Retro Space Ball shows its itch.io build in a frame', async ({ request }) => {
  const body = await (await request.get('/RetroSpaceBall/')).text();
  expect(body).toContain('<iframe src="https://v6p9d9t4.ssl.hwcdn.net/html/2032191/WebGL_b1.2.0/index.html"');
});

test('Our Games lists every published game from the table, and only those', async ({ request }) => {
  const body = await (await request.get('/Unity-Games.php')).text();
  const list = body.match(/<ul[^>]*id="my-games-list">([\s\S]*?)<\/ul>/)[1];
  for (const slug of ['Imprecision', 'HGWK', 'Gravity-Balls', 'ZombCube', 'Magnet-Destroyer', 'RetroSpaceBall']) {
    expect(list, slug).toContain(`href="/${slug}/"`);
  }
  expect(list).not.toContain('TestHiddenGame');
  // Shown in sort order: Imprecision (5) before HGWK (10) before Paddle Balls (20).
  expect(list.indexOf('/Imprecision/')).toBeLessThan(list.indexOf('/HGWK/'));
  expect(list.indexOf('/HGWK/')).toBeLessThan(list.indexOf('/Gravity-Balls/'));
});

test.describe('our games come first', () => {
  test('the homepage opens with a "Play Our Games" card for every published game', async ({ request }) => {
    const body = await (await request.get('/index.php')).text();
    const showcase = body.indexOf('id="our-games"');
    expect(showcase).toBeGreaterThan(-1);
    // Before the studio/pricing introduction.
    expect(showcase).toBeLessThan(body.indexOf("WELCOME TO MM's GAMING COMMUNITY"));
    const section = body.slice(showcase, body.indexOf('</section>', showcase));
    for (const slug of ['Imprecision', 'HGWK', 'Gravity-Balls', 'ZombCube', 'Magnet-Destroyer']) {
      expect(section, slug).toContain(`class="showcase-card" href="/${slug}/"`);
    }
    expect(section).not.toContain('TestHiddenGame');
    // Store-only games say "Get it", playable ones "Play".
    expect(section).toMatch(/href="\/Imprecision\/"[\s\S]*?Get it/);
    expect(section).toMatch(/href="\/ZombCube\/"[\s\S]*?>Play</);
  });

  test('the Games page starts with a strip of our own games', async ({ request }) => {
    const body = await (await request.get('/Free-Games.php')).text();
    expect(body).toContain('class="showcase showcase-compact" id="our-games"');
    expect(body).toContain('OUR OWN GAMES');
  });

  test('the menu lists Our Games before the third-party Games', async ({ request }) => {
    const body = await (await request.get('/Store.php')).text();
    const menu = body.match(/<header class="topnav"[\s\S]*?<\/header>/)[0];
    expect(menu.indexOf('>Our Games<')).toBeLessThan(menu.indexOf('>Games<'));
    expect(menu.indexOf('>Home<')).toBeLessThan(menu.indexOf('>Our Games<'));
  });
});
