<?php
require_once "ConexionBD.php";

class ResiduoModelo {
    
    // Función para registrar un residuo
    public function registrarResiduo($nombre, $tipo_residuo, $descripcion_residuo, $empresa_id) {
        $conexion = new ConexionBD();
        $conn = $conexion->conn;

        // Insertar el residuo en la tabla residuos
        $sql = "INSERT INTO residuos (nombre, tipo_residuo, descripcion_residuo) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $nombre, $tipo_residuo, $descripcion_residuo);
        
        if ($stmt->execute()) {
            $residuo_id = $conn->insert_id;

            // Registrar la relación empresa-residuo
            $sql_rel = "INSERT INTO empresas_has_residuos (residuos_id_residuo, id_empresa) VALUES (?, ?)";
            $stmt_rel = $conn->prepare($sql_rel);
            $stmt_rel->bind_param("ii", $residuo_id, $empresa_id);
            $stmt_rel->execute();

            return true;
        } else {
            return false;
        }
    }

    // Función para verificar si la empresa está asociada al usuario logueado
    public function verificarEmpresa($empresa_id, $usuario_id) {
        $conexion = new ConexionBD();
        $conn = $conexion->conn;

        $empresa_check = "SELECT id_empresa FROM empresas WHERE id_empresa = ? AND id_usuario = ?";
        $stmt_check = $conn->prepare($empresa_check);
        $stmt_check->bind_param("ii", $empresa_id, $usuario_id);
        $stmt_check->execute();
        $stmt_check->store_result();

        return $stmt_check->num_rows > 0;
    }
}
?>
