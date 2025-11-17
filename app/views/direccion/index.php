<?php $basePath = '/public/'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Direcciones</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
    <div class="layout">
        <header class="page-header">
            <div>
                <p class="eyebrow">Relaciones</p>
                <h1>Direcciones</h1>
                <p class="subtitle">Administra las direcciones asociadas a cada persona.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>">← Menú principal</a>
                <a class="btn btn-primary" href="<?php echo $basePath; ?>direccion/create">+ Agregar dirección</a>
            </div>
        </header>

        <div class="card">
            <div class="table-wrapper">
                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Persona</th>
                                <th>Dirección</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($direcciones) && is_array($direcciones)): ?>
                                <?php foreach ($direcciones as $direccion): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($direccion['iddireccion']); ?></td>
                                        <td><?php echo htmlspecialchars($direccion['persona_nombre'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($direccion['nombre']); ?></td>
                                        <td>
                                            <div class="actions">
                                                <a class="btn btn-primary" href="<?php echo $basePath; ?>direccion/edit?iddireccion=<?php echo htmlspecialchars($direccion['iddireccion']); ?>">Editar</a>
                                                <a class="btn btn-danger" href="<?php echo $basePath; ?>direccion/eliminar?iddireccion=<?php echo htmlspecialchars($direccion['iddireccion']); ?>">Eliminar</a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="empty-state">No hay registros disponibles.</td>
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
