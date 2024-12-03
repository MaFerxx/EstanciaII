<?php
session_start();
require_once '../../Modelo/ConexionBD.php'; 

// Verificar que se ha pasado un ID y que es válido
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id_campana = $_GET['id'];
    
    $conexion = new ConexionBD();
    $conn = $conexion->conn;

    // Consulta para eliminar la campaña
    $sql = "DELETE FROM campanas WHERE id_campana = ?";
    $stmt = $conn->prepare($sql);

    // Verificar que la preparación de la sentencia fue exitosa
    if ($stmt) {
        // Vincular el parámetro y ejecutar
        $stmt->bind_param('i', $id_campana);
        
        if ($stmt->execute()) {
            // Si se eliminó correctamente, redirigir con un mensaje de éxito
            $_SESSION['mensaje'] = "La campaña ha sido eliminada exitosamente.";
            header("Location: ../../Vista/Empresa/campañas.php");
        } else {
            // Si hubo un error al ejecutar
            $_SESSION['mensaje'] = "Error al eliminar la campaña.";
            header("Location: ../../Vista/Empresa/campañas.php");
        }
        
        // Cerrar la sentencia
        $stmt->close();
    } else {
        $_SESSION['mensaje'] = "Error al preparar la consulta.";
        header("Location: ../../Vista/Empresa/campañas.php");
    }

    // Cerrar la conexión
    $conn->close();
} else {
    // Si el ID no es válido
    $_SESSION['mensaje'] = "ID de campaña no válido.";
    header("Location: ../../Vista/Empresa/campañas.php");
}
exit();
