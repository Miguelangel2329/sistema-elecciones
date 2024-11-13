<?php
require_once 'config/database.php';

class PuestoController {
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

        // Obtener la lista de puestos electivos
        $query = "SELECT * FROM puestos";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $puestos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cargar la vista
        require_once 'app/views/puestos.php';
    }
    public function agregar() {
        // Cargar la vista para agregar un nuevo partido
        require_once 'app/views/agregar_puesto.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'] == 'Activo' ? 1 : 0;


            // Insertar el nuevo puesto en la base de datos
            $query = "INSERT INTO puestos (nombre, descripcion, estado) VALUES (:nombre, :descripcion, :estado)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':estado', $estado);
            $stmt->execute();

            header("Location: index.php?action=puestos&mensaje=registrado_exitosamente");
            exit();
        }
    }
    public function editar() {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: index.php?action=puestos");
            exit();
        }

        $id = $_GET['id'];

        // Obtener el puesto por ID
        $query = "SELECT * FROM puestos WHERE id_puesto = :id_puesto";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_puesto', $id);
        $stmt->execute();
        $puesto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$puesto) {
            header("Location: index.php?action=puestos");
            exit();
        }

        // Cargar la vista para editar el puesto
        require_once 'app/views/editar_puesto.php';
    }
    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_puesto'])) {
            $id = $_POST['id_puesto'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $estado = isset($_POST['estado']) ? intval($_POST['estado']) : 0;

            // Actualizar el puesto en la base de datos
            $query = "UPDATE puestos SET nombre = :nombre, descripcion = :descripcion, estado = :estado WHERE id_puesto = :id_puesto";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':id_puesto', $id);
            $stmt->execute();

            header("Location: index.php?action=puestos&mensaje=actualizado_exitosamente");
            exit();
        }
    }
    public function eliminar() {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: index.php?action=puestos");
            exit();
        }

        $id = $_GET['id'];

        try {
            $query = "DELETE FROM puestos WHERE id_puesto = :id_puesto";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_puesto', $id);
            $stmt->execute();

            header("Location: index.php?action=puestos&mensaje=eliminado_exitosamente");
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                header("Location: index.php?action=puestos&error=no_se_puede_eliminar");
            } else {
                echo "Error: " . $e->getMessage();
            }
        }
    }

}