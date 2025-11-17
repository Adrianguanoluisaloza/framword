<?php
// app/views/estudiante/index.php
require_once __DIR__ . '/../partials/navbar.php';
?>
<h2>Lista de Estudiantes</h2>
<a href="/estudiante/create">Agregar Estudiante</a>
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
            <td colspan="5">No hay estudiantes registrados. ¿Has inicializado la base de datos? Revisa <a href="<?php echo $basePath ?? '/public/'; ?>status"><?php echo $basePath ?? '/public/'; ?>status</a> o ejecuta las migraciones.</td>
        </tr>
        <?php endif; ?>
        <?php foreach ($estudiantes as $e): ?>
        <tr>
            <td><?= htmlspecialchars($e['id']) ?></td>
            <td><?= htmlspecialchars($e['nombre']) ?></td>
            <td><?= htmlspecialchars($e['matricula']) ?></td>
            <td><?= htmlspecialchars($e['universidad_id']) ?></td>
            <td>
                <a href="/estudiante/edit?id=<?= $e['id'] ?>">Editar</a>
                <a href="/estudiante/delete?id=<?= $e['id'] ?>" onclick="return confirm('¿Seguro?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
