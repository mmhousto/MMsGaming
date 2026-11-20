// Playwright test configuration for mms-gaming.com.
// Runs the site with PHP's built-in server against a throwaway test
// database (see scripts/), never against the live site.
const { defineConfig } = require('@playwright/test');

const PORT = process.env.TEST_PORT || '8099';

module.exports = defineConfig({
  // Tests share one database, so run them one at a time for predictable results.
  workers: 1,
  fullyParallel: false,
  retries: process.env.CI ? 1 : 0,
  timeout: 60_000,
  reporter: process.env.CI ? [['list'], ['html', { open: 'never' }]] : 'list',
  globalSetup: require.resolve('./global-setup.js'),
  projects: [
    // The normal suite (what GitHub runs).
    { name: 'e2e', testDir: './e2e' },
    // Screenshot comparison for layout changes; only run with --project=visual.
    {
      name: 'visual',
      testDir: './visual',
      testMatch: /\.visual\.js$/,
      snapshotPathTemplate: '{testDir}/__screenshots__/{arg}{ext}',
      use: { viewport: { width: 1280, height: 800 } },
    },
  ],
  use: {
    baseURL: `http://127.0.0.1:${PORT}`,
    trace: 'off',
    // Block third-party ads/analytics so tests don't depend on the internet.
    serviceWorkers: 'block',
  },
  webServer: {
    command: `bash scripts/start-server.sh ${PORT}`,
    url: `http://127.0.0.1:${PORT}/robots.txt`,
    reuseExistingServer: !process.env.CI,
    timeout: 30_000,
    stdout: 'ignore',
    stderr: 'ignore',
  },
});
