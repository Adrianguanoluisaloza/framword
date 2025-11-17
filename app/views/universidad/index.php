<?php
require_once dirname(__DIR__, 2) . '/helpers/url_helper.php';
$basePath = $basePath ?? app_base_path();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universidades</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <div class="layout">
        <header class="page-header">
            <div>
                <p class="eyebrow">Universidades</p>
                <h1>Catálogo de universidades</h1>
                <p class="subtitle">Registra planteles y claves para enlazarlos con estudiantes y profesores.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>">← Panel principal</a>
                <a class="btn btn-primary" href="<?php echo $basePath; ?>universidad/create">+ Agregar universidad</a>
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
                                <th>Clave</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($universidades)): ?>
                                <tr>
                                    <td colspan="4" class="empty-state">No hay universidades registradas.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($universidades as $u): ?>
                                <tr>
                                    <td><?= htmlspecialchars($u['id']) ?></td>
                                    <td><?= htmlspecialchars($u['nombre']) ?></td>
                                    <td><?= htmlspecialchars($u['clave']) ?></td>
                                    <td>
                                        <div class="actions">
                                            <a class="btn btn-secondary" href="<?php echo $basePath; ?>universidad/edit?id=<?= $u['id'] ?>">Editar</a>
                                            <a class="btn btn-danger" href="<?php echo $basePath; ?>universidad/delete?id=<?= $u['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar?')">Eliminar</a>
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
