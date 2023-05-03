<?php
//SCRIPT QUE DEBE ESTAR EN PATH DONDE QUEREMOS RECORRER DIRECTORIOS BUSCANDO IMÁGENES (png, gif, jpg) Y CONVIRTIENDOLAS A webp
//Author: Israel Iglesias
//Organization: Conwork

$files = [];
get_all_files('./');
convertFilesToWebP('./', './backup_images/', $files);

function get_all_files($path){
    global $files;

    $dir = opendir($path);
    while ($current = readdir($dir)){
        if( $current != "." && $current != ".." && $current != "backup_images" && $current != "index.php") {
            if(is_dir($path.$current)) {
                get_all_files($path.$current.'/', $files);
            }
            else {
                $files[] = $path.$current;
            }
        }
    }
}

function convertFilesToWebP($path, $path_backup, $files){

    //Si no existe directorio de backup, lo creamos
    if(!file_exists($path_backup)) mkdir($path_backup, 0755, true);

    echo '<h2>Archivos a convertir a WEBP</h2>';
    echo '<ul>';
    for($i=0; $i<count( $files ); $i++){
        
        $path_file = str_replace(basename($files[$i]), '', $files[$i]);
        if(convertImageToWebP($files[$i], $path_file)){
            
            $destination_backup = str_replace($path, $path_backup, $files[$i]);
            $destination_backup = str_replace(basename($files[$i]), '', $destination_backup);
            if(!file_exists($destination_backup)) mkdir($destination_backup, 0755, true);

            rename($files[$i], $destination_backup.basename($files[$i]));
            echo '<li>'.$files[$i]."</li>";
        }
    }
    echo '</ul>';
}

function convertImageToWebP($source, $destination, $quality=80) {  	

    //Obtenemos extensión
    $extension = strtolower(pathinfo($source, PATHINFO_EXTENSION));  	

    //Creamos imagen
    switch($extension){
        case 'jpeg':
        case 'jpg':
            $image = imagecreatefromjpeg($source);
            $name_image = str_replace(['.jpeg','.jpg'], '.webp', strtolower(basename($source)));
        break;
        case 'gif':
            $image = imagecreatefromgif($source);  	
            $name_image = str_replace('.gif', '.webp', strtolower(basename($source)));
        break;
        case 'png':
            $image = imagecreatefrompng($source);  	
            $name_image = str_replace('.png', '.webp', strtolower(basename($source)));
        break;
        default:
            $image = '';
        break;
    }
    
    if($image != ''){
        return imagewebp($image, $destination.$name_image, $quality);  	  
    }else{
        return false;
    }
}

?>