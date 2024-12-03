<?php
require_once "../../Modelo/ConexionBD.php";
require_once '../../Controlador/validarSesion.php';
validarSesion();

if (isset($_SESSION['mensaje_exito'])) {
    echo "<div class='alert alert-success' role='alert'>" . $_SESSION['mensaje_exito'] . "</div>";
    unset($_SESSION['mensaje_exito']);
} elseif (isset($_SESSION['mensaje_error'])) {
    echo "<div class='alert alert-danger' role='alert'>" . $_SESSION['mensaje_error'] . "</div>";
    unset($_SESSION['mensaje_error']);
}

$conexion = new ConexionBD();
$conn = $conexion->conn;

if (!$conn) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Consulta para obtener las citas junto con el nombre de la empresa y el nombre del usuario
$sql = "SELECT citas.id_cita, citas.fecha, citas.estado, citas.observaciones, empresas.nombre_empresa, usuarios.nombre AS nombre_usuario 
        FROM citas 
        JOIN empresas ON citas.empresas_id_empresa = empresas.id_empresa
        JOIN usuarios ON citas.usuarios_id_usuario = usuarios.id_usuario";
$result = $conn->query($sql);

if (!$result) {
    die("Error en la consulta: " . $conn->error);
}

// Consulta para obtener las empresas
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
    <title>Gestión de citas</title>
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

    <h1 class="text-center p-3">Gestión de citas</h1>

    <div class="container-fluid">
        <div class="row">
            <form class="col-lg-4 col-md-6 col-sm-12 p-3" action="../../Controlador/Citas/registro_citas.php" method="POST">
                <h3 class="text-center text-secondary">Registro de citas</h3>
                <div class="mb-3">
                    <label class="form-label">Fecha</label>
                    <input type="datetime-local" class="form-control" name="fecha" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Seleccione la empresa</label>
                    <select class="form-select" name="empresas_id_empresa" required>
                        <option value="" selected disabled>Seleccione una empresa</option>
                        <?php while ($empresa = $result_empresas->fetch_object()): ?>
                            <option value="<?= $empresa->id_empresa ?>"><?= $empresa->nombre_empresa ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Observaciones</label>
                    <textarea class="form-control" name="observaciones" rows="3"></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100" name="btnregistrar">Registrar</button>
            </form>
            <div class="col-lg-8 col-md-6 col-sm-12 p-4">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>FECHA</th>
                                <th>ESTADO</th>
                                <th>EMPRESA</th>
                                <th>USUARIO</th>
                                <th>OBSERVACIONES</th>
                                <th>ACCIONES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($datos = $result->fetch_object()): ?>
                                <tr>
                                    <td><?= $datos->id_cita ?></td>
                                    <td><?= $datos->fecha ?></td>
                                    <td><?= $datos->estado ?></td>
                                    <td><?= $datos->nombre_empresa ?></td>
                                    <td><?= $datos->nombre_usuario ?></td>
                                    <td><?= $datos->observaciones ?></td>
                                    <td>
                                        <a href="modificar_cita.php?id=<?= $datos->id_cita ?>" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                        <a onclick="return confirm('¿Está seguro de eliminar esta cita?')" href="../../Controlador/Citas/eliminar_cita.php?id=<?= $datos->id_cita ?>" class="btn btn-danger btn-sm">
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