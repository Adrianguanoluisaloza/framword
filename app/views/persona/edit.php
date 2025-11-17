<?php $basePath = '/public/'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar persona</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <div class="layout">
        <header class="page-header">
            <div>
                <p class="eyebrow">Personas</p>
                <h1>Editar persona</h1>
                <p class="subtitle">Actualiza los datos y mantiene la información sincronizada.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>persona">← Volver al listado</a>
            </div>
        </header>

        <form class="form-card" action="<?php echo $basePath; ?>persona/update" method="POST">
            <input type="hidden" name="idpersona" value="<?= $persona['idpersona'] ?>">
            <h2 class="form-title">Datos generales</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="nombres">Nombres</label>
                    <input class="input" type="text" name="nombres" id="nombres" value="<?= htmlspecialchars($persona['nombres']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos</label>
                    <input class="input" type="text" name="apellidos" id="apellidos" value="<?= htmlspecialchars($persona['apellidos']) ?>" required>
                </div>
                <div class="form-group">
                    <label for="fechanacimiento">Fecha de nacimiento</label>
                    <input class="input" type="date" name="fechanacimiento" id="fechanacimiento" value="<?= $persona['fechanacimiento'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="idsexo">Sexo</label>
                    <select class="select" name="idsexo" id="idsexo" required>
                        <?php foreach ($sexos as $sexo): ?>
                            <option value="<?= $sexo['id'] ?>" <?= $sexo['id'] == $persona['idsexo'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($sexo['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="idestadocivil">Estado civil</label>
                    <select class="select" name="idestadocivil" id="idestadocivil" required>
                        <?php foreach ($estadosciviles as $estadocivil): ?>
                            <option value="<?= $estadocivil['idestadocivil'] ?>" <?= $estadocivil['idestadocivil'] == $persona['idestadocivil'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($estadocivil['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="footer-actions">
                <p class="helper">Tus cambios quedarán guardados inmediatamente después de actualizar.</p>
                <button class="btn btn-success" type="submit">Actualizar persona</button>
            </div>
        </form>
    </div>
    <script src="<?php echo $basePath; ?>js/script.js"></script>
</body>
</html>
