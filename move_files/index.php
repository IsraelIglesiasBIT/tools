<?php

/*
Script que mueve los archivos en un directorio en concreto a otro con el mismo nombre pero en otro sistemo/ruta etc..
Author: Jorge Olmedos
Organization: Conwork
*/

//DIRECTORIOS
$path_origen = $_SERVER['DOCUMENT_ROOT'].'/sistemas/micro/intranet/archivos/ascservicios/clientes';
$path_destino = $_SERVER['DOCUMENT_ROOT'].'/sistemas/micro/intranet/archivos/yccomunicaciones/clientes';
$borrado = false;

moveFiles($path_origen,$path_destino,$borrado);

function moveFiles($path_origen,$path_destino,$borrado=false){

    // Get array of all source files
    $files = scandir($path_origen);

    // Cycle through all source files
    foreach ($files as $file) {

          if( in_array($file, array(".","..")) ) continue;
          // If we copied this successfully, mark it for deletion
        if( copy($path_origen.$file, $path_destino.$file) ) $delete[] = $path_origen.$file;

    }

    if( $borrado == true ) GlobalDeleteFiles($delete);

}

function deleteFiles($delete){

    // Delete all successfully-copied files
    foreach ($delete as $file) {
      unlink($file);
    }

}

?>