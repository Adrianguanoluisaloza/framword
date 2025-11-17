<?php
require_once dirname(__DIR__, 2) . '/helpers/url_helper.php';
$basePath = $basePath ?? app_base_path();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar sexo</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <div class="layout">
        <header class="page-header">
            <div>
                <p class="eyebrow">Catálogos</p>
                <h1>Editar sexo</h1>
                <p class="subtitle">Ajusta el nombre mostrado en formularios.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>sexo">← Volver al listado</a>
            </div>
        </header>

        <form class="form-card" action="<?php echo $basePath; ?>sexo/update" method="POST">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($sexo['id']); ?>">
            <h2 class="form-title">Datos del registro</h2>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input class="input" type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($sexo['nombre']); ?>" required>
            </div>
            <div class="footer-actions">
                <p class="helper">Los cambios impactarán inmediatamente en los formularios de personas.</p>
                <button class="btn btn-success" type="submit">Actualizar</button>
            </div>
        </form>
    </div>
    <script src="<?php echo $basePath; ?>js/script.js"></script>
</body>
</html>
