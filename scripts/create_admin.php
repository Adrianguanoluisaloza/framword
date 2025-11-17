<?php
require_once __DIR__ . '/../config/database.php';

$host = getenv('DB_HOST') ?: '127.0.0.1';
$port = getenv('DB_PORT') ?: '3306';
$dbname = getenv('DB_NAME') ?: 'framworddb';
$user = getenv('DB_USER') ?: 'framuser';
$pass = getenv('DB_PASS') ?: 'framword_pass';

try {
    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$dbname}", $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
    echo "ERROR: No se pudo conectar a la DB: " . $e->getMessage() . PHP_EOL;
    exit(1);
}

$name = $argv[1] ?? 'admin';
$email = $argv[2] ?? 'admin@example.com';
$password = $argv[3] ?? 'admin123';

$hash = password_hash($password, PASSWORD_DEFAULT);
$sql = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, 'admin')";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $hash);
try {
    $stmt->execute();
    echo "Usuario admin creado: {$email} (password: {$password})" . PHP_EOL;
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . PHP_EOL;
}

?>
