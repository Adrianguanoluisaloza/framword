<?php $basePath = '/public/'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar teléfono</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
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

        <form class="form-card" action="<?php echo $basePath; ?>telefono/delete" method="POST">
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
</body>
</html>
