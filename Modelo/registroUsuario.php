<?php
include 'ConexionBD.php';

$conexion = new ConexionBD();
$conn = $conexion->conn;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $apellidoP = $_POST['apellidoP'];
    $apellidoM = $_POST['apellidoM'] ?? null;  
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);  // Encriptar contraseña
    $genero = $_POST['genero'];
    $id_rol = $_POST['id_rol'];

    // Validar si el nombre de usuario ya existe
    $verificarSql = "SELECT id_usuario FROM usuarios WHERE usuario = ?";
    $stmtVerificar = $conn->prepare($verificarSql);

    if (!$stmtVerificar) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmtVerificar->bind_param("s", $usuario);
    $stmtVerificar->execute();
    $stmtVerificar->store_result();

    if ($stmtVerificar->num_rows > 0) {
        // Mensaje de error en la misma página
        session_start();
        $_SESSION['mensaje'] = "El nombre de usuario ya está en uso. Por favor, elige otro.";
        $stmtVerificar->close();
        $conn->close();
        header("Location: ../Vista/index.php"); // Volver a la página de inicio de sesión
        exit; 
    }

    $stmtVerificar->close();

    // Si el usuario no existe, proceder con el registro
    $sql = "INSERT INTO usuarios (nombre, usuario, contrasena, id_rol, apellidoP, apellidoM, correo, genero)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("sssissss", $nombre, $usuario, $contrasena, $id_rol, $apellidoP, $apellidoM, $correo, $genero);

    if ($stmt->execute()) {
        session_start();
        $_SESSION['mensaje'] = "Usuario registrado exitosamente.";
        header("Location: ../Vista/index.php");  // Volver a la página de inicio de sesión
        exit();
    } else {
        session_start();
        $_SESSION['mensaje'] = "Error al registrar el usuario: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
