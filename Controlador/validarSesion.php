<?php

function validarSesion() {
    // Verificar si la sesión no está activa y iniciarla si es necesario
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Si no existe la sesión del usuario, cerrar sesión
    if (!isset($_SESSION['usuario_id']) && !isset($_SESSION['empresa_id'])) {
        cerrarSesion();
    }
}

function cerrarSesion() {
    // Verificar si la sesión está activa antes de cerrarla
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_unset(); // Limpiar las variables de sesión
        session_destroy(); // Destruir la sesión
    }

    // Redirigir al inicio de sesión
    header('Location: ../index.php'); 
    exit();
}
