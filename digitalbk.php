<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>







<?php 
$idapp="";
$idapp_nombre="Digitalizacion";
//historia($nitavu, "Vio ".$idapp_nombre);
$nivel=2;


if (isset($_GET['busqueda'])){
	echo "<h1>Estas buscando <b class='ejecutandose'>".$_GET['busqueda']."</b>.</h1> "; 	


$sql = "
SELECT
	solicitudes.IdSolicitante,
	solicitantes.Nombre,
	solicitantes.Paterno,
	solicitantes.Materno,
	solicitantes.Curp,
	solicitudes.IdDelegacion,
	solicitudes.IdPrograma,
	solicitudes.Folio,
	contratos.NumContrato
FROM
	solicitudes
LEFT OUTER JOIN contratos ON solicitudes.IdDelegacion = contratos.IdDelegacion
AND solicitudes.IdPrograma = contratos.IdPrograma
AND solicitudes.Folio = contratos.Folio
LEFT OUTER JOIN solicitantes ON solicitudes.IdSolicitante = solicitantes.IdSolicitante
WHERE
	(solicitudes.Folio = '".$_GET['busqueda']."')

";
	//echo $sql;
	//$sql = "select * from empleados where nombre like'%".$_GET['busqueda']."%'";
	$r = $conexion -> query($sql);	
	$c = $r -> num_rows;


	if ($c<=0){//si no esta presente una busqueda mostrar buscar
		echo '<div class ="centrar_mensaje_padre"><div class = "centrar_mensaje_hijo">';
		echo "<br> No se han encontrado nada con las palabras que usaste - ".$_GET['busqueda']." - "."<a href='digital.php'>Buscar nuevamente.</a>";
		echo "</div></div>";
	}	
	else {
		
		$encontrados = "
		<table class='tabla' border='0'>		
		<th>Folio</th>
		<th>Contrato</th>
		<th>Nombre</th>
		<th>Delegacion</th>
		<th>Programa</th>

		<th></th>
		";
		while($d = $r -> fetch_array())
		{
			//$foto= ponerfoto("fotos/".$d['nitavu'].".jpg",'icono'); 
			$doc = "<tr>";
			$doc = $doc."<td>".$d['Folio']."</td>";
			$doc = $doc."<td>".$d['NumContrato']."</td>";
			$doc = $doc."<td>".$d['Nombre']." ".$d['Paterno']." ".$d['Materno']."</td>";
			$doc = $doc."<td>".$d['IdDelegacion']."</td>";
			$doc = $doc."<td>".$d['IdPrograma']."</td>";
			$doc = $doc."<td width='110px'>";
			
			if ($nivel<=3){	$doc = $doc."<a href='' ><img src='icon/ver.png' class='icono_lista'></a>";}
			if ($nivel<=2){	$doc = $doc."<a href='' ><img src='icon/editar.png' class='icono_lista'></a>";}
			if ($nivel<=2){	$doc = $doc."<a href='' ><img src='icon/renovar.png' class='icono_lista'></a>";}
			
			$doc = $doc."</td>";
			$doc = $doc."</tr>";
			
			$encontrados=$encontrados.$doc;

		}
		$encontrados = $encontrados."</table>";

		echo "<section id='digitales'>";
		echo $encontrados;
		echo "</section>";

	}





}
else
{	echo '<div class ="centrar_mensaje_padre"><div class = "centrar_mensaje_hijo">';
	buscar('digital.php','FOLIO:','');
	echo "</div></div>";
	
}



?>

















<?php include ("./lib/body_footer.php"); ?>