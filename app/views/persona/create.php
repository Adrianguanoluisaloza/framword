<?php $basePath = '/public/'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear persona</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <div class="layout">
        <header class="page-header">
            <div>
                <p class="eyebrow">Personas</p>
                <h1>Nueva persona</h1>
                <p class="subtitle">Registra los datos principales, sexo y estado civil.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>persona">← Volver al listado</a>
            </div>
        </header>

        <form class="form-card" action="<?php echo $basePath; ?>persona/store" method="POST">
            <?php include __DIR__ . '/../partials/messages.php'; ?>
            <?php echo csrf_field(); ?>
            <h2 class="form-title">Información principal</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="rol">Rol</label>
                    <select class="select" name="rol" id="rol" data-role-select required>
                        <?php foreach ($roles as $key => $label): ?>
                            <option value="<?php echo $key; ?>" <?php echo (($old['rol'] ?? '') === $key) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($label); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (!empty($errors['rol'])): ?><div class="field-error"><?php echo htmlspecialchars($errors['rol']); ?></div><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="nombres">Nombres</label>
                    <input class="input" type="text" name="nombres" id="nombres" required value="<?php echo htmlspecialchars($old['nombres'] ?? ''); ?>">
                    <?php if (!empty($errors['nombres'])): ?><div class="field-error"><?php echo htmlspecialchars($errors['nombres']); ?></div><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos</label>
                    <input class="input" type="text" name="apellidos" id="apellidos" required value="<?php echo htmlspecialchars($old['apellidos'] ?? ''); ?>">
                    <?php if (!empty($errors['apellidos'])): ?><div class="field-error"><?php echo htmlspecialchars($errors['apellidos']); ?></div><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="fechanacimiento">Fecha de nacimiento</label>
                    <input class="input" type="date" name="fechanacimiento" id="fechanacimiento" required value="<?php echo htmlspecialchars($old['fechanacimiento'] ?? ''); ?>">
                    <?php if (!empty($errors['fechanacimiento'])): ?><div class="field-error"><?php echo htmlspecialchars($errors['fechanacimiento']); ?></div><?php endif; ?>
                </div>
                <div class="form-group form-group--full">
                    <label for="detalle" data-role-label>Detalle del perfil</label>
                    <textarea class="input" name="detalle" id="detalle" rows="3" data-role-field placeholder="Describe la carrera, especialidad o información clave."><?php echo htmlspecialchars($old['detalle'] ?? ''); ?></textarea>
                    <?php if (!empty($errors['detalle'])): ?><div class="field-error"><?php echo htmlspecialchars($errors['detalle']); ?></div><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="idsexo">Sexo</label>
                    <select class="select" name="idsexo" id="idsexo" required>
                        <option value="">Seleccione un sexo</option>
                        <?php
                        if (isset($sexos) && !empty($sexos)):
                            foreach ($sexos as $sexo):
                                $sel = ((string)($old['idsexo'] ?? '') === (string)$sexo['id']) ? 'selected' : '';
                                echo '<option value="' . $sexo['id'] . '" ' . $sel . '>' . htmlspecialchars($sexo['nombre']) . '</option>';
                            endforeach;
                        else:
                            echo '<option value="">No hay sexos disponibles</option>';
                        endif;
                        ?>
                    </select>
                    <?php if (!empty($errors['idsexo'])): ?><div class="field-error"><?php echo htmlspecialchars($errors['idsexo']); ?></div><?php endif; ?>
                </div>
                <div class="form-group">
                    <label for="idestadocivil">Estado civil</label>
                    <select class="select" name="idestadocivil" id="idestadocivil" required>
                        <option value="">Seleccione un estado civil</option>
                        <?php
                        if (isset($estadosciviles) && !empty($estadosciviles)):
                            foreach ($estadosciviles as $estadocivil):
                                $sel2 = ((string)($old['idestadocivil'] ?? '') === (string)$estadocivil['idestadocivil']) ? 'selected' : '';
                                echo '<option value="' . $estadocivil['idestadocivil'] . '" ' . $sel2 . '>' . htmlspecialchars($estadocivil['nombre']) . '</option>';
                            endforeach;
                        else:
                            echo '<option value="">No hay estados civiles disponibles</option>';
                        endif;
                        ?>
                    </select>
                    <?php if (!empty($errors['idestadocivil'])): ?><div class="field-error"><?php echo htmlspecialchars($errors['idestadocivil']); ?></div><?php endif; ?>
                </div>
            </div>
            <div class="footer-actions">
                <p class="helper">Revisa los datos antes de guardar.</p>
                <button class="btn btn-primary" type="submit">Crear persona</button>
            </div>
        </form>
    </div>
    <script src="<?php echo $basePath; ?>js/script.js"></script>
</body>
</html>
