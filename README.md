# Framword — Guía visual y pública

Framword es un proyecto educativo PHP que demuestra un patrón MVC simple para gestionar Personas, Teléfonos, Direcciones y módulos académicos (Estudiante, Profesor, Universidad).

Este README público explica las características principales, la ejecución rápida del proyecto, y ofrece capturas de la interfaz y enlaces a los PDF incluidos en el repositorio como evidencia.

---

## Qué incluye (resumen)

- CRUD para `Persona`, `Telefono`, `Direccion` con validaciones.
- Módulos académicos: `Estudiante`, `Profesor`, `Universidad`.
- Catálogos de referencia: `Sexo`, `Estado Civil` y más.
- Scripts de migración y seed para desarrollo: `scripts/migrate.php`, `scripts/seed.php`.
- Scripts de ayuda: `scripts/run.sh`, `scripts/php-wrapper.sh`, `scripts/check_php.sh`.

---

## Quick start (público)

Recomendado: usar Docker / docker-compose.

1) Clona el repo:
```bash
git clone https://github.com/Adrianguanoluisaloza/framword.git
cd framword
```
2) Copia `.env.example`:
```bash
cp .env.example .env
# Si ejecutas localmente sin docker compose, DB_HOST=127.0.0.1
```
3) Opcional: usa contenedores:
```bash
docker compose up -d --build
```
4) Correr migraciones y seeds si lo necesitas:
```bash
docker compose exec web php scripts/migrate.php
# opcional
docker compose exec web php scripts/seed.php
```
5) Accede: `http://127.0.0.1:8000/public/`

Para alternativas en PHP CLI o Podman revisa el README interno del proyecto.

---

## Vista visual — capturas y PDF (evidencias)

Las imágenes y PDFs se encuentran en `Imagenes de evidencias/`.

### Inicio y navegación

![Inicio](Imagenes%20de%20evidencias/Inicio.png)
*Inicio con navegación a módulos principales*.

### Login y registro

![Inicio de sesión](Imagenes%20de%20evidencias/iniio%20de%20sesiom.png)
![Registro](Imagenes%20de%20evidencias/registro.png)

### Crear persona (ejemplo)

![Crear persona](Imagenes%20de%20evidencias/crear%20personas.png)
*Formulario de creación y validación de `Persona`*

### Módulos académicos

![Estudiante](Imagenes%20de%20evidencias/estudiante.png)
![Profesor](Imagenes%20de%20evidencias/profesor.png)
![Universidad](Imagenes%20de%20evidencias/universidad.png)

### Catálogos y soporte

![Sexo](Imagenes%20de%20evidencias/sexo.png)
![Estado Civil](Imagenes%20de%20evidencias/estado%20civil.png)
![Telefono](Imagenes%20de%20evidencias/telefono.png)
![Direccion](Imagenes%20de%20evidencias/direccion.png)

### PDFs incluidos

- [Framework educativo.pdf](Imagenes%20de%20evidencias/Framework%20educativo.pdf) — Explica la visión y arquitectura educativa del proyecto.
- [Crear persona.pdf](Imagenes%20de%20evidencias/Crear%20persona.pdf) — Guía ilustrada del flujo de `Persona`.

---

## Persona: estructura y mapeo a BD 🧾

La entidad `Persona` es la pieza central del sistema: almacena la información básica de personas que pueden ser estudiantes, profesores o roles diversos.

Tabla en la BD: `persona`

Columnas principales:
- `idpersona` INT AUTO_INCREMENT PRIMARY KEY — Identificador único.
- `nombres` VARCHAR(255) NOT NULL — Nombres de la persona.
- `apellidos` VARCHAR(255) NOT NULL — Apellidos.
- `fechanacimiento` DATE NULL — Fecha de nacimiento.
- `rol` VARCHAR(20) NOT NULL DEFAULT 'estudiante' — Rol en el sistema (ej.: estudiante, profesor).
- `detalle` TEXT NULL — Campo de texto para datos adicionales.
- `idsexo` INT NULL — FK a tabla `sexo` (masculino/femenino) — ON DELETE SET NULL.
- `idestadocivil` INT NULL — FK a tabla `estadocivil` — ON DELETE SET NULL.

Relaciones y tablas asociadas:
- `telefono` — (1:N) cada `persona` puede tener varios `telefonos` (tabla `telefono` con `idpersona`).
- `direccion` — (1:N) cada `persona` puede tener varias `direcciones` (tabla `direccion` con `idpersona`).
- `estudiantes` / `profesores` — (1:1) tablas que dependan de `persona` para roles académicos (en este proyecto, se gestionan por separado en tablas `estudiantes` y `profesores` para datos específicos como `matricula` o `rfc`).

