<?php
require_once '../../Modelo/Empresas.php';

class EmpresasController {
    private $modelo;

    public function __construct() {
        $this->modelo = new Empresas(); // Instancia el modelo de empresas
    }

    public function listarEmpresas() {
        return $this->modelo->obtenerEmpresas(); // Llama al método para obtener la lista de empresas
    }
}

// Instancia el controlador y obtiene la lista de empresas
$empresasController = new EmpresasController();
$empresas = $empresasController->listarEmpresas();
?>
