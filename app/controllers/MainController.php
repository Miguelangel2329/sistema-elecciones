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
                    header("refresh:3;url=index.php?action=votacion");
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

}
