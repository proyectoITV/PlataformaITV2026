<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php");  ?>
<?php
require("config.php");
$id_aplicacion = 'ap50';

echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap50"; //ap07=Permisos de Aplicacion
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

$styleNotas = "

";
$bd="P";
$del="0";
	if(isset($_POST['primera'])){
		$idReporte = $_POST['id'];
		$nombre = $_POST['nombre'];
		$desc = $_POST['descripcion'];
		$solicita = $_POST['solicitante'];

		historia($nitavu, "Entro al area para ingresar la consulta al reporte con ID:".$idReporte.", ".$nombre." solicitado por ".nitavu_nombre($solicita));

		echo "<div id='xdivCrearRep'>";
		echo "<form action='reportes_crear.php' method='POST'>";
		echo "<table border='0'>";
		
		echo "<tr>";
		echo "<td valign=top style='background-color:#ECF7D5;' width=60%>";
		echo "<h3 style='color:#748837;'>Reporte Solicitado:</h3>";
		echo "<b class='tenue'>[".$idReporte."]</b><b class='normal'>".$nombre."</b><br>";
		echo "<p style='font-size:12pt;'>".$desc."</p>";
		echo "<p style='font-size:10pt;'>Solicitado por <b>".nitavu_nombre($solicita)."</b> del Dpto. de ".nitavu_dpto_nombre($solicita)."</p>";

		echo "</td>";
		echo "<td valign=top>";
		//echo "<b style='color:#575A5D; padding:20px;'>Escribe las consultas para crear el reporte solicitado</b>";

		echo "<label id='notaConsultas' style='width:300px; display:inline-block;'><b>IMPORTANTE:</b> Utilizar únicamente comillas dobles ( \" \" ) en las consultas.</label>";
		
		echo "<span style='background-color:#ECC1E9; border-color:#CC3399; color:#CC3399;
		with: 200px; padding:8px; border-radius:4px; display: inline-block;
		'>
		<img src='icon/ext.png' style='width:50px;'><br><b>". nitavu_tel_ext($solicita)."</b></span>";
		echo "</td>";
		echo "</tr>";

		echo "<tr>";
		
		echo "<td>";
		
		
		echo "<label>Consulta Principal:</label>";
		echo "<textarea class='consulta' name='consulta1' id='consulta1'  required></textarea>";

		echo "</td>";
		echo "<td>";
		echo "<label class='normal'>Consulta Secundaria:(Opcional)</label>";
		echo "<textarea name='consulta2' style='height:70px;' class='consulta' ></textarea>";
		echo "<label>Consulta Opcional:</label>";
		echo "<textarea name='consulta3' style='height:70px;' class='consulta'></textarea>";
		echo "<label>Orientación del reporte </label>";
		echo "<select name='orientacion' style='width:200px;'>";
		echo "<option value='P'>Vertical</option>";    
		echo "<option value='L'>Horizontal</option>"; 
		echo "</select>"; 
		echo "<label>Base de Datos de Donde se obtendrá la información </label>";
		echo "<select name='bd' id='bd' onchange='cargarDelegaciones()'>";
		echo "<option value='S' selected='selected'>Sin Especificar</option>"; 
		echo "<option value='P'>Plataforma</option>";    
		echo "<option value='V'>Vivienda</option>"; 
		echo "</select>"; 
		echo "<div id='comboDelegaciones' style='width: 100%;'>";
								
		
	 	echo "</div>";
		echo "<input type='hidden' value='".$idReporte."' name='id'>";
		echo "<input type='hidden' value='".$nombre."' name='nombre'>";
		echo "<input type='hidden' value='".$desc."' name='descripcion'>";
		echo "<input type='hidden' value='".$solicita."' name='solicita'>";
		echo "<div id='botonGuardar'>";
		echo "<br>";
		echo "<input class='Mbtn btn-default' type='submit' title='Haga clic para guardar las consultas' name='guardar' value='Guardar las Consultas'>";
		echo "</div>";
		
	
		echo "</td>";
		echo "</tr>";
		echo "</table>";
		echo "</form>";
	
		echo "</div>";
	}
	$preReporte='';
	if(isset($_POST['consulta1'])){  
		$idReporte = $_POST['id'];
		$nombre = $_POST['nombre'];
		$desc = $_POST['descripcion'];
		$solicita = $_POST['solicita'];
		$con1=$_POST['consulta1'];
		$del=$_POST['del'];
		$preReporte = agregarReporte($idReporte,$nombre,$desc,$con1,$_POST['consulta2'],$_POST['consulta3'],$_POST['orientacion'],$nitavu,0,$solicita,$_POST['bd'],$del);
		$titulos=camposDescripcion($idReporte,1);
		actualizarDescripcion($idReporte,$titulos);
		cambioEstadoReporte($idReporte);
		
	}

	if(isset($_GET['idReporte'])){
		$idReporte = $_GET['idReporte'];
		$solicita = $_GET['solicita'];
		$preReporte = TRUE;
	}

	if($preReporte == TRUE){
		echo "<div>";
		// echo "<h3> Visualización del Reporte </h3>";
		echo "<table  border=0 style='width:100%; height: 100%;'>";
		echo "<td style='' valign=top align=center >";
		echo "<iframe id='frame' name='frame' src='reporte.php?id=".$idReporte."&nitavu=".$nitavu."&previsualizar=1' style='width:100%;height:97%;border:0; border:none;'>Tu navegador no soporta iframes...</iframe>";
		echo "</td>";
		echo "<td width=30px style='vertical-align: top;'>";
		echo "<form action='reporteador.php' method='POST'>";
		echo "<input type='hidden' value='".$idReporte."' name='RC1'>";
		echo "<input type='hidden' value='".$solicita."' name='solicita'>";
		echo "<br>";
		echo "<button type='submit' style='margin-top:0%;' class='Mbtn btn-default' title='Haga clic para enviar el reporte'> <img src='icon/enviarRep.png' style='width:30px; '> </button>"; 
		echo "</form>";
		echo "<form action='reportes_crear.php' method='POST'>";
		echo "<input type='hidden' value='".$idReporte."' name='id3'>";
		echo "<input type='hidden' value='".$solicita."' name='solicitante'>";
		echo "<br>";
		echo "<button type='submit' style='margin-top:0%;' class='Mbtn btn-default' title='Haga clic para modificar el reporte'> <img src='icon/modificarRep.png' style='width:30px; '> </button>"; 
		echo "</form>";
		echo "</td>";
		echo "</table>";
		echo "</div>";
	}	
	$orientacion="";	
	if(isset($_POST['id3'])){
		$idReporte = $_POST['id3'];
		$solicita = $_POST['solicitante'];

		echo "<div id='xdivCrearRep'>";
		echo "<form action='reportes_crear.php' method='POST'>";
		echo "<h3>Checar el reporte para ser turnado a aprobacion </h3>";
		echo "<label id='notaConsultas'>Favor de usar únicamente comillas dobles ( \" \" ) en las consultas.</label>";
		
		$sql = "SELECT * FROM reportes WHERE id_rep_consulta=".$idReporte."";
		$r = $conexion -> query($sql); 
		
		while($f = $r -> fetch_array()){
			echo "<label>Consulta Principal</label>";
			echo "<textarea class='consulta' type='text' name='con1' style='height:300px;'required>".$f['sql1']."</textarea>";
			echo "<label>Consulta Secundaria (opcional)</label>";
			echo "<textarea class='consulta'  name='con2' style='height:150px;'>".$f['sql2']."</textarea>";
			echo "<label>Consulta Opcional</label>";
			echo "<textarea class='consulta' name='con3' style='height:100px;'>".$f['sql3']."</textarea>";
			$orientacion=$f['orientacion'];
			$bd=$f['basededatos'];
			$del=$f['delegacion'];
			echo $f['basededatos'];
		}
		
		echo "<label>Orientación del reporte </label>";
		echo "<select name='orient'>";
		if ($orientacion=="P")
		{
		echo "<option value='P' selected='selected'>Vertical</option>";    
		echo "<option value='L'>Horizontal</option>"; 
		}
		else
		{
			echo "<option value='P'>Vertical</option>";    
			echo "<option value='L' selected='selected'>Horizontal</option>"; 
		}
		echo "</select>"; 
		echo "<label>Base de Datos de Donde se obtendrá la información </label>";
		echo "<select name='bd' id='bd' onchange='cargarDelegaciones()' >";
		if ($bd=="V")
		{	
			echo "<option value='P'>Plataforma</option>";    
			echo "<option value='V' selected='selected'>Vivienda</option>";	 
		}else
		{		
		  
		 echo "<option value='P' selected='selected'>Plataforma</option>";    
		 echo "<option value='V'>Vivienda</option>"; 
		}
		echo "</select>"; 

		echo "<div id='comboDelegaciones' style='width: 100%;'>";
								
						
	 	echo "</div>";



		echo "<input type='hidden' value='".$idReporte."' name='id4'>";
		echo "<input type='hidden' value='".$solicita."' name='solicita'>";
		echo "<div id='botonGuardar'>";
		echo "<br>";
		echo "<input class='Mbtn btn-default' type='submit' title='Haga clic para guardar las consultas' name='guardar' value='Guardar'>";
		echo "</div>";
		echo "</form>";
		echo "<br><br><br><br>";
		echo "</div>";
		
	}

	if(isset($_POST['id4'])){
		$id = $_POST['id4'];
		$solicita = $_POST['solicita'];
		$modifica = modificar_consultas($_POST['id4'],$_POST['con1'],$_POST['con2'],$_POST['con3'],$_POST['orient'],$nitavu,$_POST['bd'],$_POST['del']);
		if($modifica == TRUE){
			$preReporte=TRUE;
			$titulos=camposDescripcion($id,2);
			actualizarDescripcion($id,$titulos);
			//historia($nitavu, "Ha liberado el reporte con id ".$_POST['id4']);

			mensaje('Se han modificado las consultas con éxito.',"reportes_crear.php?idReporte=".$id."&solicita=".$solicita."");
		}else{
			mensaje('Hubo un error al tratar de guardar las consultas.=>'.$modifica,"reportes_crear.php?idReporte=".$id."&solicita=".$solicita."");
		}	
	}

?>
<script>

$( document ).ready(function() {

 
	cargarDelegaciones();// onload it will call the function 

	});

function cargarDelegaciones()
{
	var de = <?php echo $del;?>;

//$(document).on("change", "#bd", function(event) {
	var id=$("#bd option:selected").val();	
	
	if(id=="V")
	{
		
       $.ajax({
            url: "reporteDelegaciones.php",
			type: "POST",
			//id primero valor recibido, segundo id valor que envio a funcion
            data: {del: de},
            success: function(data){
				$('#comboDelegaciones').html(data+"\n");
				
				
			
            }
        });
	}else
	{
		if ($('#combo').is(':visible')) {
   		$('#combo').hide();
}
	}
/// });

}
	 
  
 
   
           
	
	</script>
<br><br><br><br><br><br>
<?php include ("./lib/body_footer.php"); ?>
