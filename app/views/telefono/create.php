<?php $basePath = '/public/'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar teléfono</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
    <div class="layout">
        <header class="page-header">
            <div>
                <p class="eyebrow">Relaciones</p>
                <h1>Nuevo teléfono</h1>
                <p class="subtitle">Asocia un número con la persona indicada.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>telefono">← Volver al listado</a>
            </div>
        </header>

        <form class="form-card" action="<?php echo $basePath; ?>telefono/store" method="POST">
            <h2 class="form-title">Datos del teléfono</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="idpersona">Persona</label>
                    <select class="select" name="idpersona" id="idpersona" required>
                        <option value="">Seleccione una persona</option>
                        <?php if (!empty($personas) && is_array($personas)): ?>
                            <?php foreach ($personas as $persona): ?>
                                <option value="<?php echo htmlspecialchars($persona['idpersona']); ?>"><?php echo htmlspecialchars($persona['apellidos'] . ' ' . $persona['nombres']); ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option value="">No hay personas disponibles</option>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="numero">Número de teléfono</label>
                    <input class="input" type="text" name="numero" id="numero" required>
                </div>
            </div>
            <div class="footer-actions">
                <p class="helper">Valida el número antes de guardar.</p>
                <button class="btn btn-primary" type="submit">Guardar teléfono</button>
            </div>
        </form>
    </div>
</body>
</html>
