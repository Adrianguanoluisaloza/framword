<?php $basePath = '/public/'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear sexo</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
    <div class="layout">
        <header class="page-header">
            <div>
                <p class="eyebrow">Catálogos</p>
                <h1>Nuevo sexo</h1>
                <p class="subtitle">Añade opciones claras para los formularios de personas.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>sexo">← Volver al listado</a>
            </div>
        </header>

        <form class="form-card" action="<?php echo $basePath; ?>sexo/store" method="POST">
            <h2 class="form-title">Datos básicos</h2>
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input class="input" type="text" name="nombre" id="nombre" required>
            </div>
            <div class="footer-actions">
                <p class="helper">Este valor estará disponible al crear o editar personas.</p>
                <button class="btn btn-primary" type="submit">Crear</button>
            </div>
        </form>
    </div>
</body>
</html>
