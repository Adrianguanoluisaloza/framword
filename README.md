
# framword-main

Proyecto PHP MVC minimal.

## Ejecución rápida en cualquier PC

### Requisitos
- PHP >= 8.2 (con extensiones pdo_mysql y mysqli)
- Podman o Docker (para la base de datos MySQL)

### 1. Clona el repositorio y entra al directorio
```bash
git clone <url-del-repo>
cd framword-main
```

### 2. Crea y ajusta el archivo `.env`
```bash
cp .env.example .env
# Edita .env si usas PHP local:
sed -i 's/^DB_HOST=db$/DB_HOST=127.0.0.1/' .env
# (puedes cambiar usuario/contraseña si lo deseas)
```

### 3. Inicia la base de datos MySQL con Podman/Docker
```bash
podman rm framword-db || docker rm framword-db || true
podman run -d --name framword-db -p 3306:3306 \
	-e MYSQL_DATABASE=framworddb \
	-e MYSQL_USER=framuser \
	-e MYSQL_PASSWORD=framword_pass \
	-e MYSQL_ROOT_PASSWORD=framword_root_pass \
	-v ./docker/mysql-init:/docker-entrypoint-initdb.d \
	docker.io/library/mysql:8.0
# Espera ~10 segundos a que MySQL arranque
```

### 4. Verifica que la base de datos está lista
```bash
podman ps --filter name=framword-db --format "table {{.Names}}\t{{.Ports}}\t{{.Status}}"

```
Debe mostrar algo como: `framword-db 0.0.0.0:3306->3306/tcp Up ...`

### 5. Prueba la conexión desde PHP CLI
```bash
php -r 'try{ $pdo=new PDO("mysql:host=127.0.0.1;port=3306;dbname=framworddb;charset=utf8mb4","framuser","framword_pass"); echo "Conexión OK\n"; } catch (PDOException $e){ echo "ERROR: ".$e->getMessage()."\n"; }'
```
Si ves `Conexión OK`, continúa.

### 6. Inicia el servidor PHP integrado
### Migraciones / Añadir tablas si tu contenedor ya existía
Si ya tenías un contenedor MySQL con datos, `docker/mysql-init/init.sql` no se vuelve a ejecutar automáticamente. Usa el script de migración para aplicar las tablas nuevas sin recrear el contenedor:

```bash
# Ejecuta la migración contra la DB configurada en .env
php scripts/migrate.php
```

Esto intentará ejecutar los statements del archivo `docker/mysql-init/init.sql` y dejará mensajes de advertencia si alguno falla (por ejemplo si ya existe la tabla).

Si prefieres recrear el contenedor para que se ejecute el init.sql desde el inicio, elimina el contenedor y el volumen de datos y recreate:

```bash
podman rm -f framword-db
podman run -d --name framword-db -p 3306:3306 \
	-e MYSQL_DATABASE=framworddb \
	-e MYSQL_USER=framuser \
	-e MYSQL_PASSWORD=framword_pass \
	-e MYSQL_ROOT_PASSWORD=framword_root_pass \
	-v ./docker/mysql-init:/docker-entrypoint-initdb.d \
	docker.io/library/mysql:8.0
```

Tras crear las tablas, puedes crear un admin con:
```bash
php scripts/create_admin.php "Admin" admin@example.com "password123"

Si además quieres datos de ejemplo para probar los nuevos módulos de Estudiantes/Universidades/Profesores:

```bash
php scripts/seed.php
```
```

```bash
pkill -f "php -S 127.0.0.1:8000" || true
# Usa el helper si está disponible (autodetecta contenedores o php CLI):
bash scripts/run.sh 8000
# o iniciar manualmente con CLI PHP:
php -S 127.0.0.1:8000 -t public
```

### 7. Accede a la aplicación
Abre en tu navegador:
```
http://127.0.0.1:8000/public/
```
o prueba con curl:
```bash
curl -I http://127.0.0.1:8000/public/persona/index
curl http://127.0.0.1:8000/public/persona/index | sed -n '1,200p'
```

### 8. Troubleshooting y reinicio
- Si la conexión falla, revisa que el contenedor MySQL esté corriendo y el puerto publicado.
- Si cambias credenciales, reinicia el contenedor y el servidor PHP.
- Para limpiar y reiniciar todo:
```bash
podman rm -f framword-db
podman run ... # (ver paso 3)
pkill -f "php -S 127.0.0.1:8000" || true
./run_local.sh 8000
```

