<?php
//include ("./unica/seguridad.php");
include ("./unica/body_head.php");
include ("./unica/body_menu.php");
// contenido:
?>
<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion = 'ap20';
echo "<h5>".app_detalle($id_aplicacion)."</h5>";
echo "<div id='actualizaciones'>";
$nivel = aplicaciones_nivel($nitavu);

echo "<p>";
if ($nivel==1) {
	echo "Bienvenido! Estas autorizado para ver los detalles tecnicos de las actualizaciones:<br>";
}
else
{
	echo "Estas son las actualizaciones que hemos realizado actualmente:";
}
echo "</p>";

$sql = "SELECT * FROM aplicaciones ORDER by idapp ASC";
$r = $conexion -> query($sql);
while($f2 = $r -> fetch_array())
{//Aplicaciones
//$tmp_ap = "<h5><label>".$f2['idapp']." </b> ".$f2['nombre']."</label></h5>";
$tmp_ap = "<br><h5>".app_detalle($f2['idapp'])."</h5> <A name='".$f2['idapp']."'></A>";

		$sql = "SELECT * FROM aplicaciones_historia  WHERE (idapp='".$f2['idapp']."')ORDER by idapp, version ASC";
		$r2 = $conexion -> query($sql);
		$d_us="";
		$tmp_actualizaciones="";
		$tmp = "";
		$tmp_actualizaciones = "
		<table border='0' class='tabla'>
		<tr class='tabla_titulo'>
		<td width='10px'> Imagen Ilustrativa</td>
		<td width='50px'> Version </td>
		<td width='50px'> Fecha </td>
		<td> Descripcion </td>
		
		</tr>

		";
		$c = 0;
		while($f = $r2 -> fetch_array())
			{//Categorias de Aplicaciones

				$tmp_actualizaciones = $tmp_actualizaciones.
		 		"<tr class='tabla_tr'>"."<td >".ponerfoto_app($f['archivofoto'].".jpg",'icono')."</td>".
		 		"<td>".$f['version']."</td>"."<td>".$f['fecha_lanzamiento']."</td>"."<td><cite class='tchico'>".$f['descripcion_us']."</cite>";

		 		if ($nivel==1) {
		 			$tmp_actualizaciones = $tmp_actualizaciones."<br><br><b class='normal'>Descripcion Tecnica: </b><b class='tenue tchico'>".$f['descripcion_tec']."</b><br>";
		 			$tmp_actualizaciones = $tmp_actualizaciones."Autor de la actualizacion:<br><b class='normal'>".nitavu_nombre($f['autor'])."</b>";	
		 			$tmp_actualizaciones = $tmp_actualizaciones."<br><b class='tenue tchico'>".nitavu_puesto($f['autor'])." ".dpto_id(nitavu_dpto($f['autor']))."</b>";	
		 		}
		 		$tmp_actualizaciones = $tmp_actualizaciones."</td>"."</tr>";
		 		
		 		$c = $c +1;
			
			}

		$tmp_actualizaciones = $tmp_actualizaciones."</table>";
		if ($c>0){ // tiene actualizaciones la aplicacion
			echo $tmp_ap;
			echo $tmp_actualizaciones."<br>";
			echo $tmp_actualizaciones = "";

		}


}

echo "</div>";



?>
<br><br>
<?php
include ("./unica/body_footer.php");
?>