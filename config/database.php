<?php
class Database {
    // Valores por defecto conservadores (no exponer credenciales en repo)
    private $host = '';
    private $db_name = '';
    private $username = '';
    private $password = '';
    private $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            // Leer variables de entorno con fallback a valores por defecto
            // POR DEFECTO: evitar conectar a la base de datos remota. Usar valores locales que no apuntan
            // a producción. Para configurar un entorno, usa un archivo `.env` o docker-compose.
            $host = getenv('DB_HOST') ?: '127.0.0.1';
            $db_name = getenv('DB_NAME') ?: 'framworddb';
            // Leer las credenciales desde variables de entorno.
            // NOTA: Los valores por defecto abajo son para DESARROLLO local únicamente.
            $username = getenv('DB_USER');
            $password = getenv('DB_PASS');

            // Si no se proporcionan variables de entorno, usar credenciales de desarrollo
            // (estas credenciales no deben usarse en producción). Si prefieres, exporta
            // las variables DB_USER/DB_PASS y reinicia el servidor PHP en tu sesión.
            if ($username === false || $username === '') {
                $username = 'framuser';
            }
            if ($password === false || $password === '') {
                $password = 'framword_pass';
            }
            $port = getenv('DB_PORT') ?: '3306';
            $charset = getenv('DB_CHARSET') ?: 'utf8mb4';

            // Guardar para referencia si se necesita
            $this->host = $host;
            $this->db_name = $db_name;
            $this->username = $username;
            $this->password = $password;

            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4";
            // Incluir puerto si está configurado
            if (!empty($port)) {
                $dsn = "mysql:host={$this->host};port={$port};dbname={$this->db_name};charset={$charset}";
            }

            $this->conn = new PDO($dsn, $this->username, $this->password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $exception) {
            // Registrar información útil para debugging en logs del servidor, sin incluir la contraseña.
            $logMsg = sprintf(
                "DB connection error: host=%s port=%s db=%s user=%s message=%s",
                $this->host,
                $port,
                $this->db_name,
                $this->username,
                $exception->getMessage()
            );
            error_log($logMsg);
            // Lanzar error genérico para no exponer detalles sensibles en la salida HTTP.
            throw new Exception("No se pudo conectar a la base de datos.");
        }
        return $this->conn;
    }
}
?>
