<?php
//include (".//seguridad.php");
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
// contenido:
?>

<?php 
//echo "<div class ='centrar_mensaje_padre'>";
//echo "<div class = 'centrar_mensaje_hijo'>";
$id_aplicacion ="ap49";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
//echo $nivel;
if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{
		echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";		
		include("req_menu.php");
 echo "<br><br>";
	buscar('req_requisiciones.php','Busqueda por Departamento o Estatus','');
   // historia($nitavu, "Entro a buscar un empleado");

//echo "</div>";
//echo "</div>";


if (isset($_GET['busqueda']))
{
	
	$search = $_GET['busqueda'];
	
}
 else {$search='';
		
}



//consulta sin LIMIT
if ($nivel == 1)
{
		$sql = " -- req 

		SELECT rq.IdRequisicion,
		CASE cg.nivel WHEN  'Dir.' THEN (select UPPER(nombre)from cat_gerarquia where id=  cg.id)
		WHEN  '-'   THEN UPPER(cg.nombre)
        ELSE 
          case cgg.nivel     
          when'Dpto.' then (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cgg.id ))
          when 'Sub.' then (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cgg.id )) 
          when 'CONSEJO' then UPPER(cg.nombre)  ELSE UPPER(cgg.nombre)
        END END AS Direccion,
		UPPER(cg.nombre) as Departamento, 
		tr.Requisicion, er.DesEstatus, rq.FechaCrea FROM req_requisiciones AS rq 
		INNER JOIN req_detallerequisicion AS dr on rq.IdRequisicion=dr.IdRequisicion
		INNER JOIN req_estatusreq AS er ON rq.IdEstatus=er.IdEstatus

		INNER JOIN req_tiporequisicion tr ON tr.IdTipoRequisicion=rq.IdTipoRequisicion 
		INNER JOIN cat_gerarquia AS cg ON cg.id=dr.IdDepartamento 
		LEFT JOIN cat_gerarquia AS cgg ON cgg.id=cg.dependencia ";	
		$sql = $sql."WHERE ";
		$sql = $sql."rq.IdEstatus <> 6 AND ";
		$sql = $sql."((cg.nombre LIKE '%".$search."%') OR ";
		//$sql = $sql."(cgg.nombre LIKE '%".$search."%') OR ";
		$sql = $sql."(er.DesEstatus LIKE '%".$search."%') ) ";
		$sql = $sql."GROUP BY rq.IdRequisicion ORDER BY rq.IdRequisicion DESC";
}
else
{   $sql = " -- req 

		SELECT rq.IdRequisicion, 
		CASE cg.nivel WHEN  'Dir.' THEN (select UPPER(nombre)from cat_gerarquia where id=  cg.id)
		WHEN  '-'   THEN UPPER(cg.nombre)
        ELSE 
          case cgg.nivel     
          when'Dpto.' then (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cgg.id ))
          when 'Sub.' then (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cgg.id )) 
          when 'CONSEJO' then UPPER(cg.nombre)  ELSE UPPER(cgg.nombre)
        END END AS Direccion,
		UPPER(cg.nombre) as Departamento, 
		tr.Requisicion, er.DesEstatus, rq.FechaCrea FROM req_requisiciones AS rq 
		INNER JOIN req_detallerequisicion AS dr on rq.IdRequisicion=dr.IdRequisicion
		INNER JOIN req_estatusreq AS er ON rq.IdEstatus=er.IdEstatus

		INNER JOIN req_tiporequisicion tr ON tr.IdTipoRequisicion=rq.IdTipoRequisicion 
		INNER JOIN cat_gerarquia AS cg ON cg.id=dr.IdDepartamento 
		LEFT JOIN cat_gerarquia AS cgg ON cgg.id=cg.dependencia ";	
		$sql = $sql."WHERE ";
		$sql = $sql."rq.IdEstatus <> 6 AND ";
		$sql = $sql."(((cg.nombre LIKE '%".$search."%') OR ";
		//$sql = $sql."(cgg.nombre LIKE '%".$search."%') OR ";
		$sql = $sql."(er.DesEstatus LIKE '%".$search."%') )AND  ";
		$sql = $sql."(rq.IdDepartamento=".nitavu_dpto ($nitavu).")) ";
		$sql = $sql."GROUP BY rq.IdRequisicion ORDER BY rq.IdRequisicion DESC";

}


			$r = $conexion -> query($sql);
			
			$r_count = $r -> num_rows;
			
		if ($r_count<=0)
			{ 	// en caso de haya resultados, hacer uno nuevo
				historia($nitavu,'Req_Busqueda fallida de '.$search);
				echo "<br><h3> Lo sentimos no se han encontrado resultados sobre <b class='normal'>[ ".$search." ]</b>
				 <br>vuelva a intentarlo utilizando otras palabras de busqueda</h3>";
				//mensaje($msg,"./req.php");
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
							
						} 
						else
						{ //Si la string no es numérica, redirige al index (por ejemplo: index.php?pagina=AAA)
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
					historia($nitavu,'Req_Busqueda de '.$search);
					if ($search==''){
						echo "<br><h3>Se han encontrado ".$r_count. " requisiciones: <a class='btn2' href='./req_pdf_requisiciones.php?search=".$search."'  ><img src='icon/min_impresora.png' style='width: 15px;
	height: 15px;' title='Imprimir'></a></h3>";
					}else 
					{
						

						echo "<br><h3>Se han encontrado ".$r_count. " requisiciones, con la busqueda  <b class='normal'>[ ".$search." ]</b> <a class='btn2' href='./req_pdf_requisiciones.php?search=".$search."' > <img src='icon/min_impresora.png' style='width: 15px;
	height: 15px;' title='Imprimir'></a></h3>";	
					}
				
				$paginas = intval(($r_count / $paginacion))+1;
					


				echo "<div id='r'>";
				
						while($f = $r -> fetch_array())
						{ // resultado de la busqueda.................

						//style='background-color:red; color:white;'
						
						
						/* if ($f['DesEstatus']=='EVALUACIÓN'){
							echo "<div id='resultado_elemento' style='background-color:#EEEEEE; color: #990000;' >";

						}
						else if ($f['DesEstatus']=='COTIZANDO'){
							echo "<div id='resultado_elemento' style='background-color:#f0f0de; color: #990000;' >";

						}
						else if ($f['DesEstatus']=='AUTORIZADA'){
							echo "<div id='resultado_elemento' style='background-color:#ecf7fe; color: #990000;' >";
							

						}
						else if ($f['DesEstatus']=='EN ARMADO'){
							echo "<div id='resultado_elemento' style='background-color:#def0e7; color: #990000;' >";


						}
						else if ($f['DesEstatus']=='ENTREGADA'){
							echo "<div id='resultado_elemento' style='background-color:#E8FFD9; color: #990000;' >";

						}
*/
						
						
					if ($f['DesEstatus']=='EVALUACIÓN'){
							echo "<div id='resultado_elemento' style='background-color:#f5f8fa; color: #990000;' >";

						}
						else if ($f['DesEstatus']=='COTIZANDO'){
							echo "<div id='resultado_elemento' style='background-color:#e2eaf1; color: #990000;' >";

						}
						else if ($f['DesEstatus']=='AUTORIZADA'){
							echo "<div id='resultado_elemento' style='background-color:#cfdde8; color: #990000;' >";
							

						}
						else if ($f['DesEstatus']=='EN ARMADO'){
							echo "<div id='resultado_elemento' style='background-color:#bbcfdf; color: #990000;' >";


						}
						else if ($f['DesEstatus']=='ENTREGADA'){
							echo "<div id='resultado_elemento' style='background-color:#a8c1d6; color: #990000;' >";

						}

						else if ($f['DesEstatus']=='DETENIDA'){
							echo "<div id='resultado_elemento' style='background-color:#C8CFD4; color: #990000;' >";

						}
						else if ($f['DesEstatus']=='RECHAZADA'){
							echo "<div id='resultado_elemento' style='background-color:#FFD5D5; color: #990000;' >";

						} else 

						 {
						 	echo "<div id='resultado_elemento'  >";
						 }


						

						echo "<table border='0'>";
						echo "<tr>";
											
								echo "<td width='50px' class='tipo_nitavu'><span >".$f['IdRequisicion']."</span></td>";			
								echo "<td  class=''>";					
								echo "<span class='normal tmediano'>".$f['Departamento']."</span>";
								echo "<span class='pc tchico'><br>".$f['Direccion']." </span>";
								echo "<span class='pc tchico'><br>".$f['Requisicion']."    ".date_format( date_create($f['FechaCrea']), 'd/m/Y H:i:s')."</span>";
								 
								echo "</td>";
								/*echo "<td width='100px'><a  href='./req_seguimiento.php?d=".$f['IdRequisicion']."''><i class='fa fa-signal fa-1x ' style='color:#0064A7' aria-hidden='true'  title='Seguimineto'></i></a>";*/
								echo "</td>";
								echo "<td width='200px' align='left' class='pc tenue fontpeque'>";
								echo  $f['DesEstatus'];
								echo "</td>";
								echo "<td width='100px'><a  href='./req_seguimiento.php?d=".$f['IdRequisicion']."''><img src='icon/mas.png' class='icono' title='Seguimiento'></a>";
								echo "<td width='10px' align='right' class='tipo_menu'>";
								echo "<a href='./req_detalles.php?d=".$f['IdRequisicion']."''><img src='icon/entrar.png' class='icono' title='Detalles'></a>";
								echo " </td>";					
						echo "</tr></table>";
						echo "</div>";

						
						}
				
				echo "</div>";

				
				if ($r_count >= $paginacion)
				{
					echo "<center><div id='barra_paginacion'>";
						echo "Paginas: ";
							//Crea un bucle donde $i es igual 1, y hasta que $i sea menor o igual a X, a sumar (1, 2, 3, etc.)
							//Nota: X = $total_paginas
							for ($i=1; $i<=$paginas; $i++) 
							{
								//En el bucle, muestra la paginación
								if ($pagina==$i)
								{
									echo "<span id='pagina_actual'>".$pagina."</span>";
								
										 //para el CSS span = a pagina actual
								}
								else
								{
									echo "<span id='pagina_proxima'><a href='?busqueda=".$search."&p=".$i."'>".$i."</a></span>"; //CSS span a = link a paginas
								}
							}
						
					echo "</div></center>";

				}
			}
				}
else{echo "	<br><br>";echo "No tiene acceso a ".$id_aplicacion;}
	//echo $nivel;
	?>
	<script>

	$(document ).ready(function() {
		bq=getQueryVariable('busqueda');
		if (bq!=false){
		document.getElementById("beta_buscar_input").value=bq;}
   
});

function getQueryVariable(variable)
{
       var query = window.location.search.substring(1);
       var vars = query.split("&");
       for (var i=0;i<vars.length;i++) {
               var pair = vars[i].split("=");
               if(pair[0] == variable){return pair[1];}
       }
       return(false);
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