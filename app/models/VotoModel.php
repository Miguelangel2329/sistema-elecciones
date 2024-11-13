<?php
// app/models/VotoModel.php
class VotoModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function yaVoto($ciudadano_id, $id_candidato) {
        $query = "SELECT * FROM elecciones_cont WHERE ciudadano_id = :ciudadano_id AND candidato_id = :id_candidato";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ciudadano_id', $ciudadano_id);
        $stmt->bindParam(':id_candidato', $id_candidato);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC) ? true : false;
    }

    public function registrarVoto($ciudadano_id, $id_candidato) {
        $query = "INSERT INTO elecciones_cont (ciudadano_id, candidato_id) VALUES (:ciudadano_id, :id_candidato)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':ciudadano_id', $ciudadano_id);
        $stmt->bindParam(':id_candidato', $id_candidato);
        $stmt->execute();
    }
}
?>
