<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/EstanciaII_F/Modelo/reporteCampaña.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/EstanciaII_F/libreria/dompdf/vendor/autoload.php'; 

use Dompdf\Dompdf;

class ReporteCampañaController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new ReporteCampaña(); // Instancia del modelo
    }

    // Método para obtener las campañas activas
    public function obtenerCampanasActivas()
    {
        return $this->modelo->getCampanasActivas(); // Llama al método del modelo que obtiene las campañas activas
    }

    // Método para generar el reporte de campañas activas
    public function generarReporteCampanasActivas()
    {
        // Obtener las campañas activas
        $campanasActivas = $this->obtenerCampanasActivas();
        
        if (count($campanasActivas) > 0) {
            // Si existen campañas activas, generar el reporte PDF
            $this->generarReporteDompdf($campanasActivas, "Reporte de Campañas Activas");
        } else {
            echo "No hay campañas activas.";
            // Rederije a la página de reportes si no hay campañas activas
            header("Location: ../Vista/Admin/reportes");
            exit();
        }
    }

    // Función para generar el PDF con Dompdf
    private function generarReporteDompdf($campanasActivas, $titulo)
    {
        $html = "<h1>$titulo</h1>";
        
        // Agrupar las campañas por empresa
        $campanasPorEmpresa = $this->agruparPorEmpresa($campanasActivas);

        // Recorrer cada empresa y generar una tabla con sus campañas
        foreach ($campanasPorEmpresa as $empresa => $campanas) {
            $html .= "<h2>Campañas de la Empresa: $empresa</h2>";

            // Crear una tabla con las campañas activas de esta empresa
            $html .= "<table border='1' style='width:100%; border-collapse:collapse;' cellpadding='5'>
                        <thead>
                            <tr>
                                <th style='padding: 8px;'>Nombre de la Campaña</th>
                                <th style='padding: 8px;'>Descripción</th>
                                <th style='padding: 8px;'>Fecha de Inicio</th>
                                <th style='padding: 8px;'>Fecha de Fin</th>
                            </tr>
                        </thead>
                        <tbody>";

            // Recorrer cada campaña de esta empresa y agregarla a la tabla
            foreach ($campanas as $campana) {
                $html .= "<tr>
                            <td style='padding: 8px;'>" . htmlspecialchars($campana['nombre_campana']) . "</td>
                            <td style='padding: 8px;'>" . htmlspecialchars($campana['descripcion']) . "</td>
                            <td style='padding: 8px;'>" . htmlspecialchars($campana['fecha_inicio']) . "</td>
                            <td style='padding: 8px;'>" . htmlspecialchars($campana['fecha_fin']) . "</td>
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

    // Función para agrupar las campañas por empresa
    private function agruparPorEmpresa($campanasActivas)
    {
        $campanasPorEmpresa = [];

        // Agrupar las campañas por el nombre de la empresa
        foreach ($campanasActivas as $campana) {
            $empresa = $campana['nombre_empresa'];  
            if (!isset($campanasPorEmpresa[$empresa])) {
                $campanasPorEmpresa[$empresa] = [];
            }
            $campanasPorEmpresa[$empresa][] = $campana;
        }

        return $campanasPorEmpresa;
    }
}

// Procesar el formulario si se envía por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $controller = new ReporteCampañaController();
    $controller->generarReporteCampanasActivas(); 
}
?>
