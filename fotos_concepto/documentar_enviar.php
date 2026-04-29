<?php
include ("./unica/validas_raiz.php");
?>

<?php


$destino_nitavu = $_POST['empleado'];
$destino_nitavu1 = $_POST['empleado_copia1'];
//$destino_nitavu2 = $_POST['empleado_copia2'];
$contenido = $_POST['contenido'];
$autor = $_POST['nitavu_'];
$asunto = $_POST['asunto'];
$entregar_fecha = $_POST['entregar_fecha'];

if (valida_fecha($entregar_fecha)==TRUE) {
	$sql="";
	$msg2="";
	$copias= 0;
	$no = docdigital_no(TRUE, $copias);

	$contenido = str_replace('"',"",$contenido); //extrae las " del contenido, y gracias al html5 no son necesarias en <a href=viculo o en src=archivo

	if ($destino_nitavu1<>'') {
		//echo 'copia para '.$destino_nitavu1;
		$copias = $copias + 1;
		
		$contenido2= "".$contenido;
		$sql = "INSERT INTO notificaciones(nitavu, asunto, entregar_fecha, contenido, nitavu_manda, no_oficio) VALUES ('$destino_nitavu1', '$asunto', '$entregar_fecha', '$contenido2', '$autor', '$no');";
		//echo $sql;
		if ($conexion->query($sql) == TRUE) 
		{$msg2="  ".user_legend($destino_nitavu1).", ";
		historia($autor, "Envio documento electronico a ".nitavu_nombre($destino_nitavu1)."");
		} 
		else {
		$msgE="Error inesperado al entregar copia 1 ".$sql;} 

	}


	// if ($destino_nitavu2<>'') {
	// 	//echo 'copia para '.$destino_nitavu2;
	// 	$copias = $copias + 1;
	// 	$contenido2= "".$contenido;
	// 	$sql = "INSERT INTO notificaciones(nitavu, asunto, entregar_fecha, contenido, nitavu_manda, no_oficio) VALUES ('$destino_nitavu2','$asunto', '$entregar_fecha', '$contenido2', '$autor', '$no');";
	// 	if ($conexion->query($sql) == TRUE) 
	// 	{$msg2= $msg2. " y ".user_legend($destino_nitavu2).", "; historia($nitavu, "Envio documento electronico a ".nitavu_nombre($destino_nitavu2)."");} 
	// 	else {
	// 	$msgE="Error inesperado al entregar copia 2 ".$sql;} 
	// }


	$copias = $copias + 1; //almacena cuantas hojas se ocuparian
	$copias = $copias * 2; // ya que se ocupa una copia cuando se recibe fisicamente el documento

	$no = docdigital_no(FALSE, $copias);
	$sql = "INSERT INTO notificaciones(nitavu, asunto, entregar_fecha, contenido, nitavu_manda, no_oficio) VALUES ('$destino_nitavu', '$asunto', '$entregar_fecha', '$contenido', '$autor', '$no')";

	if ($conexion->query($sql) == TRUE) 
		{$msg = "Se ha entregado con exito el documento con numero de oficio ".$no." que ha enviado a ".user_legend($destino_nitavu)." y ".$msg2; historia($autor, "Envio documento electronico a ".nitavu_nombre($destino_nitavu)."");
		mensaje ($msg,'');
		} 
	else {
		$msgE="Error inesperado ".$sql;} 
		
}
else
{
	mensaje("Fecha introducida incorrectamente",'');	
}
?>