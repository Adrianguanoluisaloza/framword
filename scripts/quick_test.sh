#!/usr/bin/env bash
# Quick test script: check endpoints, migrations and seeds
# Usage: scripts/quick_test.sh [host] [port] [basePath]
set -euo pipefail

HOST=${1:-127.0.0.1}
PORT=${2:-8000}
BASE=${3:-/public/}
BASE=${BASE%/}/

URL_BASE="http://${HOST}:${PORT}${BASE}"

echo "Quick test: ${URL_BASE} (base)"

which php >/dev/null 2>&1 && echo "PHP: $(php -v | head -n1)" || echo "PHP CLI: not found"
which docker >/dev/null 2>&1 && echo "Docker: $(docker --version)" || echo "Docker: not found"

# Check health via status
echo "--- STATUS:"
curl -s -I ${URL_BASE}status || echo "Error calling ${URL_BASE}status"

# Check pages
echo "--- GET /estudiante"
curl -s -I ${URL_BASE}estudiante || echo "Error calling estudiante"

echo "--- GET /universidad"
curl -s -I ${URL_BASE}universidad || echo "Error calling universidad"

echo "--- GET /auth/login"
curl -s -I ${URL_BASE}auth/login || echo "Error calling auth/login"

# Quick DB checks via migrate and seed if php available
if which php >/dev/null 2>&1; then
  echo "Running migrate and seed via php CLI"
  php scripts/migrate.php || true
  php scripts/seed.php || true
else
  echo "Skipping migrate/seed: PHP CLI not found"
fi

echo "Quick test completed. If HTTP responses show 200 OK for the pages above, the web server is responding."
