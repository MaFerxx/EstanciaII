<?php
require_once __DIR__ . '/ConexionBD.php';

class Citas {
    private $conexion;

    public function __construct() {
        $conexionDB = new ConexionBD();
        $this->conexion = $conexionDB->conn;
    }

    // Obtener citas según el rol (usuario o empresa)
    public function obtenerCitasPorRol($id, $rol) {
        $columna = ($rol === 'usuario') ? 'usuarios_id_usuario' : 'empresas_id_empresa';
        $query = "SELECT c.id_cita, c.fecha, c.estado, c.observaciones, e.nombre_empresa, u.nombre AS nombre_usuario 
                  FROM citas c
                  LEFT JOIN empresas e ON c.empresas_id_empresa = e.id_empresa
                  LEFT JOIN usuarios u ON c.usuarios_id_usuario = u.id_usuario
                  WHERE c.$columna = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result();
    }

    // Cancelar cita (solo si está pendiente)
    public function cancelarCita($idCita, $id, $rol) {
        $columna = ($rol === 'usuario') ? 'usuarios_id_usuario' : 'empresas_id_empresa';
        $query = "UPDATE citas SET estado = 'Cancelada' WHERE id_cita = ? AND $columna = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("ii", $idCita, $id);
        return $stmt->execute();
    }

    // Generar una nueva cita
    public function generarCita($fecha, $estado, $usuario_id, $empresa_id, $observaciones) {
        $query = "INSERT INTO citas (fecha, estado, usuarios_id_usuario, empresas_id_empresa, observaciones) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conexion->prepare($query);
        if ($stmt) {
            $stmt->bind_param("ssiis", $fecha, $estado, $usuario_id, $empresa_id, $observaciones);
            return $stmt->execute();
        }
        return false;
    }
}
?>
