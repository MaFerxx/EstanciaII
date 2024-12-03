<?php
require_once 'ConexionBD.php';

class Recomendaciones {
    private $conn;

    public function __construct() {
        $conexion = new ConexionBD();
        $this->conn = $conexion->conn;

        // Verificar si la conexión es exitosa
        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    // Método para obtener las recomendaciones de la empresa
    public function getRecomendacionesByEmpresa($id_empresa) {
        // Consulta SQL para obtener las recomendaciones de una empresa específica
        $query = "SELECT * FROM recomendaciones WHERE id_empresa = ? ORDER BY id_recomendacion DESC"; 
        
        // Preparar la consulta
        $stmt = $this->conn->prepare($query);
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $this->conn->error);
        }

        // Vincular el parámetro de la empresa
        $stmt->bind_param("i", $id_empresa);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener y devolver los resultados
        $resultado = $stmt->get_result();
        return $resultado->fetch_all(MYSQLI_ASSOC);
    }
}


