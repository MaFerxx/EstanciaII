<?php
require_once '../Modelo/ConexionBD.php';

class UserController {
    private $conexion;

    public function __construct() {
        $this->conexion = new ConexionBD();
    }

    public function redirigirSegunTipo($usuarioId) {
        $tipoUsuario = $this->conexion->obtenerTipoUsuario($usuarioId);

        switch ($tipoUsuario) {
            case 1:
                header('Location: ../Vista/Admin/pagPrincipal.php');
                break;
            case 2:
                header('Location: ../Vista/Usuario/pagPrincipal.php');
                break;
            case 3:
                header('Location: ../Vista/Empresa/pagPrincipal.php');
                break;
            default:
                header('Location: ../index.php');
                exit();
        }
        exit();
    }
}
?>
