<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php");?>
<?php
$id_aplicacion ="ap86";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
    
  	if(isset($_POST['btbuscalote']) || isset($_GET['busqueda']) ){
		  	echo "<div >";
        echo "<div>";
      /*  
        echo "<label>Busqueda por:</label><br>";
        echo "<div><input type='radio' id='contrato' name='contrato' value='Contrato' onClick='mostrarBuscar()' checked><label for='contrato'>Contrato</label> </div> ";
        echo "<div><input type='radio' id='porNom' name='porNom' value='Nombre' onClick='mostrarBuscar()'><label for='porNom'>Nombre</label> </div>  ";
        echo "<div><input type='radio' id='lote' name='lote' value='Lote' onClick=''><label for='lote'>Lote</label> </div>";
		
		*/
		echo '
		
		<form id="myForm" >
			<center>
			<table>
				<tr>
					<th colspan="3"><p>Búsqueda por:</p></th>
				</tr>
				<tr>
					<td>
						<label for="contrato"><input type="radio" id="contrato" name="opciones" value="contrato">
						Contrato o Nombre</label>
					</td>
					<td>
						<label for="lote"><input type="radio" id="lote" name="opciones" value="lote">
						Lote</label>
					</td>
				</tr>
			</table>
			</center>
		</form>
		
		';

		
		

        echo "<div id='buscarPorContratoLote' style='display:none; width:100%;'>";
        buscar('preguntas_notificadores.php','Escribe el contrato a buscar','');
		echo "</div>";
		
	
		echo "<div id='buscarPorLote' style='display:none; width:100%;'>";
			echo '<form action="preguntas_notificadores.php" method="POST">';
			echo "<table>";
				echo "<td>";
				$consulta = "select IdMunicipio, Municipio from municipios where IdMunicipio<>0";
				$ConsultaDATA = DatosVivienda(0, "WS1", "Test", $consulta);
				//echo $ConsultaDATA;
				$datos = utf8_decode($ConsultaDATA);
				$datos = utf8_decode($datos);
				//echo $datos;
				$resultado = str_replace("?", "U", $datos);
				$array = json_decode($resultado, true);
				echo "<label for='mun'>Seleccione un Municipio:";
					echo "<select id='mun' name='mun'>";
					echo "<option>Seleccione una opcion...</option>";
						if(is_array($array)){
							foreach ($array as $value) {
								echo "<option value='".$value['IdMunicipio']."'>".$value['Municipio']."</option>";
							}
						}else{
							echo "no es un array";
						}
					echo "</select>";
				echo "</label></td>"; 
				
				//echo "<td>Seleccione una Colonia:";
				echo "<td>";
						echo "<div id='BuscaColoniasMun' style=' width:100%;'>";
								
						
						echo "</div>";
						
				echo "</td>";
					
				echo "<td>";
					//echo "<label>Selecciona manzana</label>";
						echo "<div id='BuscaManzana' style=' width:100%;'>";
							echo "<label for='TxtManzana'>Manzana:";
                		    echo "<input type='text' name='TxtManzana' >" ;
                
						echo "</div>";
				echo "</td>";
					
				echo "<td>";
					    echo "<div id='BuscaLote' style=' width:100%;'>";            
                		    echo "<label for='TxtLote'>Lote:";
                    		echo "<input type='text' name='TxtLote' >" ;
						//	echo "<input type='submit' name='btbuscalote' value='Consultar' class='Mbtn btn-default'>";

						echo "</div>";
				echo "</td>";
				echo "<td>";
					    echo "<div id='BtnBuscar' style=' width:100%;'>";            
                		    echo "<input type='submit' name='btbuscalote' value='Consultar' class='Mbtn btn-default'>";

						echo "</div>";
						
				echo "</td>";
			echo "</table>";
		echo "</div>";

		echo "</div>";
		echo "</form>";
		echo 	"</div>";
		//buscar('preguntas_notificadores.php',$_POST['btbuscalote'],'');
	} else {
		echo "<div >";
        echo "<div id='buscar_centrado'>";
      /*  
        echo "<label>Busqueda por:</label><br>";
        echo "<div><input type='radio' id='contrato' name='contrato' value='Contrato' onClick='mostrarBuscar()' checked><label for='contrato'>Contrato</label> </div> ";
        echo "<div><input type='radio' id='porNom' name='porNom' value='Nombre' onClick='mostrarBuscar()'><label for='porNom'>Nombre</label> </div>  ";
        echo "<div><input type='radio' id='lote' name='lote' value='Lote' onClick=''><label for='lote'>Lote</label> </div>";
		
		*/
		echo '
		
		<form id="myForm" >
			<center>
			<table>
				<tr>
					<th colspan="3"><p>Búsqueda por:</p></th>
				</tr>
				<tr>
					<td>
						<label for="contrato"><input type="radio" id="contrato" name="opciones" value="contrato">
						Contrato o Nombre</label>
					</td>
					<td>
						<label for="lote"><input type="radio" id="lote" name="opciones" value="lote">
						Lote</label>
					</td>
				</tr>
			</table>
			</center>
		</form>
		
		';

		
		

        echo "<div id='buscarPorContratoLote' style='display:none; width:100%;'>";
        buscar('preguntas_notificadores.php','Escribe el contrato a buscar','');
		echo "</div>";
		
	
		echo "<div id='buscarPorLote' style='display:none; width:100%;'>";
			echo '<form action="preguntas_notificadores.php" method="POST">';
			echo "<table>";
				echo "<td>";
				$consulta = "select IdMunicipio, Municipio from municipios where IdMunicipio<>0";
				$ConsultaDATA = DatosVivienda(0, "WS1", "Test", $consulta);
				$datos = utf8_decode($ConsultaDATA);
				$datos = utf8_decode($datos);
				$resultado = str_replace("?", "U", $datos);
				$array = json_decode($resultado, true);
				echo "<label for='mun'>Seleccione un Municipio:";
					echo "<select id='mun' name='mun'>";
					echo "<option>Seleccione una opcion...</option>";
						if(is_array($array)){
							foreach ($array as $value) {
								echo "<option value='".$value['IdMunicipio']."'>".$value['Municipio']."</option>";
							}
						}else{
							echo "no es un array";
						}
					echo "</select>";
				echo "</label></td>"; 
				
				//echo "<td>Seleccione una Colonia:";
				echo "<td>";
						echo "<div id='BuscaColoniasMun' style=' width:100%;'>";
								
						
						echo "</div>";
						
				echo "</td>";
					
				echo "<td>";
					//echo "<label>Selecciona manzana</label>";
						echo "<div id='BuscaManzana' style=' width:100%;'>";
							echo "<label for='TxtManzana'>Manzana:";
                		    echo "<input type='text' name='TxtManzana' >" ;
                
						echo "</div>";
				echo "</td>";
					
				echo "<td>";
					    echo "<div id='BuscaLote' style=' width:100%;'>";            
                		    echo "<label for='TxtLote'>Lote:";
                    		echo "<input type='text' name='TxtLote' >" ;
						//	echo "<input type='submit' name='btbuscalote' value='Consultar' class='Mbtn btn-default'>";

						echo "</div>";
				echo "</td>";
				echo "<td>";
					    echo "<div id='BtnBuscar' style=' width:100%;'>";            
                		    echo "<input type='submit' name='btbuscalote' value='Consultar' class='Mbtn btn-default'>";

						echo "</div>";
						
				echo "</td>";
			echo "</table>";
		echo "</div>";

		echo "</div>";
		echo "</form>";
		echo 	"</div>";
	
	}
	
	//si la busqueda es por lote
	if (isset($_POST['btbuscalote']) ){
		  
			
		$idmanzana=$_POST["TxtManzana"];
		$idlote=$_POST["TxtLote"];
		$idmun=$_POST["mun"];
		$idcol=$_POST["col"];

        
       // $consulta = "select IdColonia , Colonia from catcolonia where IdMunicipio=".$idmun ;
        $consulta="SELECT     NombreCompleto, Programa, Municipio, Colonia, manzana, lote, NumContrato
        FROM         busqueda_vivienda_informacioncontratos
        WHERE     IdMunicipio = $idmun AND IdColonia = $idcol AND manzana = $idmanzana AND lote = $idlote";
	
		//echo $consulta;
		
				$ConsultaDATA = DatosVivienda(0, "WS", "Test1", $consulta);
				//var_dump($ConsultaDATA);
                //echo $ConsultaDATA;

                $datos = utf8_decode($ConsultaDATA);
				$resultado = str_replace("?", "Ñ", $datos);
				$arraycol = json_decode($resultado, true);

				echo "<div id='tablaresultado' style='display:inline-block; width: 50%;'>";
				echo "<center><table class='tabla' >";
				//var_dump($arraycol);
				if(is_array($arraycol)){
					
					foreach ($arraycol as $value) {
					if (isset($value['r'])){
						
					//if ($value['exito']=='false')
							
							mensaje("No se encontraron resultados","preguntas_notificadores.php");
						}
						else								
						{
						//	echo "ok";
						echo "<br><br>";
						echo "<th colspan='2'>Resultados de la búsqueda</th>";
						echo "<tr><td>Nombre</td><td>".$value['NombreCompleto']."</td></tr>";
						echo "<tr><td>Programa</td><td>".$value['Programa']."</td></tr>";
						echo "<tr><td>Municipio</td><td>".$value['Municipio']."</td></tr>";
						echo "<tr><td>Colonia</td><td>".$value['Colonia']."</td></tr>";
						echo "<tr><td>Manzana</td><td>".$value['manzana']."</td></tr>";
						echo "<tr><td>Lote</td><td>".$value['lote']."</td></tr>";
						echo "<tr><td>Lote</td><td>".$value['NumContrato']."</td></tr>";
						$numcontrato=$value['NumContrato'];
						echo "<tr><td colspan='2'></td></tr>";
						echo "<tr><td colspan='2'>";
						//echo "<div id='Escribepregunta' width:100%;'>";
							echo "<form action='preguntas_notificadores.php' method='POST'>";
								echo "<label>Escribe la pregunta para este contrato</label>";
								echo "<input type='text' name='txtpregunta' >";
								echo "<input type='submit' name='btnguardar' value='Guardar' class='Mbtn btn-default'>";
								echo "<input type='hidden' value=".$numcontrato." name='txtpreguntaoculto'  >";
							echo "</form>";
							//buscar('preguntas_notificadores.php','Escribe tu pregunta','');
						//echo "</div>";
						echo "</td>";
						echo "</tr>";
						}
							
					}
				}else{
					echo "no es un array";
				}
				echo "</table></center>";
				echo "</div>";

	 } 
	 //si la busqueda es por contrato 
	if (isset($_GET['busqueda']) ){
		//echo 'contrato';
		$numcontrato=$_GET['busqueda'];
		//echo $numcontrato;

		$consulta=" SELECT NombreCompleto, Programa, Municipio, Colonia, manzana, lote, NumContrato
 					FROM busqueda_vivienda_informacioncontratos
 					WHERE NumContrato='".$numcontrato."'";
				//echo $consulta;

		 $ConsultaDATA = DatosVivienda(0, "WS", "Test1", $consulta);
                //echo $ConsultaDATA;

                $datos = utf8_decode($ConsultaDATA);
				$resultado = str_replace("?", "Ñ", $datos);
				$arraycol = json_decode($resultado, true);
				echo "<div id='tablaresultado' style='display:inline-block; width: 50%;'>";
				echo "<center><table class='tabla' >";
				
				if(is_array($arraycol)){
					foreach ($arraycol as $value) {
						if (isset($value['r'])){
						//if ($value['exito']=='false')
												
							mensaje("No se encontraron resultados","preguntas_notificadores.php");
							//NPush("No se encontraron resultados","Error");				
						}
						else {													
						echo "<br><br>";
						echo "<th colspan='2'>Resultados de la búsqueda</th>";
						echo "<tr><td>Nombre</td><td>".$value['NombreCompleto']."</td></tr>";
						echo "<tr><td>Programa</td><td>".$value['Programa']."</td></tr>";
						echo "<tr><td>Municipio</td><td>".$value['Municipio']."</td></tr>";
						echo "<tr><td>Colonia</td><td>".$value['Colonia']."</td></tr>";
						echo "<tr><td>Manzana</td><td>".$value['manzana']."</td></tr>";
						echo "<tr><td>Lote</td><td>".$value['lote']."</td></tr>";
						echo "<tr><td>Lote</td><td>".$value['NumContrato']."</td></tr>";						
						echo "<tr><td colspan='2'></td></tr>";
						echo "<tr><td colspan='2'>";
						//echo "<div id='Escribepregunta' width:100%;'>";
							echo "<form action='preguntas_notificadores.php' method='POST'>";
								echo "<label>Escribe la pregunta para este contrato</label>";
								echo "<input type='text' name='txtpregunta' >";
								echo "<input type='submit' name='btnguardar' value='Guardar' class='Mbtn btn-default'>";
								echo "<input type='hidden' value=".$numcontrato." name='txtpreguntaoculto'  >";
							echo "</form>";
							//buscar('preguntas_notificadores.php','Escribe tu pregunta','');
						//echo "</div>";
						echo "</td>";
						echo "</tr>";
						}
						
					}		
				}else{
					echo "no es un array";
				}
				echo "</table></center>";
				echo "</div>";

	}
	if (isset($_POST['btnguardar'])){
		//Guarda la pregunta
		$pregunta=$_POST['txtpregunta'];
		$numcontrato=$_POST['txtpreguntaoculto'];
		echo $pregunta;
		if (GuardaPreguntas($numcontrato,$pregunta,$nitavu)=='TRUE'){
			mensaje('Se guardó correctamente','preguntas_notificadores.php');
			
		}
		else {
			mensaje('NO se guardó correctamente','preguntas_notificadores.php');
		}
	}	
}
else{mensaje("No tiene acceso a esta aplicacion",'');}
?>



