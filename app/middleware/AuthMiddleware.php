<?php
require_once __DIR__ . '/../helpers/session_helper.php';
require_once __DIR__ . '/../helpers/url_helper.php';

class AuthMiddleware {
    public static function requireLogin() {
        if (!is_logged_in()) {
            $basePath = app_base_path();
            header('Location: ' . $basePath . 'auth/login');
            exit;
        }
    }
}

?>
