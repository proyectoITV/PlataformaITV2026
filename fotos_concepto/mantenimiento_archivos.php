<?php
//include ("./unica/seguridad.php"); 
include ("./unica/body_head.php");


// contenido:
?>

<?php

function renombrarimagenes($carpeta)
 {
	
	if(is_dir($carpeta)){//comprueba que $carpeta sea un directorio					
		if($dir = opendir($carpeta)){//abre el directrio					
			//recorre el directorio mientras haya archivos
			
			while(($archivo = readdir($dir)) !== false){
				
				//el if compara que no sea elementos . .. o htaccess
				if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess')
				{								
					$pos = strpos('-', $archivo);

					if ($pos === false) {
						
						$nombre= explode('.',substr($archivo, 0, strlen($archivo)));
						echo $nombre[0]."<br>";
//echo "<br>".$nombre[0]."==>".$nombre[1];
						rename($carpeta."/".$archivo,$carpeta."/".$nombre[0].'-'.ndocumento(false).".".$nombre[1]);
					}
					else
					{
						
					}
				}
			}
			
			closedir($dir);
		}
	}

 }

//  echo "fotos_concepto:<br>";
//  echo renombrarimagenes('fotos_concepto');

 
 echo "<hr>";
 echo "fotos:<br>";
 echo renombrarimagenes('fotos');

//  echo "<hr>";
//  echo "pendientes:<br>";
//  echo renombrarimagenes('pendientes');

//  echo "<hr>";
//  echo "pendientes:<br>";
//  echo renombrarimagenes('req_fotos');

 
 ?>