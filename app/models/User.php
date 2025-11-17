<?php
require_once __DIR__ . '/../../config/database.php';

class User {
    private $conn;
    public $id;
    public $name;
    public $email;
    public $password;
    public $role;

    public function __construct($db = null) {
        if ($db) {
            $this->conn = $db;
        } else {
            $this->conn = (new Database())->getConnection();
        }
    }

    public function findByEmail($email) {
        try {
            $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("User::findByEmail error: " . $e->getMessage());
            return null;
        }
    }

    public function findById($id) {
        try {
            $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("User::findById error: " . $e->getMessage());
            return null;
        }
    }

    public function create() {
        try {
            $sql = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':name', $this->name);
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':role', $this->role);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("User::create error: " . $e->getMessage());
            return false;
        }
    }
}

?>
