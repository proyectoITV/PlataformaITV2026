<?php
include("./lib/body_head.php");
include("./lib/body_menu.php"); 

?>
<?php

$idDepartamento=nitavu_dpto($nitavu);
$id_aplicacion ="ap87";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
$nivel=1;
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
$dpto = nitavu_dpto($nitavu);

$pags=20;
//PARA DAR ACCESO CUANDO ESTE REGISTRADA
historia($nitavu,'Usando tramites App'); 
// echo "<label>* Nivel="	.$nivel." | Ambiente de Pruebas </label>";
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	
echo '<div id="respuesta" style="display:none;"></div>';
//boton mas
echo "<div>";
echo "<a href='#iniciarTramite' rel='MyModal:open' class=' btn-g' title='Nueva Solicitud'>";
	echo "<table  width='100%'><tr><td valign='middle' align='center'>";
	echo "<img src='icon/mas2.png' >";
	echo "</td>";
	echo "<td valign='middle' align='center' style='color:white;' class='pc'>";
	echo "</td></tr></table>";
echo "</a>";

//PROBANDO ID SOLICITUD 
//echo "<br><br>";
//echo 'GAEM620802MTSLSX<br>';
//echo crearIdSolicitante('GALVAN','ESTRADA','MA DE LOS ANGELES', '1962-08-02 00:00:00.000', '1', '28');
//echo 'Folio: '. IdSiguienteFolio(6, 78);

//guardamos la información de ahorro previo 
if(isset($_POST['ahorro']) and isset($_POST['tiempo'])){
	$ahorro = $_POST['ahorro'];
	$tiempo = $_POST['tiempo'];
	$idTramite = $_POST['IdTramite'];

	$query = "UPDATE tramites SET AhorroPrevio = ".$ahorro.", Tiempo = ".$tiempo." WHERE IdTramite = ".$idTramite."";
	echo $query;
	if ($conexion->query($query) == TRUE)
    {
        mensaje('Se han guardado los datos correctamente.','tramites.php');
    }else{
        mensaje('Ocurrio un error, intentelo de nuevo.','tramites.php');
    }


}

//----------------------------BUSQUEDA
echo "<div  style='width=90%; margin-top:15px;'>";
		if (isset($_GET['busqueda']))
		{ 
			$search = $_GET['busqueda'];
		} 
		else 
		{
			// echo "<label></label>";
			buscar("tramites.php","Buscar documento",'');
		}
		if (isset($_GET['busqueda']))
		{ 
			$sql = "
			SELECT tramites.IdTramite, tramitestipo.NombreTramite, tramites.Curp, tramites.NombreBeneficiario, tramites.Fecha, tramites.NitavuCaptura,tramites.IdTipoTramite,tramites.Estado
			FROM  tramites 
			INNER JOIN  tramitestipo 
			ON tramites.IdTipoTramite=tramitestipo.IdTipoTramite 
			WHERE IdTramite ='".$search."' or Curp like '%".$search."%'  or  NombreBeneficiario  like '%".$search."%'";

			//echo $sql;
			$r = $conexion -> query($sql);
			$r_count = $r -> num_rows;
			if ($r_count<=0)
			{ 
				historia($nitavu,'tr_Busqueda fallida de '.$search);
				$msg="Lo sentimos no se han encontrado resultados sobre <b>".$search."</b>";
				$msg = $msg." Vuelva a intentarlo utilizando otras palabras de busqueda";
				mensaje($msg,"tramites.php");
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
				// echo $sql;
				$rc = $conexion -> query($sql);
				echo "<h4>Resultados ".$r_count. " sobre <b>[ ".$search." ]</b>, agrupados de ".$paginacion." </h4>";
				$paginas = intval(($r_count / $paginacion));
				historia($nitavu,'tr_Busqueda de '.$search);
	
				echo "<center><div style='border: 0px; width:90%;'>";
				$cont=0;
			
				while($r = $rc -> fetch_array())
				{ // resultado de la busqueda.................
					echo "<div id='resultado_elemento'  >";			 
					echo "<table border='0'>";
						echo "<tr id='Registro".$r['IdTramite']."'>";	
						echo "<td style='width:6%;'>";
							echo "<center>";
						
								echo "<table>
								<tr><td  style='background-color: transparent;'>
								<b style='color:red; cursor:pointer; font-size:8pt;' title='Folio Tramite'>".$r['IdTramite']."</b></td>
								<td  style='background-color: transparent;'><img src='icon/veri.png' style='width:18px; visibility: hidden;' ></td>
								</tr></table>";
							
							echo "</center>";
						echo "</td>";
					
						echo "<td style='width:10%;'>";

							echo "<b style='font-size:8pt;'>".$r['NombreTramite']."</b><br>";
							echo "<span style='font-size:8pt;'>".fecha_larga($r['Fecha'])."</span>";
						echo "</td>";

						echo "<td style='width:80%;'>";//<b style='font-size:10pt; color:darkgray;'>
							echo "<b style='font-size:10pt;'>".$r['NombreBeneficiario']."</b><br><span style='font-size:10pt;'>".$r['Curp']."</span><span style='font-size:7pt'>"."</span><br>
							<span style='color:darkblue; font-size:7pt;'>Creado por: ".nitavu_nombre($r['NitavuCaptura'])."</span><br>";
							echo "<a  style='font-size:8pt;' href='#Observaciones".$r['IdTramite']."' rel='MyModal:open' title='Clic para mostrar las observaciones que se han hecho a este trámite'>Observaciones</a>"; 
							echo "<div id='Observaciones".$r['IdTramite']."' class='MyModal'>";
							echo "<h1>Observaciones</h1>";
							$sql1 = "SELECT * FROM tramitesObservaciones WHERE IdTramite = ".$r['IdTramite']." order by Id desc ";
							$rc1= $conexion -> query($sql1); 
							if ($rc1->num_rows>0)
							{
								echo "<div style='overflow:scroll;	height:400px;'>";
								echo "<table class='tabla' style='padding: 5px; border-radius: 4px;'>";
								while($r1 = $rc1 -> fetch_array())    
								{
									echo "<tr>";
								echo "<td width=30px>";
								echo "<span title='".nitavu_nombre($r1['NitavuCaptura'])." de ".nitavu_dpto_nombre($r1['NitavuCaptura'])."'>";
								echo ponerfoto("fotos/".$r1['NitavuCaptura'].".jpg",'FotoComentario');
								echo "</span>";
								echo "</td>";
								echo "<td>";
								if($r1['Estado']==1){
								echo "<span style='font-size:9pt;' ><b  class='normal menu_font_n'>VoBo</b></span>";
								}else if ($r1['Estado']==3) {echo "<span style='font-size:9pt;' ><b class='normal menu_font_n'>Rechazdo</b></span>";}
								else if ($r1['Estado']==4) {echo "<span style='font-size:9pt;' ><b class='normal menu_font_n'>Devuelto</b></span>";}
								echo "<br><span style='font-size:8pt;' >".$r1['Observacion']."</span>";
								echo "<br><span style='font-size:7pt;' >".fecha_larga($r1['Fecha'])."|".hora12($r1['Hora'])."</span>";
								
								echo "</td>";
								echo "</tr>";

						

								}
								echo "</table>";
								echo "</div>";
							}
							
							echo "</div>";
						echo "</td>";
											
						echo "<td style='width:4%;'>";						
						echo "<input type='hidden' name='operacion' id='operacion 'value='update'>";
						echo "<input type='hidden' name='idtramite' id='idtramite 'value=".$r['IdTramite'].">";
						echo "<input type='hidden' name='tramite' id='tramite' value='".$r['IdTipoTramite']."'>";
						echo "<a class='Mbtn btn-default' href='tr_iniciar.php?edit=".$r['IdTramite']."' title='Editar'> <img src='icon/ojo1.png' style='width:20px; height:20px;'> </a>"; 
					
						echo "</td>";
					echo "</tr>";
				echo "</table>";
				echo "</div>";
								
				}
							
				echo "</div>";
	
	if ($r_count >= $paginacion)
	{
	echo "<div id='barra_paginacion'>";
		echo "Paginas: ";
			//Crea un bucle donde $i es igual 1, y hasta que $i sea menor o igual a X, a sumar (1, 2, 3, etc.)
			//Nota: X = $total_paginas
			for ($i=1; $i<=$paginas+1; $i++) {
				//En el bucle, muestra la paginación
				if ($pagina==$i)
				{
					echo "<span id='pagina_actual'>".$pagina."</span>"; //para el CSS span = a pagina actual
				}
				else
				{
				//	echo "<span id='pagina_proxima'><a href='?search=".$search."&p=".$i."'>".$i."</a></span>"; //CSS span a = link a paginas
					echo "<span id='pagina_proxima'><a href='?busqueda=".$search."&p=".$i."'>".$i."</a></span>"; //CSS span a = link a paginas
				}
			}
	echo "</div></center>";
	}
	}
}

