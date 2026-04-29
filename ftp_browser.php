
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>::..Funciones FTP..::</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
</head>

<body>
<p align="center"><font size="5" face="Verdana, Tahoma, Arial"><strong><em>
Funciones FTP
</em></strong></font></p>
<p><font face="Verdana, Tahoma, Arial">

<?php
# FUNCIONES FTP

# CONSTANTES
# Cambie estos datos por los de su Servidor FTP
define("SERVER","plataformaitavu.tamaulipas.gob.mx"); //IP o Nombre del Servidor
define("PORT",2323); //Puerto
define("USER","desarrollo2"); //Nombre de Usuario
define("PASSWORD","jpedraza"); //Contraseña de acceso
define("PASV",true); //Activa modo pasivo



# FUNCIONES

function ConectarFTP(){
//Permite conectarse al Servidor FTP
$id_ftp=ftp_connect(SERVER,PORT); //Obtiene un manejador del Servidor FTP
ftp_login($id_ftp,USER,PASSWORD); //Se loguea al Servidor FTP
ftp_pasv($id_ftp, TRUE); //Establece el modo de conexión
return $id_ftp; //Devuelve el manejador a la función
}

function SubirArchivo($archivo_local,$archivo_remoto){
//Sube archivo de la maquina Cliente al Servidor (Comando PUT)
$id_ftp=ConectarFTP(); //Obtiene un manejador y se conecta al Servidor FTP
ftp_put($id_ftp,$archivo_remoto,$archivo_local,FTP_BINARY);
//Sube un archivo al Servidor FTP en modo Binario
ftp_quit($id_ftp); //Cierra la conexion FTP
}

function ObtenerRuta(){
//Obriene ruta del directorio del Servidor FTP (Comando PWD)
$id_ftp=ConectarFTP(); //Obtiene un manejador y se conecta al Servidor FTP
$Directorio=ftp_pwd($id_ftp); //Devuelve ruta actual p.e. "/home/willy"
ftp_quit($id_ftp); //Cierra la conexion FTP
return $Directorio; //Devuelve la ruta a la función
}



if(!empty($_POST["archivo"])){ //Comprueba si la variable "archivo" se ha definido
SubirArchivo($_POST["archivo"],basename($_POST["archivo"]));
//basename obtiene el nombre de archivo sin la ruta
unset($_POST["archivo"]); //Destruye la variable "archivo"
}
?>
<strong><font color="#000000" size="3">Subir Archivo</font></strong></font></p>
<hr />

<!--Formulario para elejir el archivo a subir -->
<form action="" method="post" name="form_ftp" id="form_ftp" enctype="multipart/form-data">
<p><font size="2" face="Verdana, Tahoma, Arial"> Elegir archivo :
<input name="archivo" type="file" id="archivo" />
<input name="Submit" type="submit" value="Subir Archivo" />
</font><font size="2" face="Verdana, Tahoma, Arial"> </font> </p>
</form>

<hr />
<p><font face="Verdana, Tahoma, Arial"><strong><font color="#000000" size="3">
Lista de Archivos
</font></strong></font></p>
<table width="69%" border="1" cellspacing="0" cellpadding="0">
<tr>
<td width="48%"><div align="center"><font size="2" face="Verdana, Tahoma, Arial"><strong>Nombre</strong></font></div></td>
<td width="22%"><div align="center"><font size="2" face="Verdana, Tahoma, Arial"><strong>Tama&ntilde;o</strong></font></div></td>
<td width="30%"><div align="center"><font size="2" face="Verdana, Tahoma, Arial"><strong>Fec.
Modificaci&oacute;n</strong></font></div></td>
</tr>

<?php
$id_ftp=ConectarFTP(); //Obtiene un manejador y se conecta al Servidor FTP
$ruta=ObtenerRuta(); //Obtiene la ruta actual en el Servidor FTP
echo "<b>El directorio actual es: </b> ".$ruta;
$lista=ftp_nlist($id_ftp,$ruta); //Devuelve un array con los nombres de ficheros
$lista=array_reverse($lista); //Invierte orden del array (ordena array)
while ($item=array_pop($lista)) //Se leen todos los ficheros y directorios del directorio
{
	$tamano=number_format(((ftp_size($id_ftp,$item))/1024),2)." Kb";
	//Obtiene tamaño de archivo y lo pasa a KB
	if($tamano=="-0.00 Kb") // Si es -0.00 Kb se refiere a un directorio
	{
		$item="<i>".$item."</i>";
		$tamano="&nbsp;";
		$fecha="&nbsp;";
	}else{
	$fecha=date("d/m/y h:i:s", ftp_mdtm($id_ftp,$item));
	}
//Filemtime obtiene la fecha de modificacion del fichero; y date le da el formato de salida
}
?>

<tr>
<td><font size="2" face="Verdana, Tahoma, Arial"><? echo $item ?></font></td>
<td align="right"><font size="2" face="Verdana, Tahoma, Arial"><? echo $tamano ?></font></td>
<td align="right"><font size="2" face="Verdana, Tahoma, Arial"><? echo $fecha ?></font></td>
</tr>
<? } ?>
</table>
</body>
</html>