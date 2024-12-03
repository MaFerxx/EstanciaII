<?php

if (!empty($_POST["btnmodificar"])) {
    if (!empty($_POST["nombre"]) && !empty($_POST["apellidoP"]) && !empty($_POST["apellidoM"]) && !empty($_POST["usuario"]) && !empty($_POST["correo"]) && !empty($_POST["contrasena"]) && !empty($_POST["genero"]) && !empty($_POST["id_rol"])) {
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $apellidoP = $_POST["apellidoP"];
        $apellidoM = $_POST["apellidoM"];
        $usuario = $_POST["usuario"];
        $correo = $_POST["correo"];
        $contrasena = $_POST["contrasena"];
        $genero = $_POST["genero"];
        $id_rol = $_POST["id_rol"];

        // Verificar si el nombre de usuario ya existe
        $checkUser = $conn->query("SELECT id_usuario FROM usuarios WHERE usuario = '$usuario' AND id_usuario != $id");
        if ($checkUser->num_rows > 0) {
            echo "<div class='alert alert-danger'>El nombre de usuario ya está en uso.</div>";
        } else {
            // Si el usuario no existe, procedemos con la actualización
            $sql = $conn->query("UPDATE usuarios SET nombre='$nombre', apellidoP='$apellidoP', apellidoM='$apellidoM', usuario='$usuario', correo='$correo', contrasena='$contrasena', genero='$genero', id_rol=$id_rol WHERE id_usuario=$id");
            if ($sql == 1) {
                header("Location: ../../Vista/Admin/usuarios.php");
            } else {
                echo "<div class='alert alert-danger'>Error al modificar</div>";
            }
        }
    } else {
        echo "<div class='alert alert-warning'>Campos vacíos</div>";
    }
}

?>
