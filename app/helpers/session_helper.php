<?php
// session_helper.php
// Helpers para manejo de sesiones, flash messages y autenticación básica

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function flash_set($key, $message) {
    if (!isset($_SESSION['_flash'])) $_SESSION['_flash'] = [];
    $_SESSION['_flash'][$key] = $message;
}

function flash_get($key) {
    if (isset($_SESSION['_flash'][$key])) {
        $val = $_SESSION['_flash'][$key];
        unset($_SESSION['_flash'][$key]);
        return $val;
    }
    return null;
}

function is_logged_in() {
    return isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0;
}

function login_user($userId) {
    $_SESSION['user_id'] = $userId;
}

function logout_user() {
    unset($_SESSION['user_id']);
}

function current_user_id() {
    return $_SESSION['user_id'] ?? null;
}

// CSRF token helpers
function csrf_token() {
    if (!isset($_SESSION['_csrf_token'])) {
        $_SESSION['_csrf_token'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['_csrf_token'];
}

function csrf_field() {
    $token = csrf_token();
    return '<input type="hidden" name="_csrf" value="' . htmlspecialchars($token) . '">';
}

function verify_csrf_token($token) {
    return isset($_SESSION['_csrf_token']) && hash_equals($_SESSION['_csrf_token'], $token);
}

?>
