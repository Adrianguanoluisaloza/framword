<?php
$basePath = $basePath ?? '/public/';
$trimmedBase = rtrim($basePath, '/');
$requestUri = $_SERVER['REQUEST_URI'] ?? '/';
$currentRoute = '';
if (strpos($requestUri, $basePath) === 0) {
    $currentRoute = substr($requestUri, strlen($basePath));
}
$currentRoute = trim($currentRoute, '/');
require_once __DIR__ . '/../../helpers/session_helper.php';
require_once __DIR__ . '/../../models/User.php';

$navItems = [
    ['label' => 'Inicio', 'path' => ''],
    ['label' => 'Personas', 'path' => 'persona'],
    ['label' => 'Teléfonos', 'path' => 'telefono'],
    ['label' => 'Estudiantes', 'path' => 'estudiante'],
    ['label' => 'Universidades', 'path' => 'universidad'],
    ['label' => 'Profesores', 'path' => 'profesor'],
    ['label' => 'Direcciones', 'path' => 'direccion'],
    ['label' => 'Sexos', 'path' => 'sexo'],
    ['label' => 'Estados civiles', 'path' => 'estadocivil'],
];
?>
<nav class="top-nav">
    <div class="nav-brand">
        <a href="<?php echo $trimmedBase; ?>/" class="brand">Framework Demo</a>
        <p class="brand-helper">Accesos directos a todos los módulos</p>
    </div>
    <div class="nav-links">
        <?php foreach ($navItems as $item): 
            $navRoute = trim($item['path'], '/');
            $isActive = $navRoute === '' ? $currentRoute === '' : strpos($currentRoute, $navRoute) === 0;
            $href = $navRoute === '' ? $trimmedBase . '/' : $trimmedBase . '/' . $navRoute;
        ?>
            <a href="<?php echo $href; ?>"
               class="nav-link<?php echo $isActive ? ' is-active' : ''; ?>"
               <?php echo $isActive ? 'aria-current="page"' : ''; ?>>
               <?php echo htmlspecialchars($item['label']); ?>
            </a>
        <?php endforeach; ?>
        <?php if (is_logged_in()): 
            $userId = current_user_id();
            $username = 'Mi cuenta';
            try {
                $db = (new Database())->getConnection();
                $userModel = new User($db);
                $userData = $userModel->findById($userId);
                if ($userData && isset($userData['name'])) {
                    $username = htmlspecialchars($userData['name']);
                }
            } catch (Exception $e) {
                // ignore
            }
        ?>
            <a href="<?php echo $trimmedBase; ?>/auth/logout" class="nav-link"><?php echo $username; ?> (Salir)</a>
        <?php else: ?>
            <a href="<?php echo $trimmedBase; ?>/auth/login" class="nav-link">Iniciar sesión</a>
            <a href="<?php echo $trimmedBase; ?>/auth/register" class="nav-link">Registrarse</a>
        <?php endif; ?>
    </div>
</nav>
