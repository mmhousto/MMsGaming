// Playwright test configuration for mms-gaming.com.
// Runs the site with PHP's built-in server against a throwaway test
// database (see scripts/), never against the live site.
const { defineConfig } = require('@playwright/test');

const PORT = process.env.TEST_PORT || '8099';

module.exports = defineConfig({
  testDir: './e2e',
  // Tests share one database, so run them one at a time for predictable results.
  workers: 1,
  fullyParallel: false,
  retries: process.env.CI ? 1 : 0,
  timeout: 60_000,
  reporter: process.env.CI ? [['list'], ['html', { open: 'never' }]] : 'list',
  globalSetup: require.resolve('./global-setup.js'),
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
