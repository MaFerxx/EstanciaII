<?php
include('backup.php');

// Establecemos la zona horaria 
date_default_timezone_set("America/Mexico_City");

// Configuramos el nombre del archivo
header("Content-disposition: attachment; filename=bdestancia-".date("Y-m-d").".sql");
header("Content-type: MIME");
readfile("bdestancia-".date("Y-m-d").".sql");


if(unlink("bdestancia-".date("Y-m-d").".sql")){
    // El archivo fue eliminado exitosamente
} else {
    // Hubo un problema al eliminar el archivo
}

?>