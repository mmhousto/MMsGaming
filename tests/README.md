# Automated tests

These tests run the site locally against a **throwaway test database**,
never the live site. GitHub runs them automatically on every push and pull
request (see `.github/workflows/tests.yml`). Merge to `master` only when the
check is green, because Hostinger deploys `master` straight to the live site.

## What is covered

| File | What it checks |
| --- | --- |
| `e2e/pages.spec.js` | Every page loads with no PHP error, logged out and logged in |
| `e2e/accounts.spec.js` | Sign-up, login, logout, username rules, sign-up error messages |
| `e2e/points.spec.js` | Only logged-in players earn points; at most once per 25 seconds |
| `e2e/store.spec.js` | Buying each item, prices, "Already Own", simultaneous purchases, input checks |
| `e2e/comments.spec.js` | Posting, editing, deleting comments; no posting as someone else |
| `e2e/security.spec.js` | Email change, SQL in usernames, script injection, no password in config |

## Running them on your computer

You need PHP 8 (with mysqli), Node.js 22, and MariaDB or MySQL.

1. Create a test database and user (the name must contain `test`):

   ```sql
   CREATE DATABASE mmsg_test;
   CREATE USER 'mmtest'@'127.0.0.1' IDENTIFIED BY 'testpw';
   GRANT ALL ON mmsg_test.* TO 'mmtest'@'127.0.0.1';
   ```

2. Install and run (from this `tests` folder):

   ```bash
   npm install
   npx playwright install chromium
   npx playwright test
   ```

Different database settings can be passed with `DB_HOST`, `DB_USER`,
`DB_PASS` and `DB_NAME`. The tables are rebuilt from `db/schema.sql` and
`db/seed.sql` at the start of every run.

These files are deployed with the site, but `.htaccess` makes them return
"not found" to visitors.
