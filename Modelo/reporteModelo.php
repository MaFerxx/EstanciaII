<?php
require_once 'ConexionBD.php';

class ReporteModelo
{
    private $conn;

    public function __construct() {
        $conexion = new ConexionBD();
        $this->conn = $conexion->conn;

        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    // Obtener el nombre completo de un usuario
public function getNombreCompletoUsuario($usuarioId)
{
    $sql = "SELECT CONCAT(nombre, ' ', apellidoP, ' ', apellidoM) AS nombre_completo FROM usuarios WHERE id_usuario = ?";
    $stmt = $this->conn->prepare($sql);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $this->conn->error);
    }
    $stmt->bind_param('i', $usuarioId);
    $stmt->execute();
    $resultado = $stmt->get_result();
    
    // Retornar solo el nombre completo
    $usuario = $resultado->fetch_assoc();
    return $usuario['nombre_completo'];
}

    // Obtener el historial de citas de un usuario 
    public function getHistorialUsuario($usuarioId)
    {
        $sql = "
            SELECT 
                citas.id_cita, 
                citas.fecha, 
                citas.estado, 
                empresas.nombre_empresa,
                CONCAT(usuarios.nombre, ' ', usuarios.apellidoP, ' ', usuarios.apellidoM) AS nombre_completo
            FROM citas
            JOIN empresas ON citas.empresas_id_empresa = empresas.id_empresa
            JOIN usuarios ON citas.usuarios_id_usuario = usuarios.id_usuario
            WHERE citas.usuarios_id_usuario = ?
        ";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $this->conn->error);
        }
        $stmt->bind_param('i', $usuarioId); // Parametro tipo entero
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        return $resultado->fetch_all(MYSQLI_ASSOC); // Retorna solo los campos requeridos
    }

    // Obtener el resumen de citas 
    public function getResumenCitasUsuario($usuarioId)
    {
        $sql = "SELECT 
                    SUM(CASE WHEN estado = 'Pendiente' THEN 1 ELSE 0 END) AS pendientes,
                    SUM(CASE WHEN estado = 'Cancelada' THEN 1 ELSE 0 END) AS canceladas,
                    SUM(CASE WHEN estado = 'Asistida' THEN 1 ELSE 0 END) AS asistidas
                FROM citas
                WHERE usuarios_id_usuario = ?";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $this->conn->error);
        }
        $stmt->bind_param('i', $usuarioId); 
        $stmt->execute();
        $resultado = $stmt->get_result();
        
        return $resultado->fetch_assoc(); // Devuelve el resumen de citas
    }

    public function getCitasPorEstado($empresaId)
{
    // Consulta para contar las citas pendientes
    $sqlPendientes = "
        SELECT COUNT(*) as totalPendientes
        FROM citas c
        WHERE c.empresas_id_empresa = ? AND c.estado = 'Pendiente'
    ";

    // Consulta para contar las citas canceladas
    $sqlCanceladas = "
        SELECT COUNT(*) as totalCanceladas
        FROM citas c
        WHERE c.empresas_id_empresa = ? AND c.estado = 'Cancelada'
    ";

    // Consulta para contar las citas asistidas
    $sqlAsistidas = "
        SELECT COUNT(*) as totalAsistidas
        FROM citas c
        WHERE c.empresas_id_empresa = ? AND c.estado = 'Asistida'
    ";

    // Ejecutar las consultas
    $stmtPendientes = $this->conn->prepare($sqlPendientes);
    $stmtCanceladas = $this->conn->prepare($sqlCanceladas);
    $stmtAsistidas = $this->conn->prepare($sqlAsistidas);

    if (!$stmtPendientes || !$stmtCanceladas || !$stmtAsistidas) {
        die("Error en la preparación de la consulta: " . $this->conn->error);
    }

    $stmtPendientes->bind_param('i', $empresaId);
    $stmtCanceladas->bind_param('i', $empresaId);
    $stmtAsistidas->bind_param('i', $empresaId);

    $stmtPendientes->execute();
    $stmtCanceladas->execute();
    $stmtAsistidas->execute();

    // Obtener los resultados
    $resultPendientes = $stmtPendientes->get_result()->fetch_assoc();
    $resultCanceladas = $stmtCanceladas->get_result()->fetch_assoc();
    $resultAsistidas = $stmtAsistidas->get_result()->fetch_assoc();

    return [
        'pendientes' => $resultPendientes['totalPendientes'],
        'canceladas' => $resultCanceladas['totalCanceladas'],
        'asistidas' => $resultAsistidas['totalAsistidas']
    ];
}


        // Obtener todos los usuarios
        public function getUsuarios()
        {
            $sql = "SELECT * FROM usuarios";
            $resultado = $this->conn->query($sql);
            return $resultado->fetch_all(MYSQLI_ASSOC);
        }

        

    // Cerrar la conexión
    public function cerrarConexion()
    {
        $this->conn->close();
    }
}
?>
