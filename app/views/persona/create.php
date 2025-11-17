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
            <h2 class="form-title">Información principal</h2>
            <div class="form-grid">
                <div class="form-group">
                    <label for="nombres">Nombres</label>
                    <input class="input" type="text" name="nombres" id="nombres" required>
                </div>
                <div class="form-group">
                    <label for="apellidos">Apellidos</label>
                    <input class="input" type="text" name="apellidos" id="apellidos" required>
                </div>
                <div class="form-group">
                    <label for="fechanacimiento">Fecha de nacimiento</label>
                    <input class="input" type="date" name="fechanacimiento" id="fechanacimiento" required>
                </div>
                <div class="form-group">
                    <label for="idsexo">Sexo</label>
                    <select class="select" name="idsexo" id="idsexo" required>
                        <option value="">Seleccione un sexo</option>
                        <?php
                        if (isset($sexos) && !empty($sexos)):
                            foreach ($sexos as $sexo):
                                echo '<option value="' . $sexo['id'] . '">' . htmlspecialchars($sexo['nombre']) . '</option>';
                            endforeach;
                        else:
                            echo '<option value="">No hay sexos disponibles</option>';
                        endif;
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="idestadocivil">Estado civil</label>
                    <select class="select" name="idestadocivil" id="idestadocivil" required>
                        <option value="">Seleccione un estado civil</option>
                        <?php
                        if (isset($estadosciviles) && !empty($estadosciviles)):
                            foreach ($estadosciviles as $estadocivil):
                                echo '<option value="' . $estadocivil['idestadocivil'] . '">' . htmlspecialchars($estadocivil['nombre']) . '</option>';
                            endforeach;
                        else:
                            echo '<option value="">No hay estados civiles disponibles</option>';
                        endif;
                        ?>
                    </select>
                </div>
            </div>
            <div class="footer-actions">
                <p class="helper">Revisa los datos antes de guardar.</p>
                <button class="btn btn-primary" type="submit">Crear persona</button>
            </div>
        </form>
    </div>
</body>
</html>
