#!/usr/bin/env bash
# Comprobar si PHP CLI está instalado y mostrar la ruta
set -euo pipefail

if command -v php >/dev/null 2>&1; then
  PHP_PATH=$(command -v php)
  echo "PHP CLI encontrado: $PHP_PATH"
  php -v
  echo
  echo "Si VSCode muestra un aviso 'PHP executable not found', asegúrate de que las siguientes paths coincidan en tu configuración de workspace y user settings:" 
  echo "  - .vscode/settings.json -> php.validate.executablePath"
  echo "  - .vscode/settings.json -> php.debug.executablePath"
  echo "  - User settings (si aplica): php.validate.executablePath"
  exit 0
else
  echo "PHP CLI no encontrado en PATH. Para instalar en Debian/Ubuntu:"
  echo "  sudo apt update && sudo apt install php-cli php-mbstring php-xml php-json -y"
  echo "Si usas Docker, puedes ejecutar las herramientas desde el contenedor o instalar PHP localmente."
  exit 1
fi

echo
echo "Si prefieres ejecutar PHP dentro de Docker, usa el wrapper: scripts/php-wrapper.sh"
if [ -x scripts/php-wrapper.sh ]; then
  echo ">> Prueba wrapper (no correrá en este entorno, solo verificación):"
  scripts/php-wrapper.sh -v || true
fi
