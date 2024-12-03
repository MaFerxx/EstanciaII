<?php
require_once __DIR__ . "/../../Modelo/ConexionBD.php";
require_once __DIR__ . "/../../Modelo/Residuos/Rpatogenos.php";

class Patogenos  {
    private $modelo; //Declaramos una propiedad para almacenar el modelo

    public function __construct() {
        $this->modelo = new Rpatogenos();
    }
    //Método para obtener la lista de residuos
    public function listaResiduosPatogenos() {
        return $this->modelo->listaResiduosPatogenos();
    }
}
//Instanciamos el controlador
$controlador = new Patogenos();
$residuosPatogenos = $controlador->listaResiduosPatogenos();
?>
