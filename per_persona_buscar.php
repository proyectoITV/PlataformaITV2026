<?php
//include (".//seguridad.php");
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
// contenido:
?>


<?php
$id_aplicacion ="ap54"; //ap07=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	

$search = $_GET['busqueda'];



// //consulta sin LIMIT
		$sql = " -- SOL 

		SELECT * from solicitantes ";	
		$sql = $sql."WHERE ";
		//$sql = $sql."rq.IdEstatus <> 6 AND ";
		$sql = $sql."(Nombre LIKE '%".$search."%') OR ";
		$sql = $sql."(Paterno LIKE '%".$search."%') OR ";
		$sql = $sql."(Materno LIKE '%".$search."%') OR ";
		$sql = $sql."(CONCAT( Nombre,  ' ', Paterno,' ', Materno ) LIKE '%".$search."%')  ";	 
		//$sql = $sql."GROUP BY Nombre ASC";
//echo $sql;

		 echo "<br><br>";
	$r = $conexion -> query($sql);
$r_count = $r -> num_rows;
if ($r_count<=0)
	{ // en caso de haya resultados, hacer uno nuevo
	
	historia($nitavu,'Per_Busqueda fallida de '.$search);

	$msg="Lo sentimos no se han encontrado resultados sobre <b>".$search."</b>";
	$msg = $msg." Vuelva a intentarlo utilizando otras palabras de busqueda";
	mensaje($msg,"per_personas.php?search=");


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
	$empezar_desde = ($pagina-1) * $paginacion;
	// agregamos limite a la consulta
	$sql = $sql." LIMIT ".$empezar_desde.", ".$paginacion;
	//echo $sql;
		$r = $conexion -> query($sql);
	echo "<div id='AppDetalle'>Resultados ".$r_count. " sobre <b>[ ".$search." ]</b>, agrupados de ".$paginacion." </div>";
	$paginas = intval(($r_count / $paginacion));

	historia($nitavu,'Per_Busqueda de '.$search);

	echo "<div id='r'>";
	
			while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
			echo "<div id='resultado_elemento '>";


			
				echo "<table border='0' class='tabla'  width='100%'><tr>";
			
			
					// echo "<td width='5px'>";
					// 	echo ponerfoto("fotos/".$f['nitavu'].".jpg",'foto_busqueda');
					// echo "</td>";			
					// echo "<td width='50px' class='tipo_nitavu pc'><span class='pc'>".$f['IdSolicitante']."</span></td>";			
					echo "<td  class=''>";
					//echo "<span class='pc'>".$f['Nombre']." ".$f['Paterno']."</span>";
					echo "<span class='normal tmediano'>".$f['Nombre']." ".$f['Paterno']." ".$f['Materno']."</span>";
					// echo "<span class='movil'>".nombre_corto($f['nitavu'],0)."<span class='normal tmediano'> ".$f['puesto']." </span><span class='tenue tmediano'>".$f['departamento']."</span></span>";


					echo "<span class='pc tchico'><br>".$f['FNacimiento']."</span>";
					echo "</td>";

				



					echo "<td width='10px' align='right' class='tipo_menu'>";
					echo "<a href='per_persona_editar.php?pes=gral&n=".$f['IdSolicitante']."'><img src='icon/entrar.png' class='icono'></a>";
					echo " </td>";
			
			echo "</tr></table>";
			echo "</div>";

			
			}
	
	echo "</div>";

	
	if ($r_count >= $paginacion)
	{
	echo "<center><div id='barra_paginacion'>";
		echo "Paginas: ";
			//Crea un bucle donde $i es igual 1, y hasta que $i sea menor o igual a X, a sumar (1, 2, 3, etc.)
			//Nota: X = $total_paginas
			for ($i=1; $i<=$paginas; $i++) {
				//En el bucle, muestra la paginación
				if ($pagina==$i)
				{
					echo "<span id='pagina_actual'>".$pagina."</span>"; //para el CSS span = a pagina actual
				}
				else
				{
					echo "<span id='pagina_proxima'><a href='?search=".$search."&p=".$i."'>".$i."</a></span>"; //CSS span a = link a paginas
				}
			}
	echo "</div></center>";
	}
	}
			}else
{
echo "<br><br>";
	mensaje("No tiene acceso al modúlo de personas beneficiadas (".$id_aplicacion.")", "index.php");}
	?>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<?php
	include ("./lib/body_footer.php");
	?>