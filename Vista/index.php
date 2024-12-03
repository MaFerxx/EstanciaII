<?php
session_start();
require_once '../Controlador/userController.php'; 

if (isset($_SESSION['usuario_id'])) {
    $usuarioId = $_SESSION['usuario_id'];

    $controlador = new UserController(); 
    $controlador->redirigirSegunTipo($usuarioId);
    exit(); 
}

// Mostrar mensaje si existe en la sesión
$mensaje = isset($_SESSION['mensaje']) ? $_SESSION['mensaje'] : '';
unset($_SESSION['mensaje']); // Limpiar el mensaje después de mostrarlo
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #d6f5d6;
            background-image: url('img/fondo.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            height: 100vh;
        }
        .contenedor {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            max-width: 400px;
            width: 100%;
            background: white;
            border-radius: 15px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
            padding: 30px;
            display: none; /* Ocultamos por defecto */
        }
        .contenedor-login {
            display: block; /* Mostrar login por defecto */
        }
        h2 {
            color: #8dce58;
        }
        .btn-toggle {
            background: transparent;
            border: none;
            color: #8dce58;
            cursor: pointer;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<main>
    <div class="contenedor contenedor-login" id="contenedorLogin">
        <h2 class="text-center mb-4">Iniciar Sesión</h2>
        <form action="../Controlador/loginController.php" method="POST">
            <div class="mb-3">
                <input type="text" class="form-control" name="usuario" placeholder="Usuario" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="contrasena" placeholder="Contraseña" required>
            </div>
            <button type="submit" class="btn btn-success w-100 mb-3">Entrar</button>
            <div class="text-center">
                <p>¿No tienes cuenta?
                    <button type="button" class="btn-toggle" id="btnMostrarRegistro">Regístrate</button>
                </p>
            </div>
        </form>
    </div>

    <div class="contenedor contenedor-registro" id="contenedorRegistro">
        <form action="../Modelo/registroUsuario.php" method="POST">
            <h2 class="text-center mb-4">Regístrate</h2>
            <div class="mb-3">
                <input type="text" class="form-control" name="nombre" placeholder="Nombre" required>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" name="apellidoP" placeholder="Apellido Paterno" required>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" name="apellidoM" placeholder="Apellido Materno">
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" name="usuario" placeholder="Usuario" required>
            </div>
            <div class="mb-3">
                <input type="email" class="form-control" name="correo" placeholder="Correo Electrónico" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="contrasena" placeholder="Contraseña" required>
            </div>
            <div class="mb-3">
                <select class="form-select" name="genero" required>
                    <option value="Masculino">Masculino</option>
                    <option value="Femenino">Femenino</option>
                </select>
            </div>
            <div class="mb-3">
                <select class="form-select" name="id_rol" required>
                    <option value="1">Administrador</option>
                    <option value="2">Usuario</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success w-100">Registrarse</button>
            <div class="text-center mt-3">
                <p>¿Ya tienes cuenta?
                    <button type="button" class="btn-toggle" id="btnMostrarLogin">Iniciar Sesión</button>
                </p>
                <p>¿Vas a registrar una empresa?
                    <button type="button" class="btn-toggle" id="btnMostrarRegistroEmp">Registrar empresa</button>
                </p>
            </div>
        </form>
    </div>

    <div class="contenedor contenedor-registro" id="contenedorRegistroEmp">
        <form action="../Modelo/registroEmpresa.php" method="POST">
            <h2 class="text-center mb-4">Regístrate</h2>
            <div class="mb-3">
                <input type="text" class="form-control" name="nombre_empresa" placeholder="Empresa" required>
            </div>
            <div class="mb-3">
                <input type="password" class="form-control" name="contrasena" placeholder="Contraseña" required>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" name="direccion_empresa" placeholder="Dirección" required>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" name="telefono_empresa" placeholder="Teléfono">
            </div>
            <div class="mb-3">
                <input type="email" class="form-control" name="correo_empresa" placeholder="Correo" required>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" name="altitud" placeholder="Altitud" required>
            </div>
            <div class="mb-3">
                <input type="text" class="form-control" name="latitud" placeholder="Latitud" required>
            </div>
         <!--   <div class="mb-3">
                <select class="form-select" name="id_rol" required>
                    <option value="3">Empresa</option>
                </select>
            </div> -->
            <button type="submit" class="btn btn-success w-100">Registrarse</button>
            <div class="text-center mt-3">
                <p>¿Vas a registrar un usuario?
                    <button type="button" class="btn-toggle" id="btnMostrarRegistroUsuarioE">Regístrate</button>
                </p>
                <p>¿Ya tienes cuenta?
                    <button type="button" class="btn-toggle" id="btnMostrarLogin">Iniciar Sesión</button>
                </p>
            </div>
        </form>
    </div>

     <!-- Mostrar mensaje si existe -->
     <?php if ($mensaje): ?>
        <div class="alert alert-info text-center mt-4">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="script.js" defer></script>

</body>
</html>
