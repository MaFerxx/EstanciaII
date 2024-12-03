<?php 
session_start();
require_once '../../Controlador/validarSesion.php';
require_once '../../Modelo/ConexionBD.php';

validarSesion();

if (!isset($_SESSION['empresa_id'])) {
    die('Error: No se encontró el ID de la empresa en la sesión');
}

$empresa_id = $_SESSION['empresa_id'];

// Obtener los residuos asociados a la empresa
$conexion = new ConexionBD();
$conn = $conexion->conn;

$sql = $conn->query("
    SELECT 
        r.id_residuo, 
        r.nombre, 
        r.tipo_residuo, 
        r.descripcion_residuo, 
        e.nombre_empresa 
    FROM 
        residuos r
    JOIN 
        empresas_has_residuos erh ON r.id_residuo = erh.residuos_id_residuo
    JOIN 
        empresas e ON erh.id_empresa = e.id_empresa
    WHERE
        erh.id_empresa = $empresa_id
");

if (!$sql) {
    die("Error en la consulta: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <title>Gestión de residuos</title>
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

<h1 class="text-center p-3">Gestión de residuos peligrosos</h1>

<!-- Mostrar mensajes de error o éxito -->
<?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert alert-danger">
        <?= $_SESSION['error_message']; ?>
    </div>
    <?php unset($_SESSION['error_message']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['success_message'])): ?>
    <div class="alert alert-success">
        <?= $_SESSION['success_message']; ?>
    </div>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<div class="container-fluid">
    <div class="row">
        <form class="col-lg-4 col-md-6 col-sm-12 p-3" action="../../Controlador/Residuos/registroResiduoControlador.php" method="POST">
            <h3 class="text-center text-secondary">Registro de residuos peligrosos</h3>
            <div class="mb-3">
                <label class="form-label">Nombre del residuo</label>
                <input type="text" class="form-control" name="nombre" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tipo de residuo</label>
                <select class="form-select" name="tipo_residuo" required>
                    <option value="" selected disabled>Seleccione el tipo de residuo</option>
                    <option value="Corrosivo">Corrosivo</option>
                    <option value="Reactivo">Reactivo</option>
                    <option value="Explosivo">Explosivo</option>
                    <option value="Tóxico">Tóxico</option>
                    <option value="Inflamable">Inflamable</option>
                    <option value="Infeccioso o Patógeno">Infeccioso o Patógeno</option>
                    <option value="Radiactivo">Radiactivo</option>
                </select>            
            </div>
            <div class="mb-3">
                <label class="form-label">Descripción</label>
                <input type="text" class="form-control" name="descripcion_residuo" required>
            </div>
            <button type="submit" name="btnregistrar" class="btn btn-primary">Registrar Residuo</button>
        </form>
    </div>

    <!-- Mostrar los residuos asociados a la empresa -->
    <h2 class="text-center p-3">Residuos Registrados</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID Residuo</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($residuo = $sql->fetch_object()): ?>
                <tr>
                    <td><?= $residuo->id_residuo ?></td>
                    <td><?= $residuo->nombre ?></td>
                    <td><?= $residuo->tipo_residuo ?></td>
                    <td><?= $residuo->descripcion_residuo ?></td>
                    <td>
                        <a href="modificar_residuo.php?id=<?= $residuo->id_residuo ?>" class="btn btn-warning btn-sm">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a onclick="return confirm('¿Está seguro de eliminar este residuo?')" 
                           href="../../Controlador/Residuos/eliminarE.php?id=<?= $residuo->id_residuo ?>" 
                           class="btn btn-danger btn-sm">
                            <i class="bi bi-trash"></i>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
