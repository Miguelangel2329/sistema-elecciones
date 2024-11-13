<?php
require_once 'config/database.php';

class CiudadanosController {
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

        // Obtener el parámetro de búsqueda si existe
        $busqueda = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
    
        // Si hay un término de búsqueda, filtrar los resultados
        if ($busqueda) {
            $query = "SELECT * FROM ciudadanos 
                      WHERE cedula LIKE :busqueda 
                         OR nombre LIKE :busqueda 
                         OR apellido LIKE :busqueda";
            $stmt = $this->db->prepare($query);
            $busquedaParam = '%' . $busqueda . '%';
            $stmt->bindParam(':busqueda', $busquedaParam);
        } else {
            // Si no hay término de búsqueda, obtener todos los ciudadanos
            $query = "SELECT * FROM ciudadanos";
            $stmt = $this->db->prepare($query);
        }
    
        $stmt->execute();
        $ciudadanos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        // Cargar la vista
        require_once 'app/views/ciudadanos.php';
    }
    

    public function agregar() {
        // Cargar la vista para agregar un nuevo ciudadano
        require_once 'app/views/agregar_ciudadano.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cedula = $_POST['cedula'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $email = $_POST['email'];
            $estado = $_POST['estado'] == 'Activo' ? 1 : 0;


            // Insertar el nuevo ciudadano en la base de datos
            $query = "INSERT INTO ciudadanos (cedula, nombre, apellido, email, estado) VALUES (:cedula, :nombre, :apellido, :email, :estado)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':cedula', $cedula);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':estado', $estado);
            $stmt->execute();

            header("Location: index.php?action=ciudadanos&mensaje=registrado_exitosamente");
            exit();
        }
    }

    public function editar() {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: index.php?action=ciudadanos");
            exit();
        }

        $id = $_GET['id'];

        // Obtener el ciudadano por ID
        $query = "SELECT * FROM ciudadanos WHERE cedula = :cedula";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':cedula', $id);
        $stmt->execute();
        $ciudadano = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$ciudadano) {
            header("Location: index.php?action=ciudadanos");
            exit();
        }

        // Cargar la vista para editar el ciudadano
        require_once 'app/views/editar_ciudadano.php';
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['cedula'])) {
            $id = $_POST['cedula'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $email = $_POST['email'];
            $estado = isset($_POST['estado']) ? intval($_POST['estado']) : 0;

            // Actualizar el partido en la base de datos
            $query = "UPDATE ciudadanos SET cedula = :cedula, nombre = :nombre, apellido = :apellido, email = :email, estado = :estado WHERE cedula = :cedula";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':cedula', $id);
            $stmt->execute();

            header("Location: index.php?action=ciudadanos&mensaje=actualizado_exitosamente");
            exit();
        }
    }

    public function eliminar() {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: index.php?action=ciudadanos");
            exit();
        }

        $id = $_GET['id'];

        try {
            $query = "DELETE FROM ciudadanos WHERE cedula = :cedula";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':cedula', $id);
            $stmt->execute();

            header("Location: index.php?action=ciudadanos&mensaje=eliminado_exitosamente");
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                header("Location: index.php?action=ciudadanos&error=no_se_puede_eliminar");
            } else {
                echo "Error: " . $e->getMessage();
            }
        }
    }
}
