<?php 
require_once "../../Modelo/ConexionBD.php"; 
require_once '../../Controlador/validarSesion.php';
validarSesion();

$conexion = new ConexionBD();
$conn = $conexion->conn;

if (!$conn) {
    die("Error en la conexión: " . $conn->connect_error);
}

$sql = "SELECT recomendaciones.id_recomendacion, recomendaciones.descripcion, empresas.nombre_empresa 
        FROM recomendaciones 
        JOIN empresas ON recomendaciones.id_empresa = empresas.id_empresa";
$result = $conn->query($sql);

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

$sql_empresas = "SELECT id_empresa, nombre_empresa FROM empresas";
$result_empresas = $conn->query($sql_empresas);

if (!$result_empresas) {
    die("Error en la consulta de empresas: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de recomendaciones</title>
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

<h1 class="text-center p-3">Gestión de recomendaciones</h1>

<div class="container-fluid">
    <div class="row">
        <form class="col-lg-4 col-md-6 col-sm-12 p-3" action="../../Controlador/Recomendaciones/registro_recomienda.php" method="POST">
            <h3 class="text-center text-secondary">Registro de recomendaciones</h3>
            <div class="mb-3">
                <label class="form-label">Recomendación: </label>
                <input type="text" class="form-control" name="descripcion" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Seleccione la empresa</label>
                <select class="form-select" name="id_empresa" required>
                    <option value="" selected disabled>Seleccione una empresa</option>
                    <?php while ($empresa = $result_empresas->fetch_object()): ?>
                        <option value="<?= $empresa->id_empresa ?>"><?= $empresa->nombre_empresa ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary w-100" name="btnregistrar">Registrar</button>
        </form>

        <div class="col-lg-8 col-md-6 col-sm-12 p-4">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>RECOMENDACIÓN</th>
                            <th>EMPRESA</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($datos = $result->fetch_object()): ?>
                            <tr>
                                <td><?= $datos->id_recomendacion ?></td>
                                <td><?= $datos->descripcion ?></td>
                                <td><?= $datos->nombre_empresa ?></td>
                                <td>
                                    <a href="modificar_recomenda.php?id=<?= $datos->id_recomendacion ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                    <a onclick="return confirm('¿Está seguro de eliminar esta recomendación?')" href="../../Controlador/Recomendaciones/eliminar_recomienda.php?id=<?= $datos->id_recomendacion ?>" class="btn btn-danger btn-sm">
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
