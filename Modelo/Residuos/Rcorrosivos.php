<?php
class Rcorrosivos {
    private $conn;

    public function __construct() {
        $this->conn = new ConexionBD();
    }

    public function listaResiduosCorrosivos() {
        $conn = $this->conn->conn;

        $sql = "SELECT * FROM residuos WHERE tipo_residuo = 'Corrosivo'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
}
?>
