<?php
require_once dirname(__DIR__, 2) . '/helpers/url_helper.php';
$basePath = $basePath ?? app_base_path();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar teléfono</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <div class="layout">
        <header class="page-header">
            <div>
                <p class="eyebrow">Relaciones</p>
                <h1>Actualizar teléfono</h1>
                <p class="subtitle">Modifica el número manteniendo la relación con la persona.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>telefono">← Volver al listado</a>
            </div>
        </header>

        <form class="form-card" action="<?php echo $basePath; ?>telefono/update" method="POST">
            <input type="hidden" name="idtelefono" value="<?php echo htmlspecialchars($telefono['idtelefono']); ?>">
            <h2 class="form-title">Datos del teléfono</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="idpersona">Persona</label>
                    <select class="select" name="idpersona" id="idpersona" required>
                        <?php foreach ($personas as $persona): ?>
                            <option value="<?= $persona['idpersona']; ?>" <?= $persona['idpersona'] == $telefono['idpersona'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($persona['apellidos'] . ' ' . $persona['nombres']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="numero">Número de teléfono</label>
                    <input class="input" type="text" name="numero" id="numero" value="<?php echo htmlspecialchars($telefono['numero']); ?>" required>
                </div>
            </div>
            <div class="footer-actions">
                <p class="helper">Guarda el cambio para actualizar el contacto.</p>
                <button class="btn btn-success" type="submit">Actualizar teléfono</button>
            </div>
        </form>
    </div>
    <script src="<?php echo $basePath; ?>js/script.js"></script>
</body>
</html>
