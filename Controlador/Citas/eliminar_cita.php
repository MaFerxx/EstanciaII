<?php
require_once "../../Modelo/ConexionBD.php";

if (isset($_GET['id'])) {
    $id = $_GET['id']; // Obtiene el ID de la cita
    $conexion = new ConexionBD();
    $conn = $conexion->conn;

    // Prepara la consulta para eliminar la cita
    $sql = "DELETE FROM citas WHERE id_cita = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("i", $id); // Asigna el ID a la consulta

        if ($stmt->execute()) {
            header("Location: ../../Vista/Admin/citas.php?success=1");
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error al eliminar la cita: " . $stmt->error . "</div>";
        }
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Error en la consulta: " . $conn->error . "</div>";
    }
    $conn->close();
} else {
    echo "<div class='alert alert-warning'>ID de cita no proporcionado.</div>";
}
?>
