<?php 
include "../../Modelo/ConexionBD.php";
require_once '../../Controlador/validarSesion.php';
validarSesion();

$conexion = new ConexionBD();
$conn = $conexion->conn;

$id = $_GET["id"];

$sql = $conn->query("SELECT * FROM empresas WHERE id_empresa = $id");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Modificar empresa</title>
</head>

<body>
<nav class="navbar navbar-expand-lg" style="background-color: #61c9a8;">
    <div class="container-fluid">
        <a href="empresas.php" class="btn btn-outline-primary">Regresar</a>
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
        <h3 class="text-center text-secondary">Modificar empresa</h3>
        <input type="hidden" name="id" value="<?= $_GET["id"] ?>">
        <?php
        include "../../Controlador/Empresas/modificar_empresa.php";
                if ($sql && $sql->num_rows > 0) {
            while ($datos = $sql->fetch_object()) {
        ?>
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre_empresa" value="<?= $datos->nombre_empresa ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Dirección</label>
                <input type="text" class="form-control" name="direccion_empresa" value="<?= $datos->direccion_empresa ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" class="form-control" name="telefono_empresa" value="<?= $datos->telefono_empresa ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Correo</label>
                <input type="text" class="form-control" name="correo_empresa" value="<?= $datos->correo_empresa ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Altitud</label>
                <input type="text" class="form-control" name="altitud" value="<?= $datos->altitud ?>">
            </div>
            <div class="mb-3">
                <label class="form-label">Latitud</label>
                <input type="text" class="form-control" name="latitud" value="<?= $datos->latitud ?>">
            </div>
        <?php
            }
        } else {
            echo "<p class='text-center text-danger'>Error: Empresa no encontrada.</p>";
        }
        ?>     
        
        <button type="submit" class="btn btn-primary" name="btnmodificar" value="ok">Modificar</button>
    </form>
</body>
</html>
