<?php
require_once 'config/database.php';

class DashboardController {
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
    
        // Obtener ID de la elección actual o última elección
        $queryEleccion = "
            SELECT id_elecciones 
            FROM elecciones 
            WHERE estado = 1 
            ORDER BY fecha DESC 
            LIMIT 1
        ";
        $stmt = $this->db->prepare($queryEleccion);
        $stmt->execute();
        $eleccion = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$eleccion) {
            $queryEleccion = "
                SELECT id_elecciones 
                FROM elecciones 
                ORDER BY fecha DESC 
                LIMIT 1
            ";
            $stmt = $this->db->prepare($queryEleccion);
            $stmt->execute();
            $eleccion = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    
        $idEleccion = $eleccion['id_elecciones'];
    
        // Obtener estadísticas para el dashboard
        $totalUsuarios = $this->getCount("SELECT COUNT(*) AS total FROM ciudadanos WHERE estado = '1'");
        $totalVotados = $this->getCount("SELECT COUNT(DISTINCT cedula) AS total FROM elecciones_cont WHERE id_elecciones = :id_eleccion", [':id_eleccion' => $idEleccion]);
        $sinVotar = $totalUsuarios - $totalVotados;
        $votosEnBlanco = $this->getCount("SELECT COUNT(*) AS total FROM elecciones_cont WHERE id_elecciones = :id_eleccion AND id_candidato = 0", [':id_eleccion' => $idEleccion]);
    
        // Calcula los porcentajes
        $porcentajeSinVotar = ($totalUsuarios > 0) ? ($sinVotar / $totalUsuarios) * 100 : 0;
        $porcentajeEnBlanco = ($totalUsuarios > 0) ? ($votosEnBlanco / $totalUsuarios) * 100 : 0;
        $porcentajeTotalVotados = ($totalUsuarios > 0) ? ($totalVotados / $totalUsuarios) * 100 : 0;
    
        $ciudadanos = $this->getCiudadanos();
        $candidatosData = $this->getCandidatosData();
    
        require_once 'app/views/dashboard.php';
    }
    
    private function getCount($query, $params = []) {
        $stmt = $this->db->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
    

    private function getCiudadanos() {
        $query = "SELECT cedula, nombre, apellido, email, estado, Grado FROM ciudadanos";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    private function getCandidatosData() {
        // Obtiene la elección activa o, si no hay ninguna, la última elección realizada.
        $queryEleccion = "
            SELECT id_elecciones 
            FROM elecciones 
            WHERE estado = 1 
            ORDER BY fecha DESC 
            LIMIT 1
        ";
        $stmt = $this->db->prepare($queryEleccion);
        $stmt->execute();
        $eleccion = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$eleccion) {
            // Si no hay una elección activa, obtiene la última elección realizada
            $queryEleccion = "
                SELECT id_elecciones 
                FROM elecciones 
                ORDER BY fecha DESC 
                LIMIT 1
            ";
            $stmt = $this->db->prepare($queryEleccion);
            $stmt->execute();
            $eleccion = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    
        // Ahora usa el ID de la elección obtenida para filtrar los votos de los candidatos
        $idEleccion = $eleccion['id_elecciones'];
        $query = "
            SELECT candidatos.nombre AS candidato, COUNT(elecciones_cont.cedula) AS votos 
            FROM candidatos 
            LEFT JOIN elecciones_cont 
            ON candidatos.id_candidato = elecciones_cont.id_candidato 
            AND elecciones_cont.id_elecciones = :id_eleccion
            GROUP BY candidatos.id_candidato
        ";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_eleccion', $idEleccion);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

}
