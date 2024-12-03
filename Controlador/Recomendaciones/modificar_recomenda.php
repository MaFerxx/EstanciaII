<?php
include "../../Modelo/ConexionBD.php"; 

$conexion = new ConexionBD();
$conn = $conexion->conn; 

if (!empty($_POST["btnmodificar"])) {
    //Verifica que los campos estén llenos
    if (!empty($_POST["descripcion"]) && !empty($_POST["id_empresa"])) {
        //Ibtiene los valores
        $id = $_POST["id"];
        $descripcion = $_POST["descripcion"];
        $id_empresa = $_POST["id_empresa"];

        //Realiza la actualización
        $sql = $conn->query("UPDATE recomendaciones SET descripcion='$descripcion', id_empresa='$id_empresa' WHERE id_recomendacion=$id");

        //Hace la verificación
        if ($sql) {
            header("Location: ../../Vista/Admin/recomendaciones.php"); 
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error al modificar</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Campos vacíos</div>";
    }
}
?>
