<?php
// app/views/universidad/edit.php
require_once __DIR__ . '/../partials/navbar.php';
?>
<h2>Editar Universidad</h2>
<form method="post">
    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?= htmlspecialchars($old['nombre'] ?? '') ?>">
    <span class="error"><?= $errors['nombre'] ?? '' ?></span><br>
    <label>Clave:</label>
    <input type="text" name="clave" value="<?= htmlspecialchars($old['clave'] ?? '') ?>">
    <span class="error"><?= $errors['clave'] ?? '' ?></span><br>
    <button type="submit">Actualizar</button>
</form>
<a href="/universidad">Volver a la lista</a>
<?php
require_once dirname(__DIR__, 2) . '/helpers/url_helper.php';
$basePath = $basePath ?? app_base_path();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar universidad</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <div class="layout">
        <header class="page-header">
            <div>
                <p class="eyebrow">Universidades</p>
                <h1>Editar universidad</h1>
                <p class="subtitle">Actualiza los datos de la institución antes de guardar.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>universidad">← Volver al listado</a>
            </div>
        </header>

        <form class="form-card" method="post" action="<?php echo $basePath; ?>universidad/edit?id=<?= htmlspecialchars($_GET['id'] ?? '') ?>">
            <div class="form-grid">
                <div class="form-group form-group--full">
                    <label for="nombre">Nombre</label>
                    <input class="input" type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($old['nombre'] ?? '') ?>">
                    <?php if (!empty($errors['nombre'])): ?><div class="field-error"><?= htmlspecialchars($errors['nombre']); ?></div><?php endif; ?>
                </div>
                <div class="form-group form-group--full">
                    <label for="clave">Clave</label>
                    <input class="input" type="text" name="clave" id="clave" value="<?= htmlspecialchars($old['clave'] ?? '') ?>">
                    <?php if (!empty($errors['clave'])): ?><div class="field-error"><?= htmlspecialchars($errors['clave']); ?></div><?php endif; ?>
                </div>
            </div>
            <div class="footer-actions">
                <p class="helper">Los cambios se reflejarán en todos los módulos asociados.</p>
                <button class="btn btn-primary" type="submit">Actualizar universidad</button>
            </div>
        </form>
    </div>
    <script src="<?php echo $basePath; ?>js/script.js"></script>
</body>
</html>
