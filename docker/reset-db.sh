#!/usr/bin/env bash
set -euo pipefail
# Script auxiliar para borrar volumenes y reiniciar base de datos

echo "Deteniendo y borrando los contenedores y volúmenes de la DB..."
docker compose down -v || podman compose down -v || true
echo "Reiniciando los contenedores..."
docker compose up --build -d || podman compose up --build -d
echo "Hecho. Revisa logs: docker compose logs -f db"
