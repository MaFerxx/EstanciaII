<?php
session_start();
require_once '../../Controlador/validarSesion.php';
validarSesion();

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Inicio</title>
</head>
<body>
<nav class="navbar navbar-expand-lg" style="background-color: #d7ffc2;">
        <div class="container-fluid">
            <a class="navbar-brand" href="pagPrincipal.php">EcoFusionMap</a>
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

    <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active" data-bs-interval="1500">
                <img src="../img/residuos.jpg" class="d-block w-100" alt="Residuos">
            </div>
            <div class="carousel-item" data-bs-interval="2000">
                <img src="../img/desechos.jpg" class="d-block w-100" alt="Desechos">
            </div>
            <div class="carousel-item">
                <img src="../img/campaña.jpg" class="d-block w-100" alt="Campaña">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
<hr>
<div class="container mt-4">
    <!--<h2 class="text-center">Inicio</h2> -->
<pre class="pre">
Hacer un buen uso de los residuos peligrosos es crucial debido 
a sus efectos potencialmente dañinos para la salud humana, el
medio ambiente y los ecosistemas. Estos residuos, que incluyen 
productos químicos, desechos médicos y materiales industriales, 
pueden ser tóxicos, inflamables, corrosivos o reactivos.
</pre>

    <div class="row text-left">
        <div class="col-md-4">
            <img src="../img/residuos2.jpeg" alt="Imagen 1" class="img-fluid rounded mb-3">
        </div>
        <div class="col-md-4">
            <img src="../img/desechos.jpg" alt="Imagen 2" class="img-fluid rounded-circle mb-3">
        </div>
        <div class="col-md-4">
            <img src="../img/residuos.jpg" alt="Imagen 3" class="img-fluid rounded mb-3">
        </div>
    </div>

    <p class="text-center">
        ¿Qué son los residuos peligrosos? Por lo general se entiende por residuos peligrosos a aquellos residuos que, debido a sus peligros intrínsecos, por ejemplo, ser corrosivos, reactivos, explosivos, tóxicos, inflamables, pueden causar daños o efectos indeseados a la salud o al ambiente.
    </p>
</div>

<div class="container my-4">
    <div class="row g-2"> 
        <div class="col-md-3">
            <div class="card">
                <img src="../img/residuos.jpg" class="card-img-top" alt="residuosPeligrosos">
                <div class="card-body">
                    <h5 class="card-title">Residuos peligrosos</h5>
                    <p class="card-text">Los residuos peligrosos, por su toxicidad, requieren manejo adecuado para proteger salud, prevenir contaminación y preservar ecosistemas.</p>
                    <a href="residuos.php" class="btn btn-primary">Ver catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <img src="../img/empresas.jpg" class="card-img-top" alt="empresas">
                <div class="card-body">
                    <h5 class="card-title">Empresas</h5>
                    <p class="card-text">En el siguiente apartado se mostraran las empresas que se encargan de reciclar los residuos peligrosos.</p>
                    <a href="empresas.php" class="btn btn-primary">Ver empresas</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <img src="../img/campaña.jpg" class="card-img-top" alt="campaña">
                <div class="card-body">
                    <h5 class="card-title">Campañas</h5>
                    <p class="card-text">Es importante crear conciencia en la gestión de los residuos peligrosos, es por eso que hay campañas para gestionar los residuos peligrosos, conócelas!</p>
                    <a href="campañas.php" class="btn btn-primary">Ver campañas</a>
                </div>
            </div>
        </div>

    </div>
</div>


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

    <script src="../script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>