echo "<br><br>";
$mas="";

// si es nivel 1 muestra las pestañas
if($nivel == 1 or $nivel==3  or $nivel==4)
{
	echo "<div id='pesta_elementos'>";

	if (isset($_GET['n'])){
			$mas="&n=";
	}
	if (isset($_GET['pes'])) {
			if ($_GET['pes']=='pendientes'){
				echo "<a class='seleccionada' href='?pes=pendientes".$mas."' id='pespendientes'>Pendientes</a>";	
				//if($nivel == 1){echo "<a class='sinseleccion' href='?pes=capturados".$mas."'>Capturados por mi dpto</a>";}
				if($nivel == 4){echo "<a class='sinseleccion' href='?pes=vobo".$mas."'>VoBo</a>";}
				echo "<a class='sinseleccion' href='?pes=aprobados".$mas."'>Aprobados</a>";		
				echo "<a class='sinseleccion' href='?pes=rechazados".$mas."'>Rechazados</a>";		
				
			}	
		
			if ($_GET['pes']=='vobo'){
				echo "<a class='seleccionada' href='?pes=pendientes".$mas."' id='pespendientes'>Pendientes</a>";	
				//if($nivel == 1){echo "<a class='sinseleccion' href='?pes=capturados".$mas."'>Capturados por mi dpto</a>";}
				if($nivel == 4){echo "<a class='seleccionada' href='?pes=vobo".$mas."'>VoBo</a>";}
				echo "<a class='sinseleccion' href='?pes=aprobados".$mas."'>Aprobados</a>";		
				echo "<a class='sinseleccion' href='?pes=rechazados".$mas."'>Rechazados</a>";		
				
			}	
		
			/*if ($_GET['pes']=='capturados'){
				echo "<a class='sinseleccion' href='?pes=pendientes".$mas."' id='pespendientes'>Pendientes</a>";	
				if($nivel == 1){echo "<a class='seleccionada' href='?pes=capturados".$mas."'>Capturados por mi dpto</a>";}
				if($nivel == 4){echo "<a class='sinseleccion' href='?pes=vobo".$mas."'>VoBo</a>";}	
				echo "<a class='sinseleccion' href='?pes=aprobados".$mas."'>Aprobados</a>";	
				echo "<a class='sinseleccion' href='?pes=rechazados".$mas."'>Rechazados</a>";	
					
			}	*/
			if ($_GET['pes']=='aprobados'){
				echo "<a class='sinseleccion' href='?pes=pendientes".$mas."' id='pespendientes'>Pendientes</a>";	
				//if($nivel == 1){echo "<a class='sinseleccion' href='?pes=capturados".$mas."'>Capturados por mi dpto</a>";}
				if($nivel == 4){echo "<a class='sinseleccion' href='?pes=vobo".$mas."'>VoBo</a>";}
				echo "<a class='seleccionada' href='?pes=aprobados".$mas."'>Aprobados</a>";	
				echo "<a class='sinseleccion' href='?pes=rechazados".$mas."'>Rechazados</a>";		
					
			}	
			if ($_GET['pes']=='rechazados'){
				echo "<a class='sinseleccion' href='?pes=pendientes".$mas."' id='pespendientes'>Pendientes</a>";	
				//if($nivel == 1){echo "<a class='sinseleccion' href='?pes=capturados".$mas."'>Capturados por mi dpto</a>";}
				if($nivel == 4){echo "<a class='sinseleccion' href='?pes=vobo".$mas."'>VoBo</a>";}
				echo "<a class='sinseleccion' href='?pes=aprobados".$mas."'>Aprobados</a>";	
				echo "<a class='seleccionada' href='?pes=rechazados".$mas."'>Rechazados</a>";				
			}	
		}else
		{
			echo "<a class='seleccionada' href='?pes=pendientes".$mas."' id='pespendientes'>Pendientes</a>";	
			//if($nivel == 1){echo "<a class='sinseleccion' href='?pes=capturados".$mas."'>Capturados por mi dpto</a>";}
			if($nivel == 4){echo "<a class='sinseleccion' href='?pes=vobo".$mas."'>VoBo</a>";}			
			 echo "<a class='sinseleccion' href='?pes=aprobados".$mas."'>Aprobados</a>";		
			 echo "<a class='sinseleccion' href='?pes=rechazados".$mas."'>Rechazados</a>";
			echo "<div id='pesta1' class='pesta visible' style='width:100%;'>";	
			$pes='pendientes';	
		}



	//DIV CASOS PENDIENTES
		if (isset($_GET['pes']) ) {
			if ($_GET['pes']=='pendientes'){		
				echo "<div id='pesta1' class='pesta visible' style='width:100%;'>";
				}
		//	else
		// 	{echo "<div id='pesta1' class='pesta invisible'>";}
		}

	//DIV EN LOS QUE CAPTURADOS
		if (isset($_GET['pes'])) {
			if ($_GET['pes']=='capturados'){echo "<div id='pesta1' class='pesta visible' style='width:100%;'> ";	}
		//else
		//{echo "<div id='pesta1' class='pesta invisible'>";}
		}

		//DIV EN LOS QUE VObO
		if (isset($_GET['pes'])) {
			if ($_GET['pes']=='vobo'){echo "<div id='pesta1' class='pesta visible' style='width:100%;'> ";	}
		//else
		//{echo "<div id='pesta1' class='pesta invisible'>";}
		}
		

		//DIV EN LOS QUE APROBADOS
		if (isset($_GET['pes'])) {
			if ($_GET['pes']=='aprobados'){echo "<div id='pesta1' class='pesta visible' style='width:100%;'> ";	}
		//else
		//{echo "<div id='pesta1' class='pesta invisible'>";}
		}
		//DIV EN LOS QUE APROBADOS
		if (isset($_GET['pes'])) {
			if ($_GET['pes']=='rechazados'){echo "<div id='pesta1' class='pesta visible' style='width:100%;'> ";	}
		//else
		//{echo "<div id='pesta1' class='pesta invisible'>";}
		}
	}
	else
	{
		echo "<div  class='pesta ' style='width:100%;'>";
	}



 



//************** SOLICITUDES PENDIENTES 	
echo "<div id='tramitesPendientes'>";
$dpto = nitavu_dpto($nitavu);
if($nivel==3){ // ESTE NIVEL SOLO PUEDE ENVIAR
	$sql = "SELECT tramites.IdTramite, tramitestipo.NombreTramite, tramites.Curp, tramites.NombreBeneficiario, tramites.Fecha, tramites.NitavuCaptura,tramites.IdTipoTramite,tramites.Estado, tramites.VoBo1, 'x' as result
	,tramitestipo.Programa,tramitestipo.IdPrograma, tramitestipo.Formato FROM  tramites INNER JOIN  tramitestipo 
	ON tramites.IdTipoTramite=tramitestipo.IdTipoTramite 
	 WHERE (tramites.Estado=0 or tramites.Estado=4) and tramites.DptoCaptura =".$dpto." order by tramitestipo.IdPrograma asc,tramites.IdTramite desc";
}else 

