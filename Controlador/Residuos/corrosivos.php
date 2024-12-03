<?php
require_once __DIR__ . "/../../Modelo/ConexionBD.php";
require_once __DIR__ . "/../../Modelo/Residuos/Rcorrosivos.php";

class Corrosivos  {
    private $modelo; //Declaramos una propiedad para almacenar el modelo

    public function __construct() {
        $this->modelo = new Rcorrosivos();
    }

    //Método para obtener la lista de residuos corrosivos
    public function listaResiduosCorrosivos() {
        return $this->modelo->listaResiduosCorrosivos();
    }
}
//Instanciamos el controlador
$controlador = new Corrosivos();
$residuosCorrosivos = $controlador->listaResiduosCorrosivos();
?>
