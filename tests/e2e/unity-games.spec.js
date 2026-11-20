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