if($nivel == 2){
	/*	$sql = "SELECT tramites.IdTramite, tramitestipo.NombreTramite, tramites.Curp, tramites.NombreBeneficiario, tramites.Fecha, tramites.NitavuCaptura,tramites.IdTipoTramite,tramites.Estado, tramites.VoBo1, tramites.VoBo2, tramites.VoBo3, tramites.VoBo4, tramites.VoBo5 
	FROM tramites 
	INNER JOIN tramitestipo ON tramites.IdTipoTramite=tramitestipo.IdTipoTramite 
	WHERE (tramites.Estado=1 AND (tramites.VoBo1='' OR tramites.VoBo2='' OR tramites.VoBo3='' OR tramites.VoBo4='' OR tramites.VoBo5='')) OR (tramites.Estado=1 AND (tramitestipo.VoBo1 = ".nitavu_dpto($nitavu)." OR tramitestipo.VoBo2 = ".nitavu_dpto($nitavu)." OR tramitestipo.VoBo3 = ".nitavu_dpto($nitavu)." OR tramitestipo.VoBo4 = ".nitavu_dpto($nitavu)." OR tramitestipo.VoBo5 = ".nitavu_dpto($nitavu)."))
	ORDER BY tramites.IdTramite DESC";*/
	//(tramites.Estado=1 AND (tramites.VoBo1='' OR tramites.VoBo2='' OR tramites.VoBo3='' OR tramites.VoBo4='' OR tramites.VoBo5='')) OR
	$sql = "SELECT tramites.IdTramite, tramitestipo.NombreTramite, tramites.Curp, tramites.NombreBeneficiario, tramites.Fecha, 
	tramites.NitavuCaptura,tramites.IdTipoTramite,tramites.Estado, tramites.VoBo1, tramites.VoBo2, tramites.VoBo3, tramites.VoBo4, tramites.VoBo5,
	IF(tramitestipo.VoBo1 = ".nitavu_dpto($nitavu).",'VoBo1',IF(tramitestipo.VoBo2 = ".nitavu_dpto($nitavu).",'VoBo2', IF(tramitestipo.VoBo3 = ".nitavu_dpto($nitavu).",'VoBo3', IF(tramitestipo.VoBo4 = ".nitavu_dpto($nitavu).",'VoBo4', IF(tramitestipo.VoBo5 = ".nitavu_dpto($nitavu).",'VoBo5','No'))))) as result
	,tramitestipo.Programa,tramitestipo.IdPrograma, tramitestipo.Formato FROM tramites 
	INNER JOIN tramitestipo ON tramites.IdTipoTramite=tramitestipo.IdTipoTramite 
	WHERE tramites.Estado=1
	ORDER BY tramites.IdTramite DESC
	";
}
else if($nivel ==1 ){ // ESTE NIVEL PUEDE APROBAR SI EL DPTO ESTA EN LA TABLA DE TRAMITESTIPO -> IdDptoEjecucion
	//else
	//	{
		//TRAMITES PENDIENTES
		$sql = "SELECT tramites.IdTramite, tramitestipo.NombreTramite, tramites.Curp, tramites.NombreBeneficiario, tramites.Fecha, tramites.NitavuCaptura,tramites.IdTipoTramite,tramites.Estado, tramites.VoBo1, 'x' as result
		,tramitestipo.Programa,tramitestipo.IdPrograma, tramitestipo.Formato
		FROM  tramites INNER JOIN  tramitestipo 
		ON tramites.IdTipoTramite=tramitestipo.IdTipoTramite 
		 WHERE 	tramites.Estado=1  or (tramites.Estado=0 and  tramites.DptoCaptura = ".nitavu_dpto($nitavu).")
		order by tramitestipo.Programa asc,tramitestipo.IdTipoTramite asc ,tramites.IdTramite asc";

		}
	if($nivel==4){
			$sql = "SELECT tramites.IdTramite, tramitestipo.NombreTramite, tramites.Curp, tramites.NombreBeneficiario, tramites.Fecha, tramites.NitavuCaptura,tramites.IdTipoTramite,tramites.Estado, tramites.VoBo1, 'x' as result
			,tramitestipo.Programa,tramitestipo.IdPrograma, tramitestipo.Formato FROM  tramites INNER JOIN  tramitestipo 
			ON tramites.IdTipoTramite=tramitestipo.IdTipoTramite 
			 WHERE (tramites.Estado=0 or tramites.Estado=4)  order by tramitestipo.IdPrograma asc,tramites.IdTramite desc";
	}
	
	 // TRAMITES CAPTURADOS
	 if (isset($_GET['pes']))
	  {
		  
		if ($_GET['pes']=='capturados')
		{
			$sql = "SELECT tramites.IdTramite, tramitestipo.NombreTramite, tramites.Curp, tramites.NombreBeneficiario, tramites.Fecha, tramites.NitavuCaptura,tramites.IdTipoTramite,tramites.Estado, tramites.VoBo1, 'x' as result
			,tramitestipo.Programa,tramitestipo.IdPrograma, tramitestipo.Formato
			FROM  tramites INNER JOIN  tramitestipo 
			ON tramites.IdTipoTramite=tramitestipo.IdTipoTramite 
			 WHERE 	tramites.NitavuCaptura=".$nitavu." and tramites.Estado=0 or tramites.Estado=1
			order by tramitestipo.Programa asc,tramitestipo.IdTipoTramite asc ,tramites.IdTramite asc";
			
		}
		// TRAMITES VOBO
		if ($_GET['pes']=='vobo')
		{
			$sql = "SELECT tramites.IdTramite, tramitestipo.NombreTramite, tramites.Curp, tramites.NombreBeneficiario, tramites.Fecha, tramites.NitavuCaptura,tramites.IdTipoTramite,tramites.Estado, tramites.VoBo1, 'x' as result
			,tramitestipo.Programa,tramitestipo.IdPrograma, tramitestipo.Formato
			FROM  tramites INNER JOIN  tramitestipo 
			ON tramites.IdTipoTramite=tramitestipo.IdTipoTramite 
			 WHERE  tramites.Estado=1 
			order by tramitestipo.Programa asc,tramitestipo.IdTipoTramite asc ,tramites.IdTramite asc";
			
		}
		//TRAMITES APROBADOS
		else if ($_GET['pes']=='aprobados')
		{
			$sql = "SELECT tramites.IdTramite, tramitestipo.NombreTramite, tramites.Curp, tramites.NombreBeneficiario, tramites.Fecha, tramites.NitavuCaptura,tramites.IdTipoTramite,tramites.Estado, tramites.VoBo1, 'x' as result
			,tramitestipo.Programa,tramitestipo.IdPrograma, tramitestipo.Formato
			FROM  tramites INNER JOIN  tramitestipo 
			ON tramites.IdTipoTramite=tramitestipo.IdTipoTramite 
			 WHERE 	tramites.Estado=2 
			order by tramitestipo.Programa asc,tramitestipo.IdTipoTramite asc ,tramites.IdTramite asc";
			
		}
		//TRAMITES RECHAZADOS
		else if ($_GET['pes']=='rechazados')
		{
			$sql = "SELECT tramites.IdTramite, tramitestipo.NombreTramite, tramites.Curp, tramites.NombreBeneficiario, tramites.Fecha, tramites.NitavuCaptura,tramites.IdTipoTramite,tramites.Estado, tramites.VoBo1, 'x' as result
			,tramitestipo.Programa,tramitestipo.IdPrograma, tramitestipo.Formato
			FROM  tramites INNER JOIN  tramitestipo 
			ON tramites.IdTipoTramite=tramitestipo.IdTipoTramite 
			WHERE 	tramites.Estado=3 
			order by tramitestipo.Programa asc,tramitestipo.IdTipoTramite asc ,tramites.IdTramite asc";
		
		}
		
	}
 echo $sql;


