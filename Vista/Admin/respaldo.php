<?php
	include '../../Controlador/Connet.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Respaldo y Restauración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

<div class="container mt-5">
    <h1 class="text-center">Respaldo y Restauración</h1>
    <div class="container mb-5">
        <div class="row justify-content-md-center">
            <form action="../../Controlador/RespaldoBD.php" method="POST" class="row g-3 shadow bg-light">
                <div class="col-12">
                    <div class="mb-3">
                        <div class="text-center">
                            <h2 class="text-center">Respaldar base de datos</h2>
                            <p>Haga clic en el botón para respaldar la base de datos.</p>
                            <div class="loading" id="loading">
                                <!-- Loading -->
                            </div>
                            <input type="hidden" name="accion" value="respaldo">
                            <button type="submit" class="btn btn-primary w-100 my-3">Crear Respaldo</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="container mb-5">
        <div class="row justify-content-md-center">
            <form id="formRestoreBD" class="row g-3 shadow bg-light">
                <div class="col-12">
                    <div class="mb-3">
                        <div class="text-center">
                            <h2 class="text-center">Restaurar base de datos</h2>
                            <p>Por favor seleccione el archivo de la Base de Datos a restaurar.</p>
                            <div class="loading" id="loading">
                                <!-- Loading -->
                            </div>
                            <input type="file" class="form-control" name="backup_file" id="backup_file">
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-warning mb-4" id="restoringBD">Restaurar</button>
            </form>
        </div>
    </div>

</form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="restore.js"></script>
</body>
</html>