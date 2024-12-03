<?php
class Rexplosivos {
    private $conn;

    public function __construct() {
        $this->conn = new ConexionBD();
    }

    public function listaResiduosExplosivos() {
        $conn = $this->conn->conn;

        $sql = "SELECT * FROM residuos WHERE tipo_residuo = 'Explosivo'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return [];
        }
    }
}
?>
