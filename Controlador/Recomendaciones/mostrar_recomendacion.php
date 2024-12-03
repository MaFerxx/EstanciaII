<?php

require_once '../../Modelo/Recomendaciones.php';

class Mostrar_recomendacion {
    // Método para obtener las recomendaciones de la empresa actual
    public function obtenerRecomendaciones($id_empresa) {
        // Crear una instancia del modelo
        $recomendaciones = new Recomendaciones();
        
        // Obtener las recomendaciones de la empresa
        return $recomendaciones->getRecomendacionesByEmpresa($id_empresa);
    }
}
