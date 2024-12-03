<?php
include './Connet.php';
//Obtiene la fecha y hora actuales 
$day=date("d");
$mont=date("m");
$year=date("Y");
$hora=date("H-i-s");
$fecha=$day.'_'.$mont.'_'.$year;
//Define el nombre del archivo de respaldo 
$DataBASE="bdestancia-".date("Y-m-d").".sql";
// Inicializar un arreglo para almacenar los nombres de las tablas de la base de datos
$tables=array();
//Ejecutamos la consulta SQL para obtener las tablas de la base de datos
$result=SGBD::sql('SHOW TABLES');
//Verificamos si se obtuvieron los resultados y se almacenan en el arreglo
if($result){
    while($row=mysqli_fetch_row($result)){
        $tables[] = $row[0];
    }
//Iniciamos el archivo de respaldo con la desactivación de las restricciones de clave foránea
    $sql='SET FOREIGN_KEY_CHECKS=0;'."\n\n";
//Agregamos la creación de la base de datos si no existe y seleccionar la base de datos
    $sql.='CREATE DATABASE IF NOT EXISTS '.BD.";\n\n";
    $sql.='USE '.BD.";\n\n";;
    //Recorremos las tablas para obtener su estructura y datos
    foreach($tables as $table){
        $result=SGBD::sql('SELECT * FROM '.$table);
        if($result){
            $numFields=mysqli_num_fields($result);
            $sql.='DROP TABLE IF EXISTS '.$table.';';
            //Obtener la estructura de la tabla y agregarla al archivo de respaldo
            $row2=mysqli_fetch_row(SGBD::sql('SHOW CREATE TABLE '.$table));
            $sql.="\n\n".$row2[1].";\n\n";
            //Recorremos las filas de la tabla y agregamos los datos al archivo de respaldo
            for ($i=0; $i < $numFields; $i++){
                while($row=mysqli_fetch_row($result)){
                    $sql.='INSERT INTO '.$table.' VALUES(';
                    for($j=0; $j<$numFields; $j++){
                        $row[$j]=addslashes($row[$j]);
                        $row[$j]=str_replace("\n","\\n",$row[$j]);
                        if (isset($row[$j])){
                            $sql .= '"'.$row[$j].'"' ;
                        }
                        else{
                            $sql.= '""';
                        }
                        if ($j < ($numFields-1)){
                            $sql .= ',';
                        }
                    }
                    $sql.= ");\n";
                }
            }
            $sql.="\n\n\n";
        }else{
            $error=1;
        }
    }
    if($error==1){
        echo 'Ocurrio un error inesperado al crear la copia de seguridad';
    }else{
//Cambiar los permisos del directorio de respaldo para permitir escritura
        chmod(BACKUP_PATH, 0777);
        $sql.='SET FOREIGN_KEY_CHECKS=1;'; //Activamos de nuevo las restricciones
        $handle=fopen($DataBASE,'w+');
        if(fwrite($handle, $sql)){
            fclose($handle);
        }else{
            echo 'Ocurrio un error inesperado al crear la copia de seguridad';
        }
    }
}else{
    echo 'Ocurrio un error inesperado';
}
mysqli_free_result($result);