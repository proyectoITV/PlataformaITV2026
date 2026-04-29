<!DOCTYPE html>
<html>
	<head>
		<title>
		Subir por ftp
		</title>
	</head>
	<body>
		<form name="enviador" method="post" action="ftp.php" enctype="multipart/form-data">
			<input type="hidden" name="MAX_FILE_SIZE" value="1000">
			Archivo: <input type="file" name="archivo">
			<input type="submit" name='submit_ftp'>
		</form>

<?php


# CONSTANTES
// define("FTP_SERVER","localhost"); //IP o Nombre del Servidor
// define("FTP_PORT",21); //Puerto
// define("FTP_USER","desarrollo"); //Nombre de Usuario
// define("FTP_PASSWORD","jpedraza"); //Contraseña de acceso
// define("FTP_DIR","/home/desarrollo2/public_html/"); //ruta del  ftp

require('unica/config.php');
require('unica/funciones.php');


$archivo_local = 'tam.png';



if (isset($_POST['submit_ftp'])){
	echo "<H1>".$_FILES['archivo']['tmp_name']."</H1>";	
	$subida1 = FTP_subir($_FILES['archivo']['tmp_name'],'test_13112018.png');
	if ($subida1 == "TRUE"){
		echo "OK";

	} else {
		echo "ERROR";
	}



}else{echo "Selecciona un archivo...";}


	
	$subida1 = FTP_subir('tam.png','test_13112018.png');
	if ($subida1 == "TRUE"){
		echo "OK";

	} else {
		echo "ERROR";
	}


?>




	</body>
	</html>