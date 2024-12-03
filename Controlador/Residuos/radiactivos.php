<?php
require_once __DIR__ . "/../../Modelo/ConexionBD.php";
require_once __DIR__ . "/../../Modelo/Residuos/Rradiactivos.php";

class Radiactivos  {
    private $modelo; //Declaramos una propiedad para almacenar el modelo

    public function __construct() {
        $this->modelo = new Rradiactivos();
    }
    //Método para obtener la lista de residuos
    public function listaResiduosRadiactivos() {
        return $this->modelo->listaResiduosRadiactivos();
    }
}
//Instanciamos el controlador
$controlador = new Radiactivos();
$residuosRadiactivos = $controlador->listaResiduosRadiactivos();
?>
