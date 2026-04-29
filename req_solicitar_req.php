<?php //include (".//seguridad.php");
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
// contenido:
?>
<?php 


$id_aplicacion ="ap49";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE and $nivel==1)
{ 	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";				
		include("req_menu.php");






//consulta sin LIMIT

				// $sql = " -- req 
				// SELECT dr.IdDepartamento, UPPER(cgg.nombre) as Direccion, UPPER(cg.nombre) as Departamento 
				// FROM req_detallerequisicion as dr right  JOIN req_conceptos AS rc on dr.IdConcepto=rc.IdConcepto 
				// left JOIN req_requisiciones AS rq on rq.IdRequisicion=dr.IdRequisicion
				// INNER JOIN cat_gerarquia AS cg ON cg.id=dr.IdDepartamento 
				// 		LEFT JOIN cat_gerarquia AS cgg ON cgg.id=cg.dependencia
				// where dr.Cancelado=0 and  (dr.IdRequisicion IS NULL or dr.IdRequisicion=0)
				// and rc.Cancelado=0 and dr.Justificacion is not null
				// GROUP BY dr.IdDepartamento,rq.IdRequisicion,cgg.nombre";
 $sql = " -- req 
 				SELECT DISTINCT (dr.IdDepartamento), UPPER(cgg.nombre) as Direccion, UPPER(cg.nombre) as Departamento,
				 (select  dr.FechaCrea  from req_detallerequisicion where req_detallerequisicion.IdDepartamento=dr.IdDepartamento order by req_detallerequisicion.FechaCrea desc limit 1) as fecha_primer_articulo
				 ,dr.Estatus
				FROM req_detallerequisicion as dr right  JOIN req_conceptos AS rc on dr.IdConcepto=rc.IdConcepto 
				left JOIN req_requisiciones AS rq on rq.IdRequisicion=dr.IdRequisicion
				INNER JOIN cat_gerarquia AS cg ON cg.id=dr.IdDepartamento 
						LEFT JOIN cat_gerarquia AS cgg ON cgg.id=cg.dependencia
				where dr.Cancelado=0 and  (dr.IdRequisicion IS NULL or dr.IdRequisicion=0)
				and rc.Cancelado=0 and dr.Justificacion is not null
				GROUP BY dr.IdDepartamento,rq.IdRequisicion,cgg.nombre
	            ORDER BY fecha_primer_articulo asc";


			$r = $conexion -> query($sql);
			$r_count = $r -> num_rows;
		if ($r_count<=0)
			{ 	// en caso de haya resultados, hacer uno nuevo
				//historia($nitavu,'Busqueda fallida de '.$search);
				echo "<br>";
				echo "<br>";
				echo "<div class='alert alert-danger'>";
				echo "<strong>No se han encontrado resultados</strong> !";
				echo "</div>";
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
							header("Location: ./req.php");
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
				//echo "<br><div id='AppDetalle'>Resultados ".$r_count. ", agrupados de ".$paginacion." </div>";
				$paginas = intval(($r_count / $paginacion));
echo "<form  action='req_solicitar_req_bd.php' method='POST' >";
echo "<script type='text/javascript'>
//<![CDATA[
function marcar_desmarcar(){
var marca = document.getElementById('marcar');
var cb = document.getElementsByName('idrequisiciones[]');
 
for (i=0; i<cb.length; i++){
if(marca.checked == true){
cb[i].checked = true
}else{
cb[i].checked = false;
}
}
 
}
//]]>
</script>";
echo "<div>"; // MENU
		
	
echo" <button type='submit' class='Mbtn btn-default' name='btnAgrupar' id='btnAgrupar'>Agrupar Requisiciones</button>";
//echo "<a href='req.php?s=' class='Mbtn btn-default'>Solicitar Requicisiones</a>"; //este btn va aqui porq es solo para el admin
		//echo"<a href='./req_solicitar_req_bd.php' name='enviar' class='Mbtn btn-default'>Agrupar Requisiciones</a>";
echo "</div>";

echo "<br >";
						echo "<table ><tr>";									
						echo "<td  style='padding: 10px;text-align: left;  font-size:12px; font-family: 'Compacta';'  class='tipo_nitavu'><input type='checkbox' id='marcar' value='' onclick='marcar_desmarcar();' style='color: #666666'  >     SELECCIONAR TODOS</input></td>";	
						echo "</tr></table>";
						
			//echo"<input type='checkbox' id='marcar' value='' onclick='marcar_desmarcar();' style='text-align:right;' >Seleccionar todos</input>"	;
				echo "<section id='resul'>";

				

						while($f = $r -> fetch_array())
						{ // resultado de la busqueda.................
						
						if($f['Estatus']=='OK')
						{
						echo "<div id='resultado_elemento' style='background-color:#e2eaf1; color: #990000;' >";
						}
						else
						{echo "<div id='resultado_elemento'>";}
						echo "<table border='0'><tr>";
											
								echo "<td width='10px' class='tipo_nitavu'><span class='pc'></span></td>";	
								echo "<td width='70px'><input type='checkbox' name='idrequisiciones[]' value='".$f['IdDepartamento']."'></td>";		
								echo "<td>";					
								echo "<span class='normal tmediano'>".$f['Departamento']."</span>";
								echo "<span class='pc tchico'><br>".$f['Direccion']." </span>";
								echo "</td>";
								echo "<td align='left' width='150px'>";
								echo "<span class='pc tchico'>";
								echo date_format( date_create($f['fecha_primer_articulo']), 'd/m/Y H:i:s');
								echo"</span>";								
								echo "</td>";
								if($f['Estatus']=='OK'){
								echo "<td align='left' width='150px'>";
								echo "<span class='pc tchico'>".$f['Estatus'];	
								}else{
									echo "<td align='left' width='150px'>";
									echo "<span class='pc tchico'>";		
								}					
								echo"</span>";								
								echo "</td>";
						
						echo "</tr></table>";
						echo "</div>";

						
						}
				
				echo "</section>";

				
				if ($r_count >= $paginacion+1)
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
									echo "<span id='pagina_actual'>".$pagina."</span>"; //para el CSS span = a pagina actual
								}
								else
								{
									echo "<span id='pagina_proxima'><a href='?search=".$search."&p=".$i."'>".$i."</a></span>"; //CSS span a = link a paginas
								}
							}
					echo "</div></center>";

				}
				echo "</form>";
			}
		}
		
				
			
else{echo "	<br><br>";echo "No tiene acceso a ".$id_aplicacion;}
	
	?>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>
	<br><br><br><br><br><br>

	<?php
	include ("./lib/body_footer.php");
	?>
