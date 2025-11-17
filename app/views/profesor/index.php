<?php
// app/views/profesor/index.php
require_once __DIR__ . '/../partials/navbar.php';
?>
<h2>Lista de Profesores</h2>
<a href="/profesor/create">Agregar Profesor</a>
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
        <?php foreach ($profesores as $p): ?>
        <tr>
            <td><?= htmlspecialchars($p['id']) ?></td>
            <td><?= htmlspecialchars($p['nombre']) ?></td>
            <td><?= htmlspecialchars($p['rfc']) ?></td>
            <td><?= htmlspecialchars($p['universidad_id']) ?></td>
            <td>
                <a href="/profesor/edit?id=<?= $p['id'] ?>">Editar</a>
                <a href="/profesor/delete?id=<?= $p['id'] ?>" onclick="return confirm('¿Seguro?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
