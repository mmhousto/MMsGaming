// Regression tests for the Phase 0 security fixes.
const { test, expect } = require('@playwright/test');
const { registerUser, login, insertUserDirect, userId, postForm } = require('../helpers/site');
const { query, scalar, q } = require('../helpers/db');

test('changing email only changes your own account, whatever user id the form sends', async ({ playwright, baseURL }) => {
  const alice = await playwright.request.newContext({ baseURL });
  const aliceName = await registerUser(alice);
  await login(alice, aliceName);
  const bobName = await registerUser(alice);

  await postForm(alice, '/changeEmail.inc.php', {
    form: { emailSubmit: '1', uid: String(userId(bobName)), newEmail: 'attacker@example.com' },
    maxRedirects: 0,
  });

  expect(scalar(`SELECT Email FROM users WHERE username = ${q(bobName)}`)).toBe(`${bobName}@example.com`);
  expect(scalar(`SELECT Email FROM users WHERE username = ${q(aliceName)}`)).toBe('attacker@example.com');
  await alice.dispose();
});

test('guests cannot change any email', async ({ request }) => {
  const name = await registerUser(request);
  const res = await postForm(request, '/changeEmail.inc.php', {
    form: { emailSubmit: '1', uid: String(userId(name)), newEmail: 'attacker@example.com' },
    maxRedirects: 0,
  });
  expect(res.headers()['location']).toContain('login.php');
  expect(scalar(`SELECT Email FROM users WHERE username = ${q(name)}`)).toBe(`${name}@example.com`);
});

test('a username containing SQL only ever touches its own row', async ({ request }) => {
  const evil = insertUserDirect("x' OR '1'='1", { totalPoints: 150 });
  const othersBefore = query(`SELECT id, \`rank\`, points FROM users WHERE username <> ${q(evil)} ORDER BY id`);
  await login(request, evil);
  await request.get('/index.php');
  await request.get('/addPoints.php');

  // This user moved to the "Novice" rank; nobody else's row changed.
  expect(scalar(`SELECT \`rank\` FROM users WHERE username = ${q(evil)}`)).toBe('Novice');
  expect(query(`SELECT id, \`rank\`, points FROM users WHERE username <> ${q(evil)} ORDER BY id`)).toEqual(othersBefore);

  // And it is shown escaped on the scoreboard.
  const board = await (await request.get('/Scoreboard.php')).text();
  expect(board).toContain('x&#039; OR &#039;1&#039;=&#039;1');
});

test('values from the address bar are not run as JavaScript', async ({ request }) => {
  const name = await registerUser(request);
  await login(request, name);
  for (const page of ['/about.php', '/index.php', '/Store.php']) {
    const body = await (await request.get(`${page}?image=';alert(77)//&box=';alert(78)//`)).text();
    expect(body, page).not.toMatch(/'\s*;\s*alert\(7[78]\)/);
  }
});

test('the site config file contains no password', async () => {
  const fs = require('fs');
  const path = require('path');
  const config = fs.readFileSync(path.join(__dirname, '..', '..', 'config.php'), 'utf8');
  expect(config).not.toMatch(/define\(\s*'DB_PASSWORD'\s*,\s*'/);
});
