<?php
session_start();
require_once '../../Controlador/validarSesion.php';
validarSesion();

require_once '../../Modelo/ConexionBD.php';

$conexion = new ConexionBD();
$conn = $conexion->conn;

if (!$conn) {
    die("Error en la conexión: " . $conn->connect_error);
}

// Verifica que el parámetro id_empresa esté presente en la URL
if (!isset($_GET['id_empresa'])) {
    die("Error: ID de empresa no proporcionado.");
}

$id_empresa = $_GET['id_empresa'];

// Obtiene los datos de la empresa
$sql_empresa = "SELECT nombre_empresa FROM empresas WHERE id_empresa = ?";
$stmt_empresa = $conn->prepare($sql_empresa);
$stmt_empresa->bind_param("i", $id_empresa);
$stmt_empresa->execute();
$result_empresa = $stmt_empresa->get_result();

if ($result_empresa->num_rows === 0) {
    die("Error: Empresa no encontrada.");
}

$empresa = $result_empresa->fetch_object();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Cita</title>
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-expand-lg" style="background-color: #d7ffc2;">
        <div class="container-fluid">
            <a class="navbar-brand" href="empresas.php">Regresar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="pagPrincipal.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="empresas.php">Empresas</a></li>
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="#quienes-somos">¿Quienes somos?</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Perfil</a>
                        <ul class="dropdown-menu">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="citas.php">Mi citas</a></li>
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

    <div class="container mt-5">
        <h2 class="text-center">Generar Cita</h2>
        <form action="../../Controlador/Citas/regis_citaU.php" method="POST" class="p-4 border rounded shadow-sm">
    <input type="hidden" name="empresas_id_empresa" value="<?= $id_empresa ?>">

    <div class="mb-3">
        <label for="fecha" class="form-label">Fecha</label>
        <input type="datetime-local" class="form-control" id="fecha" name="fecha" required>
    </div>

    <div class="mb-3">
        <label for="observaciones" class="form-label">Observaciones</label>
        <textarea class="form-control" id="observaciones" name="observaciones" rows="3"></textarea>
    </div>

    <button type="submit" name="btnregistrar" class="btn btn-primary w-100">Registrar Cita</button>
</form>

    </div>

<footer id="quienes-somos" class="text-center py-2">
    <div class="container">
      <h4>EcoFusionMap</h4>
      <h5>Contáctanos</h5>
      <p>
        Garcia Gaona Maria Fernanda
        <a href="mailto:ggmo221346@upemor.edu.mx" style="color: inherit; text-decoration: underline;">GGMO221346@UPEMOR.EDU.MX</a>
      </p>
      <p>
        Gomez Estrada Jorge Luis
        <a href="mailto:gejo221148@upemor.edu.mx" style="color: inherit; text-decoration: underline;">GEJO221148@UPEMOR.EDU.MX</a>
      </p>
    </div>
</footer>

    <script src="../script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
