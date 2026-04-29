<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

?>
<?php
/////********* INICIA FORMULARIO***************///
$id_aplicacion ="ap49";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE and $nivel==1 )
{	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";				
		include("req_menu.php");
		echo "<br>";
		echo "<br>";
		//echo "<div id='AppDetalle'>Nuevo concepto </div>";
		
		echo "<form  action='req_concepto_nuevo_bd.php' method='POST' enctype='multipart/form-data'>";
		// echo "<input type='hidden' value='".$nitavu."' name='quien'>";
		// echo "<div>";
		//  echo "<label for='no'>Id:</label>";
		// echo "<input type='hidden' name='no' readonly id='no' value='".siguienteIdConcepto()."'>";
		// echo "</div>";
		echo "<div>";
		echo "<label for='concepto'>Nombre:</label>";	


		
		if (isset($_GET['img'])){$busqueda=$_GET['img'];} else {	$busqueda='sin imagen disponible';
	}

		$src= Google_images($busqueda,'','FALSE'); 
		
	
		 if (isset($_GET['img']))
		 {	
		 	//echo "entro";
			echo "<input type='text' name='concepto' id='concepto' placeholder='Descripción del producto'  required value='".$busqueda."' onchange='test_carga();' autofocus='autofocus'>";


		 }
	 	else 
		 {
		 	
		 	 if(isset($_GET['con']))
      			{
      				$src= Google_images($_GET['con'],'','FALSE'); 
      				echo "<input type='text' name='concepto' id='concepto'   placeholder='Descripción del producto' required value='".$_GET['con']."' onchange='test_carga();' autofocus='autofocus'>";
      			}
      			else
     			 {	echo "<input type='text' name='concepto' id='concepto' placeholder='Descripción del producto'  required value='' onchange='test_carga();' autofocus='autofocus'>";

				}	
			}

	
	 	echo "</div>";
		
		echo "<div>";
		echo "<label for='tipoRequisicion'>Tipo de Requisición::";
		echo "<select name='tipoRequisicion' required='required' >";
		
		echo '<option value="0" selected="selected">Selecciona un tipo de requisición</option>';		
			 $sql = " -- req 
			 SELECT * FROM req_tiporequisicion ORDER by Requisicion ASC";
			 

			 $r = $conexion -> query($sql);
			 
			 while($f = $r -> fetch_array())
			 	{ 
			 		echo "<option value='".$f['IdTipoRequisicion']."'>".$f['Requisicion']. " </option>";
				}
					
		echo "</select>";
		echo "</label>";
		echo "</div>";
		echo "<div id='imagen_ejemplo'>";
		echo "<input type='hidden' readonly='readonly' value='$src' name='imagen_ejemplo'>";
		echo "<img src='$src'>";
		echo "<input type='file' name='foto_file' id='foto_file'  >";
		echo "</div>";


		echo "<div>";		
		echo "<label for='costoProducto'> Costo del producto</label>";
		echo "<input type='text' name='costoProducto' id='costoProducto' value='0.00' >";
		echo "</div>";

		echo "<span>";
		echo sugerencia("No utilice apostrofes o comillas, afecta a la integridad de los datos.");
		echo "<div>";
		echo "<input type='submit' value='Agregar' class='Mbtn btn-default'>";
		echo "</div></div></span>";
		echo "</form>";



}
else
{	echo "<br><br>";
	echo "No tiene acceso a ".$id_aplicacion;
}


		/////********* FIN FORMULARIO***************///
?>

<script>
function test_carga()
{
	var yourSelect = document.getElementById( "concepto" );
	window.location="req_concepto_nuevo.php?img="+ yourSelect.value ;
}
</script>

<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>