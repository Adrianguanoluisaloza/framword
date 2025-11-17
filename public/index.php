<?php
session_start();

// --- CONTROLADORES ---
require_once __DIR__ . '/../app/controllers/PersonaController.php';
require_once __DIR__ . '/../app/controllers/SexoController.php';
require_once __DIR__ . '/../app/controllers/DireccionController.php';
require_once __DIR__ . '/../app/controllers/TelefonoController.php';
require_once __DIR__ . '/../app/controllers/EstadocivilController.php';

// --- ANÁLISIS DE RUTA ---
$requestUri = $_SERVER["REQUEST_URI"];
// Detectar basePath dinámicamente en función de SCRIPT_NAME (soporta /public/index.php o /index.php)
$scriptName = $_SERVER['SCRIPT_NAME']; // Ejemplo: /public/index.php o /index.php
$basePath = rtrim(str_replace('index.php', '', $scriptName), '/') . '/';

// Obtener la ruta relativa al basePath
$route = '';
if (strpos($requestUri, $basePath) === 0) {
    $route = substr($requestUri, strlen($basePath));
}

// Limpiar la ruta
$route = strtok($route, '?'); // Quitar parámetros GET
$route = trim($route, '/'); // Quitar slashes al inicio y final

// --- MENÚ PRINCIPAL ---
// Si después de limpiar, la ruta está vacía, mostrar menú
if (empty($route)) { 
    $modules = [
        [
            'title' => 'Personas base',
            'description' => 'Registra estudiantes y docentes en una sola tabla para reutilizarlos en cada proceso.',
            'href' => $basePath . 'persona',
            'action' => $basePath . 'persona/create',
            'accent' => 'personas'
        ],
        [
            'title' => 'Contactos y teléfonos',
            'description' => 'Historial de teléfonos para avisos, tutorías y recordatorios escolares.',
            'href' => $basePath . 'telefono',
            'action' => $basePath . 'telefono/create',
            'accent' => 'telefonos'
        ],
        [
            'title' => 'Direcciones & sedes',
            'description' => 'Mantén ubicaciones de colegios, universidades y estudiantes siempre sincronizadas.',
            'href' => $basePath . 'direccion',
            'action' => $basePath . 'direccion/create',
            'accent' => 'direcciones'
        ],
        [
            'title' => 'Catálogo de sexos',
            'description' => 'Base mínima para reportes oficiales y formularios inclusivos.',
            'href' => $basePath . 'sexo',
            'action' => $basePath . 'sexo/create',
            'accent' => 'sexos'
        ],
        [
            'title' => 'Estados civiles y tutores',
            'description' => 'Clasifica contextos familiares antes de generar constancias.',
            'href' => $basePath . 'estadocivil',
            'action' => $basePath . 'estadocivil/create',
            'accent' => 'estadocivil'
        ],
    ];
    $summaryTiles = [
        [
            'label' => 'Alumnos registrados',
            'value' => '1,280',
            'helper' => 'Ejemplo basado en conteo SELECT COUNT(*)',
            'href' => $basePath . 'persona'
        ],
        [
            'label' => 'Profesores activos',
            'value' => '64',
            'helper' => 'Duplica la tabla personas filtrando por rol',
            'href' => $basePath . 'persona'
        ],
        [
            'label' => 'Teléfonos verificados',
            'value' => '512',
            'helper' => 'Sincroniza con el módulo Teléfonos para avisos',
            'href' => $basePath . 'telefono'
        ],
        [
            'label' => 'Sedes registradas',
            'value' => '24',
            'helper' => 'Basado en Direcciones & sedes',
            'href' => $basePath . 'direccion'
        ],
    ];
    $pipelineSteps = [
        [
            'title' => '1 · Registro base',
            'description' => 'Captura estudiantes y profesores como Personas, sin duplicar lógica.',
            'links' => [
                ['label' => 'Personas', 'href' => $basePath . 'persona'],
                ['label' => 'Agregar persona', 'href' => $basePath . 'persona/create']
            ]
        ],
        [
            'title' => '2 · Contactos',
            'description' => 'Adjunta teléfonos y direcciones para notificaciones y fichas.',
            'links' => [
                ['label' => 'Teléfonos', 'href' => $basePath . 'telefono'],
                ['label' => 'Direcciones', 'href' => $basePath . 'direccion']
            ]
        ],
        [
            'title' => '3 · Catálogos obligatorios',
            'description' => 'Mantén Sexos y Estados civiles al día para informes oficiales.',
            'links' => [
                ['label' => 'Sexos', 'href' => $basePath . 'sexo'],
                ['label' => 'Estados civiles', 'href' => $basePath . 'estadocivil']
            ]
        ],
        [
            'title' => '4 · Materias y campus',
            'description' => 'Duplica estas plantillas para materias, carreras y sedes específicas.',
            'links' => [
                ['label' => 'Plantilla Materia', 'href' => '#register'],
                ['label' => 'Instituciones', 'href' => '#institutions']
            ]
        ],
    ];
    $menuGroups = [
        [
            'title' => 'Registros base',
            'subtitle' => 'Personas, teléfonos y direcciones',
            'items' => array_slice($modules, 0, 3)
        ],
        [
            'title' => 'Catálogos esenciales',
            'subtitle' => 'Información que se reutiliza en todos los formularios',
            'items' => array_slice($modules, 3)
        ],
    ];
    $institutionPillars = [
        [
            'type' => 'Colegios',
            'title' => 'Catálogo de colegios',
            'description' => 'Administra planteles, niveles y contactos directivos en una ficha editable.',
            'bullets' => [
                'Definir niveles: inicial, primaria, secundaria',
                'Registrar responsable y datos de contacto',
                'Vincular con estudiantes registrados'
            ],
            'cta' => 'Configurar colegios',
            'href' => $basePath . 'direccion'
        ],
        [
            'type' => 'Universidades',
            'title' => 'Red de universidades',
            'description' => 'Documenta facultades, campus y convenios para prácticas profesionales.',
            'bullets' => [
                'Agregar campus por ciudad o país',
                'Anotar carreras activas y horas de práctica',
                'Mantener datos para cartas y oficios'
            ],
            'cta' => 'Gestionar universidades',
            'href' => $basePath . 'direccion'
        ],
    ];
    $subjectRoadmap = [
        [
            'title' => 'Diseña planes de estudio',
            'detail' => 'Define materias base, correlativas y duración para cada carrera o grado.'
        ],
        [
            'title' => 'Asigna responsables',
            'detail' => 'Relaciona cada materia con profesores registrados para clarificar liderazgos.'
        ],
        [
            'title' => 'Establece horarios y sedes',
            'detail' => 'Usa las direcciones guardadas para ubicar aulas virtuales o presenciales.'
        ],
        [
            'title' => 'Comunica cambios',
            'detail' => 'Aprovecha teléfonos y correos para notificar ajustes de última hora.'
        ],
    ];
    $checklist = [
        [
            'title' => 'Define catálogos educativos',
            'description' => 'Antes de registrar estudiantes, verifica Sexos y Estados civiles.',
            'href' => $basePath . 'sexo'
        ],
        [
            'title' => 'Carga docentes y estudiantes base',
            'description' => 'Usa el módulo Personas para que ambos perfiles compartan la misma estructura.',
            'href' => $basePath . 'persona/create'
        ],
        [
            'title' => 'Relaciona teléfonos y direcciones',
            'description' => 'En cada persona tendrás accesos a domicilios y contactos de emergencia.',
            'href' => $basePath . 'telefono'
        ],
        [
            'title' => 'Documenta instituciones externas',
            'description' => 'Registra colegios y universidades dentro de Direcciones para integrarlos al flujo.',
            'href' => $basePath . 'direccion'
        ],
    ];
    $faq = [
        [
            'question' => '¿Cómo diferencio estudiantes y profesores?',
            'answer' => 'Ambos se registran como personas. Puedes usar campos personalizados o etiquetas internas según tus necesidades.'
        ],
        [
            'question' => '¿Puedo usar este marco como plantilla?',
            'answer' => 'Sí. Esta página sirve como blueprint visual; adapta los formularios y tablas según tus modelos educativos.'
        ],
        [
            'question' => '¿Dónde conecto materias y colegios?',
            'answer' => 'Guarda cada sede en Direcciones y enlázala manualmente desde tus formularios personalizados o una nueva tabla.'
        ],
    ];
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Framework educativo</title>
    <link rel="stylesheet" href="<?php echo $basePath; ?>css/style.css">
</head>
<body class="landing-body">
    <?php include __DIR__ . '/../app/views/partials/navbar.php'; ?>
    <main class="landing">
        <section class="hero-card" id="inicio">
            <div>
                <p class="eyebrow">Framework educativo</p>
                <h1>Registra estudiantes, profesores e instituciones sin perder contexto</h1>
                <p class="subtitle">
                    Este panel agrupa los módulos existentes en una experiencia pensada para instituciones académicas. Usa los formularios de ejemplo para planear tus desarrollos antes de implementar la lógica final.
                </p>
            </div>
            <div class="hero-actions">
                <a class="btn btn-primary" href="<?php echo $basePath; ?>persona">Gestionar personas base</a>
                <a class="btn btn-secondary" href="<?php echo $basePath; ?>persona/create">Registrar nuevo perfil</a>
            </div>
            <nav class="hero-nav">
                <a class="pill-link" href="#overview">Resumen</a>
                <a class="pill-link" href="#flow">Flujo</a>
                <a class="pill-link" href="#menu">Menús</a>
                <a class="pill-link" href="#register">Registro</a>
                <a class="pill-link" href="#support">Checklist</a>
            </nav>
            <div class="hero-stats">
                <article class="stat-card">
                    <p class="stat-label">Módulos listos</p>
                    <p class="stat-value">5</p>
                    <p class="stat-desc">Personas, teléfonos, direcciones y catálogos listos para adaptar.</p>
                </article>
                <article class="stat-card">
                    <p class="stat-label">Formularios</p>
                    <p class="stat-value">3 plantillas</p>
                    <p class="stat-desc">Estudiantes, docentes y materias listas para personalizar.</p>
                </article>
                <article class="stat-card">
                    <p class="stat-label">Listo para clonar</p>
                    <p class="stat-value">100%</p>
                    <p class="stat-desc">Descarga el proyecto, modifícalo y crea tus propios módulos.</p>
                </article>
            </div>
        </section>

        <section id="overview" class="overview-section">
            <header class="section-heading">
                <div>
                    <p class="eyebrow">Resumen ejecutivo</p>
                    <h2>Visualiza tus datos clave</h2>
                    <p class="subtitle">Los valores son ejemplos. Reemplázalos con tus consultas SQL.</p>
                </div>
            </header>
            <div class="summary-grid">
                <?php foreach ($summaryTiles as $tile): ?>
                    <article class="summary-card">
                        <p class="summary-label"><?php echo htmlspecialchars($tile['label']); ?></p>
                        <p class="summary-value"><?php echo htmlspecialchars($tile['value']); ?></p>
                        <p class="summary-helper"><?php echo htmlspecialchars($tile['helper']); ?></p>
                        <a class="pill-link" href="<?php echo htmlspecialchars($tile['href']); ?>">Ver detalle</a>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="flow" class="pipeline-section">
            <header class="section-heading">
                <div>
                    <p class="eyebrow">Flujo recomendado</p>
                    <h2>Organiza tus menús en pasos claros</h2>
                </div>
            </header>
            <div class="pipeline-list">
                <?php foreach ($pipelineSteps as $step): ?>
                    <article class="pipeline-card">
                        <h3><?php echo htmlspecialchars($step['title']); ?></h3>
                        <p><?php echo htmlspecialchars($step['description']); ?></p>
                        <div class="pipeline-links">
                            <?php foreach ($step['links'] as $link): ?>
                                <a class="pill-link" href="<?php echo htmlspecialchars($link['href']); ?>">
                                    <?php echo htmlspecialchars($link['label']); ?>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="menu" class="menu-section">
            <header class="section-heading">
                <div>
                    <p class="eyebrow">Menús organizados</p>
                    <h2>Estructura base sin enredos</h2>
                    <p class="subtitle">Cada grupo agrupa enlaces reales del proyecto para que no queden sueltos.</p>
                </div>
            </header>
            <div class="menu-groups">
                <?php foreach ($menuGroups as $group): ?>
                    <article class="menu-group-card">
                        <header>
                            <h3><?php echo htmlspecialchars($group['title']); ?></h3>
                            <p><?php echo htmlspecialchars($group['subtitle']); ?></p>
                        </header>
                        <div class="menu-items">
                            <?php foreach ($group['items'] as $item): ?>
                                <div class="menu-item">
                                    <div>
                                        <p class="menu-item-title"><?php echo htmlspecialchars($item['title']); ?></p>
                                        <p class="menu-item-desc"><?php echo htmlspecialchars($item['description']); ?></p>
                                    </div>
                                    <div class="menu-item-actions">
                                        <a class="btn btn-primary" href="<?php echo htmlspecialchars($item['href']); ?>">Abrir</a>
                                        <a class="btn btn-ghost" href="<?php echo htmlspecialchars($item['action']); ?>">+ Crear</a>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section id="register" class="register-workbench">
            <header class="section-heading">
                <div>
                    <p class="eyebrow">Banco de formularios</p>
                    <h2>Plantillas de registro listas para copiar</h2>
                    <p class="subtitle">Simula el formulario antes de tocar la base de datos.</p>
                </div>
            </header>
            <div class="register-columns">
                <article class="intake-card">
                    <header>
                        <p class="card-tag">Plantilla</p>
                        <h2>Ingreso de estudiantes</h2>
                        <p>Define los campos básicos antes de llevarlos al módulo oficial de Personas.</p>
                    </header>
                    <form class="intake-form" action="javascript:void(0)" onsubmit="return false;">
                        <div class="intake-fields">
                            <label>
                                Nombre completo
                                <input type="text" class="input" placeholder="Ej. María Luna" />
                            </label>
                            <label>
                                Documento / Matrícula
                                <input type="text" class="input" placeholder="DNI, CURP, etc." />
                            </label>
                            <label>
                                Fecha de nacimiento
                                <input type="date" class="input" />
                            </label>
                            <label>
                                Colegio / Universidad
                                <input type="text" class="input" placeholder="Selecciona o escribe la institución" />
                            </label>
                            <label>
                                Materia principal
                                <input type="text" class="input" placeholder="Matemáticas, Historia..." />
                            </label>
                            <label>
                                Contacto del tutor
                                <input type="tel" class="input" placeholder="(+XX) 123 456 789" />
                            </label>
                        </div>
                        <div class="intake-actions">
                            <button type="submit" class="btn btn-primary">Guardar bosquejo</button>
                            <a class="btn btn-ghost" href="<?php echo $basePath; ?>persona/create">Abrir formulario real</a>
                        </div>
                    </form>
                </article>
                <article class="intake-card">
                    <header>
                        <p class="card-tag">Plantilla</p>
                        <h2>Ingreso de profesores</h2>
                        <p>Centraliza docentes, cátedras y datos de contacto antes de generar horarios.</p>
                    </header>
                    <form class="intake-form" action="javascript:void(0)" onsubmit="return false;">
                        <div class="intake-fields">
                            <label>
                                Nombre completo
                                <input type="text" class="input" placeholder="Ej. Luis Hernández" />
                            </label>
                            <label>
                                Especialidad
                                <input type="text" class="input" placeholder="Matemáticas, Literatura..." />
                            </label>
                            <label>
                                Correo institucional
                                <input type="email" class="input" placeholder="profesor@dominio.edu" />
                            </label>
                            <label>
                                Campus / Sede
                                <input type="text" class="input" placeholder="Campus Norte, Sede Virtual..." />
                            </label>
                            <label>
                                Fecha de ingreso
                                <input type="date" class="input" />
                            </label>
                            <label>
                                Materias asignadas
                                <textarea class="input" rows="3" placeholder="Lista rápida de materias"></textarea>
                            </label>
                        </div>
                        <div class="intake-actions">
                            <button type="submit" class="btn btn-primary">Guardar bosquejo</button>
                            <a class="btn btn-ghost" href="<?php echo $basePath; ?>persona/create">Duplicar campos reales</a>
                        </div>
                    </form>
                </article>
            </div>
            <article class="intake-card intake-card--full">
                <header>
                    <p class="card-tag">Plantilla</p>
                    <h2>Materia o curso</h2>
                    <p>Describe cada materia para luego conectarla con profesores e instituciones.</p>
                </header>
                <form class="intake-form" action="javascript:void(0)" onsubmit="return false;">
                    <div class="intake-fields">
                        <label>
                            Nombre de la materia
                            <input type="text" class="input" placeholder="Programación I" />
                        </label>
                        <label>
                            Código interno
                            <input type="text" class="input" placeholder="MAT-101" />
                        </label>
                        <label>
                            Nivel
                            <select class="select">
                                <option value="">Seleccionar nivel</option>
                                <option>Escolar</option>
                                <option>Preparatoria</option>
                                <option>Universidad</option>
                                <option>Postgrado</option>
                            </select>
                        </label>
                        <label>
                            Horas semanales
                            <input type="number" class="input" placeholder="Ej. 6" />
                        </label>
                        <label>
                            Responsable
                            <input type="text" class="input" placeholder="Profesor asignado" />
                        </label>
                        <label>
                            Observaciones
                            <textarea class="input" rows="3" placeholder="Notas sobre materiales, modalidad..."></textarea>
                        </label>
                    </div>
                    <div class="intake-actions">
                        <button type="submit" class="btn btn-primary">Guardar bosquejo</button>
                        <a class="btn btn-ghost" href="<?php echo $basePath; ?>direccion">Relacionar con sede</a>
                    </div>
                </form>
            </article>
        </section>

        <section id="institutions" class="institution-section">
            <header class="section-heading">
                <div>
                    <p class="eyebrow">Colegios y universidades</p>
                    <h2>Estandariza tus instituciones</h2>
                    <p class="subtitle">Usa la tabla de direcciones para listar sedes, campus y contactos.</p>
                </div>
            </header>
            <div class="institution-grid">
                <?php foreach ($institutionPillars as $pillar): ?>
                    <article class="institution-card">
                        <p class="card-tag"><?php echo htmlspecialchars($pillar['type']); ?></p>
                        <h3><?php echo htmlspecialchars($pillar['title']); ?></h3>
                        <p><?php echo htmlspecialchars($pillar['description']); ?></p>
                        <ul>
                            <?php foreach ($pillar['bullets'] as $bullet): ?>
                                <li><?php echo htmlspecialchars($bullet); ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <a class="btn btn-secondary" href="<?php echo htmlspecialchars($pillar['href']); ?>">
                            <?php echo htmlspecialchars($pillar['cta']); ?>
                        </a>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="modules" id="modules">
            <header class="section-heading">
                <div>
                    <p class="eyebrow">Blueprint de datos</p>
                    <h2>Componentes listos para conectar</h2>
                    <p class="subtitle">Estos módulos ya existen en el proyecto y sirven como base para cualquier flujo educativo.</p>
                </div>
            </header>
            <div class="module-grid">
                <?php foreach ($modules as $module): ?>
                    <article class="module-card module-card--<?php echo htmlspecialchars($module['accent']); ?>">
                        <header>
                            <h3><?php echo htmlspecialchars($module['title']); ?></h3>
                            <p><?php echo htmlspecialchars($module['description']); ?></p>
                        </header>
                        <div class="module-card-actions">
                            <a class="btn btn-primary" href="<?php echo htmlspecialchars($module['href']); ?>">Abrir módulo</a>
                            <a class="btn btn-ghost" href="<?php echo htmlspecialchars($module['action']); ?>">+ Crear registro</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>

        <section class="roadmap" id="roadmap">
            <header class="section-heading">
                <div>
                    <p class="eyebrow">Plan de materias</p>
                    <h2>Roadmap para tu equipo académico</h2>
                    <p class="subtitle">Tómalo como guía para desplegar cada funcionalidad.</p>
                </div>
            </header>
            <ol class="roadmap-list">
                <?php foreach ($subjectRoadmap as $index => $step): ?>
                    <li class="roadmap-item">
                        <div class="roadmap-step"><?php echo $index + 1; ?></div>
                        <div>
                            <h3><?php echo htmlspecialchars($step['title']); ?></h3>
                            <p><?php echo htmlspecialchars($step['detail']); ?></p>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ol>
        </section>

        <section class="support" id="support">
            <header class="section-heading">
                <div>
                    <p class="eyebrow">¿Nuevo en este framework?</p>
                    <h2>Checklist para implementar sin errores</h2>
                </div>
            </header>
            <div class="tips-grid">
                <article class="tip-card">
                    <p class="tip-number">1</p>
                    <h3>Define roles</h3>
                    <p>Decide cómo distinguirás estudiantes, profesores y administrativos usando la tabla Personas.</p>
                </article>
                <article class="tip-card">
                    <p class="tip-number">2</p>
                    <h3>Replica formularios</h3>
                    <p>Usa las plantillas superiores como referencia para tus propias vistas o componentes.</p>
                </article>
                <article class="tip-card">
                    <p class="tip-number">3</p>
                    <h3>Conecta catálogos</h3>
                    <p>Cuando agregues nuevos catálogos (ej. materias), enlázalos con las tablas existentes via IDs.</p>
                </article>
                <article class="tip-card">
                    <p class="tip-number">4</p>
                    <h3>Documenta procesos</h3>
                    <p>Agrega notas en README para que otros desarrolladores sepan cómo extender cada módulo.</p>
                </article>
            </div>
            <div class="support-grid">
                <article class="checklist-card">
                    <div class="progress-pill">
                        <span>Progreso sugerido</span>
                        <div class="progress-track">
                            <div class="progress-fill" style="width: 75%;"></div>
                        </div>
                        <strong>75% completado</strong>
                    </div>
                    <ul class="checklist">
                        <?php foreach ($checklist as $item): ?>
                            <li class="checklist-item">
                                <div>
                                    <p class="checklist-title"><?php echo htmlspecialchars($item['title']); ?></p>
                                    <p class="checklist-desc"><?php echo htmlspecialchars($item['description']); ?></p>
                                </div>
                                <a class="btn btn-ghost" href="<?php echo htmlspecialchars($item['href']); ?>">Ir</a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </article>
                <article class="faq-card">
                    <h3>Preguntas frecuentes</h3>
                    <ul class="faq-list">
                        <?php foreach ($faq as $entry): ?>
                            <li class="faq-item">
                                <p class="faq-question"><?php echo htmlspecialchars($entry['question']); ?></p>
                                <p class="faq-answer"><?php echo htmlspecialchars($entry['answer']); ?></p>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </article>
            </div>
        </section>
    </main>
    <script src="<?php echo $basePath; ?>js/script.js"></script>
</body>
</html>
<?php
} else {
    // --- ENRUTADOR PRINCIPAL ---
    switch ($route) {

        // --- RUTAS DE PERSONA (CRUD Completo) ---
        case 'persona':
        case 'persona/index':
            $controller = new PersonaController();
            $controller->index();
            break;
        case 'persona/create': 
            $controller = new PersonaController();
            $controller->create(); 
            break;
        case 'persona/store': 
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new PersonaController();
                $controller->store();
            }
            break;
        case 'persona/edit':
            if (isset($_GET['idpersona'])) {
                $controller = new PersonaController();
                $controller->edit($_GET['idpersona']);
            } else {
                echo "Error: Falta el ID de persona para editar.";
            }
            break;
        case 'persona/update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new PersonaController();
                $controller->update();
            }
            break;
        case 'persona/eliminar': 
             if (isset($_GET['idpersona'])) {
                $controller = new PersonaController();
                $controller->eliminar($_GET['idpersona']);
            } else {
                echo "Error: Falta el ID de persona para eliminar.";
            }
            break;
        case 'persona/delete': 
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new PersonaController();
                $controller->delete();
            }
            break;
        case 'persona/view': 
            if (isset($_GET['idpersona'])) {
                $controller = new PersonaController();
                $controller->registro($_GET['idpersona']);
            } else {
                echo "Error: Falta el ID de persona para ver.";
            }
            break;

        // --- RUTAS DE SEXO (CRUD Completo) ---
        case 'sexo':
        case 'sexo/index':
            $controller = new SexoController();
            $controller->index();
            break;
        case 'sexo/create':
            $controller = new SexoController();
            $controller->create();
            break;
        case 'sexo/store':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new SexoController();
                $controller->store();
            }
            break;
        case 'sexo/edit':
             if (isset($_GET['id'])) { 
                $controller = new SexoController();
                $controller->edit($_GET['id']); 
            } else {
                echo "Error: Falta el ID de sexo para editar.";
            }
            break;
        case 'sexo/update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new SexoController();
                $controller->update();
            }
            break;
        case 'sexo/eliminar': 
             if (isset($_GET['id'])) { 
                $controller = new SexoController();
                $controller->eliminar($_GET['id']); 
            } else {
                echo "Error: Falta el ID de sexo para eliminar."; 
            }
            break;
        case 'sexo/delete': 
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new SexoController();
                $controller->delete();
            }
            break;

        // --- RUTAS DE DIRECCION (CRUD Completo) ---
        case 'direccion':
        case 'direccion/index':
            $controller = new DireccionController();
            $controller->index();
            break;
        case 'direccion/create':
            $controller = new DireccionController();
            $controller->create(); 
            break;
        case 'direccion/store':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new DireccionController();
                $controller->store();
            }
            break;
        case 'direccion/edit':
            if (isset($_GET['iddireccion'])) {
                $controller = new DireccionController();
                $controller->edit($_GET['iddireccion']);
            } else {
                echo "Error: Falta el ID de dirección para editar.";
            }
            break;
        case 'direccion/update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new DireccionController();
                $controller->update();
            }
            break;
        case 'direccion/eliminar':
            if (isset($_GET['iddireccion'])) {
                $controller = new DireccionController();
                $controller->eliminar($_GET['iddireccion']);
            } else {
                echo "Error: Falta el ID de dirección para eliminar.";
            }
            break;
        case 'direccion/delete':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new DireccionController();
                $controller->delete();
            }
            break;

        // --- RUTAS DE TELEFONO (CRUD Completo) ---
        case 'telefono':
        case 'telefono/index':
            $controller = new TelefonoController();
            $controller->index();
            break;
        case 'telefono/create':
            $controller = new TelefonoController();
            $controller->create(); 
            break;
        case 'telefono/store':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new TelefonoController();
                $controller->store();
            }
            break;
        case 'telefono/edit':
            if (isset($_GET['idtelefono'])) { 
                $controller = new TelefonoController();
                $controller->edit($_GET['idtelefono']);
            } else {
                echo "Error: Falta el ID de teléfono para editar.";
            }
            break;
        case 'telefono/update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new TelefonoController();
                $controller->update();
            }
            break;
        case 'telefono/eliminar':
             if (isset($_GET['idtelefono'])) {
                $controller = new TelefonoController();
                $controller->eliminar($_GET['idtelefono']);
            } else {
                echo "Error: Falta el ID de teléfono para eliminar.";
            }
            break;
        case 'telefono/delete':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new TelefonoController();
                $controller->delete();
            }
            break;

        // --- RUTAS DE ESTADO CIVIL (CRUD Completo) ---
        case 'estadocivil':
        case 'estadocivil/index':
            $controller = new EstadocivilController();
            $controller->index();
            break;
        case 'estadocivil/create':
            $controller = new EstadocivilController();
            $controller->create();
            break;
        case 'estadocivil/store':
             if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new EstadocivilController();
                $controller->store();
            }
            break;
        case 'estadocivil/edit':
            if (isset($_GET['idestadocivil'])) {
                $controller = new EstadocivilController();
                $controller->edit($_GET['idestadocivil']);
            } else {
                echo "Error: Falta el ID de estado civil para editar.";
            }
            break;
        case 'estadocivil/update':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new EstadocivilController();
                $controller->update();
            }
            break;
        case 'estadocivil/eliminar':
            if (isset($_GET['idestadocivil'])) {
                $controller = new EstadocivilController();
                $controller->eliminar($_GET['idestadocivil']);
            } else {
                echo "Error: Falta el ID de estado civil para eliminar.";
            }
            break;
        case 'estadocivil/delete':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $controller = new EstadocivilController();
                $controller->delete();
            }
            break;

        // --- RUTAS DE ESTUDIANTE (CRUD Completo) ---
        case 'estudiante':
        case 'estudiante/index':
            require_once __DIR__ . '/../app/controllers/EstudianteController.php';
            $controller = new EstudianteController();
            $controller->index();
            break;
        case 'estudiante/create':
            require_once __DIR__ . '/../app/controllers/EstudianteController.php';
            $controller = new EstudianteController();
            $controller->create();
            break;
        case 'estudiante/edit':
            require_once __DIR__ . '/../app/controllers/EstudianteController.php';
            if (isset($_GET['id'])) {
                $controller = new EstudianteController();
                $controller->edit($_GET['id']);
            } else {
                echo "Error: Falta el ID de estudiante para editar.";
            }
            break;
        case 'estudiante/delete':
            require_once __DIR__ . '/../app/controllers/EstudianteController.php';
            if (isset($_GET['id'])) {
                $controller = new EstudianteController();
                $controller->delete($_GET['id']);
            } else {
                echo "Error: Falta el ID de estudiante para eliminar.";
            }
            break;

        // --- RUTAS DE UNIVERSIDAD (CRUD Completo) ---
        case 'universidad':
        case 'universidad/index':
            require_once __DIR__ . '/../app/controllers/UniversidadController.php';
            $controller = new UniversidadController();
            $controller->index();
            break;
        case 'universidad/create':
            require_once __DIR__ . '/../app/controllers/UniversidadController.php';
            $controller = new UniversidadController();
            $controller->create();
            break;
        case 'universidad/edit':
            require_once __DIR__ . '/../app/controllers/UniversidadController.php';
            if (isset($_GET['id'])) {
                $controller = new UniversidadController();
                $controller->edit($_GET['id']);
            } else {
                echo "Error: Falta el ID de universidad para editar.";
            }
            break;
        case 'universidad/delete':
            require_once __DIR__ . '/../app/controllers/UniversidadController.php';
            if (isset($_GET['id'])) {
                $controller = new UniversidadController();
                $controller->delete($_GET['id']);
            } else {
                echo "Error: Falta el ID de universidad para eliminar.";
            }
            break;

        // --- RUTAS DE PROFESOR (CRUD Completo) ---
                // --- RUTAS DE AUTENTICACIÓN (LOGIN / REGISTER) ---
                case 'auth/login':
                    require_once __DIR__ . '/../app/controllers/AuthController.php';
                    $controller = new AuthController();
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $controller->login();
                    } else {
                        $controller->loginForm();
                    }
                    break;
                case 'auth/register':
                    require_once __DIR__ . '/../app/controllers/AuthController.php';
                    $controller = new AuthController();
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $controller->register();
                    } else {
                        $controller->registerForm();
                    }
                    break;
                case 'auth/logout':
                    require_once __DIR__ . '/../app/controllers/AuthController.php';
                    $controller = new AuthController();
                    $controller->logout();
                    break;
        case 'profesor':
        case 'profesor/index':
            require_once __DIR__ . '/../app/controllers/ProfesorController.php';
            $controller = new ProfesorController();
            $controller->index();
            break;
        case 'profesor/create':
            require_once __DIR__ . '/../app/controllers/ProfesorController.php';
            $controller = new ProfesorController();
            $controller->create();
            break;
        case 'profesor/edit':
            require_once __DIR__ . '/../app/controllers/ProfesorController.php';
            if (isset($_GET['id'])) {
                $controller = new ProfesorController();
                $controller->edit($_GET['id']);
            } else {
                echo "Error: Falta el ID de profesor para editar.";
            }
            break;
        case 'profesor/delete':
            require_once __DIR__ . '/../app/controllers/ProfesorController.php';
            if (isset($_GET['id'])) {
                $controller = new ProfesorController();
                $controller->delete($_GET['id']);
            } else {
                echo "Error: Falta el ID de profesor para eliminar.";
            }
            break;

        // --- RUTA DEFAULT ---
        case 'status':
            // Muestra un resumen rápido de tablas y conteos (útil para desarrollo)
            require_once __DIR__ . '/../config/database.php';
            try {
                $db = (new Database())->getConnection();
                $tables = ['personas' => 'persona', 'universidades' => 'universidades', 'estudiantes' => 'estudiantes', 'profesores' => 'profesores', 'telefonos' => 'telefono'];
                // Permitir formato text/plain si se solicita explícitamente
                $format = isset($_GET['format']) ? strtolower($_GET['format']) : 'html';
                if ($format === 'text') {
                    header('Content-Type: text/plain');
                    echo "Estado de la base de datos:\n";
                    foreach ($tables as $label => $table) {
                        try {
                            $count = $db->query("SELECT COUNT(*) as c FROM `$table`")->fetchColumn();
                            echo sprintf("%s (%s): %s\n", $label, $table, $count);
                        } catch (Exception $e) {
                            echo sprintf("%s (%s): NOT FOUND\n", $label, $table);
                        }
                    }
                } else {
                    // Salida HTML básica para facilitar la lectura en el navegador
                    ?>
                    <!DOCTYPE html>
                    <html lang="es">
                    <head>
                        <meta charset="utf-8" />
                        <meta name="viewport" content="width=device-width, initial-scale=1" />
                        <title>Status DB — Framword</title>
                        <style>body{font-family:system-ui,Segoe UI,Roboto,Arial;margin:1rem;background:#f9fafb;color:#111}table{border-collapse:collapse;background:#fff;border:1px solid #ddd}td,th{padding:.45rem 1rem;border:1px solid #eee;text-align:left}</style>
                    </head>
                    <body>
                        <h1>Estado de la Base de Datos</h1>
                        <table>
                            <thead>
                                <tr><th>Etiqueta</th><th>Tabla</th><th>Resultado</th></tr>
                            </thead>
                            <tbody>
                    <?php
                    foreach ($tables as $label => $table) {
                        try {
                            $count = $db->query("SELECT COUNT(*) as c FROM `$table`")->fetchColumn();
                            $row = sprintf('<tr><td>%s</td><td>%s</td><td>%s</td></tr>', htmlspecialchars($label), htmlspecialchars($table), htmlspecialchars($count));
                        } catch (Exception $e) {
                            $row = sprintf('<tr><td>%s</td><td>%s</td><td style="color:#c00">NOT FOUND</td></tr>', htmlspecialchars($label), htmlspecialchars($table));
                        }
                        echo $row;
                    }
                    ?>
                            </tbody>
                        </table>
                        <p><small>Formato alternativo de texto plano: <a href="?format=text">?format=text</a></small></p>
                    </body>
                    </html>
                    <?php
                }
            } catch (Exception $e) {
                echo "ERROR: No se pudo conectar a la base de datos: " . $e->getMessage();
            }
            break;
        default:
            // Intentar cargar una vista estática si existe (opcional)
            // $staticView = __DIR__ . '/../app/views/' . $route . '.php';
            // if (file_exists($staticView)) {
            //     require_once $staticView;
            // } else {
                 echo "Error 404: Página no encontrada. (Ruta: '$route')";
            // }
            break;
    }
}
?>
