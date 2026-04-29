<?php
//include (".//seguridad.php");
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
// contenido:
?>

<?php
$id_aplicacion ="ap71";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
docdigital_no(FALSE, 1); //ahorra 1 hoja

if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
	if(isset($_GET['busqueda'])){
		buscar('mt_digitalizacioncyp.php',$_GET['busqueda'],'');
	} else {
		echo "<div id='buscar_fondo'>";
		echo "<div id='buscar_centrado'>";
		buscar('mt_digitalizacioncyp.php','Escribe la colonia o programa a buscar','');
		if ($nivel==1){
		echo "<a href='mt_permisos.php' title='Haga clic aqui para administrar los permisos a esta aplicacion de su personal'
		style='color:gray; font-size:8pt;'
		>
		Administrar Permisos para esta aplicacion
		</a>";}
		echo "</div></div>";
	}

if(isset($_GET['busqueda']))
{
	echo "<h3 style=''>Resultados de <b style='color:#E3D79F;'>".$_GET['busqueda']."</b></h2>";
	historia($nitavu,'mt_Buscó en la seccion de mesa de trabajo:'.$_GET['busqueda']);
	




 $sqlcol = "select     0 as id, cat_colonias.idmunicipio, cat_colonias.idcolonia, cat_municipios.municipio, cat_colonias.colonia, 'colonias' as tipo
 from         cat_colonias left outer join
 cat_municipios on cat_colonias.idmunicipio = cat_municipios.idmunicipio
 where     (cat_colonias.colonia like '%".$_GET['busqueda']."%'  or cat_municipios.municipio like  '%".$_GET['busqueda']."%' )";


 echo '<br>';

$sqlman = "select  cat_mandantes.mandante as nombre,  cat_colonias.idmunicipio as idmunicipio, cat_municipios.municipio  
 as municipio, 
 cat_colonias.idcolonia as idcolonia,   cat_colonias.colonia, 
 'mandantes' as tipo, cat_mandantes.idmandante                      
 from         cat_municipios right outer join
 cat_colonias on cat_municipios.idmunicipio = cat_colonias.idmunicipio right outer join
 cat_mandantes on cat_colonias.idmunicipio = cat_mandantes.idmunicipio and 
 cat_colonias.idcolonia = cat_mandantes.idcolonia
 where (mandante like '%".$_GET['busqueda']."%' or cat_municipios.municipio like  '%".$_GET['busqueda']."%' or cat_colonias.colonia like  '%".$_GET['busqueda']."%')";
		 


$sqldes= "select     convdesarrollador.folio as idconvenio,convdesarrollador.idprograma,convdesarrollador.iddesarrollador,convdesarrollador.iddelegacion, cat_desarrolladores.nombre, 
 convdesarrollador.montoconvenio, convdesarrollador.plazoconvenio, convdesarrollador.totallotes,  convdesarrollador.fechaconvenio,
 convdesarrollador.idcolonia,convdesarrollador.completo, convdesarrollador.addendumal as aladdendum, convdesarrollador.addendum,
 convdesarrollador.idmunicipio , cat_municipios.municipio, convdesarrollador.fechaultimamod, 
 convdesarrollador.fechacaptura,
 convdesarrollador.subsidiolote*convdesarrollador.totallotes as subsidio 
 from  cat_desarrolladores inner join convdesarrollador on cat_desarrolladores.iddesarrollador = convdesarrollador.iddesarrollador inner join 
 cat_municipios on convdesarrollador.idmunicipio = cat_municipios.idmunicipio 
 where (cat_desarrolladores.nombre like '%".$_GET['busqueda']."%' or cat_municipios.municipio like  '%".$_GET['busqueda']."%' )
 order by  cat_desarrolladores.nombre";

$sqlpro="select idprograma , programa, 'programas' as tipo from cat_programa 
where programa like '%".$_GET['busqueda']."%'";


$r2 = $conexion -> query($sqlcol);
echo "<div class='ModulosInteriores' style='background-color:#FFE8F2; border-color:#FFBFDB; color:#FF9FC8;'>";
echo "<h2>RESULTADO DE COLONIAS</h2>";
if ($r2->num_rows>0)
{
	
	// echo "<center><div id='diseño1'>";
	echo "<div id='coloniass'>";
	echo "<br>";
	echo "<table class='tabla'>";
		// echo"<th>municipio</th>";
		// echo"<th>colonia</th>";
		
	while($f = $r2 -> fetch_array())
	{
		echo"<tr>";
		
		echo"<td><a title='Haz clic aqui para entrar a la Colonia' href='mt_mesadetrabajo.php?pes=ficha&IdMunicipio=".$f['idmunicipio']."&IdColonia=".$f['idcolonia']."'>".$f['colonia']."</a></td>";
		echo"<td>".$f['municipio']."</td>";
		//echo"<td class='pc'>".$f['colonia']."</td>";    
		echo"</tr>";
	}
echo "</table>";
echo "</div>";
// echo "</div></center>"; 
} else {
	echo "No se encontraron resultados";
}
echo "</div>";




echo "<div class='ModulosInteriores' style='background-color:#FFFFDD; border-color:#FFFF55; color:#D2D200;'>";
echo "<h2>RESULTADO DE MANDANTES</h2>";    

$rman = $conexion -> query($sqlman); 
if ($rman->num_rows>0)
{ 
//******mandantes
// echo "<center><div id='diseño1'>";  
echo "<div id='mandantes'>";
echo "<br>";    
echo "<table class='tabla'>";
	 echo"<th>mandante</th>";
	 echo"<th>municipio</th>";
	 echo"<th>colonia</th>";

 
while($f2 = $rman -> fetch_array())
{
	 echo"<tr>";
	 echo"<td><a title='Haz clic aqui para entrar a ver el mandante' href='mt_mesadetrabajo.php?pes=ficha&IdMandante=".$f2['idmandante']."&IdMunicipio=".$f2['idmunicipio']."&IdColonia=".$f2['idcolonia']."'>".$f2['nombre']."</a></td>";
	 //echo"<td class='pc'>".$f2['nombre']."</td>";
	 echo"<td class='pc'>".$f2['municipio']."</td>";
	 echo"<td class='pc'>".$f2['colonia']."</td>";    
	 echo"</tr>";
}

echo "</table>";
echo "</div>";      
// echo "</div></center>"; 
} else {
	echo "Sin resultados";
}
echo "</div>";

// $rdes = $conexion -> query($sqldes); 

// // if ($rdes)
// echo "<div class='ModulosInteriores' style='background-color:#E6FFFF; border-color:#AAFFFF; color:#4DA6FF;'>";
// echo "<h2>RESULTADO DE DESARROLLADORES</h2>";  
// // echo $sqldes;
// if ($rdes->num_rows>0)
// {
// //****desarrolladores   


// // echo "<center><div id='diseño1'>";
// echo "<div id='desarrolladores'>";
// echo "<br>";


//  echo "<table class='tabla'>";
// 	 echo"<th>desarrollador</th>";
// 	 echo"<th>municipio</th>";
// 	 echo"<th>fecha convenio</th>";
// 	 echo "<th>monto convenio</th>";
// 	 echo "<th>total lotes </th>";

// while($f3 = $rdes -> fetch_array())
// {
// 	 echo"<tr>";
// 	 echo "<td><a href='mt_mesadetrabajo.php?pes=ficha&IdDesarrollador=".$f3['iddesarrollador']."&IdMunicipio=".$f3['idmunicipio']."&IdColonia=".$f3['idcolonia']."&IdConvenio=".$f3['idconvenio']."'>".$f3['nombre']."</a></td>";
//  //echo"<td class='pc'>".$f3['nombre']."</td>";
// 	 echo"<td class='pc'>".$f3['municipio']."</td>";
// 	 echo"<td>".$f3['fechaconvenio']."</td>";
// 	 echo"<td>".$f3['montoconvenio']."</td>";
// 	 echo"<td>".$f3['totallotes']."</td>";

// 	 //echo"<td class='pc'>".$f3['colonia']."</td>";    
// 	 echo"</tr>";            
// }

// echo "</table>";
// echo "</div>";
// // echo "</div></center>";
// } else {
// 	echo "Sin resultados";
// }
// echo "</div>";



echo "<div class='ModulosInteriores' style='background-color:#E3FEDE; border-color:#7AFC5F; color:#008C23;'>";
echo "<h2>RESULTADOS DE PROGRAMAS</h2>";    

$rpro = $conexion -> query($sqlpro); 
if ($rpro->num_rows>0)
{
//****programas 
// echo "<center><div id='diseño1'>";      
echo "<div id='programas'>";
echo "<br>";        
echo "<table class='tabla'>";
	 echo"<th>programa</th>";


while($f4 = $rpro -> fetch_array())
{
 
	 echo"<tr>";                 
	 //echo"<td class='pc'>".$f4['programa']."</td>";                
		 echo "<td><a href='mt_mesadetrabajo.php?pes=ficha&IdPrograma=".$f4['idprograma']."&programa=".$f4['programa']."'>".$f4['programa']."</a></td>";
	 echo"</tr>";
 
}
 
echo "</table>";
echo "</div>";
// echo "</div></center>";
} else{
	echo "Sin resultados";
}
echo "</div>";
}
}
else{mensaje("No tiene acceso a esta aplicacion",'');}
?>


<?php
include ("./lib/body_footer.php");
?>