$rc= $conexion -> query($sql); 
$r_count = $rc -> num_rows;
if ($rc->num_rows>0)
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
        //echo $paginacion;
        // agregamos limite a la consulta
        $sql = $sql." LIMIT ".$empezar_desde.", ".$paginacion;
        //echo $sql;
        $r = $conexion -> query($sql);
        
        $paginas = ceil(($r_count / $paginacion));
        //historia($nitavu,'cp_Busqueda de '.$search);
        

	$idprograma=0;
	//echo $sql;

	echo "<center>";
	//echo "<h1>Pendientes</h1>";
	echo "<div><table class='tabla'>";
	// echo "<th width='10%'></th>";
	// echo "<th width='10%'></th>";
	// echo "<th ></th>";
	// echo "<th width='300px'></th>";
	
	$idprograma='';
  while($r = $rc -> fetch_array())    
  {
	

	if($r['result']=='No'){

	}else if($r['result']=='x' or revisarSiTieneVistoBueno($r['result'], $r['IdTramite'])== '' ){
		
		if($idprograma<>$r['IdPrograma'] or $idprograma=='') 
		{
			//echo "<tr style='background:white; height:50px;'><td colspan='4' style='font-size:18px; font-weight: bold; text-align: center; background-color: transparent;'></td></tr>";
			echo "<tr style='background:white; height:50px;'><td colspan='4' style='font-size:18px; font-weight: bold; font-family: verdana; text-align: center; background-color: transparent;'>".$r['Programa']."</td></tr>";
			$idprograma=$r['IdPrograma'];
		
		}
		if( $idprograma==$r['IdPrograma'] )
		{
			//----RESALTAR LOS DEVUELTOS
			if($r['Estado']==4){
				echo "<tr id='Registro".$r['IdTramite']."' style='background-color:red;'>";
			}else{
				echo "<tr id='Registro".$r['IdTramite']."'>";
			}
					
				echo "<td>";
				
				echo "<center>";
				//Porcentaje de Avance:
			
				$Porcentaje = ProcentajeTramite($r['IdTramite'],$r['IdTipoTramite']);
				
				
					
					echo "<table>
					<tr><td  style='background-color: transparent;'><b style='font-size:15pt; font-weight:bold;'>".$Porcentaje."%</b><br>
					<b style='color:red; cursor:pointer; font-size:8pt;' title='Folio Tramite'>".$r['IdTramite']."</b></td>
					<td  style='background-color: transparent;'><img src='icon/veri.png' style='width:18px; visibility: hidden;' ></td>
					</tr></table>";
				
				echo "</center>";
				echo "</td>";
			
				echo "<td>";
				echo "<b style='font-size:12pt;'>".$r['NombreTramite']."</b><br>";
				
				echo fecha_larga($r['Fecha'])."<br>";
				echo "<span style='color:gray; font-size:10pt;'>".nitavu_dpto_nombre($r['NitavuCaptura'])."</span><br>";
				echo "</td>";
				//<span style='color:darkblue; font-size:7pt;'>Creado por: ".nitavu_nombre($r['NitavuCaptura'])."</span><br>";
				echo "<td><b style='font-size:12pt;'>".$r['NombreBeneficiario']."</b><br><b>".$r['Curp']."</b><span style='font-size:7pt'>"."</span>";
				
				echo "<br><a style=' padding-left: 0px; ' href='#Observaciones".$r['IdTramite']."' rel='MyModal:open' title='Clic para mostrar las observaciones que se han hecho a este trámite'>Observaciones</a>"; 
				echo "<div id='Observaciones".$r['IdTramite']."' class='MyModal'>";
				echo "<h1>Observaciones</h1>";
				echo "<a type='button' id='btn' value='Print' onclick='printDiv(".$r['IdTramite'].");' ><img src='icon/pdf.png' style='width:25px;'></a>";
				//				echo "<div style='text-align: right;'><a type='button' id='btn' value='Print' onclick='printDiv(".$r['IdTramite'].");' ><img src='icon/pdf.png' style='width:25px;'></a></div>";

				$sql1 = "SELECT * FROM tramitesObservaciones WHERE IdTramite = ".$r['IdTramite']." order by Id desc ";
				$rc1= $conexion -> query($sql1); 
				if ($rc1->num_rows>0)
				{
					echo "<div style='overflow:scroll;	height:400px;'>";
					echo "<table class='tabla' style='padding: 5px; border-radius: 4px;'>";
					while($r1 = $rc1 -> fetch_array())    
					{
						echo "<tr>";
					echo "<td width=30px>";
					echo "<span title='".nitavu_nombre($r1['NitavuCaptura'])." de ".nitavu_dpto_nombre($r1['NitavuCaptura'])."'>";
					echo ponerfoto("fotos/".$r1['NitavuCaptura'].".jpg",'FotoComentario');
					echo "</span>";
					echo "</td>";
					echo "<td>";
					if($r1['Estado']==1){
					echo "<span style='font-size:9pt;' ><b  class='normal menu_font_n'>VoBo</b></span>";
					}else if ($r1['Estado']==3) {echo "<span style='font-size:9pt;' ><b class='normal menu_font_n'>Rechazdo</b></span>";}
					else if ($r1['Estado']==4) {echo "<span style='font-size:9pt;' ><b class='normal menu_font_n'>Devuelto</b></span>";}
					echo "<br><span style='font-size:8pt;' >".$r1['Observacion']."</span>";
					echo "<br><span style='font-size:7pt;' >".fecha_larga($r1['Fecha'])."|".hora12($r1['Hora'])."</span>";
					
					// echo "<span style='font-size:8pt;' title='".fecha_larga($Cm['Fecha'])."|".hora12($Cm['Hora'])."'>".$Cm['Comentario']."</span>";
					echo "</td>";
					echo "</tr>";


					}
					echo "</table>";
					echo "</div>";
				}

			echo "</div>";

					//---------------DIV PARA IMPRIMIR OBSERVACIONES
					echo "<div id='imprimir".$r['IdTramite']."' style='display:none;'>";
						echo "<center><span style='font-size:12pt;'><b>Observaciones del trámite (".$r['IdTramite'].") ".$r['NombreTramite']." ".$r['Programa']." </b></span>";
						echo "<span style='font-size:11pt;'><br>Beneficiario:  ".$r['NombreBeneficiario']."</span></center>";
						$sql1 = "SELECT * FROM tramitesObservaciones WHERE IdTramite = ".$r['IdTramite']." order by Id desc ";
						$rc1= $conexion -> query($sql1); 
						if ($rc1->num_rows>0)
						{
							echo "<div><br><br>";
							echo "<table class='tabla' style='padding: 5px; border-radius: 4px;'>";
							while($r1 = $rc1 -> fetch_array())    
							{
							echo "<tr>";
								echo "<td style='border-top-width:1px; border-bottom-width:2px;'>";
																
									if($r1['Estado']==1){echo "<span style='font-size:12pt;' ><b  class='normal menu_font_n'>VoBo</b></span>";
									}else if ($r1['Estado']==3) {echo "<span style='font-size:12pt;' ><b class='normal menu_font_n'>Rechazdo</b></span>";}
									else if ($r1['Estado']==4) {echo "<span style='font-size:12pt;' ><b class='normal menu_font_n'>Devuelto</b></span>";}
									echo "<span style='font-size:10pt;'><br>Por: ".nitavu_nombre($r1['NitavuCaptura'])." de ".nitavu_dpto_nombre($r1['NitavuCaptura'])."</span>";
									echo "<br><span style='font-size:10pt;' >Observación: ".$r1['Observacion']."</span>";
									echo "<br><span style='font-size:8pt;' >".fecha_larga($r1['Fecha'])."|".hora12($r1['Hora'])."</span>";
								echo "</td>";
							echo "</tr>";


							}
							echo "</table>";
							echo "</div>";
						}
						
					echo "</div>";

				//SI ES LA PRESOLICITUD PEDIMOS AHORRO PREVIO Y TIEMPO 
				if(TramitePreSolicitud($r['IdTramite'])==1 and $r['Estado']==1){
					echo "<br><a style=' padding-left: 0px; ' href='#AhorroPrevio".$r['IdTramite']."' rel='MyModal:open' title='Clic para capturar ahorro previo a trámite'>Ahorro previo</a>"; 
					echo "<div id='AhorroPrevio".$r['IdTramite']."' class='MyModal'>";
						echo "<h1>Ahorro previo</h1>";
						echo '<form action="tramites.php" method="POST">';
						echo '<input type="hidden" id="IdTramite" name="IdTramite" value="'.$r['IdTramite'].'">';
							echo '<div style="width:100%;">';
						$q = "SELECT * FROM tramites WHERE IdTramite = ".$r['IdTramite']."";
						$res= $conexion -> query($q); 	
						while($f = $res -> fetch_array()){
							echo '<div><label>Ahorro previo</label>';
							echo '<input id="ahorro" name="ahorro" value="'.$f['AhorroPrevio'].'"></div>';
							echo '<div><label>Tiempo en meses</label>';
							echo '<input id="tiempo" name="tiempo" value="'.$f['Tiempo'].'"></div>';
							echo '</div>';
						
						}
							echo "<input type='submit' value='Guardar' class='Mbtn btn-default' style='width:100px;'>";
						echo '</form>';
					echo "</div>";
				}
				











				echo "</td>";
				
				
				
				
				echo "<td>";
				
				//echo $r['QuiendioVoBo'];		
				echo "<input type='hidden' name='operacion' id='operacion 'value='update'>";
				echo "<input type='hidden' name='idtramite' id='idtramite 'value=".$r['IdTramite'].">";
				echo "<input type='hidden' name='tramite' id='tramite' value='".$r['IdTipoTramite']."'>";
				echo "<a class='Mbtn btn-default' href='tr_iniciar.php?edit=".$r['IdTramite']."' title='Editar'> <img src='icon/ojo1.png' style='width:20px; height:20px;'> </a>"; 
				
				// echo " <a class='Mbtn btn-tercero'  href='tr_iniciar.php?edit=".$r['IdTramite']."' title='Imprimir Solicitud'> <img src='icon/imprimir.png' style='width:20px; height:20px;'> </a>"; 
				
				if($r['Estado']==0 or $r['Estado']==4 and ($nivel==1 or $nivel==3)){

					echo " <a  href='#enviarTramite".$r['IdTramite']."' rel='MyModal:open' class='Mbtn btn-azulTam' title='Clic para Enviar'> <img src='icon/btn_derecha.png' style='width:20px; height:20px;'>"; 
					echo "</a>";
					// ************Modal Enviar Tramite*********** Cada modal se escribe con id diferente, asi como cada form, concatene el IdTramite
					echo "<div id='enviarTramite".$r['IdTramite']."' class='MyModal'><h3>Enviar Tramite </h3>";
					$NombreDelRequisito='AcuseSolicitud';					
					$Descripcion='Subir Acuse del Tramite (Firmado por el Beneficiario)';
					$IdRequisito='AcuseSolicitud';
					$FolioTramite=$r['IdTramite'];
					
					$vinculo='';
					$TipoTramite=$r['IdTipoTramite'];			
					echo "<center>";
					echo "<div id='contenedor' style='width:100%'>";	
						echo "<div id='mostrararchivo' style='width:50%; display:inline-block;'>";
							if($r['Formato']<>''){
								echo "<iframe id='frame' name='frame' src='".$r['Formato']."?folio=".$FolioTramite."'
							style='width:100%; height:50%; border:0; border:none;'>Tu navegador no soporta iframes...</iframe>";
							}else{
								echo "<iframe id='frame' name='frame' src=''
							style='width:100%; height:50%; border:0; border:none;'>Tu navegador no soporta iframes...</iframe>";
							}
							
						echo "</div>";//cierra mostrar archivo					
							echo "<div id='subirarchivo' style='width:45%; display:inline-block; vertical-align: top; margin:5px; padding:10px;'>";	
									echo "<table width=100%><tr><td><div  id='subir'>";		
									echo "<label>".$Descripcion."</label>";					
									echo "<form method='POST' action='' enctype='multipart/form-data' id='Form".$FolioTramite."' name='Form".$FolioTramite."' >";
									echo '<input type="file"  name="'.$IdRequisito.$FolioTramite.'" id="'.$IdRequisito.$FolioTramite.'"  onchange=SubirArchivo('.$FolioTramite.','.$TipoTramite.',"'.$IdRequisito.'","botonenviar") >';
									echo "</form>";
									echo "</div></td><td>";			
								$vinculo = "<a href='tramitesFiles/".$IdRequisito.$FolioTramite.".pdf' download='".$IdRequisito.$FolioTramite.".pdf' target=_blank><img src='icon/pdf.png' style='width:36px;'></a>";
								echo "<div id='Loader".$IdRequisito.$FolioTramite."' style='display:none;'><img src='img/loader_bar.gif' style='width:18px;'></div>";
								echo "<div id='PDF".$IdRequisito.$FolioTramite."' style='display:none;'>".$vinculo."</div></td></tr>";
								echo "<tr><td><center><div  id='botonenviar".$FolioTramite."' style='display:none;' >";
								echo"<a class='Mbtn btn-azulTam' onclick='ValidarTramite(".$r['IdTramite'].",".$r['IdTipoTramite'].")' title='Enviar al Dpto Correspondiente'><img src='icon/btn_derecha.png' style='width:20px; height:20px;'> Enviar </a></div></center></td></tr>";
								echo "</table>";					
							echo "</div>"; //cierra  subir archivo
						echo "</div>"; //cierra contenedor
					echo "<center>";
				echo "</div>";


					//echo " <a id='botonEnviar' class='Mbtn btn-azulTam'  onclick='ValidarTramite(".$r['IdTramite'].",".$r['IdTipoTramite'].")'  title='Enviar al Dpto Correspondiente'> <img src='icon/check.png' style='width:20px; height:20px;'>  </a>";
					//echo " <a id='botonImprimir' class='Mbtn btn-secundario' href='tr_formato.php?folio=".$r['IdTramite']."'  title='Imprimir Formato' target='black'> <img src='icon/embarques_print.png' style='width:20px; height:20px;'>  </a>";  
				}
				
				if($r['Estado']==1 and $nivel==2 ){
					echo " <a id='Vobo".$r['IdTramite']."' href='#vistoBueno".$r['IdTramite']."' rel='MyModal:open' class='Mbtn btn-azulTam' title='Clic para marcar con Visto Bueno'> <img src='icon/Vistobueno.png' style='width:20px; height:20px;'></a>"; 
					//------------Modal agregar observaciones para visto bueno
					echo "<div id='vistoBueno".$r['IdTramite']."' class='MyModal'>";
					echo '<label>Observaciones...</label>';
					echo "<textarea id='Obs".$r['IdTramite']."'></textarea>";
					echo " <center><a class='Mbtn btn-azulTam' onclick='DarVistoBueno(".$r['IdTramite'].", ".$nitavu.", ".$r['IdTipoTramite'].")' title='Clic para marcar con Visto Bueno'> Guardar </a></center>"; 
					echo "</div>";
				}


				
				if($nivel == 1 and $r['Estado'] == 1){
					
					$NombreDeTarjeta = TramiteAcuse1Name($r['IdTipoTramite']);	;
				
					if ($NombreDeTarjeta <> '' ){		
					
					echo " <a  href='#aprobarTramite".$r['IdTramite']."' rel='MyModal:open' class='Mbtn btn-azulTam' title='Clic para Aprobar'> <img src='icon/ok.png' style='width:20px; height:20px;'>"; 
					echo "</a>";
					// ************Modal Aprobar Tramite*********** Cada modal se escribe con id diferente, asi como cada form, concatene el IdTramite
					echo "<div id='aprobarTramite".$r['IdTramite']."' class='MyModal'><h3>Aprobar Tramite </h3>";
					$NombreDelRequisito='Tarjeta de autorización';					
					$Descripcion='Subir Tarjeta de autorización';
					$IdRequisito='TarjetaAutorizacion';
					$FolioTramite=$r['IdTramite'];
					
					$vinculo='';
					$TipoTramite=$r['IdTipoTramite'];			

					echo "<div id='contenedor' style='width:100%'>";
						echo "<div id='mostrararchivo' style='width:50%; display:inline-block;'>";
							echo "<iframe id='frame' name='frame' src='".$NombreDeTarjeta."?folio=".$FolioTramite."'
							style='width:100%; height:50%; border:0; border:none;'>Tu navegador no soporta iframes...</iframe>";
						echo "</div>";//cierra mostrar archivo

						echo "<div id='subirarchivo' style='width:45%; display:inline-block; vertical-align: top; margin:5px; padding:10px;'>";	
							echo "<table width=100%><tr><td><div  id='subir'>";		
							echo "<label>".$Descripcion."</label>";					
							echo "<form method='POST' action='' enctype='multipart/form-data' id='Form".$FolioTramite."' name='Form".$FolioTramite."' >";
							echo '<input type="file"  name="'.$IdRequisito.$FolioTramite.'" id="'.$IdRequisito.$FolioTramite.'"  onchange=SubirArchivo('.$FolioTramite.','.$TipoTramite.',"'.$IdRequisito.'","botonaprobar") >';
							echo "</form>";
							echo "</div></td><td>";			
						$vinculo = "<a href='tramitesFiles/".$IdRequisito.$FolioTramite.".pdf' download='".$IdRequisito.$FolioTramite.".pdf' target=_blank><img src='icon/pdf.png' style='width:36px;'></a>";
						echo "<div id='Loader".$IdRequisito.$FolioTramite."' style='display:none;'><img src='img/loader_bar.gif' style='width:18px;'></div>";
						echo "<div id='PDF".$IdRequisito.$FolioTramite."' style='display:none;'>".$vinculo."</div></td></tr>";
						echo "<tr><td><center><div  id='botonaprobar".$FolioTramite."' style='display:none;' >";
						echo"<a class='Mbtn btn-azulTam' onclick='AprobarTramite(".$r['IdTramite'].",".$r['IdTipoTramite'].", ".$idprograma.")' title='Clic para aprobar'><img src='icon/ok.png' style='width:20px; height:20px;'> Aprobar </a></div></center></td></tr>";
						echo "</table>";
					
						$Nombres = TramiteNombres($FolioTramite);
						$Apellido1 = TramiteApellido1($FolioTramite);
						$Apellido2= TramiteApellido2($FolioTramite);
						$NombreCompleto = $Nombres." ".$Apellido1." ".$Apellido2;
						echo "<br><hr><b style='font-size:9pt; color:green;'>Sugerencia antes de aprobar: </b> <a target=_blank class='Mbtn btn-secundario' href='beneficiarios.php?search=".$NombreCompleto."'><table border=0><tr> src='icon/benes2.png' style='width:40px;'></td><td> Buscar información de ".$NombreCompleto."</td></tr></table></a>";
						echo "<label>* Se buscaran coincidencias de acuerdo al nombre en todas las delegaciones disponibles; tenga en cuenta que puede haber homonimos, o que no coincida por errores de captura del nombre</label>";

						
							echo "</div>"; //cierra  subir archivo
						echo "</div>"; //cierra contenedor
				echo "</div>";

					}else{
						echo"<a class='Mbtn btn-azulTam' onclick='AprobarTramite(".$r['IdTramite'].",".$r['IdTipoTramite'].",".$idprograma.")' title='Clic para aprobar'><img src='icon/ok.png' style='width:20px; height:20px;'></a>";
					}	 

					echo " <a id='RechazarTramite".$r['IdTramite']."' href='#rechazarTramite".$r['IdTramite']."' rel='MyModal:open' class='Mbtn btn-azulTam' title='Clic para marcar como rechazdo'> <img src='icon/x.png' style='width:20px; height:20px;'></a>"; 
					//------------Modal observaciones para rechazar tramite
					echo "<div id='rechazarTramite".$r['IdTramite']."' class='MyModal'>";
					echo '<label>Observaciones para rechazar el trámite...</label>';
					echo "<textarea id='obsRechazado".$r['IdTramite']."'></textarea>";
					echo " <center><a class='Mbtn btn-azulTam' onclick='RechazarTramite(".$r['IdTramite'].",".$r['IdTipoTramite'].")' title='Clic para marcar como rechazdo'> Guardar </a></center>"; 
					echo "</div>";

					echo " <a id='DevolverTramite".$r['IdTramite']."' href='#devolverTramite".$r['IdTramite']."' rel='MyModal:open' class='Mbtn btn-azulTam' title='Clic para marcar como devuelto'> <img src='icon/devolver.png' style='width:20px; height:20px;'></a>"; 
					//------------Modal observaciones para rechazar tramite
					echo "<div id='devolverTramite".$r['IdTramite']."' class='MyModal'>";
					echo '<label>Observaciones para devolver el trámite...</label>';
					echo "<textarea id='obsDevuelto".$r['IdTramite']."'></textarea>";
					echo " <center><a class='Mbtn btn-azulTam'  onclick='DevolverTramite(".$r['IdTramite'].",".$r['IdTipoTramite'].")'  title='Clic para marcar como devuelto'> Guardar </a></center>"; 
					echo "</div>";

					//echo " <a class='Mbtn btn-azulTam' onclick='RechazarTramite(".$r['IdTramite'].",".$r['IdTipoTramite'].")'  title='Clic para rechazar'> <img src='icon/x.png' style='width:20px; height:20px;'></a>"; 
					//echo " <a class='Mbtn btn-azulTam' onclick='DevolverTramite(".$r['IdTramite'].",".$r['IdTipoTramite'].")' title='Clic para devolver'> <img src='icon/devolver.png' style='width:20px; height:20px;'></a>"; 

			
				}
				// echo "</form>";
				echo "</td>";
			echo "</tr>";
			$idprograma=$r['IdPrograma'];
			
			//}
		}
		
		}
		
	
  }
	  echo "</table>";
	  echo "</div></center>";
} 

