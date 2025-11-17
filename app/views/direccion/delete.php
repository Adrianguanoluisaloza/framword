<?php $basePath = '/public/'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar dirección</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <div class="layout">
        <header class="page-header">
            <div>
                <p class="eyebrow">Relaciones</p>
                <h1>Eliminar dirección</h1>
                <p class="subtitle">Confirma antes de borrar la dirección seleccionada.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>direccion">Cancelar</a>
            </div>
        </header>

        <form class="form-card" action="<?php echo $basePath; ?>direccion/delete" method="POST" data-confirm="¿Eliminar esta dirección?">
            <input type="hidden" name="iddireccion" value="<?php echo htmlspecialchars($direccion['iddireccion']); ?>">
            <div class="form-group">
                <label for="nombre">Dirección</label>
                <input class="input" type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($direccion['nombre']); ?>" readonly>
                <p class="helper">Esta acción no se puede revertir.</p>
            </div>
            <div class="footer-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>direccion">← Volver</a>
                <button class="btn btn-danger" type="submit">Eliminar</button>
            </div>
        </form>
    </div>
    <script src="<?php echo $basePath; ?>js/script.js"></script>
</body>
</html>
