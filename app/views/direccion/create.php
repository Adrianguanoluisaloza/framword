<?php
require_once dirname(__DIR__, 2) . '/helpers/url_helper.php';
$basePath = $basePath ?? app_base_path();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva dirección</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <div class="layout">
        <header class="page-header">
            <div>
                <p class="eyebrow">Relaciones</p>
                <h1>Agregar dirección</h1>
                <p class="subtitle">Vincula una dirección a la persona correspondiente.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>direccion">← Volver al listado</a>
            </div>
        </header>

        <form class="form-card" action="<?php echo $basePath; ?>direccion/store" method="POST">
            <h2 class="form-title">Datos de la dirección</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="idpersona">Persona</label>
                    <select class="select" name="idpersona" id="idpersona" required>
                        <option value="">Seleccione una persona</option>
                        <?php foreach ($personas as $persona): ?>
                            <option value="<?= $persona['idpersona']; ?>"><?= htmlspecialchars($persona['nombres'] . ' ' . $persona['apellidos']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nombre">Dirección</label>
                    <input class="input" type="text" name="nombre" id="nombre" required>
                </div>
            </div>
            <div class="footer-actions">
                <p class="helper">Puedes editarla más adelante si lo necesitas.</p>
                <button class="btn btn-primary" type="submit">Guardar dirección</button>
            </div>
        </form>
    </div>
    <script src="<?php echo $basePath; ?>js/script.js"></script>
</body>
</html>
