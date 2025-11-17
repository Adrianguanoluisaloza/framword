<?php
// app/controllers/ProfesorController.php
require_once __DIR__ . '/../helpers/entity_helper.php';
require_once __DIR__ . '/../../config/database.php';

class ProfesorController {
    private $pdo;
    public function __construct() {
        $this->pdo = (new Database())->getConnection();
    }

    public function index() {
        $profesores = getEntities($this->pdo, 'profesor');
        require __DIR__ . '/../views/profesor/index.php';
    }

    public function create() {
        $errors = [];
        $old = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $old = $_POST;
            $errors = validateEntity($_POST, 'profesor');
            if (empty($errors)) {
                createEntity($this->pdo, $_POST, 'profesor');
                header('Location: /profesor');
                exit;
            }
        }
        require __DIR__ . '/../views/profesor/create.php';
    }

    public function edit($id) {
        $profesor = getEntityById($this->pdo, 'profesor', $id);
        $errors = [];
        $old = $profesor;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $old = $_POST;
            $errors = validateEntity($_POST, 'profesor');
            if (empty($errors)) {
                updateEntity($this->pdo, $_POST, 'profesor', $id);
                header('Location: /profesor');
                exit;
            }
        }
        require __DIR__ . '/../views/profesor/edit.php';
    }

    public function delete($id) {
        deleteEntity($this->pdo, 'profesor', $id);
        header('Location: /profesor');
        exit;
    }
}
