<?php
// include ("unica/seguridad.php"); 
include ("unica/body_head.php");
include ("unica/body_menu.php");

// contenido:
?>



<?php		
		$sql = "SELECT * FROM empleados WHERE nitavu='".$nitavu."'";
		$rc= $conexion -> query($sql);if($f = $rc -> fetch_array())
		{
			if ($f['nitavu'] == $f['nip']){
				//echo "igual";
				//mensaje("Igual","nip_update.php?msg=Por seguridad debe cambiar su NIP");
				$msg="Por su seguridad debe cambiar el NIP";
				mensaje($msg, 'nip_update.php?msg='.$msg."&nitavu=".$nitavu);
			}

		}
?>

<!-- <section name="promos" id="promos" class="pc" style="background-color:transparent; ">
	<span style="height:49px; width:100%; display: inline-block;"></span>
		<div id="slider_ecologico" style="margin:0px; background-color:transparent; "> -->
		




	 
		<div id='PromoHome' style=''>
		 	<!-- <img src="img/slider_eco1.png"/> -->
		
			<p style='color:white; font-family:Regular; text-shadow: 0 0 5px #050404, 0 0 10px #000, 0 0 15px #000;'>
			 Hasta este instante utilizando esta plataforma, hemos ahorrado <br><b class='ejecutandose tgrande' style='font-size:34pt;'>

			 <?php
				$hojas = ceropapel();
				$hojapeso = 4.68; //g 	// obtenido de https://www.tamanosdepapel.com/pesos-de-papel.htm
										//75g /m2 A4

				//Geociencias de la UNAM dice que 100kg =  a la vida de 7arboles //http://www.geociencias.unam.mx/geociencias/iype_cgeo/materiales/recicla.pdf
				//es decir (100K/7) = 14.28k
				//1 arbol = 14280g

				$arbol = 14280;

				$PesoG = $hojas * $hojapeso;
				$PesoK = $PesoG / 1000;
				$arboles =  	$PesoG / $arbol	;

			
			 echo "".number_format($hojas)."</b> hojas.  <br> Es decir ".number_format($PesoK)."k; con esto HEMOS SALVADO <b>".round($arboles)." ARBOLES</b>";
			//  echo "<label style='font-size:7pt; color:white;'><br> * Estos calculos estan basados segun datos de <a style='font-size:7pt; color:white;'  target=blank title='Haga clic aqui para ver publicidad de la UNAM' href='http://www.geociencias.unam.mx/geociencias/iype_cgeo/materiales/recicla.pdf'>Geociencias de la UNAM</a>; donde se expone que ahorrar 100k de papel salva la vida de 7 arboles</label>";

			 ?>
			 </p>
	</div>  
	    
		 <!-- <div style='color:gray; margin:0px; '>
		
		<img src="img/ecologico7.png"/>

</div>   -->

		 
	    
	

	<!-- <div id="ahorro_ecologico">
		
	</div> -->
	<!-- </div> -->
<!-- </section> -->


<section id="alertas">
<!-- 	La funcion escribe los article segun las alertas que existan -->

		<?php
			$alertas = user_alertas($_SESSION['nitavu']);
			echo $alertas;

		?>
		

				<?php
				// if (isset($_GET['nac'])){
				// 	$n = fecha_nacimiento($nitavu,$_GET['nac'], TRUE);
				// 	if ( $n == TRUE) {
				// 		mensaje ('Gracias por tu apoyo, se ha guardado correctamente','');
				// 	}
				// 	else
				// 	{
				// 		mensaje ('Hemos tenido un incoveniente, no se guardo ','');
				// 	}		
				// }


				?>

<?php //echo docdigital_no(TRUE,1); ?>
</section>

<div id="portada_contenido">
<?php
 

?>


<?php
//BARRA DE APPS, MAS USADAS
// echo "<section id='aplicaciones_top'  class='movil'>";
// $sql = "
// select 
// 	xd.iduser as iduser,
// 	(select nombre from empleados where nitavu=iduser) as nombre,
// 	xd.c as cuantos,
// 	xd.idap as id_app,
// 	(select nombre from aplicaciones where aplicaciones.idapp = id_app) as aplicacion,
// 	(select vinculo from aplicaciones where aplicaciones.idapp = id_app) as url,
// 	(select icono from aplicaciones where aplicaciones.idapp = id_app) as icono,
// 	xd.fecha
	
	

// from xd 
// 	-- where c>2
// where xd.iduser='".$nitavu."'
 
// order by c desc
// limit 0,10
// ";
// $r2 = $conexion -> query($sql);while($fv = $r2 -> fetch_array())
// {
// 	echo "<article>";
// 	echo "<a href='".$fv['url']."' title='".$fv['aplicacion'].", Se utilizo por ultima vez el ".fecha_larga($fv['fecha'])."'>";
// 	echo "<img src='icon/".$fv['icono']."'>";
// 	echo "</a>";
// 	echo "</article>";

// }
// echo "</section>";



//-------  AREA DE WIDGETS SUPERIOR para todos

echo "<div id='widgets_top'>";	
	if ($nitavu <> '2772'){
		include("widget_salidas.php");
	}
	

	if (sanpedro('atencionw', $nitavu)==TRUE){
		echo ""; include("atencion_widget.php");echo "";
	} else {
		// include("widget_tiempo.php");//<-- solo victoria por ahora
		// include("widget_cumples.php");
		if ($nitavu <> '2772'){
			include("widget_cumples.php");
		}
	}

echo "</div>";
///------------------------------------


?>


<?php
echo "<div id='app_contenedor' >";
$sql = "SELECT * FROM aplicaciones_categoria";
$r2 = $conexion -> query($sql);
while($apcat = $r2 -> fetch_array())
{//Categorias de Aplicaciones
	//echo $apcat['idapcat'];
	if ($apcat['idapcat']<>2 and  $apcat['idapcat']<>8  and $apcat['idapcat']<>4 ){ 
	//cargamos segun acceso
			$apps = carga_apps($apcat['idapcat'],$nitavu,FALSE);
			if ($apps <> ''){
				echo "<section id='aplicaciones'>";
				echo "<Label>".$apcat['nombre'].":</label>";
				echo $apps;
				echo "</section>";
			}	
		
	} else {
		if ($apcat['idapcat']==4){//solo titulares
			if (soytitular($nitavu)<>'FALSE'){
				$apps = carga_apps($apcat['idapcat'],$nitavu,TRUE);
				if ($apps <> ''){
					echo "<section id='aplicaciones' >";
					echo "<Label style='color:#006699;'>".$apcat['nombre'].":</label>";
					echo $apps;
					echo "</section>";
				}		
			}
			
		}else{
			$apps = carga_apps($apcat['idapcat'],$nitavu,TRUE);
			if ($apps <> ''){
				echo "<section id='aplicaciones'>";
				echo "<Label style='color:green;'>".$apcat['nombre'].":</label>";
				echo $apps;
				echo "</section>";
			}	
		}
		
		

	 }
	
}

//-------  AREA DE WIDGETS INFERIOR, estos aparecen al final de las aplicaciones segun tengan acceso	
//el acceso a estos sera como ser aplicaciones

	
	if (sanpedro('w5', $nitavu)==TRUE){echo ""; include("widget_req.php");echo "";}
	if (sanpedro('w4', $nitavu)==TRUE){echo ""; include("widget_actividad.php");echo "";}
	
	


//-----------------------------------	

echo "</div>";
	





?>

</div>


<?php 
docdigital_no(FALSE, 1); //ahorra 1 hoja
include ("unica/body_footer.php"); ?>

