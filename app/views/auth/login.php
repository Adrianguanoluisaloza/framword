<?php
require_once dirname(__DIR__, 2) . '/helpers/url_helper.php';
$basePath = $basePath ?? app_base_path();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="auth-shell">
    <?php include __DIR__ . '/../partials/navbar.php'; ?>
    <div class="auth-wrapper">
        <section class="auth-card">
            <header>
                <p class="eyebrow">Acceso</p>
                <h1>Iniciar sesión</h1>
                <p class="subtitle">Conéctate para administrar estudiantes, profesores y universidades.</p>
            </header>
            <?php if ($msg = flash_get('error')): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($msg); ?></div>
            <?php endif; ?>
            <?php if ($msg = flash_get('success')): ?>
                <div class="alert alert-success"><?php echo htmlspecialchars($msg); ?></div>
            <?php endif; ?>
            <form method="post" action="<?php echo $basePath; ?>auth/login" class="form-grid">
                <?php echo csrf_field(); ?>
                <div class="form-group form-group--full">
                    <label for="email">Email</label>
                    <input class="input" type="email" name="email" id="email" required>
                </div>
                <div class="form-group form-group--full">
                    <label for="password">Contraseña</label>
                    <input class="input" type="password" name="password" id="password" required>
                </div>
                <div class="footer-actions">
                    <p class="helper">Ingresa con las credenciales proporcionadas.</p>
                    <button class="btn btn-primary" type="submit">Ingresar</button>
                </div>
            </form>
            <p class="auth-helper">¿No tienes cuenta? <a href="<?php echo $basePath; ?>auth/register">Regístrate</a></p>
        </section>
    </div>
    <script src="<?php echo $basePath; ?>js/script.js"></script>
</body>
</html>
