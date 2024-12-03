<?php
require_once __DIR__ . "/../../Modelo/ConexionBD.php";
require_once __DIR__ . "/../../Modelo/Residuos/Rexplosivos.php";

class Explosivos  {
    private $modelo; //Declaramos una propiedad para almacenar el modelo

    public function __construct() {
        $this->modelo = new Rexplosivos();
    }
    //Método para obtener la lista de residuos
    public function listaResiduosExplosivos() {
        return $this->modelo->listaResiduosExplosivos();
    }
}
//Instanciamos el controlador
$controlador = new Explosivos();
$residuosExplosivos = $controlador->listaResiduosExplosivos();
?>
