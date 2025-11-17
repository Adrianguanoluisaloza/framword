<?php
// app/views/estudiante/create.php
require_once __DIR__ . '/../partials/navbar.php';
?>
<h2>Agregar Estudiante</h2>
<form method="post">
    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?= htmlspecialchars($old['nombre'] ?? '') ?>">
    <span class="error"><?= $errors['nombre'] ?? '' ?></span><br>
    <label>Matrícula:</label>
    <input type="text" name="matricula" value="<?= htmlspecialchars($old['matricula'] ?? '') ?>">
    <span class="error"><?= $errors['matricula'] ?? '' ?></span><br>
    <label>Universidad ID:</label>
    <input type="number" name="universidad_id" value="<?= htmlspecialchars($old['universidad_id'] ?? '') ?>">
    <span class="error"><?= $errors['universidad_id'] ?? '' ?></span><br>
    <button type="submit">Guardar</button>
</form>
<a href="/estudiante">Volver a la lista</a>
