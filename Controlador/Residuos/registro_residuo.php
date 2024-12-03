<?php
require_once "../../Modelo/ConexionBD.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnregistrar'])) {
    //Verificamos que los campos no estén vacíos
    if (
        !empty($_POST["nombre"]) &&
        !empty($_POST["tipo_residuo"]) &&
        !empty($_POST["descripcion_residuo"]) &&
        !empty($_POST["empresa_id"]) 
    ) {
        $conexion = new ConexionBD();
        $conn = $conexion->conn;
        //Asigna las variables con los datos enviados del formulario
        $nombre = $_POST["nombre"];
        $tipo_residuo = $_POST["tipo_residuo"];
        $descripcion_residuo = $_POST["descripcion_residuo"];
        $empresa_id = $_POST["empresa_id"]; 

        // Iniciar la transacción
        $conn->begin_transaction();

        try {
            // Insertar el residuo en la tabla residuos
            $sql_residuo = "INSERT INTO residuos (nombre, tipo_residuo, descripcion_residuo) 
                            VALUES (?, ?, ?)";
            $stmt_residuo = $conn->prepare($sql_residuo);
            if ($stmt_residuo) {
                $stmt_residuo->bind_param("sss", $nombre, $tipo_residuo, $descripcion_residuo);
                $stmt_residuo->execute();
                // Obtener el ID del residuo recién insertado
                $residuo_id = $stmt_residuo->insert_id;
                $stmt_residuo->close();

                // Insertar la relación en la tabla empresas_has_residuos
                $sql_relacion = "INSERT INTO empresas_has_residuos (id_empresa, residuos_id_residuo) 
                                 VALUES (?, ?)";
                $stmt_relacion = $conn->prepare($sql_relacion);
                if ($stmt_relacion) {
                    $stmt_relacion->bind_param("ii", $empresa_id, $residuo_id); // usa $empresa_id y $residuo_id
                    $stmt_relacion->execute();
                    $stmt_relacion->close();

                    // Si todo fue bien, confirmar la transacción
                    $conn->commit();
                    header("Location: ../../Vista/Admin/residuos.php?success=1");
                    exit();
                } else {
                    throw new Exception("Error al insertar relación en empresas_has_residuos: " . $conn->error);
                }

            } else {
                throw new Exception("Error al insertar residuo: " . $conn->error);
            }
        } catch (Exception $e) {
            // Si hubo un error, hacer rollback y mostrar el mensaje
            $conn->rollback();
            echo "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
        }

        $conn->close();
    } else {
        echo "<div class='alert alert-warning'>Algunos campos están vacíos.</div>";
    }
}
?>
