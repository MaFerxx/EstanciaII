<?php
//Verificamos que el botón fue presionado
if (!empty($_POST["btnmodificar"])) {
    //Verifica que los campos no estén vacíos
    if (!empty($_POST["nombre"]) && !empty($_POST["tipo_residuo"]) && !empty($_POST["descripcion_residuo"]) && !empty($_POST["empresa_id"])) {
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $tipo_residuo = $_POST["tipo_residuo"];
        $descripcion_residuo = $_POST["descripcion_residuo"];
        $empresa_id = $_POST["empresa_id"];

        // Actualizar el residuo
        $sql = $conn->query("UPDATE residuos SET nombre='$nombre', tipo_residuo='$tipo_residuo', descripcion_residuo='$descripcion_residuo' WHERE id_residuo=$id");

        // Actualizar la relación empresa-residuo
        $sql_relacion = $conn->query("UPDATE empresas_has_residuos SET id_empresa='$empresa_id' WHERE residuos_id_residuo=$id");

        if ($sql && $sql_relacion) {
            header("Location: ../../Vista/Admin/residuos.php"); 
            exit();
        } else {
            echo "<div class='alert alert-danger'>Error al modificar</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Campos vacíos</div>";
    }
}

?>
