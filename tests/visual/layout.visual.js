// Visual check for layout refactors: screenshots of key pages, compared
// against a baseline taken BEFORE the change on the same machine.
//
//   npx playwright test --project=visual --update-snapshots   (before the change)
//   npx playwright test --project=visual                      (after: shows any differences)
//
// Not part of the normal test run: fonts render slightly differently on
// different computers, so the baseline only makes sense on one machine.
const { test, expect } = require('@playwright/test');
const { mysql } = require('../helpers/db');
const { PASSWORD } = require('../helpers/site');

const PAGES = [
  'index.php', 'login.php', 'register.php', 'Store.php', 'Scoreboard.php', 'about.php', 'profile.php',
  'Free-Games.php', 'IO-Games.php', 'Unity-Games.php', 'blog/index.php', 'blog/Best-Io-Games.php',
  'HGWK/index.php', 'Krunker/index.php', 'ZombCube/index.php', 'editComment.php', 'forgot-password.php',
];

// A fixed player so every run sees the same data.
const NAME = 'visualplayer';

test.beforeAll(async ({ request }) => {
  mysql(`DELETE FROM custom WHERE UID IN (SELECT id FROM users WHERE username = '${NAME}');
         DELETE FROM users WHERE username = '${NAME}';`);
  await request.post('/register.php', {
    form: { username: NAME, email: `${NAME}@example.com`, password: PASSWORD, confirm_password: PASSWORD },
  });
  mysql(`UPDATE users SET points = 1234, totalPoints = 3000 WHERE username = '${NAME}'`);
});

for (const who of ['guest', 'player']) {
  for (const path of PAGES) {
    test(`${who}: ${path}`, async ({ page }) => {
      // Block everything that isn't this site (ads, analytics, fonts, embeds).
      await page.route(/^https?:\/\/(?!127\.0\.0\.1)/, (route) => route.abort());
      if (who === 'player') {
        await page.goto('/login.php');
        await page.fill('input[name="username"]', NAME);
        await page.fill('input[name="password"]', PASSWORD);
        await page.click('input[type="submit"][value="Login"]');
        await page.waitForURL(/index\.php/);
      }
      await page.goto(`/${path}`, { waitUntil: 'load' });
      await page.addStyleTag({ content: '*, *::before, *::after { animation: none !important; transition: none !important; caret-color: transparent !important; }' });
      await expect(page).toHaveScreenshot(`${who}-${path.replace(/\//g, '_')}.png`, {
        fullPage: true,
        maxDiffPixelRatio: 0.001,
        timeout: 15_000,
      });
    });
  }
}
