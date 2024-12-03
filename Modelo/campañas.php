<?php

class Campanas {
    private $conn;

    public function __construct() {
        require_once 'ConexionBD.php';
        $conexion = new ConexionBD();
        $this->conn = $conexion->conn;
    }

    // Método para obtener las campañas de la empresa
    public function obtenerCampanasPorEmpresa($empresaId) {
        $sql = "SELECT * FROM campanas WHERE empresas_id_empresa = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $empresaId);
        $stmt->execute();
        $result = $stmt->get_result();
        
        $campanas = [];
        while ($row = $result->fetch_assoc()) {
            $campanas[] = $row;
        }
        return $campanas;
    }
}
?>
