<?php
/**
 * Helper para determinar rutas base sin importar el DocumentRoot.
 */
if (!function_exists('app_base_path')) {
    function app_base_path(): string {
        static $base = null;
        if ($base !== null) {
            return $base;
        }
        $script = $_SERVER['SCRIPT_NAME'] ?? '/';
        $dir = str_replace('\\', '/', dirname($script));
        if ($dir === '/' || $dir === '\\' || $dir === '.') {
            $dir = '';
        }
        $base = $dir === '' ? '/' : rtrim($dir, '/') . '/';
        return $base;
    }
}

if (!function_exists('app_url')) {
    function app_url(string $path = ''): string {
        $base = app_base_path();
        $trimmed = $base === '/' ? '' : rtrim($base, '/');
        $prefix = $trimmed === '' ? '' : $trimmed;
        return $prefix . '/' . ltrim($path, '/');
    }
}
