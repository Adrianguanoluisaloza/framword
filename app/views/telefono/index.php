<?php
require_once dirname(__DIR__, 2) . '/helpers/url_helper.php';
$basePath = $basePath ?? app_base_path();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teléfonos</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <div class="layout">
        <header class="page-header">
            <div>
                <p class="eyebrow">Relaciones</p>
                <h1>Teléfonos</h1>
                <p class="subtitle">Controla los números asociados a cada persona.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>">← Menú principal</a>
                <a class="btn btn-primary" href="<?php echo $basePath; ?>telefono/create">+ Agregar teléfono</a>
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
                                <th>Número</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($telefonos) && is_array($telefonos)): ?>
                                <?php foreach ($telefonos as $telefono): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($telefono['idtelefono']); ?></td>
                                        <td><?php echo htmlspecialchars($telefono['persona_nombre'] ?? 'N/A'); ?></td>
                                        <td><?php echo htmlspecialchars($telefono['numero']); ?></td>
                                        <td>
                                            <div class="actions">
                                                <a class="btn btn-primary" href="<?php echo $basePath; ?>telefono/edit?idtelefono=<?php echo htmlspecialchars($telefono['idtelefono']); ?>">Editar</a>
                                                <a class="btn btn-danger" href="<?php echo $basePath; ?>telefono/eliminar?idtelefono=<?php echo htmlspecialchars($telefono['idtelefono']); ?>">Eliminar</a>
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
