<?php
if (!empty($_POST["btnmodificar"])) {
    // Verifica que los campos estén completos
    if (!empty($_POST["nombre_empresa"]) && !empty($_POST["direccion_empresa"]) && !empty($_POST["telefono_empresa"]) && !empty($_POST["correo_empresa"]) && !empty($_POST["altitud"]) && !empty($_POST["latitud"])) {
        
        $id = $_POST["id"]; 
        $nombre_empresa = $_POST["nombre_empresa"];
        $direccion_empresa = $_POST["direccion_empresa"];
        $telefono_empresa = $_POST["telefono_empresa"];
        $correo_empresa = $_POST["correo_empresa"];
        $altitud = $_POST["altitud"];
        $latitud = $_POST["latitud"];

        // Realiza la actualización de la empresa en la base de datos
        $sql = $conn->query("UPDATE empresas SET nombre_empresa='$nombre_empresa', direccion_empresa='$direccion_empresa', telefono_empresa='$telefono_empresa', correo_empresa='$correo_empresa', altitud='$altitud', latitud='$latitud' WHERE id_empresa=$id");

        if ($sql == 1) {
            header("Location: ../../Vista/Admin/empresas.php"); 
        } else {
            echo "<div class='alert alert-danger'>Error al modificar</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Campos vacíos</div>"; 
    }
}
?>
