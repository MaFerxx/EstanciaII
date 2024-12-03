<?php
require_once __DIR__ . "/../../Modelo/ConexionBD.php";
require_once __DIR__ . "/../../Modelo/Residuos/Rreactivos.php";

class Reactivos  {
    private $modelo; //Declaramos una propiedad para almacenar el modelo

    public function __construct() {
        $this->modelo = new Rreactivos();
    }
    //Método para obtener la lista de residuos
    public function listaResiduosReactivos() {
        return $this->modelo->listaResiduosReactivos();
    }
}
//Instanciamos el controlador
$controlador = new Reactivos();
$residuosReactivos = $controlador->listaResiduosReactivos();
?>
