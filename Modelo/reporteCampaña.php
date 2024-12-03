<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/EstanciaII_F/Modelo/ConexionBD.php';

class ReporteCampaña
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new ConexionBD(); 
    }

    // Obtener las campañas activas
    public function getCampanasActivas()
    {
        $sql = "SELECT c.nombre_campana, c.descripcion, c.fecha_inicio, c.fecha_fin, e.nombre_empresa
                FROM campanas c
                LEFT JOIN empresas e ON c.id_empresa = e.id_empresa
                WHERE c.fecha_fin >= CURDATE()";
        
        // Llamamos a consulta sin parámetros
        $result = $this->conexion->consulta($sql);
        return $result;
    }

public function getUsuariosPorCampana($campanaId)
{
    $sql = "SELECT COUNT(DISTINCT ci.usuarios_id_usuario) as usuarios
            FROM citas ci
            INNER JOIN campanas c ON ci.empresas_id_empresa = c.id_empresa
            WHERE c.id_campana = ? AND ci.estado = 'Pendiente'"; 
    
    // Pasamos el parámetro $campanaId
    $parametros = [$campanaId];
    $result = $this->conexion->consulta($sql, $parametros);
    return $result[0]['usuarios'] ?? 0; // Retorna el número de usuarios o 0 si no hay resultados
}

}
?>
