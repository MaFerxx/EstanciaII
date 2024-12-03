<?php
require_once 'ConexionBD.php';

class ReporteEmpresa
{
    private $conn;

    public function __construct() {
        $conexion = new ConexionBD();
        $this->conn = $conexion->conn;

        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
    }

    public function obtenerEmpresas() {
        $query = "SELECT id_empresa, nombre_empresa FROM empresas";
        $result = $this->conn->query($query);
        
        $empresas = [];
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $empresas[] = $row;
            }
        }
        return $empresas;
    }

    // Obtener la información de la empresa
    public function getEmpresaInfo($empresaId)
    {
        $sql = "
            SELECT 
                id_empresa, 
                nombre_empresa, 
                direccion_empresa, 
                telefono_empresa, 
                correo_empresa, 
                latitud, 
                altitud
            FROM empresas
            WHERE id_empresa = ?
        ";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $this->conn->error);
        }
        $stmt->bind_param('i', $empresaId);
        $stmt->execute();
        $resultado = $stmt->get_result();

        return $resultado->fetch_assoc();
    }

    // Obtener los residuos que acepta la empresa
    public function getResiduosEmpresa($empresaId)
{
    $sql = "
        SELECT r.nombre 
        FROM empresas_has_residuos er
        INNER JOIN residuos r ON er.residuos_id_residuo = r.id_residuo
        WHERE er.id_empresa = ?
    ";
    $stmt = $this->conn->prepare($sql);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $this->conn->error);
    }
    $stmt->bind_param('i', $empresaId);
    $stmt->execute();
    $resultado = $stmt->get_result();

    return $resultado->fetch_all(MYSQLI_ASSOC);
}

    

    // Obtener las campañas de la empresa
    public function getCampanasEmpresa($empresaId)
    {
        $sql = "
            SELECT nombre_campana, descripcion, fecha_inicio, fecha_fin
            FROM campanas
            WHERE id_empresa = ?
        ";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $this->conn->error);
        }
        $stmt->bind_param('i', $empresaId);
        $stmt->execute();
        $resultado = $stmt->get_result();

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    // Obtener las recomendaciones de la empresa
    public function getRecomendacionesEmpresa($empresaId)
    {
        $sql = "
            SELECT descripcion
            FROM recomendaciones
            WHERE id_empresa = ?
        ";
        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $this->conn->error);
        }
        $stmt->bind_param('i', $empresaId);
        $stmt->execute();
        $resultado = $stmt->get_result();

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    // Obtener las citas de la empresa
    public function getCitasEmpresa($empresaId)
{
    $sql = "
        SELECT 
            c.id_cita, 
            c.fecha, 
            c.estado, 
            CONCAT(u.nombre, ' ', u.apellidoP, ' ', u.apellidoM) AS nombre_completo,
            c.observaciones
        FROM 
            citas c
        JOIN 
            usuarios u ON c.usuarios_id_usuario = u.id_usuario
        WHERE 
            c.empresas_id_empresa = ?
    ";
    
    $stmt = $this->conn->prepare($sql);
    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $this->conn->error);
    }
    $stmt->bind_param('i', $empresaId);
    $stmt->execute();
    $resultado = $stmt->get_result();

    return $resultado->fetch_all(MYSQLI_ASSOC);
}

public function getCitasPorEstado($empresaId)
{
    // Consultas para contar las citas
    $sqlPendientes = "
        SELECT COUNT(*) as totalPendientes
        FROM citas c
        WHERE c.empresas_id_empresa = ? AND c.estado = 'Pendiente'
    ";

    $sqlCanceladas = "
        SELECT COUNT(*) as totalCanceladas
        FROM citas c
        WHERE c.empresas_id_empresa = ? AND c.estado = 'Cancelada'
    ";

    $sqlAsistidas = "
        SELECT COUNT(*) as totalAsistidas
        FROM citas c
        WHERE c.empresas_id_empresa = ? AND c.estado = 'Asistida'
    ";

    // Preparar las consultas
    $stmtPendientes = $this->conn->prepare($sqlPendientes);
    $stmtCanceladas = $this->conn->prepare($sqlCanceladas);
    $stmtAsistidas = $this->conn->prepare($sqlAsistidas);

    if (!$stmtPendientes || !$stmtCanceladas || !$stmtAsistidas) {
        die("Error en la preparación de la consulta: " . $this->conn->error);
    }

    // Enlazar los parámetros
    $stmtPendientes->bind_param('i', $empresaId);
    $stmtCanceladas->bind_param('i', $empresaId);
    $stmtAsistidas->bind_param('i', $empresaId);

    // Ejecutar la consulta de citas pendientes
    $stmtPendientes->execute();
    if ($stmtPendientes->errno) {
        die("Error al ejecutar la consulta Pendientes: " . $stmtPendientes->error);
    }

    // Obtener los resultados
    $resultPendientes = $stmtPendientes->get_result();
    if (!$resultPendientes) {
        die("Error al obtener los resultados de las citas Pendientes.");
    }

    // Ejecutar la consulta de citas canceladas
    $stmtCanceladas->execute();
    if ($stmtCanceladas->errno) {
        die("Error al ejecutar la consulta Canceladas: " . $stmtCanceladas->error);
    }

    // Obtener los resultados
    $resultCanceladas = $stmtCanceladas->get_result();
    if (!$resultCanceladas) {
        die("Error al obtener los resultados de las citas Canceladas.");
    }

    // Ejecutar la consulta de citas asistidas
    $stmtAsistidas->execute();
    if ($stmtAsistidas->errno) {
        die("Error al ejecutar la consulta Asistidas: " . $stmtAsistidas->error);
    }

    // Obtener los resultados
    $resultAsistidas = $stmtAsistidas->get_result();
    if (!$resultAsistidas) {
        die("Error al obtener los resultados de las citas Asistidas.");
    }

    // Obtener los valores de las consultas
    $resultPendientes = $resultPendientes->fetch_assoc();
    $resultCanceladas = $resultCanceladas->fetch_assoc();
    $resultAsistidas = $resultAsistidas->fetch_assoc();

    return [
        'pendientes' => $resultPendientes['totalPendientes'],
        'canceladas' => $resultCanceladas['totalCanceladas'],
        'asistidas' => $resultAsistidas['totalAsistidas']
    ];
}



    public function cerrarConexion()
    {
        $this->conn->close();
    }
}
?>
