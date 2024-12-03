<?php
session_start();
require_once "../../Modelo/ConexionBD.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnregistrar'])) {
    // Verificar que todos los campos estén completos
    if (
        !empty($_POST["nombre_campana"]) &&
        !empty($_POST["descripcion"]) &&
        !empty($_POST["fecha_inicio"]) &&
        !empty($_POST["fecha_fin"]) &&
        !empty($_POST["id_empresa"])
    ) {
        // Obtener los datos del formulario
        $nombre_campana = $_POST["nombre_campana"];
        $descripcion = $_POST["descripcion"];
        $fecha_inicio = $_POST["fecha_inicio"];
        $fecha_fin = $_POST["fecha_fin"];
        $id_empresa = $_POST["id_empresa"]; 

        // Validación de fechas
        if (strtotime($fecha_inicio) < strtotime(date('Y-m-d'))) {
            $_SESSION['error'] = "La fecha de inicio no puede ser una fecha pasada.";
            header("Location: ../../Vista/Admin/campañas.php");
            exit();
        }

        if (strtotime($fecha_fin) < strtotime(date('Y-m-d'))) {
            $_SESSION['error'] = "La fecha de fin no puede ser una fecha pasada.";
            header("Location: ../../Vista/Admin/campañas.php");
            exit();
        }

        if (strtotime($fecha_inicio) > strtotime($fecha_fin)) {
            $_SESSION['error'] = "La fecha de inicio no puede ser posterior a la fecha de fin.";
            header("Location: ../../Vista/Admin/campañas.php");
            exit();
        }

        // Establecer conexión con la base de datos
        $conexion = new ConexionBD();
        $conn = $conexion->conn;

        // Preparar la consulta SQL
        $sql = "INSERT INTO campanas (nombre_campana, descripcion, fecha_inicio, fecha_fin, id_empresa) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Enlazar los parámetros
            $stmt->bind_param("ssssi", $nombre_campana, $descripcion, $fecha_inicio, $fecha_fin, $id_empresa);

            // Ejecutar la consulta
            if ($stmt->execute()) {
                header("Location: ../../Vista/Admin/campañas.php?success=1");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Error al registrar la campaña: " . $stmt->error . "</div>";
            }
            $stmt->close();
        } else {
            echo "<div class='alert alert-danger'>Error en la consulta: " . $conn->error . "</div>";
        }
        $conn->close();
    } else {
        echo "<div class='alert alert-warning'>Algunos campos están vacíos. Por favor, completa todos los campos.</div>";
    }
}
?>
