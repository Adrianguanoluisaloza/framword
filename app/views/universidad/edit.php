<?php
// app/views/universidad/edit.php
require_once __DIR__ . '/../partials/navbar.php';
?>
<h2>Editar Universidad</h2>
<form method="post">
    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?= htmlspecialchars($old['nombre'] ?? '') ?>">
    <span class="error"><?= $errors['nombre'] ?? '' ?></span><br>
    <label>Clave:</label>
    <input type="text" name="clave" value="<?= htmlspecialchars($old['clave'] ?? '') ?>">
    <span class="error"><?= $errors['clave'] ?? '' ?></span><br>
    <button type="submit">Actualizar</button>
</form>
<a href="/universidad">Volver a la lista</a>
