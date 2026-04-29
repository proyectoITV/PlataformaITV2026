<?php
//include (".//seguridad.php");
include ("./lib/body_head.php");

historia ($nitavu,"Vio Las notificaciones");	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title></title>
		<?php
		
		$imprimir = FALSE;
		if ($_GET['p']>0) {$imprimir=TRUE;}else{$imprimir=FALSE;}

		if ($imprimir==TRUE){
			echo '<link rel="stylesheet" href="./lib/css_notificacion_impreso.css">';
		}
		else
		{
			echo '<link rel="stylesheet" href="./lib/css_notificacion_pantalla.css">';
		}	

		?>
	</head>
	<body>



<center>
<div id="documento">
<table bgcolor="#c6cace" border="0" cellpadding="0" cellspacing="0" >
<!-- fwtable fwsrc="hoja.png" fwbase="hoja.jpg" fwstyle="Dreamweaver" fwdocid = "2128631311" fwnested="0" -->
  <tr>
   <td><img src="img/spacer.gif" width="333" height="1" border="0" class="imgt" /></td>
   <td><img src="img/spacer.gif" width="93" height="1" border="0" class="imgt" /></td>
   <td><img src="img/spacer.gif" width="683" height="1" border="0" class="imgt" /></td>
   <td><img src="img/spacer.gif" width="83" height="1" border="0" class="imgt" /></td>
   <td><img src="img/spacer.gif" width="488" height="1" border="0" class="imgt" /></td>
   <td><img src="img/spacer.gif" width="1" height="1" border="0" class="imgt" /></td>
  </tr>

  <tr>
   <td rowspan="5" bgcolor="#c6cace"><img src="img/spacer.gif" width="333" height="1050" border="0" class="imgt" /></td>
   <td><img name="hoja_r1_c2" src="img/hoja_r1_c2.jpg" width="93" height="83" border="0" id="hoja_r1_c2" class="imgt" /></td>
   <td><img name="hoja_r1_c3" src="img/hoja_r1_c3.jpg" width="683" height="83" border="0" id="hoja_r1_c3" class="imgt" /></td>
   <td><img name="hoja_r1_c4" src="img/hoja_r1_c4.jpg" width="83" height="83" border="0" id="hoja_r1_c4" class="imgt" /></td>
   <td rowspan="5" bgcolor="#c6cace"><img src="img/spacer.gif" width="488" height="1050" border="0" class="imgt" /></td>
   
  </tr>
  <tr>
   <td><img name="hoja_r2_c2" src="img/hoja_r2_c2.jpg" width="93" height="73" border="0" id="hoja_r2_c2" class="imgt" /></td>
   <td bgcolor="white" valign="top">


		<?php
		// cargar los datos desde el no. de oficio solicitante
		$docdigital = $_GET['n'];
		


		$sql = "SELECT * FROM notificaciones WHERE no_oficio='".$docdigital."'";
			$rc= $conexion -> query($sql);
			$msg="";
		//echo $sql;
		if($f = $rc -> fetch_array())
		{
		echo '';

		echo '
		<table border="0">
			<tr><td>
				<img src="./img/logo.png" class="logo_impreso">
			</td>
		</tr>
		</table>

		';

		?>

	</td>
   <td><img name="hoja_r2_c4" src="img/hoja_r2_c4.jpg" width="83" height="73" border="0" id="hoja_r2_c4" class="imgt" /></td>
   
  </tr>
  <tr>
   <td><img name="hoja_r3_c2" src="img/hoja_r3_c2.jpg" width="93" height="683" border="0" id="hoja_r3_c2" class="imgt" /></td>
   <td bgcolor="white" valign="top">



		<?php
		echo '
		<table border="0" width="100%" >
		<tr><td align="right" width="60%" class="encabezado">OFICIO NO:</td><td align="left" class="encabezado">'.$docdigital.'</td></tr>
		<tr><td align="right" class="encabezado">ASUNTO:</td><td align="left" class="encabezado">'.$f['asunto'].'</td></tr>
		<tr><td align="right"></td><td align="left" class="encabezado">'.dedondeeres($f['nitavu_manda']).' a '.$f['entregar_fecha'].'</td></tr>
		</table>';



		echo '<label>'.user_legend($f['nitavu']).'</label><br>';

		echo '<span class="contenido"><p align="justify"> ';
		echo $f['contenido'];
		echo '</p></span>';



echo '
</td>
   <td><img name="hoja_r3_c4" src="img/hoja_r3_c4.jpg" width="83" height="683" border="0" id="hoja_r3_c4" class="imgt" /></td>
   
  </tr>
  <tr>
   <td background="img/hoja_r4_c2.jpg"><img name="hoja_r4_c2" src="img/hoja_r4_c2.jpg" width="93" height="250" border="0" id="hoja_r4_c2" class="imgt" /></td>
   <td bgcolor="white">
';



?>



	<p class="pie">

<?php
		echo '
		<p class="firma">
		<span class="atentamente">Atentamente </span><br>
		<label>'.user_legend($f['nitavu_manda']).'</label> <br>
		';

		$archivo = "../firma/".$f['nitavu'].".jpg";
		if (file_exists($archivo)){
			return '<img src="'.$archivo.'" class="'.$clase.'">';
			}
		else 
		{}


		/// FUNCION PARA VISTO
		

		

		echo '</div>';
		}
		else
		{
			mensaje("No se encontro el documento electronico ".$docdigital,'');
		}
		?>





		<table border='0' width="100%">
			<tr>
				<td class="pie">
					INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO
					DIRECCIÓN DE ADMINISTRACIÓN Y FINANZAS
					DEPARTAMENTO DE SOPORTE TÉCNICO Y TELECOMlibCIONES
					CALLE PINO SUÁREZ 2210 NTE.
					COLONIA DR. NORBERTO TREVIÑO ZAPATA
					CIUDAD VICTORIA, TAMAULIPAS, MÉXICO, C.P. 87020
				</td>
				<td>
					<img src="./img/firma_raya.png"
				</td>
				<td class="pie">
					TEL.: (834) 3185506
					EXT.: 46506
				</td>
			</tr>
		</table>
	</p>
</div>


</td>
   <td><img name="hoja_r4_c4" src="img/hoja_r4_c4.jpg" width="83" height="250" border="0" id="hoja_r4_c4" class="imgt" /></td>
   
  </tr>
  <tr>
   <td><img name="hoja_r5_c2" src="img/hoja_r5_c2.jpg" width="93" height="97" border="0" id="hoja_r5_c2" class="imgt" /></td>
   <td><img name="hoja_r5_c3" src="img/hoja_r5_c3.jpg" width="683" height="97" border="0" id="hoja_r5_c3" class="imgt" /></td>
   <td><img name="hoja_r5_c4" src="img/hoja_r5_c4.jpg" width="83" height="97" border="0" id="hoja_r5_c4" class="imgt" /></td>
   
  </tr>




</table>
</center>

<?php
//funcion para marcar como leida esta notificacion
?>

</body>
</html>