<?php
// En PersonaController.php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/Persona.php';
require_once __DIR__ . '/../helpers/session_helper.php';
require_once __DIR__ . '/../helpers/url_helper.php';
require_once __DIR__ . '/../models/Sexo.php';
require_once __DIR__ . '/../models/Estadocivil.php';
require_once __DIR__ . '/../models/Direccion.php';
require_once __DIR__ . '/../models/Telefono.php';

class PersonaController {
    private $persona;
    private $sexo;
    private $estadocivil;
    private $telefono;
    private $direccion;
    private $db;
    private $basePath;
    private $roles = [
        'estudiante' => 'Estudiante',
        'profesor' => 'Profesor',
        'universidad' => 'Universidad'
    ];

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->persona = new Persona($this->db);
        $this->sexo = new Sexo($this->db);
        $this->estadocivil = new Estadocivil($this->db);
        $this->telefono = new Telefono($this->db);
        $this->direccion = new Direccion($this->db);
        $this->basePath = app_base_path();
    }

    // Mostrar todas las personas
    public function index() {
        $personas = $this->persona->read(); 
        $sexos = $this->sexo->read(); 
        $estadosciviles = $this->estadocivil->read(); 

        $groupedByRole = [];
        $roleStats = [];

        foreach ($this->roles as $key => $label) {
            $groupedByRole[$key] = [];
            $roleStats[$key] = ['label' => $label, 'count' => 0];
        }

        foreach ($personas as $persona) {
            $roleKey = $persona['rol'] ?? 'estudiante';
            if (!isset($groupedByRole[$roleKey])) {
                $groupedByRole[$roleKey] = [];
                $roleStats[$roleKey] = ['label' => ucfirst($roleKey), 'count' => 0];
            }
            $groupedByRole[$roleKey][] = $persona;
            $roleStats[$roleKey]['count']++;
        }

        $roles = $this->roles;
        require_once __DIR__ . '/../views/persona/index.php';
    }

    // --- MUESTRA EL FORMULARIO DE CREACIÓN ---
    public function create() {
        $sexos = $this->sexo->read();
        $estadosciviles = $this->estadocivil->read();
        $roles = $this->roles;
        // Obtener errores y datos antiguos si vienen desde flash
        $errors = flash_get('errors') ?: [];
        $old = flash_get('_old') ?: [];
        require_once __DIR__ . '/../views/persona/create.php';
    }

    // --- PROCESA EL FORMULARIO DE CREACIÓN ---
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRF protection
            $token = $_POST['_csrf'] ?? '';
            if (!verify_csrf_token($token)) {
                header('Location: ' . $this->basePath . 'persona/create?msg=csrf');
                exit;
            }
            if (
                isset($_POST['nombres'], $_POST['apellidos'], $_POST['fechanacimiento'], $_POST['idsexo'], $_POST['idestadocivil'])
            ) {
                $rolSeleccionado = $_POST['rol'] ?? 'estudiante';
                if (!array_key_exists($rolSeleccionado, $this->roles)) {
                    $rolSeleccionado = 'estudiante';
                }

                $detalle = trim($_POST['detalle'] ?? '');

                $this->persona->nombres = $_POST['nombres'];
                $this->persona->apellidos = $_POST['apellidos'];
                $this->persona->fechanacimiento = $_POST['fechanacimiento'];
                $this->persona->rol = $rolSeleccionado;
                $this->persona->detalle = $detalle;
                $this->persona->idsexo = $_POST['idsexo'];
                $this->persona->idestadocivil = $_POST['idestadocivil'];

                $_POST['rol'] = $rolSeleccionado;
                $_POST['detalle'] = $detalle;

                // Validación server-side
                require_once __DIR__ . '/../helpers/validation_helper.php';
                $errors = validate_persona($_POST, $this->db, ['roles' => array_keys($this->roles)]);
                if (!empty($errors)) {
                    // Guardar errores y datos antiguos en flash y redirigir
                    flash_set('errors', $errors);
                    flash_set('_old', $_POST);
                    header('Location: ' . $this->basePath . 'persona/create');
                    exit;
                }

                if ($this->persona->create()) {
                    header('Location: ' . $this->basePath . 'persona/index?msg=created');
                } else {
                    header('Location: ' . $this->basePath . 'persona/index?msg=error');
                }
            } else {
                // Faltan datos, redirigir de vuelta al formulario de creación
                header('Location: ' . $this->basePath . 'persona/create?msg=missingdata');
            }
        } else {
            header('Location: ' . $this->basePath . 'persona/create');
        }
        exit;
    }

    // Mostrar el formulario de edición de persona
    public function edit($idpersona) {
        $this->persona->idpersona = $idpersona;
        $persona = $this->persona->readOne(); // $persona ya tiene los JOINs

        if (!$persona) {
            die("Error: No se encontró la persona.");
        }

        // Cargar datos necesarios para los <select> del formulario
        $sexos = $this->sexo->read();
        $estadosciviles = $this->estadocivil->read();

        // Cargar errores y valores viejos si existen
        $errors = flash_get('errors') ?: [];
        $old = flash_get('_old') ?: [];
        require_once __DIR__ . '/../views/persona/edit.php';
    }

    // Muestra el registro completo (vista detallada)
    public function registro($idpersona) {
        $this->persona->idpersona = $idpersona;
        $persona = $this->persona->readOne(); // $persona ya tiene los JOINs (sexo_nombre, etc.)

        if (!$persona) {
            die("Error: No se encontró la persona.");
        }
        
        // Cargar datos relacionados
        $telefonos = $this->telefono->readByPersona($idpersona); // Asumiendo que Telefono.php tiene readByPersona()
        $direcciones = $this->direccion->readByPersona($idpersona); // Asumiendo que Direccion.php tiene readByPersona()
        $sexos = $this->sexo->read();
        $estadosciviles = $this->estadocivil->read();

        $roles = $this->roles;

        require_once __DIR__ . '/../views/persona/registro.php';
    }

    // Procesar la actualización de una persona
    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRF protection
            $token = $_POST['_csrf'] ?? '';
            if (!verify_csrf_token($token)) {
                header('Location: ' . $this->basePath . 'persona/index?msg=csrf');
                exit;
            }
            if (
                isset($_POST['idpersona'], $_POST['nombres'], $_POST['apellidos'], $_POST['fechanacimiento'], $_POST['idsexo'], $_POST['idestadocivil'])
            ) {
                $rolSeleccionado = $_POST['rol'] ?? 'estudiante';
                if (!array_key_exists($rolSeleccionado, $this->roles)) {
                    $rolSeleccionado = 'estudiante';
                }
                $detalle = trim($_POST['detalle'] ?? '');

                $this->persona->idpersona = $_POST['idpersona'];
                $this->persona->nombres = $_POST['nombres'];
                $this->persona->apellidos = $_POST['apellidos'];
                $this->persona->fechanacimiento = $_POST['fechanacimiento'];
                $this->persona->rol = $rolSeleccionado;
                $this->persona->detalle = $detalle;
                $this->persona->idsexo = $_POST['idsexo'];
                $this->persona->idestadocivil = $_POST['idestadocivil'];

                // Validación server-side
                require_once __DIR__ . '/../helpers/validation_helper.php';
                $_POST['rol'] = $rolSeleccionado;
                $_POST['detalle'] = $detalle;
                $errors = validate_persona($_POST, $this->db, ['roles' => array_keys($this->roles)]);
                if (!empty($errors)) {
                    // Guardar errores y datos antiguos y redirigir a la edición
                    flash_set('errors', $errors);
                    flash_set('_old', $_POST);
                    $id = $_POST['idpersona'] ?? 0;
                    header('Location: ' . $this->basePath . 'persona/edit?idpersona=' . $id);
                    exit;
                }

                if ($this->persona->update()) {
                    header('Location: ' . $this->basePath . 'persona/index?msg=updated');
                } else {
                    header('Location: ' . $this->basePath . 'persona/index?msg=error');
                }
            } else {
                $id = $_POST['idpersona'] ?? 0;
                header('Location: ' . $this->basePath . 'persona/edit?idpersona=' . $id . '&msg=missingdata');
            }
        } else {
            header('Location: ' . $this->basePath . 'persona/index');
        }
        exit;
    }

    // Mostrar la confirmación de eliminación de persona
    public function eliminar($idpersona) {
        $this->persona->idpersona = $idpersona;
        $persona = $this->persona->readOne();

        if (!$persona) {
            die("Error: No se encontró la persona.");
        }

        require_once __DIR__ . '/../views/persona/delete.php';
    }

    // Procesar la eliminación de una persona
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // CSRF protection
            $token = $_POST['_csrf'] ?? '';
            if (!verify_csrf_token($token)) {
                header('Location: ' . $this->basePath . 'persona/index?msg=csrf');
                exit;
            }
            if (isset($_POST['idpersona'])) {
                $this->persona->idpersona = $_POST['idpersona'];
                if ($this->persona->delete()) {
                    header('Location: ' . $this->basePath . 'persona/index?msg=deleted');
                } else {
                    header('Location: ' . $this->basePath . 'persona/index?msg=error');
                }
            } else {
                header('Location: ' . $this->basePath . 'persona/index?msg=missingid');
            }
        } else {
            header('Location: ' . $this->basePath . 'persona/index');
        }
        exit;
    }

    // API (Se mantiene como estaba)
    public function api() {
        while (ob_get_level()) {
            ob_end_clean();
        }

        // --- CORRECCIÓN AQUÍ ---
        // El método getAll() fue eliminado del Modelo. Usamos read() en su lugar.
        $personas = $this->persona->read(); 
        header('Content-Type: application/json');
        echo json_encode($personas);
        exit;
    }
}
?>