## Notas de seguridad y buenas prácticas
- No subas tu archivo `.env` al repositorio (ya está en `.gitignore`).
- Las credenciales por defecto son solo para desarrollo.
- Si usas Docker Compose, los pasos son similares pero el host de la DB será `db`.

## Para compartir con tu equipo o IA
## Validación y UX de formularios
Se añadió validación server-side básica para los formularios de `Persona`:
- Comprueba campos obligatorios (nombres, apellidos, sexo, estado civil).
- Valida formato de fecha y que las referencias a `sexo`/`estadocivil` existan en la BD.
- Si hay errores, el formulario vuelve a mostrar los valores previos y mensajes por campo.

Prueba la validación:
1. Armar un POST con datos inválidos (por ejemplo, `nombres` vacío) y verificar que la página de creación muestre los errores y los valores previamente ingresados.
2. Armar un POST con `fechanacimiento` inválida (ej.: 2024-02-30) y verificar el error.

Esto deja una base solida para los futuros flujos: validación más compleja, mensajes por campo y tests de integración.

## Autenticación (usuarios, login y roles)
Se agregó autenticación básica (session-based) para proteger rutas que requieren login, por ejemplo el módulo de Personas.

### Crear usuario admin (desde host)
Una forma simple de crear el admin es usando el script PHP `scripts/create_admin.php`:
```bash
# Ejecuta desde la raíz del proyecto después de que la DB haya arrancado
php scripts/create_admin.php "Nombre Admin" admin@example.com "admin123"
```
Esto insertará un usuario admin con la contraseña indicada (hashed) en la tabla `users`.

### Rutas de autenticación
- `/public/auth/login` — formulario de login
- `/public/auth/register` — formulario de registro
- `/public/auth/logout` — cerrar sesión

### Cómo funciona
- Si intentas acceder a `/public/persona` u otras rutas protegidas, serás redirigido a `/public/auth/login`.
- Las rutas protegidas se pueden ajustar en `public/index.php` con `AuthMiddleware::requireLogin()`.

### Consideraciones
- En producción, evoluciona al uso de HTTPS, políticas de contraseñas, y bloqueo de intentos fallidos.
- Si usas `docker-compose` y quieres crear el admin desde el contenedor:
	- Ejecuta `podman exec -it framword-db` o abre un terminal con `podman run` y usa el script con las mismas variables de conexión.

Comparte este README y el archivo `.env.example`. Cualquier persona puede seguir estos pasos en Linux, Mac o WSL.

## ¿Problemas?
Pega la salida de los comandos de verificación y el log del servidor PHP para recibir ayuda.

### VSCode: advertencia "PHP executable not found"
- Si en VSCode ves la advertencia: "PHP executable not found. Install PHP and add it to your PATH or set php.debug.executablePath setting",
	asegúrate de que tengas instalada la CLI de PHP y que tu configuración local apunte al ejecutable.

- Pasos rápidos:
```bash
# Comprueba si tienes PHP CLI
php -v

# Si no aparece, en Debian/Ubuntu instala:
sudo apt update && sudo apt install php-cli php-mbstring php-xml php-json -y
```

- Si usas Docker y quieres ejecutar PHP desde el contenedor en VSCode, puedes usar rutas remotas o instaladores del binario local.
	También puedes especificar la ruta del ejecutable en el archivo de *workspace* `.vscode/settings.json` (ya incluido en el repo), por ejemplo:
	```json
	{
		"php.validate.executablePath": "${workspaceFolder}/scripts/php-wrapper.sh",
		"php.debug.executablePath": "${workspaceFolder}/scripts/php-wrapper.sh"
	}
	```

- Para comprobar automatizadamente si PHP está disponible, ejecuta:
	```bash
	bash scripts/check_php.sh
	```

Si te interesa que la extensión `PHP Debug` utilice tu PHP dentro de Docker para ejecutar pruebas o debugging en el contenedor, el wrapper `scripts/php-wrapper.sh` que añadimos lanzará el `docker run` o `docker compose exec` según disponibilidad. Asegúrate de que:

- Tienes `docker` o `docker compose` instalado y un servicio `web` en `docker-compose.yml` (como el repo).
- El contenedor `framword-web` está corriendo si usas `docker compose exec`.

Si prefieres usar el PHP local en lugar del contenedor, cambia `.vscode/settings.json` para usar `/usr/bin/php` o la ruta correcta en tu máquina (ej.: `/opt/homebrew/bin/php` para macOS Homebrew).



