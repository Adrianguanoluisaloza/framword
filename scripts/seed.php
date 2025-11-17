<?php
/**
 * Seed script para crear datos de ejemplo (desarrollo local)
 * Uso: php scripts/seed.php
 */
require_once __DIR__ . '/../config/database.php';

$host = getenv('DB_HOST') ?: '127.0.0.1';
$port = getenv('DB_PORT') ?: '3306';
$name = getenv('DB_NAME') ?: 'framworddb';
$user = getenv('DB_USER') ?: 'framuser';
$pass = getenv('DB_PASS') ?: 'framword_pass';

try {
    $pdo = new PDO("mysql:host={$host};port={$port};dbname={$name};charset=utf8mb4", $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
} catch (Exception $e) {
    echo "ERROR: No se pudo conectar a la DB: " . $e->getMessage() . PHP_EOL;
    exit(1);
}

try {
    // Insert universidades de ejemplo
    $sql = "INSERT INTO universidades (nombre, clave) VALUES (:nombre, :clave)";
    $stmt = $pdo->prepare($sql);
    $universities = [
        ['nombre' => 'Universidad Nacional', 'clave' => 'UN-001'],
        ['nombre' => 'Instituto Superior', 'clave' => 'IS-002']
    ];
    foreach ($universities as $u) {
        try {
            $stmt->execute([':nombre' => $u['nombre'], ':clave' => $u['clave']]);
        } catch (Exception $e) {
            // Ignore duplicates
        }
    }

    // Obtener universidad ids
    $rows = $pdo->query("SELECT id, nombre FROM universidades")->fetchAll(PDO::FETCH_ASSOC);
    $firstUniv = $rows[0]['id'] ?? null;
    $secondUniv = $rows[1]['id'] ?? $firstUniv;

    // Insert estudiantes
    $sql = "INSERT INTO estudiantes (nombre, matricula, universidad_id) VALUES (:nombre, :matricula, :universidad_id)";
    $stmt = $pdo->prepare($sql);
    $students = [
        ['nombre' => 'María Luna', 'matricula' => 'MAT-001', 'universidad_id' => $firstUniv],
        ['nombre' => 'Carlos Pérez', 'matricula' => 'MAT-002', 'universidad_id' => $secondUniv]
    ];
    foreach ($students as $s) {
        try {
            $stmt->execute([':nombre' => $s['nombre'], ':matricula' => $s['matricula'], ':universidad_id' => $s['universidad_id']]);
        } catch (Exception $e) {
            // Ignore duplicates or errors
        }
    }

    // Insert profesores
    $sql = "INSERT INTO profesores (nombre, rfc, universidad_id) VALUES (:nombre, :rfc, :universidad_id)";
    $stmt = $pdo->prepare($sql);
    $profs = [
        ['nombre' => 'Luis Hernández', 'rfc' => 'RFC-001', 'universidad_id' => $firstUniv],
        ['nombre' => 'Ana Gómez', 'rfc' => 'RFC-002', 'universidad_id' => $secondUniv]
    ];
    foreach ($profs as $p) {
        try {
            $stmt->execute([':nombre' => $p['nombre'], ':rfc' => $p['rfc'], ':universidad_id' => $p['universidad_id']]);
        } catch (Exception $e) {
            // Ignore duplicates
        }
    }

    echo "Seed completado. Universidades, estudiantes y profesores insertados (si no existían).\n";
} catch (Exception $e) {
    echo "ERROR: Seed falló: " . $e->getMessage() . PHP_EOL;
    exit(1);
}

?>
