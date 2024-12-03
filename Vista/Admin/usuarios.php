<?php
require_once "../../Modelo/ConexionBD.php"; 
require_once '../../Controlador/validarSesion.php';
validarSesion();

$conexion = new ConexionBD();
$conn = $conexion->conn;

if (!$conn) {
    die("Error en la conexión: " . $conn->connect_error);
}

$sql = $conn->query("SELECT * FROM usuarios");

if (!$sql) {
    die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-expand-lg" style="background-color: #61c9a8;">
    <div class="container-fluid">
        <a href="pagPrincipal.php" class="btn btn-outline-primary">Regresar</a>
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

<h1 class="text-center p-3">Gestión de usuarios</h1>

<div class="container-fluid">
    <div class="row">
        <!-- Formulario de Registro -->
        <form class="col-lg-4 col-md-6 col-sm-12 p-3" action="../../Controlador/registro_usuario.php" method="POST">
            <h3 class="text-center text-secondary">Registro de usuarios</h3>
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Apellido Paterno</label>
                <input type="text" class="form-control" name="apellidoP" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Apellido Materno</label>
                <input type="text" class="form-control" name="apellidoM">
            </div>
            <div class="mb-3">
                <label class="form-label">Usuario</label>
                <input type="text" class="form-control" name="usuario" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" name="correo" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="contrasena" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Género</label>
                <select class="form-select" name="genero" required>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Tipo de usuario</label>
                <select class="form-select" name="id_rol" required>
                    <option value="1">Administrador</option>
                    <option value="2">Usuario</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100" name="btnregistrar">Registrar</button>
        </form>

        <!-- Tabla de Usuarios -->
        <div class="col-lg-8 col-md-6 col-sm-12 p-4">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>USER</th>
                            <th>NOMBRE</th>
                            <th>APELLIDO PATERNO</th>
                            <th>APELLIDO MATERNO</th>
                            <th>TIPO DE USUARIO</th>
                            <th>CONTRASEÑA</th>
                            <th>CORREO</th>
                            <th>GÉNERO</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($datos = $sql->fetch_object()): ?>
                            <tr>
                                <td><?= $datos->id_usuario ?></td>
                                <td><?= $datos->usuario ?></td>
                                <td><?= $datos->nombre ?></td>
                                <td><?= $datos->apellidoP ?></td>
                                <td><?= $datos->apellidoM ?></td>
                                <td><?= $datos->id_rol ?></td>
                                <td><?= $datos->contrasena ?></td>
                                <td><?= $datos->correo ?></td>
                                <td><?= $datos->genero ?></td>
                                <td>
                                    <a href="modificar_usuario.php?id=<?= $datos->id_usuario ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                    <a onclick="return confirm('¿Está seguro de eliminar este usuario?')" href="../../Controlador/eliminar_usuario.php?id=<?= $datos->id_usuario ?>" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
