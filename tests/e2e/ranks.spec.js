// The rank ladder (lib/points.php) and that every page agrees on a player's rank.
const { test, expect } = require('@playwright/test');
const { execFileSync } = require('child_process');
const path = require('path');
const { registerUser, login } = require('../helpers/site');
const { scalar, mysql, q } = require('../helpers/db');

const LIB = path.join(__dirname, '..', '..', 'lib', 'points.php');

function php(code) {
  return JSON.parse(execFileSync('php', ['-r', `require '${LIB}'; echo json_encode(${code});`], { encoding: 'utf8' }));
}

const LADDER = [
  [0, 'Noob', 100], [99, 'Noob', 100], [100, 'Novice', 200], [399, 'Experienced', 400],
  [400, 'Specialist', 800], [1600, 'Bada**', 3200], [12799, 'Spartan', 12800], [12800, 'Legend', 25600],
  [25600, 'Game Game Junkie', 52000], [52000, 'Godsent', 104000], [104000, 'INSANE', 208000], [999999, 'INSANE', 208000],
];

for (const [points, rank, total] of LADDER) {
  test(`rank_for(${points}) is ${rank}`, () => {
    expect(php(`rank_for(${points})`)).toEqual({ rank, total });
  });
}

test('progress bar maths', () => {
  expect(php('progress_for(40, 100)')).toEqual({ count: 40, goal: 100, percent: 40 });
  expect(php('progress_for(150, 200)')).toEqual({ count: 50, goal: 100, percent: 50 });
  expect(php('progress_for(30000, 52000)')).toEqual({ count: 4000, goal: 26000, percent: (4000 / 26000) * 100 });
});

for (const [totalPoints, rank] of [[150, 'Novice'], [30000, 'Game Game Junkie'], [60000, 'Godsent'], [150000, 'INSANE']]) {
  test(`every page shows the same rank at ${totalPoints} points (${rank})`, async ({ request }) => {
    const name = await registerUser(request);
    await login(request, name);
    mysql(`UPDATE users SET totalPoints = ${totalPoints}, points = ${totalPoints} WHERE username = ${q(name)}`);

    expect((await (await request.get('/rank.php')).text()).trim()).toBe(rank);
    const home = await (await request.get('/index.php')).text();
    expect(home).toContain(`<span id="Rank">${rank}</span>`);
    // The rank saved for the Scoreboard matches too.
    expect(scalar(`SELECT \`rank\` FROM users WHERE username = ${q(name)}`)).toBe(rank);

    const { goal, percent } = php(`progress_for(${totalPoints}, rank_for(${totalPoints})['total'])`);
    expect((await (await request.get('/total.php')).text()).trim()).toBe(String(goal));
    const bar = (await (await request.get('/Bar.php')).text()).trim();
    expect(bar.endsWith('%')).toBe(true);
    expect(parseFloat(bar)).toBeCloseTo(percent, 6);
  });
}
