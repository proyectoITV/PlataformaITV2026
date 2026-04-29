<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>


<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap31"; //ap07=Permisos de Aplicacion
//if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	//echo renombrarimagenes('fotos');
	//echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";


	//$n=$_GET['n'];//var con la que nos manda la busqueda y nos indica que numero de itavu tiene
	//$sql = "SELECT * FROM empleados ORDER by fecha_nacimiento ASC";
	
	//cumples de este mes
	$sql = "
	SELECT
	* 
FROM
	empleados 
WHERE
	DATE_FORMAT(fecha_nacimiento, '%m' ) = DATE_FORMAT(now( ), '%m' ) 
ORDER BY
	DATE_FORMAT(fecha_nacimiento, '%d' )
	
	";
	// echo $sql;
	//$r_count = $r -> num_rows;
	

	$r = $conexion -> query($sql);
	echo "<table border='0' class='tabla'>";
	echo "<tr><td></td>";

	echo "<td> NOMBRE </td>";
	echo "<td> CUMPLEAÑOS </td>";
	echo "<td>  </td>";
	echo "</tr>";


	while($f = $r -> fetch_array())
		{ // resultado de la busqueda.................

		$nacimiento = $f['fecha_nacimiento'];
		$edad = edad($nacimiento) + 1;
		$fcumple = date("Y").substr($nacimiento, -6);
		$x="";	
		if ($fcumple==$fecha){
				echo "<tr class='ejecutandose'>";
				echo " <td width='40px'> ";
				echo ponerfoto("fotos/".$f['nitavu'].".jpg",'icono_cumple');
				echo "</td>";
				$x=" Hoy";
		}
		else
		{
				echo "<tr>";
				echo " <td width='40px'>";
				echo ponerfoto("fotos/".$f['nitavu'].".jpg",'icono');
				echo "</td>";
		}
			


			echo "<td> <b class='tmediano normal'>".nombre_corto($f['nitavu'],0)."</b> ".nombre_corto($f['nitavu'],1)."";
			echo "<span class='tenue'> ".$f['puesto']." de ".$f['departamento']."</span>";
			echo " </td>";
			
			//echo "<td> Nacio un ".fecha_larga($f['fecha_nacimiento']).", ".$x." cumple ".tantos($edad)." años ";
			echo "<td> Nacio un ".fecha_larga_cumple($f['fecha_nacimiento']).".";
			
			
			echo "</td>";






			echo "<td>";
			if ($fcumple>=$fecha){
			echo "<a href='documentar.php?g=&id=".$f['nitavu']."&a=FELICIDADES&f=".$fcumple."'>FELICITAR</a>";
			}
			echo "</td>";
			//echo "<td>".$edad."</td>";
			echo "</tr>";
			
		}
	echo"</table>";

historia($nitavu, "Vio la Lista de Cumpleaños");
//}
// else{
// 	mensaje("No tiene acceso a esta aplicacion","");
// }











?>





<?php
include ("./lib/body_footer.php");
?>