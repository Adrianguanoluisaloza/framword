<?php
require_once dirname(__DIR__, 2) . '/helpers/url_helper.php';
$basePath = $basePath ?? app_base_path();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sexos</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <div class="layout">
        <header class="page-header">
            <div>
                <p class="eyebrow">Catálogos</p>
                <h1>Listado de sexos</h1>
                <p class="subtitle">Controla la tabla de sexos utilizada en formularios.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>">← Menú principal</a>
                <a class="btn btn-primary" href="<?php echo $basePath; ?>sexo/create">+ Agregar sexo</a>
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
                            <?php if (!empty($sexos) && is_array($sexos)): ?>
                                <?php foreach ($sexos as $sexo): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($sexo['id']); ?></td>
                                        <td><?php echo htmlspecialchars($sexo['nombre']); ?></td>
                                        <td>
                                            <div class="actions">
                                                <a class="btn btn-primary" href="<?php echo $basePath; ?>sexo/edit?id=<?php echo htmlspecialchars($sexo['id']); ?>">Editar</a>
                                                <a class="btn btn-danger" href="<?php echo $basePath; ?>sexo/eliminar?id=<?php echo htmlspecialchars($sexo['id']); ?>">Eliminar</a>
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
