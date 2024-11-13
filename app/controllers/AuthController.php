<?php
require_once 'config/database.php';

class AuthController {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function login() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $usuario = $_POST['usuario'];
            $clave = $_POST['clave'];

            // Cambiar a la tabla correcta
            $query = "SELECT * FROM administracion WHERE usuario = :usuario AND clave = :clave";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->bindParam(':clave', $clave);

            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                session_start();
                $_SESSION['id_usuario'] = $user['id_usuario'];
                header("Location: index.php?action=dashboard");
                exit();
            } else {
                $error = "Credenciales incorrectas";
                require_once 'app/views/login.php';
            }
        } else {
            require_once 'app/views/login.php';
        }
    }

    public function logout() {
        session_start();
        session_destroy();
        header("Location: index.php?action=login");
        exit();
    }
}
