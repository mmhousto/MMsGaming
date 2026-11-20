// Phase 3: password rules, login pauses after repeated failures, password
// change needs the current password, and the email reset flow.
const { test, expect } = require('@playwright/test');
const { execFileSync } = require('child_process');
const path = require('path');
const { registerUser, login, postForm, PASSWORD, uniqueName } = require('../helpers/site');
const { scalar, mysql, q } = require('../helpers/db');

const LIB = path.join(__dirname, '..', '..', 'lib', 'accounts.php');
function passwordProblem(pw, user = '') {
  return execFileSync('php', ['-r', `require '${LIB}'; echo json_encode(password_problem($argv[1], $argv[2]));`, '--', pw, user], { encoding: 'utf8' });
}

// Every test here starts and ends with no recorded attempts, so the
// per-IP limit (all tests come from 127.0.0.1) never leaks into other tests.
test.beforeEach(() => mysql('DELETE FROM rate_limits'));
test.afterEach(() => mysql('DELETE FROM rate_limits'));

test('password rules', () => {
  expect(passwordProblem('short')).toContain('at least 10');
  expect(passwordProblem('password123')).toContain('too common');
  expect(passwordProblem('aaaaaaaaaaaa')).toContain('too common');
  expect(passwordProblem('bobby_rocks_2026', 'bobby')).toContain('username');
  expect(passwordProblem('x'.repeat(73))).toContain('72');
  expect(passwordProblem('correct horse battery')).toBe('null');
});

test('sign-up rejects weak passwords', async ({ request }) => {
  for (const [pw, msg] of [['short1', 'at least 10'], ['password123', 'too common']]) {
    const name = uniqueName('weak');
    const res = await postForm(request, '/register.php', {
      form: { username: name, email: `${name}@example.com`, password: pw, confirm_password: pw },
      maxRedirects: 0,
    });
    expect(await res.text()).toContain(msg);
    expect(scalar(`SELECT COUNT(*) FROM users WHERE username = ${q(name)}`)).toBe('0');
  }
});

test('unknown username and wrong password give the same message', async ({ request }) => {
  const name = await registerUser(request);
  const wrongPw = await (await postForm(request, '/login.php', { form: { username: name, password: 'WrongPassword9' } })).text();
  const noUser = await (await postForm(request, '/login.php', { form: { username: 'nobody_here_x', password: 'WrongPassword9' } })).text();
  const msg = 'The username or password you entered was not valid.';
  expect(wrongPw).toContain(msg);
  expect(noUser).toContain(msg);
  expect(noUser).not.toContain('No account found');
});

test('5 wrong passwords pause logins to that account for 15 minutes', async ({ request }) => {
  const name = await registerUser(request);
  for (let i = 0; i < 5; i++) {
    await postForm(request, '/login.php', { form: { username: name, password: `Wrong-guess-${i}` } });
  }
  // Even the right password is refused while paused.
  const paused = await postForm(request, '/login.php', { form: { username: name, password: PASSWORD }, maxRedirects: 0 });
  expect(paused.status()).toBe(200);
  expect(await paused.text()).toContain('Too many failed attempts');

  // 15 minutes later it works again, and a successful login clears the count.
  mysql(`UPDATE rate_limits SET attempted_at = DATE_SUB(NOW(), INTERVAL 16 MINUTE)`);
  await login(request, name);
  expect(scalar(`SELECT COUNT(*) FROM rate_limits WHERE subject = ${q(name.toLowerCase())}`)).toBe('0');
});

test('20 failures from one address pause logins from it', async ({ request }) => {
  const name = await registerUser(request);
  for (let i = 0; i < 20; i++) {
    await postForm(request, '/login.php', { form: { username: `guess_user_${i}`, password: 'Wrong-guess-1' } });
  }
  const paused = await postForm(request, '/login.php', { form: { username: name, password: PASSWORD }, maxRedirects: 0 });
  expect(await paused.text()).toContain('Too many failed attempts');
});

test('changing your password needs the current one', async ({ request }) => {
  const name = await registerUser(request);
  await login(request, name);
  const newPw = 'Brand-new-secret-77';

  const wrong = await postForm(request, '/reset-password.php', {
    form: { current_password: 'not-my-password', new_password: newPw, confirm_password: newPw }, maxRedirects: 0,
  });
  expect(await wrong.text()).toContain('Your current password is not correct.');

  const weak = await postForm(request, '/reset-password.php', {
    form: { current_password: PASSWORD, new_password: 'password123', confirm_password: 'password123' }, maxRedirects: 0,
  });
  expect(await weak.text()).toContain('too common');

  const ok = await postForm(request, '/reset-password.php', {
    form: { current_password: PASSWORD, new_password: newPw, confirm_password: newPw }, maxRedirects: 0,
  });
  expect(ok.status()).toBe(302);
  await login(request, name, newPw);
});

test('email reset: weak password goes back to the form with the link codes; a strong one works', async ({ request }) => {
  const name = await registerUser(request);
  const selector = 'a1b2c3d4e5f60718';
  const validatorHex = 'ab'.repeat(32);
  const hash = execFileSync('php', ['-r', `echo password_hash(hex2bin('${validatorHex}'), PASSWORD_DEFAULT);`], { encoding: 'utf8' });
  mysql(`INSERT INTO pwdReset (pwdResetEmail, pwdResetSelector, pwdResetToken, pwdResetExpires)
         VALUES (${q(`${name}@example.com`)}, '${selector}', ${q(hash)}, '${Math.floor(Date.now() / 1000) + 1800}')`);

  const weak = await postForm(request, '/resets-password.inc.php', {
    form: { 'reset-password-submit': '1', selector, validator: validatorHex, pwd: 'short', 'pwd-repeat': 'short' }, maxRedirects: 0,
  });
  const back = weak.headers()['location'];
  expect(back).toContain(`selector=${selector}`);
  expect(back).toContain('newpwd=weak');
  expect(await (await request.get(`/${back}`)).text()).toContain('Please choose a stronger password');

  const newPw = 'Reset-to-this-2026';
  const ok = await postForm(request, '/resets-password.inc.php', {
    form: { 'reset-password-submit': '1', selector, validator: validatorHex, pwd: newPw, 'pwd-repeat': newPw }, maxRedirects: 0,
  });
  expect(ok.headers()['location']).toContain('passwordupdated');
  await login(request, name, newPw);
});

test("reset requests don't reveal whether an email has an account, and are limited", async ({ request }) => {
  const email = 'not-a-member@example.com';
  for (let i = 0; i < 5; i++) {
    const res = await postForm(request, '/reset-request.inc.php', { form: { 'forgot-password': '1', 'user-email': email }, maxRedirects: 0 });
    expect(res.headers()['location']).toContain('reset=success');
  }
  // Only the first 3 were processed.
  expect(scalar(`SELECT COUNT(*) FROM rate_limits WHERE kind = 'reset' AND subject = ${q(email)}`)).toBe('3');
});
