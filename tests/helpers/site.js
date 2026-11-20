// Helpers for creating users and logging in during tests.
const { expect } = require('@playwright/test');
const { scalar, mysql, q } = require('./db');

let counter = 0;
const PASSWORD = 'TestPass123';

/** A unique, valid username for each test (3-20 letters/numbers/underscores). */
function uniqueName(prefix = 'u') {
  counter += 1;
  return `${prefix}${Date.now().toString(36)}${counter}`.slice(0, 20);
}

/** Register a new account through the real form handler. Returns the username. */
async function registerUser(request, username = uniqueName()) {
  const res = await postForm(request, '/register.php', {
    form: { username, email: `${username}@example.com`, password: PASSWORD, confirm_password: PASSWORD },
    maxRedirects: 0,
  });
  expect(res.status(), `register ${username}`).toBe(302);
  return username;
}

/** Log in an API request context (keeps the session cookie). */
async function login(request, username, password = PASSWORD) {
  const res = await postForm(request, '/login.php', { form: { username, password }, maxRedirects: 0 });
  expect(res.status(), `login ${username}`).toBe(302);
  expect(res.headers()['location']).toContain('index.php');
}

/** Create a user directly in the database (for usernames the form would reject). */
function insertUserDirect(username, { points = 0, totalPoints = 0 } = {}) {
  const hash = require('child_process')
    .execFileSync('php', ['-r', `echo password_hash('${PASSWORD}', PASSWORD_DEFAULT);`], { encoding: 'utf8' });
  mysql(
    `INSERT INTO users (username, password, points, totalPoints) VALUES (${q(username)}, ${q(hash)}, ${points}, ${totalPoints});
     INSERT INTO custom (UID) VALUES (LAST_INSERT_ID());`
  );
  return username;
}

function userId(username) {
  return Number(scalar(`SELECT id FROM users WHERE username = ${q(username)}`));
}

function setPoints(username, points) {
  mysql(`UPDATE users SET points = ${Number(points)} WHERE username = ${q(username)}`);
}

module.exports = { PASSWORD, uniqueName, registerUser, login, insertUserDirect, userId, setPoints };

/** The session's form token, read from a page the way a browser gets it. */
async function csrfToken(ctx) {
  const html = await (await ctx.get('/forgot-password.php')).text();
  const m = html.match(/name="csrf_token" value="([0-9a-f]+)"/);
  if (!m) throw new Error('No csrf_token found on /forgot-password.php');
  return m[1];
}

/** POST a form like a browser would: including the session's form token. */
async function postForm(ctx, url, options = {}) {
  const token = await csrfToken(ctx);
  return ctx.post(url, { ...options, form: { ...(options.form || {}), csrf_token: token } });
}

module.exports.csrfToken = csrfToken;
module.exports.postForm = postForm;