Ejemplo: cómo agregar una persona usando SQL
```sql
INSERT INTO persona (nombres, apellidos, fechanacimiento, rol, detalle, idsexo, idestadocivil)
VALUES ('Juan', 'Pérez', '1997-05-13', 'estudiante', 'Referencia: exalumno', 1, 1);
```

Ejemplo: consulta para recuperar persona y teléfonos
```sql
SELECT p.*, t.numero FROM persona p
LEFT JOIN telefono t ON p.idpersona = t.idpersona
WHERE p.idpersona = 1;
```

Modelo PHP (`app/models/Persona.php`) — mapeo de campos
- `public $id`, `public $nombres`, `public $apellidos`, `public $fechanacimiento`, `public $rol`, `public $detalle`, `public $idsexo`, `public $idestadocivil`

Nota: En el código del proyecto, hay helpers (`entity_helper.php`) para insertar/actualizar personas y sus entidades asociadas. También existen scripts `scripts/migrate.php` y `docker/mysql-init/init.sql` que definen la estructura exacta y pueden usarse para crear la BD localmente.

---

Puedes encontrar un diagrama ER simple y un script SQL del esquema en `Imagenes de evidencias/er_diagram.svg` y `scripts/schema_dump.sql`.

---

## Preguntas frecuentes (público)

- ¿Puedo usarlo en producción?
  No, este proyecto es principalmente para aprendizaje y demostración. Requiere ajustes (seguridad, autenticación robusta, saneamiento de entrada, etc.) para producción.

- ¿Cómo creo un usuario admin?
```bash
php scripts/create_admin.php "Administrador" admin@example.com "admin123"
```

---

 
---

## Galería (miniaturas) 📸

Aquí tienes una galería con miniaturas; haz clic en la imagen para verla completa.

<table>
  <tr>
    <td align="center"><a href="Imagenes%20de%20evidencias/Inicio.png"><img src="Imagenes%20de%20evidencias/Inicio.png" width="240" alt="Inicio"><br><em>Inicio</em></a></td>
    <td align="center"><a href="Imagenes%20de%20evidencias/crear%20personas.png"><img src="Imagenes%20de%20evidencias/crear%20personas.png" width="240" alt="Crear persona"><br><em>Crear persona</em></a></td>
    <td align="center"><a href="Imagenes%20de%20evidencias/registro.png"><img src="Imagenes%20de%20evidencias/registro.png" width="240" alt="Registro"><br><em>Registro</em></a></td>
  </tr>
  <tr>
    <td align="center"><a href="Imagenes%20de%20evidencias/iniio%20de%20sesiom.png"><img src="Imagenes%20de%20evidencias/iniio%20de%20sesiom.png" width="240" alt="Inicio de sesión"><br><em>Inicio de sesión</em></a></td>
    <td align="center"><a href="Imagenes%20de%20evidencias/estudiante.png"><img src="Imagenes%20de%20evidencias/estudiante.png" width="240" alt="Estudiante"><br><em>Estudiante</em></a></td>
    <td align="center"><a href="Imagenes%20de%20evidencias/profesor.png"><img src="Imagenes%20de%20evidencias/profesor.png" width="240" alt="Profesor"><br><em>Profesor</em></a></td>
  </tr>
  <tr>
    <td align="center"><a href="Imagenes%20de%20evidencias/universidad.png"><img src="Imagenes%20de%20evidencias/universidad.png" width="240" alt="Universidad"><br><em>Universidad</em></a></td>
    <td align="center"><a href="Imagenes%20de%20evidencias/sexo.png"><img src="Imagenes%20de%20evidencias/sexo.png" width="240" alt="Sexo"><br><em>Sexo</em></a></td>
    <td align="center"><a href="Imagenes%20de%20evidencias/estado%20civil.png"><img src="Imagenes%20de%20evidencias/estado%20civil.png" width="240" alt="Estado Civil"><br><em>Estado Civil</em></a></td>
  </tr>
  <tr>
    <td align="center"><a href="Imagenes%20de%20evidencias/telefono.png"><img src="Imagenes%20de%20evidencias/telefono.png" width="240" alt="Telefono"><br><em>Teléfono</em></a></td>
    <td align="center"><a href="Imagenes%20de%20evidencias/direccion.png"><img src="Imagenes%20de%20evidencias/direccion.png" width="240" alt="Dirección"><br><em>Dirección</em></a></td>
    <td align="center"><a href="Imagenes%20de%20evidencias/Framework%20educativo.pdf"><img src="Imagenes%20de%20evidencias/Inicio.png" width="240" alt="Framework educativo PDF"><br><em>Framework educativo (PDF)</em></a></td>
  </tr>
</table>
