<?php
session_start(); // Inicia la sesión al principio

require_once '../Modelo/ConexionBD.php';

class loginController {
    private $conexion;

    public function __construct() {
        $this->conexion = new ConexionBD();
    }

    public function iniciarSesion($usuario, $contrasena) {
        // Variable para almacenar mensajes de error
        $mensajeError = "";

        try {
            // Consultar en la tabla usuarios
            $queryUsuarios = "SELECT id_usuario, contrasena, id_rol FROM usuarios WHERE usuario = ?";
            $stmtUsuarios = $this->conexion->conn->prepare($queryUsuarios);
            $stmtUsuarios->bind_param("s", $usuario);
            $stmtUsuarios->execute();
            $resultadoUsuarios = $stmtUsuarios->get_result();

            if ($resultadoUsuarios->num_rows > 0) {
                // Usuario encontrado
                $datosUsuario = $resultadoUsuarios->fetch_assoc();
                if (password_verify($contrasena, $datosUsuario['contrasena'])) {
                    // Inicia sesión para usuario o administrador
                    $_SESSION['usuario_id'] = $datosUsuario['id_usuario'];
                    $_SESSION['id_rol'] = $datosUsuario['id_rol'];
                    header('Location: ../Vista/index.php');
                    exit();
                } else {
                    $mensajeError = "Contraseña incorrecta para usuario.";
                }
            } else {
                // Consultar en la tabla empresas
                $queryEmpresas = "SELECT id_empresa, contrasena FROM empresas WHERE nombre_empresa = ?";
                $stmtEmpresas = $this->conexion->conn->prepare($queryEmpresas);
                $stmtEmpresas->bind_param("s", $usuario);
                $stmtEmpresas->execute();
                $resultadoEmpresas = $stmtEmpresas->get_result();

                if ($resultadoEmpresas->num_rows > 0) {
                    // Empresa encontrada
                    $datosEmpresa = $resultadoEmpresas->fetch_assoc();
                    if (password_verify($contrasena, $datosEmpresa['contrasena'])) {
                        // Inicia sesión para empresa
                        $_SESSION['empresa_id'] = $datosEmpresa['id_empresa'];
                        header('Location: ../Vista/Empresa/pagPrincipal.php');
                        exit();
                    } else {
                        $mensajeError = "Contraseña incorrecta para empresa.";
                    }
                } else {
                    $mensajeError = "Usuario o empresa no encontrado.";
                }
            }
        } catch (Exception $e) {
            $mensajeError = "Error de sistema: " . $e->getMessage();
        }

        // Si no se cumple ninguna condición anterior, mostrar el mensaje de error
        echo "<script>alert('$mensajeError'); window.location.href = '../Vista/index.php';</script>";
    }
}

// Manejo del formulario de inicio de sesión
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar y limpiar los datos de entrada
    $usuario = htmlspecialchars(trim($_POST['usuario']));
    $contrasena = htmlspecialchars(trim($_POST['contrasena']));

    // Instanciar el controlador e iniciar sesión
    $loginController = new loginController();
    $loginController->iniciarSesion($usuario, $contrasena);
}
