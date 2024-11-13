<?php
// app/models/EleccionesModel.php
class EleccionesModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function verificarEleccionActiva() {
        $query = "SELECT * FROM elecciones WHERE estado = 1";  // Estado 1 es activo
        $stmt = $this->db->prepare($query);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }
}
?>