<script>



//muestra o no lista de municipios
$('#myForm input').on('change', function() {
 //alert($('input[name=opciones]:checked', '#myForm').val()); 
	if(($('input:radio[name=opciones]:checked').val()=='contrato')){
		$("#buscarPorContratoLote").css({'display':'inline-block',});
		$("#buscarPorLote").css({'display':'none',});
		
		$("#BuscaManzana").css({'display':'none',});
		$("#BuscaLote").css({'display':'none',});
		$("#BtnBuscar").css({'display':'none',});
		$("#tablaresultado").css({'display':'none',});
		
	}else{
		$("#buscarPorContratoLote").css({'display':'none',});
		$("#buscarPorLote").css({'display':'inline-block',});

		$("#BuscaManzana").css({'display':'none',});
		$("#BuscaLote").css({'display':'none',});
		$("#BtnBuscar").css({'display':'none',});
		$("#tablaresultado").css({'display':'none',});
	}
});


    $(document).on("change", "#mun", function(event) {
		var id=$("#mun option:selected").val();	
		//muestra mensaje emergente con id
			//alert(id);
       $.ajax({
            url: "BWS_ColoniasxMun.php",
			type: "POST",
			//id primero valor recibido, segundo id valor que envio a funcion
            data: {idclase: id},
            success: function(data){
				console.log ('id'+id)
				//alert(data);
				console.log(data);
				$('#BuscaColoniasMun').html(data+"\n");
			
				
			
            }
        });
    });              
	
	$(document).on("change", "#col", function(event) {
		var id=$("#col option:selected").val();	
		//alert(id);	
		$("#BuscaManzana").css({'display': '',});
		$("#BuscaLote").css({'display':'',});
		$("#BtnBuscar").css({'display':'',});

       
    });       




</script>

<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<?php include ("./lib/body_footer.php"); ?>