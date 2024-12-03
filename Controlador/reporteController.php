<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/EstanciaII_F/Modelo/reporteModelo.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/EstanciaII_F/libreria/dompdf/vendor/autoload.php'; 

use Dompdf\Dompdf;

class ReporteController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new ReporteModelo(); // Instancia del modelo
    }

    public function obtenerUsuarios()
    {
        return $this->modelo->getUsuarios(); 
    }


// Método para generar el reporte de historial de usuario
public function generarHistorialReporte($usuarioId)
{
    // Obtener el historial de citas y el resumen de citas
    $resultado = $this->modelo->getHistorialUsuario($usuarioId);
    $resumen = $this->modelo->getResumenCitasUsuario($usuarioId);

    // Obtener el nombre completo del usuario
    $nombreCompleto = $this->modelo->getNombreCompletoUsuario($usuarioId);

    // Si hay datos, generar el reporte
    if (!empty($resultado)) {
        // Pasar los datos, incluyendo el nombre completo
        generarReporteDompdf($resultado, $resumen, "Historial del Usuario $nombreCompleto");
    } else {
        echo "Error: No se encontraron datos para este usuario.";
    }
}

}

// Procesar el formulario si se envía por POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$usuarioId = $_POST['usuario_id'] ?? null;

if ($usuarioId) {
    $controller = new ReporteController();
    $controller->generarHistorialReporte($usuarioId);
} else {
    echo "Error: Debes seleccionar un usuario.";
}
}
// Función para generar el PDF
function generarReporteDompdf($datos, $resumen = null, $titulo)
{
    $html = "<h1>$titulo</h1>";

    // Resumen de citas
    if ($resumen) {
        $html .= "<h3>Resumen de Citas del Usuario:</h3>
                  <p>Citas Pendientes: " . $resumen['pendientes'] . "</p>
                  <p>Citas Canceladas: " . $resumen['canceladas'] . "</p>
                  <p>Citas Asistidas: " . $resumen['asistidas'] . "</p>";
    }

    // Tabla con el historial de citas
    $html .= "<table border='1' style='width:100%; border-collapse:collapse;'>
             <thead><tr>";

    if (!empty($datos)) {
        // Aseguramos que se están obteniendo las claves correctas del array
        foreach (array_keys($datos[0]) as $header) {
            if ($header !== 'nombre_completo') {
                $html .= "<th>" . htmlspecialchars($header) . "</th>";
            }
        }
        $html .= "</tr></thead><tbody>";

        foreach ($datos as $fila) {
            $html .= "<tr>";
            foreach ($fila as $columna => $valor) {
                // Excluimos el nombre completo en los valores de la tabla
                if ($columna !== 'nombre_completo') {
                    $html .= "<td>" . htmlspecialchars($valor) . "</td>";
                }
            }
            $html .= "</tr>";
        }
    } else {
        $html .= "<tr><td colspan='100%'>No se encontraron datos</td></tr>";
    }

    $html .= "</tbody></table>";

    $dompdf = new Dompdf();
    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'portrait');
    $dompdf->render();

    $dompdf->stream("$titulo.pdf", ["Attachment" => true]);
    exit();
}


?>
