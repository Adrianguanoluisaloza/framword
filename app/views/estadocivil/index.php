<?php $basePath = '/public/'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estados civiles</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <div class="layout">
        <header class="page-header">
            <div>
                <p class="eyebrow">Catálogos</p>
                <h1>Estados civiles</h1>
                <p class="subtitle">Gestiona las opciones disponibles para registrar personas.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>">← Menú principal</a>
                <a class="btn btn-primary" href="<?php echo $basePath; ?>estadocivil/create">+ Agregar estado civil</a>
            </div>
        </header>

        <div class="card">
            <div class="table-wrapper">
                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($estadocivil) && is_array($estadocivil)): ?>
                                <?php foreach ($estadocivil as $item): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($item['idestadocivil']); ?></td>
                                        <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                                        <td>
                                            <div class="actions">
                                                <a class="btn btn-primary" href="<?php echo $basePath; ?>estadocivil/edit?idestadocivil=<?php echo htmlspecialchars($item['idestadocivil']); ?>">Editar</a>
                                                <a class="btn btn-danger" href="<?php echo $basePath; ?>estadocivil/eliminar?idestadocivil=<?php echo htmlspecialchars($item['idestadocivil']); ?>">Eliminar</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="empty-state">No hay registros disponibles.</td>
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
