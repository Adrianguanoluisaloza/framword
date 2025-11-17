#!/usr/bin/env bash
set -e
# Run the project using podman-compose, docker-compose or fallback to PHP built-in server
ROOT_DIR="$(cd "$(dirname "$0")/.." && pwd)"
cd "$ROOT_DIR"

PORT=${1:-8080}

if command -v podman-compose >/dev/null 2>&1; then
  echo "Using podman-compose to run the project..."
  podman-compose down || true
  podman-compose up -d --build
  echo "Podman Compose started. Web: http://localhost:$PORT"
  exit 0
fi

if command -v docker-compose >/dev/null 2>&1 || command -v docker-compose >/dev/null 2>&1; then
  echo "Using docker-compose to run the project..."
  docker-compose down || true
  docker-compose up -d --build
  echo "Docker Compose started. Web: http://localhost:$PORT"
  exit 0
fi

if command -v php >/dev/null 2>&1; then
  echo "No container tool detected; using PHP built-in server on port $PORT (docroot: project root)"
  php -S 0.0.0.0:$PORT -t .
  exit 0
fi

cat <<EOF
No podman-compose, docker-compose or PHP CLI found in PATH.
Please install one of them or run the server manually.
EOF
exit 1
