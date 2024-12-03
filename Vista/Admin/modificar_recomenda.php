<?php 
include "../../Modelo/ConexionBD.php";
require_once '../../Controlador/validarSesion.php';
validarSesion();

$conexion = new ConexionBD();
$conn = $conexion->conn;

$id = $_GET["id"];

$sql = $conn->query("SELECT * FROM recomendaciones WHERE id_recomendacion = $id");
$sql_empresas = $conn->query("SELECT id_empresa, nombre_empresa FROM empresas");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Modificar Recomendación</title>
</head>

<body>
<nav class="navbar navbar-expand-lg" style="background-color: #61c9a8;">
    <div class="container-fluid">
        <a href="recomendaciones.php" class="btn btn-outline-primary">Regresar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="pagPrincipal.php">Inicio</a>
                </li>
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
    
<form class="col-4 p-3 m-auto" action="../../Controlador/Recomendaciones/modificar_recomenda.php" method="POST">
    <h3 class="text-center text-secondary">Modificar recomendación</h3>
    <input type="hidden" name="id" value="<?= $id ?>">
    
    <?php
    if ($sql && $sql->num_rows > 0) {
        $datos = $sql->fetch_object();
    ?>
        <div class="mb-3">
            <label class="form-label">Recomendación</label>
            <input type="text" class="form-control" name="descripcion" value="<?= $datos->descripcion ?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Seleccione la empresa</label>
            <select class="form-select" name="id_empresa" required>
                <option value="" disabled>Seleccione una empresa</option>
                <?php while ($empresa = $sql_empresas->fetch_object()): ?>
                    <option value="<?= $empresa->id_empresa ?>" <?= ($empresa->id_empresa == $datos->id_empresa) ? 'selected' : '' ?>>
                        <?= $empresa->nombre_empresa ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <!-- <button type="submit" class="btn btn-primary" name="btnmodificar">Modificar</button> -->
    <?php
    } else {
        echo "<p class='text-center text-danger'>Error: Recomendación no encontrada.</p>";
    }
    ?>     
            <button type="submit" class="btn btn-primary" name="btnmodificar" value="ok">Modificar</button>

</form>

</body>
</html>
