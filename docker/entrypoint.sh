#!/usr/bin/env bash
set -euo pipefail

# Entrypoint: espera a la base de datos y luego arranca Apache
echo "Entrypoint: verificar DB..."
# PHP script will exit with 0 on success
php /var/www/html/docker/wait-for-db.php || {
  echo "Advertencia: la base de datos no está disponible después del timeout. Procediendo de todos modos..."
}

exec apache2-foreground
