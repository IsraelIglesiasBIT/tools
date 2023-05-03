<?php
/*
Script que elimina los archivos de un directorio con una antigüedad mayor a X días
Author: Israel Iglesias
Organization: Conwork
*/

deleteOldFiles('./', 7);

function deleteOldFiles($path, $dias=7){
	global $trace;

	$dias = intval($dias);

	if($trace){
		echo "<br><b></b>Recorriendo archivos del directorio: '".$path."' </b><br/>";
		echo "<ul>";
	}

	$archivos_eliminados = 0;
	$archivos_noeliminados = 0;
	$total_archivos = 0;

	$handle = opendir($path);
    while ($file = readdir($handle)) {
		if (is_file($path."/".$file)) {
			$total_archivos++;
			if($trace) echo "<li>- ".$path."/".$file." --> ";  

			if($dias==0){
				if ( unlink($path."/".$file) ){
					$archivos_eliminados++;
				   	if($trace) echo "Eliminado. </li>";
				}else{
				   	$archivos_noeliminados++;
				   	if($trace) echo "No se ha podido eliminar. </li>";
				}
			}else{
				//Elimino los anteriores a los días pasados por parámetro
				if(time()-filemtime($path."/".$file) > 3600*24*$dias){

					if ( unlink($path."/".$file) ){
						$archivos_eliminados++;
					   	if($trace) echo "Eliminado. </li>";
					}else{
					   	$archivos_noeliminados++;
					   	if($trace) echo "No se ha podido eliminar. </li>";
					}
				}else{
					$archivos_noeliminados++;
					if($trace) echo "Pertenece a los últimos ".$dias." días. No se ha podido eliminar. </li>";
				}
			}
		}
    }

	if($trace){
		echo "</ul>";
		echo "<br/>";
		echo "Total archivos: <strong>". $total_archivos ."</strong><br/>";
		echo "Archivos eliminados: <strong>". $archivos_eliminados ."</strong><br/>";
		echo "Archivos no eliminados: <strong>". $archivos_noeliminados ."</strong><br/>";
	}
}

?>