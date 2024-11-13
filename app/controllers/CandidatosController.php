<?php
require_once 'config/database.php';

class CandidatosController {
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

        // Obtener la lista de candidatos
        $query = "SELECT * FROM candidatos";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $candidatos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cargar la vista
        require_once 'app/views/candidatos.php';
    }

    public function agregar() {
        // Cargar la vista para agregar un nuevo candidato
        require_once 'app/views/agregar_candidato.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $id_partido = $_POST['id_partido'];
            $id_puesto = $_POST['id_puesto'];
            $estado = $_POST['estado'] == 'Activo' ? 1 : 0;  // Asegurar que el estado es 1 o 0
            $nom_teni = $_POST['nom-teni'];
            $gra_teni = $_POST['gra-teni'];
            $nom_salu = $_POST['nom-salu'];
            $gra_salu = $_POST['gra-salu'];
            $nom_educ = $_POST['nom-educ'];
            $gra_educ = $_POST['gra-educ'];
            $nom_dere = $_POST['nom-dere'];
            $gra_dere = $_POST['gra-dere'];
            $nom_comu = $_POST['nom-comu'];
            $gra_comu = $_POST['gra-comu'];
            $nom_empr = $_POST['nom-empr'];
            $gra_empr = $_POST['gra-empr'];
            $plan_trab = $_POST['plan-trab'];
    
            // Subir el archivo de imagen
            $foto_perfil = null;
            if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == 0) {
                $nombreImagen = $_FILES['foto_perfil']['name'];
                $rutaDestino = 'public/images/' . $nombreImagen;
                if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $rutaDestino)) {
                    $foto_perfil = $nombreImagen;
                }
            }
    
            // Insertar el nuevo candidato en la base de datos
            $query = "INSERT INTO candidatos (nombre, apellido, id_partido, id_puesto, foto_perfil, estado, nom_teni, gra_teni, nom_salu, gra_salu, nom_educ, gra_educ, nom_dere, gra_dere, nom_comu, gra_comu, nom_empr, gra_empr, plan_trab) 
                      VALUES (:nombre, :apellido, :id_partido, :id_puesto, :foto_perfil, :estado, :nom_teni, :gra_teni, :nom_salu, :gra_salu, :nom_educ, :gra_educ, :nom_dere, :gra_dere, :nom_comu, :gra_comu, :nom_empr, :gra_empr, :plan_trab)";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':id_partido', $id_partido);
            $stmt->bindParam(':id_puesto', $id_puesto);
            $stmt->bindParam(':foto_perfil', $foto_perfil);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':nom_teni', $nom_teni);
            $stmt->bindParam(':gra_teni', $gra_teni);
            $stmt->bindParam(':nom_salu', $nom_salu);
            $stmt->bindParam(':gra_salu', $gra_salu);
            $stmt->bindParam(':nom_educ', $nom_educ);
            $stmt->bindParam(':gra_educ', $gra_educ);
            $stmt->bindParam(':nom_dere', $nom_dere);
            $stmt->bindParam(':gra_dere', $gra_dere);
            $stmt->bindParam(':nom_comu', $nom_comu);
            $stmt->bindParam(':gra_comu', $gra_comu);
            $stmt->bindParam(':nom_empr', $nom_empr);
            $stmt->bindParam(':gra_empr', $gra_empr);
            $stmt->bindParam(':plan_trab', $plan_trab);
            $stmt->execute();
    
            header("Location: index.php?action=candidatos&mensaje=registrado_exitosamente");
            exit();
        }
    }


    public function editar() {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: index.php?action=candidatos");
            exit();
        }

        $id = $_GET['id'];

        // Obtener el candidatos por ID
        $query = "SELECT * FROM candidatos WHERE id_candidato = :id_candidato";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_candidato', $id);
        $stmt->execute();
        $candidato = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$candidato) {
            header("Location: index.php?action=candidatos");
            exit();
        }

        // Cargar la vista para editar el candidatos
        require_once 'app/views/editar_candidato.php';
    }

    public function actualizar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_candidato'])) {
            $id = $_POST['id_candidato'];
            $nombre = $_POST['nombre'];
            $apellido = $_POST['apellido'];
            $id_partido = $_POST['id_partido'];
            $id_puesto = $_POST['id_puesto'];
            $estado = isset($_POST['estado']) ? intval($_POST['estado']) : 0;
            $nom_teni = $_POST['nom-teni'];
            $gra_teni = $_POST['gra-teni'];
            $nom_salu = $_POST['nom-salu'];
            $gra_salu = $_POST['gra-salu'];
            $nom_educ = $_POST['nom-educ'];
            $gra_educ = $_POST['gra-educ'];
            $nom_dere = $_POST['nom-dere'];
            $gra_dere = $_POST['gra-dere'];
            $nom_comu = $_POST['nom-comu'];
            $gra_comu = $_POST['gra-comu'];
            $nom_empr = $_POST['nom-empr'];
            $gra_empr = $_POST['gra-empr'];
            $plan_trab = $_POST['plan-trab'];
    
            // Verificar si se ha subido un nuevo logo
            $foto_perfil = $_POST['foto_perfil_actual'];  // Mantener la foto actual si no se sube una nueva
            if (isset($_FILES['foto_perfil']) && $_FILES['foto_perfil']['error'] == 0) {
                $nombreImagen = $_FILES['foto_perfil']['name'];
                $rutaDestino = 'public/images/' . $nombreImagen;
                if (move_uploaded_file($_FILES['foto_perfil']['tmp_name'], $rutaDestino)) {
                    $foto_perfil = $nombreImagen;
                }
            }
    
            // Actualizar el candidato en la base de datos
            $query = "UPDATE candidatos SET nombre = :nombre, apellido = :apellido, id_partido = :id_partido, id_puesto = :id_puesto, foto_perfil = :foto_perfil, estado = :estado, nom_teni = :nom_teni, gra_teni = :gra_teni, nom_salu = :nom_salu, gra_salu = :gra_salu, nom_educ = :nom_educ, gra_educ = :gra_educ, nom_dere = :nom_dere, gra_dere = :gra_dere, nom_comu = :nom_comu, gra_comu = :gra_comu, nom_empr = :nom_empr, gra_empr = :gra_empr, plan_trab = :plan_trab WHERE id_candidato = :id_candidato";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':id_partido', $id_partido);
            $stmt->bindParam(':id_puesto', $id_puesto);
            $stmt->bindParam(':foto_perfil', $foto_perfil);
            $stmt->bindParam(':estado', $estado);
            $stmt->bindParam(':nom_teni', $nom_teni);
            $stmt->bindParam(':gra_teni', $gra_teni);
            $stmt->bindParam(':nom_salu', $nom_salu);
            $stmt->bindParam(':gra_salu', $gra_salu);
            $stmt->bindParam(':nom_educ', $nom_educ);
            $stmt->bindParam(':gra_educ', $gra_educ);
            $stmt->bindParam(':nom_dere', $nom_dere);
            $stmt->bindParam(':gra_dere', $gra_dere);
            $stmt->bindParam(':nom_comu', $nom_comu);
            $stmt->bindParam(':gra_comu', $gra_comu);
            $stmt->bindParam(':nom_empr', $nom_empr);
            $stmt->bindParam(':gra_empr', $gra_empr);
            $stmt->bindParam(':plan_trab', $plan_trab);
            $stmt->bindParam(':id_candidato', $id);
            $stmt->execute();
    
            header("Location: index.php?action=candidatos&mensaje=actualizado_exitosamente");
            exit();
        }
    }


    public function eliminar() {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: index.php?action=candidatos");
            exit();
        }

        $id = $_GET['id'];

        try {
            $query = "DELETE FROM candidatos WHERE id_candidato = :id_candidato";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':id_candidato', $id);
            $stmt->execute();

            header("Location: index.php?action=candidatos&mensaje=eliminado_exitosamente");
        } catch (PDOException $e) {
            if ($e->getCode() == '23000') {
                header("Location: index.php?action=candidatos&error=no_se_puede_eliminar");
            } else {
                echo "Error: " . $e->getMessage();
            }
        }
    }
}
