<?php
// Verificamos si se paso el parámetro 'id' en la URL
if (isset($_GET['id'])) {
    $id_residuo = $_GET['id'];

    include "../../Modelo/ConexionBD.php";
    $conexion = new ConexionBD();
    $conn = $conexion->conn;

    //Prepara la consulta SQL
    $sql = $conn->prepare("DELETE FROM residuos WHERE id_residuo = ?");
    $sql->bind_param("i", $id_residuo);

    //Ejecuta la consulta
    if ($sql->execute()) {
        header("Location: ../../Vista/Empresa/residuos.php?mensaje=Residuo eliminado");
        exit();
    } else {
        echo "Error al eliminar el residuo: " . $conn->error;
    }

    $sql->close();
    $conn->close();
} else {
    //echo "ID no proporcionado.";
}
?>
