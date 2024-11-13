<?php
require_once 'config/database.php';

class PartidosController {
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

        // Obtener la lista de partidos
        $query = "SELECT * FROM partidos";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $partidos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cargar la vista
        require_once 'app/views/partidos.php';
    }

    public function agregar() {
        // Cargar la vista para agregar un nuevo partido
        require_once 'app/views/agregar_partido.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $estado = $_POST['estado'] == 'Activo' ? 1 : 0;

            // Subir el archivo de imagen
            $logo = null;
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
                $nombreImagen = $_FILES['logo']['name'];
                $rutaDestino = 'public/images/' . $nombreImagen;
                if (move_uploaded_file($_FILES['logo']['tmp_name'], $rutaDestino)) {
                    $logo = $nombreImagen;
                }
            }

            // Insertar el nuevo partido en la base de datos
            $query = "INSERT INTO partidos (nombre, descripcion, logo, estado) VALUES (:nombre, :descripcion, :logo, :estado)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':logo', $logo);
            $stmt->bindParam(':estado', $estado);
            $stmt->execute();

            header("Location: index.php?action=partidos&mensaje=registrado_exitosamente");
            exit();
        }
    }

    public function editar() {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: index.php?action=partidos");
            exit();
        }

        $id = $_GET['id'];

        // Obtener el partido por ID
        $query = "SELECT * FROM partidos WHERE id_partido = :id_partido";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_partido', $id);
        $stmt->execute();
        $partido = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$partido) {
            header("Location: index.php?action=partidos");
            exit();
        }

        // Cargar la vista para editar el partido
        require_once 'app/views/editar_partido.php';
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_partido'])) {
            $id = $_POST['id_partido'];
            $nombre = $_POST['nombre'];
            $descripcion = $_POST['descripcion'];
            $estado = isset($_POST['estado']) ? intval($_POST['estado']) : 0;

            // Verificar si se ha subido un nuevo logo
            $logo = $_POST['logo_actual'];
            if (isset($_FILES['logo']) && $_FILES['logo']['error'] == 0) {
                $nombreImagen = $_FILES['logo']['name'];
                $rutaDestino = 'public/images/' . $nombreImagen;
                if (move_uploaded_file($_FILES['logo']['tmp_name'], $rutaDestino)) {
                    $logo = $nombreImagen;
                }
            }

            // Actualizar el partido en la base de datos
            $query = "UPDATE partidos SET nombre = :nombre, descripcion = :descripcion, logo = :logo, estado = :estado WHERE id_partido = :id_partido";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':descripcion', $descripcion);
            $stmt->bindParam(':logo', $logo);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':id_partido', $id);
            $stmt->execute();

            header("Location: index.php?action=partidos&mensaje=actualizado_exitosamente");
            exit();
        }
    }

    public function eliminar() {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: index.php?action=partidos");
            exit();
        }

        $id = $_GET['id'];

        try {
            $query = "DELETE FROM partidos WHERE id_partido = :id_partido";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_partido', $id);
            $stmt->execute();

            header("Location: index.php?action=partidos&mensaje=eliminado_exitosamente");
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                header("Location: index.php?action=partidos&error=no_se_puede_eliminar");
            } else {
                echo "Error: " . $e->getMessage();
            }
        }
    }
}
