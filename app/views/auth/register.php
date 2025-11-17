<?php
require_once __DIR__ . '/../partials/navbar.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="<?php echo $basePath ?? '/public/'; ?>css/style.css">
    <style> .auth-form { max-width: 420px; margin: 2rem auto; } </style>
</head>
<body>
    <main class="auth-form">
        <h1>Registro</h1>
        <?php if ($msg = flash_get('error')): ?>
            <div class="alert alert-error"><?php echo htmlspecialchars($msg); ?></div>
        <?php endif; ?>
        <?php if ($msg = flash_get('success')): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($msg); ?></div>
        <?php endif; ?>
        <form method="post" action="<?php echo $basePath ?? '/public/'; ?>auth/register">
            <?php echo csrf_field(); ?>
            <label>Nombre</label>
            <input type="text" name="name" required>
            <label>Email</label>
            <input type="email" name="email" required>
            <label>Contraseña</label>
            <input type="password" name="password" required>
            <button class="btn btn-primary" type="submit">Registrar</button>
        </form>
        <p>¿Ya tienes cuenta? <a href="<?php echo $basePath ?? '/public/'; ?>auth/login">Inicia sesión</a></p>
    </main>
</body>
</html>
