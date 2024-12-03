<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/EstanciaII_F/Modelo/ReporteEmpresa.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/EstanciaII_F/libreria/dompdf/vendor/autoload.php'; 

use Dompdf\Dompdf;

class ReporteEmpresaController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new ReporteEmpresa(); // Instancia del modelo
    }

    public function obtenerEmpresas() {
        return $this->modelo->obtenerEmpresas();
    }

    // Método para generar el reporte de empresa
    public function generarReporteEmpresa($empresaId)
{
    // Obtener los datos de la empresa
    $empresaInfo = $this->modelo->getEmpresaInfo($empresaId);
    $residuos = $this->modelo->getResiduosEmpresa($empresaId);
    $campanas = $this->modelo->getCampanasEmpresa($empresaId);
    $recomendaciones = $this->modelo->getRecomendacionesEmpresa($empresaId);
    $citas = $this->modelo->getCitasEmpresa($empresaId);
    
    // Obtener el conteo de las citas por estado
    $citasEstado = $this->modelo->getCitasPorEstado($empresaId);

    if ($empresaInfo) {
        generarReporteDompdfEmpresa($empresaInfo, $residuos, $campanas, $recomendaciones, $citas, $citasEstado);
    } else {
        echo "Error: No se encontró información para esta empresa.";
    }
}

}

// Procesar el formulario si se envía por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $empresaId = $_POST['empresa_id'] ?? null;

    if ($empresaId) {
        $controller = new ReporteEmpresaController();
        $controller->generarReporteEmpresa($empresaId);
    } else {
        echo "Error: Debes seleccionar una empresa.";
    }
}

// Función para generar el PDF 
function generarReporteDompdfEmpresa($empresaInfo, $residuos, $campanas, $recomendaciones, $citas, $citasEstado)
{
    $html = "<h1>Reporte de la Empresa: " . htmlspecialchars($empresaInfo['nombre_empresa']) . "</h1>";

    // Información general de la empresa
    $html .= "<h3>Información de la Empresa:</h3>
              <p><strong>Dirección:</strong> " . htmlspecialchars($empresaInfo['direccion_empresa']) . "</p>
              <p><strong>Teléfono:</strong> " . htmlspecialchars($empresaInfo['telefono_empresa']) . "</p>
              <p><strong>Correo:</strong> " . htmlspecialchars($empresaInfo['correo_empresa']) . "</p>
              <p><strong>Ubicación (Latitud, Longitud):</strong> " . htmlspecialchars($empresaInfo['latitud']) . ", " . htmlspecialchars($empresaInfo['altitud']) . "</p>";

    // Residuos que acepta la empresa
    $html .= "<h3>Residuos Aceptados:</h3><ul>";
    foreach ($residuos as $residuo) {
        $html .= "<li>" . htmlspecialchars($residuo['nombre']) . "</li>";
    }
    $html .= "</ul>";
    
    // Campañas de la empresa
    $html .= "<h3>Campañas:</h3><ul>";
    foreach ($campanas as $campana) {
        $html .= "<li><strong>" . htmlspecialchars($campana['nombre_campana']) . ":</strong> " . htmlspecialchars($campana['descripcion']) . " (Del " . $campana['fecha_inicio'] . " al " . $campana['fecha_fin'] . ")</li>";
    }
    $html .= "</ul>";

    // Recomendaciones
    $html .= "<h3>Recomendaciones:</h3><ul>";
    foreach ($recomendaciones as $recomendacion) {
        $html .= "<li>" . htmlspecialchars($recomendacion['descripcion']) . "</li>";
    }
    $html .= "</ul>";

    // Citas por estado
    $html .= "<h3>Estado de las Citas:</h3>
              <p><strong>Citas Pendientes:</strong> " . htmlspecialchars($citasEstado['pendientes']) . "</p>
              <p><strong>Citas Canceladas:</strong> " . htmlspecialchars($citasEstado['canceladas']) . "</p>
              <p><strong>Citas Asistidas:</strong> " . htmlspecialchars($citasEstado['asistidas']) . "</p>";

    // Citas de la empresa
    $html .= "<h3>Citas:</h3><table border='1' style='width:100%; border-collapse:collapse;'>
    <thead><tr><th>ID Cita</th><th>Fecha</th><th>Estado</th><th>Nombre Completo</th><th>Observaciones</th></tr></thead><tbody>";
    foreach ($citas as $cita) {
        $html .= "<tr>
                  <td>" . htmlspecialchars($cita['id_cita']) . "</td>
                  <td>" . htmlspecialchars($cita['fecha']) . "</td>
                  <td>" . htmlspecialchars($cita['estado']) . "</td>
                  <td>" . htmlspecialchars($cita['nombre_completo']) . "</td>
                  <td>" . htmlspecialchars($cita['observaciones']) . "</td>
                </tr>";
    }
    $html .= "</tbody></table>";

    // Generar el PDF
    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    // Descargar el archivo PDF
    $dompdf->stream("Reporte_Empresa_" . htmlspecialchars($empresaInfo['nombre_empresa']) . ".pdf", ["Attachment" => true]);
    exit();
}



?>
