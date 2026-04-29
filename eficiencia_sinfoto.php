<?php
//include (".//seguridad.php");
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
// contenido:
?>






<?php
//$search = $_GET['search'];
//consulta sin LIMIT
$id_aplicacion ="ap16"; //ap07=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
		xd_update('ap16',$nitavu);//guarda la experiencia del usuario
		historia($nitavu, "Entro a la aplicacion [ap16], para ver quienes les falta fotografia para su expediente digital ");

$sql = "SELECT * FROM empleados   ORDER by nombre ASC";

//echo $sql;
$r = $conexion -> query($sql);
$r_count = $r -> num_rows;
if ($r_count<=0)
	{ // en caso de haya resultados, hacer uno nuevo
	
	$msg="EXCELENTE! Actualmente todos los empleados tienen foto.";
	$msg = $msg."siga asi!";
	mensaje($msg,"");


	}
else
{
	/// PARA PAGINAR
	//Comprueba si está seteado el GET de HTTP
	if (isset($_GET["p"])) {
		//Si el GET de HTTP SÍ es una string / cadena, procede
		if (is_string($_GET["p"])) {
			//Si la string es numérica, define la variable 'pagina'
			if (is_numeric($_GET["p"])) {
				//Si la petición desde la paginación es la página uno
				//en lugar de ir a 'index.php?pagina=1' se iría directamente a 'index.php'
					$pagina = $_GET["p"];
				
			} else { //Si la string no es numérica, redirige al index (por ejemplo: index.php?pagina=AAA)
				header("Location: ./index.php");
				die();
			};
		};
	} else { //Si el GET de HTTP no está seteado, lleva a la primera página (puede ser cambiado al index.php o lo que sea)
		$pagina = 1;
	};
	//Define el número 0 para empezar a paginar multiplicado por la cantidad de resultados por página
	//$empezar_desde = ($pagina-1) * $paginacion;
	$empezar_desde = ($pagina-1) * 100;
	// agregamos limite a la consulta
	$sql = $sql."";
	//echo $sql;
		$r = $conexion -> query($sql);
	echo "<div id='AppDetalle'>Estos son los empleados que no tienen foto:</div>";
	$paginas = intval(($r_count / $paginacion));

	historia($nitavu,'Vio cuantos que  '.$r_count.' empleados no tenian foto');

	echo "<div id='r'>";
	
			while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................

	
			
					
					$archivo = "fotos/".$f['nitavu'].".jpg";
					if (file_exists($archivo)){
						//echo '<a href="'.$archivo.'"><img src="'.$archivo.'" class="'.$clase.'"></a>';
					}
					else
					{ // no tiene foto.
						echo "<div id='resultado_elemento'>";
						echo "<table border='0'>";
						echo "<tr><td width='10px'>";
						echo ponerfoto("fotos/".$f['nitavu'].".jpg",'icono');
						echo "</td>";			
						echo "<td width='50px' class='tipo_nitavu'><span class='pc'>".$f['nitavu']."</span></td>";			
						echo "<td width='300px' class='tipo_nombre'>".$f['profesion_abr']." ".$f['nombre']."</td>";
						echo "<td  class='tipo_detalle'><span class='pc'>".$f['puesto']." de ".$f['departamento']." en ".$f['ciudad']."";
						echo "<br> Tel: ".$f['telefono']." ext:".$f['telefono_extension'].", ".$f['telefono2'].", Celular: ".$f['telefono_movil'];
						echo "<br> Correo electronico: ".$f['correoelectronico'];
						echo "</span> </td>";
						echo "<td width='10px' align='right' class='tipo_menu'>";
						echo "<a href='empleados_edit.php?n=".$f['nitavu']."'><img src='icon/entrar.png' class='icono'></a>";
						echo " </td>";
						echo "</tr>";
						echo "</table>";
						echo "</div>";
						
					}
					
					
			

			

			
			}
	
	echo "</div>";

		historia($nitavu, "Vio quienes no tienen foto");
	}

}
else{
	mensaje("no tiene acceso",'');
}	
	?>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<?php
	include ("./lib/body_footer.php");
	?>