<?php

if (isset($_GET['id'])) {
    $id_usuario = $_GET['id'];

    include "../Modelo/ConexionBD.php";
    $conexion = new ConexionBD();
    $conn = $conexion->conn;

    $sql = $conn->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
    $sql->bind_param("i", $id_usuario);

    if ($sql->execute()) {
        header("Location: ../Vista/Admin/usuarios.php?mensaje=Usuario eliminado");
        exit();
    } else {
        echo "Error al eliminar el usuario: " . $conn->error;
    }

    $sql->close();
    $conn->close();
} else {
    //echo "ID no proporcionado.";
}
?>
