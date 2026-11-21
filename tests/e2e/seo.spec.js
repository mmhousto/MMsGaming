// SEO: social tags on every page, noindex on account pages, structured
// data, the generated sitemap and robots.txt.
const fs = require('fs');
const path = require('path');
const { test, expect } = require('@playwright/test');

function jsonLd(body) {
  return [...body.matchAll(/<script type="application\/ld\+json">(.*?)<\/script>/gs)].map((m) => JSON.parse(m[1]));
}

test('pages without their own social tags get them from the title and description', async ({ request }) => {
  const body = await (await request.get('/BattleRoyale/')).text();
  const title = body.match(/<title>(.*?)<\/title>/s)[1].trim();
  expect(body).toContain('<meta property="og:site_name" content="MM&#039;s Gaming Community">');
  expect(body).toContain(`<meta property="og:title" content="${title}">`);
  expect(body).toContain('<meta property="og:image" content="https://mms-gaming.com/MMsGCoo.png">');
  expect(body).toContain('<meta name="twitter:card" content="summary">');
  expect(body).not.toContain('noindex');
  // Added once, inside <head>.
  expect(body.match(/property="og:title"/g)).toHaveLength(1);
  expect(body.indexOf('og:title')).toBeLessThan(body.indexOf('</head>'));
});

test('a page that sets its own og:title is left alone', async ({ request }) => {
  const body = await (await request.get('/')).text();
  expect(body.match(/property="og:title"/g)).toHaveLength(1);
});

test('og:url uses the canonical address', async ({ request }) => {
  const body = await (await request.get('/HGWK/?utm_source=x')).text();
  expect(body).toContain('<meta property="og:url" content="https://mms-gaming.com/HGWK/">');
});

for (const page of ['/login.php', '/register.php', '/forgot-password.php']) {
  test(`${page} is marked noindex`, async ({ request }) => {
    const body = await (await request.get(page)).text();
    expect(body).toContain('<meta name="robots" content="noindex, follow">');
  });
}

test('game pages describe the game as structured data', async ({ request }) => {
  const body = await (await request.get('/HGWK/')).text();
  const game = jsonLd(body).find((d) => d['@type'] === 'VideoGame');
  expect(game).toBeTruthy();
  expect(game.name).toBe('Have Gun, Will Kill');
  expect(game.url).toBe('https://mms-gaming.com/HGWK/');
  expect(game.gamePlatform).toContain('Web browser');
  expect(game.offers.price).toBe('0');
  expect(game.publisher.name).toBe("MM's Gaming Community");
});

test('the home page describes the studio', async ({ request }) => {
  const body = await (await request.get('/')).text();
  const graph = jsonLd(body).find((d) => d['@graph'])['@graph'];
  expect(graph.map((n) => n['@type'])).toEqual(['Organization', 'WebSite']);
});

test('the sitemap lists real pages and games but not account pages', async ({ request }) => {
  const res = await request.get('/sitemap.php');
  expect(res.status()).toBe(200);
  expect(res.headers()['content-type']).toContain('application/xml');
  const xml = await res.text();
  expect(xml).toContain('<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">');
  for (const url of ['https://mms-gaming.com/', 'https://mms-gaming.com/Unity-Games.php', 'https://mms-gaming.com/HGWK/',
    'https://mms-gaming.com/Gravity-Balls/', 'https://mms-gaming.com/blog/']) {
    expect(xml).toContain(`<loc>${url}</loc>`);
  }
  for (const bad of ['login.php', 'register.php', 'forgot-password.php', 'profile.php', 'blog/index.php', '/tests/', '/templates/']) {
    expect(xml).not.toContain(bad);
  }
  // Every address appears once.
  const locs = [...xml.matchAll(/<loc>(.*?)<\/loc>/g)].map((m) => m[1]);
  expect(new Set(locs).size).toBe(locs.length);
});

test('robots.txt allows crawling and points at the sitemap', async ({ request }) => {
  const txt = await (await request.get('/robots.txt')).text();
  expect(txt).toContain('User-agent: *\nAllow: /');
  expect(txt).toContain('Sitemap: https://mms-gaming.com/sitemap.xml');
  expect(txt).not.toMatch(/Disallow: \/\s*$/m);
});

test('.htaccess serves sitemap.xml from sitemap.php', () => {
  const htaccess = fs.readFileSync(path.join(__dirname, '../../.htaccess'), 'utf8');
  expect(htaccess).toContain('RewriteRule ^sitemap\\.xml$ sitemap.php [L]');
});

test('blog canonical links point at real pages', async ({ request }) => {
  const body = await (await request.get('/blog/')).text();
  expect(body).toContain('<link rel="canonical" href="https://mms-gaming.com/blog/">');
  const post = await (await request.get('/blog/Precision-New-Input-System-Cinemachine-and-Target-Follow.php')).text();
  expect(post).toContain('<link rel="canonical" href="https://mms-gaming.com/blog/Precision-New-Input-System-Cinemachine-and-Target-Follow.php">');
});

test('every public page fits phone screens (viewport tag)', async () => {
  const root = path.join(__dirname, '../..');
  const pages = fs.readdirSync(root, { withFileTypes: true })
    .filter((d) => d.isDirectory() && fs.existsSync(path.join(root, d.name, 'index.php')))
    .map((d) => `${d.name}/index.php`)
    .filter((p) => !/^(tests|templates|db|docs|node_modules)\//.test(p))
    .concat(fs.readdirSync(root).filter((f) => /\.(php|html)$/.test(f)));
  const missing = pages.filter((p) => {
    const src = fs.readFileSync(path.join(root, p), 'utf8');
    return /<\/head>/i.test(src) && !/name="viewport"/i.test(src) && p !== 'freecontactforminstall.php';
  });
  expect(missing).toEqual([]);
});

test('UNO Online is now Duo with Friends at /Duo/', async ({ request }) => {
  const body = await (await request.get('/Duo/')).text();
  expect(body).toContain('<title>Play Duo with Friends Online Free | Multiplayer Card Game</title>');
  expect(body).toContain('<link rel="canonical" href="https://mms-gaming.com/Duo/">');
  expect(body).not.toContain('UNO');
  expect(body).not.toContain('must be played in http');
  const htaccess = fs.readFileSync(path.join(__dirname, '../../.htaccess'), 'utf8');
  expect(htaccess).toContain('RewriteRule ^UNO(/.*)?$ /Duo/ [R=301,L]');
  const xml = await (await request.get('/sitemap.php')).text();
  expect(xml).toContain('<loc>https://mms-gaming.com/Duo/</loc>');
  expect(xml).not.toContain('/UNO/');
});

test('Krew.io no longer tells visitors to switch to http', async ({ request }) => {
  const body = await (await request.get('/Krew/')).text();
  expect(body).not.toContain('must be played in http');
});
