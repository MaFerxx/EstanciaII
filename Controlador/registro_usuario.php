<?php
require_once "../Modelo/ConexionBD.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnregistrar'])) {
    if (
        !empty($_POST["nombre"]) &&
        !empty($_POST["apellidoP"]) &&
        !empty($_POST["apellidoM"]) &&
        !empty($_POST["usuario"]) &&
        !empty($_POST["correo"]) &&
        !empty($_POST["contrasena"]) &&
        !empty($_POST["genero"]) &&
        !empty($_POST["id_rol"])
    ) {
        $conexion = new ConexionBD();
        $conn = $conexion->conn;

        $nombre = $_POST["nombre"];
        $apellidoP = $_POST["apellidoP"];
        $apellidoM = $_POST["apellidoM"];
        $usuario = $_POST["usuario"];
        $correo = $_POST["correo"];
        $contrasena = password_hash($_POST["contrasena"], PASSWORD_BCRYPT);
        $genero = $_POST["genero"];
        $id_rol = $_POST["id_rol"];

        // Validación de correo electrónico
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error_message'] = "El correo electrónico no es válido.";
            header("Location: ../Vista/index.php");
            exit();
        }

        // Verificar si el nombre de usuario ya existe
        $sql_check = "SELECT COUNT(*) FROM usuarios WHERE usuario = ?";
        $stmt_check = $conn->prepare($sql_check);
        if ($stmt_check) {
            $stmt_check->bind_param("s", $usuario);
            $stmt_check->execute();
            $stmt_check->bind_result($count);
            $stmt_check->fetch();
            $stmt_check->close();

            if ($count > 0) {
                echo "<div class='alert alert-warning'>El nombre de usuario ya está en uso. Por favor, elige otro.</div>";
            } else {
                // Insertar el nuevo usuario
                $sql = "INSERT INTO usuarios (nombre, apellidoP, apellidoM, usuario, correo, contrasena, genero, id_rol) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                if ($stmt) {
                    $stmt->bind_param("sssssssi", $nombre, $apellidoP, $apellidoM, $usuario, $correo, $contrasena, $genero, $id_rol);
                    if ($stmt->execute()) {
                        header("Location: ../Vista/Admin/usuarios.php?success=1");
                        exit();
                    } else {
                        echo "<div class='alert alert-danger'>Error al registrar usuario: " . $stmt->error . "</div>";
                    }
                    $stmt->close();
                } else {
                    echo "<div class='alert alert-danger'>Error en la consulta: " . $conn->error . "</div>";
                }
            }
        } else {
            echo "<div class='alert alert-danger'>Error en la consulta: " . $conn->error . "</div>";
        }
        $conn->close();
    } else {
        echo "<div class='alert alert-warning'>Algunos campos están vacíos.</div>";
    }
}
?>
