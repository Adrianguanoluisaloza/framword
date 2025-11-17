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
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <?php include __DIR__ . '/../partials/messages.php'; ?>
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

        <?php if (isset($_GET['msg'])): ?>
            <div class="alert-container">
                <?php if ($_GET['msg'] === 'created'): ?><div class="alert alert-success">Persona creada correctamente.</div><?php endif; ?>
                <?php if ($_GET['msg'] === 'updated'): ?><div class="alert alert-success">Persona actualizada correctamente.</div><?php endif; ?>
                <?php if ($_GET['msg'] === 'deleted'): ?><div class="alert alert-success">Persona eliminada correctamente.</div><?php endif; ?>
                <?php if ($_GET['msg'] === 'error'): ?><div class="alert alert-error">Ocurrió un error al procesar la solicitud.</div><?php endif; ?>
            </div>
        <?php endif; ?>

        <section class="overview-section">
            <h2 class="section-title">Resumen por rol</h2>
            <div class="summary-grid">
                <?php foreach ($roleStats as $key => $stat): ?>
                    <article class="summary-card">
                        <p class="summary-label"><?php echo htmlspecialchars($stat['label']); ?></p>
                        <p class="summary-value"><?php echo $stat['count']; ?></p>
                        <p class="summary-helper">Registros asignados a este perfil.</p>
                        <button class="pill-link role-tab-trigger" data-role-tab="<?php echo $key; ?>">Ver listado</button>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="card role-card">
            <div class="role-tabs" role="tablist">
                <?php $roleKeys = array_keys($groupedByRole); $firstRole = reset($roleKeys); ?>
                <?php foreach ($groupedByRole as $key => $items): ?>
                    <button type="button"
                            class="role-tab<?php echo ($key === $firstRole) ? ' is-active' : ''; ?>"
                            data-role-tab="<?php echo $key; ?>">
                        <?php echo htmlspecialchars($roles[$key] ?? ucfirst($key)); ?>
                        <span class="badge badge-muted"><?php echo count($items); ?></span>
                    </button>
                <?php endforeach; ?>
            </div>

            <?php foreach ($groupedByRole as $key => $items): ?>
                <div class="role-panel<?php echo ($key === $firstRole) ? ' is-active' : ''; ?>" data-role-panel="<?php echo $key; ?>">
                    <div class="table-wrapper">
                        <div class="table-scroll">
                            <table>
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nombre completo</th>
                                        <th>Detalle</th>
                                        <th>Sexo</th>
                                        <th>Estado Civil</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($items)): ?>
                                        <?php foreach ($items as $persona): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($persona['idpersona']); ?></td>
                                                <td>
                                                    <div class="table-name">
                                                        <strong><?php echo htmlspecialchars($persona['nombres'] . ' ' . $persona['apellidos']); ?></strong>
                                                        <span class="badge"><?php echo htmlspecialchars($roles[$persona['rol']] ?? ucfirst($persona['rol'])); ?></span>
                                                        <small><?php echo htmlspecialchars($persona['fechanacimiento']); ?></small>
                                                    </div>
                                                </td>
                                                <td><?php echo $persona['detalle'] ? htmlspecialchars($persona['detalle']) : '—'; ?></td>
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
                                            <td colspan="6" class="empty-state">No hay registros para este rol.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    </div>
    <script src="<?php echo $basePath; ?>js/script.js"></script>
</body>
</html>
