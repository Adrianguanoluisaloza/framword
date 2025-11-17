<?php
require_once dirname(__DIR__, 2) . '/helpers/url_helper.php';
$basePath = $basePath ?? app_base_path();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar teléfono</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <div class="layout">
        <header class="page-header">
            <div>
                <p class="eyebrow">Relaciones</p>
                <h1>Eliminar teléfono</h1>
                <p class="subtitle">Confirma antes de retirar el número seleccionado.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>telefono">Cancelar</a>
            </div>
        </header>

        <form class="form-card" action="<?php echo $basePath; ?>telefono/delete" method="POST" data-confirm="¿Eliminar este teléfono?">
            <input type="hidden" name="idtelefono" value="<?php echo htmlspecialchars($telefono['idtelefono']); ?>">
            <div class="form-group">
                <label for="numero">Número de teléfono</label>
                <input class="input" type="text" name="numero" id="numero" value="<?php echo htmlspecialchars($telefono['numero']); ?>" readonly>
                <p class="helper">Esta acción no se puede deshacer.</p>
            </div>
            <div class="footer-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>telefono">← Volver</a>
                <button class="btn btn-danger" type="submit">Eliminar</button>
            </div>
        </form>
    </div>
    <script src="<?php echo $basePath; ?>js/script.js"></script>
</body>
</html>
