<?php
require_once "../../Modelo/ConexionBD.php";
require_once "../../Controlador/validarSesion.php";
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

$id = $_GET['id'];
$sql = $conn->prepare("SELECT * FROM citas WHERE id_cita = ?");
$sql->bind_param("i", $id);
$sql->execute();
$result = $sql->get_result();

$sql_empresas = $conn->query("SELECT id_empresa, nombre_empresa FROM empresas");
$cita = $result->fetch_object();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Modificar Cita</title>
</head>
<body>

<nav class="navbar navbar-expand-lg" style="background-color: #61c9a8;">
    <div class="container-fluid">
        <a href="citas.php" class="btn btn-outline-primary">Regresar</a>
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
    <form class="col-4 p-3 m-auto" action="../../Controlador/Citas/modificar_cita.php" method="POST">
        <h3 class="text-center text-secondary">Modificar cita</h3>
        <input type="hidden" name="id" value="<?= $cita->id_cita ?>">

        <div class="mb-3">
            <label class="form-label">Fecha</label>
            <input type="datetime-local" class="form-control" name="fecha" value="<?= $cita->fecha ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Estado</label>
            <input type="text" class="form-control" name="estado" value="<?= $cita->estado ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Seleccione la empresa</label>
            <select class="form-select" name="id_empresa" required>
                <?php while ($empresa = $sql_empresas->fetch_object()): ?>
                    <option value="<?= $empresa->id_empresa ?>" <?= $empresa->id_empresa == $cita->empresas_id_empresa ? 'selected' : '' ?>>
                        <?= $empresa->nombre_empresa ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Observaciones</label>
            <textarea class="form-control" name="observaciones"><?= $cita->observaciones ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary w-100">Guardar cambios</button>
    </form>
</body>
</html>
