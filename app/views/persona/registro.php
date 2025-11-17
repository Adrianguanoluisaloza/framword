<?php
require_once dirname(__DIR__, 2) . '/helpers/url_helper.php';
$basePath = $basePath ?? app_base_path();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle de persona</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <div class="layout">
        <header class="page-header">
            <div>
                <p class="eyebrow">Personas</p>
                <h1>Detalle y vínculos</h1>
                <p class="subtitle">Edita los datos principales y consulta teléfonos y direcciones asociados.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>persona">← Volver al listado</a>
            </div>
        </header>

        <form class="form-card" action="<?php echo $basePath; ?>persona/update" method="POST">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="idpersona" value="<?= $persona['idpersona'] ?>">
            <h2 class="form-title">Información de la persona</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="rol">Rol</label>
                    <select class="select" name="rol" id="rol" data-role-select required>
                        <?php foreach ($roles as $key => $label): ?>
                            <option value="<?php echo $key; ?>" <?php echo (($persona['rol'] ?? 'estudiante') === $key) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nombres">Nombres</label>
                    <input class="input" type="text" name="nombres" id="nombres" value="<?= htmlspecialchars($persona['nombres']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos</label>
                    <input class="input" type="text" name="apellidos" id="apellidos" value="<?= htmlspecialchars($persona['apellidos']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="fechanacimiento">Fecha de nacimiento</label>
                    <input class="input" type="date" name="fechanacimiento" id="fechanacimiento" value="<?= $persona['fechanacimiento'] ?>" required>
                </div>
                <div class="form-group form-group--full">
                    <label for="detalle" data-role-label>Detalle del perfil</label>
                    <textarea class="input" name="detalle" id="detalle" rows="3" data-role-field placeholder="Describe la carrera, especialidad o información clave."><?php echo htmlspecialchars($persona['detalle'] ?? ''); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="idsexo">Sexo</label>
                    <select class="select" name="idsexo" id="idsexo" required>
                        <?php foreach ($sexos as $sexo): ?>
                            <option value="<?= $sexo['id'] ?>" <?= $sexo['id'] == $persona['idsexo'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($sexo['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="idestadocivil">Estado civil</label>
                    <select class="select" name="idestadocivil" id="idestadocivil" required>
                        <?php foreach ($estadosciviles as $estadocivil): ?>
                            <option value="<?= $estadocivil['idestadocivil'] ?>" <?= $estadocivil['idestadocivil'] == $persona['idestadocivil'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($estadocivil['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="footer-actions">
                <p class="helper">Guarda los cambios y los vínculos se mantendrán intactos.</p>
                <button class="btn btn-success" type="submit">Actualizar persona</button>
            </div>
        </form>

        <div class="card">
            <h3 class="section-title">Teléfonos registrados</h3>
            <?php if (!empty($telefonos)): ?>
                <div class="pill-list">
                    <?php foreach ($telefonos as $telefono): ?>
                        <div class="pill">
                            <span>ID: <?= $telefono['idtelefono'] ?></span>
                            <span>Número: <?= htmlspecialchars($telefono['numero']) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="empty-state">No hay teléfonos registrados.</p>
            <?php endif; ?>
        </div>

        <div class="card">
            <h3 class="section-title">Direcciones registradas</h3>
            <?php if (!empty($direcciones)): ?>
                <div class="pill-list">
                    <?php foreach ($direcciones as $direccion): ?>
                        <div class="pill">
                            <span>ID: <?= $direccion['iddireccion'] ?></span>
                            <span>Dirección: <?= htmlspecialchars($direccion['nombre']) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="empty-state">No hay direcciones registradas.</p>
            <?php endif; ?>
        </div>
    </div>
    <script src="<?php echo $basePath; ?>js/script.js"></script>
</body>
</html>
