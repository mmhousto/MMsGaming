// PayPal donations: the Donate button tells PayPal which player is paying,
// and donate.php credits $1 = 1,000 points only for genuine, completed
// payments to the site's own PayPal account, once per payment.
const { test, expect } = require('@playwright/test');
const { execFileSync } = require('child_process');
const path = require('path');
const { registerUser, login, userId } = require('../helpers/site');
const { scalar, mysql, q } = require('../helpers/db');

function tokenFor(uid) {
  const lib = path.join(__dirname, '..', '..', 'lib', 'donations.php');
  // Same secret the site uses: derived from the test DB password.
  return execFileSync('php', ['-r', `define('DB_PASSWORD', getenv('DB_PASS') ?: 'testpw'); require '${lib}'; echo donation_custom_token(${uid});`], { encoding: 'utf8' });
}

let txnCounter = 0;
function ipn(overrides = {}) {
  txnCounter += 1;
  return {
    txn_id: `TEST${Date.now()}${txnCounter}`, payment_status: 'Completed', mc_gross: '5.00', mc_currency: 'USD',
    receiver_email: 'seller@example.com', payer_email: 'buyer@example.com', txn_type: 'web_accept', ...overrides,
  };
}

async function notify(request, fields) {
  const res = await request.post('/donate.php', { form: fields });
  expect(res.status()).toBe(200);
  return (await res.text()).trim();
}

async function donor(request) {
  const name = await registerUser(request);
  await login(request, name);
  return { name, uid: userId(name) };
}

const pointsOf = (name) => Number(scalar(`SELECT points FROM users WHERE username = ${q(name)}`));
const isDonor = (uid) => scalar(`SELECT Donor FROM custom WHERE UID = ${uid}`);

test.beforeEach(() => mysql('DELETE FROM donations'));

test('the Donate button tells PayPal which player is paying (logged in only)', async ({ request }) => {
  let store = await (await request.get('/Store.php')).text();
  expect(store).not.toContain('name="custom"');
  expect(store).toContain('first to receive points for your donation');

  const { uid } = await donor(request);
  store = await (await request.get('/Store.php')).text();
  expect(store).toContain(`name="custom" value="${tokenFor(uid)}"`);
  expect(store).toContain('name="notify_url" value="https://mms-gaming.com/donate.php"');
  expect(store).toContain('name="return" value="https://mms-gaming.com/thankYou.php"');
});

test('a completed $5 donation credits 5,000 points and Donor status, once', async ({ request }) => {
  const { name, uid } = await donor(request);
  const before = pointsOf(name);
  const fields = ipn({ custom: tokenFor(uid) });

  expect(await notify(request, fields)).toBe('credited');
  expect(pointsOf(name)).toBe(before + 5000);
  expect(isDonor(uid)).toBe('1');
  expect(scalar(`SELECT CONCAT(user_id, ' ', amount, ' ', points, ' ', status) FROM donations WHERE txn_id = ${q(fields.txn_id)}`))
    .toBe(`${uid} 5.00 5000 completed`);

  // PayPal re-sends notices: the same payment is never credited twice.
  expect(await notify(request, fields)).toBe('duplicate');
  expect(pointsOf(name)).toBe(before + 5000);
});

test('notices that must not credit anything', async ({ request }) => {
  const { name, uid } = await donor(request);
  const token = tokenFor(uid);
  const before = pointsOf(name);
  const cases = [
    [{ custom: token, test_forged: '1' }, 'invalid'],                               // not from PayPal
    [{ custom: token, receiver_email: 'someone-else@example.com' }, 'wrong-receiver'], // paid to another account
    [{ custom: token, payment_status: 'Pending' }, 'ignored-status'],
    [{ custom: token, mc_currency: 'EUR' }, 'wrong-currency'],
  ];
  for (const [over, expected] of cases) {
    expect(await notify(request, ipn(over)), JSON.stringify(over)).toBe(expected);
  }
  expect(pointsOf(name)).toBe(before);
  expect(isDonor(uid)).toBe('0');
});

test('a forged or missing player code records the donation without crediting anyone', async ({ request }) => {
  const { name, uid } = await donor(request);
  const before = pointsOf(name);
  const forged = tokenFor(uid).replace(/.$/, (c) => (c === '0' ? '1' : '0'));
  expect(await notify(request, ipn({ custom: forged }))).toBe('credited-guest');
  expect(await notify(request, ipn({ custom: `u${uid}` }))).toBe('credited-guest');
  expect(await notify(request, ipn({}))).toBe('credited-guest');
  expect(pointsOf(name)).toBe(before);
  expect(scalar('SELECT COUNT(*) FROM donations WHERE user_id IS NULL')).toBe('3');
});

test('a refund or chargeback takes the points back', async ({ request }) => {
  const { name, uid } = await donor(request);
  const original = ipn({ custom: tokenFor(uid), mc_gross: '2.50' });
  await notify(request, original);
  const credited = pointsOf(name);
  expect(credited).toBeGreaterThanOrEqual(2500);

  const refund = ipn({ payment_status: 'Refunded', parent_txn_id: original.txn_id, mc_gross: '-2.50' });
  expect(await notify(request, refund)).toBe('refunded');
  expect(pointsOf(name)).toBe(credited - 2500);
  expect(scalar(`SELECT status FROM donations WHERE txn_id = ${q(original.txn_id)}`)).toBe('refunded');
  expect(await notify(request, { ...refund, txn_id: refund.txn_id + 'B' })).toBe('duplicate');
  expect(pointsOf(name)).toBe(credited - 2500);
});
