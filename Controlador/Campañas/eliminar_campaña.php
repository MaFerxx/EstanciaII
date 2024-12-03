<?php

// Verifica si se ha proporcionado un ID a través de la URL mediante el método GET
if (isset($_GET['id'])) {
    $id_campana = $_GET['id'];

    // Incluye el archivo de conexión a la base de datos
    include "../../Modelo/ConexionBD.php";
    
    // Crea una nueva instancia de la clase de conexión y obtiene la conexión
    $conexion = new ConexionBD();
    $conn = $conexion->conn;

    // Prepara la consulta SQL para eliminar una campaña con el ID especificado
    $sql = $conn->prepare("DELETE FROM campanas WHERE id_campana = ?");
    $sql->bind_param("i", $id_campana); 

    // Ejecuta la consulta y verifica si se eliminó correctamente
    if ($sql->execute()) {
        // Redirige al usuario a la página 
        header("Location: ../../Vista/Admin/campañas.php?mensaje=Campaña eliminada");
        exit(); 
        echo "Error al eliminar la campaña: " . $conn->error;
    }

    // Cierra la consulta y la conexión a la base de datos
    $sql->close();
    $conn->close();
} else {
    //echo "ID no proporcionado.";
}

?>
