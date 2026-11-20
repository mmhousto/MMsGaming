// Before the test run: rebuild the test database from db/schema.sql + db/seed.sql
// and empty the file that collects the emails the site "sends" during tests.
const fs = require('fs');
const { resetDatabase } = require('./helpers/db');

module.exports = async () => {
  resetDatabase();
  if (process.env.MMSG_MAIL_LOG) fs.writeFileSync(process.env.MMSG_MAIL_LOG, '');
};
