<?php $basePath = '/public/'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personas</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
    <div class="layout">
        <header class="page-header">
            <div>
                <p class="eyebrow">Personas</p>
                <h1>Gestión de personas</h1>
                <p class="subtitle">Consulta, crea y actualiza la información de cada persona con accesos rápidos.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>">← Menú principal</a>
                <a class="btn btn-primary" href="<?php echo $basePath; ?>persona/create">+ Agregar persona</a>
            </div>
        </header>

        <div class="card">
            <div class="table-wrapper">
                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Fecha de Nacimiento</th>
                                <th>Sexo</th>
                                <th>Estado Civil</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($personas) && is_array($personas)): ?>
                                <?php foreach ($personas as $persona): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($persona['idpersona']); ?></td>
                                        <td><?php echo htmlspecialchars($persona['nombres']); ?></td>
                                        <td><?php echo htmlspecialchars($persona['apellidos']); ?></td>
                                        <td><?php echo htmlspecialchars($persona['fechanacimiento']); ?></td>
                                        <td><span class="badge"><?php echo htmlspecialchars($persona['sexo_nombre'] ?? $persona['idsexo']); ?></span></td>
                                        <td><span class="badge"><?php echo htmlspecialchars($persona['estadocivil_nombre'] ?? $persona['idestadocivil']); ?></span></td>
                                        <td>
                                            <div class="actions">
                                                <a class="btn btn-secondary" href="<?php echo $basePath; ?>persona/view?idpersona=<?php echo htmlspecialchars($persona['idpersona']); ?>">Ver</a>
                                                <a class="btn btn-primary" href="<?php echo $basePath; ?>persona/edit?idpersona=<?php echo htmlspecialchars($persona['idpersona']); ?>">Editar</a>
                                                <a class="btn btn-danger" href="<?php echo $basePath; ?>persona/eliminar?idpersona=<?php echo htmlspecialchars($persona['idpersona']); ?>">Eliminar</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="empty-state">No hay registros de personas disponibles.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo $basePath; ?>js/script.js"></script>
</body>
</html>
