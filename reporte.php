<?php
require("config.php");
require("lib/flor_funciones.php");
require("lib/funciones.php");
ini_set('max_execution_time', 0);

//SEGURIDAD 1.- verificacion de variables get
if (isset($_GET['id']) and isset($_GET['nitavu'])){


//verificar si el id, esta en informatica
$EdoReport= ReporteEnInformatica($_GET['id']);
// echo "<h1>".$EdoReport."</h1>";

if ($EdoReport == 'INFORMATICA'){
		echo "<div id='master' style='width:100%; height:100%; margin:0px; text-align:center;'>
		<h3 style='color:#A3C30F; margin:0px;' >IDENTIFICATE! informatico</h3>
		<form action='reporte.php?id=".$_GET['id']."&nitavu=".$_GET['nitavu']."' method='POST'
		style='
		background-color:#A3C30F;
		width: 80%; border-radius:5px;
		display:inline-block;
		padding: 10px;'>";
		echo "<table><tr>";
		echo "<td><label style='color:white; font-family:Verdana;'><b>¿Quien eres?</b></label></td><td><select name='user'
		style='font-family:Verdana; font-size:12pt; color:#A3C30F; width:100%;'
		>";
		$sql="select nitavu, nombre, dpto from empleados where dpto=55 and estado=''";
		$rc= $conexion -> query($sql);
		if($rc){while($f = $rc -> fetch_array()){
			echo "<option value='".$f['nitavu']."'>".$f['nombre']."</option>";	
			//para seleccionar		
			if ($_GET['nitavu'] == $f['nitavu']){echo "<option value='".$f['nitavu']."' selected='selected'>".$f['nombre']."</option>";}			
		}}	
		echo "</selected></td></tr>";

		echo "<td><label style='color:white; font-family:Verdana;' >Password</label></td><td><input style=' width:100%;font-family:Verdana; font-size:12pt; color:#A3C30F;' type='password' name='password'></td><tr>";
		echo "</table><div><input type='submit' class='Mbtn btn-default' value='Ver reporte' name='rp2'
		style='font-family:Verdana; font-size:12pt; with: 50%; padding:5px; '
		></div>";
		echo "</form>";
		$bd ="";
		$del ="";
		if (isset($_POST['rp2'])) {
			$ok = FALSE;
			//	echo $sql;
			$sql = "SELECT nombre, nitavu, nip, dpto FROM empleados WHERE nitavu='".$_POST['user']."'";
			$txt = "";
			$r= $conexion -> query($sql);if($f = $r -> fetch_array())
			{
				if ($f['nitavu'] == $_POST['user']){
					if ($f['nip'] == $_POST['password']){
						$ok=TRUE;
					} else {$ok=FALSE; $txt = $txt."Password	 incorrecto. ";}
				} else {$ok=FALSE; $txt = $txt."Usuario incorrecto. ";}
			}

			if ($ok == FALSE){		
			echo "<div style='
				background-color:#004D8A; color:white; font-size:14pt; font-family:Verdana;
				width: 78%; border-radius: 5px; padding: 20px; margin-top: 0px; display:inline-block;
			'>";
			echo $txt." ".$_POST['user'];
			echo "</div>";
			echo "</div>";
			} else {
				//mostramos el reporte
				echo "</div>";			
				echo '<script>document.getElementById("master").style.display = "none";</script>';
				ob_end_clean();
				$id= $_GET['id'];
				$nitavu = $_GET['nitavu'];
				reporteshistoria($nitavu, $id);
				//$orientacion=""; $autor=""; $titulo=""; $descripcion="";
				if(isset($_GET['previsualizar'])){
					$sql = "SELECT * FROM reportes WHERE id_rep_consulta='".$id."'";
					$rc= $conexion -> query($sql);
					if($f = $rc -> fetch_array()){ 
						$orientacion = $f['orientacion'];
						$autor = $f['nitavu'];
						$titulo = $f['nombre'];
						$descripcion = $f['descripcion'];
						
					} 
					$t = primerConsultaPre($id);
					$t2 = segundaConsulta($id);
					$t3 = tercerConsulta($id);
				}else{
					$sql = "SELECT * FROM reportes WHERE id_rep_consulta='".$id."'";
					$rc= $conexion -> query($sql);
					if($f = $rc -> fetch_array()){ 
						$orientacion = $f['orientacion'];
						$autor = $f['nitavu'];
						$titulo = $f['nombre'];
						$descripcion = $f['descripcion'];
						$bd = $f['basededatos'];
						$del = $f['delegacion'];
					} 
				
					if($bd=="V"){
				
						$t = primerConsultaVivienda($del,$id);
						$t2 = segundaConsultaVivienda($del,$id);
						$t3 = tercerConsultaVivienda($del,$id);
					}
					else
					{
						$t = primerConsultaPre($id);
						$t2 = segundaConsulta($id);
						$t3 = tercerConsulta($id);
						
					}
				}
			

				
				require('pdf/tcpdf.php');
				
				// create new PDF document
				$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor($autor);
				$pdf->SetTitle("d".strtoupper($titulo));
				$pdf->SetSubject("x".$titulo);
				$pdf->SetKeywords('Reporte ITAVU');
				// set default header data
				// $PDF_HEADER_TITLE="Titulo del PDF";
				// $PDF_HEADER_STRING="SEgunda linea";
				// $PDF_HEADER_LOGO="imagen"; //Solo me funciona si esta dentro de la carpeta images de la libreria
			
				// $this->pdf->SetHeaderData($PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);
			
			
				$pdf->SetHeaderData('pdf_logo.jpg', '30', strtoupper("".$titulo).'', $descripcion."\nImpreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($_POST['user'])."(".$_POST['user'].")");
			
				// set header and footer fonts
				// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 6));
				$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				// set default monospaced font
				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
				// set margins
				$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				// set auto page breaks
				$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
				// set image scale factor
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
				// set some language-dependent strings (optional)
				if (@file_exists(dirname(__FILE__).'pdf/lang/eng.php')) {
					require_once(dirname(__FILE__).'pdf/lang/eng.php');
					$pdf->setLanguageArray($l);
				}
				// set font
				$pdf->SetFont('helvetica', '', 7);
				// add a page
				$pdf->AddPage($orientacion); //en la tabla de reporte L o P
				$html = $t;
				//echo $html;// aqui escribe el contenido de la consulta
				$pdf->writeHTML($html, true, false, true, 0, '');
				
			
				//echo $orientacion;
				if($orientacion=="L"){
					//echo $orientacion;
					if(isset($t2) or isset($t3)){
					$pdf->AddPage($orientacion); //en la tabla de reporte L o P
					//$pdf->writeHTMLCell(100, '', 60,$y, $t3, 0, 0, 0, true, 'J', true);
					}
					$y = $pdf->getY();
					// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
					if(isset($t2)){
						$pdf->writeHTMLCell(100, '', 60, $y, $t2, 0, 0, 0, false, 'L', true);
					}
					if (isset($t3)){
						$pdf->writeHTMLCell(100, '', '', '', $t3, 0, 0, 0, true, 'L', true);
					}
					// reset pointer to the last page
					$pdf->lastPage();
					//Close and output PDF document
					$pdf->Output('reporte.pdf', 'I');
				}else if($orientacion == 'P'){
					//echo $orientacion;
					if(isset($t2) or isset($t3)){
					$pdf->AddPage($orientacion); //en la tabla de reporte L o P
					//$pdf->writeHTMLCell(100, '', 60,$y, $t3, 0, 0, 0, true, 'J', true);
					}
					$y = $pdf->getY();
					// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
					if(isset($t2)){
						$pdf->writeHTMLCell(100, '', '', $y, $t2, 0, 0, 0, false, 'L', true);
					}
					if (isset($t3)){
						$pdf->writeHTMLCell(100, '', '', '', $t3, 0, 0, 0, true, 'L', true);
					}
					// reset pointer to the last page
					$pdf->lastPage();
					//Close and output PDF document}
					$pdf->Output('reporte.pdf', 'I');
				}


			}//else ok
		}//fn rp2
} // fin informatica



if ($EdoReport =='INFORMATICA-JEFE'){
		echo "<div id='master' style='width:100%; height:100%; margin:0px; text-align:center;'>
		<h3 style='color:#A3C30F; margin:0px;' >IDENTIFICATE! Jede del Dpto. de Informatica</h3>
		<form action='reporte.php?id=".$_GET['id']."&nitavu=".$_GET['nitavu']."' method='POST'
		style='
		background-color:#A3C30F;
		width: 80%; border-radius:5px;
		display:inline-block;
		padding: 10px;'>";
		echo "<table><tr>";
		echo "<td><label style='color:white; font-family:Verdana;'><b>¿Quien eres?</b></label></td><td><select name='user'
		style='font-family:Verdana; font-size:12pt; color:#A3C30F; width:100%;'
		>";
		$sql="select 
		id as dpto,
		titular as QNitavu,
		(select nombre from empleados where nitavu=QNitavu) as nombre
		from cat_gerarquia where id=55";
		$rc= $conexion -> query($sql);
		if($rc){while($f = $rc -> fetch_array()){
			echo "<option value='".$f['QNitavu']."'>".$f['nombre']."</option>";	
			//para seleccionar		
			// if ($_GET['nitavu'] == $f['QNitavu']){echo "<option value='".$f['nitavu']."' selected='selected'>".$f['nombre']."</option>";}			
		}}	
		echo "</select></td></tr>";

		echo "<td><label style='color:white; font-family:Verdana;' >Password</label></td><td><input style=' width:100%;font-family:Verdana; font-size:12pt; color:#A3C30F;' type='password' name='password'></td><tr>";
		echo "</table><div><input type='submit' class='Mbtn btn-default' value='Ver reporte' name='rp3'
		style='font-family:Verdana; font-size:12pt; with: 50%; padding:5px; '
		></div>";
		echo "</form>";
		
		if (isset($_POST['rp3'])) {
			$ok = FALSE;
			//	echo $sql;
			$sql = "SELECT nombre, nitavu, nip, dpto FROM empleados WHERE nitavu='".$_POST['user']."'";
			$txt = "";
			$r= $conexion -> query($sql);if($f = $r -> fetch_array())
			{
				if ($f['nitavu'] == $_POST['user']){
					if ($f['nip'] == $_POST['password']){
						$ok=TRUE;
					} else {$ok=FALSE; $txt = $txt."Password	 incorrecto. ";}
				} else {$ok=FALSE; $txt = $txt."Usuario incorrecto. ";}
			}

			if ($ok == FALSE){		
			echo "<div style='
				background-color:#004D8A; color:white; font-size:14pt; font-family:Verdana;
				width: 78%; border-radius: 5px; padding: 20px; margin-top: 0px; display:inline-block;
			'>";
			echo $txt." ".$_POST['user'];
			echo "</div>";
			echo "</div>";
			} else {
				//mostramos el reporte
				echo "</div>";			
				echo '<script>document.getElementById("master").style.display = "none";</script>';
				ob_end_clean();
				$id= $_GET['id'];
				$nitavu = $_GET['nitavu'];
				reporteshistoria($nitavu, $id);
				//$orientacion=""; $autor=""; $titulo=""; $descripcion="";
				if(isset($_GET['previsualizar'])){
					$sql = "SELECT * FROM reportes WHERE id_rep_consulta='".$id."'";
					$rc= $conexion -> query($sql);
					if($f = $rc -> fetch_array()){ 
						$orientacion = $f['orientacion'];
						$autor = $f['nitavu'];
						$titulo = $f['nombre'];
						$descripcion = $f['descripcion'];
						$bd = $f['basededatos'];
						$del = $f['delegacion'];
					} 
				
					if($bd=="V"){
				
						$t = primerConsultaVivienda($del,$id);
						$t2 = segundaConsultaVivienda($del,$id);
						$t3 = tercerConsultaVivienda($del,$id);
					}
					else
					{
						$t = primerConsultaPre($id);
						$t2 = segundaConsulta($id);
						$t3 = tercerConsulta($id);
						
					}
				}else{
					$sql = "SELECT * FROM reportes WHERE id_rep_consulta='".$id."'";
					$rc= $conexion -> query($sql);
					if($f = $rc -> fetch_array()){ 
						$orientacion = $f['orientacion'];
						$autor = $f['nitavu'];
						$titulo = $f['nombre'];
						$descripcion = $f['descripcion'];
						$bd = $f['basededatos'];
						$del = $f['delegacion'];
					} 
					
					if($bd=="V"){
				
						$t = primerConsultaVivienda($del,$id);
						$t2 = segundaConsultaVivienda($del,$id);
						$t3 = tercerConsultaVivienda($del,$id);
					}
					else
					{
						$t = primerConsultaPre($id);
						$t2 = segundaConsulta($id);
						$t3 = tercerConsulta($id);
						
					}
				}
			

				
				require('pdf/tcpdf.php');
				
				// create new PDF document
				$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor($autor);
				$pdf->SetTitle("d".strtoupper($titulo));
				$pdf->SetSubject("x".$titulo);
				$pdf->SetKeywords('Reporte ITAVU');
				// set default header data
				// $PDF_HEADER_TITLE="Titulo del PDF";
				// $PDF_HEADER_STRING="SEgunda linea";
				// $PDF_HEADER_LOGO="imagen"; //Solo me funciona si esta dentro de la carpeta images de la libreria
			
				// $this->pdf->SetHeaderData($PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);
			
			
				$pdf->SetHeaderData('pdf_logo.jpg', '30', strtoupper("".$titulo).'', $descripcion."\nImpreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($_POST['user'])."(".$_POST['user'].")");
			
				// set header and footer fonts
				// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 6));
				$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				// set default monospaced font
				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
				// set margins
				$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				// set auto page breaks
				$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
				// set image scale factor
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
				// set some language-dependent strings (optional)
				if (@file_exists(dirname(__FILE__).'pdf/lang/eng.php')) {
					require_once(dirname(__FILE__).'pdf/lang/eng.php');
					$pdf->setLanguageArray($l);
				}
				// set font
				$pdf->SetFont('helvetica', '', 7);
				// add a page
				$pdf->AddPage($orientacion); //en la tabla de reporte L o P
				$html = $t;
				//echo $html; //aqui escribe el contenido de la consulta
				$pdf->writeHTML($html, true, false, true, 0, '');
			
				//echo $orientacion;
				if($orientacion=="L"){
					//echo $orientacion;
					if(isset($t2) or isset($t3)){
					$pdf->AddPage($orientacion); //en la tabla de reporte L o P
					//$pdf->writeHTMLCell(100, '', 60,$y, $t3, 0, 0, 0, true, 'J', true);
					}
					$y = $pdf->getY();
					// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
					if(isset($t2)){
						$pdf->writeHTMLCell(100, '', 60, $y, $t2, 0, 0, 0, false, 'L', true);
					}
					if (isset($t3)){
						$pdf->writeHTMLCell(100, '', '', '', $t3, 0, 0, 0, true, 'L', true);
					}
					// reset pointer to the last page
					$pdf->lastPage();
					//Close and output PDF document
					$pdf->Output('reporte.pdf', 'I');
				}else if($orientacion == 'P'){
					//echo $orientacion;
					if(isset($t2) or isset($t3)){
					$pdf->AddPage($orientacion); //en la tabla de reporte L o P
					//$pdf->writeHTMLCell(100, '', 60,$y, $t3, 0, 0, 0, true, 'J', true);
					}
					$y = $pdf->getY();
					// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
					if(isset($t2)){
						$pdf->writeHTMLCell(100, '', '', $y, $t2, 0, 0, 0, false, 'L', true);
					}
					if (isset($t3)){
						$pdf->writeHTMLCell(100, '', '', '', $t3, 0, 0, 0, true, 'L', true);
					}
					// reset pointer to the last page
					$pdf->lastPage();
					//Close and output PDF document}
					$pdf->Output('reporte.pdf', 'I');
				}


			}//else ok
		}//fn rp2
	}//fin informatica - jefe

	if ($EdoReport =='AUTORIZA'){
		$QuienAutoriza = ReporteQuienAutoriza($_GET['id']);
		

		if (validaIDreporte($_GET['id'])==0){	
			echo "Reporte incorrecto";

		} else { //contiamos
			//validar contraseña
			//ocupamos primero la lista de los usuarios que pueden ver este reporte

			echo "<div id='master' style='width:100%; height:100%; margin:0px; text-align:center;'>
			<h3 style='color:#A3C30F; margin:0px; font-family:Verdana; ' >Identificate</h3>
			<label style='color:gray; font-size:8pt; font-family:Verdana;'>Para ver este reporte necesitas tener permiso para AUTORIZARLO</label>
			<form action='reporte.php?id=".$_GET['id']."&nitavu=".$_GET['nitavu']."' method='POST'
			style='
				background-color:#A3C30F;
				width: 80%; border-radius:5px;
				display:inline-block;
				padding: 10px;
			'
			
			>";
			echo "<table><tr>";
			echo "<td><label style='color:white; font-family:Verdana;'><b>¿Quien eres?</b></label></td><td><select name='user'
			style='font-family:Verdana; font-size:12pt; color:#A3C30F; width:100%;'
			>";
			$sql="select nitavu, nombre from empleados where nitavu='".$QuienAutoriza."'";
			$rc= $conexion -> query($sql);
			if($rc){while($f = $rc -> fetch_array()){
				echo "<option value='".$f['nitavu']."'>".$f['nombre']."</option>";	

			}}	
			echo "</select></td></tr>";

			echo "<td><label style='color:white; font-family:Verdana;' >Password</label></td><td><input style=' width:100%;font-family:Verdana; font-size:12pt; color:#A3C30F;' type='password' name='password'></td><tr>";
			echo "</table><div><input type='submit' class='Mbtn btn-default' value='Ver reporte' name='rp'
			style='font-family:Verdana; font-size:12pt; with: 50%; padding:5px; '
			></div>";

			echo "</form>";
			
			if (isset($_POST['rp'])) {
				$ok = FALSE;
				//	echo $sql;
				$sql = "SELECT nombre, nitavu, nip FROM empleados WHERE nitavu='".$_POST['user']."'";
				$txt = "";

				$r= $conexion -> query($sql);if($f = $r -> fetch_array())
				{
					if ($f['nitavu'] == $_POST['user']){
						if ($f['nip'] == $_POST['password']){
							$ok=TRUE;
						} else {$ok=FALSE; $txt = $txt."Password	 incorrecto. ";}
					} else {$ok=FALSE; $txt = $txt."Usuario incorrecto. ";}
				}

				if ($ok == FALSE){		
				echo "<div style='
					background-color:#004D8A; color:white; font-size:14pt; font-family:Verdana;
					width: 78%; border-radius: 5px; padding: 20px; margin-top: 0px; display:inline-block;

				'>";
				echo $txt." ";
				//.$_POST['user'];
				echo "</div>";
				echo "</div>";
				}

				else {
					//DESPLEGAR REPORTE

					//PROBLEMA ACTUAL= Eliminar tags html 
					echo "</div>"; // cierre div master

					echo '<script>document.getElementById("master").style.display = "none";</script>';
					ob_end_clean();
					$id= $_GET['id'];
					$nitavu = $_GET['nitavu'];
					reporteshistoria($nitavu, $id);
					//$orientacion=""; $autor=""; $titulo=""; $descripcion="";
						$sql = "SELECT * FROM reportes WHERE id_rep_consulta='".$id."' ";
						$rc= $conexion -> query($sql);
						if($f = $rc -> fetch_array()){ 
							$orientacion = $f['orientacion'];
							$autor = $f['nitavu'];
							$titulo = $f['nombre'];
							$descripcion = $f['descripcion'];
							$bd = $f['basededatos'];
							$del = $f['delegacion'];
					} 
					
					if($bd=="V"){
				
						$t = primerConsultaVivienda($del,$id);
						$t2 = segundaConsultaVivienda($del,$id);
						$t3 = tercerConsultaVivienda($del,$id);
					}
					else
					{
						$t = primerConsultaPre($id);
						$t2 = segundaConsulta($id);
						$t3 = tercerConsulta($id);
						
					}
				}
				

					
					require('pdf/tcpdf.php');
					
					// create new PDF document
					$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
					// set document information
					$pdf->SetCreator(PDF_CREATOR);
					$pdf->SetAuthor($autor);
					$pdf->SetTitle("d".strtoupper($titulo));
					$pdf->SetSubject("x".$titulo);
					$pdf->SetKeywords('Reporte ITAVU');
					// set default header data
					// $PDF_HEADER_TITLE="Titulo del PDF";
					// $PDF_HEADER_STRING="SEgunda linea";
					// $PDF_HEADER_LOGO="imagen"; //Solo me funciona si esta dentro de la carpeta images de la libreria
				
					// $this->pdf->SetHeaderData($PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);
				
				
					$pdf->SetHeaderData('pdf_logo.jpg', '30', strtoupper("".$titulo).'', $descripcion."\nImpreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($_POST['user'])."(".$_POST['user'].")");
				
					// set header and footer fonts
					// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 6));
					$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
					// set default monospaced font
					$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
					// set margins
					$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
					$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
					$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
					// set auto page breaks
					$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
					// set image scale factor
					$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
					// set some language-dependent strings (optional)
					if (@file_exists(dirname(__FILE__).'pdf/lang/eng.php')) {
						require_once(dirname(__FILE__).'pdf/lang/eng.php');
						$pdf->setLanguageArray($l);
					}
					// set font
					$pdf->SetFont('helvetica', '', 7);
					// add a page
					$pdf->AddPage($orientacion); //en la tabla de reporte L o P
					$html = $t;
					//echo $html; aqui escribe el contenido de la consulta
					$pdf->writeHTML($html, true, false, true, 0, '');
				
					//echo $orientacion;
					if($orientacion=="L"){
						//echo $orientacion;
						if(isset($t2) or isset($t3)){
						$pdf->AddPage($orientacion); //en la tabla de reporte L o P
						//$pdf->writeHTMLCell(100, '', 60,$y, $t3, 0, 0, 0, true, 'J', true);
						}
						$y = $pdf->getY();
						// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
						if(isset($t2)){
							$pdf->writeHTMLCell(100, '', 60, $y, $t2, 0, 0, 0, false, 'L', true);
						}
						if (isset($t3)){
							$pdf->writeHTMLCell(100, '', '', '', $t3, 0, 0, 0, true, 'L', true);
						}
						// reset pointer to the last page
						$pdf->lastPage();
						//Close and output PDF document
						$pdf->Output('reporte.pdf', 'I');
					}else if($orientacion == 'P'){
						//echo $orientacion;
						if(isset($t2) or isset($t3)){
						$pdf->AddPage($orientacion); //en la tabla de reporte L o P
						//$pdf->writeHTMLCell(100, '', 60,$y, $t3, 0, 0, 0, true, 'J', true);
						}
						$y = $pdf->getY();
						// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
						if(isset($t2)){
							$pdf->writeHTMLCell(100, '', '', $y, $t2, 0, 0, 0, false, 'L', true);
						}
						if (isset($t3)){
							$pdf->writeHTMLCell(100, '', '', '', $t3, 0, 0, 0, true, 'L', true);
						}
						// reset pointer to the last page
						$pdf->lastPage();
						//Close and output PDF document}
						$pdf->Output('reporte.pdf', 'I');
					}
				
				//}//fin de validacion de $ok


			}else {echo "";}



		} // fin validacion id


	}//fin autoriza


	if ($EdoReport == 'PRE-PUBLICAR'){
	$Quien = ReporteDeQuienEs($_GET['id']);
	

	if (validaIDreporte($_GET['id'])==0){	
		echo "Reporte incorrecto";

	} else { //contiamos
		//validar contraseña
		//ocupamos primero la lista de los usuarios que pueden ver este reporte

		echo "<div id='master' style='width:100%; height:100%; margin:0px; text-align:center;'>
		<h3 style='color:#A3C30F; margin:0px; font-family:Verdana; ' >Identificate</h3>
		<label style='color:gray; font-size:8pt; font-family:Verdana;'>Para ver este reporte necesitas tener permiso para PUBLICARLO</label>
		<form action='reporte.php?id=".$_GET['id']."&nitavu=".$_GET['nitavu']."' method='POST'
		style='
			background-color:#A3C30F;
			width: 80%; border-radius:5px;
			display:inline-block;
			padding: 10px;
		'
		
		>";
		echo "<table><tr>";
		echo "<td><label style='color:white; font-family:Verdana;'><b>¿Quien eres?</b></label></td><td><select name='user'
		style='font-family:Verdana; font-size:12pt; color:#A3C30F; width:100%;'
		>";
		$sql="select nitavu, nombre from empleados where nitavu='".$Quien."'";
		$rc= $conexion -> query($sql);
		if($rc){while($f = $rc -> fetch_array()){
			echo "<option value='".$f['nitavu']."'>".$f['nombre']."</option>";	

		}}	
		echo "</select></td></tr>";

		echo "<td><label style='color:white; font-family:Verdana;' >Password</label></td><td><input style=' width:100%;font-family:Verdana; font-size:12pt; color:#A3C30F;' type='password' name='password'></td><tr>";
		echo "</table><div><input type='submit' class='Mbtn btn-default' value='Ver reporte' name='rp'
		style='font-family:Verdana; font-size:12pt; with: 50%; padding:5px; '
		></div>";

		echo "</form>";
		
		if (isset($_POST['rp'])) {
			$ok = FALSE;
			//	echo $sql;
			$sql = "SELECT nombre, nitavu, nip FROM empleados WHERE nitavu='".$Quien."'";
			$txt = "";

			$r= $conexion -> query($sql);if($f = $r -> fetch_array())
			{
				if ($f['nitavu'] == $_POST['user']){
					if ($f['nip'] == $_POST['password']){
						$ok=TRUE;
					} else {$ok=FALSE; $txt = $txt."Password	 incorrecto. ";}
				} else {$ok=FALSE; $txt = $txt."Usuario incorrecto. ";}
			}

			if ($ok == FALSE){		
			echo "<div style='
				background-color:#004D8A; color:white; font-size:14pt; font-family:Verdana;
				width: 78%; border-radius: 5px; padding: 20px; margin-top: 0px; display:inline-block;

			'>";
			echo $txt." ";
			//.$_POST['user'];
			echo "</div>";
			echo "</div>";
			}

			else {
				//DESPLEGAR REPORTE

				//PROBLEMA ACTUAL= Eliminar tags html 
				echo "</div>"; // cierre div master

				echo '<script>document.getElementById("master").style.display = "none";</script>';
				ob_end_clean();
				$id= $_GET['id'];
				$nitavu = $_GET['nitavu'];
				reporteshistoria($nitavu, $id);
				//$orientacion=""; $autor=""; $titulo=""; $descripcion="";
					$sql = "SELECT * FROM reportes WHERE id_rep_consulta='".$id."' ";
					$rc= $conexion -> query($sql);
					if($f = $rc -> fetch_array()){ 
						$orientacion = $f['orientacion'];
						$autor = $f['nitavu'];
						$titulo = $f['nombre'];
						$descripcion = $f['descripcion'];
						$bd = $f['basededatos'];
						$del = $f['delegacion'];
					} 
				
					if($bd=="V"){
				
						$t = primerConsultaVivienda($del,$id);
						$t2 = segundaConsultaVivienda($del,$id);
						$t3 = tercerConsultaVivienda($del,$id);
					}
					else
					{
						$t = primerConsultaPre($id);
						$t2 = segundaConsulta($id);
						$t3 = tercerConsulta($id);
						
					}
			}
			

				
				require('pdf/tcpdf.php');
				
				// create new PDF document
				$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
				// set document information
				$pdf->SetCreator(PDF_CREATOR);
				$pdf->SetAuthor($autor);
				$pdf->SetTitle("d".strtoupper($titulo));
				$pdf->SetSubject("x".$titulo);
				$pdf->SetKeywords('Reporte ITAVU');
				// set default header data
				// $PDF_HEADER_TITLE="Titulo del PDF";
				// $PDF_HEADER_STRING="SEgunda linea";
				// $PDF_HEADER_LOGO="imagen"; //Solo me funciona si esta dentro de la carpeta images de la libreria
			
				// $this->pdf->SetHeaderData($PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);
			
			
				$pdf->SetHeaderData('pdf_logo.jpg', '30', strtoupper("".$titulo).'', $descripcion."\nImpreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($_POST['user'])."(".$_POST['user'].")");
			
				// set header and footer fonts
				// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
				$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 6));
				$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
				// set default monospaced font
				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
				// set margins
				$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
				// set auto page breaks
				$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
				// set image scale factor
				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
				// set some language-dependent strings (optional)
				if (@file_exists(dirname(__FILE__).'pdf/lang/eng.php')) {
					require_once(dirname(__FILE__).'pdf/lang/eng.php');
					$pdf->setLanguageArray($l);
				}
				// set font
				$pdf->SetFont('helvetica', '', 7);
				// add a page
				$pdf->AddPage($orientacion); //en la tabla de reporte L o P
				$html = $t;
				//echo $html; aqui escribe el contenido de la consulta
				$pdf->writeHTML($html, true, false, true, 0, '');
			
				//echo $orientacion;
				if($orientacion=="L"){
					//echo $orientacion;
					if(isset($t2) or isset($t3)){
					$pdf->AddPage($orientacion); //en la tabla de reporte L o P
					//$pdf->writeHTMLCell(100, '', 60,$y, $t3, 0, 0, 0, true, 'J', true);
					}
					$y = $pdf->getY();
					// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
					if(isset($t2)){
						$pdf->writeHTMLCell(100, '', 60, $y, $t2, 0, 0, 0, false, 'L', true);
					}
					if (isset($t3)){
						$pdf->writeHTMLCell(100, '', '', '', $t3, 0, 0, 0, true, 'L', true);
					}
					// reset pointer to the last page
					$pdf->lastPage();
					//Close and output PDF document
					$pdf->Output('reporte.pdf', 'I');
				}else if($orientacion == 'P'){
					//echo $orientacion;
					if(isset($t2) or isset($t3)){
					$pdf->AddPage($orientacion); //en la tabla de reporte L o P
					//$pdf->writeHTMLCell(100, '', 60,$y, $t3, 0, 0, 0, true, 'J', true);
					}
					$y = $pdf->getY();
					// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
					if(isset($t2)){
						$pdf->writeHTMLCell(100, '', '', $y, $t2, 0, 0, 0, false, 'L', true);
					}
					if (isset($t3)){
						$pdf->writeHTMLCell(100, '', '', '', $t3, 0, 0, 0, true, 'L', true);
					}
					// reset pointer to the last page
					$pdf->lastPage();
					//Close and output PDF document}
					$pdf->Output('reporte.pdf', 'I');
				}
			
			//}//fin de validacion de $ok


		}else {echo "";}



	} // fin validacion id

}//fin prepub




			// echo "<h1>=>".ReporteEnInformatica($_GET['id'])."</h1>";
	if ($EdoReport <> "INFORMATICA" AND $EdoReport <> "INFORMATICA-JEFE" AND $EdoReport <> "AUTORIZA" AND $EdoReport <> "PRE-PUBLICAR"){

	
			//SEGURIDAD 2.- validar id y nitavu
		if (validaIDreporte($_GET['id'])==0){	
			echo "Reporte incorrecto";

		} else { //contiamos
			//validar contraseña
			//ocupamos primero la lista de los usuarios que pueden ver este reporte
		
			echo "<div id='master' style='width:100%; height:100%; margin:0px; text-align:center;'>";

			// $info = quienpuedeverreportes('1533');
			//echo "Yo puedo ver estos reportes: ";
			
			$midpto = nitavu_dpto2($_GET['nitavu']);
			$empleados = quiendependedemi($midpto);
			$MisReportes = reportesDeMisDependientes($empleados);
			$PuedoVerlo = FALSE;
			for($i=0; $i < sizeof($MisReportes); $i++){  
				// echo $MisReportes[$i].","; //<---- reportes que ver
				if ($MisReportes[$i]==$_GET['id']){
					$PuedoVerlo = TRUE;
				}
			}

			

			echo"
			<h3 style='color:#A3C30F; margin:0px;' >IDENTIFICATE!</h3>
			<form action='reporte.php?id=".$_GET['id']."&nitavu=".$_GET['nitavu']."' method='POST'
			style='
				background-color:#A3C30F;
				width: 80%; border-radius:5px;
				display:inline-block;
				padding: 10px;
			'
			
			>";
			echo "<table><tr>";
			echo "<td><label style='color:white; font-family:Verdana;'><b>¿Quien eres?</b></label></td><td><select name='user'
			style='font-family:Verdana; font-size:12pt; color:#A3C30F; width:100%;'
			>";
			$sql="
			SELECT 
				reportes.id_rep as Qid_rep, reportes.id_rep_consulta as Qid_consulta,
				reportes.solicitante as Usuario,
				(select nombre from empleados where nitavu=Usuario) as Nombre
				
			FROM
				reportes
			WHERE reportes.id_rep_consulta = '".$_GET['id']."'

			UNION

			SELECT 
				reportes_eq.nombre as Qid_rep, reportes_eq.nombre as Qid_consulta,
				reportes_eq.integrante as Usuario,
				(select nombre from empleados where nitavu=Usuario) as Nombre
				
			FROM
				reportes_eq
			WHERE reportes_eq.nombre = '".$_GET['id']."'";

			if ($PuedoVerlo == TRUE){
				$sql = $sql."
				UNION
	
				SELECT 
					empleados.nitavu as Qid_rep, empleados.nitavu as Qid_consulta,
					empleados.nitavu as Usuario,	nombre
					
				FROM
					empleados
				WHERE nitavu = '".$_GET['nitavu']."'";
			}
			
			
			
			
			
			$rc= $conexion -> query($sql);
			$autorizo="";
			// echo $sql;
			if($rc){while($f = $rc -> fetch_array()){

				
				echo "<option value='".$f['Usuario']."'>".$f['Nombre']."</option>";	

				//para seleccionar
				if ($_GET['nitavu'] == $f['Usuario']){echo "<option value='".$f['Usuario']."' selected='selected'>".$f['Nombre']."</option>";		}
					
					
			
			

			}}	
			echo "</select></td></tr>";

			echo "<td><label style='color:white; font-family:Verdana;' >Password</label></td><td><input style=' width:100%;font-family:Verdana; font-size:12pt; color:#A3C30F;' type='password' name='password'></td><tr>";
			echo "</table><div><input type='submit' class='Mbtn btn-default' value='Ver reporte' name='rp'
			style='font-family:Verdana; font-size:12pt; with: 50%; padding:5px; '
			></div>";

			echo "</form>";
			
			if (isset($_POST['rp'])) {
				$ok = FALSE;
				//	echo $sql;
				$sql = "SELECT nombre, nitavu, nip FROM empleados WHERE nitavu='".$_POST['user']."'";
				$txt = "";

				$r= $conexion -> query($sql);if($f = $r -> fetch_array())
				{
					if ($f['nitavu'] == $_POST['user']){
						if ($f['nip'] == $_POST['password']){
							$ok=TRUE;
						} else {$ok=FALSE; $txt = $txt."Password	 incorrecto. ";}
					} else {$ok=FALSE; $txt = $txt."Usuario incorrecto. ";}
				}

				if ($ok == FALSE){		
				echo "<div style='
					background-color:#004D8A; color:white; font-size:14pt; font-family:Verdana;
					width: 78%; border-radius: 5px; padding: 20px; margin-top: 0px; display:inline-block;

				'>";
				echo $txt." ".$_POST['user'];
				echo "</div>";
				echo "</div>";
				}

				else {
					//DESPLEGAR REPORTE
					

					//PROBLEMA ACTUAL= Eliminar tags html 
					echo "</div>"; // cierre div master

					echo '<script>document.getElementById("master").style.display = "none";</script>';
					ob_end_clean();
					$id= $_GET['id'];
					$nitavu = $_GET['nitavu'];
					reporteshistoria($nitavu, $id);
					//$orientacion=""; $autor=""; $titulo=""; $descripcion="";
					if(isset($_GET['previsualizar'])){
						
						$sql = "SELECT * FROM reportes WHERE id_rep_consulta='".$id."'";
						$rc= $conexion -> query($sql);
						if($f = $rc -> fetch_array()){ 
							$orientacion = $f['orientacion'];
							$autor = $f['nitavu'];
							$titulo = $f['nombre'];
							$descripcion = $f['descripcion'];
							$bd = $f['basededatos'];							
							$del = $f['delegacion'];
						} 
						
						if($bd=="V"){
				
							$t = primerConsultaVivienda($del,$id);
							$t2 = segundaConsultaVivienda($del,$id);
							$t3 = tercerConsultaVivienda($del,$id);
						}
						else
						{
							$t = primerConsultaPre($id);
							$t2 = segundaConsulta($id);
							$t3 = tercerConsulta($id);
							
						}
					}else{
						
						$sql = "SELECT * FROM reportes WHERE id_rep_consulta='".$id."' AND estado=4";
						$rc= $conexion -> query($sql);
						if($f = $rc -> fetch_array()){ 
							$orientacion = $f['orientacion'];
							$autor = $f['nitavu'];
							$titulo = $f['nombre'];
							$descripcion = $f['descripcion'];
							$bd = $f['basededatos'];
							$del = $f['delegacion'];
					} 
					
					if($bd=="V"){
				
						$t = primerConsultaVivienda($del,$id);
						$t2 = segundaConsultaVivienda($del,$id);
						$t3 = tercerConsultaVivienda($del,$id);
					}
					else
					{
						$t = primerConsultaPre($id);
						$t2 = segundaConsulta($id);
						$t3 = tercerConsulta($id);
						
					}
				}
				
						if ($_POST['user']<>$_GET['nitavu']){//si eso es diferente es otro el que vio con la contraseña
							historia($_GET['nitavu'], "Vio el Reporte con IDrep=".$_GET['id'].";".$titulo.", ".$descripcion." <b> Con la contraseña del empleado con ID ".$_POST['user']."</b>");
						} else {
							historia($_POST['user'], "Vio el Reporte con IDrep=".$_GET['id'].";".$titulo.", ".$descripcion);
						}
				

					require('pdf/tcpdf.php');
					
					// create new PDF document
					$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
					// set document information
					$pdf->SetCreator(PDF_CREATOR);
					$pdf->SetAuthor($autor);
					$pdf->SetTitle("d".strtoupper($titulo));
					$pdf->SetSubject("x".$titulo);
					$pdf->SetKeywords('Reporte ITAVU');
					// set default header data
					// $PDF_HEADER_TITLE="Titulo del PDF";
					// $PDF_HEADER_STRING="SEgunda linea";
					// $PDF_HEADER_LOGO="imagen"; //Solo me funciona si esta dentro de la carpeta images de la libreria
				
					// $this->pdf->SetHeaderData($PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);
				
				
					$pdf->SetHeaderData('pdf_logo.jpg', '30', strtoupper("".$titulo).'', $descripcion."\nImpreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($_POST['user'])."(".$_POST['user'].")");
				
					// set header and footer fonts
					// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
					$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 6));
					$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
					// set default monospaced font
					$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
					// set margins
					$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
					$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
					$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
					// set auto page breaks
					$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
					// set image scale factor
					$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
					// set some language-dependent strings (optional)
					if (@file_exists(dirname(__FILE__).'pdf/lang/eng.php')) {
						require_once(dirname(__FILE__).'pdf/lang/eng.php');
						$pdf->setLanguageArray($l);
					}
					// set font
					$pdf->SetFont('helvetica', '', 7);
					// add a page
					$pdf->AddPage($orientacion); //en la tabla de reporte L o P
					$html = $t;
					//echo $html; 
					//aqui escribe el contenido de la consulta
					$pdf->writeHTML($html, true, false, true, 0, '');
				
					//echo $orientacion;
					if($orientacion=="L"){
						//echo $orientacion;
						if(isset($t2) or isset($t3)){
						$pdf->AddPage($orientacion); //en la tabla de reporte L o P
						//$pdf->writeHTMLCell(100, '', 60,$y, $t3, 0, 0, 0, true, 'J', true);
						}
						$y = $pdf->getY();
						// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
						if(isset($t2)){
							$pdf->writeHTMLCell(100, '', 60, $y, $t2, 0, 0, 0, false, 'L', true);
						}
						if (isset($t3)){
							$pdf->writeHTMLCell(100, '', '', '', $t3, 0, 0, 0, true, 'L', true);
						}
						// reset pointer to the last page
						$pdf->lastPage();
						//Close and output PDF document
						$pdf->Output('reporte.pdf', 'I');
					}else if($orientacion == 'P'){
						//echo $orientacion;
						if(isset($t2) or isset($t3)){
						$pdf->AddPage($orientacion); //en la tabla de reporte L o P
						//$pdf->writeHTMLCell(100, '', 60,$y, $t3, 0, 0, 0, true, 'J', true);
						}
						$y = $pdf->getY();
						// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)
						if(isset($t2)){
							$pdf->writeHTMLCell(100, '', '', $y, $t2, 0, 0, 0, false, 'L', true);
						}
						if (isset($t3)){
							$pdf->writeHTMLCell(100, '', '', '', $t3, 0, 0, 0, true, 'L', true);
						}
						// reset pointer to the last page
						$pdf->lastPage();
						//Close and output PDF document}
						$pdf->Output('reporte.pdf', 'I');
					}
				
				}//fin de validacion de $ok


			}else {echo "";}


			
		} // fin validacion id
	
	}//FN validacion que no sea infor---

//}//fin validacion informatica (switch)


} else {echo "Error validacion GET";} // fin validacion de variables get




/*
function fecha_larga($fecha_){
	//return  dia_semana($fecha_)." ".date('d/m/Y', strtotime($fecha_));
	$mes = date('m', strtotime($fecha_));
	$mes = (int)$mes -1;
	$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	$mes_largo = $meses[$mes];
	$fecha_salida = dia_semana($fecha_)." ".date('d', strtotime($fecha_))." de ".$mes_largo." de ".date('Y', strtotime($fecha_));;
	
	return $fecha_salida;
	}

	function hora12($hora_){
		return date("g:ia",strtotime($hora_));
		}	

	
		function nitavu_nombre($id){
			require("config.php");
			$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
			$rc= $conexion -> query($sql);
			$msg="";
			if($f = $rc -> fetch_array())
			{
			if ($f['profesion_abr']==""){
			return $f['nombre'];}
			else
			{return $f['profesion_abr'].". ".$f['nombre'];}
			}
			else
			{ return FALSE;}
			}

			
function dia_semana($fecha_){
	$dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
	$n= date('N', strtotime($fecha_));
	$fecha = $dias[$n-1];
	return $fecha;
	//return $fecha_;
	//return date('N', strtotime($fecha_));
	}

	function nitavu_dpto2($id){
		require("config.php");
		$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
		$rc= $conexion -> query($sql);
		$msg="";
		if($f = $rc -> fetch_array())
				{return $f['dpto'];}
		else
				{ return FALSE;}
		}



function historia($nitavu_, $descripcion){
require("config.php");
	//funcion que otorga acceso a las aplicaciones
	$sql = "INSERT INTO historia
	(nitavu, fecha, hora, descripcion)
	VALUES
	('$nitavu_', '$fecha', '$hora','$descripcion')";
	if ($conexion->query($sql) == TRUE)
	{	//echo "ok";
		return 'TRUE';
	}
		else
	{	//echo $sql;
		return 'FALSE';
	}
}
						
*/
?>