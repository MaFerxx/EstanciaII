<?php

if (isset($_GET['id'])) {
    $id_empresa = $_GET['id']; // Obtiene el ID de la empresa

    include "../../Modelo/ConexionBD.php"; 
    $conexion = new ConexionBD();
    $conn = $conexion->conn;

    // Prepara la consulta para eliminar la empresa
    $sql = $conn->prepare("DELETE FROM empresas WHERE id_empresa = ?");
    $sql->bind_param("i", $id_empresa); // Asigna el ID a la consulta

    if ($sql->execute()) {
        header("Location: ../../Vista/Admin/empresas.php?mensaje=Empresa eliminada"); // Redirecciona si se elimina correctamente
        exit();
    } else {
        echo "Error al eliminar la empresa: " . $conn->error; 
    }
// Cierra la consulta y conexión
    $sql->close(); 
    $conn->close(); 
} else {
    //echo "ID no proporcionado."; 
}
?>