if ($r_count >= $pags)
{
echo "<center><div id='barra_paginacion'>";
	echo "Paginas: ";
		//Crea un bucle donde $i es igual 1, y hasta que $i sea menor o igual a X, a sumar (1, 2, 3, etc.)
		//Nota: X = $total_paginas
		for ($i=1; $i<=$paginas; $i++) {
			//En el bucle, muestra la paginación
			if ($pagina==$i){
				echo "<span id='pagina_actual'>".$pagina."</span>"; //para el CSS span = a pagina actual
			}else{
			//	echo "<span id='pagina_proxima'><a href='?search=".$search."&p=".$i."'>".$i."</a></span>"; //CSS span a = link a paginas
				echo "<span id='pagina_proxima'><a href='?p1=".$i."&pes=creados'>".$i."</a></span>"; //CSS span a = link a paginas
			}
		}
echo "</div></center>";
}

echo "</div>";

echo "</div>";



// ************Modal**************
echo "<div id='iniciarTramite' class='MyModal'><h3>Agregar nueva solicitud: </h3>";

/*********Al buscar por CURP*******************/
echo "<form action='tr_iniciar.php' method='POST'>";

	//CURP
	echo "<div>";
	echo '<label>Ingresa la CURP de la persona que realizara el Tramite:</label>';
	echo "<input type='text' id='_curp' name='_curp' value='' maxlength='18' onkeyup='mayus(this);' required>";
	echo "<input type='hidden' id='user' name='user' value='".$nitavu."'>";
	echo "</div>";

	//Seleccion del Tramite
	echo "<div style='margin:10px;width:100%;'>";
	$MiIdDpto = nitavu_dpto($nitavu);
	$sql = "select * from tramitestipo WHERE Cancelado=0
	order by IdPrograma, IdTipoTramite";	
	echo "<label>Selecciona El Tramite</label>";
	echo "<select id='IdTramite' name='IdTramite' onchange='ValidarTramiteSeleccionar();'>";
	$r= $conexion -> query($sql);	while($f = $r -> fetch_array()) {
		//validar Delegacion IdDto de cat_gerarquia
		$IdTipoTramite = $f['IdTipoTramite']; $IdDpto = nitavu_dpto($nitavu);
		if ( TramiteDptoBloqueado($IdTipoTramite, $IdDpto) == TRUE ) {
			echo "<script>console.log('Tramite Bloqueado: ".$IdTipoTramite."');</script>";
		} else {

			if ($f['IdDelegacionDpto'] == ''){
				echo "<option value='".$f['IdTipoTramite']."'>".$f['Programa']." - ".$f['NombreTramite']."</option>";
			}

			if ($f['IdDelegacionDpto'] == $MiIdDpto){
				echo "<option value='".$f['IdTipoTramite']."'>".$f['Programa']." - ".$f['NombreTramite']."</option>";
			}
		}

	}
	echo "</select>";
	
	echo "</div>";

	echo "<div>";
	echo "<input type='submit' value='Siguiente' class='Mbtn btn-azulTam'>";
	echo "</div>";

