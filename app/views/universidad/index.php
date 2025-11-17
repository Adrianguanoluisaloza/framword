<?php
// app/views/universidad/index.php
require_once __DIR__ . '/../partials/navbar.php';
?>
<h2>Lista de Universidades</h2>
<a href="/universidad/create">Agregar Universidad</a>
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
        <?php foreach ($universidades as $u): ?>
        <tr>
            <td><?= htmlspecialchars($u['id']) ?></td>
            <td><?= htmlspecialchars($u['nombre']) ?></td>
            <td><?= htmlspecialchars($u['clave']) ?></td>
            <td>
                <a href="/universidad/edit?id=<?= $u['id'] ?>">Editar</a>
                <a href="/universidad/delete?id=<?= $u['id'] ?>" onclick="return confirm('¿Seguro?')">Eliminar</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
