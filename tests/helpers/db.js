// Small helpers to read and write the TEST database from tests, using the
// mysql command-line client. Connection settings come from the same
// environment variables as scripts/start-server.sh.
const { execFileSync } = require('child_process');
const fs = require('fs');
const path = require('path');

const cfg = {
  host: process.env.DB_HOST || '127.0.0.1',
  user: process.env.DB_USER || 'mmtest',
  pass: process.env.DB_PASS || 'testpw',
  name: process.env.DB_NAME || 'mmsg_test',
};

if (!/test/i.test(cfg.name)) {
  // Safety catch: never let the tests wipe a database that isn't a test one.
  throw new Error(`Refusing to use database "${cfg.name}": its name must contain "test".`);
}

function mysql(sql, { db = true } = {}) {
  const args = ['-h', cfg.host, '-u', cfg.user, '--batch', '--skip-column-names'];
  if (cfg.pass) args.push(`-p${cfg.pass}`);
  if (db) args.push(cfg.name);
  return execFileSync('mysql', args, { input: sql, encoding: 'utf8' });
}

/** Run SQL and return rows as arrays of strings. */
function query(sql) {
  const out = mysql(sql).trim();
  return out ? out.split('\n').map((line) => line.split('\t')) : [];
}

/** Run SQL and return the first column of the first row. */
function scalar(sql) {
  const rows = query(sql);
  return rows.length ? rows[0][0] : null;
}

function resetDatabase() {
  const root = path.join(__dirname, '..', '..', 'db');
  const tables = ['users', 'custom', 'comments', 'replies', 'secondReplies', 'posts', 'games', 'pwdReset', 'rate_limits', 'email_verifications'];
  mysql(`CREATE DATABASE IF NOT EXISTS \`${cfg.name}\` CHARACTER SET utf8mb4;`, { db: false });
  mysql(
    'SET FOREIGN_KEY_CHECKS=0;\n' +
      tables.map((t) => `DROP TABLE IF EXISTS \`${t}\`;`).join('\n') +
      '\n' +
      fs.readFileSync(path.join(root, 'schema.sql'), 'utf8') +
      '\n' +
      fs.readFileSync(path.join(root, 'seed.sql'), 'utf8')
  );
}

/** Escape a value for use inside a single-quoted SQL string. */
function q(value) {
  return "'" + String(value).replace(/\\/g, '\\\\').replace(/'/g, "\\'") + "'";
}

module.exports = { query, scalar, mysql, resetDatabase, q };
