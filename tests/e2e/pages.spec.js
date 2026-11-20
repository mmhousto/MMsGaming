// Every page on the site should load without a PHP error, both for a
// logged-out visitor and for a logged-in player.
const { test, expect } = require('@playwright/test');
const fs = require('fs');
const path = require('path');
const { registerUser, login } = require('../helpers/site');

const ROOT = path.join(__dirname, '..', '..');

// Files that are endpoints or includes, not pages people visit.
const NOT_PAGES = /^(config|addPoints|points|rank|total|gamer|Bar|donate|logout|freecontactform\w*)\.php$|^(buy|set|load)\w*\.php$|\.inc\.php$/;

function listPages() {
  const pages = fs.readdirSync(ROOT).filter((f) => f.endsWith('.php') && !NOT_PAGES.test(f));
  for (const dir of fs.readdirSync(ROOT, { withFileTypes: true })) {
    if (!dir.isDirectory() || ['lib', 'tests', 'db', 'templates', 'node_modules'].includes(dir.name) || dir.name.startsWith('.')) continue;
    const sub = path.join(ROOT, dir.name);
    for (const f of fs.readdirSync(sub)) {
      if (f.endsWith('.php')) pages.push(`${dir.name}/${f}`);
    }
  }
  return pages.sort();
}

const PHP_ERROR = /(Fatal error|Parse error|Uncaught \w+|You have an error in your SQL syntax|Warning<\/b>:\s+mysqli)/;

const pages = listPages();

test('finds the site pages', () => {
  expect(pages.length).toBeGreaterThan(50);
});

for (const who of ['guest', 'player']) {
  test.describe(`as ${who}`, () => {

    for (const page of pages) {
      test(`${page} loads`, async ({ request }) => {
        if (who === 'player') {
          const name = await registerUser(request);
          await login(request, name);
        }
        const res = await request.get(`/${page}`, { maxRedirects: 0 });
        expect([200, 301, 302], `HTTP status for ${page}`).toContain(res.status());
        const body = await res.text();
        const match = body.match(PHP_ERROR);
        expect(match ? body.slice(Math.max(0, match.index - 100), match.index + 300) : null, `PHP error on ${page}`).toBeNull();

        // Pages with the site footer use the shared one (working links, current year).
        if (body.includes('<footer id="gradient"')) {
          expect(body, `footer contact link on ${page}`).toContain('<a href="/contactform.html">Contact Me!</a>');
          expect(body, `footer year on ${page}`).toContain(`© 2019-${new Date().getFullYear()}`);
        }
      });
    }
  });
}

test('ZombCube links to its own privacy policy', async ({ request }) => {
  const body = await (await request.get('/ZombCube/index.php')).text();
  expect(body).toContain('<a href="/ZombCube/PrivacyPolicy.html">Privacy Policy</a>');
});

// These three are plain HTML (no PHP), so their footer is kept in step by hand.
for (const htmlPage of ['terms.html', 'privacyPolicy.html', 'contactform.html']) {
  test(`${htmlPage} footer matches the shared footer`, async ({ page }) => {
    await page.route(/^https?:\/\/(?!127\.0\.0\.1)/, (route) => route.abort());
    await page.goto(`/${htmlPage}`);
    const footer = page.locator('footer#gradient');
    await expect(footer).toContainText(`© 2019-${new Date().getFullYear()} MM's Gaming Community LLC`);
    for (const href of ['/sitemap.xml', '/terms.html', '/privacyPolicy.html', '/contactform.html']) {
      await expect(footer.locator(`a[href="${href}"]`)).toHaveCount(1);
    }
  });
}
