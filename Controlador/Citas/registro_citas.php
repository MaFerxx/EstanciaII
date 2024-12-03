<?php
session_start();
require_once "../../Modelo/ConexionBD.php";
require_once "../../Modelo/citas.php";

// Verifica si el usuario o empresa está autenticado
if (!isset($_SESSION['usuario_id']) && !isset($_SESSION['empresa_id'])) {
    echo "<script>alert('Error: Usuario o Empresa no identificado. Por favor, inicie sesión.');</script>";
    exit();
}

// Inicializa el modelo de citas
$citas = new Citas();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $fecha = $_POST['fecha'] ?? null;
    $observaciones = $_POST['observaciones'] ?? '';
    $estado = "Pendiente"; // Estado inicial

    // Validación específica para usuario autenticado
    if (isset($_POST['empresas_id_empresa']) && isset($_SESSION['usuario_id'])) {
        $empresaId = $_POST['empresas_id_empresa'];
        $usuarioId = $_SESSION['usuario_id'];

        if ($fecha && $empresaId) {
            // Verificar que la fecha no sea en el pasado
            $fecha_actual = date("Y-m-d H:i:s");
            if ($fecha < $fecha_actual) {
                $_SESSION['mensaje_error'] = "La fecha seleccionada no puede ser en el pasado.";
            } else {
                // Consultamos si ya existe una cita en esa fecha y hora para la misma empresa
                $conexion = new ConexionBD();
                $conn = $conexion->conn;
                $sql_check = "SELECT COUNT(*) FROM citas WHERE fecha = ? AND empresas_id_empresa = ?";
                $stmt_check = $conn->prepare($sql_check);
                $stmt_check->bind_param("si", $fecha, $empresaId);
                $stmt_check->execute();
                $stmt_check->bind_result($count);
                $stmt_check->fetch();
                $stmt_check->close();

                if ($count > 0) {
                    $_SESSION['mensaje_error'] = "Ya existe una cita en esa fecha y hora para esta empresa.";
                } else {
                    // Si no hay problema, se genera la cita
                    $resultado = $citas->generarCita($fecha, $estado, $usuarioId, $empresaId, $observaciones);

                    if ($resultado) {
                        $_SESSION['mensaje_exito'] = "Cita registrada con éxito.";
                    } else {
                        $_SESSION['mensaje_error'] = "Error al generar la cita.";
                    }
                }
            }
        } else {
            $_SESSION['mensaje_error'] = "Por favor, complete todos los campos.";
        }
    } elseif (isset($_POST['usuario_id']) && isset($_SESSION['empresa_id'])) {
        // Validación para empresa autenticada
        $empresaId = $_SESSION['empresa_id'];
        $usuarioId = $_POST['usuario_id'];

        if ($fecha && $usuarioId) {
            // Verificar que la fecha no sea en el pasado
            $fecha_actual = date("Y-m-d H:i:s");
            if ($fecha < $fecha_actual) {
                $_SESSION['mensaje_error'] = "La fecha seleccionada no puede ser en el pasado.";
            } else {
                // Consultamos si ya existe una cita en esa fecha y hora para la misma empresa
                $conexion = new ConexionBD();
                $conn = $conexion->conn;
                $sql_check = "SELECT COUNT(*) FROM citas WHERE fecha = ? AND empresas_id_empresa = ?";
                $stmt_check = $conn->prepare($sql_check);
                $stmt_check->bind_param("si", $fecha, $empresaId);
                $stmt_check->execute();
                $stmt_check->bind_result($count);
                $stmt_check->fetch();
                $stmt_check->close();

                if ($count > 0) {
                    $_SESSION['mensaje_error'] = "Ya existe una cita en esa fecha y hora para esta empresa.";
                } else {
                    // Si no hay problema, se genera la cita
                    $resultado = $citas->generarCita($fecha, $estado, $usuarioId, $empresaId, $observaciones);

                    if ($resultado) {
                        $_SESSION['mensaje_exito'] = "Cita registrada con éxito.";
                    } else {
                        $_SESSION['mensaje_error'] = "Error al generar la cita.";
                    }
                }
            }
        } else {
            $_SESSION['mensaje_error'] = "Por favor, complete todos los campos.";
        }
    } else {
        $_SESSION['mensaje_error'] = "Acción no reconocida.";
    }

    // Redirige a la página de citas para mostrar el mensaje
    header("Location: ../../Vista/Admin/citas.php");
    exit();
} else {
    $_SESSION['mensaje_error'] = "Método de solicitud no permitido.";
    header("Location: ../../Vista/Admin/citas.php");
    exit();
}
?>
