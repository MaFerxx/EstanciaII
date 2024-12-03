<?php
require_once "../../Modelo/ConexionBD.php";

class CampanasController {

    private $conn;

    public function __construct() {
        $conexion = new ConexionBD();
        $this->conn = $conexion->conn;
    }

    public function obtenerEmpresasYCampanas() {
        // Verifica si la sesión tiene el id de la empresa
        if (isset($_SESSION['empresa_id'])) {
            $empresaId = $_SESSION['empresa_id'];

            // Consulta para obtener las campañas solo de la empresa con id_empresa
            $sql = "SELECT c.id_campana, c.nombre_campana, c.fecha_inicio, c.fecha_fin
                    FROM campanas c
                    WHERE c.id_empresa = ?"; // Filtra por id_empresa

            $stmt = $this->conn->prepare($sql); 
            $stmt->bind_param("i", $empresaId);

            $stmt->execute();
            $result = $stmt->get_result();

            // Obtener los resultados (almacena)
            $campanas = [];
            while ($row = $result->fetch_assoc()) {
                $campanas[] = $row;
            }
            return $campanas;

        } else {
            // Si no hay id_empresa en la sesión, entonces es un usuario normal
            $sql = "SELECT e.id_empresa, e.nombre_empresa, c.id_campana, c.nombre_campana, c.fecha_inicio, c.fecha_fin 
                    FROM empresas e
                    LEFT JOIN campanas c ON e.id_empresa = c.id_empresa"; 

            $result = $this->conn->query($sql); 
            $campanas = [];
            while ($row = $result->fetch_assoc()) {
                $campanas[] = $row;
            }
            return $campanas;
        }
    }

    public function getCampañasByEmpresa($id_empresa) {
// Consulta campañas filtradas por empresa y ordenadas por fecha de inicio
        $query = "SELECT * FROM campanas WHERE id_empresa = ? ORDER BY fecha_inicio DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id_empresa);

        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}
?>
