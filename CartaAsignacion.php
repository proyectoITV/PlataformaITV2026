<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php");?>
<?php
$id_aplicacion ="ap91";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
    
  	
		echo "<div >";
        echo "<div id='buscar_centrado'>";
     
		

	
		echo "<div id='buscarPorLote' style=' width:100%;'>";
			echo '<form action="CartaAsignacion.php" method="POST">';
			echo "<table>";
				echo "<td>";
				// echo "<div id='ListaMunicipios' >";
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
				 //echo "</div>";
				//echo "<td>Seleccione una Colonia:";
				echo "<td>";
						echo "<div id='BuscaColoniasMun' style=' width:100%;'>";
								
						
						echo "</div>";
						
				echo "</td>";
					
				echo "<td>";
					//echo "<label>Selecciona manzana</label>";
						echo "<div id='BuscaManzana' style='display: none; width:100%;'>";
							echo "<label for='TxtManzana'>Manzana:";
                		    echo "<input type='text' name='TxtManzana' >" ;
                
						echo "</div>";
				echo "</td>";
					
				echo "<td>";
					    echo "<div id='BuscaLote' style=' display: none;  width:100%;'>";            
                		    echo "<label for='TxtLote'>Lote:";
                    		echo "<input type='text' name='TxtLote' >" ;
						//	echo "<input type='submit' name='btbuscalote' value='Consultar' class='Mbtn btn-default'>";

						echo "</div>";
				echo "</td>";
				echo "<td>";
					    echo "<div id='BtnBuscar' style='display:none;  width:100%;'>";            
                		    echo "<input type='submit' name='btbuscalote' value='Consultar' class='Mbtn btn-default'>";

						echo "</div>";
						
				echo "</td>";
			echo "</table>";
		echo "</div>";

		echo "</div>";
		echo "</form>";
		echo 	"</div>";
	
	
	
	//si la busqueda es por lote
	if (isset($_POST['btbuscalote']) ){
		  
			
		$idmanzana=$_POST["TxtManzana"];
		$idlote=$_POST["TxtLote"];
		$idmun=$_POST["mun"];
		$idcol=$_POST["col"];

        

       //insert
	  
		$consulta="select vivienda_cartografia.IdLote, ISNULL(NumContrato,'') AS NumContrato, Manzana, Lote, catcolonia.Colonia, vivienda_cartografia.IdMunicipio, Municipios.Municipio
		from vivienda_cartografia 
	   left outer join catcolonia  on vivienda_cartografia.IdMunicipio=catcolonia.IdMunicipio and 
	   vivienda_cartografia.Idcolonia=catcolonia.IdColonia
	   left outer join Municipios on vivienda_cartografia.idmunicipio=Municipios.IdMunicipio
	   where vivienda_cartografia.IdMunicipio=$idmun and vivienda_cartografia.IdColonia=$idcol 
	   and vivienda_cartografia.Manzana=$idmanzana and vivienda_cartografia.Lote=$idlote";

		/* $consulta="select  Manzana, Lote, catcolonia.Colonia, vivienda_cartografia.IdMunicipio, Municipios.Municipio
		 from vivienda_cartografia 
	   left outer join catcolonia  on vivienda_cartografia.IdMunicipio=catcolonia.IdMunicipio and 
	   vivienda_cartografia.Idcolonia=catcolonia.IdColonia
	   left outer join Municipios on vivienda_cartografia.idmunicipio=Municipios.IdMunicipio
	   where vivienda_cartografia.IdMunicipio=$idmun and vivienda_cartografia.IdColonia=$idcol 
	   and vivienda_cartografia.Manzana=$idmanzana and vivienda_cartografia.Lote=$idlote"; */
        /* $consulta="SELECT     NombreCompleto, Programa, Municipio, Colonia, manzana, lote, NumContrato
        FROM         busqueda_vivienda_informacioncontratos
        WHERE     IdMunicipio = $idmun AND IdColonia = $idcol AND manzana = $idmanzana AND lote = $idlote"; */
    
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
							
							mensaje("No se encontraron resultados","CartaAsignacion.php");
						}
						else								
						{
						//	echo "ok";
						echo "<br><br>";
						echo "<th colspan='2'>Resultados de la búsqueda</th>";
						//echo "<tr><td>Nombre</td><td>".$value['NombreCompleto']."</td></tr>";
						echo "<tr><td>IdLote</td><td>".$value['IdLote']."</td></tr>";
						echo "<tr><td>Municipio</td><td>".$value['Municipio']."</td></tr>";
						echo "<tr><td>Colonia</td><td>".$value['Colonia']."</td></tr>";
						echo "<tr><td>Manzana</td><td>".$value['Manzana']."</td></tr>";
						echo "<tr><td>Lote</td><td>".$value['Lote']."</td></tr>";
						echo "<tr><td>Numcontrato</td><td>".$value['NumContrato']."</td></tr>";
						$numcontrato=$value['NumContrato'];
						echo "<tr><td colspan='2'></td></tr>";
						echo "<tr><td colspan='2'>";
						//echo "<div id='Escribepregunta' width:100%;'>";
							echo "<form action='CartaAsignacion.php' method='POST'>";
								//echo "<label>Escribe la pregunta para este contrato</label>";
								//echo "<input type='text' name='txtpregunta' >";
								//echo "<input type='submit' name='btnguardar' value='Guardar' class='Mbtn btn-default'>";
								echo "<input type='submit' name='btnguardar' value='Registrar Permiso Carta Asignación' class='Mbtn btn-default'>";
								//echo "<input type='hidden' value=".$numcontrato." name='txtpreguntaoculto'  >";
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
		//Guarda el estatus en lotes
		//$estatus=$_POST['1'];
		
		//echo $pregunta;
		//if (GuardaPreguntas($numcontrato,$pregunta,$nitavu)=='TRUE'){
		//	mensaje('Se guardó correctamente','preguntas_notificadores.php');
			
		//}
		//else {
		//	mensaje('NO se guardó correctamente','preguntas_notificadores.php');
		//}
		$consultaguarda="update IngresosDiarios set FormaPago=80 where IdDelegacion=1 and IdPrograma=78 and IdSemana=19 and Tipo='IE'
		select @@ROWCOUNT as resultado;
		set nocount off	";
		$ConsultaDATA = DatosViviendaLarge(0, "WS", "Test1", $consultaguarda);
				var_dump($ConsultaDATA);
                //echo $ConsultaDATA;                
				$arraycol = json_decode($resultado, true);
				echo "<div id='tablaresultado' style='display:inline-block; width: 50%;'>";
				echo "<center><table class='tabla' >";
				//var_dump($arraycol);
				if(is_array($arraycol)){
					
					foreach ($arraycol as $value) {
					if (isset($value['r'])){
							
							mensaje("No se encontraron resultados","CartaAsignacion.php");
						}
						else								
						{
						//	echo "ok";
						echo "<br><br>";
						echo "<th colspan='2'>Resultados de la búsqueda</th>";
						
						echo "<tr><td>IdLote</td><td>".$value['resultado']."</td></tr>";
						
						}
							
					}
				}else{
					echo "no es un array";
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
                $("#BuscaManzana").css({'display': 'inline-block',});
                $("#BuscaLote").css({'display':'inline-block',});
		        $("#BtnBuscar").css({'display':'inline-block',});
			
				
			
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