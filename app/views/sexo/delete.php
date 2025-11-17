<?php $basePath = '/public/'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar sexo</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <div class="layout">
        <header class="page-header">
            <div>
                <p class="eyebrow">Catálogos</p>
                <h1>Eliminar sexo</h1>
                <p class="subtitle">Confirma la eliminación antes de continuar.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>sexo">Cancelar</a>
            </div>
        </header>

        <form class="form-card" action="<?php echo $basePath; ?>sexo/delete" method="POST" data-confirm="¿Eliminar este registro de sexo?">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($sexo['id']); ?>">
            <div class="form-group">
                <label for="nombre">Registro seleccionado</label>
                <input class="input" type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($sexo['nombre']); ?>" readonly>
                <p class="helper">Esta acción no se puede deshacer.</p>
            </div>
            <div class="footer-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>sexo">← Volver</a>
                <button class="btn btn-danger" type="submit">Eliminar</button>
            </div>
        </form>
    </div>
    <script src="<?php echo $basePath; ?>js/script.js"></script>
</body>
</html>
