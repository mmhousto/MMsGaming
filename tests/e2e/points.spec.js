// Earning points: only logged-in players, at most once every 25 seconds.
const { test, expect } = require('@playwright/test');
const { registerUser, login } = require('../helpers/site');
const { query, q } = require('../helpers/db');

test('guests cannot earn points', async ({ request }) => {
  const res = await request.get('/addPoints.php');
  expect(res.status()).toBe(401);
});

test('a player earns 2 points, and calling again right away earns nothing', async ({ request }) => {
  const name = await registerUser(request);
  await login(request, name);

  await request.get('/addPoints.php');
  await request.get('/addPoints.php');
  await request.get('/addPoints.php');

  const [[points, total]] = query(`SELECT points, totalPoints FROM users WHERE username = ${q(name)}`);
  expect(Number(points)).toBe(2);
  expect(Number(total)).toBe(2);
});
