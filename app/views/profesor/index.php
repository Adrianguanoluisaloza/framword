<?php
require_once dirname(__DIR__, 2) . '/helpers/url_helper.php';
$basePath = $basePath ?? app_base_path();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profesores</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <div class="layout">
        <header class="page-header">
            <div>
                <p class="eyebrow">Profesores</p>
                <h1>Listado de profesores</h1>
                <p class="subtitle">Controla docentes, RFC y las universidades donde colaboran.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>">← Panel principal</a>
                <a class="btn btn-primary" href="<?php echo $basePath; ?>profesor/create">+ Agregar profesor</a>
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
                                <th>RFC</th>
                                <th>Universidad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($profesores)): ?>
                                <tr>
                                    <td colspan="5" class="empty-state">Aún no hay profesores registrados.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($profesores as $p): ?>
                                <tr>
                                    <td><?= htmlspecialchars($p['id']) ?></td>
                                    <td><?= htmlspecialchars($p['nombre']) ?></td>
                                    <td><?= htmlspecialchars($p['rfc']) ?></td>
                                    <td><?= htmlspecialchars($p['universidad_id']) ?></td>
                                    <td>
                                        <div class="actions">
                                            <a class="btn btn-secondary" href="<?php echo $basePath; ?>profesor/edit?id=<?= $p['id'] ?>">Editar</a>
                                            <a class="btn btn-danger" href="<?php echo $basePath; ?>profesor/delete?id=<?= $p['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar?')">Eliminar</a>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
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
