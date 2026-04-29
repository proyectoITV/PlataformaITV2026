<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>

<?php
	$id_aplicacion ="ap26"; //ap07=Permisos de Aplicacion
	if (sanpedro($id_aplicacion, $nitavu)==TRUE)
	{
		echo "<form action='patrimonio_mttodebienes_validar.php' method='post' name='patrimonio_mttodebienes_validar' enctype='multipart/form-data'>";
			echo "";
			echo "<input type='hidden' name='tipo' value='temporal' readonly='readonly'>";

			echo "<div>";
				echo "<label for='numdeinvoficial'>Número de inventario OFICIAL</label>"; 
				echo "<input type='text' name='numinvoficial' id='numinvoficial'>";
			echo "</div>";

			echo "<div>";
			echo "";
			echo "</div>";

			echo "<div>";
				echo "<label for='numdeinvanterior'>Número de inventario ANTERIOR</label>"; 
				echo "<input type='text' name='numinvanterior' id='numinvanterior'>";
			echo "</div>";

			echo "<div>";
				echo "<label for='numdeinvgobierno'>Número de inventario GOBIERNO</label>"; 
				echo "<input type='text' name='numinvgobierno' id='numinvgobierno'>";
			echo "</div>";

			echo "<div>";
				echo "<label for='sap'>Nombre o descripción del BIEN</label>"; 
				echo "<input type='text' name='descripciondelbien' id='descripciondelbien'>";
			echo "</div>";

			echo "<div>";
			echo "<label for='listademarcas'>Lista de MARCAS:";
			echo "<select name='listademarcas' required='required'>";
			
				$sql = "SELECT * FROM patrimonio_marcas ORDER by marca ASC";
				$r = $conexion -> query($sql);
				while($f = $r -> fetch_array())
					{ // resultado de la busqueda.................
						echo "<option value='".$f['idmarca']."'>".$f['marca']. " </option>";
					}
			
			echo "</select>";
			echo "</label>";
			echo "</div>";

			echo "<div>";
				echo "<label for='lblmodelobien'>Modelo</label>"; 
				echo "<input type='text' name='txtmodelobien' id='txtmodelobien'>";
			echo "</div>";


			echo "<div>";
				echo "<label for='lblseriebien'>Serie</label>"; 
				echo "<input type='text' name='txtseriebien' id='txtseriebien'>";
			echo "</div>";

			echo "<div>";
				echo "<label for='lblfechafactura'>Fecha de la factura</label>";
				echo "<input type='date' name='fecha_factura' id='fecha_factura' required='required' placeholder='AAAA-MM-DD'>";
			echo "</div>";

			echo "<div>";
				echo "<label for='lblfechacontable'>Fecha de alta contable</label>";
				echo "<input type='date' name='dtfechacontable' id='dtfechacontable' required='required' placeholder='AAAA-MM-DD'>";
			echo "</div>";

			echo "<div>";
				echo "<label for='lblnumerofactura'´>Número de factura</label>"; 
				echo "<input type='text' name='txtnumerofactura' id='txtnumerofactura'>";
			echo "</div>";

			echo "<div>";
				echo "<label for='lblcostoarticulo'´>Costo del artículo</label>"; 
				echo "<input type='text' name='txtcostoarticulo' id='txtcostoarticulo'>";
			echo "</div>";

			echo "<div>";
				echo "<label>Clasificación de contraloria</label>";
				echo "<select name='cboclascontraloria'>";
					echo "<option value=0 selected='selected'>BIEN INVENTARIABLE</option>";
					echo "<option value=1 >BIEN CONTROLABLE</option>";
					echo "<option value=2 >BIEN CONTROLABLE - GASTO</option>";
					echo "<option value=3 >BIENES BAJA DEFINITIVA</option>";
				echo "</select>";
			echo "</div>";				

			echo "<div>";
			echo "<label for='listaproveedores'>Lista de PROVEEDORES";
			echo "<select name='listadeproveedores' required='required'>";
			
				$sql = "SELECT * FROM patrimonio_proveedores ORDER by proveedor ASC";
				$r = $conexion -> query($sql);
				while($f = $r -> fetch_array())
					{ // resultado de la busqueda.................
						echo "<option value='".$f['idproveedor']."'>".$f['proveedor']. " </option>";
					}
			
			echo "</select>";
			echo "</label>";
			echo "</div>";

		echo "<div>";
				echo "<label>Observaciones:</label>";
				echo "<textarea name='txtObservaciones'></textarea>";
		echo "</div>";

		echo "<div>";
				echo "<label>Ubicación fisica:</label>";
				echo "<textarea name='txtubicacionfisica'></textarea>";
		echo "</div>";

		echo "<span>";
		echo sugerencia("No utilice apostrofes o comillas, afecta a la integredad de los datos.");
		echo "<div>";

		echo "<input type='submit' value='Agregar' class='Mbtn btn-default'>";
		echo "</div></div></span>";

		echo "</form>";
	}
	else{echo "No tiene acceso a ".$id_aplicacion;}
//?>

<?php
include ("./lib/body_footer.php");
?>