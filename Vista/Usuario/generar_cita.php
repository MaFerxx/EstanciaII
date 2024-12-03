<?php
session_start();
require_once '../../Controlador/validarSesion.php';
validarSesion();

$empresa_id = $_GET['id_empresa']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Generar Cita</title>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Generar Cita</h1>
    <form action="../../Controlador/Citas/generar_cita.php" method="POST">
        <input type="hidden" name="empresa_id" value="<?= htmlspecialchars($empresa_id) ?>">
        <div class="mb-3">
            <label for="fecha" class="form-label">Fecha y Hora</label>
            <input type="datetime-local" class="form-control" name="fecha" required>
        </div>
        <div class="mb-3">
            <label for="observaciones" class="form-label">Observaciones</label>
            <textarea name="observaciones" class="form-control" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-success w-100">Confirmar Cita</button>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
