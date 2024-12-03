<?php
require_once '../../Modelo/ConexionBD.php';

class Citas {
    private $conn;

    public function __construct() {
        $conexion = new ConexionBD();
        $this->conn = $conexion->conn;
    }

    // Método para obtener las citas de una empresa
    public function getCitasByEmpresa($id_empresa) {
        $query = "SELECT * FROM citas WHERE empresas_id_empresa = ? ORDER BY fecha DESC";

        // Preparar la consulta
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_empresa); // Vinculamos

        $stmt->execute();
        
        // Obtener y devolver los resultados
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}
