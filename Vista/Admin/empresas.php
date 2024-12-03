<?php 
require_once "../../Modelo/ConexionBD.php"; 
require_once '../../Controlador/validarSesion.php';
validarSesion();

$conexion = new ConexionBD();
$conn = $conexion->conn;

if (!$conn) {
    die("Error en la conexión: " . $conn->connect_error);
}

$sql = $conn->query("SELECT * FROM empresas");

if (!$sql) {
    die("Error en la consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de empresas</title>
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

<h1 class="text-center p-3">Gestión de empresas</h1>

<div class="container-fluid">
    <div class="row">
        <!-- Formulario de Registro -->
        <form class="col-lg-4 col-md-6 col-sm-12 p-3" action="../../Controlador/Empresas/registro_empresas.php" method="POST">
            <h3 class="text-center text-secondary">Registro de empresas</h3>
            <div class="mb-3">
                <label class="form-label">Empresa</label>
                <input type="text" class="form-control" name="nombre_empresa" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" class="form-control" name="contrasena" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Dirección</label>
                <input type="text" class="form-control" name="direccion_empresa" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Teléfono</label>
                <input type="text" class="form-control" name="telefono_empresa">
            </div>
            <div class="mb-3">
                <label class="form-label">Correo</label>
                <input type="text" class="form-control" name="correo_empresa">
            </div>
            <div class="mb-3">
                <label class="form-label">Altitud</label>
                <input type="text" class="form-control" name="altitud">
            </div>
            <div class="mb-3">
                <label class="form-label">Latitud</label>
                <input type="text" class="form-control" name="latitud">
            </div>
            <button type="submit" class="btn btn-primary w-100" name="btnregistrar">Registrar</button>
        </form>

        <div class="col-lg-8 col-md-6 col-sm-12 p-4">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>EMPRESA</th>
                            <th>DIRECCIÓN</th>
                            <th>TELÉFONO</th>
                            <th>CORREO</th>
                            <th>ALTITUD</th>
                            <th>LATITUD</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($datos = $sql->fetch_object()): ?>
                            <tr>
                                <td><?= $datos->id_empresa ?></td>
                                <td><?= $datos->nombre_empresa ?></td>
                                <td><?= $datos->direccion_empresa ?></td>
                                <td><?= $datos->telefono_empresa ?></td>
                                <td><?= $datos->correo_empresa ?></td>
                                <td><?= $datos->altitud ?></td>
                                <td><?= $datos->latitud ?></td>
                                <td>
                                    <a href="modificar_empresa.php?id=<?= $datos->id_empresa ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                    <a onclick="return confirm('¿Está seguro de eliminar esta empresa?')" href="../../Controlador/Empresas/eliminar_empresa.php?id=<?= $datos->id_empresa ?>" class="btn btn-danger btn-sm">
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
