#!/usr/bin/env bash
# Wrapper para ejecutar PHP con Docker si no hay PHP local
# Usar: scripts/php-wrapper.sh -v
set -euo pipefail

# Si hay PHP local, usarlo
if command -v php >/dev/null 2>&1; then
  exec php "$@"
fi

# Si no existe `docker-compose` o `docker compose`, intentar usar `docker run` con php image
# Preferimos `docker compose` si hay docker-compose.yml en workspace
if [ -f docker-compose.yml ] || [ -f docker-compose.yaml ]; then
  # Si el contenedor web está corriendo, ejecutar dentro del servicio `web`
  if docker ps --format '{{.Names}}' | grep -q "framword-web"; then
    exec docker compose exec web php "$@"
  elif docker ps --format '{{.Names}}' | grep -q "framword-web"; then
    exec docker-compose exec web php "$@"
  else
    # Intenta lanzar temporalmente un contenedor php para ejecutar el comando
    exec docker run --rm -v "$PWD":/app -w /app php:8.2-cli php "$@"
  fi
else
  # Sin docker-compose, lanzar contenedor temporal
  exec docker run --rm -v "$PWD":/app -w /app php:8.2-cli php "$@"
fi
