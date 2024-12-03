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

<div class="container my-4">
    <div class="row g-2"> 
        <div class="col-md-3">
            <div class="card">
                <img src="../img/corrosivos.jpg" class="card-img-top" alt="Corrosivos">
                <div class="card-body">
                    <h5 class="card-title">Corrosivos</h5>
                    <p class="card-text">Los residuos corrosivos incluyen ácidos, bases fuertes, productos de limpieza industrial, residuos de procesos químicos y soluciones de baterías, todos con potencial para dañar materiales y el medio ambiente si no se manejan adecuadamente.</p>
                    <a href="Residuos/corrosivos.php" class="btn btn-primary">Ver catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <img src="../img/reactivos.jpg" class="card-img-top" alt="Reactivos">
                <div class="card-body">
                    <h5 class="card-title">Reactivos</h5>
                    <p class="card-text">Incluyen metales como sodio y potasio, peróxidos orgánicos, cianuros, sulfuros, restos de pólvora, nitratos, cloratos y percloratos. Son peligrosos por su capacidad de provocar reacciones violentas.</p>
                    <a href="Residuos/reactivos.php" class="btn btn-primary">Ver catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <img src="../img/explosivos.jpg" class="card-img-top" alt="Explosivos">
                <div class="card-body">
                    <h5 class="card-title">Explosivos</h5>
                    <p class="card-text">Incluyen productos pirotécnicos, municiones, explosivos industriales, peróxidos orgánicos y nitratos. Son altamente peligrosos, ya que pueden detonar con calor, fricción o presión, y requieren almacenamiento seguro y manejo especializado para prevenir accidentes y daños ambientales.</p>
                    <a href="Residuos/explosivos.php" class="btn btn-primary">Ver catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <img src="../img/toxicos.jpg" class="card-img-top" alt="Tóxicos">
                <div class="card-body">
                    <h5 class="card-title">Tóxicos</h5>
                    <p class="card-text">Los residuos tóxicos incluyen sustancias que pueden ser venenosas o causar daños serios a la salud humana y al ambiente, como pesticidas y productos químicos industriales.</p>
                    <a href="Residuos/toxicos.php" class="btn btn-primary">Ver catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <img src="../img/inflamable.jpg" class="card-img-top" alt="Inflamables">
                <div class="card-body">
                    <h5 class="card-title">Inflamables</h5>
                    <p class="card-text">Incluyen materiales que pueden encenderse fácilmente al contacto con fuentes de calor, chispas o llamas. Ejemplos comunes son solventes como acetona y alcoholes, aceites usados, combustibles y algunos productos de limpieza.</p>
                    <a href="Residuos/inflamables.php" class="btn btn-primary">Ver catálogo</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card">
                <img src="../img/patogena.jpg" class="card-img-top" alt="Patogeno">
                <div class="card-body">
                    <h5 class="card-title">Infecciosos o patogenos</h5>
                    <p class="card-text">Incluyen materiales que contienen microorganismos patógenos y representan un riesgo de transmisión de enfermedades. Ejemplos comunes son materiales contaminados con sangre, aguas residuales de laboratorios clínicos, guantes y jeringas usadas, y residuos de cultivos biológicos.</p>
                    <a href="Residuos/patogenos.php" class="btn btn-primary">Ver catálogo</a>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card">
                <img src="../img/radiactivo.jpg" class="card-img-top" alt="Radiactivo">
                <div class="card-body">
                    <h5 class="card-title">Radiactivos</h5>
                    <p class="card-text">Son materiales que emiten radiación ionizante, lo que representa un riesgo para la salud y el medio ambiente debido a su capacidad de causar daño celular. Ejemplos comunes incluyen desechos de plantas nucleares, materiales de diagnóstico médico y terapias de radiación, y fuentes de radiación usadas en investigación.</p>
                    <a href="Residuos/radiactivos.php" class="btn btn-primary">Ver catálogo</a>
                </div>
            </div>
        </div>

    </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>