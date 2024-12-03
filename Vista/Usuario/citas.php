<?php
session_start();
require_once '../../Controlador/validarSesion.php';
validarSesion();

require_once '../../Controlador/Citas/gestionar_citas.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <title>Gestión de Citas</title>
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
    <h2 class="text-center">Mis Citas</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Estado</th>
                <th>Empresa</th>
                <th>Usuario</th>
                <th>Observaciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($cita = $citas->fetch_object()): ?>
                <tr>
                    <td><?= htmlspecialchars($cita->id_cita) ?></td>
                    <td><?= htmlspecialchars($cita->fecha) ?></td>
                    <td><?= htmlspecialchars($cita->estado) ?></td>
                    <td><?= htmlspecialchars($cita->nombre_empresa) ?></td>
                    <td><?= htmlspecialchars($cita->nombre_usuario) ?></td>
                    <td><?= htmlspecialchars($cita->observaciones) ?></td>
                    <td>
                        <?php if ($cita->estado === 'Pendiente'): ?>
                            <form action="../../Controlador/Citas/gestionar_citas.php" method="POST" onsubmit="return confirmarCancelacion();">
                                <input type="hidden" name="id_cita" value="<?= htmlspecialchars($cita->id_cita) ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Cancelar</button>
                            </form>
                        <?php else: ?>
                            <span class="text-muted">No disponible</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
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
<script>
    /**
     * Función para confirmar la cancelación de una cita.
     * Se ejecuta al enviar el formulario.
     */
    function confirmarCancelacion() {
        return confirm("¿Seguro que quiere cancelar esta cita?");
    }
</script>

</body>
</html>
