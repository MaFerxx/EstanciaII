<?php

class RespaldoBD {
    private $usuario = 'root'; 
    private $password = ''; 
    private $host = 'localhost';
    private $base_de_datos = 'bdestancia'; 

    // Generar respaldo
    public function generarRespaldo($archivo_respaldo) {
        $comando = "mysqldump -u $this->usuario -p$this->password -h $this->host $this->base_de_datos > $archivo_respaldo";
        exec($comando, $output, $resultado);
        
        if ($resultado !== 0) {
            error_log("Error al ejecutar comando: $comando");
            error_log("Salida del comando: " . implode("\n", $output));
        }
        
        return $resultado === 0; // Retorna true si fue exitoso
    }
    

    // Restaurar base de datos
    public function restaurarBaseDeDatos($archivo_respaldo) {
        $comando = sprintf(
            'mysql -u %s -p%s -h %s %s < %s',
            escapeshellarg($this->usuario),
            escapeshellarg($this->password),
            escapeshellarg($this->host),
            escapeshellarg($this->base_de_datos),
            escapeshellarg($archivo_respaldo)
        );
        exec($comando, $output, $resultado);
        return $resultado === 0; // Retorna true si fue exitoso
    }
}
