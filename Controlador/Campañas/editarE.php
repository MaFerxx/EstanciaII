<?php
session_start(); // Inicia la sesión para almacenar mensajes

include "../../Modelo/ConexionBD.php"; // Incluye la conexión

$conexion = new ConexionBD();
$conn = $conexion->conn;

// Mostrar el mensaje de sesión si está disponible
if (isset($_SESSION['mensaje'])) {
    echo "<div class='alert alert-info'>" . $_SESSION['mensaje'] . "</div>";
    unset($_SESSION['mensaje']); // Elimina el mensaje de la sesión después de mostrarlo
}

if (!empty($_POST["btnmodificar"])) {
    if (!empty($_POST["nombre_campana"]) && !empty($_POST["descripcion"]) && !empty($_POST["fecha_inicio"]) && !empty($_POST["fecha_fin"])) {
        $id = $_POST["id"];
        $nombre_campana = $_POST["nombre_campana"];
        $descripcion = $_POST["descripcion"];
        $fecha_inicio = $_POST["fecha_inicio"];
        $fecha_fin = $_POST["fecha_fin"];
        
        // Obtener el id de la empresa desde la sesión
        $id_empresa = $_SESSION['empresa_id']; // El ID de la empresa ya está en la sesión

        // Validación de fechas
        if (strtotime($fecha_inicio) < strtotime(date('Y-m-d'))) {
            $_SESSION['mensaje'] = "La fecha de inicio no puede ser una fecha pasada.";
            header("Location: ../../Vista/Empresa/modificar_campaña.php?id=$id");
            exit;
        }

        if (strtotime($fecha_fin) < strtotime(date('Y-m-d'))) {
            $_SESSION['mensaje'] = "La fecha de fin no puede ser una fecha pasada.";
            header("Location: ../../Vista/Empresa/modificar_campaña.php?id=$id");
            exit;
        }

        if (strtotime($fecha_inicio) > strtotime($fecha_fin)) {
            $_SESSION['mensaje'] = "La fecha de inicio no puede ser posterior a la fecha de fin.";
            header("Location: ../../Vista/Empresa/modificar_campaña.php?id=$id");
            exit;
        }

        // Realizar la actualización en la base de datos
        $sql = $conn->query("UPDATE campanas SET nombre_campana='$nombre_campana', descripcion='$descripcion', fecha_inicio='$fecha_inicio', fecha_fin='$fecha_fin', id_empresa='$id_empresa' WHERE id_campana=$id");

        if ($sql) {
            $_SESSION['mensaje'] = "Campaña modificada exitosamente.";
            header("Location: ../../Vista/Empresa/campañas.php");
            exit();
        } else {
            $_SESSION['mensaje'] = "Error al modificar la campaña.";
            header("Location: ../../Vista/Empresa/modificar_campaña.php?id=$id");
            exit();
        }
    } else {
        $_SESSION['mensaje'] = "Por favor, complete todos los campos.";
        header("Location: ../../Vista/Empresa/modificar_campaña.php?id=$id");
        exit();
    }
}
?>
