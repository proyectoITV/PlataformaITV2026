<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>



<?php
$id_aplicacion ="ap49";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
if (sanpedro($id_aplicacion, $nitavu)==TRUE and $nivel==1)
{
	
	echo "<br><br>";
	include("req_menu.php");

	$n=$_GET['n'];//var con la que nos manda la busqueda y nos indica que numero de itavu tiene

	$sql = " -- req 
	SELECT * FROM req_conceptos WHERE IdConcepto='".$n."'";
	$rc= $conexion -> query($sql);
	 if($f = $rc -> fetch_array())
	 {
	

/////********* INICIA FORMULARIO***************///

		
		echo "<form  action='req_concepto_edit_bd.php' method='POST' enctype='multipart/form-data'>";
		echo "<input type='hidden' value='".$nitavu."' name='quien'>";
		echo "<input type='hidden' name='IdConcepto' readonly id='IdConcepto' value='".$n."' >";
		echo "<div>";
		echo "<label for='concepto'>Nombre:</label>";
		echo "<input type='text' name='Concepto' id='concepto' placeholder='Descripcion del producto'required value='".$f['Concepto']."'>";
		echo "</div>";		
		echo "<div>";
		echo "<label for='tipoRequisicion'>Tipo de Requisicion:";
		echo "<select name='TipoRequisicion' required='required'>";			
		$sql = " -- req 
		SELECT * FROM req_tiporequisicion ORDER by Requisicion ASC";
		$tmp="";
		$r2 = $conexion -> query($sql);

 		//$r = $conexion -> query($sql);
						
			
 				$entro=false;
		     while($fx = $r2 -> fetch_array())
			{
			  				
				if ($f['IdTipoRequisicion']==$fx['IdTipoRequisicion'])
					{
						$entro=true;
						echo '<option value="'.$f['IdTipoRequisicion'].'" selected="selected">'.$fx['Requisicion'].'</option>';							
					}
					else
					{
						echo '<option value="'.$fx['IdTipoRequisicion'].'">'.$fx['Requisicion'].'</option>';		
					}					
			}
		

			if ($entro==false)
			{
				echo '<option value="0" selected="selected">NINGUNO</option>';	
			}
			
		
		echo "</select>";
		echo "</label>";
		echo "</div>";
		echo "<div>";
		echo ponerfoto("fotos_concepto/".$f['IdConcepto'].".jpg",'foto');
		echo "<label for='foto_file'> Seleccione un archivo:</label>";
		echo "<input type='file' name='foto_file' id='foto_file'  >";
		echo "</div>";

		$idcosto=ConsultaPrecioActivo($f['IdConcepto']);
		echo "<div>";		
		echo "<label for='costoProducto'> Costo del producto</label>";
		echo "<input type='text' name='costoProducto' id='costoProducto' value='".$idcosto."' >";
		echo "</div>";



		echo "<span>";
		echo sugerencia("No utilice apostrofes o comillas, afecta a la integredad de los datos.");
		echo "<div>";
		echo "<input type='submit' value='Aceptar' class='Mbtn btn-default'>";
		echo "</div></div></span>";
		echo "</form>";


		/////********* FIN FORMULARIO***************///


}
	}
else{
	echo "	<br><br>";
	echo "No tiene acceso a ".$id_aplicacion;
}
	echo "	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>";
	

?>











<br>
<?php
include ("./lib/body_footer.php");
?>