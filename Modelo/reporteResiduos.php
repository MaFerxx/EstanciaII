<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/EstanciaII_F/Modelo/ConexionBD.php';

class ReporteResiduos
{
    private $conexion;

    public function __construct()
    {
        $this->conexion = new ConexionBD(); 
    }

    // Obtener los residuos agrupados por empresa
    public function getResiduosPorEmpresa()
    {
        $sql = "SELECT r.nombre, r.tipo_residuo, r.descripcion_residuo, e.nombre_empresa
                FROM residuos r
                LEFT JOIN empresas_has_residuos erh ON r.id_residuo = erh.residuos_id_residuo
                LEFT JOIN empresas e ON erh.id_empresa = e.id_empresa
                ORDER BY e.nombre_empresa, r.nombre";
        
        // Llamamos a consulta sin parámetros
        $result = $this->conexion->consulta($sql);
        $residuosPorEmpresa = [];

        // Agrupar los residuos por empresa
        foreach ($result as $row) {
            $empresa = $row['nombre_empresa'];
            if (!isset($residuosPorEmpresa[$empresa])) {
                $residuosPorEmpresa[$empresa] = [];
            }
            $residuosPorEmpresa[$empresa][] = $row;
        }

        return $residuosPorEmpresa;
    }
}
?>
