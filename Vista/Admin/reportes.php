<?php
require_once '../../Controlador/reporteController.php';
require_once '../../Controlador/reporteEmpresa.php';
require_once '../../Controlador/reporteCampaña.php';
require_once '../../Controlador/reporteResiduosController.php';
require_once '../../Controlador/validarSesion.php';
validarSesion();

$conexion = new ConexionBD();
$conn = $conexion->conn;

if (!$conn) {
    die("Error en la conexión: " . $conn->connect_error);
}

$controlador = new ReporteController();
$controladorEmpresa = new ReporteEmpresa();
$controladorCampana = new ReporteCampañaController();
$controladorResiduos = new ReporteResiduosController();

$usuarios = $controlador->obtenerUsuarios(); // Obtener usuarios
$empresas = $controladorEmpresa->obtenerEmpresas(); // Obtener empresas
$campanasActivas = $controladorCampana->obtenerCampanasActivas(); // Obtener campañas activas

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Reporte</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
            </ul>
        </div>
    </div>
</nav>

<main class="container">
    <h2 class="text-center mb-4">Generar Reporte</h2>

    <!-- Cuadro con las opciones de reportes -->
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Historial de Usuario</h5>
                    <!-- Formulario para seleccionar usuario -->
                    <form action="../../Controlador/reporteController.php" method="POST">
                        <div class="mb-3">
                            <label for="usuario_id" class="form-label">Seleccionar Usuario</label>
                            <select class="form-select" name="usuario_id" required>
                                <option value="">Seleccione un usuario</option>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <option value="<?= $usuario['id_usuario']; ?>"><?= $usuario['nombre']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Generar Reporte de Usuario</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Reporte de Empresas</h5>
                    <!-- Formulario para seleccionar empresa -->
                    <form action="../../Controlador/reporteEmpresa.php" method="POST">
                        <div class="mb-3">
                            <label for="empresa_id" class="form-label">Seleccionar Empresa</label>
                            <select class="form-select" name="empresa_id" required>
                                <option value="">Seleccione una empresa</option>
                                <?php foreach ($empresas as $empresa): ?>
                                    <option value="<?= $empresa['id_empresa']; ?>"><?= $empresa['nombre_empresa']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Generar Reporte de Empresa</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Aquí solo agregamos un botón para generar el reporte de campañas -->
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Generar Reporte de Campañas Activas</h5>
                    <!-- Botón para generar el PDF de campañas activas -->
                    <form action="../../Controlador/reporteCampaña.php" method="POST">
                        <button type="submit" class="btn btn-primary w-100">Generar Reporte PDF</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-title">Reporte de Residuos por Empresa</h5>
                    <!-- Formulario para generar reporte -->
                    <form action="../../Controlador/reporteResiduosController.php" method="POST">
                        <button type="submit" class="btn btn-primary">Generar Reporte</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
