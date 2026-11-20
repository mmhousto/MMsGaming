// Sign-up, login and logout, driven through the real pages in a browser.
const { test, expect } = require('@playwright/test');
const { uniqueName, PASSWORD, registerUser } = require('../helpers/site');
const { scalar, q } = require('../helpers/db');

// Don't load ads, analytics or other outside scripts during tests.
test.beforeEach(async ({ page }) => {
  await page.route(/^https?:\/\/(?!127\.0\.0\.1)/, (route) => route.abort());
});

test('a visitor can register, log in and log out', async ({ page }) => {
  const name = uniqueName('new');

  await page.goto('/register.php');
  await page.fill('input[name="username"]', name);
  await page.fill('input[name="email"]', `${name}@example.com`);
  await page.fill('input[name="password"]', PASSWORD);
  await page.fill('input[name="confirm_password"]', PASSWORD);
  await page.check('#agree');
  await page.click('input[name="register"]');
  await expect(page).toHaveURL(/login\.php/);

  // The account and its store row exist.
  const id = scalar(`SELECT id FROM users WHERE username = ${q(name)}`);
  expect(id).not.toBeNull();
  expect(scalar(`SELECT COUNT(*) FROM custom WHERE UID = ${id}`)).toBe('1');

  await page.fill('input[name="username"]', name);
  await page.fill('input[name="password"]', PASSWORD);
  await page.click('input[type="submit"][value="Login"]');
  await expect(page).toHaveURL(/index\.php/);
  await expect(page.locator('#Gamer')).toHaveText(name);

  await page.getByRole('link', { name: 'Sign Out' }).click();
  await expect(page).toHaveURL(/login\.php/);
});

test('wrong password is rejected', async ({ page, request }) => {
  const name = await registerUser(request);
  await page.goto('/login.php');
  await page.fill('input[name="username"]', name);
  await page.fill('input[name="password"]', 'not-the-password');
  await page.click('input[type="submit"][value="Login"]');
  await expect(page).toHaveURL(/login\.php/);
  await expect(page.locator('body')).toContainText('not valid');
});

test('usernames must be 3-20 letters, numbers or underscores', async ({ request }) => {
  for (const bad of ["a'b", 'ab', 'x'.repeat(21), '<script>', 'has space']) {
    const res = await request.post('/register.php', {
      form: { username: bad, email: 'x@example.com', password: PASSWORD, confirm_password: PASSWORD },
      maxRedirects: 0,
    });
    expect(res.status(), `"${bad}" should not be accepted`).toBe(200);
    expect(await res.text()).toContain('Username must be 3-20 letters');
  }
});

test('login issues a new session ID (prevents session fixation)', async ({ request }) => {
  const name = await registerUser(request);
  await request.get('/login.php');
  const before = (await request.storageState()).cookies.find((c) => c.name === 'PHPSESSID')?.value;
  await request.post('/login.php', { form: { username: name, password: PASSWORD }, maxRedirects: 0 });
  const after = (await request.storageState()).cookies.find((c) => c.name === 'PHPSESSID')?.value;
  expect(before).toBeTruthy();
  expect(after).not.toBe(before);
});

test('sign-up mistakes show a message instead of crashing (taken name, short or mismatched password)', async ({ request }) => {
  const taken = await registerUser(request);
  const attempts = [
    { username: taken, password: PASSWORD, confirm_password: PASSWORD, expect: 'already taken' },
    { username: taken, password: PASSWORD, confirm_password: PASSWORD, expect: 'already taken' },
    { username: 'fresh_name_1', password: '123', confirm_password: '123', expect: 'atleast 6 characters' },
    { username: 'fresh_name_2', password: PASSWORD, confirm_password: 'different1', expect: 'did not match' },
  ];
  for (const a of attempts) {
    const res = await request.post('/register.php', {
      form: { username: a.username, email: `${a.username}@example.com`, password: a.password, confirm_password: a.confirm_password },
      maxRedirects: 0,
    });
    const body = await res.text();
    expect(body).not.toContain('Fatal error');
    expect(body).toContain(a.expect);
  }
  // A failed sign-up must not leave behind a store row with no account.
  expect(scalar('SELECT COUNT(*) FROM custom c LEFT JOIN users u ON u.id = c.UID WHERE u.id IS NULL')).toBe('0');
});
