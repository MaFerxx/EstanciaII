<?php
require_once __DIR__ . "/../../Modelo/ConexionBD.php";
require_once __DIR__ . "/../../Modelo/Residuos/Rinflamables.php";

class Inflamables  {
    private $modelo; //Declaramos una propiedad para almacenar el modelo

    public function __construct() {
        $this->modelo = new Rinflamables();
    }
//Método para obtener la lista de residuos
    public function listaResiduosInflamables() {
        return $this->modelo->listaResiduosInflamables();
    }
}
//Instanciamos el controlador
$controlador = new Inflamables();
$residuosInflamables = $controlador->listaResiduosInflamables();
?>
