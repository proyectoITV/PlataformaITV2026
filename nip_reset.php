<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");

// contenido:
?>
<div id="documentar">

<?php

//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap22"; //Id de la aplicacion a cargar
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
	// span ocupa 100% y Div 50%;

	
	
	
	historia ($nitavu,"Entro a Resetear el NIP");				
	echo "<div style='
	text-align:center; padding:20px; width:100%;
	'>";
	
	echo "<label for='empleado'>Seleccione a quien le enviara un documento:";
	echo "<select name='IdEmpleado' id='IdEmpleado' class='' style='
	font-size:13pt;
	'>";
	
		$sql = "SELECT * FROM empleados ORDER by nombre ASC";
		$r = $conexion -> query($sql);
		while($f = $r -> fetch_array())
			{ // resultado de la busqueda.................
				echo "<option value='".$f['nitavu']."'>".$f['nitavu']." ".$f['nombre']. " (".$f['puesto']." de ".$f['departamento'].")</option>";
			}
	
	echo "</select>";
	echo "</label>";
	


	
	echo "
	<p style='font-size:12pt;'>
		Se enviara un correo electronico al correo que tengan registrado, con copia 
		para ".$CorreoDeLaPlataforma.", por ser por este medio.<br>
		<br>
		Recomienda realizarlo via <b>Olvide mi NIP</b>, desde el Login de la Plataforma,
		tambien puedes actualizarle su correo electronico y que despues en el Login, le de clic <br>
		en Olvide mi NIP.
	</p>";
	
	echo "<button class='btn btn-success' onclick='Reset();'>Resetear NIP</button>";

	echo "</div>";

	
	


	
}
else
{
	mensaje ("no tiene permiso",'');
}
?>


<script>

function Reset(){		                    
    $('#preloader').show();
	IdEmpleado = $('#IdEmpleado').val();
	
    $.ajax({
    url: "nip_dat_reset.php",
    type: "post",        
    data: {IdEmpleado:IdEmpleado},
    success: function(data){    
		//console.log(data);            
        $("#R").html(data+"");     
        
        $('#preloader').hide();
    }
    });

            
}
</script>

</div>
<br><br><br><br><br>
<?php
include ("./lib/body_footer.php");
?>