#!/usr/bin/env bash
# Starts the site locally for the tests with PHP's built-in web server.
# Writes a throwaway MMsGamingconfig.php (test database only) to a temp
# folder outside the repo and points the site at it with MMSG_CONFIG.
set -euo pipefail

PORT="${1:-8099}"
ROOT="$(cd "$(dirname "$0")/../.." && pwd)"
CONF_DIR="$(mktemp -d)"
CONF="$CONF_DIR/MMsGamingconfig.php"

cat > "$CONF" <<PHP
<?php
define('DB_SERVER', '${DB_HOST:-127.0.0.1}');
define('DB_USERNAME', '${DB_USER:-mmtest}');
define('DB_PASSWORD', '${DB_PASS:-testpw}');
define('DB_NAME', '${DB_NAME:-mmsg_test}');
// Test PayPal account (donations are only credited for payments to it).
define('PAYPAL_RECEIVER', 'seller@example.com');
PHP

export MMSG_CONFIG="$CONF"
# Several workers so simultaneous-request tests really run at the same time.
export PHP_CLI_SERVER_WORKERS="${PHP_CLI_SERVER_WORKERS:-4}"
exec php -d display_errors=1 -d log_errors=0 -S "127.0.0.1:${PORT}" -t "$ROOT"
