<?php
// app/controllers/UniversidadController.php
require_once __DIR__ . '/../helpers/entity_helper.php';
require_once __DIR__ . '/../../config/database.php';

class UniversidadController {
    private $pdo;
    public function __construct() {
        $this->pdo = (new Database())->getConnection();
    }

    public function index() {
        $universidades = getEntities($this->pdo, 'universidad');
        require __DIR__ . '/../views/universidad/index.php';
    }

    public function create() {
        $errors = [];
        $old = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $old = $_POST;
            $errors = validateEntity($_POST, 'universidad');
            if (empty($errors)) {
                createEntity($this->pdo, $_POST, 'universidad');
                header('Location: /universidad');
                exit;
            }
        }
        require __DIR__ . '/../views/universidad/create.php';
    }

    public function edit($id) {
        $universidad = getEntityById($this->pdo, 'universidad', $id);
        $errors = [];
        $old = $universidad;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $old = $_POST;
            $errors = validateEntity($_POST, 'universidad');
            if (empty($errors)) {
                updateEntity($this->pdo, $_POST, 'universidad', $id);
                header('Location: /universidad');
                exit;
            }
        }
        require __DIR__ . '/../views/universidad/edit.php';
    }

    public function delete($id) {
        deleteEntity($this->pdo, 'universidad', $id);
        header('Location: /universidad');
        exit;
    }
}
