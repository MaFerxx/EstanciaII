<?php
session_start();
require_once '../../Controlador/validarSesion.php';
validarSesion();

// Obtener el ID de la empresa 
if (!isset($_SESSION['empresa_id'])) {
    echo "<script>alert('No has iniciado sesión como empresa.'); window.location.href = '../login.php';</script>";
    exit();
}

$id_empresa = $_SESSION['empresa_id'];  

// Incluir el controlador de campañas
require_once '../../Controlador/Campañas/mostrar_campañas.php';
$campanasController = new CampanasController();
$campanasList = $campanasController->getCampañasByEmpresa($id_empresa);


header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">    <title>Campañas</title>
</head>
<body>
<nav class="navbar navbar-expand-lg" style="background-color: #d7ffc2;">
    <div class="container-fluid">
        <a class="navbar-brand" href="pagPrincipal.php">Regresar</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="pagPrincipal.php">Inicio</a></li>
                <li class="nav-item"><a class="nav-link active" aria-current="page" href="#quienes-somos">¿Quienes somos?</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Perfil</a>
                    <ul class="dropdown-menu">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="citas.php">Mis citas</a></li>
                        <li><a class="dropdown-item" href="../../Controlador/logout.php">Cerrar sesión</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2 class="text-center">Campañas Registradas</h2>

    <?php if (isset($campanasList) && count($campanasList) > 0): ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($campanasList as $campana): ?>
                    <tr>
                        <td><?= htmlspecialchars($campana['nombre_campana']) ?></td>
                        <td><?= htmlspecialchars($campana['descripcion']) ?></td>
                        <td><?= htmlspecialchars($campana['fecha_inicio']) ?></td>
                        <td><?= htmlspecialchars($campana['fecha_fin']) ?></td>                        <td>
                            <a href="modificar_campaña.php?id=<?= $campana['id_campana'] ?>" class="btn btn-warning btn-sm">Editar</a>
                            <a onclick="return confirm('¿Está seguro de eliminar esta campaña?')" 
   href="../../Controlador/Campañas/eliminarDE.php?id=<?= $campana['id_campana'] ?>" 
   class="btn btn-danger btn-sm">
    <i class="bi bi-trash"></i>
</a>
                    </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="text-center">No hay campañas registradas para esta empresa.</p>
    <?php endif; ?>
</div>

<footer class="text-center py-2">
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
