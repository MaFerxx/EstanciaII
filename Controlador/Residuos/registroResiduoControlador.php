<?php
//Este registro es para cuando quiero registrar un residuo desde una empresa
session_start();
require_once '../../Modelo/ConexionBD.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btnregistrar'])) {
//Verifica si existe el 'empresa_id' en la sesión, si no se encuentra, termina la ejecución
    if (!isset($_SESSION['empresa_id'])) {
        die('Error: No se encontró el ID de la empresa en la sesión');
    }
    //Asigna los valores
    $empresa_id = $_SESSION['empresa_id'];
    $nombre = $_POST['nombre'];
    $tipo_residuo = $_POST['tipo_residuo'];
    $descripcion_residuo = $_POST['descripcion_residuo'];

    $conexion = new ConexionBD();
    $conn = $conexion->conn;

    // Preparar la inserción
    $stmt = $conn->prepare("
        INSERT INTO residuos (nombre, tipo_residuo, descripcion_residuo)
        VALUES (?, ?, ?)
    ");
    $stmt->bind_param("sss", $nombre, $tipo_residuo, $descripcion_residuo);
    if ($stmt->execute()) {
        //Obtiene el ID del residuo insertado
        $residuo_id = $stmt->insert_id;

    //Prepara la sentencia SQL para asociar el residuo con la empresa
        $stmt2 = $conn->prepare("
            INSERT INTO empresas_has_residuos (id_empresa, residuos_id_residuo)
            VALUES (?, ?)
        ");
        $stmt2->bind_param("ii", $empresa_id, $residuo_id);
        $stmt2->execute();

        $_SESSION['success_message'] = 'Residuo registrado exitosamente.';
    } else {
        $_SESSION['error_message'] = 'Hubo un error al registrar el residuo.';
    }

    header('Location: ../../Vista/Empresa/residuos.php');
}
