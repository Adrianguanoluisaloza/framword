#!/usr/bin/env bash
set -euo pipefail

# Script para ejecutar el proyecto usando el servidor web integrado de PHP
# Si PHP no está instalado, muestra instrucciones para instalarlo.

if ! command -v php >/dev/null 2>&1; then
  echo "PHP no está instalado en tu entorno."
  echo "Instálalo con apt/dnf/pacman o usa Docker (se incluye Dockerfile y docker-compose.yml)."
  echo
  echo "Ejemplos en Debian/Ubuntu:"
  echo "  sudo apt update && sudo apt install -y php php-cli php-mbstring php-xml php-mysql"
  echo "Ejemplos en Fedora/CentOS:"
  echo "  sudo dnf install -y php php-cli php-mbstring php-xml php-mysqlnd"
  echo
  echo "O ejecuta usando Docker:"
  echo "  docker-compose up --build"
  exit 1
fi

PORT=${1:-8000}
HOST=${2:-127.0.0.1}

# Si existe un archivo .env en la raíz, expórtalo para que las variables
# estén disponibles para el servidor PHP integrado.
if [ -f ".env" ]; then
  echo "Cargando variables de entorno desde .env"
  # Exportar todas las variables definidas en .env
  set -o allexport
  # shellcheck disable=SC1091
  . ./.env
  set +o allexport
fi

echo "Iniciando servidor PHP integrado en http://${HOST}:${PORT}/public/"
echo "Usando DB_HOST=${DB_HOST:-127.0.0.1} DB_NAME=${DB_NAME:-framworddb} DB_USER=${DB_USER:-framuser}"
php -S "${HOST}:${PORT}" -t .
