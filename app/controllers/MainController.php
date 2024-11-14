<?php
// MainController.php
require_once 'config/database.php';

class MainController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function votacion() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $cedula = $_POST['cedula'];

            // Validar si el ciudadano existe y está activo
            $query = "SELECT * FROM ciudadanos WHERE cedula = :cedula AND estado = 1";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':cedula', $cedula);
            $stmt->execute();
            $ciudadano = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($ciudadano) {
                // Guardar cédula en sesión y redirigir a `list_votacion`
                session_start();
                $_SESSION['cedula'] = $cedula;
                header("Location: index.php?action=list_votacion");
                exit();
            } else {
                $error = "Cédula inválida o ciudadano inactivo.";
                require_once 'app/views/votacion.php';
            }
        } else {
            require_once 'app/views/votacion.php';
        }
    }

    public function list_votacion() {
        session_start();
        if (!isset($_SESSION['cedula'])) {
            header("Location: index.php?action=votacion");
            exit();
        }

        // Validar si la elección está activa
        $query = "SELECT * FROM elecciones WHERE estado = 1 LIMIT 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $eleccion = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($eleccion) {
            // Obtener los candidatos activos
            $query = "SELECT c.*, p.nombre AS partido_nombre, p.logo 
                      FROM candidatos c
                      JOIN partidos p ON c.id_partido = p.id_partido
                      WHERE c.estado = 1";
            $stmt = $this->db->prepare($query);
            $stmt->execute();
            $candidatos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            require_once 'app/views/list_votacion.php';
        } else {
            header("Location: index.php?action=votacion&error=no_election");
        }
    }

    public function votar() {
        session_start();
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['cedula'])) {
            $cedula = $_SESSION['cedula'];
            $id_candidato = $_POST['id_candidato'];
            $id_eleccion = $_POST['id_eleccion'] ?? null;
            $id_puesto = $_POST['id_puesto'];
    
            // Verificar que el id_eleccion no sea NULL
            if (is_null($id_eleccion)) {
                echo "Error: ID de elección no proporcionado.";
                header("refresh:3;url=index.php?action=list_votacion");
                exit();
            }
    
            // Validar que el usuario no haya votado por este puesto
            $query = "SELECT * FROM elecciones_cont WHERE cedula = :cedula AND id_elecciones = :id_elecciones AND id_puesto = :id_puesto";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':cedula', $cedula);
            $stmt->bindParam(':id_elecciones', $id_eleccion);
            $stmt->bindParam(':id_puesto', $id_puesto);
            $stmt->execute();
            $votoExistente = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if (!$votoExistente) {
                // Obtener el id_partido del candidato seleccionado
                $query = "SELECT id_partido FROM candidatos WHERE id_candidato = :id_candidato";
                $stmt = $this->db->prepare($query);
                $stmt->bindParam(':id_candidato', $id_candidato);
                $stmt->execute();
                $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
                if ($resultado) {
                    $id_partido = $resultado['id_partido'];
    
                    // Insertar el voto en `elecciones_cont`
                    $query = "INSERT INTO elecciones_cont (id_elecciones, id_candidato, id_partido, id_puesto, cedula) VALUES (:id_elecciones, :id_candidato, :id_partido, :id_puesto, :cedula)";
                    $stmt = $this->db->prepare($query);
                    $stmt->bindParam(':id_elecciones', $id_eleccion);
                    $stmt->bindParam(':id_candidato', $id_candidato);
                    $stmt->bindParam(':id_partido', $id_partido);
                    $stmt->bindParam(':id_puesto', $id_puesto);
                    $stmt->bindParam(':cedula', $cedula);
                    $stmt->execute();
    
                    echo "Gracias por votar por: " . htmlspecialchars($_POST['nombre_candidato']);
                    session_unset();
                    header("refresh:2;url=index.php?action=votacion");
                } else {
                    echo "Error: Candidato no encontrado.";
                    header("refresh:2;url=index.php?action=list_votacion");
                }
            } else {
                echo "Ya has votado en esta elección.";
                header("refresh:2;url=index.php?action=votacion");
            }
          } 
    }
    public function home() {
        // Cargar la vista principal de "home"
        require_once 'app/views/home.php';
    }

    public function ganadores() {
        $queryEleccion = "SELECT * FROM elecciones WHERE estado IN (1, 0) ORDER BY fecha DESC LIMIT 1";
        $stmtEleccion = $this->db->prepare($queryEleccion);
        $stmtEleccion->execute();
        $eleccion = $stmtEleccion->fetch(PDO::FETCH_ASSOC);
    
        if ($eleccion) {
            $idEleccion = $eleccion['id_elecciones'];
    
            // Consulta para obtener todos los candidatos con sus votos en la última elección
            $queryCandidatos = "
                SELECT 
                    c.nombre AS candidato,
                    p.nombre AS partido,
                    pu.nombre AS puesto,
                    COUNT(ec.id_candidato) AS total_votos
                FROM elecciones_cont ec
                JOIN candidatos c ON ec.id_candidato = c.id_candidato
                JOIN partidos p ON c.id_partido = p.id_partido
                JOIN puestos pu ON c.id_puesto = pu.id_puesto
                WHERE ec.id_elecciones = :id_eleccion
                GROUP BY ec.id_candidato
                ORDER BY total_votos DESC
            ";
            $stmtCandidatos = $this->db->prepare($queryCandidatos);
            $stmtCandidatos->bindParam(':id_eleccion', $idEleccion);
            $stmtCandidatos->execute();
            $candidatos = $stmtCandidatos->fetchAll(PDO::FETCH_ASSOC);
    
            // Pasa los datos a la vista
            require_once 'app/views/ganadores.php';
        } else {
            echo "No hay elecciones recientes para mostrar los resultados.";
        }
    }

    public function candid() {
        $query = "SELECT 
                    c.id_candidato,
                    c.nombre AS nombre_candidato,
                    c.apellido,
                    c.id_partido,
                    c.id_puesto,
                    c.estado,
                    c.nom_teni,
                    c.gra_teni,
                    c.nom_salu,
                    c.gra_salu,
                    c.nom_educ,
                    c.gra_educ,
                    c.nom_dere,
                    c.gra_dere,
                    c.nom_comu,
                    c.gra_comu,
                    c.nom_empr,
                    c.gra_empr,
                    c.plan_trab,
                    p.nombre AS nombre_partido,
                    p.logo,
                    foto_perfil,
                    pu.nombre AS puesto
                FROM candidatos c
                JOIN partidos p ON c.id_partido = p.id_partido
                JOIN puestos pu ON c.id_puesto = pu.id_puesto
                WHERE c.estado = 1";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $candidatos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Pasar los datos a la vista
        require_once 'app/views/candidato_l.php';
    }
    
}
