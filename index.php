<?php
require_once 'app/controllers/MainController.php';
require_once 'app/controllers/AuthController.php';
require_once 'app/controllers/PartidosController.php';
require_once 'app/controllers/CandidatosController.php';
require_once 'app/controllers/PuestoController.php';
require_once 'app/controllers/CiudadanosController.php';
require_once 'app/controllers/DashboardController.php';
require_once 'app/controllers/EleccionesController.php';

$controller = null;
$action = isset($_GET['action']) ? $_GET['action'] : 'dashboard';

switch ($action) {
    case 'votacion':
        $controller = new MainController();
        $controller->votacion();
        break;

    case 'list_votacion':
        $controller = new MainController();
        $controller->list_votacion();
        break;

    case 'votar':
        $controller = new MainController();
        $controller->votar();
        break;
        
    case 'dashboard':
        $controller = new DashboardController();
        $controller->index();
        break;

    case 'elecciones':
        $controller = new EleccionesController();
        $controller->index();
        break;
    case 'iniciar_eleccion':
        $controller = new EleccionesController();
        $controller->iniciarEleccion();
        break;
    case 'guardar_eleccion':
        $controller = new EleccionesController();
        $controller->guardarEleccion();
        break;
    case 'terminar_eleccion':
        $controller = new EleccionesController();
        $controller->terminarEleccion();
        break;

    case 'ciudadanos':
        $controller = new CiudadanosController();
        $controller->index();
        break;
    case 'agregar_ciudadano':
        $controller = new CiudadanosController();
        $controller->agregar();
        break;
    case 'guardar_ciudadano':
        $controller = new CiudadanosController();
        $controller->guardar();
        break;
    case 'editar_ciudadano':
        $controller = new CiudadanosController();
        $controller->editar();
        break;
    case 'actualizar_ciudadano':
        $controller = new CiudadanosController();
        $controller->actualizar();
        break;
    case 'eliminar_ciudadano':
        $controller = new CiudadanosController();
        $controller->eliminar();
        break;
    
    case 'candidatos':
        $controller = new CandidatosController();
        $controller->index();
        break;
    case 'agregar_candidato':
        $controller = new CandidatosController();
        $controller->agregar();
        break;
    case 'guardar_candidato':
        $controller = new CandidatosController();
        $controller->guardar();
        break;
    case 'editar_candidato':
        $controller = new CandidatosController();
        $controller->editar();
        break;
    case 'actualizar_candidato':
        $controller = new CandidatosController();
        $controller->actualizar();
        break;
    case 'eliminar_candidato':
        $controller = new CandidatosController();
        $controller->eliminar();
        break;
    
    case 'puestos':
        $controller = new PuestoController();
        $controller->index();
        break;
    case 'agregar_puesto':
        $controller = new PuestoController();
        $controller->agregar();
        break;
    case 'guardar_puesto':
        $controller = new PuestoController();
        $controller->guardar();
        break;
    case 'editar_puesto':
        $controller = new PuestoController();
        $controller->editar();
        break;
    case 'actualizar_puesto':
        $controller = new PuestoController();
        $controller->actualizar();
        break;
    case 'eliminar_puesto':
        $controller = new PuestoController();
        $controller->eliminar();
        break;
    
    case 'partidos':
        $controller = new PartidosController();
        $controller->index();
        break;
    case 'agregar_partido':
        $controller = new PartidosController();
        $controller->agregar();
        break;
    case 'guardar_partido':
        $controller = new PartidosController();
        $controller->guardar();
        break;
    case 'editar_partido':
        $controller = new PartidosController();
        $controller->editar();
        break;
    case 'actualizar_partido':
        $controller = new PartidosController();
        $controller->actualizar();
        break;
    case 'eliminar_partido':
        $controller = new PartidosController();
        $controller->eliminar();
        break;
    case 'login':
        $controller = new AuthController();
        $controller->login();
        break;
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;
    default:
        $controller = new MainController();
        $controller->index();
        break;
    case 'home':
        $controller = new MainController();
        $controller->home();
        break;
    case 'votacion':
        $controller = new MainController();
        $controller->votacion();
        break;
    case 'ganadores':
        $controller = new MainController();
        $controller->ganadores();
        break;

    case 'list_votacion':
        $controller = new MainController();
        $controller->list_votacion();
        break;

    
    
}
