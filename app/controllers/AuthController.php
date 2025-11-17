<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../helpers/session_helper.php';
require_once __DIR__ . '/../helpers/url_helper.php';

class AuthController {
    private $db;
    private $userModel;
    private $basePath;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->userModel = new User($this->db);
        $this->basePath = app_base_path();
    }

    // Mostrar formulario de login
    public function loginForm() {
        require_once __DIR__ . '/../views/auth/login.php';
    }

    // Procesar login
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            if (empty($email) || empty($password)) {
                flash_set('error', 'Debes completar email y contraseña.');
                header('Location: ' . $this->basePath . 'auth/login');
                exit;
            }
            // CSRF validation
            $token = $_POST['_csrf'] ?? '';
            if (!verify_csrf_token($token)) {
                flash_set('error', 'Token CSRF inválido.');
                header('Location: ' . $this->basePath . 'auth/login');
                exit;
            }
            $user = $this->userModel->findByEmail($email);
            if (!$user) {
                flash_set('error', 'Credenciales inválidas.');
                header('Location: ' . $this->basePath . 'auth/login');
                exit;
            }
            if (password_verify($password, $user['password'])) {
                login_user((int)$user['id']);
                flash_set('success', 'Bienvenido, ' . htmlspecialchars($user['name']) . '!');
                header('Location: ' . $this->basePath);
                exit;
            } else {
                flash_set('error', 'Credenciales inválidas.');
                header('Location: ' . $this->basePath . 'auth/login');
                exit;
            }
        } else {
            header('Location: ' . $this->basePath . 'auth/login');
            exit;
        }
    }

    // Mostrar formulario de registro
    public function registerForm() {
        require_once __DIR__ . '/../views/auth/register.php';
    }

    // Procesar registro
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            if (empty($name) || empty($email) || empty($password)) {
                flash_set('error', 'Completa todos los campos.');
                header('Location: ' . $this->basePath . 'auth/register');
                exit;
            }
            // CSRF validation
            $token = $_POST['_csrf'] ?? '';
            if (!verify_csrf_token($token)) {
                flash_set('error', 'Token CSRF inválido.');
                header('Location: ' . $this->basePath . 'auth/register');
                exit;
            }
            // Verificar si usuario existe
            $existing = $this->userModel->findByEmail($email);
            if ($existing) {
                flash_set('error', 'Ya existe un usuario con ese correo.');
                header('Location: ' . $this->basePath . 'auth/register');
                exit;
            }
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $this->userModel->name = $name;
            $this->userModel->email = $email;
            $this->userModel->password = $hashed;
            $this->userModel->role = 'user';

            if ($this->userModel->create()) {
                flash_set('success', 'Usuario creado. Inicia sesión.');
                header('Location: ' . $this->basePath . 'auth/login');
                exit;
            } else {
                flash_set('error', 'No se pudo crear el usuario.');
                header('Location: ' . $this->basePath . 'auth/register');
                exit;
            }
        }
        header('Location: ' . $this->basePath . 'auth/register');
        exit;
    }

    public function logout() {
        logout_user();
        flash_set('success', 'Has cerrado sesión.');
        header('Location: ' . $this->basePath . 'auth/login');
        exit;
    }
}

?>
