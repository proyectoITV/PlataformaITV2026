<?php	include("config/html_head.php"); ?>


<?php //BARRA DE MENU
include("config/html_menu.php"); ?>

<?php
$id_aplicacion='ap3'; $nivel = aplicacion_nivel($id_aplicacion, $nuc);	
if (sanpedro($id_aplicacion,$nuc)==TRUE){
if (isset($_GET['nuevo'])){ //usario seleccionado
echo "cliente nuevo";


} else {

	if (isset($_GET['x'])){ //usario seleccionado
		echo "Se ha seleccionado, cliente con CURP: <b> ".$_GET['x']."</b>";
		$sql = "SELECT * FROM clientes WHERE curp='".$_GET['x']."'";
		$rc= $conexion -> query($sql);
		if($cl = $rc -> fetch_array())
		{//mostrar pantalla para actualizar datos del cliente
			echo "<form action='clientes.php' method='post'>";
			echo "<div><label>CURP: </label><input type='text' name='curp' readonly value='".$cl['curp']."'></div>";
			echo "<div><label>Nombre del cliente:</label><input type='text' name='nombre' value='".$cl['nombre']."'></div>";
			echo "<div><label>Fecha de Nacimiento:</label><input type='date' name='nacimiento' value='".$cl['fechadenacimiento']."'></div>";
			echo "<div><label>Domicilio: </label><input type='text' name='domicilio' value='".$cl['domicilio']."'></div>";
			echo "<div><label>Municipio</label><input type='text' name='municipio' value='".$cl['municipio']."'></div>";
			echo "<div><label>Estado</label><input type='text' name='estado' value='".$cl['estado']."'></div>";
			echo "<div><label>IFE:</label><input type='text' name='IFE' value='".$cl['IFE']."'></div>";
			echo "<div><label>Telefono</label><input type='text' name='telefono' value='".$cl['telefono']."'></div>";
			echo "<div><input type='submit' name='submit_act' value='Guardar' class='btn btn-default'></div>";
			
			echo "</form>";

			if (isset($_POST['submit_act'])){//guardar actualizacion
				$sql="UPDATE clientes SET 
				nombre='".$_POST['nombre']."',
				ife='".$_POST['IFE']."',
				domicilio='".$_POST['domicilio']."',
				municipio='".$_POST['municipio']."',
				estado='".$_POST['estado']."'

				WHERE curp='".$_POST['curp']."'";
				//$r = $conexion -> query($sql);
				if ($conexion->query($sql) == TRUE) {
				return $f['nfoto'];
				}
	

			}

		}
		else {
			historia($nuc, "ERROR: ".$sql);
			mensaje("Ha habido un error, cliente no se encontro",'','error');
		}
		

	} else {
	if (isset($_GET['q'])){	//ejecutamos la consulta
		$sql = "SELECT * FROM clientes WHERE nombre like'%".$_GET['q']."%' ";
		historia($nuc,$sql);
		historia($nuc,"busco a ".$_GET['q']);
		$r2= $conexion -> query($sql);
		echo "<h3>Resultados de <b style='color: #64002B;'>".$_GET['q']."</b>:</h3>";
		echo "<table class='tabla'>";
		echo "<th class='pc' width=200px>CURP</th>";
		echo "<th>Nombre</th>";
		echo "<th></th>";
		$c=0;
		while($fr = $r2 -> fetch_array())
		{
			echo "<tr>";
			echo "<td class='pc'>".$fr['curp']."</td>";
			echo "<td><b>".$fr['nombre']."</b><br><span style='font-size:8pt;'>".$fr['domicilio']."</span><span class='pc' style='font-size: 8pt; color:#64002B;'> | ".$fr['telefono']."</span></td>";
			echo "<td width=50px>"; //acciones
				echo "<a class='btn btn-default' style='display:block;' href='?x=".$fr['curp']."' style='text-decoration:none '><img src='icon/entrar.png'></a>";
			echo "</td>";

			echo "</tr>";
			$c = $c +1 ;

		}
		echo "</table>";

		echo "<hr>";
		echo "<p>Si no encontro al cliente, puede <a class='btn btn-default' href='clientes.php?nuevo='> Registrarlo </a> y asi agregarlo a su base de datos</p>";
	}
	else {//ponemos la opcion para buscar
		echo "<div style='margin-top: 200px;  		'>";
		buscar('clientes.php','Escriba el nombre del cliente');
		echo "</div>";


	}
	}

}

}else {mensaje("Acceso denegado a esta aplicacion",'','error');}

?>
<?php include("config/html_footer.php"); ?>	