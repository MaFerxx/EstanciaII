<?php
require_once '../../Modelo/Citas.php';
require_once __DIR__ . '../../validarSesion.php';

// Validar la sesión activa
validarSesion();

$citasModel = new Citas();
$id = isset($_SESSION['usuario_id']) ? $_SESSION['usuario_id'] : $_SESSION['empresa_id'];
$rol = isset($_SESSION['usuario_id']) ? 'usuario' : 'empresa';

// Obtener las citas para el rol actual
$citas = $citasModel->obtenerCitasPorRol($id, $rol);

// Cancelar una cita
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_cita'])) {
    $idCita = $_POST['id_cita'];
    if ($citasModel->cancelarCita($idCita, $id, $rol)) {
        header("Location: ../../Vista/{$rol}/citas.php?success=1");
        exit();
    } else {
        echo "<script>alert('Error al cancelar la cita');</script>";
    }
}
?>
