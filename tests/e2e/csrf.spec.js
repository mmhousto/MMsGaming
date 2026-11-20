// Protection against forged form submissions (CSRF): every POST needs the
// session's secret token, which the site adds to its own forms.
const { test, expect } = require('@playwright/test');
const { registerUser, login, setPoints, userId, postForm, csrfToken } = require('../helpers/site');
const { scalar, q } = require('../helpers/db');

test('a store purchase without the token is refused and costs nothing', async ({ request }) => {
  const name = await registerUser(request);
  await login(request, name);
  setPoints(name, 5000);

  const forged = await request.post('/buyColor.php', { maxRedirects: 0 });
  expect(forged.status()).toBe(403);
  expect(await forged.text()).toContain('This form has expired');
  expect(scalar(`SELECT points FROM users WHERE username = ${q(name)}`)).toBe('5000');

  const wrong = await request.post('/buyColor.php', { form: { csrf_token: 'f'.repeat(64) }, maxRedirects: 0 });
  expect(wrong.status()).toBe(403);

  const real = await postForm(request, '/buyColor.php', { maxRedirects: 0 });
  expect(real.status()).toBe(302);
  expect(scalar(`SELECT ownBg FROM custom WHERE UID = ${userId(name)}`)).toBe('1');
});

test('login and email change without the token are refused', async ({ request }) => {
  const name = await registerUser(request);
  const res = await request.post('/login.php', { form: { username: name, password: 'TestPass123' }, maxRedirects: 0 });
  expect(res.status()).toBe(403);

  await login(request, name);
  await request.post('/changeEmail.inc.php', { form: { emailSubmit: '1', newEmail: 'forged@example.com' }, maxRedirects: 0 });
  expect(scalar(`SELECT Email FROM users WHERE username = ${q(name)}`)).toBe(`${name}@example.com`);
});

test("the site's forms carry the token; the PayPal form does not", async ({ request }) => {
  const name = await registerUser(request);
  await login(request, name);
  const token = await csrfToken(request);
  const store = await (await request.get('/Store.php')).text();

  const forms = store.match(/<form\b[^>]*>(\s*<input type="hidden" name="csrf_token" value="[0-9a-f]+">)?/gi) || [];
  const own = forms.filter((f) => /method\s*=\s*["']?post/i.test(f) && !/paypal\.com/i.test(f));
  expect(own.length).toBeGreaterThan(5);
  for (const f of own) expect(f, f).toContain(`value="${token}"`);

  const paypal = forms.filter((f) => /paypal\.com/i.test(f));
  expect(paypal.length).toBe(1);
  expect(paypal[0]).not.toContain('csrf_token');
});

test("PayPal's payment notification (no browser session) is not blocked by the token check", async ({ request }) => {
  const res = await request.post('/donate.php', { form: { txn_id: 'TEST' }, maxRedirects: 0 });
  expect(res.status()).not.toBe(403);
});
