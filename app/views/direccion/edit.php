<?php $basePath = '/public/'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar dirección</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
    <div class="layout">
        <header class="page-header">
            <div>
                <p class="eyebrow">Relaciones</p>
                <h1>Editar dirección</h1>
                <p class="subtitle">Actualiza la información sin perder la relación con la persona.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>direccion">← Volver al listado</a>
            </div>
        </header>

        <form class="form-card" action="<?php echo $basePath; ?>direccion/update" method="POST">
            <input type="hidden" name="iddireccion" value="<?php echo htmlspecialchars($direccion['iddireccion']); ?>">
            <h2 class="form-title">Datos de la dirección</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="idpersona">Persona</label>
                    <select class="select" name="idpersona" id="idpersona" required>
                        <?php foreach ($personas as $persona): ?>
                            <option value="<?= $persona['idpersona']; ?>" <?= $persona['idpersona'] == $direccion['idpersona'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($persona['nombres'] . ' ' . $persona['apellidos']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="nombre">Dirección</label>
                    <input class="input" type="text" name="nombre" id="nombre" value="<?php echo htmlspecialchars($direccion['nombre']); ?>" required>
                </div>
            </div>
            <div class="footer-actions">
                <p class="helper">Revisa antes de guardar.</p>
                <button class="btn btn-success" type="submit">Actualizar</button>
            </div>
        </form>
    </div>
</body>
</html>
