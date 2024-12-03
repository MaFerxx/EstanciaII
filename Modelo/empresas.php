<?php
require_once 'ConexionBD.php';

class Empresas {
    private $conexion;

    public function __construct() {
        $this->conexion = new ConexionBD();
    }

    public function obtenerEmpresas() {
        $conn = $this->conexion->conn;
        $sql = "SELECT id_empresa, nombre_empresa, direccion_empresa, telefono_empresa, correo_empresa, latitud, altitud FROM empresas";
        $result = $conn->query($sql);
    
        if ($result->num_rows > 0) {
        // Si existen resultados se devuelven como un array asociativo
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return []; //Si no, se devuleve un array vacío
        }
    }
    
}
?>
