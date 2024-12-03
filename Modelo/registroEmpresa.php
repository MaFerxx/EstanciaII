<?php
include 'ConexionBD.php';

$conexion = new ConexionBD();
$conn = $conexion->conn;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre_empresa = $_POST['nombre_empresa'];
    $contrasena = $_POST['contrasena'];
    $direccion_empresa = $_POST['direccion_empresa'];
    $telefono_empresa = $_POST['telefono_empresa'];
    $correo_empresa = $_POST['correo_empresa'];
    $altitud = $_POST['altitud'];
    $latitud = $_POST['latitud'];

    // Encriptar la contraseña
    $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);

    $sql = "INSERT INTO empresas (nombre_empresa, contrasena, direccion_empresa, telefono_empresa, correo_empresa, altitud, latitud)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    // Cambiar el segundo parámetro por $contrasenaHash
    $stmt->bind_param("sssssss", $nombre_empresa, $contrasenaHash, $direccion_empresa, $telefono_empresa, $correo_empresa, $altitud, $latitud);

    if ($stmt->execute()) {
        session_start();
        $_SESSION['mensaje'] = "Empresa registrada exitosamente.";
        header("Location: ../Vista/index.php");  // Volver a la página de inicio de sesión
        exit();
    } else {
        session_start();
        $_SESSION['mensaje'] = "Error al registrar la empresa: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
