<?php
// app/controllers/UniversidadController.php
require_once __DIR__ . '/../helpers/entity_helper.php';
require_once __DIR__ . '/../helpers/url_helper.php';
require_once __DIR__ . '/../../config/database.php';

class UniversidadController {
    private $pdo;
    private $basePath;
    public function __construct() {
        $this->pdo = (new Database())->getConnection();
        $this->basePath = app_base_path();
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
                header('Location: ' . $this->basePath . 'universidad');
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
                header('Location: ' . $this->basePath . 'universidad');
                exit;
            }
        }
        require __DIR__ . '/../views/universidad/edit.php';
    }

    public function delete($id) {
        deleteEntity($this->pdo, 'universidad', $id);
        header('Location: ' . $this->basePath . 'universidad');
        exit;
    }
}
