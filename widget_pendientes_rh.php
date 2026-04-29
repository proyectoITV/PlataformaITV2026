<?php


//WIDGET PROTOTIPO



$Widget_contenido="";
$empleados_sindpto_quienes="";
$pendientes=0;
//require("config.php");
$sql = "SELECT * FROM empleados WHERE dpto='' and estado=''";
$rc= $conexion -> query($sql);
$empleados_sindpto = $rc -> num_rows;
while($m = $rc -> fetch_array()) {
		$empleados_sindpto_quienes = $empleados_sindpto_quienes."<a href='empleados_edit.php?pes=lab&n=".$m['nitavu']."' title='".$m['nombre']." (".$m['departamento'].")'>";
		$empleados_sindpto_quienes = $empleados_sindpto_quienes.$m['nitavu']."</a>, ";
}



$empleados_sindomicilio_quienes="";

//require("config.php");
$sql = 'SELECT * FROM empleados WHERE (domicilio_calle = "") OR (LENGTH(domicilio_calle) <= 1) and estado=""';
$rc= $conexion -> query($sql);
$empleados_sindomicilio = $rc -> num_rows;
while($m = $rc -> fetch_array()) {
		$empleados_sindomicilio_quienes = $empleados_sindomicilio_quienes."<a href='empleados_edit.php?pes=lab&n=".$m['nitavu']."' title='".$m['nombre']." (".$m['departamento'].")'>";
		$empleados_sindomicilio_quienes = $empleados_sindomicilio_quienes.$m['nitavu']."</a>, ";
}


$sinhorario="";
//require("config.php");
$sql = 'SELECT * FROM empleados WHERE (horario_entrada="00:00:00" OR horario_salida="00:00:00") and estado=""';
$rc= $conexion -> query($sql);
$empleados_sinhorario = $rc -> num_rows;
while($m = $rc -> fetch_array()) {
		$sinhorario = $sinhorario."<a href='empleados_edit.php?pes=lab&n=".$m['nitavu']."' title='".$m['nombre']." (".$m['departamento'].")'>";
		$sinhorario = $sinhorario.$m['nitavu']."</a>, ";
}


$sincomida="";
//require("config.php");
$sql = 'SELECT * FROM empleados WHERE (comida<>"00:30:00" ) and estado=""';
$rc= $conexion -> query($sql);
$empleados_sincomida = $rc -> num_rows;
while($m = $rc -> fetch_array()) {
		$sincomida = $sincomida."<a href='empleados_edit.php?pes=lab&n=".$m['nitavu']."' title='".$m['nombre']." (".$m['departamento'].")'>";
		$sincomida = $sincomida.$m['nitavu']."</a>, ";
}


	
$pendientes = $pendientes + $empleados_sindomicilio;
$pendientes = $pendientes + $empleados_sindpto;
$pendientes = $pendientes + $empleados_sincomida;
$pendientes = $pendientes + $empleados_sinhorario;

if ($pendientes>0) {
	$Widget_nombre="<b class='ejecutandose'> ".$pendientes." ALERTAS </b>: para RH";
		
	$Widget_contenido= $Widget_contenido."<span class='tchico'>Actualizacion pendiente: <b class='normal'>(TIP: poner el cursor sobre los numeros de la lista, indica el nombre del empleado)</b> <span><lu>";


	if ($empleados_sincomida>0){
			$Widget_contenido= $Widget_contenido."<li>Hay ".$empleados_sincomida." empleados con tiempo de comida superior a 30min:"."<br><label>
			(".$sincomida.")</label></li>";
	}


	if ($empleados_sinhorario>0){
			$Widget_contenido= $Widget_contenido."<li>Faltan ".$empleados_sinhorario." sin su horario configurado:"."<br><label>
			(".$sinhorario.")</label></li>";
	}

	if ($empleados_sindpto>0){
			$Widget_contenido= $Widget_contenido."<li>Hay ".$empleados_sindpto." empleados sin dpto:"."<br><label>
	 		(".$empleados_sindpto_quienes.")</label></li><br><br>";

	}
	
	if ($empleados_sindomicilio>0){
			$Widget_contenido= $Widget_contenido."<li>Hay ".$empleados_sindomicilio." empleados sin domiclio:"."<br><label>
			(".$empleados_sindomicilio_quienes.")</label></li>";
	}
	

	$Widget_contenido= $Widget_contenido."</lu>";

}
else
{
	$Widget_nombre="PENDIENTES RH solicitados por Dpto. de Informatica";
	$Widget_contenido = "<b class='ejecutandose'>EXCELENTE!</b> No hay pendientes";
}




$tmp="";
$tmp = $tmp."<section id='aplicaciones' class='widget'>";
$tmp = $tmp. "<label>".$Widget_nombre."</label>";
$tmp = $tmp."<article >";
$tmp = $tmp. "<a href=''>";
$tmp = $tmp. "<table border='0'><tr><td>";
$tmp = $tmp.$Widget_contenido;
$tmp = $tmp. "</td></tr></table></a></article>";

echo $tmp."</section>";
//echo $tmp."</section>";
?>