echo "</form>";

echo "</div>";




P$tramite=0;
if(isset($_GET['tramite'])){
	$tramite = $_GET['tramite'];
}
if(isset($_POST['curp'])){

	$dato = $_POST['curp'];
	$operacion = $_POST['operacion'];
	$idtramite = $_POST['idtramite'];
	$tipotramite = $_POST['tipotramite'];
	
	$numTramite = ntramite(TRUE);
	$sql = "INSERT INTO tramites(IdTramite, IdTipoTramite, Curp, NitavuCaptura,Fecha,Hora, DptoCaptura) 
	VALUES ('$numTramite', '$tramite', '$dato','$nitavu','$fecha','$hora',".nitavu_dpto($nitavu).")";
	if ($conexion->query($sql) == TRUE){   
		ntramite(FALSE);

		if($operacion=="insert")
		{
		$sql = "-- tr 
		SELECT tramitesrequisitos.IdRequisito, tramitesrequisitos.NombreRequisito,tramitesrequisitos.TipoRequisito,tramitesrequisitos.IdCatRequisitos,
		tramitesrequisitoscat.Nombre, tramitesrequisitos.Opcional,tramitesrequisitos.Descripcion FROM tramiteslistarequisitos
		INNER JOIN tramitesrequisitos ON tramitesrequisitos.IdRequisito=tramiteslistarequisitos.IdRequisito
		INNER JOIN tramitestipo ON tramitestipo.IdTipoTramite=tramiteslistarequisitos.IdTipoTramite
		LEFT JOIN tramitesrequisitoscat ON tramitesrequisitoscat.IdCatRequisitos=tramitesrequisitos.IdCatRequisitos
		WHERE  tramiteslistarequisitos.IdTipoTramite=".$tramite." order by tramitesrequisitoscat.IdCatRequisitos,tramitesrequisitos.IdRequisito asc";
	
		}
		else{
			$sql = "-- tr
	 SELECT tramitesrequisitos.IdRequisito, tramitesrequisitos.NombreRequisito,tramitesrequisitos.TipoRequisito,tramitesrequisitos.IdCatRequisitos,
	tramitesrequisitoscat.Nombre, tramitesrequisitos.Opcional,tramitesrequisitos.Descripcion
	,(SELECT tramitesinformacion.Dato FROM tramitesinformacion WHERE tramitesinformacion.IdTramite=tramites.IdTramite 
	AND tramitesinformacion.IdRequisito=tramitesrequisitos.IdRequisito AND tramitesinformacion.Cancelado=0 ) AS Dato
	FROM tramitestipo
	INNER JOIN tramites ON tramitestipo.IdTipoTramite=tramitestipo.IdTipoTramite
	LEFT JOIN tramiteslistarequisitos ON tramiteslistarequisitos.IdTipoTramite=tramitestipo.IdTipoTramite
	INNER JOIN tramitesrequisitos ON tramitesrequisitos.IdRequisito=tramiteslistarequisitos.IdRequisito
	INNER JOIN tramitesrequisitoscat ON tramitesrequisitoscat.IdCatRequisitos=tramitesrequisitos.IdCatRequisitos
	WHERE  tramitestipo.IdTipoTramite=".$tipotramite." AND tramites.IdTramite=".$idtramite." and tramitesrequisitos.Cancelado=0 
	order by tramitesrequisitoscat.IdCatRequisitos,tramitesrequisitos.IdRequisito asc";
	//echo $sql;
	}
		$tmp="";
		//echo $sql;
		$r = $conexion -> query($sql);
		
		$r_count = $r -> num_rows;
		while($f = $r -> fetch_array())
		{

			$id = 'req'.$f['IdRequisito'];
			
			if($f['TipoRequisito']=='file'){
				
				$doc = $_FILES[$id]["name"];
				$tmp =$_FILES[$id]["tmp_name"];
				//Sube archivo a Carpeta, no a FTP
				if($operacion =='insert'){
					$res = guardarBDFile($numTramite,$f['IdRequisito'],$doc,$tmp,$f['TipoRequisito'],$operacion,$nitavu);

				}else{
					//echo 'entro actualizar';
					$res = guardarBDFile($idtramite,$f['IdRequisito'],$doc,$tmp,$f['TipoRequisito'],$operacion,$nitavu);

				}
				//$array=($res);
				if($res==TRUE){
					echo "<script>
						NPush('Se subio con éxito el archivo ".nombreRequisito($f['IdRequisito'])."','Plataforma ITAVU')
					</script>";
				}else{
					echo "<script>
						NPush('El archivo ".nombreRequisito($f['IdRequisito'])." no pudo subirse, intentelo de nuevo.','Plataforma ITAVU')
					</script>";
				}
				
				
			}else{
				
				
				if(isset($_POST[$id])){
					$dato = $_POST[$id];
					if($operacion =='insert'){
						$res = guardarBD($numTramite,$f['IdRequisito'],$dato,$f['TipoRequisito'],$operacion,$nitavu);
	
					}else{
						$res = guardarBD($idtramite,$f['IdRequisito'],$dato,$f['TipoRequisito'],$operacion,$nitavu);
	
					}
					//$res = guardarBD($numTramite,$f['IdRequisito'],$dato,$f['TipoRequisito'],$operacion,$nitavu);
					if($res==TRUE){
						echo "<script>
							NPush('Se subio con éxito el requisito: ".nombreRequisito($f['IdRequisito'])."','Plataforma ITAVU')
						</script>";
					}else{
						echo "<script>
							NPush('Ocurrio un error al subir el requisito: ".nombreRequisito($f['IdRequisito']).", intentelo de nuevo.','Plataforma ITAVU')
						</script>";
					}
				}
			}

		
		}
		

		}
		
		//Si se lleno todo esta completo para finalizar y no salga en pendientes
		$sql1 = "SELECT llenos,total, case when llenos=total then 'True' when llenos<>total then 'False' end as respuesta 
		FROM tramitesinformacion 
		INNER JOIN (SELECT COUNT(IdTramite) AS llenos,(SELECT COUNT(IdTipoTramite) FROM tramiteslistarequisitos 
		INNER JOIN tramitesrequisitos ON tramitesrequisitos.IdRequisito = tramiteslistarequisitos.IdRequisito
		WHERE tramiteslistarequisitos.IdTipoTramite = ".$tipotramite ." and tramitesrequisitos.Cancelado=0) as total FROM tramitesinformacion WHERE Dato<>'' AND IdTramite =".$idtramite." AND Cancelado = 0 ) as t1 ON tramitesinformacion.IdTramite=".$idtramite." group by llenos,total";
		//echo $sql1;
		$rc= $conexion -> query($sql1);
		if($fx = $rc -> fetch_array()){
			//echo $fx['respuesta'];
			if($fx['respuesta']=='True'){
				//echo 'entroooooo';
				$query = "UPDATE tramites SET Estado = 1 WHERE IdTramite=".$idtramite."";
				echo $query;
				 if ($conexion->query($query) == TRUE){
					mensaje('El tramite de esta solicitud ha sido completado','tramites.php');
				 }
			}else{
				mensaje('Faltaron varios datos por subir de esta solicitud, estará disponible en la pantalla de pendientes.','tramites.php');
			 }
		
		}

	}

}else{
    mensaje('No tiene permiso para esta aplicación','index.php');
}
?>



