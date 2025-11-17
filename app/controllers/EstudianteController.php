<?php
// app/controllers/EstudianteController.php
require_once __DIR__ . '/../helpers/entity_helper.php';
require_once __DIR__ . '/../../config/database.php';

class EstudianteController {
    private $pdo;
    public function __construct() {
        $this->pdo = (new Database())->getConnection();
    }

    public function index() {
        $estudiantes = getEntities($this->pdo, 'estudiante');
        require __DIR__ . '/../views/estudiante/index.php';
    }

    public function create() {
        $errors = [];
        $old = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $old = $_POST;
            $errors = validateEntity($_POST, 'estudiante');
            if (empty($errors)) {
                createEntity($this->pdo, $_POST, 'estudiante');
                header('Location: /estudiante');
                exit;
            }
        }
        require __DIR__ . '/../views/estudiante/create.php';
    }

    public function edit($id) {
        $estudiante = getEntityById($this->pdo, 'estudiante', $id);
        $errors = [];
        $old = $estudiante;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $old = $_POST;
            $errors = validateEntity($_POST, 'estudiante');
            if (empty($errors)) {
                updateEntity($this->pdo, $_POST, 'estudiante', $id);
                header('Location: /estudiante');
                exit;
            }
        }
        require __DIR__ . '/../views/estudiante/edit.php';
    }

    public function delete($id) {
        deleteEntity($this->pdo, 'estudiante', $id);
        header('Location: /estudiante');
        exit;
    }
}
