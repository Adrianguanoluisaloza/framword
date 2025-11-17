<?php
require_once dirname(__DIR__, 2) . '/helpers/url_helper.php';
$basePath = $basePath ?? app_base_path();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudiantes</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="app-shell">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <div class="layout">
        <header class="page-header">
            <div>
                <p class="eyebrow">Estudiantes</p>
                <h1>Lista de estudiantes</h1>
                <p class="subtitle">Registra y administra matrículas asociadas a universidades.</p>
            </div>
            <div class="header-actions">
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>">← Panel principal</a>
                <a class="btn btn-primary" href="<?php echo $basePath; ?>estudiante/create">+ Agregar estudiante</a>
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
                                <th>Matrícula</th>
                                <th>Universidad</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($estudiantes)): ?>
                                <tr>
                                    <td colspan="5" class="empty-state">
                                        No hay estudiantes registrados. Verifica que las migraciones se hayan ejecutado y visita
                                        <a href="<?php echo $basePath; ?>status"><?php echo $basePath; ?>status</a>.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($estudiantes as $e): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($e['id']) ?></td>
                                        <td><?= htmlspecialchars($e['nombre']) ?></td>
                                        <td><?= htmlspecialchars($e['matricula']) ?></td>
                                        <td><?= htmlspecialchars($e['universidad_id']) ?></td>
                                        <td>
                                            <div class="actions">
                                                <a class="btn btn-secondary" href="<?php echo $basePath; ?>estudiante/edit?id=<?= $e['id'] ?>">Editar</a>
                                                <a class="btn btn-danger" href="<?php echo $basePath; ?>estudiante/delete?id=<?= $e['id'] ?>" onclick="return confirm('¿Seguro que deseas eliminar?')">Eliminar</a>
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
