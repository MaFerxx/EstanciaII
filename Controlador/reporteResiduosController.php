<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/EstanciaII_F/Modelo/reporteResiduos.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/EstanciaII_F/libreria/dompdf/vendor/autoload.php'; 

use Dompdf\Dompdf;

class ReporteResiduosController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new ReporteResiduos(); // Instancia del modelo
    }

    // Método para obtener los residuos agrupados por empresa
    public function obtenerResiduosPorEmpresa()
    {
        return $this->modelo->getResiduosPorEmpresa(); 
    }

    // Método para generar el reporte de residuos por empresa
    public function generarReporteResiduos()
    {
        // Obtener los residuos agrupados por empresa
        $residuosPorEmpresa = $this->obtenerResiduosPorEmpresa();
        
        if (count($residuosPorEmpresa) > 0) {
            // Si existen residuos, generar el reporte PDF
            $this->generarReporteDompdf($residuosPorEmpresa, "Reporte de Residuos por Empresa");
        } else {
            // Si no hay residuos, redirigir a la vista de reportes
            header("Location: ../Vista/Admin/reportes.php");
            exit();
        }
    }

    // Función para generar el PDF
    private function generarReporteDompdf($residuosPorEmpresa, $titulo)
    {
        $html = "<h1>$titulo</h1>";

        // Recorrer cada empresa y generar una tabla con sus residuos
        foreach ($residuosPorEmpresa as $empresa => $residuos) {
            $html .= "<h2>Residuos de la Empresa: $empresa</h2>";

            // Crear una tabla con los residuos de esta empresa
            $html .= "<table border='1' style='width:100%; border-collapse:collapse;' cellpadding='5'>
                        <thead>
                            <tr>
                                <th style='padding: 8px;'>Residuo</th>
                                <th style='padding: 8px;'>Tipo de Residuo</th>
                                <th style='padding: 8px;'>Descripción</th>
                            </tr>
                        </thead>
                        <tbody>";

            // Recorrer cada residuo de esta empresa y agregarlo a la tabla
            foreach ($residuos as $residuo) {
                $html .= "<tr>
                            <td style='padding: 8px;'>" . htmlspecialchars($residuo['nombre']) . "</td>
                            <td style='padding: 8px;'>" . htmlspecialchars($residuo['tipo_residuo']) . "</td>
                            <td style='padding: 8px;'>" . htmlspecialchars($residuo['descripcion_residuo']) . "</td>
                          </tr>";
            }

            $html .= "</tbody></table>";
        }

        // Crear una nueva instancia de Dompdf
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape'); 
        $dompdf->render();

        // Descargar el archivo PDF
        $dompdf->stream("$titulo.pdf", ["Attachment" => true]);

        exit();
    }
}

// Ejecutar la generación del reporte si se recibe una solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Crear una instancia del controlador
    $controller = new ReporteResiduosController();
    
    // Llamar al método para generar el reporte
    $controller->generarReporteResiduos();
}
?>
