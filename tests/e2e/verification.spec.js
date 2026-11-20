// Email verification: new players confirm their address before they can
// earn points, comment or use the Store. They can still log in and play.
const { test, expect } = require('@playwright/test');
const { registerUser, login, postForm, setPoints, userId, sentEmails, uniqueName } = require('../helpers/site');
const { scalar, mysql, q } = require('../helpers/db');

async function newPlayer(request) {
  const name = uniqueName('nv');
  const res = await postForm(request, '/register.php', {
    form: { username: name, email: `${name}@example.com`, password: 'TestPass123', confirm_password: 'TestPass123' },
    maxRedirects: 0,
  });
  expect(res.headers()['location']).toContain('login.php?verify=sent');
  await login(request, name);
  return name;
}

function linkFor(name) {
  const mail = sentEmails().filter((m) => m.to === `${name}@example.com`).pop();
  expect(mail, `confirmation email to ${name}`).toBeTruthy();
  expect(mail.subject).toContain('Confirm your email');
  return mail.html.match(/href="https:\/\/mms-gaming\.com(\/verify-email\.php\?[^"]+)"/)[1].replace(/&amp;/g, '&');
}

test.beforeEach(() => mysql('DELETE FROM rate_limits'));

test('signing up sends a confirmation email; the link verifies the account', async ({ request }) => {
  const name = await newPlayer(request);
  expect(scalar(`SELECT email_verified_at IS NULL FROM users WHERE username = ${q(name)}`)).toBe('1');

  const page = await (await request.get('/index.php')).text();
  expect(page).toContain('Please confirm your email address');

  const res = await request.get(linkFor(name));
  expect(res.status()).toBe(200);
  expect(await res.text()).toContain('Email confirmed!');
  expect(scalar(`SELECT email_verified_at IS NULL FROM users WHERE username = ${q(name)}`)).toBe('0');
  expect(await (await request.get('/index.php')).text()).not.toContain('Please confirm your email address');

  // The link only works once.
  expect((await request.get(linkFor(name))).status()).toBe(400);
});

test('unverified players can play but not earn points, buy or comment', async ({ request }) => {
  const name = await newPlayer(request);
  setPoints(name, 5000);

  await request.get('/addPoints.php');
  expect(scalar(`SELECT totalPoints FROM users WHERE username = ${q(name)}`)).toBe('0');

  const buy = await postForm(request, '/buyColor.php', { maxRedirects: 0 });
  expect(await buy.text()).toContain('Please confirm your email address before using the Store');
  expect(scalar(`SELECT ownBg FROM custom WHERE UID = ${userId(name)}`)).toBe('0');

  mysql('DELETE FROM comments');
  await postForm(request, '/blog/Best-Io-Games.php', { form: { commentSubmit: '1', message: 'hello' } });
  expect(scalar('SELECT COUNT(*) FROM comments')).toBe('0');

  // Game pages still work.
  expect((await request.get('/8Ball/index.php')).status()).toBe(200);

  // After confirming, everything works.
  await request.get(linkFor(name));
  await request.get('/addPoints.php');
  expect(scalar(`SELECT totalPoints FROM users WHERE username = ${q(name)}`)).toBe('2');
  expect((await postForm(request, '/buyColor.php', { maxRedirects: 0 })).status()).toBe(302);
});

test('expired or wrong links are refused', async ({ request }) => {
  const name = await newPlayer(request);
  const link = linkFor(name);
  expect((await request.get(link.replace(/validator=[0-9a-f]{4}/, 'validator=0000'))).status()).toBe(400);
  mysql(`UPDATE email_verifications SET expires_at = DATE_SUB(NOW(), INTERVAL 1 HOUR)`);
  const res = await request.get(link);
  expect(res.status()).toBe(400);
  expect(await res.text()).toContain("This link didn't work");
});

test('resend sends a new link (and the old one stops working); limited to 3 an hour', async ({ request }) => {
  const name = await newPlayer(request);
  const first = linkFor(name);
  await postForm(request, '/resend-verification.php');
  const second = linkFor(name);
  expect(second).not.toBe(first);
  expect((await request.get(first)).status()).toBe(400);

  await postForm(request, '/resend-verification.php');
  const before = sentEmails().length;
  const last = await postForm(request, '/resend-verification.php'); // 4th email in the hour
  expect(await last.text()).toContain('could not send another email');
  expect(sentEmails().length).toBe(before);
});

test('changing to a new email address needs confirming again', async ({ request }) => {
  const name = await registerUser(request); // verified
  await login(request, name);
  await postForm(request, '/changeEmail.inc.php', { form: { emailSubmit: '1', newEmail: `${name}-new@example.com` }, maxRedirects: 0 });
  expect(scalar(`SELECT email_verified_at IS NULL FROM users WHERE username = ${q(name)}`)).toBe('1');
  const mail = sentEmails().filter((m) => m.to === `${name}-new@example.com`).pop();
  expect(mail).toBeTruthy();

  // Re-saving the same address doesn't.
  const other = await registerUser(request);
  await login(request, other);
  await postForm(request, '/changeEmail.inc.php', { form: { emailSubmit: '1', newEmail: `${other}@example.com` }, maxRedirects: 0 });
  expect(scalar(`SELECT email_verified_at IS NULL FROM users WHERE username = ${q(other)}`)).toBe('0');
});
