<?php
require_once "../../Modelo/ConexionBD.php"; 
require_once '../../Controlador/validarSesion.php';
validarSesion();

$conexion = new ConexionBD();
$conn = $conexion->conn;

if (isset($_SESSION['error'])) {
    echo "<div class='alert alert-danger'>" . $_SESSION['error'] . "</div>";
    unset($_SESSION['error']); // Eliminar el mensaje después de mostrarlo
}

if (isset($_SESSION['success'])) {
    echo "<div class='alert alert-success'>" . $_SESSION['success'] . "</div>";
    unset($_SESSION['success']); // Eliminar el mensaje después de mostrarlo
}

if (!$conn) {
    die("Error en la conexión: " . $conn->connect_error);
}

$sql = "SELECT campanas.id_campana, campanas.nombre_campana, campanas.descripcion, campanas.fecha_inicio, campanas.fecha_fin, empresas.nombre_empresa 
        FROM campanas 
        JOIN empresas ON campanas.id_empresa = empresas.id_empresa";
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
    <title>Gestión de campañas</title>
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

<h1 class="text-center p-3">Gestión de campañas</h1>

<div class="container-fluid">
    <div class="row">
        <!-- Formulario de Registro -->
        <form class="col-lg-4 col-md-6 col-sm-12 p-3" action="../../Controlador/Campañas/registro_campañas.php" method="POST">
            <h3 class="text-center text-secondary">Registro de campañas</h3>
            <div class="mb-3">
                <label class="form-label">Nombre de la campaña</label>
                <input type="text" class="form-control" name="nombre_campana" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <input type="text" class="form-control" name="descripcion" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Fecha de inicio</label>
                <input type="date" class="form-control" name="fecha_inicio">
            </div>
            <div class="mb-3">
                <label class="form-label">Fecha de fin</label>
                <input type="date" class="form-control" name="fecha_fin">
            </div>
            <!-- Selector de Empresa -->
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

        <!-- Tabla de campañas -->
        <div class="col-lg-8 col-md-6 col-sm-12 p-4">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>CAMPAÑA</th>
                            <th>DESCRIPCIÓN</th>
                            <th>FECHA DE INICIO</th>
                            <th>FECHA DE FIN</th>
                            <th>EMPRESA</th>
                            <th>ACCIONES</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($datos = $result->fetch_object()): ?>
                            <tr>
                                <td><?= $datos->id_campana ?></td>
                                <td><?= $datos->nombre_campana ?></td>
                                <td><?= $datos->descripcion ?></td>
                                <td><?= $datos->fecha_inicio ?></td>
                                <td><?= $datos->fecha_fin ?></td>
                                <td><?= $datos->nombre_empresa ?></td>
                                <td>
                                    <a href="modificar_campaña.php?id=<?= $datos->id_campana ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                    <a onclick="return confirm('¿Está seguro de eliminar esta campaña?')" href="../../Controlador/Campañas/eliminar_campaña.php?id=<?= $datos->id_campana ?>" class="btn btn-danger btn-sm">
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