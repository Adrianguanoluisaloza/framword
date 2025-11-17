<?php
require_once __DIR__ . '/../helpers/session_helper.php';

class AuthMiddleware {
    public static function requireLogin() {
        if (!is_logged_in()) {
            // For web app redirect to login; compute dynamic base path so it works in both environments
            $basePath = '/public/';
            if (isset($_SERVER['SCRIPT_NAME'])) {
                $basePath = rtrim(str_replace('index.php', '', $_SERVER['SCRIPT_NAME']), '/') . '/';
            }
            header('Location: ' . $basePath . 'auth/login');
            exit;
        }
    }
}

?>
