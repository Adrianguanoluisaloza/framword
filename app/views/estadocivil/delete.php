<?php
require_once dirname(__DIR__, 2) . '/helpers/url_helper.php';
$basePath = $basePath ?? app_base_path();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar estado civil</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <div class="layout">
        <header class="page-header">
            <div>
                <p class="eyebrow">Catálogos</p>
                <h1>Eliminar estado civil</h1>
                <p class="subtitle">Confirma antes de eliminar la opción seleccionada.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>estadocivil">Cancelar</a>
            </div>
        </header>

        <form class="form-card" action="<?php echo $basePath; ?>estadocivil/delete" method="POST" data-confirm="¿Eliminar este estado civil?">
            <input type="hidden" name="idestadocivil" value="<?php echo htmlspecialchars($estadocivil['idestadocivil']); ?>">
            <div class="form-group">
                <label for="nombre">Estado civil</label>
                <input class="input" type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($estadocivil['nombre']); ?>" readonly>
                <p class="helper">Esta acción no se puede revertir.</p>
            </div>
            <div class="footer-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>estadocivil">← Volver</a>
                <button class="btn btn-danger" type="submit">Eliminar</button>
            </div>
        </form>
    </div>
    <script src="<?php echo $basePath; ?>js/script.js"></script>
</body>
</html>
