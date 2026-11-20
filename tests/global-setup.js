// Before the test run: rebuild the test database from db/schema.sql + db/seed.sql.
const { resetDatabase } = require('./helpers/db');

module.exports = async () => {
  resetDatabase();
};
