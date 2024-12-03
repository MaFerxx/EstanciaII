<?php
session_start();
require_once '../../Controlador/validarSesion.php';
require_once '../../Controlador/Empresas/mostrar_empresas.php';

validarSesion();

if (isset($_SESSION['mensaje_error'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['mensaje_error'] . '</div>';
    unset($_SESSION['mensaje_error']); // Limpia el mensaje después de mostrarlo
}

if (isset($_SESSION['mensaje_exito'])) {
    echo '<div class="alert alert-success">' . $_SESSION['mensaje_exito'] . '</div>';
    unset($_SESSION['mensaje_exito']); // Limpia el mensaje después de mostrarlo
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Empresas Registradas</title>
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

<div class="container mt-4">
<h1 class="text-center mb-4">Empresas Registradas</h1>
    <div class="row">
      <?php foreach ($empresas as $empresa): ?>
      <div class="col-md-4 mb-3">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($empresa['nombre_empresa']) ?></h5>
            <p class="card-text">
              <strong>Dirección:</strong> <?= htmlspecialchars($empresa['direccion_empresa']) ?><br>
              <strong>Teléfono:</strong> <?= htmlspecialchars($empresa['telefono_empresa']) ?><br>
              <strong>Correo:</strong> <?= htmlspecialchars($empresa['correo_empresa']) ?>
            </p>
            <a href="formCita.php?id_empresa=<?= $empresa['id_empresa'] ?>" class="btn btn-primary">Generar Cita</a>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

<div id="map"></div>

<!-- Contacto -->
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

<script>
    const empresas = <?= json_encode($empresas, JSON_HEX_TAG); ?>;
</script>

<script src="../script.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBDaeWicvigtP9xPv919E-RNoxfvC-Hqik&callback=iniciarMap"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
