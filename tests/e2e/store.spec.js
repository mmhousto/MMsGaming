// The points store: buying items and applying customizations.
const { test, expect } = require('@playwright/test');
const { registerUser, login, setPoints, userId, postForm } = require('../helpers/site');
const { query, scalar, mysql, q } = require('../helpers/db');

// Item, endpoint and live price (must match the Store page).
const ITEMS = [
  { file: 'buyColor.php', flag: 'ownBg', price: 1000 },
  { file: 'buyImg.php', flag: 'ownImg', price: 1500 },
  { file: 'buyTrail.php', flag: 'ownTrail', price: 2500 },
  { file: 'buyCursor.php', flag: 'ownCursor', price: 1000 },
  { file: 'buyFont.php', flag: 'ownFont', price: 1500 },
];

async function player(request, points = 0) {
  const name = await registerUser(request);
  await login(request, name);
  setPoints(name, points);
  return name;
}

function owned(name, flag) {
  return scalar(`SELECT ${flag} FROM custom WHERE UID = ${userId(name)}`);
}
function points(name) {
  return Number(scalar(`SELECT points FROM users WHERE username = ${q(name)}`));
}

for (const item of ITEMS) {
  test(`${item.file}: buy once for ${item.price}, second buy says "Already Own"`, async ({ request }) => {
    const name = await player(request, item.price + 50);

    const first = await postForm(request, `/${item.file}`, { maxRedirects: 0 });
    expect(first.status()).toBe(302);
    expect(owned(name, item.flag)).toBe('1');
    expect(points(name)).toBe(50);

    const second = await postForm(request, `/${item.file}`, { maxRedirects: 0 });
    expect(await second.text()).toContain('Already Own!');
    expect(points(name)).toBe(50);
  });

  test(`${item.file}: not enough points`, async ({ request }) => {
    const name = await player(request, item.price - 1);
    const res = await postForm(request, `/${item.file}`, { maxRedirects: 0 });
    expect(await res.text()).toContain('Not enough points!');
    expect(owned(name, item.flag)).toBe('0');
    expect(points(name)).toBe(item.price - 1);
  });
}

test('buying requires a form submit (GET does nothing) and a login', async ({ request, playwright, baseURL }) => {
  const name = await player(request, 5000);
  await request.get('/buyColor.php', { maxRedirects: 0 });
  expect(points(name)).toBe(5000);

  const guest = await playwright.request.newContext({ baseURL });
  const res = await postForm(guest, '/buyColor.php', { maxRedirects: 0 });
  expect(res.headers()['location']).toContain('login.php');
  await guest.dispose();
});

test('8 simultaneous purchases only charge once', async ({ request, playwright, baseURL }) => {
  const name = await player(request, 2500);
  // Separate sessions so PHP's session lock doesn't serialize the requests.
  const sessions = [];
  for (let i = 0; i < 8; i++) {
    const ctx = await playwright.request.newContext({ baseURL });
    await login(ctx, name);
    sessions.push(ctx);
  }
  await Promise.all(sessions.map((ctx) => postForm(ctx, '/buyTrail.php', { maxRedirects: 0 })));
  await Promise.all(sessions.map((ctx) => ctx.dispose()));

  expect(points(name)).toBe(0);
  expect(owned(name, 'ownTrail')).toBe('1');
});

test.describe('customization values are validated', () => {
  const CASES = [
    { buy: 'buyColor.php', set: 'setBgColor.php', field: 'box2', column: 'BgColor', good: '#ff0000', bad: 'red;}</style><script>alert(1)</script>' },
    { buy: 'buyTrail.php', set: 'setTrail.php', field: 'color', column: 'Trail', good: 'blue', bad: 'blue;background:url(x)' },
    { buy: 'buyImg.php', set: 'setBgImg.php', field: 'image', column: 'BgImg', good: 'https://example.com/bg.png', bad: 'javascript:alert(1)' },
    { buy: 'buyCursor.php', set: 'setCursor.php', field: 'cursorC', column: 'CursorC', good: 'https://example.com/c.cur', bad: 'https://x.com/a.png) ; } body{x:url(evil' },
    { buy: 'buyFont.php', set: 'setFont.php', field: 'myFont', column: 'Font', good: 'Comic Sans MS', bad: 'Arial;}</style><script>' },
  ];

  for (const c of CASES) {
    test(`${c.set}`, async ({ request }) => {
      const name = await player(request, 5000);
      await postForm(request, `/${c.buy}`, { maxRedirects: 0 });

      const bad = await postForm(request, `/${c.set}`, { form: { [c.field]: c.bad }, maxRedirects: 0 });
      expect(bad.status()).toBe(200);
      expect(await bad.text()).toContain('Please enter');
      expect(scalar(`SELECT ${c.column} FROM custom WHERE UID = ${userId(name)}`) ?? '').toBe('');

      const good = await postForm(request, `/${c.set}`, { form: { [c.field]: c.good }, maxRedirects: 0 });
      expect(good.status()).toBe(302);
      expect(scalar(`SELECT ${c.column} FROM custom WHERE UID = ${userId(name)}`)).toBe(c.good);
    });
  }

  test('setting a customization you do not own is refused', async ({ request }) => {
    const name = await player(request, 0);
    const res = await postForm(request, '/setBgColor.php', { form: { box2: '#00ff00' }, maxRedirects: 0 });
    expect(await res.text()).toContain('You Do Not Own');
    expect(scalar(`SELECT BgColor FROM custom WHERE UID = ${userId(name)}`) ?? '').toBe('');
  });
});

test('harmful values already in the database are never printed', async ({ request }) => {
  const name = await player(request, 0);
  mysql(`UPDATE custom SET ownBg=1, ownImg=1, ownTrail=1, ownCursor=1, ownFont=1, lastSet='Image',
         BgImg='x); } </style><script>alert(91)</script>', Trail='red;}</style><script>alert(92)</script>',
         CursorC='x)</style><script>alert(93)</script>', Font='a;}</style><script>alert(94)</script>'
         WHERE UID = ${userId(name)}`);
  for (const page of ['/index.php', '/Store.php', '/HGWK/index.php']) {
    const body = await (await request.get(page)).text();
    expect(body, page).not.toMatch(/<script>alert\(9[1-4]\)/);
  }
});

test("the player's saved items reach the page (one shared lookup)", async ({ request }) => {
  const name = await player(request, 0);
  mysql(`UPDATE custom SET ownBg = 1, BgColor = '#123abc', lastSet = 'Background', Donor = 1 WHERE UID = ${userId(name)}`);
  const body = await (await request.get('/index.php')).text();
  // Page script settings (these read the wrong column name before Phase 2, so BgColor was always empty).
  expect(body).toContain('BgColor : "#123abc"');
  expect(body).toContain('hasBg   : "1"');
  expect(body).toContain('Donor   : "1"');
  // And the background CSS uses it.
  expect(body).toContain('#123abc; background-image: none');
});
