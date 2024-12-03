<?php
include "../../Modelo/ConexionBD.php";
require_once '../../Controlador/validarSesion.php';
validarSesion();

$conexion = new ConexionBD();
$conn = $conexion->conn;

$id=$_GET["id"];

$sql=$conn->query("select * from usuarios where id_usuario=$id");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Modificar</title>
</head>

<body>
<nav class="navbar navbar-expand-lg" style="background-color: #61c9a8;">
    <div class="container-fluid">
        <a href="usuarios.php" class="btn btn-outline-primary">Regresar</a>
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
        <h3 class="text-center text-secondary">Modificar usuarios</h3>
        <input type="hidden" name="id" value="<?= $_GET["id"] ?>">
        <?php
        include "../../Controlador/modificar_usuario.php";
        while($datos=$sql->fetch_object()){?>
            <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" class="form-control" name="nombre" value="<?= $datos->nombre?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Apellido Paterno</label>
            <input type="text" class="form-control" name="apellidoP" value="<?= $datos->apellidoP?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Apellido Materno</label>
            <input type="text" class="form-control" name="apellidoM" value="<?= $datos->apellidoM?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Usuario</label>
            <input type="text" class="form-control" name="usuario" value="<?= $datos->usuario?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" name="correo" value="<?= $datos->correo?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Contraseña</label>
            <input type="password" class="form-control" name="contrasena" value="<?= $datos->contrasena?>">
        </div>
        <div class="mb-3">
            <label class="form-label">Género</label>
            <select class="form-select" name="genero" value="<?= $datos->genero?>">
                <option value="Masculino">Masculino</option>
                <option value="Femenino">Femenino</option>
            </select>
        </div>
        <div class="mb-3">
            <label class="form-label">Tipo de usuario</label>
            <select class="form-select" name="id_rol" value="<?= $datos->id_rol?>">
                <option value="1">Administrador</option>
                <option value="2">Usuario</option>
                <option value="3">Empresa</option>
            </select>
        </div>
        <?php }
        ?>     
        
        <button type="submit" class="btn btn-primary" name="btnmodificar" value="ok">Modificar</button>
    </form>

</body>

</html>