<?php

if (isset($_GET['id'])) {
    $id_recomendacion = $_GET['id']; //Obtenemos el 'id_recomendacion' de la URL

    include "../../Modelo/ConexionBD.php";
    $conexion = new ConexionBD();
    $conn = $conexion->conn;

    //Prepara el script
    $sql = $conn->prepare("DELETE FROM recomendaciones WHERE id_recomendacion = ?");
    $sql->bind_param("i", $id_recomendacion); //Vinculamos el parámetro

    //Se ejecuta
    if ($sql->execute()) {
        header("Location: ../../Vista/Admin/recomendaciones.php?mensaje=Recomendación eliminada");
        exit();
    } else {
        echo "Error al eliminar la recomendación: " . $conn->error;
    }

    $sql->close();
    $conn->close();
} else {
    //echo "ID no proporcionado.";
}
?>
