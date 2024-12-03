<?php 
include "../../Modelo/ConexionBD.php";
require_once '../../Controlador/validarSesion.php';
validarSesion();

$conexion = new ConexionBD();
$conn = $conexion->conn;

$sql_empresas = $conn->query("SELECT id_empresa, nombre_empresa FROM empresas");


$id = $_GET["id"];

$sql = $conn->query("
    SELECT r.*, erh.id_empresa 
    FROM residuos r
    JOIN empresas_has_residuos erh ON r.id_residuo = erh.residuos_id_residuo
    WHERE r.id_residuo = $id
");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Modificar Residuo</title>
</head>

<body>
<nav class="navbar navbar-expand-lg" style="background-color: #61c9a8;">
    <div class="container-fluid">
        <a href="residuos.php" class="btn btn-outline-primary">Regresar</a>
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
    <form class="col-4 p-3 m-auto" method="POST">
        <h3 class="text-center text-secondary">Modificar residuos peligrosos</h3>
        <input type="hidden" name="id" value="<?= $_GET["id"] ?>">
        <?php
        include "../../Controlador/Residuos/modificar_residuo.php";
                if ($sql && $sql->num_rows > 0) {
            while ($datos = $sql->fetch_object()) {
        ?>
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="<?= $datos->nombre ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Tipo de residuo</label>
                <select class="form-select" name="tipo_residuo">
                <option value="Corrosivo" <?= $datos->tipo_residuo == 'Corrosivo' ? 'selected' : '' ?>>Corrosivo</option>
                <option value="Reactivo" <?= $datos->tipo_residuo == 'Reactivo' ? 'selected' : '' ?>>Reactivo</option>
                <option value="Explosivo" <?= $datos->tipo_residuo == 'Explosivo' ? 'selected' : '' ?>>Explosivo</option>
                <option value="Tóxico" <?= $datos->tipo_residuo == 'Tóxico' ? 'selected' : '' ?>>Tóxico</option>
                <option value="Inflamable" <?= $datos->tipo_residuo == 'Inflamable' ? 'selected' : '' ?>>Inflamable</option>
                <option value="Infeccioso o Patógeno" <?= $datos->tipo_residuo == 'Infeccioso o Patógeno' ? 'selected' : '' ?>>Infeccioso o Patógeno</option>
                <option value="Radiactivo" <?= $datos->tipo_residuo == 'Radiactivo' ? 'selected' : '' ?>>Radiactivo</option>
            </select>
            </div>
            <div class="mb-3">
    <label class="form-label">Seleccione la empresa</label>
    <select class="form-select" name="empresa_id" required>
        <option value="" disabled>Seleccione una empresa</option>
        <?php while ($empresa = $sql_empresas->fetch_object()): ?>
            <option value="<?= $empresa->id_empresa ?>" <?= $datos->id_empresa == $empresa->id_empresa ? 'selected' : '' ?>>
                <?= $empresa->nombre_empresa ?>
            </option>
        <?php endwhile; ?>
    </select>
</div>

            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <input type="text" class="form-control" name="descripcion_residuo" value="<?= $datos->descripcion_residuo ?>">
            </div>
        <?php
            }
        } else {
            echo "<p class='text-center text-danger'>Error: Residuo no encontrado.</p>";
        }
        ?>     
        
        <button type="submit" class="btn btn-primary" name="btnmodificar" value="ok">Modificar</button>
    </form>
</body>
</html>
