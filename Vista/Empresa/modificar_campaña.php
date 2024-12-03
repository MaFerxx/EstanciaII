<?php 
include "../../Modelo/ConexionBD.php";
require_once '../../Controlador/validarSesion.php';
validarSesion();

$conexion = new ConexionBD();
$conn = $conexion->conn;

$id = $_GET["id"];

// Consulta para obtener los datos de la campaña
$sql = $conn->query("SELECT * FROM campanas WHERE id_campana = $id");

// Consulta para obtener las empresas
$sql_empresas = $conn->query("SELECT id_empresa, nombre_empresa FROM empresas");

if (isset($_SESSION['mensaje'])) {
    echo "<div class='alert alert-info'>{$_SESSION['mensaje']}</div>";
    unset($_SESSION['mensaje']); // Elimina el mensaje para no mostrarlo después
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Modificar Campaña</title>
</head>

<body>
<nav class="navbar navbar-expand-lg" style="background-color: #d7ffc2;">
    <div class="container-fluid">
        <a class="navbar-brand" href="residuos.php">Regresar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="pagPrincipal.php">Inicio</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Perfil</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="../../Controlador/logout.php">Cerrar sesión</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
            </div>
    </div>
</nav>
    
<form class="col-4 p-3 m-auto" action="../../Controlador/Campañas/editarE.php" method="POST">
    <h3 class="text-center text-secondary">Modificar campañas</h3>
    <input type="hidden" name="id" value="<?= $id ?>">

    <?php
    if ($sql && $sql->num_rows > 0) {
        $datos = $sql->fetch_object();
        // Obtener el id_empresa desde la sesión
        $empresa_id_sesion = $_SESSION['empresa_id']; 
    ?>
        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" name="nombre_campana" value="<?= $datos->nombre_campana ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <input type="text" class="form-control" name="descripcion" value="<?= $datos->descripcion ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha de inicio</label>
            <input type="date" class="form-control" name="fecha_inicio" value="<?= $datos->fecha_inicio ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Fecha de fin</label>
            <input type="date" class="form-control" name="fecha_fin" value="<?= $datos->fecha_fin ?>">
        </div>

        <!-- El campo de empresa se oculta ya que se asociará automáticamente con la empresa de la sesión -->
        <input type="hidden" name="id_empresa" value="<?= $empresa_id_sesion ?>">

    <?php
    } else {
        echo "<p class='text-center text-danger'>Error: Campaña no encontrada.</p>";
    }
    ?>     
            <button type="submit" class="btn btn-primary" name="btnmodificar" value="ok">Modificar</button>

</form>

</body>
</html>
