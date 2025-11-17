<?php $basePath = '/public/'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar estado civil</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
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

        <form class="form-card" action="<?php echo $basePath; ?>estadocivil/delete" method="POST">
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
</body>
</html>
