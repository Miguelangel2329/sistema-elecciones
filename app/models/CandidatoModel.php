<?php
// app/models/CiudadanosModel.php
class CiudadanosModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function verificarCiudadano($cedula) {
        $query = "SELECT * FROM ciudadanos WHERE cedula = :cedula AND estado = 1"; // Estado 1 es activo
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':cedula', $cedula);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

?>