<script>
function mayus(e) {
    e.value = e.value.toUpperCase();
}






function SubirArchivo(FolioTramite,TipoTramite,campo,boton){
$("#Loader" + FolioTramite).css({'display':'inline-block'});
$("#PDF" + FolioTramite).css({'display':'none'});


var inputFileImage = document.getElementById(campo+FolioTramite);

var file = inputFileImage.files[0];
var data = new FormData();

data.append('campo',campo);
data.append(campo+FolioTramite,file);
data.append("Folio",FolioTramite);
data.append("Tipo",TipoTramite);
// data.append(file,file);
console.log(data);
$.ajax({
        url: "tr_dat22.php",        
        type: "POST",             
        data: data, 			  
        contentType: false,       
        cache: false,             
        processData:false,        
        success: function(data)   
        {
			
            $('#PDF' +campo+FolioTramite).html(data);
			$("#PDF"  +campo+FolioTramite).css({'display':'inline-block'});          
		   	$("#Loader"  +campo+ FolioTramite).css({'display':'none'});		  
			//$(boton + FolioTramite).css({'display':'inline-block'});		
			$("#"+boton+FolioTramite).css({'display':'inline-block'});
		//	$("#botonaprobar" + FolioTramite).css({'display':'inline-block'});
        }
    });
    

}

