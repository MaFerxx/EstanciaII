<?php
require_once "../../Modelo/ConexionBD.php";

// Verifica que el formulario fue enviado y la solicitud POST
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnregistrar'])) {
    if (
        !empty($_POST["descripcion"]) &&
        !empty($_POST["id_empresa"]) 
    ) {
        $conexion = new ConexionBD();
        $conn = $conexion->conn;

        //Obtiene los valores
        $descripcion = $_POST["descripcion"];
        $id_empresa = $_POST["id_empresa"]; 

        //Prepara la consulta SQL
        $sql = "INSERT INTO recomendaciones (descripcion, id_empresa) 
                VALUES (?, ?)";
        $stmt = $conn->prepare($sql);

        //Verifica si la preparación de la consulta fue exitosa
        if ($stmt) {
            $stmt->bind_param("ss", $descripcion, $id_empresa);

            if ($stmt->execute()) {
                header("Location: ../../Vista/Admin/recomendaciones.php?success=1");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Error al registrar la recomendación: " . $stmt->error . "</div>";
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
