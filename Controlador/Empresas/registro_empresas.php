<?php
require_once "../../Modelo/ConexionBD.php";

// Verifica si el formulario fue enviado por el método POST y si se presionó el botón 'btnregistrar'
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnregistrar'])) {
    // Verifica que los campos estén llenos
    if (
        !empty($_POST["nombre_empresa"]) &&
        !empty($_POST["contrasena"]) &&
        !empty($_POST["direccion_empresa"]) &&
        !empty($_POST["telefono_empresa"]) &&
        !empty($_POST["correo_empresa"]) &&
        !empty($_POST["altitud"]) &&
        !empty($_POST["latitud"]) 
    ) {
        $conexion = new ConexionBD();
        $conn = $conexion->conn;

        // Obtiene los valores del formulario
        $nombre_empresa = $_POST["nombre_empresa"];
        $contrasena = $_POST["contrasena"];  
        $direccion_empresa = $_POST["direccion_empresa"];
        $telefono_empresa = $_POST["telefono_empresa"];
        $correo_empresa = $_POST["correo_empresa"];
        $altitud = $_POST["altitud"];
        $latitud = $_POST["latitud"];

        // Encripta la contraseña antes de guardarla
        $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);

        // Prepara la consulta SQL para insertar los datos en la base de datos
        $sql = "INSERT INTO empresas (nombre_empresa, contrasena, direccion_empresa, telefono_empresa, correo_empresa, altitud, latitud) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Vincula los parámetros a la consulta
            $stmt->bind_param("sssssss", $nombre_empresa, $contrasena_hash, $direccion_empresa, $telefono_empresa, $correo_empresa, $altitud, $latitud);

            // Ejecuta la consulta y redirige a la página de empresas si la inserción fue exitosa
            if ($stmt->execute()) {
                header("Location: ../../Vista/Admin/empresas.php?success=1");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Error al registrar la empresa: " . $stmt->error . "</div>";
            }
            $stmt->close();
        } else {
            echo "<div class='alert alert-danger'>Error en la consulta: " . $conn->error . "</div>";
        }
        $conn->close();
    } else {
        echo "<div class='alert alert-warning'>Algunos campos están vacíos.</div>";
    }
}
?>
