<?php
/**
 * Simple migration runner: ejecuta docker/mysql-init/init.sql contra la DB configurada en .env
 * Uso: php scripts/migrate.php
 */
require_once __DIR__ . '/../config/database.php';

$host = getenv('DB_HOST') ?: '127.0.0.1';
$port = getenv('DB_PORT') ?: '3306';
$name = getenv('DB_NAME') ?: 'framworddb';
$user = getenv('DB_USER') ?: 'framuser';
$pass = getenv('DB_PASS') ?: 'framword_pass';

try {
    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$name}", $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
    echo "ERROR: No se pudo conectar a la DB: " . $e->getMessage() . PHP_EOL;
    exit(1);
}

$sqlFile = __DIR__ . '/../docker/mysql-init/init.sql';
if (!file_exists($sqlFile)) {
    echo "ERROR: No se encontró el archivo init.sql en docker/mysql-init/init.sql" . PHP_EOL;
    exit(1);
}

$sql = file_get_contents($sqlFile);
// Execute multiple statements; PDO supports exec for simple statements, but we split by ';' safely
$statements = array_filter(array_map('trim', explode(';', $sql)));
foreach ($statements as $stmt) {
    if ($stmt === '') continue;
    try {
        $pdo->exec($stmt);
    } catch (Exception $e) {
        // Log and continue: use errors to notify about potential issues
        echo "WARN: ejecucion de statement falló: " . substr($stmt, 0, 120) . "... => " . $e->getMessage() . PHP_EOL;
    }
}

echo "Migración completada (se aplicaron statements del init.sql)" . PHP_EOL;

?>
