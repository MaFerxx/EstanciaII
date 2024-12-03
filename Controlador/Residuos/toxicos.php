<?php
require_once __DIR__ . "/../../Modelo/ConexionBD.php";
require_once __DIR__ . "/../../Modelo/Residuos/Rtoxicos.php";

class Toxicos  {
    private $modelo; //Declaramos una propiedad para almacenar el modelo

    public function __construct() {
        $this->modelo = new Rtoxicos();
    }
    //Método para obtener la lista de residuos
    public function listaResiduosToxicos() {
        return $this->modelo->listaResiduosToxicos();
    }
}
//Instanciamos el controlador
$controlador = new Toxicos();
$residuosToxicos = $controlador->listaResiduosToxicos();
?>
