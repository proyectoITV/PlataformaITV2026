<?php//
//include (".//seguridad.php"); 
include ("../lib/body_head.php");
include ("../lib/body_menu.php");


// contenido:
?>
<script>
function tiempo(){

var fecha= new Date();
var horas= fecha.getHours();
var minutos = fecha.getMinutes();
var segundos = fecha.getSeconds();


if (horas>12){
dn="PM";
horas=horas-12;
} else {
	dn = "AM";
}
document.getElementById('vigi_hora').innerHTML=horas;
document.getElementById('vigi_min').innerHTML=minutos;
document.getElementById('vigi_seg').innerHTML=segundos;
document.getElementById('vigi_dn').innerHTML=dn;

setTimeout('tiempo()',1);
}
setTimeout('tiempo()',10);

</script>

<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap13"; //ap06=Permisos de Aplicacion
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	//echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
	historia($nitavu,"usando la aplicacion [ap13], de vigilancia");

	$delegacion =  midelegacion($nitavu);
	$delegacion_id = midelegacion_id($nitavu);
	echo "<div id='vigi_footer'><table width=100% border=0><tr>";
	echo "<td width=100px align=center ><a href='vigilancia3.php?r=20'><img  src='icon/home.png' style='width:50px; height:50px; opacity:0.5;'></a></td>";
	echo "<td align=left>";
		buscar("vigilancia3.php","Escriba el NITAVU para informar de una salida o entrada de pase de COMIDA",'');
	echo "</td></tr></table>";
	echo "</div>";


	if (isset($_GET['busqueda'])){
		//buscar	
 		//PENDIENTE DELEGACION Y QUE NO DEJE PASAR LOS QUE YA
		
		
	}else 
	{

    echo "<div id='vigi_sugerencias'>";
    if ($delegacion_id==''){
		$sql = "SELECT * FROM empleados_salidas_temporal WHERE (fecha='".$fecha."' AND registro_entrada='00:00:00' and asunto='COMIDA')  ORDER by registro_salida DESC";
	} else {$sql = "SELECT * FROM empleados_salidas_temporal WHERE (fecha='".$fecha."' AND registro_entrada='00:00:00' and asunto='COMIDA') AND dpto='".$delegacion_id."'  ORDER by registro_salida DESC";}
		echo $sql;

		$rc= $conexion -> query($sql); $cuantos = $rc -> num_rows;
		if ($cuantos<=0) {}
		else
		{// SI HAY PASES PENDIENTES:
			//echo "<h1 style='font-size:11pt;'>Hay ".$cuantos." por regresar de su comida:</h1>";
			echo "<label>PASES DE SALIDA PARA COMER:</label>";
			while($f = $rc -> fetch_array()) {
				echo "<a href='vigilancia3.php?busqueda=".$f['nitavu']."' title='".$f['nitavu']." | ".nitavu_nombre($f['nitavu'])." | ".$f['asunto']."'>";
				echo "<article >";				
					echo ponerfoto("fotos/".$f['nitavu'].".jpg",'vigi_foto')."<br>";
					//echo "<div id='nombre_sombra' class=''>".nombre_corto($f['nitavu'],0)."</div>";				
					//echo "<div id='ide' style='opacity:0.5; background-color:black; color:white; font-size: 8pt;'>".$f['nitavu']."</div>";

					echo $f['asunto']."<br>";
					
					$trestante = comida_trestante($f['nitavu']);
					if ($f['asunto']=='OFICIAL' OR $f['asunto']=='OTRO'){
						echo $f['asunto'];



					}
					else {
						if (substr($trestante, 0,1)=='-'){
							echo "<b class='alerta'>".nombre_corto($f['nitavu'],0)."</b><br>";
						} else {
							echo nombre_corto($f['nitavu'],0)."<br>";
						}	
						if (substr($trestante, 0,1)=='-'){//se retraso
							echo "<span class='alerta chico'>".comida_trestante($f['nitavu'])."m</span>";
						} else
						{
							echo "<span class='normal chico'>".comida_trestante($f['nitavu'])."m</span>";
						}
		
					}					

				echo "</article></a>";
				}


			}
	    echo "</div>";



	}









	


	
}
else{echo "No tiene acceso a ".$id_aplicacion;}

?>


<br><br><br><br><br><br><br><br>









<?php
include ("./lib/body_footer.php");
?>