function ValidarTramite(FolioTramite, IdTipoTramite){


	 //$("#Loader" + IdRequisito).show();
	$.ajax({
	url: "tr_dat3.php",
	type: "get",        
	data: {Folio:FolioTramite, IdTipoTramite:IdTipoTramite},
	success: function(data){   
		$('#respuesta').html(data);
		$("#Registro" + FolioTramite).hide();
		$(".close-modal").get(0).click();
		NPush(data,'Plataforma ITAVU');
		
		/*var res=data.trim();
		if(res.includes('COMPLETO')==true){
			$("#Registro" + FolioTramite).hide();
			$(".close-modal").get(0).click();
        	NPush('Se ha enviado el tramite','Plataforma ITAVU');
    
		}else
		{
			NPush(data,'Plataforma ITAVU');
		}
		/*else{
			NPush('ERROR: No puedes continuar con la solicitud ya que el requisito es que personas solteras menores de 30 años no se admiten. A excepciòn de madres y padres solteros que demuestren con acta de nacimiento tener hijos(as).','Plataforma ITAVU');
    
		}*/

		   
	}
	}); 
}
	function AprobarTramite(FolioTramite, IdTipoTramite, IdPrograma){

	$.ajax({
	url: "tr_dat5.php",
	type: "get",        
	data: {Folio:FolioTramite, IdTipoTramite:IdTipoTramite, IdPrograma:IdPrograma},
	success: function(data)
	{   
		$('#respuesta').html(data);
		var res=data.trim();
		/*mensaje=res.split('_')[1];
		if (res.search('TRUE') != -1) 
		{
			$("#Registro" + FolioTramite).hide();
			NPush(mensaje,'Plataforma ITAVU');
		} */
		console.log(data);
		if(res.includes('TRUE')==true)
		{
			$("#Registro" + FolioTramite).hide();		
			NPush('Se ha marcado el trámite como aprobado','Plataforma ITAVU'); 					
			$(".close-modal").get(0).click();
		}else{
			//alert(data);
			NPush('Ocurrio un error al momento de marcar el trámite, por favor intentelo de nuevo.','Plataforma ITAVU');
		}
	}
	}); 	
	}

	function RechazarTramite(FolioTramite, IdTipoTramite){
	var obs = document.getElementById("obsRechazado"+FolioTramite).value;
	$.ajax({
	url: "tr_dat6.php",
	type: "get",        
	data: {Folio:FolioTramite, IdTipoTramite:IdTipoTramite,obs:obs},
		success: function(data)
		{   
			$('#respuesta').html(data);
			var res=data.trim();
			/*mensaje=res.split('_')[1];
			if (res.search('TRUE') != -1) 
			{
				$("#Registro" + FolioTramite).hide();
				NPush(mensaje,'Plataforma ITAVU');
			} */	
			
			if(res=='TRUE')
			{
				$("#Registro" + FolioTramite).hide();
				$(".close-modal").get(0).click();		
				NPush('Se ha marcado el trámite como rechazado','Plataforma ITAVU'); 
			
			
			}else{
			NPush('Ocurrio un error al momento de marcar el trámite, por favor intentelo de nuevo.','Plataforma ITAVU');
		}
		}
	}); 

}
function DevolverTramite(FolioTramite, IdTipoTramite){
	var obs = document.getElementById("obsDevuelto"+FolioTramite).value;
	$.ajax({
	url: "tr_dat7.php",
	type: "get",        
	data: {Folio:FolioTramite, IdTipoTramite:IdTipoTramite,obs:obs},
		success: function(data)
		{   
			$('#respuesta').html(data);
			var res=data.trim();
			/*mensaje=res.split('_')[1];
			if (res.search('TRUE') != -1) 
			{
				$("#Registro" + FolioTramite).hide();
				NPush(mensaje,'Plataforma ITAVU');
			} */
				
			if(res.includes('TRUE')==true){			
				$("#Registro" + FolioTramite).hide();
				$(".close-modal").get(0).click();		
				NPush('Se ha marcado el trámite como devuelto','Plataforma ITAVU'); 
			
			
			
			}else{
				NPush('Ocurrio un error al momento de marcar el trámite, por favor intentelo de nuevo.','Plataforma ITAVU');
			}
		}
	}); 

}

function DarVistoBueno(FolioTramite, nitavu, idTipo){
	var obs = document.getElementById("Obs"+FolioTramite).value;
	$.ajax({
	url: "tr_dat4.php",
	type: "post",        
	data: {Folio:FolioTramite, nitavu: nitavu, obs: obs, idTipo: idTipo},
	success: function(data){   
		$('#respuesta').html(data);
		var res=data.trim();
		if(res=='TRUE'){
			$("#Registro" + FolioTramite).hide();
			$(".close-modal").get(0).click();
        	NPush('Se ha marcado con Visto Bueno el trámite.','Plataforma ITAVU');
		}else{
			NPush('Ocurrio un error al momento de marcar el trámite, por favor intentelo de nuevo.','Plataforma ITAVU');
		}   
	}
	});
}

function ValidarTramiteSeleccionar(){
	var CURP = $("#_curp").val();
	var IdTipoTramite = $("#IdTramite").val();

	console.log("CURP = "+CURP + ", IdTipoTramite="+IdTipoTramite);
	$.ajax({
	url: "tr_datval.php",
	type: "get",        
	data: {Folio:IdTipoTramite, CURP:CURP},
	success: function(data){   
		$('#respuesta').html(data);
	}
	});
		

}

function printDiv(id) 
{

  var divToPrint=document.getElementById('imprimir'+id);

  var newWin=window.open('','Print-Window');

  newWin.document.open();

  newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');

  newWin.document.close();

  setTimeout(function(){newWin.close();},10);

}
</script>
<br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br><br>

<?php include ("./lib/body_footer.php"); ?>
