<?php
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
?>
<?php
if (isset($_GET['busqueda'])){
$search = $_GET['busqueda'];
}
else {
	$search = "";
}
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
// echo $sql;
	$r = $conexion -> query($sql);
$r_count = $r -> num_rows;
if ($r_count<=0){ // en caso de haya resultados, hacer uno nuevo
	
	historia($nitavu,'Busqueda fallida de '.$search);

	$msg="Lo sentimos no se han encontrado resultados sobre <b>".$search."</b>";
	$msg = $msg." Vuelva a intentarlo utilizando otras palabras de busqueda";
	mensaje($msg,"empleados.php?search=");


}else{
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
	echo "<div id='AppDetalle'><br>Resultados ".$r_count. " sobre <b>[ ".$search." ]</b>, agrupados de ".$paginacion." </div>";
	$paginas = intval(($r_count / $paginacion));

	historia($nitavu,'Busqueda de '.$search);

	echo "<div id='r'>";
	
			while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
			echo "<div id='resultado_elemento '>";

			if ($f['estado']<>''){echo "<table border='0' class='tabla alerta' width='100%'><tr>";}
			else {echo "<table border='0' class='tabla'  width='100%'><tr>";}
			
					echo "<td width='5px'>";
						echo ponerfoto("fotos/".$f['nitavu'].".jpg",'foto_busqueda');
					echo "</td>";			
					echo "<td width='50px' class='tipo_nitavu pc'><span class='pc'>".$f['nitavu']."</span></td>";			
					echo "<td  class=''>";
					echo "<span class='pc'>".$f['profesion_abr']." ".$f['nombre']."</span>";
					echo "<span class='movil'>".nombre_corto($f['nitavu'],0)."<span class='normal tmediano'> ".$f['puesto']." </span><span class='tenue tmediano'>".$f['departamento']."</span></span>";
					


					echo "<span class='pc tchico'><br>".$f['puesto']." de ".$f['departamento']." en ".$f['ciudad']."</span>";
					if ($f['estado']<>''){ echo "<br>Estado Laboral: ".$f['estado'];}
					echo "</td>";

					echo "<td width='10px'><a href='directorio.php?nombre=".$f['nombre']."'><img src='icon/dirtel.png' class='icono_dir'></a>";

					echo "</td>";



					echo "<td width='10px' align='right' class='tipo_menu'>";
					echo "<a href='empleados_edit.php?pes=gral&n=".$f['nitavu']."'><img src='icon/entrar.png' class='icono'></a>";
					echo " </td>";
			
			echo "</tr></table>";
			echo "</div>";

			
			}
	
	echo "</div>";

	
	if ($r_count >= $paginacion){
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
				echo "<span id='pagina_proxima'><a href='?busqueda=".$search."&p=".$i."'>".$i."</a></span>"; //CSS span a = link a paginas
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
	include ("./lib/body_footer.php");
	?>