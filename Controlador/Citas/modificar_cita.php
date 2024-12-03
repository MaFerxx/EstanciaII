<?php
session_start();
require_once "../../Modelo/ConexionBD.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conexion = new ConexionBD();
    $conn = $conexion->conn;

    $id = $_POST["id"];
    $fecha = $_POST["fecha"];
    $estado = $_POST["estado"];
    $id_empresa = $_POST["id_empresa"];
    $observaciones = $_POST["observaciones"];

    // Verificar que la fecha no sea en el pasado
    $fecha_actual = date("Y-m-d H:i:s");
    if ($fecha < $fecha_actual) {
        $_SESSION['mensaje_error'] = "La fecha seleccionada no puede ser en el pasado.";
        header("Location: ../../Vista/Admin/citas.php");
        exit();
    }

    // Verificamos si ya existe una cita con la misma fecha y hora para la misma empresa, excluyendo la cita actual
    $sql_check = "SELECT COUNT(*) FROM citas WHERE fecha = ? AND empresas_id_empresa = ? AND id_cita != ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("sii", $fecha, $id_empresa, $id);
    $stmt_check->execute();
    $stmt_check->bind_result($count);
    $stmt_check->fetch();
    $stmt_check->close();

    if ($count > 0) {
        $_SESSION['mensaje_error'] = "Ya existe una cita en esa fecha y hora para esta empresa.";
        header("Location: ../../Vista/Admin/modificar_cita.php?id=" . $id); // Redirige con el id de la cita
        exit();
    } else {
        // Si no hay problema, actualizamos la cita
        $sql = "UPDATE citas SET fecha = ?, estado = ?, empresas_id_empresa = ?, observaciones = ? WHERE id_cita = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ssisi", $fecha, $estado, $id_empresa, $observaciones, $id);

            if ($stmt->execute()) {
                $_SESSION['mensaje_exito'] = "Cita modificada con éxito.";
                header("Location: ../../Vista/Admin/citas.php");
                exit();
            } else {
                $_SESSION['mensaje_error'] = "Error al modificar la cita: " . $stmt->error;
                header("Location: ../../Vista/Admin/modificar_cita.php?id=" . $id); // Redirige con el id de la cita
                exit();
            }
            $stmt->close();
        } else {
            $_SESSION['mensaje_error'] = "Error en la consulta: " . $conn->error;
            header("Location: ../../Vista/Admin/modificar_cita.php?id=" . $id); // Redirige con el id de la cita
            exit();
        }
    }
    $conn->close();
}
?>
