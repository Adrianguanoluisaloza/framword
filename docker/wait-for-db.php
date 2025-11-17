<?php
// Script simple para esperar a que MySQL esté disponible.
$host = getenv('DB_HOST') ?: '127.0.0.1';
$port = getenv('DB_PORT') ?: '3306';
$db = getenv('DB_NAME') ?: 'framworddb';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
$timeout = getenv('DB_WAIT_TIMEOUT') ?: 30; // segundos

$start = time();
echo "Esperando a MySQL en {$host}:{$port}...\n";
while (true) {
    $mysqli = @mysqli_connect($host, $user, $pass, $db, (int)$port);
    if ($mysqli) {
        echo "MySQL disponible: {$host}:{$port}\n";
        mysqli_close($mysqli);
        exit(0);
    }
    if ((time() - $start) >= (int)$timeout) {
        echo "Timeout esperando la base de datos ({$timeout} segundos).\n";
        exit(1);
    }
    sleep(1);
}
?>
