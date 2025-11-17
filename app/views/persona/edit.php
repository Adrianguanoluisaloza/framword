<?php
require_once dirname(__DIR__, 2) . '/helpers/url_helper.php';
$basePath = $basePath ?? app_base_path();
?>
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
            <?php include __DIR__ . '/../partials/messages.php'; ?>
            <?php echo csrf_field(); ?>
            <input type="hidden" name="idpersona" value="<?= $persona['idpersona'] ?>">
            <h2 class="form-title">Datos generales</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="rol">Rol</label>
                    <select class="select" name="rol" id="rol" data-role-select required>
                        <?php foreach ($roles as $key => $label): 
                            $selected = $old['rol'] ?? $persona['rol'] ?? 'estudiante';
                        ?>
                            <option value="<?php echo $key; ?>" <?php echo ($selected === $key) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['rol'])): ?><div class="field-error"><?php echo htmlspecialchars($errors['rol']); ?></div><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="nombres">Nombres</label>
                    <input class="input" type="text" name="nombres" id="nombres" value="<?= htmlspecialchars($old['nombres'] ?? $persona['nombres']) ?>" required>
                    <?php if (!empty($errors['nombres'])): ?><div class="field-error"><?php echo htmlspecialchars($errors['nombres']); ?></div><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos</label>
                    <input class="input" type="text" name="apellidos" id="apellidos" value="<?= htmlspecialchars($old['apellidos'] ?? $persona['apellidos']) ?>" required>
                    <?php if (!empty($errors['apellidos'])): ?><div class="field-error"><?php echo htmlspecialchars($errors['apellidos']); ?></div><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="fechanacimiento">Fecha de nacimiento</label>
                    <input class="input" type="date" name="fechanacimiento" id="fechanacimiento" value="<?= htmlspecialchars($old['fechanacimiento'] ?? $persona['fechanacimiento']) ?>" required>
                    <?php if (!empty($errors['fechanacimiento'])): ?><div class="field-error"><?php echo htmlspecialchars($errors['fechanacimiento']); ?></div><?php endif; ?>
                </div>
                <div class="form-group form-group--full">
                    <label for="detalle" data-role-label>Detalle del perfil</label>
                    <textarea class="input" name="detalle" id="detalle" rows="3" data-role-field placeholder="Describe la carrera, especialidad o información clave."><?php echo htmlspecialchars($old['detalle'] ?? $persona['detalle'] ?? ''); ?></textarea>
                    <?php if (!empty($errors['detalle'])): ?><div class="field-error"><?php echo htmlspecialchars($errors['detalle']); ?></div><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="idsexo">Sexo</label>
                    <select class="select" name="idsexo" id="idsexo" required>
                        <?php foreach ($sexos as $sexo): ?>
                            <option value="<?= $sexo['id'] ?>" <?= ((string)($old['idsexo'] ?? '') === (string)$sexo['id']) ? 'selected' : ($sexo['id'] == $persona['idsexo'] ? 'selected' : '') ?>>
                                <?= htmlspecialchars($sexo['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['idsexo'])): ?><div class="field-error"><?php echo htmlspecialchars($errors['idsexo']); ?></div><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="idestadocivil">Estado civil</label>
                    <select class="select" name="idestadocivil" id="idestadocivil" required>
                        <?php foreach ($estadosciviles as $estadocivil): ?>
                            <option value="<?= $estadocivil['idestadocivil'] ?>" <?= ((string)($old['idestadocivil'] ?? '') === (string)$estadocivil['idestadocivil']) ? 'selected' : ($estadocivil['idestadocivil'] == $persona['idestadocivil'] ? 'selected' : '') ?>>
                                <?= htmlspecialchars($estadocivil['nombre']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['idestadocivil'])): ?><div class="field-error"><?php echo htmlspecialchars($errors['idestadocivil']); ?></div><?php endif; ?>
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
