<?php $basePath = '/public/'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar persona</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <div class="layout">
        <header class="page-header">
            <div>
                <p class="eyebrow">Personas</p>
                <h1>Confirmar eliminación</h1>
                <p class="subtitle">El registro será eliminado de forma permanente.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>persona">Cancelar</a>
            </div>
        </header>

        <form class="form-card" action="<?php echo $basePath; ?>persona/delete" method="POST" data-confirm="¿Seguro que deseas eliminar esta persona?">
            <?php include __DIR__ . '/../partials/messages.php'; ?>
            <?php echo csrf_field(); ?>
            <input type="hidden" name="idpersona" value="<?php echo htmlspecialchars($persona['idpersona']); ?>">
            <div class="form-group">
                <label for="nombre">Persona seleccionada</label>
                <input class="input" type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($persona['nombres'] . ' ' . $persona['apellidos']); ?>" readonly>
                <p class="helper">Esta acción no se puede deshacer.</p>
            </div>
            <div class="footer-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>persona">← Volver</a>
                <button class="btn btn-danger" type="submit">Eliminar definitivamente</button>
            </div>
        </form>
    </div>
    <script src="<?php echo $basePath; ?>js/script.js"></script>
</body>
</html>
