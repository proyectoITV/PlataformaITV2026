<?php
include ("./unica/seguridad.php");
include ("./unica/body_head.php");
include ("./unica/body_menu.php");
// contenido:
?>






<?php
$search = $_GET['search'];
//consulta sin LIMIT
$sql = "SELECT * FROM empleados WHERE ";
$sql = $sql."(nombre LIKE '%".$search."%') OR ";
$sql = $sql."(nitavu LIKE '%".$search."%') OR ";
$sql = $sql."(departamento LIKE '%".$search."%') OR ";
$sql = $sql."(puesto LIKE '%".$search."%') OR ";
$sql = $sql."(direccion LIKE '%".$search."%') OR ";
$sql = $sql."(sap LIKE '%".$search."%') OR ";
$sql = $sql."(nivel LIKE '%".$search."%') OR ";
$sql = $sql."(ciudad LIKE '%".$search."%')";
$sql = $sql."ORDER by nombre ASC";
//echo $sql;
	$r = $conexion -> query($sql);
$r_count = $r -> num_rows;
if ($r_count<=0)
	{ // en caso de haya resultados, hacer uno nuevo
	echo "<h5>No hubo resultados sobre <b>[ ".$search." ]</b>. PUEDE AGREGARLO DESDE AQUI:</h5>";
		
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
	echo "<h5>Resultados ".$r_count. " sobre <b>[ ".$search." ]</b>, agrupados de ".$paginacion." </h5>";
	$paginas = intval(($r_count / $paginacion));
	echo "<div id='resultados'>";
			echo "<table border='0' class='pc'>
					<tr class='titulos'>
							<td>N. Itavu </td>
							<td>SAP </td>
							<td>Nombre</td>
							
							<td>Departamento</td>
							<td>Puesto</td>
							<td>Nivel</td>
							<td>Ciudad</td>
							<td>Acciones</td>
					</tr>";
			
			while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
			
				echo "<span class='pc'>";
					echo "<tr>";
						echo "<td>".$f['nitavu']."</td>";
						echo "<td >".$f['sap']."</td>";
						echo "<td>".$f['nombre']."</td>";
						//echo "<td >".$f['direccion']."</td>";
						echo "<td >".$f['departamento']."</td>";
						echo "<td>".$f['puesto']."</td>";
						echo "<td >".$f['nivel']."</td>";
						echo "<td>".$f['ciudad']."</td>";
						echo "<td>";
						echo "</td>";
					echo "</tr>";
				echo "</span>";

				//resultados para  moviles
				echo "<span class='movil'>";
				echo "<article>";
						echo "<img src='./icon/user.png' class='icono' align='center'><br>";
						echo "<b>".$f['nombre']."</b><br>";
						echo "<em>".$f['puesto']."</em>";
						echo "<label>".$f['direccion']." de ".$f['departamento']."</label>";
						echo "<label>".$f['ciudad'].", Tamaulipas</label>";
				echo "</article></span>";
				
			}
			echo "<div class='pc'></table></div>";
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
	?>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<?php
	include ("./unica/body_footer.php");
	?>