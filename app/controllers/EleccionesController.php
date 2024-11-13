<?php
require_once 'config/database.php';

class EleccionesController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function index() {
        session_start();
        if (!isset($_SESSION['id_usuario'])) {
            header("Location: index.php?action=login");
            exit();
        }

        // Obtener todas las elecciones, incluyendo el estado
        $queryElecciones = "SELECT id_elecciones, nombre, fecha, estado FROM elecciones ORDER BY fecha DESC";
        $stmt = $this->db->prepare($queryElecciones);
        $stmt->execute();
        $elecciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Obtener candidatos y votos para cada elección
        foreach ($elecciones as &$eleccion) {
            $queryCandidatos = "
                SELECT c.nombre AS candidato, p.nombre AS partido, pu.nombre AS puesto, COUNT(ec.cedula) AS total_votos
                FROM elecciones_cont ec
                JOIN candidatos c ON ec.id_candidato = c.id_candidato
                JOIN partidos p ON c.id_partido = p.id_partido
                JOIN puestos pu ON c.id_puesto = pu.id_puesto
                WHERE ec.id_elecciones = :id_elecciones
                GROUP BY c.id_candidato";
            $stmt = $this->db->prepare($queryCandidatos);
            $stmt->bindParam(':id_elecciones', $eleccion['id_elecciones']);
            $stmt->execute();
            $eleccion['candidatos'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    
        // Pasar los datos a la vista
        require_once 'app/views/elecciones.php';
    }

    public function iniciarEleccion() {
        // Cargar vista para registrar una nueva elección
        require_once 'app/views/registrar_eleccion.php';
    }

    public function guardarEleccion() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombre'];
            $fecha = date('Y-m-d H:i:s'); // Hora y fecha actual al iniciar elección
            $estado = 1; // Elección activa

            $query = "INSERT INTO elecciones (nombre, fecha, estado) VALUES (:nombre, :fecha, :estado)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':fecha', $fecha);
            $stmt->bindParam(':estado', $estado);
            $stmt->execute();

            header("Location: index.php?action=elecciones&mensaje=eleccion_iniciada");
            exit();
        }
    }

    public function terminarEleccion() {
        // Cambiar el estado de la elección activa a 0 (inactiva)
        $query = "UPDATE elecciones SET estado = 0 WHERE estado = 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        header("Location: index.php?action=elecciones&mensaje=eleccion_finalizada");
        exit();
    }
}
