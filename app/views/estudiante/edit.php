<?php
require_once dirname(__DIR__, 2) . '/helpers/url_helper.php';
$basePath = $basePath ?? app_base_path();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar estudiante</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <div class="layout">
        <header class="page-header">
            <div>
                <p class="eyebrow">Estudiantes</p>
                <h1>Editar estudiante</h1>
                <p class="subtitle">Actualiza la información antes de guardar.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>estudiante">← Volver al listado</a>
            </div>
        </header>

        <form class="form-card" method="post" action="<?php echo $basePath; ?>estudiante/edit?id=<?= htmlspecialchars($_GET['id'] ?? '') ?>">
            <div class="form-grid">
                <div class="form-group form-group--full">
                    <label for="nombre">Nombre completo</label>
                    <input class="input" type="text" name="nombre" id="nombre" value="<?= htmlspecialchars($old['nombre'] ?? '') ?>">
                    <?php if (!empty($errors['nombre'])): ?><div class="field-error"><?= htmlspecialchars($errors['nombre']); ?></div><?php endif; ?>
                </div>
                <div class="form-group form-group--full">
                    <label for="matricula">Matrícula</label>
                    <input class="input" type="text" name="matricula" id="matricula" value="<?= htmlspecialchars($old['matricula'] ?? '') ?>">
                    <?php if (!empty($errors['matricula'])): ?><div class="field-error"><?= htmlspecialchars($errors['matricula']); ?></div><?php endif; ?>
                </div>
                <div class="form-group form-group--full">
                    <label for="universidad_id">ID de universidad</label>
                    <input class="input" type="number" name="universidad_id" id="universidad_id" value="<?= htmlspecialchars($old['universidad_id'] ?? '') ?>">
                    <?php if (!empty($errors['universidad_id'])): ?><div class="field-error"><?= htmlspecialchars($errors['universidad_id']); ?></div><?php endif; ?>
                </div>
            </div>
            <div class="footer-actions">
                <p class="helper">Los cambios se reflejarán inmediatamente en listados y reportes.</p>
                <button class="btn btn-primary" type="submit">Actualizar estudiante</button>
            </div>
        </form>
    </div>
    <script src="<?php echo $basePath; ?>js/script.js"></script>
</body>
</html>
