<?php

$conn = mysqli_connect(
    'localhost',
    'root',
    '',
    'bdestancia'
);

if (empty($_FILES["backup_file"]["name"])) {
    echo "No se ha seleccionado ningún archivo.";
} else {
    // Validando el tipo de archivo SQL por extensiones
    if (!in_array(strtolower(pathinfo($_FILES["backup_file"]["name"], PATHINFO_EXTENSION)), array(
        "sql"
    ))) {
        echo "La extensión del archivo no es permitida.";
    } else {
        // Verificar si el archivo fue cargado correctamente
        if (is_uploaded_file($_FILES["backup_file"]["tmp_name"])) {
            move_uploaded_file($_FILES["backup_file"]["tmp_name"], $_FILES["backup_file"]["name"]);
            $response = restoreMysqlDB($_FILES["backup_file"]["name"], $conn); // Restaura la base de datos

            switch ($response) {
                case "Error":
                    echo "La Base de Datos no se restauró.";
                break;
                case "Success":
                    echo "¡Base de Datos restaurada!";
                    if(unlink($_FILES["backup_file"]["name"])){
                        // El archivo fue eliminado exitosamente
                    } else {
                        // Hubo un problema al eliminar el archivo
                    }
                break;
            }
        }
    }
}
// Función para restaurar la base de datos desde un archivo SQL
function restoreMysqlDB($filePath, $conn)
{
    $sql = '';
    $error = '';

    // Verificamos si el archivo existe
    if (file_exists($filePath)) {
        $lines = file($filePath);

        foreach ($lines as $line) {

            // Ignorar comentarios del script SQL
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }

            $sql .= $line;

            if (substr(trim($line), -1, 1) == ';') {
                $result = mysqli_query($conn, $sql);
                if (!$result) {
                    $error .= mysqli_error($conn) . "n";
                }
                $sql = '';
            }
        } // end foreach

        if ($error) {
            $response = "Error";
        } else {
            $response = "Success";
        }
    } // finalizar si el archivo existe
    return $response;
}
