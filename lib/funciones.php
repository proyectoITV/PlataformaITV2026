<?php


// -yyyy`  yyyyyyyyyyyyyyyyyy`     -yyyyo`    .yyyyo           oyyys. .yyyy.         oyyy+        
// -yyyy`  sssssssyyyysssssss`    .syyyyy+     -yyyy/         /yyyy-  .yyyy.         oyyy+        
// -yyyy`        .yyyy-          `syyysyyy/     :yyyy-       -yyyy:   .yyyy.         oyyy+        
// -yyyy`        .yyyy-         `oyyy+`syyy:     +yyys.     .syyy+    .yyyy.         oyyy+        
// -yyyy`        .yyyy-         +yyyo` -yyyy-     oyyys`   `oyyyo     .yyyy.         oyyy+        
// -yyyy`        .yyyy-        /yyys`   :yyyy.    `syyy+   +yyys`     .yyyy.         oyyy+        
// -yyyy`        .yyyy-       :yyyy+:::::syyys`    .syyy: :yyys.      `yyyy-         syyy+        
// -yyyy`        .yyyy-      -yyyyyyyyyyyyyyyyo`    -yyyy:yyyy-        oyyyo`       :yyyy-        
// -yyyy`        .yyyy-     .yyyy+:::::::::syyyo     :yyyyyyy:         .syyys+:--:/oyyyy/         
// -yyyy`        .yyyy-    `syyyo          .yyyy+     +yyyyy+           `/syyyyyyyyyyy+.          
// `::::         `::::`    .::::`           .::::`     :::::               .-//++//:-`            
//
// FUNCIONES DE OPERACION PRINCIPAL																						 



define("FTP_SERVER", "192.168.159.15"); //IP o Nombre del Servidor
// define("FTP_SERVER","localhost"); //IP o Nombre del Servidor
define("FTP_PORT", 21); //Puerto desde fuera 2323
define("FTP_USER", "eguzman"); //Nombre de Usuario
define("FTP_PASSWORD", "eguzman"); //Contraseña de acceso
// define("FTP_PASSWORD","*8l4ckp4nt3r*"); //Contraseña de acceso
define("FTP_DIR", "/home/desarrollo2/public_html/"); //ruta del  ftp


// define("FTP_SERVER","itvoc.dyndns.org"); //IP o Nombre del Servidor
// define("FTP_PORT",21); //Puerto desde fuera 2323
// define("FTP_USER","itv-ftp-001"); //Nombre de Usuario
// define("FTP_PASSWORD","**0pt1mu5**"); //Contraseña de acceso
// define("FTP_DIR","/"); //ruta del  ftp
?>


<?php
require("funciones_vivienda.php");
require("FormElement.php");
require_once("preference.php");
require("gentoken.php");
require("docsecure.php");
require("password_fun.php");
require("problemas_fun.php");

function ContratoVisita($NumContrato, $OriginData, $nitavu, $Comentarios='',$url=''){
	require("config.php");
	if ($url == ''){
		
		$host= $_SERVER["HTTP_HOST"];
		$url= $_SERVER["REQUEST_URI"];
		$url =  "http://" . $host . $url;
		
	}
	$sql = "INSERT INTO contratos_visitas(NumContrato, OriginData, NEmpleado, Fecha, Hora, url, Comentarios) 
			VALUES ('".$NumContrato."', '".$OriginData."', '".$nitavu."','".$fecha."','".$hora."','".$url."','".$Comentarios."')";
	if ($Vivienda->query($sql) == TRUE){                   		
		return TRUE;
	} else {
		return FALSE;
	}
}

function NumContrato_IdDelegacion($NumContrato, $OriginData){
	require("config.php");
	$sql = "SELECT * from contratos where NumContrato='".$NumContrato."' and OriginData = '".$OriginData."'";	
	// echo $sql;
	$r= $Vivienda -> query($sql);					
	$html = "";
	if($f = $r -> fetch_array())
	{
		return $f['IdDelegacion'];
	} else {
		return '';
	}
}

function NumContrato_Folio($NumContrato, $OriginData){
	require("config.php");
	$sql = "SELECT * from contratos where NumContrato='".$NumContrato."' and OriginData = '".$OriginData."'";	
	// echo $sql;
	$r= $Vivienda -> query($sql);					
	$html = "";
	if($f = $r -> fetch_array())
	{
		return $f['Folio'];
	} else {
		return '';
	}
}

function NumContrato_IdPrograma($NumContrato, $OriginData){
	require("config.php");
	$sql = "SELECT * from contratos where NumContrato='".$NumContrato."' and OriginData = '".$OriginData."'";	
	// echo $sql;
	$r= $Vivienda -> query($sql);					
	$html = "";
	if($f = $r -> fetch_array())
	{
		return $f['IdPrograma'];
	} else {
		return '';
	}
}


function NumContrato_Vobo($NumContrato, $OriginData){
	require("config.php");
	$sql = "SELECT * from contratos where NumContrato='".$NumContrato."' and OriginData = '".$OriginData."'";	
	// echo $sql;
	$r= $Vivienda -> query($sql);					
	$html = "";
	if($f = $r -> fetch_array())
	{
		if ($f['VoBo_public']==1){
			return $f['VoBo']." - ".nitavu_nombre($f['VoBo'])." el ".$f['VoBo_fecha'];
		} else {
			return '';
		}
	} else {
		return '';
	}
}


function Reporteador_Estadistica_html($id_rep){
	require("config.php");
	$sql = "SELECT * FROM Reporteador_Estadistica  WHERE id_rep='".$id_rep."'";	
	$msg = "";
	$r= $conexion -> query($sql);if($f = $r -> fetch_array()){	
		$msg = $msg."<b style='font-size:14pt;'>".$f['nombre']."</b><br>";
		$msg = $msg."<cite style='font-size: 10pt;'>".$f['descripcion']."</cite><br>";
		$msg = $msg."<cite style='
			font-size: 8pt;
			font-family: Light;
		'>".$f['UltimaVisita']."</cite><br>";
		$msg = $msg."<span style='
		background-color: rgba(162, 162, 162, 0.58);
    	margin: 20px;    	
    	padding-left: 10px;    	
    	padding-right: 10px;
		border-radius: 3px;
		font-size:8pt;

		'>Visitas: ".$f['Visitas']."</span>";
		$msg = $msg."<span style='
		background-color: rgba(162, 162, 162, 0.58);
    	margin: 20px;    	
    	padding-left: 10px;    	
    	padding-right: 10px;
		border-radius: 3px;
		font-size:8pt;
		
		'>Usuarios: ".$f['Usuarios']."</span><br><br>";
		
		
		

		


		return $msg;
	} else {
		return "";
	}
	
}
function InfoColonia_Saldo($IdMunicipio, $IdColonia){
	require("config.php");
	$sql = "SELECT * FROM Estadistica_Colonias  WHERE IdMunicipio='".$IdMunicipio."' AND IdColonia ='".$IdColonia."'";	
	// echo $sql;
	$r= $Vivienda -> query($sql);					
	$html = "";
	if($f = $r -> fetch_array())
	{
		return $f['Saldo'];
	} else {
		return '';
	}
}

function ProblemaName($IdProblema){
	require("config.php");
	$sql = "SELECT * from cat_problemasdevivienda where IdProblema='".$IdProblema."'";	
	// echo $sql;
	$r= $Vivienda -> query($sql);					
	$html = "";
	if($f = $r -> fetch_array())
	{
		return $f['Problema']."";
	} else {
		return '';
	}
}


function ProblemaDescripcion($IdProblema){
	require("config.php");
	$sql = "SELECT * from cat_problemasdevivienda where IdProblema='".$IdProblema."'";	
	// echo $sql;
	$r= $Vivienda -> query($sql);					
	$html = "";
	if($f = $r -> fetch_array())
	{
		return $f['Descripcion']."";
	} else {
		return '';
	}
}

function InfoColonia_Moratorio($IdMunicipio, $IdColonia){
	require("config.php");
	$sql = "SELECT * FROM Estadistica_Colonias  WHERE IdMunicipio='".$IdMunicipio."' AND IdColonia ='".$IdColonia."'";	
	// echo $sql;
	$r= $Vivienda -> query($sql);					
	$html = "";
	if($f = $r -> fetch_array())
	{
		return $f['Saldo_Moratorio'];
	} else {
		return '';
	}
}

function InfoColonia($IdMunicipio, $IdColonia){
	require("config.php");
	$sql = "SELECT * FROM Estadistica_Colonias  WHERE IdMunicipio='".$IdMunicipio."' AND IdColonia ='".$IdColonia."'";	
	// echo $sql;
	$r= $Vivienda -> query($sql);					
	$html = "";
	if($f = $r -> fetch_array())
	{	
		// $html = $html."		
		// <table border=1>";
		// $html = $html."<tr>";
		// $html = $html."<td><b>Contratos otorgados: </b>".$f['Contratos']."</td>";
		// $html = $html."</tr>";

		// $html = $html."<tr>";
		// $html = $html."<td><b>Contratos Liquidados: </b>".$f['ContratosLiquidados']."</td>";
		// $html = $html."</tr>";

		
		// $html = $html."<tr>";
		// $html = $html."<td><b>Beneficio Economico: </b>".Pesos($f['MontoCredito'])."</td>";
		// $html = $html."</tr>";

		
		// $html = $html."<tr>";
		// $html = $html."<td><b>Saldo: </b>".Pesos($f['Saldo'])."</td>";
		// $html = $html."</tr>";

		
		// $html = $html."<tr>";
		// $html = $html."<td><b>Saldo Moratorio: </b>".Pesos($f['Saldo_Moratorio'])."</td>";
		// $html = $html."</tr>";


		// $html = $html."</table>";



		$html = $html."<b>Contratos:</b> ".$f['Contratos']."<br>";
		$html = $html."<b>Liquidados: </b>".$f['ContratosLiquidados']."<br>";
		$html = $html."<b>Adeudo: </b>".($f['Contratos'] - $f['ContratosLiquidados'])."<hr><br>";

		
		$html = $html."<b>Esta colonia ha sido beneficiada con: </b>".Pesos($f['MontoCredito'])."<br>";
		$html = $html."<b>Saldo: </b>".Pesos($f['Saldo'])."<br>";
		$html = $html."<b>Moratorio: </b>".Pesos($f['Saldo_Moratorio'])."<br>";


		$html = $html."<p style='font-size:12pt;'>Programas otorgados: <b> ".$f['Programas']."</b></p>";
		$html = $html."<p style='font-size:8pt; color:gray;'>NOTA: Esta Informacion fue actualizada el ".$f['ActualizacionFecha']." a las ".$f['ActualizacionHora']."</p>
	
		";

		
		// $html = $html."
		// <div style='width:50%; display:inline-block;'>
		// GRAFICA
		// <div id='Grafica".$f['IdMunicipio']."_".$f['IdColonia']."'>
		// </div>
		
		// </div>
		// ";

		return $html;


		
	} else {
		return "";
	}
	
}


function Reporteador_estatus($id_rep, $token){
require("config.php");
$sql = "SELECT * FROM reporteador_repstatus  WHERE id_rep='".$id_rep."' AND token ='".$token."'";	
$r= $conexion -> query($sql);					
if($f = $r -> fetch_array())
{	
	return $f['estatus'];	
} else {
	return "";
}

}


function Reporteador_repestatus($id_rep, $token, $OK){
require("config.php");
if ($OK == FALSE){ // se agrega
	$sql = "INSERT INTO reporteador_repstatus(id_rep, token, estatus) 
	VALUES ('".$id_rep."', '".$token."', '0')";
	if ($conexion->query($sql) == TRUE){                   	
		return TRUE;
	} else {
		return FALSE;
	}
} else { // se actualiza
	$sql = "UPDATE reporteador_repstatus SET estatus ='1'
	WHERE token ='".$token."' AND id_rep='".$id_rep."'";
	if ($conexion->query($sql) == TRUE){                   	
		return TRUE;
	} else {
		return FALSE;
	}
}

}



function Tarea($IdTarea, $Nombre, $OK){
	require("config.php");
	if ($OK == FALSE){ // se agrega
		$sql = "INSERT INTO tareas(IdTarea, Nombre, Fecha) 
		VALUES ('".$IdTarea."', '".$Nombre."', '".$fecha."')";
		// echo $sql;
		if ($conexion->query($sql) == TRUE){                   	
			return TRUE;
		} else {
			return FALSE;
		}
	} else { // se actualiza
		$sql = "UPDATE tareas SET Estatus ='1'
		WHERE IdTarea ='".$IdTarea."' AND Fecha='".$fecha."'";
		if ($conexion->query($sql) == TRUE){                   	
			return TRUE;
		} else {
			return FALSE;
		}
	}
	
	}

	


function reporteador_Visitas($id_rep, $nitavu, $info){
	require("config.php");
	$sql = "INSERT INTO reporteador_Visitas(id_rep, fecha, hora, nitavu_visitante, info) 
			VALUES ('".$id_rep."', '".$fecha."', '".$hora."','".$nitavu."','".$info."')";
	if ($conexion->query($sql) == TRUE){                   
		historia($nitavu,"IdApp [ap50]: Consulto el reporte con id ".$id_rep.", ".$info);
		return TRUE;
	} else {
		return FALSE;
	}
}



function GenerarGrafica($nitavu, $id_rep, $token){

		require("config.php");
		// require("funciones.php");
	
		//LOS VALORES SE TOMARAN DEL RESULTADO DEL CAMPO sqlG
		$sqlOrigin = "SELECT * FROM Reporteador_Reportes WHERE id_rep='".$id_rep."'";
		$rc= $conexion -> query($sqlOrigin);
		if($f = $rc -> fetch_array()){
			$Gsql = $f['Gsql'];
			$title = $f['Gtitle'];
			$subtitle = $f['Gsubtitle'];
			$Gtype = $f['Gtype'];
			$BD = $f['basededatos'];
			$var1 = $f['var1'];
			$interactivo = $f['interactivo'];
			// echo $Gtype;
			$SQL_go = FALSE;
			if ($var1 == 1){
				if (isset($_GET['var1'])){ // si detectamos el valor de var1			
					$var1_str = $_GET['var1']; if (ValidaVAR($var1_str)==TRUE){$var1_str = LimpiarVAR($var1_str);} else {$var1_str = "";}
					$Gsql = str_replace("{var1}", $var1_str, $Gsql); //actualizamos la consulta
					$SQL_go = TRUE;
				}
		
			} else { // sino esta preparada para var1 sigue
				$SQL_go = TRUE;
			}
			
			// echo $Gsql;

			switch ($Gtype) {
				case 0:
					if ($Gsql<>'' AND $SQL_go == TRUE) {
						//GRAFICA PIE CHART
						require ("jpgraph/jpgraph.php");
						require ("jpgraph/jpgraph_pie.php");
						$data = array();  //Array para vaalues
						$dataLabels = array();  
						$labels = array();
						// echo $Gsql;
						switch ($BD) {
							case "P": $r = $conexion -> query($Gsql);break;
							case "V": $r = $Vivienda -> query($Gsql);break;		
							default: $r = $conexion -> query($Gsql);break;	
						}
						// $r= $conexion -> query($Gsql);
						while($fv = $r -> fetch_array()) {//asi deben estar las consultas
							array_push ($data, $fv['Valor']);
							array_push ($dataLabels, $fv['Label']);
							array_push ($labels, "(".$fv['Valor'].") %.1f%%");
						}
						
						// $labels = array("First\n(%.1f%%)",
						//     "Second\n(%.1f%%)","Third\n(%.1f%%)",
						//     "Fourth\n(%.1f%%)","Fifth\n(%.1f%%)",
						//     "Sixth\n(%.1f%%)","Seventh\n(%.1f%%)");
						// ob_end_clean();
						$graph = new PieGraph(2500,2500);
						$theme_class="DefaultTheme";
						$graph->title->Set($title);
						$graph->subtitle->Set($subtitle);
						$graph->SetBox(true);
						$p1 = new PiePlot($data);
						$p1->SetLabelType("PIE_VALUE_ABS");
						$graph->Add($p1);
						$p1->SetLegends($dataLabels);
						$p1->ShowBorder();
						$p1->SetColor('black');
						$p1->SetLabels($labels);
						$p1->SetGuideLines(true,false);
						$p1->SetGuideLinesAdjust(1.1);
						$p1->SetLabelPos(1);
						$p1->SetLabelType(PIE_VALUE_PER);
						$graph->legend->SetFont(FF_ARIAL,FS_NORMAL,14);
						$graph->legend->SetPos(0.5,0.97,'center','bottom');
						$graph->legend->SetMarkAbsSize (20);
						// $graph->legend-> SetColumns (2);
						$p1->value->SetFont(FF_ARIAL,FS_NORMAL,14);

						$graph->title->SetFont(FF_ARIAL,FS_NORMAL,24);
						$graph->subtitle->SetFont(FF_ARIAL,FS_NORMAL,18);

						$p1->SetSliceColors(array('#F08080','#E9967A','#DC143C','#FF69B4','#C71585','#FFA07A','#FF6347','#FF8C00','#BDB76B','#D8BFD8','#EE82EE','#BA55D3','#9966CC','#9400D3','#8B008B','#4B0082','#7CFC00','#32CD32','#90EE90','#00FF7F','#2E8B57','#008000','#9ACD32','#808000','#66CDAA','#20B2AA','#008080','#00FFFF','#AFEEEE','#40E0D0','#00CED1','#4682B4','#B0E0E6','#87CEEB','#00BFFF','#6495ED','#4169E1','#0000CD','#000080','#F5DEB3','#D2B48C','#F4A460','#B8860B','#D2691E','#A0522D','#800000','#808080','#778899','#2F4F4F'));
						$graph->Stroke("tmp/graficaspdf/".$nitavu."_".$id_rep."_".$token.".jpg");
					}
			

				break;
			case 1:
				if ($Gsql<>''  AND $SQL_go == TRUE) {
					require ('jpgraph/jpgraph.php');
					require ('jpgraph/jpgraph_line.php');
				

					
					$datay = array();  //Array para vaalues
					$dataLabels = array();  
					$labels = array();
					// echo $Gsql;
					switch ($BD) {
						case "P": $r = $conexion -> query($Gsql);break;
						case "V": $r = $Vivienda -> query($Gsql); break;		
						default: $r = $conexion -> query($Gsql);break;	
					}
					// $r= $conexion -> query($Gsql);
					// var_dump($r);
					while($fv = $r -> fetch_array()) {//asi deben estar las consultas
						array_push ($datay, $fv['Valor']);
						array_push ($dataLabels, $fv['Label']);
						array_push ($labels, "(".$fv['Valor'].") %.1f%%");

						//Lineas
						
					
						
					}

					
					
					
					// $datay = array(0,25,12,47,27,27,0);
					
					// Setup the graph
					$graph = new Graph(2500,2500);
					$graph->SetScale("intlin",0,$aYMax=50);
					
					$theme_class= new UniversalTheme;
					$graph->SetTheme($theme_class);
					
					$graph->SetMargin(40,40,50,40);
					
					$graph->title->Set($title);
					$graph->title->SetFont(FF_ARIAL,FS_NORMAL,24);
					$graph->title->SetMargin(50);
					$graph->SetBox(true);
					$graph->yaxis->HideLine(true);
					$graph->yaxis->HideTicks(true,true);					
					
					$graph->SetBackgroundGradient('#FFFFFF', '#00FF7F', GRAD_HOR, BGRAD_PLOT);					
					
					$graph->xaxis->SetTickLabels($dataLabels);
					$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,14);
					$graph->yaxis->SetFont(FF_ARIAL,FS_NORMAL,14);
					$graph->xaxis->SetLabelMargin(20);
					$graph->yaxis->SetLabelMargin(20);
					

					// $graph->SetAxisStyle(AXSTYLE_BOXOUT);
					// $graph->img->SetAngle(180); 
					
					// Create the line
					$p1 = new LinePlot($datay);
					$graph->Add($p1);
					
					$p1->SetFillGradient('#BBBBBB','#BBBBBB');
					$p1->SetColor('#BBBBBB');
					
					// Output line					
					$graph->Stroke("tmp/graficaspdf/".$nitavu."_".$id_rep."_".$token.".jpg");
				}

			}
			
	
			// sleep(1);
			return TRUE;
		} else {
			return FALSE;
	
		}
	
	
	
	
	
}

function Reporteador_Interactivo($id_rep){
require ("config.php");
	$sql = "SELECT interactivo FROM Reporteador_Reportes WHERE id_rep='".$id_rep."'";	
	// var_dump($conexion);
	// echo $sql;
	$r= $conexion -> query($sql);					
	if($f = $r -> fetch_array())
	{	
		if ($f['interactivo']=="0"){
			return FALSE;
		} else {
			return TRUE;
		}
	} else {
		return FALSE;
	}
}

function TareaIsset($IdTarea){
	require ("config.php");
		$sql = "SELECT count(*) as N FROM tareas WHERE IdTarea='".$IdTarea."' and Fecha='".$fecha."'";			
		// echo $sql;
		$r= $conexion -> query($sql);					
		if($f = $r -> fetch_array())
		{	
			if ($f['N']=="0"){
				return FALSE;
			} else {
				return TRUE;
			}
		} else {
			return FALSE;
		}
	}

function Reporteador_ReporteName($id_rep){
	require ("config.php");
		$sql = "SELECT nombre FROM Reporteador_Reportes WHERE id_rep='".$id_rep."'";	
		// var_dump($conexion);
		// echo $sql;
		$r= $conexion -> query($sql);					
		if($f = $r -> fetch_array())
		{	
			return $f['nombre'];
		} else {
			return "";
		}
}


function Colorines_IdtoHex($IdColor){
	require ("config.php");
		$sql = "SELECT * FROM Colorines WHERE IdColor='".$IdColor."'";	
		// var_dump($conexion);
		$r= $conexion -> query($sql);					
		if($f = $r -> fetch_array())
		{	
			return $f['hex'];
		} else {
			return "";
		}
	}

	
function ColorinesHex($Cuantos){
	require ("config.php");
    $sql = "
    select * from Colorines WHERE IdColor NOT IN(24,25,26,27,33,57,52,77,100,101,102,117,118,119,120,121,122,123,124,125,126,127,128,129,130,131,132,133,134)
    order by RAND() limit ".$Cuantos."
	";
	// var_dump($conexion);
    $r= $conexion -> query($sql);
    $IdColores = "";
    while($f = $r -> fetch_array()) {
        // echo "<b style='color:".$f['hex']."'>".$f['IdColor']." - ".$f['ColorName']."</b><br>";
        $IdColores = $IdColores.$f['IdColor'].",";
    }
	$IdColores = substr($IdColores, 0, -1); //quita la ultima coma.
	return $IdColores;
}



function RI_out_type($id_rep){
    /*------------------SEGUNDA CONSULTA---------------------*/
require("config.php");

$t=""; $TipoDeReporte="";
$sqlOrigin = "SELECT * FROM Reporteador_Reportes WHERE id_rep='".$id_rep."'";
$rc= $conexion -> query($sqlOrigin);
if($f = $rc -> fetch_array()){
	
	return $f['out_type'];

}else{
	return ""; //sino esta el reporte lo regresamos en blanco
}
}

function RI_SQL2($id_rep){
    /*------------------SEGUNDA CONSULTA---------------------*/
require("config.php");

$t=""; $TipoDeReporte="";
$sqlOrigin = "SELECT * FROM Reporteador_Reportes WHERE id_rep='".$id_rep."'";
$rc= $conexion -> query($sqlOrigin);
if($f = $rc -> fetch_array()){
	$sql = $f['sql2'];
	$TipoDeReporte = $f['interactivo'];
	$BD = $f['basededatos'];
	$Label = $f['label_sql2'];
	$var1 = $f['var1'];

}else{
	return ""; //sino esta el reporte lo regresamos en blanco
}

//Alimentamos la consulta con lo que le falte	
if ($TipoDeReporte == 1) { //INTERACTIVO
//1) solicitamos datos necesarios
$SQL_go = FALSE;
	
	if ($var1 == 1){
		if (isset($_GET['var1'])){ // si detectamos el valor de var1			
			$var1_str = $_GET['var1']; if (ValidaVAR($var1_str)==TRUE){$var1_str = LimpiarVAR($var1_str);} else {$var1_str = "";}
			$sql = str_replace("{var1}", $var1_str, $sql); //actualizamos la consulta
			$SQL_go = TRUE;
		}

	}

//2) Llenamos la consulta las variables {var1}


} else { //ESTATICO	
}

$t2="";    
// echo $sql;
if ($SQL_go == TRUE){
if(!empty($sql) == true){
        $cuantas_columnas2=0;
		$tabla_titulos2 = "<tr>";
		
		switch ($BD) {
			case "P": $rc2 = $conexion -> query($sql);break;
			case "V": $rc2 = $Vivienda -> query($sql);break;		
			default: $rc2 = $conexion -> query($sql);break;	
		}
        // $rc2= $conexion -> query($sql);
        if($rc2){
            while($finfo2 = $rc2->fetch_field()){//OBTENER LAS COLUMNAS
            /* obtener posición del puntero de campo */
                $currentfield = $rc2->current_field;
                $tabla_titulos2=$tabla_titulos2.'<td style=" text-align: left; background-color:#939699;"><b>'.$finfo2->name."</b></td>";
                $cuantas_columnas2 = $cuantas_columnas2 + 1;
            }
            $tabla_titulos2 = $tabla_titulos2."</tr>";
			$tabla_contenido2=""; $cuantas_filas2=0;
			switch ($BD) {
				case "P": $rc2 = $conexion -> query($sql);break;
				case "V": $rc2 = $Vivienda -> query($sql);break;		
				default: $rc2 = $conexion -> query($sql);break;	
			}
			// $rc2= $conexion -> query($sql);
			
			while($f2 = $rc2-> fetch_row())
            {//LISTAR COLUMNAS
            $tabla_contenido2 = $tabla_contenido2."<tr>";
            for ($i2 = 1; $i2 <= $cuantas_columnas2; $i2++) {
            if($cuantas_filas2%2==0){
                $tabla_contenido2= $tabla_contenido2.'<td style="right:0; text-align: left;  background-color:white">'.$f2[$i2-1]."</td>";
            }else{
                $tabla_contenido2= $tabla_contenido2.'<td style="right:0; text-align: left;  background-color:#FFEFBF;">'.$f2[$i2-1]."</td>";
            }
            }
            $tabla_contenido2 = $tabla_contenido2."</tr>";
            $cuantas_filas2 = $cuantas_filas2 + 1;
            }
            
        
            $t2 = $t2.'<b>ANEXO 1: </b><br><cite>'.$Label.'</cite><br><br><table style="width:100%">'.$tabla_titulos2.$tabla_contenido2."</table>";
        }else{
            $t2="<p>EXISTE UN ERROR DE SINTAXIS EN LA CONSULTA 2</p>";
        }
        return $t2;
} else {return "";}
}

}

function RI_SQL3($id_rep){
require("config.php");	
	$t=""; $TipoDeReporte="";
    $sqlOrigin = "SELECT * FROM Reporteador_Reportes WHERE id_rep='".$id_rep."'";
    $rc= $conexion -> query($sqlOrigin);
    if($f = $rc -> fetch_array()){
		$sql = $f['sql3'];
		$TipoDeReporte = $f['interactivo'];
		$BD = $f['basededatos'];
		$Label = $f['label_sql3'];
		$var1 = $f['var1'];

    }else{
		return ""; //sino esta el reporte lo regresamos en blanco
    }

//Alimentamos la consulta con lo que le falte	
if ($TipoDeReporte == 1) { //INTERACTIVO
	//1) solicitamos datos necesarios
	$SQL_go = FALSE;
	
	if ($var1 == 1){
		if (isset($_GET['var1'])){ // si detectamos el valor de var1			
			$var1_str = $_GET['var1']; if (ValidaVAR($var1_str)==TRUE){$var1_str = LimpiarVAR($var1_str);} else {$var1_str = "";}
			$sql = str_replace("{var1}", $var1_str, $sql); //actualizamos la consulta
			$SQL_go = TRUE;
		}

	}
	//2) Llenamos la consulta las variables {var1}


} else { //ESTATICO	
}


$t3="";
if ($SQL_go == TRUE){
// echo $sql;
if(!empty($sql) == true){
        $cuantas_columnas3=0;
		$tabla_titulos3 = "<tr>";
		switch ($BD) {
			case "P": $rc3 = $conexion -> query($sql);break;
			case "V": $rc3 = $Vivienda -> query($sql);break;		
			default: $rc3 = $conexion -> query($sql);break;	
		}
        // $rc3 = $conexion -> query($sql);
        if($rc3){
            while($finfo = $rc3->fetch_field()){//OBTENER LAS COLUMNAS
                /* obtener posición del puntero de campo */
                $currentfield3 = $rc3->current_field;
                $tabla_titulos3=$tabla_titulos3.'<td style="right:0; text-align: left; background-color:#939699"><b>'.$finfo->name."</b></td>";
                $cuantas_columnas3 = $cuantas_columnas3 + 1;	
            }
            $tabla_titulos3 = $tabla_titulos3."</tr>";
			$tabla_contenido3=""; $cuantas_filas3=0;
			switch ($BD) {
				case "P": $rc3 = $conexion -> query($sql);break;
				case "V": $rc3 = $Vivienda -> query($sql);break;		
				default: $rc3 = $conexion -> query($sql);break;	
			}
			// $rc3 = $conexion -> query($sql);
			while($f3 = $rc3-> fetch_row())
            {//LISTAR COLUMNAS
            $tabla_contenido3 = $tabla_contenido3."<tr>";
                    for ($i3=1; $i3 <= $cuantas_columnas3; $i3++) {
                        if($cuantas_filas3%2==0){
                            $tabla_contenido3= $tabla_contenido3.'<td style="right:0; text-align: left; background-color:white;">'.$f3[$i3-1]."</td>";
                        }else{
                            $tabla_contenido3= $tabla_contenido3.'<td style="right:0; text-align: left; background-color:#DFFFBF;">'.$f3[$i3-1]."</td>";
                        }		
                    }	
                $tabla_contenido3 = $tabla_contenido3."</tr>";
                $cuantas_filas3 = $cuantas_filas3 + 1;
            }
        
            $t3 = $t3.'<b>ANEXO 2: </b><br><cite>'.$Label.'</cite><br><br><table style="width:100%">'.$tabla_titulos3.$tabla_contenido3."</table>";
        }else{
            $t3="<p>EXISTE UN ERROR DE SINTAXIS EN LA CONSULTA 3</p>";
        }

        return $t3;
	} else {return "";}
}

}

function RI_Form($id_rep, $nitavu){
require("config.php");
	$t=""; $TipoDeReporte="";
    $sqlOrigin = "SELECT * FROM Reporteador_Reportes WHERE id_rep='".$id_rep."'";
    $rc= $conexion -> query($sqlOrigin);
    if($f = $rc -> fetch_array()){
		$sql = $f['sql1'];
		$TipoDeReporte = $f['interactivo'];
		$BD = $f['basededatos'];

		$var1 = $f['var1'];
		$var1_type = $f['var1_type'];
		$var1_label = $f['var1_label'];


		$var2 = $f['var2'];
		$var2_type = $f['var2_type'];
		$var2_label = $f['var2_label'];


		$var3 = $f['var3'];
		$var3_type = $f['var3_type'];
		$var3_label = $f['var3_label'];
		

    }else{
		return ""; //sino esta el reporte lo regresamos en blanco
    }

//Alimentamos la consulta con lo que le falte	
if ($TipoDeReporte == 1) { //INTERACTIVO
	//1) solicitamos datos necesarios
	// echo "Consulta a actualizar: ".$sql."<br>";	
	$SQL_go = FALSE;
	//formar el fomulario
	echo "<section style='
		width: 97%;
		background-color: rgba(255, 255, 255, 0.83);
		border-radius: 5px;
		padding: 9px;
		'>
		<label style='
		font-size: 12pt;
		font-family: Verdana;
		'>Capture la información solicitada:</label>
		";

		echo "<form action='ri_view.php?id_rep=".$_GET['id_rep']."&token=".$_GET['token']."' method='POST'>";
		// echo "<form>";
		echo "<input type='hidden' name='id_rep' value='".$_GET['id_rep']."'>";
		echo "<input type='hidden' name='token' value='".$_GET['token']."'>";
		echo "<input type='hidden' name='nitavu' value='".$nitavu."'>";
		echo "<input type='hidden' name='info' value='".InfoEquipo()."'>";




	if ($var1 == 1){
		//elemento var1
		echo "<article style='
			display:inline-block;
			width:40%;
			padding:15px;
			margin:10px;
			background-color:#ffffff5c;
			border-radius:5px;
			background-color: #43a5cc;
			border-radius: 5px;

		'>";
		echo "<label style='font-size:10pt; color:white; font-family: Verdana;'>".$var1_label."</label><br>";
		echo "<input type='".$var1_type."' name='var1' id='var1' style='
		height: 41px;
		width: 100%;
		font-size: 14pt;
		border: 0px;
		border-radius: 4px;
		background-color: #ffffff2b;
		color: white;
		'  value=''  required>";
		echo "</article>";
	}


	//VARIABLE 2
	if ($var2 == 1){
		//elemento var1
		echo "<article style='
			display:inline-block;
			width:40%;
			padding:15px;
			margin:10px;
			background-color:#ffffff5c;
			border-radius:5px;
			background-color: #43a5cc;
			border-radius: 5px;

		'>";
		echo "<label style='font-size:10pt; color:white; font-family: Verdana;'>".$var2_label."</label><br>";
		echo "<input type='".$var2_type."' name='var2' id='var2' style='
		height: 41px;
		width: 100%;
		font-size: 14pt;
		border: 0px;
		border-radius: 4px;
		background-color: #ffffff2b;
		color: white;
		' value='' required>";
		echo "</article>";
	}


	//VARIABLE 3
	if ($var3 == 1){
		//elemento var1
		echo "<article style='
			display:inline-block;
			width:40%;
			padding:15px;
			margin:10px;
			background-color:#ffffff5c;
			border-radius:5px;
			background-color: #43a5cc;
			border-radius: 5px;

		'>";
		echo "<label style='font-size:10pt; color:white; font-family: Verdana;'>".$var3_label."</label><br>";
		echo "<input type='".$var3_type."' name='var3' id='var3' style='
		height: 41px;
		width: 100%;
		font-size: 14pt;
		border: 0px;
		border-radius: 4px;
		background-color: #ffffff2b;
		color: white;
		' value=''  required>";
		echo "</article>";
	}

		echo "<br><hr style='border: 1px dashed gray; opacity: 0.2;'><br><center><input onclick='ChecarEstadoReporte();' type='submit' style='
		width: 300px;
		background-color: #51ae43;
		padding: 10px;
		margin: 20px;
		border-radius: 5px;
		text-decoration: none;
		font-family: Verdana;
		color: white;
		box-shadow: 0 3px #3D8432;
		border: 0px;
		font-size: 13pt; cursor:pointer;
		'
		value='Preparar Reporte'></center> <br><br>
		
		";
		echo "</form>";
		
		echo "</section>";

}
}


function RI_SQL1_interactive($id_rep, $Value_var1, $Value_var2, $Value_var3){
require("config.php");    
$t=""; $TipoDeReporte="";
    $sqlOrigin = "SELECT * FROM Reporteador_Reportes WHERE id_rep='".$id_rep."'";
    $rc= $conexion -> query($sqlOrigin);
    if($f = $rc -> fetch_array()){
		$sql = $f['sql1']; //query 1
		$TipoDeReporte = $f['interactivo'];
		$BD = $f['basededatos'];

		$var1 = $f['var1'];
		$var1_type = $f['var1_type'];
		$var1_label = $f['var1_label'];


		$var2 = $f['var2'];
		$var2_type = $f['var2_type'];
		$var2_label = $f['var2_label'];


		$var3 = $f['var3'];
		$var3_type = $f['var3_type'];
		$var3_label = $f['var3_label'];
		

}
// Reporteador_repestatus($id_rep, $_GET['token'], FALSE);

if ($Value_var1 <> ''){ // si detectamos el valor de var1			
	$var1_str = $Value_var1; if (ValidaVAR($var1_str)==TRUE){$var1_str = LimpiarVAR($var1_str);} else {$var1_str = "";}
	$sql = str_replace("{var1}", $var1_str, $sql); //actualizamos la consulta
	$SQL_go = TRUE;
}

if ($Value_var2 <> ''){ // si detectamos el valor de var1			
	$var2_str = $Value_var2; if (ValidaVAR($var2_str)==TRUE){$var2_str = LimpiarVAR($var2_str);} else {$var2_str = "";}
	$sql = str_replace("{var2}", $var2_str, $sql); //actualizamos la consulta
	$SQL_go = TRUE;
}


if ($Value_var3 <> ''){ // si detectamos el valor de var1			
	$var3_str = $Value_var3; if (ValidaVAR($var3_str)==TRUE){$var3_str = LimpiarVAR($var3_str);} else {$var3_str = "";}
	$sql = str_replace("{var3}", $var3_str, $sql); //actualizamos la consulta
	$SQL_go = TRUE;
}


// En este punto $sql ya viene con la informacion lista y comenzamos a contruir la $t que se imprimira
if ($SQL_go == TRUE){
			//CONSTRUIMOS t1
			$style_td_titulo='background-color:#939699; ';
			$style_td='border: 1px solid gray;';
			$HoraInicio = $hora;
			if(!empty($sql) == true){
				$cuantas_columnas=0;
				$tabla_titulos = "<tr>";
				switch ($BD) {
					case "P": $r2 = $conexion -> query($sql);break;
					case "V": $r2 = $Vivienda -> query($sql);break;		
					default: $r2 = $conexion -> query($sql);break;	
				}
				
				
				
				if($r2){
					$registros = 0;
					while($finfo = $r2->fetch_field()){//OBTENER LAS COLUMNAS
						/* obtener posición del puntero de campo */
						$currentfield = $r2->current_field;
						$tabla_titulos=$tabla_titulos.'<td align=left style="'.$style_td_titulo.'"><b>'.$finfo->name."</b></td>";
						$cuantas_columnas = $cuantas_columnas + 1;
						
					}
					$tabla_titulos = $tabla_titulos."</tr>";
					$tabla_contenido=""; $cuantas_filas=0;
					switch ($BD) {
						case "P": $r = $conexion -> query($sql);break;
						case "V": $r = $Vivienda -> query($sql);break;		
						default: $r = $conexion -> query($sql);break;	
					}
					
					
					while($f = $r-> fetch_row()){//LISTAR COLUMNAS
						$tabla_contenido = $tabla_contenido."<tr>";
							for ($i = 1; $i <= $cuantas_columnas; $i++) {
								if($cuantas_filas%2==0){
									$tabla_contenido= $tabla_contenido.'<td align=left style="right:0;  background-color:white">'.$f[$i-1]."</td>";
								}else{
									$tabla_contenido= $tabla_contenido.'<td align=left style="right:0; background-color:#CACACA;">'.$f[$i-1]."</td>";
								}
							}
						$tabla_contenido = $tabla_contenido."</tr>";
						$cuantas_filas = $cuantas_filas + 1;
						
					}
					$t="";                
					$style_table='
						width:100%;
						text-align: left;
						border: 1px solid gray;
					';
					$HoraFinal = $hora;
					if ($var1 == 1){
						$t = $t.'<br>PARAMETROS USADOS: '.$var1_label.": ".$var1_str;
					}
					if ($var2 == 1){
						$t = $t.', '.$var2_label.":".$var2_str;
					}
					if ($var3 == 1){
						$t = $t.', '.$var3_label.":".$var3_str;
					}

					$t = $t.''.'<br><table style="'.$style_table.'">'.$tabla_titulos.$tabla_contenido."</table>";
					$t = $t.'<br><b>Total de Registros consultados: </b>'.$cuantas_filas.', ';
					if ($BD == 'P'){
						$t = $t.' de la Base de Datos de la Plataforma.';
					} else {
						$t = $t.' de la Base de Datos de Vivienda';

					}
					
				}else{
					$t="ERROR";
				}

				return $t;
			}  else {return "";}
		}



Reporteador_repestatus($id_rep, $_GET['token'], TRUE);

}



function RI_SQL1($id_rep){
	require("config.php");    
	$t=""; $TipoDeReporte="";
		$sqlOrigin = "SELECT * FROM Reporteador_Reportes WHERE id_rep='".$id_rep."'";
		$rc= $conexion -> query($sqlOrigin);
		if($f = $rc -> fetch_array()){
			$sql = $f['sql1'];
			$TipoDeReporte = $f['interactivo'];
			$BD = $f['basededatos'];
	
			$var1 = $f['var1'];
			$var1_type = $f['var1_type'];
			$var1_label = $f['var1_label'];
	
	
			$var2 = $f['var2'];
			$var2_type = $f['var2_type'];
			$var2_label = $f['var2_label'];
	
	
			$var3 = $f['var3'];
			$var3_type = $f['var3_type'];
			$var3_label = $f['var3_label'];
			
	
	}

				//CONSTRUIMOS t1
				$style_td_titulo='background-color:#939699; ';
				$style_td='border: 1px solid gray;';
				$HoraInicio = $hora;
				if(!empty($sql) == true){
					$cuantas_columnas=0;
					$tabla_titulos = "<tr>";
					switch ($BD) {
						case "P": $r2 = $conexion -> query($sql);break;
						case "V": $r2 = $Vivienda -> query($sql);break;		
						default: $r2 = $conexion -> query($sql);break;	
					}
					
					
					
					if($r2){
						$registros = 0;
						while($finfo = $r2->fetch_field()){//OBTENER LAS COLUMNAS
							/* obtener posición del puntero de campo */
							$currentfield = $r2->current_field;
							$tabla_titulos=$tabla_titulos.'<td align=left style="'.$style_td_titulo.'"><b>'.$finfo->name."</b></td>";
							$cuantas_columnas = $cuantas_columnas + 1;
							
						}
						$tabla_titulos = $tabla_titulos."</tr>";
						$tabla_contenido=""; $cuantas_filas=0;
						switch ($BD) {
							case "P": $r = $conexion -> query($sql);break;
							case "V": $r = $Vivienda -> query($sql);break;		
							default: $r = $conexion -> query($sql);break;	
						}
						
						
						while($f = $r-> fetch_row()){//LISTAR COLUMNAS
							$tabla_contenido = $tabla_contenido."<tr>";
								for ($i = 1; $i <= $cuantas_columnas; $i++) {
									if($cuantas_filas%2==0){
										$tabla_contenido= $tabla_contenido.'<td align=left style="right:0;  background-color:white">'.$f[$i-1]."</td>";
									}else{
										$tabla_contenido= $tabla_contenido.'<td align=left style="right:0; background-color:#CACACA;">'.$f[$i-1]."</td>";
									}
								}
							$tabla_contenido = $tabla_contenido."</tr>";
							$cuantas_filas = $cuantas_filas + 1;
							
						}
						$t="";                
						$style_table='
							width:100%;
							text-align: left;
							border: 1px solid gray;
						';
						$HoraFinal = $hora;
						if ($var1 == 1){
							$t = $t.'<br>PARAMETROS USADOS: '.$var1_label.": ".$var1_str;
						}
						if ($var2 == 1){
							$t = $t.', '.$var2_label.":".$var2_str;
						}
						if ($var3 == 1){
							$t = $t.', '.$var3_label.":".$var3_str;
						}
	
						$t = $t.''.'<br><table style="'.$style_table.'">'.$tabla_titulos.$tabla_contenido."</table>";
						$t = $t.'<br><b>Total de Registros consultados: </b>'.$cuantas_filas.', ';
						if ($BD == 'P'){
							$t = $t.' de la Base de Datos de la Plataforma.';
						} else {
							$t = $t.' de la Base de Datos de Vivienda';
	
						}
						
					}else{
						$t="ERROR";
					}
	
					return $t;
				}  else {return "";}
			
	
	
	
	Reporteador_repestatus($id_rep, $_GET['token'], TRUE); //Actualiza el estado
	
}
	
	
function ImprimirReporte($id_rep, $nitavu,$t1, $t2, $t3, $info_leyenda,$token){	
require("config.php");



//GENERAR PDF
require('pdf/tcpdf.php');
$sql = "SELECT * FROM Reporteador_Reportes WHERE id_rep='".$id_rep."' ";
$rc= $conexion -> query($sql);if($f = $rc -> fetch_array()){ 
            $orientacion = $f['orientacion'];
            $autor = $f['nitavu'];
            $titulo = $f['nombre'];
            $descripcion = $f['descripcion'];
            $bd = $f['basededatos'];
			$del = $f['delegacion'];
			$PageSize = $f['PageSize'];
} 
// $info_leyenda = "aqui va el footer";

		

ob_end_clean();  

class PDFReporteUniversal extends TCPDF {
	public $str;
	public $titulo;
	public $descripcion;
	public $id_rep;
	public $info_leyenda;
	public $orientacion;
	public $PageSize;

	public function Header() {
		if ($this->PageSize == "LETTER"){ //Configuracion CARTA
			if ($this->orientacion == 'L') { //horizontal CARTA						
				$image_file = K_PATH_IMAGES.'pdf_logo.png';
				$icono = K_PATH_IMAGES.'user.png';		
				$this->Image($image_file, 15, 7, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
				$this->SetFont('helvetica', 'B', 7);
				$LogitudTitulo=150;
				$this->Text(57, 7, ''.substr($this->titulo,0,$LogitudTitulo).""); 
				$this->Text(57, 9.5, ''.substr($this->titulo,$LogitudTitulo + 1 , $LogitudTitulo ).""); 			
				$this->SetFont('helvetica', 'I', 6);
				$LogitudTitulo=200;
				$this->Text(57, 12, ''.substr($this->descripcion,0,$LogitudTitulo).""); 
				$this->Text(57, 13.5, ''.substr($this->descripcion,$LogitudTitulo + 1 , $LogitudTitulo).""); 
				$this->Text(57, 15.5, ''.substr($this->descripcion,($LogitudTitulo * 2) + 1 , $LogitudTitulo).""); 

			} else { //VERTICAL CARTA
				$image_file = K_PATH_IMAGES.'pdf_logo.png';
				$icono = K_PATH_IMAGES.'user.png';		
				$this->Image($image_file, 15, 7, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
				$this->SetFont('helvetica', 'B', 7);
				$LogitudTitulo=100;
				$this->Text(57, 7, ''.substr($this->titulo,0,$LogitudTitulo).""); 
				$this->Text(57, 9.5, ''.substr($this->titulo,$LogitudTitulo + 1 , $LogitudTitulo ).""); 			
				$this->SetFont('helvetica', 'I', 6);
				$LogitudTitulo=140;
				$this->Text(57, 12, ''.substr($this->descripcion,0,$LogitudTitulo).""); 
				$this->Text(57, 13.5, ''.substr($this->descripcion,$LogitudTitulo + 1 , $LogitudTitulo).""); 
				$this->Text(57, 15.5, ''.substr($this->descripcion,($LogitudTitulo * 2) + 1 , $LogitudTitulo).""); 
				
			}
		} else {//OFICIO
			if ($this->orientacion == 'L') { //horizontal OFICIO.
				$image_file = K_PATH_IMAGES.'pdf_logo.png';
				$icono = K_PATH_IMAGES.'user.png';		
				$this->Image($image_file, 15, 7, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
				$this->SetFont('helvetica', 'B', 7);
				$LogitudTitulo=220;
				$this->Text(57, 7, ''.substr($this->titulo,0,$LogitudTitulo).""); 
				$this->Text(57, 9.5, ''.substr($this->titulo,$LogitudTitulo + 1 , $LogitudTitulo ).""); 			
				$this->SetFont('helvetica', 'I', 6);
				$LogitudTitulo=280;
				$this->Text(57, 12, ''.substr($this->descripcion,0,$LogitudTitulo).""); 
				$this->Text(57, 13.5, ''.substr($this->descripcion,$LogitudTitulo + 1 , $LogitudTitulo).""); 
				$this->Text(57, 15.5, ''.substr($this->descripcion,($LogitudTitulo * 2) + 1 , $LogitudTitulo).""); 

			} else { //VERTICAL OFICIO
				$image_file = K_PATH_IMAGES.'pdf_logo.png';
				$icono = K_PATH_IMAGES.'user.png';		
				$this->Image($image_file, 15, 7, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
				$this->SetFont('helvetica', 'B', 7);
				$LogitudTitulo=100;
				$this->Text(57, 7, ''.substr($this->titulo,0,$LogitudTitulo).""); 
				$this->Text(57, 9.5, ''.substr($this->titulo,$LogitudTitulo + 1 , $LogitudTitulo ).""); 			
				$this->SetFont('helvetica', 'I', 6);
				$LogitudTitulo=140;
				$this->Text(57, 12, ''.substr($this->descripcion,0,$LogitudTitulo).""); 
				$this->Text(57, 13.5, ''.substr($this->descripcion,$LogitudTitulo + 1 , $LogitudTitulo).""); 
				$this->Text(57, 15.5, ''.substr($this->descripcion,($LogitudTitulo * 2) + 1 , $LogitudTitulo).""); 

			}
		}


	}

	public function Footer() {
		if ($this->PageSize == "LETTER"){ //Configuracion CARTA
			if ($this->orientacion == 'L') { //horizontal CARTA						
				$this->SetY(-15);		
				$this->SetFont('helvetica', 'I', 6);	 
				$this->SetTextColor(0,0,0);
				$linea= "_____________________________________________________________________________________________________________________________________________________________________________________________________________________";
				$paginas = "Pag. ".$this->getAliasNumPage().'/'.$this->getAliasNbPages();	
				$this->Text(14.5,199, $linea); 	 
				$LogitudTitulo=205;
				$this->SetFont('helvetica', 'B', 9); $this->Text(15,201.5, $paginas); 	 
				$this->SetFont('helvetica', 'I', 6); $this->Text(40,201.5, "[".$this->id_rep."] ".substr($this->info_leyenda,0,$LogitudTitulo).""); 	 
				$this->SetFont('helvetica', 'I', 6); $this->Text(40,203.5, "".substr($this->info_leyenda,$LogitudTitulo + 1,$LogitudTitulo ).""); 	 
		

			} else { //VERTICAL CARTA
				$this->SetY(-15);		
				$this->SetFont('helvetica', 'I', 6);	 
				$this->SetTextColor(0,0,0);
				$linea= "_______________________________________________________________________________________________________________________________________________________________";
				$paginas = "Pag. ".$this->getAliasNumPage().'/'.$this->getAliasNbPages();	
				$this->Text(14.5,262.5, $linea); 	 
				$LogitudTitulo=150;
				$this->SetFont('helvetica', 'B', 9); $this->Text(15,265, $paginas); 	 
				$this->SetFont('helvetica', 'I', 6); $this->Text(40,265, "[".$this->id_rep."] ".substr($this->info_leyenda,0,$LogitudTitulo).""); 	 
				$this->SetFont('helvetica', 'I', 6); $this->Text(40,267, "".substr($this->info_leyenda,$LogitudTitulo + 1,$LogitudTitulo ).""); 	 
				
			}
		} else {//OFICIO
			if ($this->orientacion == 'L') { //horizontal OFICIO
				$this->SetY(-15);		
				$this->SetFont('helvetica', 'I', 6);	 
				$this->SetTextColor(0,0,0);
				$linea= "______________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________________";
				$paginas = "Pag. ".$this->getAliasNumPage().'/'.$this->getAliasNbPages();	
				$this->Text(14.5,199, $linea); 	 
				$LogitudTitulo=205;
				$this->SetFont('helvetica', 'B', 9); $this->Text(15,201.5, $paginas); 	 
				$this->SetFont('helvetica', 'I', 6); $this->Text(40,201.5, "[".$this->id_rep."] ".substr($this->info_leyenda,0,$LogitudTitulo).""); 	 
				$this->SetFont('helvetica', 'I', 6); $this->Text(40,203.5, "".substr($this->info_leyenda,$LogitudTitulo + 1,$LogitudTitulo ).""); 	 
	

			} else { //VERTICAL OFICIO
				// $this->SetY(-15);		
				$this->SetFont('helvetica', 'I', 6);	 
				$this->SetTextColor(0,0,0);
				$linea= "_______________________________________________________________________________________________________________________________________________________________";
				$paginas = "Pag. ".$this->getAliasNumPage().'/'.$this->getAliasNbPages();	
				$this->Text(14.5,325, $linea); 	 
				$LogitudTitulo=150;
				$this->SetFont('helvetica', 'B', 9); $this->Text(15,327, $paginas); 	 
				$this->SetFont('helvetica', 'I', 6); $this->Text(40,327.5, "[".$this->id_rep."] ".substr($this->info_leyenda,0,$LogitudTitulo).""); 	 
				$this->SetFont('helvetica', 'I', 6); $this->Text(40,329.8, "".substr($this->info_leyenda,$LogitudTitulo + 1,$LogitudTitulo ).""); 	 
	
			}
		}


	}
}
$pdf = new PDFReporteUniversal(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf->SetCreator(PDF_CREATOR);
// $pdf->SetAuthor($autor);
// $pdf->SetTitle("d".strtoupper($titulo));
// $pdf->SetSubject("x".$titulo);
// $pdf->SetKeywords('Reporte ITAVU');
// $pdf->SetHeaderData('pdf_logo.jpg', '30', strtoupper("".$titulo).'', $descripcion."\nImpreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($nitavu)."(".$nitavu.")");

//   $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 6));
//   $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
//   $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);    
  $pdf->SetMargins(PDF_MARGIN_LEFT, 20, PDF_MARGIN_RIGHT);
//   $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// $pdf->SetHeaderMargin(20);
// $pdf->SetFooterMargin(50);
	
//   $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);  
  $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);  
  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);  
  if (@file_exists(dirname(__FILE__).'pdf/lang/eng.php')) {require(dirname(__FILE__).'pdf/lang/eng.php'); $pdf->setLanguageArray($l); }
  
  $pdf->titulo = $titulo;
  $pdf->descripcion = $descripcion;
  $pdf->orientacion = $orientacion;
  $pdf->PageSize = $PageSize;
  $pdf->info_leyenda = $info_leyenda;
  $pdf->id_rep = $id_rep;

  $pdf->SetFont('helvetica', '', 7);  
  
//   $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	if ($PageSize == "LEGAL")  {
		if ($orientacion == "P"){
			$pdf->SetAutoPageBreak(TRUE, 30);
		} else {
			$pdf->SetAutoPageBreak(TRUE, 15);
		}
		
	} else {

	}

  
  $pdf->AddPage($orientacion,$PageSize);     

  $pdf->writeHTML($t1, true, false, true, 0, '');

  //Est apartado se acomoda sin importar si es vertical o horizontal, asi como el tamaño de la hoja
  if($t2<>'' or $t3<>'') {	//Agregamos una nueva hoja para los anexos
	$pdf->AddPage($orientacion, $PageSize);
	$pdf->writeHTML($t2, true, false, true, 0, ''); //Anexo1
	$pdf->writeHTML($t3, true, false, true, 0, ''); //Anexo2

  }


  //Para la Grafica si es dependiendo de la orientacion de la hoja
  if($orientacion=="L"){	  
	  //GRAFICA horizontal
	
	// $GraficaIMG = "<br>Imagen: <br><img src='tmp/graficaspdf/".$nitavu."_".$id_rep."_".$token.".jpg'>";
	
	$GraficaIMG = "tmp/graficaspdf/".$nitavu."_".$id_rep."_".$token.".jpg";
	
	if (file_exists($GraficaIMG)) {
		$pdf->AddPage($orientacion,$PageSize);
		// $pdf->SetXY(110, 200);
		$pdf->Image($GraficaIMG, '15', '30', 230, 230, '', '', 'T', true, 800, '', false, false, 0, false, false, false);
		
	}
		

  }else if($orientacion == 'P'){  	  
	//GRAFICA vertical
	$pdf->AddPage($orientacion,$PageSize);
	// $GraficaIMG = "<br>Imagen: <br><img src='tmp/graficaspdf/".$nitavu."_".$id_rep."_".$token.".jpg'>";
	
	$GraficaIMG = "tmp/graficaspdf/".$nitavu."_".$id_rep."_".$token.".jpg";
	if (file_exists($GraficaIMG)) {
		$pdf->AddPage($orientacion,$PageSize);
		// $pdf->SetXY(110, 200);
		$pdf->Image($GraficaIMG, '15', '30', 200, 200, '', '', 'T', true, 800, '', false, false, 0, false, false, false);
	}	
	
  }

  //Finalizamos el reporte
  $pdf->lastPage();	  
//   $pdf->Output('reporte_'.$id_rep.'.pdf', 'I');
  $directorio = __DIR__;
  $directorio = str_replace("lib", "tmp", $directorio);
  $archivo = $directorio."\\reportes\\R_".$nitavu."_".$id_rep."_".$token.".pdf";  
  $archivoWeb = "tmp\\reportes\\R_".$nitavu."_".$id_rep."_".$token.".pdf";  
//   echo "Archivo:".$archivo;  
  $pdf->Output($archivo, 'F'); 
  	echo "<iframe src='".$archivoWeb."' 
            style='width:100%; height:98%; border: 0px solid black; margin-top: 7px;' border=0></iframe>";
	echo "<script>
            $('#grancontenido').css({'background-color':'#4d4d4d'});
            $('body').css({'background-color':'#4d4d4d'});
            </script>";
  exit();


}

function LocationFull($page){
	echo ' <script type="text/javascript">top.location.href="'.$page.'"</script>';
}
function LoginReset(){
	$_SERVER['PHP_AUTH_PW'] = ""; 
	$_SERVER['PHP_AUTH_USER'] = ""; 
	unset($_SERVER['PHP_AUTH_PW']);
	unset($_SERVER['PHP_AUTH_USER']);

	// $_SESSION = array();
    // unset($_COOKIE[session_name()]);
	// session_destroy();
	
	Toast("Reset Login",1,"");

}


function Reporte_TengoPermiso($nitavu, $id_rep){
	require("config.php");
	$sql = "SELECT * FROM reporteador_permisos WHERE id_rep='".$id_rep."' and IdEmpleado='".$nitavu."' and Estatus=1";
	// echo $sql;
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		return TRUE;
	}
	else { return FALSE;}
}
	


function Nid_rep($consulta){
	require("config.php");
	$sql = "SELECT * FROM contadores WHERE id='0'";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		if ($consulta==TRUE) {
				return $f['id_rep'];
		}
		else
		{ // sino es consulta entonces aumentarle y aumentar el contador de ceropapel
			// la diferencia entre ceropapel y este, es que cero papel se multiplica
			// por las copias que se entregan o con copia, para estadistica de cuanto se ha ahorrado
			$n2 = $f['id_rep'] + 1;
			//$n2 = $f['npase_idenficador'].$n2;
			$sql="UPDATE contadores SET id_rep='".$n2."' WHERE id='0'";
			$resultado = $conexion -> query($sql);
			if ($conexion->query($sql) == TRUE) {
				return $n2 ;
			}else {return  FALSE;}
		}
	}
	else
	{ return FALSE;}
}
	

	

function r2_nuevo($ReporteNombre, $ReporteDescripcion, $ReporteFile, $nitavu, $solicitante){
    require("config.php"); /*No mover*/
	$id_rep = Nid_rep(FALSE);
    $query = "INSERT INTO Reporteador_Reportes(
		id_rep, nombre, descripcion, nitavu, fecha, hora, estado, solicitante
	) 
    VALUES ('".$id_rep."','".$ReporteNombre."','".$ReporteDescripcion."', '".$nitavu."','".$fecha."','".$hora."','0','".$solicitante."')";
    if ($conexion->query($query) == TRUE) {
		//Guardamos el archivo
		$nombredelcontrol = "ReporteFile"; $subio=FALSE;
		if ( isset( $_FILES ) && isset( $_FILES[$nombredelcontrol] ) && !empty( $_FILES[$nombredelcontrol]['name'] && !empty($_FILES[$nombredelcontrol]['tmp_name']) ) ) {
			if ($_FILES[$nombredelcontrol]['type']=="application/pdf"){
				// mensaje("ok","");
				$ArchivoServidor = "reportes/".$id_rep."_solicitud.pdf";
				if(move_uploaded_file($_FILES[$nombredelcontrol]['tmp_name'], $ArchivoServidor))
				{$subio = TRUE;} else{$subio = FALSE;}
				
			} else {
				// mensaje("ERROR: El archivo que ha cargado no tiene un formato compatible (PDF). Su archivo es ".$_FILES[$nombredelcontrol]['type'],"");
			}
		} else {
			// mensaje("no se recibio","");
		}

        return TRUE; 
    }else{
        return FALSE;
    }
}


function EstadoDeCuenta_recalcularsaldo($NumContrato, $OriginData, $nitavu){
require("config.php");

	$sql="
	select CheckContratos.*, (SaldoCalculo  -  Saldo) as Diferencia from CheckContratos 
	where Saldo <> SaldoCalculo and NumContrato='".$NumContrato."' and OriginData='".$OriginData."'	 order by numpago
	";
	$r= $Vivienda -> query($sql);
	// echo $sql;
	$e=0;
	$TotDiferencia=0; $Dif="";
    while($f = $r -> fetch_array()) {
		$TotDiferencia = $TotDiferencia + $f['Diferencia'];
		$Dif = (String)$TotDiferencia;
		// var_dump($f);
		if (EstadoDeCuenta_ActualizarSaldoExcento($NumContrato, $OriginData, $f['numpago'], $Dif, $nitavu ) ==TRUE){

		} else {
			$e=$e+1;	
		}

	}
	if ($e>0){//si hay un error al guardar
		return FALSE;
	} else {
		return TRUE;
	}

}

function EstadoDeCuenta_ActualizarSaldoExcento($NumContrato, $OriginData,$NumMov, $saldoexento, $nitavu){
	require("config.php");
	$NumContrato = (String)$NumContrato;
	$OriginData = (String)$OriginData;
	$NumMov = (String)$NumMov;
	$saldoexento = (String)$saldoexento;
	$saldoexento_anterior = HistoricoPagos_SaldoExcento($NumContrato, $OriginData,$NumMov);
	$saldoexento_nuevo = $saldoexento_anterior + $saldoexento;


	$sql="
	UPDATE historicopagos
	SET
	saldoexento=TRUNCATE('".$saldoexento_nuevo."',2) WHERE NumContrato='".$NumContrato."' and OriginData='".$OriginData."' and NumMov='".$NumMov."'
	";
	echo "<script>console.log(`".$sql."`);</script>";
	if ($Vivienda->query($sql) == TRUE)
	{
		historia($nitavu,"actualizo el saldo exento del contrato ".$NumContrato." OriginData=".$OriginData." del NumMov=".$NumMov." (habia ".$saldoexento_anterior.")");
		return TRUE;
		
	} else {
		return FALSE;
	}


}


function HistoricoPagos_SaldoExcento($NumContrato, $OriginData,$NumMov){
	require("config.php");
	$NumContrato = (String)$NumContrato;
	$OriginData = (String)$OriginData;
	$NumMov = (String)$NumMov;
	// $saldoexento = (String)$saldoexento;

	$sql = "SELECT ifnull(saldoexento,0) as saldoexento from historicopagos WHERE NumContrato='".$NumContrato."' and OriginData='".$OriginData."' and NumMov='".$NumMov."'";
	$rc= $Vivienda -> query($sql);
	if($f = $rc -> fetch_array())
	{
		return $f['saldoexento'];
	} else {
		return 0;
	}


}

function NominaFile($IdEmpleado, $Fecha){
	require("config.php");
	$sql = "select ifnull(File,'') as File from nominas where nitavu='".$IdEmpleado."' and FechaNomina='".$Fecha."'";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		return $f['File'];
	} else {
		return '';
	}


}

function EstatusCuenta($NumContrato){
	require("config.php");
	$sql = "
	SELECT 
	NumContrato,
	controlcontratos.EstatusCuenta,
	estatuscuentas.Descripcion
	FROM
	controlcontratos
	INNER JOIN estatuscuentas ON controlcontratos.EstatusCuenta = estatuscuentas.idEstatusCuenta

	where NumContrato ='".$NumContrato."'

	
	";
	$rc= $Vivienda -> query($sql);	
	if($f = $rc -> fetch_array())
	{
		return $f['Descripcion'];
	}
	else
		{ return "";}
}


// function RecuperarIPLocal($nitavu){
// 	require("config.php");
// 	$sql = "
// 	select * from ips where fecha = curdate() and nitavu=".$nitavu." order by hora DESC limit 1";
// 	$rc= $conexion -> query($sql);	
// 	if($f = $rc -> fetch_array())
// 	{
// 		return $f['ip_local'];
// 	}
// 	else
// 		{ return 0;}
// }



function LoaderFile(){
	require("config.php");
	$sql = "
	select * from loaders ORDER BY RAND() limit 1
	";
	$rc= $conexion -> query($sql);
	
	if($f = $rc -> fetch_array())
	{
		return "img/".$f['file'];
	}
	else
		{ return "";}
}


function CarteraVencida_ColoniaCount($IdDelegacion, $IdColonia){
	require("config.php");
	$sql = "
	select count(*) as n from carteravencida_seguimiento 
		WHERE Fecha = (select MAX(Fecha) from carteravencida_seguimiento) AND IdDelegacion = ".$IdDelegacion." and IdColonia = ".$IdColonia."
	";
	$rc= $conexion -> query($sql);
	
	if($f = $rc -> fetch_array())
	{
		return $f['n'];
	}
	else
		{ return 0;}
}
function CURP_limite(){
	require("config.php");
	if (CURPs_hoy() < $CURP_limite){
		return TRUE;
	} else {
		return FALSE;
	}
}

function CURPs_hoy(){
	require("config.php");
	$sql = "
	select count(*) as n from curp_consultas where fecha = curdate()
	";
	$rc= $conexion -> query($sql);
	
	if($f = $rc -> fetch_array())
	{
		return $f['n'];
	}
	else
		{ return 0;}
}


function CarteraVencida_CalculoHoy($IdDelegacion){
	require("config.php");
	$sql = "
	select count(*) as n from carteravencida_seguimiento WHERE IdDelegacion=".$IdDelegacion." and Fecha='".$fecha."'
	";
	$rc= $conexion -> query($sql);
	
	if($f = $rc -> fetch_array())
	{
		return $f['n'];
	}
	else
		{ return 0;}
}


function MiIdDelegacion($nitavu){
	require("config.php");
	$sql = "select IdDelegacion from empleadosconiddelegacion where del='del' and nitavu='".$nitavu."'";

	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		return $f['IdDelegacion'];
	} else {
		return "";
	}
}	
	
function DbPing($IdDelegacion){
	$ConsultaDATA2 = DatosViviendaLarge($IdDelegacion, "Plataforma", "Test", "select 'EXITO' as TocToc");
	// var_dump($ConsultaDATA2);
	$mystring = $ConsultaDATA2;
	// echo $mystring;
    $findme   = 'EXITO';
    // echo $mystring;
    $pos = strpos($mystring, $findme);
    if ($pos === false) {
        return FALSE;
    } else {
        return TRUE;
    }
    
    

}

function DelegacionIpPrivada($id){
	require("config.php");
	$sql = "SELECT IpPrivada FROM catalogodevpn WHERE IdDelegacion='".$id."'";
	// echo $sql;
	$rc= $conexion -> query($sql);
	$msg="";
	if($f = $rc -> fetch_array())
	{
		return $f['IpPrivada'];
	}
	else
	{ 
		return FALSE;
	}
}
function TramiteAprobar($FolioTramite, $IdUsuario, $info){
	require("config.php");
	$sql = "UPDATE tramites  SET Estado=2 WHERE IdTramite='".$FolioTramite."'";
	echo $sql;
	if ($conexion->query($sql) == TRUE){
		historia($IdUsuario,"tramites: Aprobo el Tramite con Folio " . $FolioTramite.", ".$info);
		return TRUE;	
	}
	else {
		return FALSE;
	}

		
	
}


function TramitePermisoAgregar($IdTipoTramite, $IdEmpleado, $IdPermiso, $IdUsuario ){
	require("config.php");
	$msg="";
	
	$sql = "INSERT INTO tramitesPermisos(IdTipoTramite, Permiso, nitavu, fecha, nitavu_autoriza) 
			VALUES ('".$IdTipoTramite."', '".$IdPermiso."', '".$IdEmpleado."','".$fecha."','".$IdUsuario."')";

	if ($conexion->query($sql) == TRUE){                   
		historia($IdUsuario,"tramites: Agrego acceso a  ".$IdEmpleado." - ".nitavu_nombre($IdEmpleado)." el Tramite ".$IdTipoTramite." - ".TramiteNombre($IdTipoTramite)." el Permiso ".$IdPermiso);
		return TRUE;
	} else {
		return FALSE;
	}
}


function TramitePermisoRetirar($IdTipoTramite, $IdEmpleado, $IdPermiso, $IdUsuario ){
	require("config.php");
	$msg="";
	$sql="delete from tramitesPermisos WHERE
	IdTipoTramite=".$IdTipoTramite." and Permiso=".$IdPermiso." and nitavu=".$IdEmpleado."";
	if ($conexion->query($sql) == TRUE){                   
		historia($IdUsuario,"tramites: Retiro el acceso a  ".$IdEmpleado." - ".nitavu_nombre($IdEmpleado)." el Tramite ".$IdTipoTramite." - ".TramiteNombre($IdTipoTramite)." el Permiso ".$IdPermiso);
		return TRUE;
	} else {
		return FALSE;
	}
}



function TramiteVobos($IdTramite){
	require("config.php");
	$msg="";
	$sql="select * from tramitesvobos WHERE IdTramite='".$IdTramite."'";
	$r= $conexion -> query($sql);

    while($f = $r -> fetch_array()) {
		$msg = $msg."<img src='icon/ok.png' style='width:10px;'><b title='".$f['fecha'].":".$f['hora']."'>".nitavu_nombre($f['nitavu'])."</b><br>";
	}
	if ($msg <> ''){
		return "<span style='
		
		
		'><hr>Vobos: <br>".$msg."</span>";
	}
	else {
		return "";
	}
}


function TramiteVobo($IdTramite, $IdUser){
	require("config.php");

	$sql = "INSERT INTO tramitesvobos(IdTramite, nitavu, fecha, hora) 
			VALUES ('".$IdTramite."', '".$IdUser."', '".$fecha."','".$hora."')";
	// echo $sql;
	if ($conexion->query($sql) == TRUE){                   
		historia($IdUser,"tramites: Dio Vobo al Tramite con Id ".$IdTramite.", ".detectar());
		return TRUE;
	} else {
		return FALSE;
	}
}

function GraficaPorcentaje($Div, $Valor){


	echo '
	<div id="'.$Div.'" class="GraficaPorcentaje" >
		<canvas id="'.$Div.'canvas" class="GraficaPorcentajeCanvas"></canvas>    
		<div  id="'.$Div.'CanvasGLabel"  class="GraficaPorcentajeLabel">18%</div>
		<div  id="CanvasGLabelSigno"  class="GraficaPorcentajeSigno">%</div>
	</div>
	';
	
	echo "
	<script>
	function GraficaPorcentaje".$Div."(){
		var opts = {
			lines: 12, 
			angle: 0.22,
			lineWidth: 0.1, 
			pointer: {
				length: 0.5, strokeWidth: 0.035, color: '#000000' 
			},
			limitMax: 'false', 
			colorStart: '#A1C30D', 
			colorStop: '#2DA3DC',
			strokeColor: '#A1C30D', 
			generateGradient: true
		};
		var target = document.getElementById('".$Div."canvas'); 
		var gauge = new Donut(target).setOptions(opts);
		gauge.maxValue = 100; 
		gauge.animationSpeed = 20; 
		gauge.set(".$Valor."); 
		gauge.setTextField(document.getElementById('".$Div."CanvasGLabel'));
		
		textRenderer.render = function(gauge){
			//percentage = gauge.displayedValue / gauge.maxValue
			//this.el.innerHTML = (percentage * 100).toFixed(2) + '%'
			this.el.innerHTML = gauge.displayedValue + '%'
	
		};
		
	
	}  
	GraficaPorcentaje".$Div."();
	</script>
	
	";
	

}

function ExportarExcel($Tabla, $Archivo, $nitavu){

    echo "<form method='POST' action='excel.php' style='margin:10px;'>
    <input type='hidden' name='nitavu' value='".$nitavu."'>
    <input type='hidden' name='Tabla' value='".$Tabla."'>
    <input type='hidden' name='Archivo' value='".$Archivo."'>
    <input type='submit' value='Exportar a Excel' class='Mbtn btn-Excel'></form>";

}

function tramitesTengoPermiso($nitavu, $IdTipoTramite, $Permiso){
	require("config.php");
	$sql = "
	select count(*) as Valor from tramitesListadePermisos WHERE IdEmpleado='".$nitavu."' AND IdTipoTramite='".$IdTipoTramite."' AND Permiso='".$Permiso."'";
	
	$rc= $conexion -> query($sql);
	
	if($f = $rc -> fetch_array())
	{
		return $f['Dptos'];
	}
	else
		{ return 0;}
}


function MisDptosIn($nitavu){
	require("config.php");
	$sql = "
	select MisDptos(".$nitavu.") as Dptos
	";
	$rc= $conexion -> query($sql);
	
	if($f = $rc -> fetch_array())
	{
		return $f['Dptos'];
	}
	else
		{ return "";}
}





function EdoCuentaFooter4($contrato, $IdDelegacion, $IdPrograma, $Folio){
	require("config.php");	$t1='';
	$sql8 ="SELECT ISNULL(IdDelegacion,'') AS IdDelegacion, ISNULL(IdPrograma,'') AS IdPrograma, ISNULL(Folio,'') AS Folio, ISNULL(NumContrato, '') AS NumContrato, ISNULL(TasaAnualFin,'') AS TasaAnualFin, ISNULL(TasaIntMora,'') AS TasaIntMora, ISNULL(MontoCredito,'') AS MontoCredito, ISNULL(MontoPago,'') AS MontoPago,
	ISNULL(Actualizacion,'') AS Actualizacion, ISNULL(Cargo_MontoCredito,'') AS Cargo_MontoCredito, ISNULL(Cargo_OtrosGastos,'') AS Cargo_OtrosGastos, ISNULL(Cargo_ComisionesFinancSegVida,'') AS Cargo_ComisionesFinancSegVida, ISNULL(Cargo_Moratorios,'') AS Cargo_Moratorios, ISNULL(Abonos_Ahorros,'') AS Abonos_Ahorros,
	ISNULL(Abonos_Subsidios,'') AS Abonos_Subsidios, ISNULL(Abonos_PagosRecibidos,'') AS Abonos_PagosRecibidos, ISNULL(Abonos_Descuentos,'') AS Abonos_Descuentos, ISNULL(Abonado_SoloCapital,'') AS Abonado_SoloCapital, ISNULL(Saldo_VencidoSinMoratorios,'') AS Saldo_VencidoSinMoratorios, ISNULL(Saldo_Corriente,'') AS Saldo_Corriente,
	ISNULL(Saldo_Moratorio,'') AS Saldo_Moratorio, ISNULL(SaldoExento,'') AS SaldoExento, ISNULL(Saldo,'') AS Saldo, ISNULL(MesesDeAtraso,'') AS MesesDeAtraso, ISNULL(FechaPrimerPAGO,'') AS FechaPrimerPAGO, ISNULL(FechaUltimoPAGO,'') AS FechaUltimoPAGO, ISNULL(PuntosAcumulados,'') AS PuntosAcumulados, ISNULL(TotalPeriodosPagados,'') AS TotalPeriodosPagados, ISNULL(TotalPeriodosVencidos,'') AS TotalPeriodosVencidos
	FROM busqueda_vivienda_informacionfinanciera WHERE numcontrato = '".$contrato."'";
	//echo $sql8.'<br>';
	$ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", $sql8);
	$array = json_decode($ConsultaDATA, true);
	$error = 0;    $c=0;
	if(is_array($array)){            
		foreach ($array as $value) {
			if (isset($value['r'])){// si hay un error
				$t1 = $t1."*Error: ".$value['r'];
				$error = $value['r'];
			} else {//si no hay errores escribimos

				
				// $t1 = $t1.'<tr style="font-size:7pt;">';
				
				$abonos = $value['Abonos_Ahorros'] + $value['Abonos_Subsidios'] + $value['Abonos_PagosRecibidos'] + $value['Abonos_Descuentos'];
				$cargos = $value['Cargo_MontoCredito'] + $value['Cargo_OtrosGastos'] + $value['Cargo_ComisionesFinancSegVida'] + $value['Cargo_Moratorios'];
				$saldo = $cargos - $abonos;
				$t1 = $t1.'
						<div style="border:1px dashed #D4D4D4; background-color:white; padding:10px; ">
						<table border="0" style="color:black;font-size:10pt;"><tr bgcolor="#D4D4D4">';
					
						$t1 = $t1.'<td style="font-size:8pt;"> Total de periodos pagados <b>'.$value['TotalPeriodosPagados'].'</b></td>';
						// $t1 = $t1.'<td style="font-size:8pt;"> Total de periodos por pagar</td>';
						$t1 = $t1.'<td style="font-size:8pt;"> Total de periodos vencidos <b>'.$value['TotalPeriodosVencidos'].'</b></td>';
						$t1 = $t1.'<td style="font-size:8pt;"> Total de puntos acumulados <b>'.$value['PuntosAcumulados'].'</b></td>';

					$t1 = $t1.'
						</tr>
						</table></div>
					';
					
			}
			
		}
		
	}
	return $t1;
}


function VEdoCuentaFooter4($contrato, $IdDelegacion, $IdPrograma, $Folio, $OriginData){
	require("config.php");	$t1='';
	$sql8 ="SELECT *
	FROM busqueda_vivienda_informacionfinanciera WHERE numcontrato = '".$contrato."' and OriginData='".$OriginData."'";
	//echo $sql8.'<br>';
	$rc= $Vivienda -> query($sql8);
	if($value = $rc -> fetch_array())
	{
	
				$abonos = $value['Abonos_Ahorros'] + $value['Abonos_Subsidios'] + $value['Abonos_PagosRecibidos'] + $value['Abonos_Descuentos'];
				$cargos = $value['Cargo_MontoCredito'] + $value['Cargo_OtrosGastos'] + $value['Cargo_ComisionesFinancSegVida'] + $value['Cargo_Moratorios'];
				$saldo = $cargos - $abonos;
				// $t1 = $t1.'
				// 		<div style="border:1px dashed #D4D4D4; background-color:white; padding:10px; ">
				// 		<table border="0" style="color:black;font-size:10pt;"><tr bgcolor="#D4D4D4">';
					
				// 		// $t1 = $t1.'<td style="font-size:8pt;"> Total de periodos pagados <b>'.$value['TotalPeriodosPagados'].'</b></td>';
				// 		// $t1 = $t1.'<td style="font-size:8pt;"> Total de periodos por pagar</td>';
				// 		// $t1 = $t1.'<td style="font-size:8pt;"> Total de periodos vencidos <b>'.$value['TotalPeriodosVencidos'].'</b></td>';
				// 		// $t1 = $t1.'<td style="font-size:8pt;"> Total de puntos acumulados <b>'.$value['PuntosAcumulados'].'</b></td>';

				// 	$t1 = $t1.'
				// 		</tr>
				// 		</table></div>
				// 	';
					
			}
			
		
	return $t1;
}

function EdoCuentaFooter3($contrato, $IdDelegacion, $IdPrograma, $Folio){
	require("config.php");	$t1='';
	$sql8 ="SELECT ISNULL(IdDelegacion,'') AS IdDelegacion, ISNULL(IdPrograma,'') AS IdPrograma, ISNULL(Folio,'') AS Folio, ISNULL(NumContrato, '') AS NumContrato, ISNULL(TasaAnualFin,'') AS TasaAnualFin, ISNULL(TasaIntMora,'') AS TasaIntMora, ISNULL(MontoCredito,'') AS MontoCredito, ISNULL(MontoPago,'') AS MontoPago,
	ISNULL(Actualizacion,'') AS Actualizacion, ISNULL(Cargo_MontoCredito,'') AS Cargo_MontoCredito, ISNULL(Cargo_OtrosGastos,'') AS Cargo_OtrosGastos, ISNULL(Cargo_ComisionesFinancSegVida,'') AS Cargo_ComisionesFinancSegVida, ISNULL(Cargo_Moratorios,'') AS Cargo_Moratorios, ISNULL(Abonos_Ahorros,'') AS Abonos_Ahorros,
	ISNULL(Abonos_Subsidios,'') AS Abonos_Subsidios, ISNULL(Abonos_PagosRecibidos,'') AS Abonos_PagosRecibidos, ISNULL(Abonos_Descuentos,'') AS Abonos_Descuentos, ISNULL(Abonado_SoloCapital,'') AS Abonado_SoloCapital, ISNULL(Saldo_VencidoSinMoratorios,'') AS Saldo_VencidoSinMoratorios, ISNULL(Saldo_Corriente,'') AS Saldo_Corriente,
	ISNULL(Saldo_Moratorio,'') AS Saldo_Moratorio, ISNULL(SaldoExento,'') AS SaldoExento, ISNULL(Saldo,'') AS Saldo, ISNULL(MesesDeAtraso,'') AS MesesDeAtraso, ISNULL(FechaPrimerPAGO,'') AS FechaPrimerPAGO, ISNULL(FechaUltimoPAGO,'') AS FechaUltimoPAGO, ISNULL(PuntosAcumulados,'') AS PuntosAcumulados, ISNULL(TotalPeriodosPagados,'') AS TotalPeriodosPagados, ISNULL(TotalPeriodosVencidos,'') AS TotalPeriodosVencidos
	FROM busqueda_vivienda_informacionfinanciera WHERE numcontrato = '".$contrato."'";
	//echo $sql8.'<br>';
	$ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", $sql8);
	$array = json_decode($ConsultaDATA, true);
	$error = 0;    $c=0;
	if(is_array($array)){            
		foreach ($array as $value) {
			if (isset($value['r'])){// si hay un error
				$t1 = $t1."*Error: ".$value['r'];
				$error = $value['r'];
			} else {//si no hay errores escribimos

				
				// $t1 = $t1.'<tr style="font-size:7pt;">';
				
				$abonos = $value['Abonos_Ahorros'] + $value['Abonos_Subsidios'] + $value['Abonos_PagosRecibidos'] + $value['Abonos_Descuentos'];
				$cargos = $value['Cargo_MontoCredito'] + $value['Cargo_OtrosGastos'] + $value['Cargo_ComisionesFinancSegVida'] + $value['Cargo_Moratorios'];
				$saldo = $cargos - $abonos;
				$t1 = $t1.'
						<div style="border:1px dashed #D4D4D4; background-color:white; padding:10px; ">
						<table border="0" style="color:black;font-size:10pt;">';
					
			

					$t1 = $t1.'
						<tr bgcolor="#A6A6A6" style="font-size:10pt; color:white;">
							<td align="left" colspan="2" align="center">SALDO:</td>
						</tr>
						<tr bgcolor="#E9E9E9" style="font-size:8pt;">
							<td align="left">Saldo se debe cubrir: </td><td align="left"><b>$'.number_format($value['Saldo_VencidoSinMoratorios'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="white"  style="font-size:8pt;">
							<td align="left" >Saldo Corriente:</td><td  align="left"><b>$ '.number_format($value['Saldo_Corriente'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="#E9E9E9" style="font-size:8pt;">
							<td align="left">Saldo de Moratorios:</td><td align="left"><b>$ '.number_format($value['Saldo_Moratorio'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="white"  style="font-size:8pt;">
							<td align="left">Saldo Total a la Fecha:</td><td align="left"><b>$ '.number_format($value['Saldo'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="#E9E9E9"  style="font-size:8pt;">
							<td align="left">SALDO TOTAL:</td><td align="left"><b>$ '.number_format($saldo, 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="white"  style="font-size:9pt;">
							<td colspan="2" align="left" style="font-size:7pt; color:gray;"> (Saldo total = cargos - abonos)<br><br></td>
						</tr>
						</table></div>
					';
					
			}
			
		}
		
	}
	return $t1;
}



function VEdoCuentaFooter3($contrato, $IdDelegacion, $IdPrograma, $Folio,$OriginData){
	require("config.php");	$t1='';
	$sql8 ="SELECT *
	FROM vivienda_informacionfinanciera WHERE numcontrato = '".$contrato."' and OriginData=".$OriginData;
	//echo $sql8.'<br>';
	$rc= $Vivienda -> query($sql8);
	if($value = $rc -> fetch_array())
	{
	
				
				// $t1 = $t1.'<tr style="font-size:7pt;">';
				
				$abonos = $value['Abonos_Ahorros'] + $value['Abonos_Subsidios'] + $value['Abonos_PagosRecibidos'] + $value['Abonos_Descuentos'];
				$cargos = $value['Cargo_MontoCredito'] + $value['Cargo_OtrosGastos'] + $value['Cargo_ComisionesFinancSegVida'] + $value['Cargo_Moratorios'];
				$saldo = $cargos - $abonos;
				$t1 = $t1.'
						<div style="border:1px dashed #D4D4D4; background-color:white; padding:10px; ">
						<table border="0" style="color:black;font-size:10pt;">';
					
			

					$t1 = $t1.'
						<tr bgcolor="#A6A6A6" style="font-size:10pt; color:white;">
							<td align="left" colspan="2" align="center">SALDO:</td>
						</tr>
						<tr bgcolor="#E9E9E9" style="font-size:8pt;">
							<td align="left">Saldo se debe cubrir: </td><td align="left"><b>$'.number_format($value['Saldo_VencidoSinMoratorios'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="white"  style="font-size:8pt;">
							<td align="left" >Saldo Corriente:</td><td  align="left"><b>$ '.number_format($value['Saldo_Corriente'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="#E9E9E9" style="font-size:8pt;">
							<td align="left">Saldo de Moratorios:</td><td align="left"><b>$ '.number_format($value['Saldo_Moratorio'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="white"  style="font-size:8pt;">
							<td align="left">Saldo Total a la Fecha:</td><td align="left"><b>$ '.number_format($value['Saldo'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="#E9E9E9"  style="font-size:8pt;">
							<td align="left"> * SALDO TOTAL:</td><td align="left"><b>$ '.number_format($saldo, 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="white"  style="font-size:9pt;">
							<td colspan="2" align="left" style="font-size:7pt; color:gray;"> (Saldo total = cargos - abonos)<br><br></td>
						</tr>
						</table></div>
					';
					
			}
			
		
	return $t1;
}


function EdoCuentaFooter2($contrato, $IdDelegacion, $IdPrograma, $Folio){
	require("config.php");	$t1='';
	$sql8 ="SELECT ISNULL(IdDelegacion,'') AS IdDelegacion, ISNULL(IdPrograma,'') AS IdPrograma, ISNULL(Folio,'') AS Folio, ISNULL(NumContrato, '') AS NumContrato, ISNULL(TasaAnualFin,'') AS TasaAnualFin, ISNULL(TasaIntMora,'') AS TasaIntMora, ISNULL(MontoCredito,'') AS MontoCredito, ISNULL(MontoPago,'') AS MontoPago,
	ISNULL(Actualizacion,'') AS Actualizacion, ISNULL(Cargo_MontoCredito,'') AS Cargo_MontoCredito, ISNULL(Cargo_OtrosGastos,'') AS Cargo_OtrosGastos, ISNULL(Cargo_ComisionesFinancSegVida,'') AS Cargo_ComisionesFinancSegVida, ISNULL(Cargo_Moratorios,'') AS Cargo_Moratorios, ISNULL(Abonos_Ahorros,'') AS Abonos_Ahorros,
	ISNULL(Abonos_Subsidios,'') AS Abonos_Subsidios, ISNULL(Abonos_PagosRecibidos,'') AS Abonos_PagosRecibidos, ISNULL(Abonos_Descuentos,'') AS Abonos_Descuentos, ISNULL(Abonado_SoloCapital,'') AS Abonado_SoloCapital, ISNULL(Saldo_VencidoSinMoratorios,'') AS Saldo_VencidoSinMoratorios, ISNULL(Saldo_Corriente,'') AS Saldo_Corriente,
	ISNULL(Saldo_Moratorio,'') AS Saldo_Moratorio, ISNULL(SaldoExento,'') AS SaldoExento, ISNULL(Saldo,'') AS Saldo, ISNULL(MesesDeAtraso,'') AS MesesDeAtraso, ISNULL(FechaPrimerPAGO,'') AS FechaPrimerPAGO, ISNULL(FechaUltimoPAGO,'') AS FechaUltimoPAGO, ISNULL(PuntosAcumulados,'') AS PuntosAcumulados, ISNULL(TotalPeriodosPagados,'') AS TotalPeriodosPagados, ISNULL(TotalPeriodosVencidos,'') AS TotalPeriodosVencidos
	FROM busqueda_vivienda_informacionfinanciera WHERE numcontrato = '".$contrato."'";
	//echo $sql8.'<br>';
	$ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", $sql8);
	$array = json_decode($ConsultaDATA, true);
	$error = 0;    $c=0;
	if(is_array($array)){            
		foreach ($array as $value) {
			if (isset($value['r'])){// si hay un error
				$t1 = $t1."*Error: ".$value['r'];
				$error = $value['r'];
			} else {//si no hay errores escribimos

				
				// $t1 = $t1.'<tr style="font-size:7pt;">';
				
				$abonos = $value['Abonos_Ahorros'] + $value['Abonos_Subsidios'] + $value['Abonos_PagosRecibidos'] + $value['Abonos_Descuentos'];
				$cargos = $value['Cargo_MontoCredito'] + $value['Cargo_OtrosGastos'] + $value['Cargo_ComisionesFinancSegVida'] + $value['Cargo_Moratorios'];
				$saldo = $cargos - $abonos;
				$t1 = $t1.'
						<div style="border:1px dashed #D4D4D4; background-color:white; padding:10px; ">
						<table border="0" style="color:black;font-size:10pt;">';
					


					$t1 = $t1.'
						<tr bgcolor="#A6A6A6" style="font-size:10pt; color:white;">
							<td align="left" colspan="2" align="center">ABONOS:</td>
						</tr>
						<tr bgcolor="#E9E9E9" style="font-size:8pt;">
							<td align="left">Enganche (ahorro): </td><td align="left"><b>$'.number_format($value['Abonos_Ahorros'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="white"  style="font-size:8pt;">
							<td align="left" >Subsidiado:</td><td  align="left"><b>$ '.number_format($value['Abonos_Subsidios'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="#E9E9E9" style="font-size:8pt;">
							<td align="left">Financ, Seguros y Gastos:</td><td align="left"><b>$ '.number_format($value['Cargo_ComisionesFinancSegVida'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="white"  style="font-size:8pt;">
							<td align="left">Pados Recibidos:</td><td align="left"><b>$ '.number_format($value['Abonos_PagosRecibidos'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="#E9E9E9"  style="font-size:8pt;">
							<td align="left">Descuentos y Bonificaciones:</td><td align="left"><b>$ '.number_format($value['Abonos_Descuentos'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="white"  style="font-size:9pt;">
							<td align="left">Total de Abonos:</td><td align="left"><b>$ '.number_format($abonos, 2, '.', ',').'</b></td>
						</tr>
						</table></div>
					';
					
			}
			
		}
		
	}
	return $t1;
}




function VEdoCuentaFooter2($contrato, $IdDelegacion, $IdPrograma, $Folio, $OriginData){
	require("config.php");	$t1='';
	$sql8 ="SELECT *
	FROM busqueda_vivienda_informacionfinanciera WHERE numcontrato = '".$contrato."' and OriginData='".$OriginData."'";
	//echo $sql8.'<br>';
	$rc= $Vivienda -> query($sql8);
	if($value = $rc -> fetch_array())
	{
				// $t1 = $t1.'<tr style="font-size:7pt;">';
				
				$abonos = $value['Abonos_Ahorros'] + $value['Abonos_Subsidios'] + $value['Abonos_PagosRecibidos'] + $value['Abonos_Descuentos'];
				$cargos = $value['Cargo_MontoCredito'] + $value['Cargo_OtrosGastos'] + $value['Cargo_ComisionesFinancSegVida'] + $value['Cargo_Moratorios'];
				$saldo = $cargos - $abonos;
				$t1 = $t1.'
						<div style="border:1px dashed #D4D4D4; background-color:white; padding:10px; ">
						<table border="0" style="color:black;font-size:10pt;">';
					


					$t1 = $t1.'
						<tr bgcolor="#A6A6A6" style="font-size:10pt; color:white;">
							<td align="left" colspan="2" align="center">ABONOS:</td>
						</tr>
						<tr bgcolor="#E9E9E9" style="font-size:8pt;">
							<td align="left">Enganche (ahorro): </td><td align="left"><b>$'.number_format($value['Abonos_Ahorros'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="white"  style="font-size:8pt;">
							<td align="left" >Subsidiado:</td><td  align="left"><b>$ '.number_format($value['Abonos_Subsidios'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="#E9E9E9" style="font-size:8pt;">
							<td align="left">Financ, Seguros y Gastos:</td><td align="left"><b>$ '.number_format($value['Cargo_ComisionesFinancSegVida'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="white"  style="font-size:8pt;">
							<td align="left">Pados Recibidos:</td><td align="left"><b>$ '.number_format($value['Abonos_PagosRecibidos'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="#E9E9E9"  style="font-size:8pt;">
							<td align="left">Descuentos y Bonificaciones:</td><td align="left"><b>$ '.number_format($value['Abonos_Descuentos'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="white"  style="font-size:9pt;">
							<td align="left">Total de Abonos:</td><td align="left"><b>$ '.number_format($abonos, 2, '.', ',').'</b></td>
						</tr>
						</table></div>
					';
					
			}
			
		
	return $t1;
}


function EdoCuentaFooter1($contrato, $IdDelegacion, $IdPrograma, $Folio){
	require("config.php");	$t1='';
	$sql8 ="SELECT ISNULL(IdDelegacion,'') AS IdDelegacion, ISNULL(IdPrograma,'') AS IdPrograma, ISNULL(Folio,'') AS Folio, ISNULL(NumContrato, '') AS NumContrato, ISNULL(TasaAnualFin,'') AS TasaAnualFin, ISNULL(TasaIntMora,'') AS TasaIntMora, ISNULL(MontoCredito,'') AS MontoCredito, ISNULL(MontoPago,'') AS MontoPago,
	ISNULL(Actualizacion,'') AS Actualizacion, ISNULL(Cargo_MontoCredito,'') AS Cargo_MontoCredito, ISNULL(Cargo_OtrosGastos,'') AS Cargo_OtrosGastos, ISNULL(Cargo_ComisionesFinancSegVida,'') AS Cargo_ComisionesFinancSegVida, ISNULL(Cargo_Moratorios,'') AS Cargo_Moratorios, ISNULL(Abonos_Ahorros,'') AS Abonos_Ahorros,
	ISNULL(Abonos_Subsidios,'') AS Abonos_Subsidios, ISNULL(Abonos_PagosRecibidos,'') AS Abonos_PagosRecibidos, ISNULL(Abonos_Descuentos,'') AS Abonos_Descuentos, ISNULL(Abonado_SoloCapital,'') AS Abonado_SoloCapital, ISNULL(Saldo_VencidoSinMoratorios,'') AS Saldo_VencidoSinMoratorios, ISNULL(Saldo_Corriente,'') AS Saldo_Corriente,
	ISNULL(Saldo_Moratorio,'') AS Saldo_Moratorio, ISNULL(SaldoExento,'') AS SaldoExento, ISNULL(Saldo,'') AS Saldo, ISNULL(MesesDeAtraso,'') AS MesesDeAtraso, ISNULL(FechaPrimerPAGO,'') AS FechaPrimerPAGO, ISNULL(FechaUltimoPAGO,'') AS FechaUltimoPAGO, ISNULL(PuntosAcumulados,'') AS PuntosAcumulados, ISNULL(TotalPeriodosPagados,'') AS TotalPeriodosPagados, ISNULL(TotalPeriodosVencidos,'') AS TotalPeriodosVencidos
	FROM busqueda_vivienda_informacionfinanciera WHERE numcontrato = '".$contrato."'";
	//echo $sql8.'<br>';
	$ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", $sql8);
	$array = json_decode($ConsultaDATA, true);
	$error = 0;    $c=0;
	if(is_array($array)){            
		foreach ($array as $value) {
			if (isset($value['r'])){// si hay un error
				$t1 = $t1."*Error: ".$value['r'];
				$error = $value['r'];
			} else {//si no hay errores escribimos

				$abonos = $value['Abonos_Ahorros'] + $value['Abonos_Subsidios'] + $value['Abonos_PagosRecibidos'] + $value['Abonos_Descuentos'];
				$cargos = $value['Cargo_MontoCredito'] + $value['Cargo_OtrosGastos'] + $value['Cargo_ComisionesFinancSegVida'] + $value['Cargo_Moratorios'];
				$saldo = $cargos - $abonos;
				
				// $t1 = $t1.'<tr style="font-size:7pt;">';
				
					$t1 = $t1.'
						<div style="border:1px dashed #D4D4D4; background-color:white; padding:10px; ">
						<table border="0" style="color:black;font-size:10pt;">';
			
					$t1 = $t1.'
						<tr bgcolor="#A6A6A6" style="font-size:10pt; color:white;">
							<td align="left" colspan="2" align="center">CARGOS:</td>
						</tr>
						<tr bgcolor="#E9E9E9" style="font-size:8pt;">
							<td align="left">Mnto. Credito: </td><td align="left"><b>$'.number_format($value['Cargo_MontoCredito'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="white"  style="font-size:8pt;">
							<td align="left" >Gastos y Comisiones Apertura:</td><td  align="left"><b>$ '.number_format($value['Cargo_OtrosGastos'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="#E9E9E9" style="font-size:8pt;">
							<td align="left">Financ, Seguros y Gastos:</td><td align="left"><b>$ '.number_format($value['Cargo_ComisionesFinancSegVida'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="white"  style="font-size:8pt;">
							<td align="left">Moratorios Generados:</td><td align="left"><b>$ '.number_format($value['Cargo_Moratorios'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="#E9E9E9"  style="font-size:9pt;">
							<td align="left">Total de Cargos:</td><td align="left"><b>$ '.number_format($cargos, 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="#E9E9E9"  style="font-size:9pt;">
						<td align="left"></td><td align="left"></td>
						</tr>
						</table></div>
					';
					
			}
			
		}
		
	}
	return $t1;
}




function VEdoCuentaFooter1($contrato, $IdDelegacion, $IdPrograma, $Folio, $OriginData){
	require("config.php");	$t1='';
	$sql8 ="SELECT 
	*
	FROM busqueda_vivienda_informacionfinanciera WHERE numcontrato = '".$contrato."' and OriginData='".$OriginData."'";
	
	$rc= $Vivienda -> query($sql8);
	if($value = $rc -> fetch_array())
	{
				$abonos = $value['Abonos_Ahorros'] + $value['Abonos_Subsidios'] + $value['Abonos_PagosRecibidos'] + $value['Abonos_Descuentos'];
				$cargos = $value['Cargo_MontoCredito'] + $value['Cargo_OtrosGastos'] + $value['Cargo_ComisionesFinancSegVida'] + $value['Cargo_Moratorios'];
				$saldo = $cargos - $abonos;
				
				// $t1 = $t1.'<tr style="font-size:7pt;">';
				
					$t1 = $t1.'
						<div style="border:1px dashed #D4D4D4; background-color:white; padding:10px; ">
						<table border="0" style="color:black;font-size:10pt;">';
			
					$t1 = $t1.'
						<tr bgcolor="#A6A6A6" style="font-size:10pt; color:white;">
							<td align="left" colspan="2" align="center">CARGOS:</td>
						</tr>
						<tr bgcolor="#E9E9E9" style="font-size:8pt;">
							<td align="left">Mnto. Credito: </td><td align="left"><b>$'.number_format($value['Cargo_MontoCredito'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="white"  style="font-size:8pt;">
							<td align="left" >Gastos y Comisiones Apertura:</td><td  align="left"><b>$ '.number_format($value['Cargo_OtrosGastos'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="#E9E9E9" style="font-size:8pt;">
							<td align="left">Financ, Seguros y Gastos:</td><td align="left"><b>$ '.number_format($value['Cargo_ComisionesFinancSegVida'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="white"  style="font-size:8pt;">
							<td align="left">Moratorios Generados:</td><td align="left"><b>$ '.number_format($value['Cargo_Moratorios'], 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="#E9E9E9"  style="font-size:9pt;">
							<td align="left">Total de Cargos:</td><td align="left"><b>$ '.number_format($cargos, 2, '.', ',').'</b></td>
						</tr>
						<tr bgcolor="#E9E9E9"  style="font-size:9pt;">
						<td align="left"></td><td align="left"></td>
						</tr>
						</table></div>
					';
					
	}
			
		
		
	
	return $t1;
}


function EdoCuentaDomicilio($contrato, $IdDelegacion, $IdPrograma, $Folio){
	require("config.php");	$t1='';
	 /*$sql2 = "SELECT isnull(Calle1,'') as Calle1, isnull(Calle2,'') as Calle2, isnull(CalleyNum,'') as CalleyNum, isnull(IdColonia,'') as IdColonia FROM datosdomicilio
                        WHERE (IdDelegacion = ".$value['IdDelegacion'].") AND (IdPrograma = ".$value['IdPrograma'].") AND (Folio = ".$value['Folio'].")";*/
                        $sql2 = "SELECT isnull(datosdomicilio.Calle1,'') as Calle1, isnull(datosdomicilio.Calle2,'') as Calle2,
                        isnull(datosdomicilio.CalleyNum,'') as CalleyNum,
                        isnull(datosdomicilio.IdColonia,'') as IdColonia, isnull(colonias.colonia,'') as Colonia
                        FROM datosdomicilio 
                        inner join colonias on colonias.IdColonia=datosdomicilio.IdColonia
                        WHERE (IdDelegacion = ".$IdDelegacion.") AND (IdPrograma = ".$IdPrograma.") AND (Folio = ".$Folio.")";
                       // echo $sql2.'<br>';
                         $ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", $sql2);
                         $array = json_decode($ConsultaDATA, true);
                     
                         if(is_array($array)){            
                             foreach ($array as $value) {
                                 if (isset($value['r'])){// si hay un error
                                     $t1 = $t1."*Error: ".$value['r'];
                                     $error = $value['r'];
                                 } else {//si no hay errores escribimos
                                    $t1= $t1.' Domicilio: <b>'.$value['CalleyNum'].' '.$value['Calle1'].' '.$value['Calle2'].'  
                                    , Colonia: '.$value['Colonia'].'</b>
                                       ';
                                 }
                            }
                        }
			   
	




				return $t1;
}



function VEdoCuentaDomicilio($contrato, $IdDelegacion, $IdPrograma, $Folio, $OriginData){
	require("config.php");	$t1='';
	$sql2 = "SELECT ifnull(datosdomicilio.Calle1,'') as Calle1, ifnull(datosdomicilio.Calle2,'') as Calle2,
	ifnull(datosdomicilio.CalleyNum,'') as CalleyNum,
	ifnull(datosdomicilio.IdColonia,'') as IdColonia, ifnull(colonias.colonia,'') as Colonia
	FROM datosdomicilio 
	inner join colonias on colonias.IdColonia=datosdomicilio.IdColonia
	WHERE (IdDelegacion = ".$IdDelegacion.") AND (IdPrograma = ".$IdPrograma.") AND (Folio = ".$Folio.") AND (datosdomicilio.OriginData=".$OriginData.")";
		// echo $sql2.'<br>';
		$t1="";
	$rc= $Vivienda -> query($sql2);
	if($value = $rc -> fetch_array())
	{

                        
		$t1= $t1.' Domicilio: <b>'.$value['CalleyNum'].'<BR> '.$value['Calle1'].'<BR> '.$value['Calle2'].'  
		<BR>Colonia: '.$value['Colonia'].'</b>
			';

	}	




				return $t1;
}


function EdoCuentaTablaDePagos($contrato, $IdDelegacion,$full, $ContratoCancelado){
	// $ContratoCancelado = ContratoCancelado($contrato, $IdDelegacion);
	require("config.php");	$t1='';

	$t1 = $t1.' <tr border="1" bgcolor="#484848" style="font-size:6.5pt;">
	<td align="center" style="width:25px; color:#ffffff; ">No.</td>
	<td align="left" style="width:50px; color:#ffffff; ">Emp. Creo <br> Emp. Mod <br> Emp. Creo</td>
	<td align="left" style="width:108px; color:#ffffff; ">Fecha Pago <br> Fecha Mod <br> Fecha de captura</td>
	<td align="left" style="width:70px; color:#ffffff; ">Núm. Recibo <br> Refen OPD <br> Cve. Interna</td>
	<td align="left" style="width:190px; color:#ffffff; ">Concepto <br> Observaciones <br> Aclaraciones financieras</td>
	<td align="center" style="width:70px; color:#ffffff; ">Cargos</td>
	<td align="center" style="width:70px; color:#ffffff; ">Abonos</td>
	<td align="center" style="width:75px; color:#ffffff; ">Saldo</td>
</tr>
';
// ISNULL(	CONVERT ( VARCHAR ( MAX ), conceptopago.Descripcion, 103 ),  CONVERT ( VARCHAR ( MAX ), descripcionmovimiento.DescripcionMovimiento, 103 )) AS descripcion,

if ($full == 1){
$sql7 = "select EdoCuenta.* from EdoCuenta
WHERE	NumContrato = '".$contrato."' 
-- AND tipomov <> 14 AND cancelado= 0 

ORDER BY	EdoCuenta.numpago";
} else {
$sql7 = "select EdoCuenta.* from EdoCuenta
WHERE	NumContrato = '".$contrato."' 
AND tipomov <> 14 AND cancelado= 0 

ORDER BY	EdoCuenta.numpago";
}
// echo $sql7.'<br>';

$ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratosPagos", "Test", $sql7);
if ($ConsultaDATA == TRUE){
$array = json_decode($ConsultaDATA, true);
$error = 0;
$c=1;

if(is_array($array)){            
foreach ($array as $value) {
	if (isset($value['r'])){// si hay un error
		$t1 = $t1.'<tr bgcolor="#ffffff" style="font-size:8pt;"><td colspan="8" align="center">Sin Movimientos....</td></tr>
		<tr bgcolor="#ffffff" style="font-size:8pt;"><td colspan="8" align="center"></td></tr>';
		$error = $value['r'];
	} else {//si no hay errores escribimos
		//Colores de lineas
		if ($c%2==0){
			$t1 = $t1.'<tr bgcolor="#C9DEB4" style="font-size:8pt;">';
		}else{
			$t1 = $t1.'<tr bgcolor="#ffffff"  style="font-size:8pt;">';
		}
		if($ContratoCancelado=="True"){
			
			$t1 = $t1."<td><strike>".$value['NumMov']."</strike></td>";
			$t1 = $t1."<td>";
					if($value['IdEmpCrea']<>0){
						$t1 = $t1.$StringStrike.$value['IdEmpCrea'].$StringStrike2;
					}
					if($value['IdEmpModifica']<>0){
						$t1 = $t1.$StringStrike.$value['IdEmpModifica'].$StringStrike2;
					}
				$t1 = $t1."</td>";

				$t1 = $t1.'<td style="font-size:7pt;">';
					//$t1 = $t1.$value['fechapago'].'<br>';
					//$t1 = $t1.$value['FechaUltimaMod'];
					if($value['fechapago'] <> '01/01/1900'){
						$t1 = $t1.$StringStrike.$value['fechapago'].'</strike><br>';
						
					}
					if($value['FechaUltimaMod'] <> '01/01/1900'){
						
						$t1 = $t1.$StringStrike.$value['FechaUltimaMod'].'</strike><br>';
					}
				$t1 = $t1."</td>";

				$t1 = $t1.'<td style="font-size:7pt;">';
					if($value['numrecibo']<>''){
						if (is_numeric($value['numrecibo'])) {
							$t1 = $t1.$StringStrike.number_format($value['numrecibo'], 0, '.', '')."</strike><br>";

						}else{
							$t1 = $t1.$StringStrike.$value['numrecibo']."</strike><br>";

						}
						//$t1 = $t1."".number_format($value['numrecibo'], 0, '.', '')."<br>";

					}
					if($value['ReferenciaOPD']<>''){
						$t1 = $t1.$StringStrike.$value['ReferenciaOPD']."</strike><br>";
					}
					if($value['Aclaraciones']<>''){
						$t1 = $t1.$StringStrike.$value['Aclaraciones'].$StringStrike2;
					}
				$t1 = $t1."</td>";

				$t1 = $t1."<td>";
						$t1 = $t1.$StringStrike.$value['descripcion'].'</strike><br>';
					if($value['observaciones']<>"" ){
						$t1 = $t1.$StringStrike.$value['observaciones']."</strike><br>";
					}
					if($value['Aclaraciones']<>''){
						$t1 = $t1.$StringStrike.$value['Aclaraciones'].$StringStrike2;
					}
				$t1 = $t1."</td>";

				$t1 = $t1.'<td align = "right">';
					if($value['cargos']<>0){
						$t1 = $t1.$StringStrike.number_format($value['cargos'], 2, '.', ',').$StringStrike2;
					}
				$t1 = $t1."</td>";

				$t1 = $t1.'<td align = "right">';
					if($value['abonos']<>0){
						$t1 = $t1.$StringStrike.number_format($value['abonos'], 2, '.', ',').$StringStrike2;
					}
				$t1 = $t1."</td>";

				$t1 = $t1.'<td align = "right">';
					if($value['Saldo']<>0){
						$t1 = $t1.$StringStrike.number_format($value['Saldo'], 2, '.', ',').$StringStrike2;
					}
				$t1 = $t1."</td>";
			$t1 = $t1."</tr>";
		}else{
				$t1 = $t1."<td>".$value['Secuencia']."</td>";
				$t1 = $t1."<td>";
						if($value['IdEmpCrea']<>0){
							$t1 = $t1."".$value['IdEmpCrea'];
						}
						if($value['IdEmpModifica']<>0){
							$t1 = $t1."".$value['IdEmpModifica'];
						}
					$t1 = $t1."</td>";

					$t1 = $t1.'<td style="font-size:7pt;">';
						//$t1 = $t1.$value['fechapago'].'<br>';
						//$t1 = $t1.$value['FechaUltimaMod'];
						if($value['fechapago'] <> '01/01/1900'){
							$t1 = $t1."".$value['fechapago'].'<br>';
							
						}
						if($value['FechaUltimaMod'] <> '01/01/1900'){
							
							$t1 = $t1."".$value['FechaUltimaMod'].'<br>';
						}
					$t1 = $t1."</td>";

					$t1 = $t1.'<td style="font-size:7pt;">';
						if($value['numrecibo']<>''){
							if (is_numeric($value['numrecibo'])) {
								$t1 = $t1."".number_format($value['numrecibo'], 0, '.', '')."<br>";

							}else{
								$t1 = $t1."".$value['numrecibo']."<br>";

							}
							//$t1 = $t1."".number_format($value['numrecibo'], 0, '.', '')."<br>";

						}
						if($value['ReferenciaOPD']<>''){
							$t1 = $t1."".$value['ReferenciaOPD']."<br>";
						}
						if($value['Aclaraciones']<>''){
							$t1 = $t1."".$value['Aclaraciones'];
						}
					$t1 = $t1."</td>";

					$t1 = $t1."<td>";
							$t1 = $t1."".$value['descripcion'].'<br>';
						if($value['observaciones']<>"" ){
							$t1 = $t1."".$value['observaciones']."<br>";
						}
						if($value['Aclaraciones']<>''){
							$t1 = $t1."".$value['Aclaraciones'];
						}
					$t1 = $t1."</td>";

					$t1 = $t1.'<td align = "right">';
						if($value['cargos']<>0){
							$t1 = $t1."".number_format($value['cargos'], 2, '.', ',');
						}
					$t1 = $t1."</td>";

					$t1 = $t1.'<td align = "right">';
						if($value['abonos']<>0){
							$t1 = $t1."".number_format($value['abonos'], 2, '.', ',');
						}
					$t1 = $t1."</td>";

					$t1 = $t1.'<td align = "right">';
						if($value['Saldo']<>0){
							$t1 = $t1."".number_format($value['Saldo'], 2, '.', ',');
						}
					$t1 = $t1."</td>";
				$t1 = $t1."</tr>";
			}
	}
	$c++;
}

}
} else {
	$t1 = '<tr><td colspan="8">Sin pagos detectados</td></tr>';
}
// $t1 = $t1.'</table>';
return $t1;
}







function VEdoCuentaTablaDePagos($contrato, $IdDelegacion, $ContratoCancelado, $OriginData,$full, $cancelados){	
	require("config.php");	
	$t1='';
	$t1 = $t1.'<tr border="1" bgcolor="#484848" style="font-size:6.5pt;">
	<td align="center" style="width:25px; color:#ffffff; ">No.</td>
	<td align="left" style="width:50px; color:#ffffff; ">Empleado:<br>a)Creo<br>b)Mod<br>c)Captura</td>
	<td align="left" style="width:108px; color:#ffffff; ">Fecha: <br> a)Pago <br> b)Mod <br> c)captura</td>
	<td align="left" style="width:70px; color:#ffffff; ">a)Núm. Recibo<br>b)Refen OPD<br>c)Cve. Interna</td>
	<td align="left" style="width:190px; color:#ffffff; ">a)Concepto<br>b)Observaciones<br>c)Aclaraciones Finac.</td>
	<td align="center" style="width:70px; color:#ffffff; ">Cargos</td>
	<td align="center" style="width:70px; color:#ffffff; ">Abonos</td>
	<td align="center" style="width:75px; color:#ffffff; ">Saldo</td>
	</tr>
	';

	$sql7 = "
	SELECT * FROM vivienda_pagosedocuenta
	WHERE	(NumContrato = '".$contrato."' and OriginData='".$OriginData."')
 

 ";



	$sql7_count = "

	SELECT	
	count(*) as n
	FROM vivienda_pagosedocuenta
	WHERE	(NumContrato = '".$contrato."' and OriginData='".$OriginData."')
 
	";
	

$GranCargo = 0; $GranAbono=0; $styleERROR ="background-color:#FFCC99;"; $Calculo_Saldo = 0;
$c=0; $Registros = 0;
$rc= $Vivienda -> query($sql7_count); if($f = $rc -> fetch_array()){$Registros = $f['n'];}

$StringStrike=""; $StringStrike2="";
if($ContratoCancelado==1){	$StringStrike = "<strike>"; $StringStrike2="</strike>";}

if ($Registros <= 0 ){
		$t1 = $t1.'<tr bgcolor="#ffffff" style="font-size:8pt;"><td colspan="8" align="center">Sin Movimientos....</td></tr>
		<tr bgcolor="#ffffff" style="font-size:8pt;"><td colspan="8" align="center"></td></tr>';
} else {
	$r1= $Vivienda -> query($sql7);
	while($value = $r1 -> fetch_array()) {
	// if ($value['Cancelado']==0){
	// 	$Calculo_Saldo = $Calculo_Saldo + $value['cargos']; //<-- aumentamos el calculo del saldo
	// 	$Calculo_Saldo = $Calculo_Saldo - $value['abonos']; //<-- le quitamos el calculo del saldo


	// 	$SaldoDeCuenta = (String)$value['Saldo'];
	// 	$Calculo_Saldo2 = (String)$Calculo_Saldo;
	// 	// var_dump($SaldoDeCuenta);
	// 	// var_dump($Calculo_Saldo);
		
	// 	$Diferencia = $SaldoDeCuenta - $Calculo_Saldo;
	// 	$StringStrike = ""; $StringStrike2="";
	// } else {
	// 	$StringStrike = "<strike>"; $StringStrike2="</strike>";
	// }
	


	


		$Muestro = TRUE;
		$styleTD='border:1px solid white;';
		// if ($cancelados == 1){
			// if ($value['Cancelado']==1){
			// 	$Muestro = FALSE; //no mostrar y seguir 
			// }	
			
		// } else {
		// 	$Muestro = TRUE; //no mostrar y seguir 
			
		// }

		if ($value['Cancelado']==1 AND  $cancelados == 1){ // si esta cancelado y dio clic en mostrar cancelados
			$Muestro = TRUE;
		} 

		if ($value['Cancelado']==1 AND  $cancelados == 0){ // si esta cancelado y dio clic en mostrar cancelados
			$Muestro = FALSE;
		} 

		if ($value['Cancelado']==1 AND  $full == 1){ // si esta cancelado y dio clic en mostrar cancelados
			$Muestro = TRUE;
		} 



		if ($Muestro == TRUE){
			//CHECA SI EL SALDO GUARDADO VS EL CALCULADO
			$Desface=0;
			if ($value['Saldo']>$value['Saldo_Calculado']){
				$Desface = $value['Saldo'] - $value['Saldo_Calculado'];
				// $t1 = $t1."<br><sup>* -".$Desface."</sup>";
			} else {
				$Desface = $value['Saldo_Calculado'] - $value['Saldo'];
				// $t1 = $t1."<br><sup>* +".$Desface."</sup>";
			}
			if ($Desface==0){ //si no tiene falla el registro		
					if ($c%2==0){
						$t1 = $t1.'<tr bgcolor="#BFBFBF" border="1" style="font-size:8pt; border:1px solid gray;1">';
					}else{
						$t1 = $t1.'<tr bgcolor="#EEEEEE" border="1" style="font-size:8pt; border:1px solid gray;2">';
					}
			} else {//si tiene un error de calculo
				
				if($full==1){ // si debo mostrar la solucion
					$t1 = $t1.'<tr bgcolor="#FFE599" border="1" style="font-size:8pt; border:1px solid gray;3">';
				} else { //si no debo mostrar la solucion, lo ilumino normal
					if ($c%2==0){
						$t1 = $t1.'<tr bgcolor="#BFBFBF" border="1" style="font-size:8pt; border:1px solid gray;4">';
					}else{
						$t1 = $t1.'<tr bgcolor="#EEEEEE" border="1" style="font-size:8pt; border:1px solid gray;5">';
					}
		
				}
			}
		$t1 = $t1.'<td align="center" valign="center"  style="'.$styleTD.'"> '.$StringStrike.$value['NumMov'].$StringStrike2."</td>";
			$t1 = $t1.'<td  style="'.$styleTD.'">';
				if(	($value['fechapago'] !=  '1900-01-01' ) && ($value['fechapago'] != '') ){
					if($value['IdEmpCrea']<>0){
						$t1 = $t1.$StringStrike."<sup>a)</sup>".$value['IdEmpCrea']."<br>".$StringStrike2;
					}
				}

				if($value['observaciones']<>"" ){
				if(($value['FechaUltimaMod'] !=  '01/01/1900') && ($value['FechaUltimaMod'] != '')){		
					if($value['IdEmpModifica']<>0){
						$t1 = $t1.$StringStrike."<sup>b)</sup>".$value['IdEmpModifica']."<br>".$StringStrike2;
					} else {
						// $t1 = $t1.$StringStrike."<sup>b)</sup>*".$value['IdEmpModifica']."<br>".$StringStrike2;
					}
				}
				}

				if (($value['FechaCaptura'] != '01/01/1900') && ($value['FechaCaptura'] !='')) {
					if($value['IdEmpCrea']<>0){
						$t1 = $t1.$StringStrike."<sup>c)</sup>".$value['IdEmpCrea']."<br>".$StringStrike2;
					}	
				}
				

			$t1 = $t1."</td>";
				$t1 = $t1.'<td  style="'.$styleTD.'">';
					//$t1 = $t1.$value['fechapago'].'<br>';
					//$t1 = $t1.$value['FechaUltimaMod'];
					//SOLO EN LA FECHAPAGO la ponemos aunque el usuario no este o este en 0
					if(	($value['fechapago'] != '1900-01-01' ) && ($value['fechapago'] != '') ){
						$t1 = $t1.$StringStrike."<sup>a)</sup>".$value['fechapago'].$StringStrike2.'<br>';
						
					}

					if($value['observaciones']<>"" ){
						if(($value['FechaUltimaMod'] != '01/01/1900') && ($value['FechaUltimaMod'] != '') ){						
							$t1 = $t1.$StringStrike."<sup>b)</sup>".$value['FechaUltimaMod'].$StringStrike2.'<br>';
						}
					}

					if(($value['FechaCaptura'] != '01/01/1900') && ($value['FechaCaptura'] != '') && ($value['IdEmpCrea']<>0) ){						
						$t1 = $t1.$StringStrike."c)".$value['FechaCaptura'].$StringStrike2.'<br>';
					}
				$t1 = $t1."</td>";

				$t1 = $t1.'<td style="'.$styleTD.'">';
				$mystring = $value['Recibo_Folio'];
				$findme   = '+';
				$pos = strpos($mystring, $findme);
				if ($pos !== false) { //tiene notacion +00
					// $t1 = $t1.$StringStrike."<sup>a)</sup>*".$value['numrecibo'].$StringStrike2."<br>";
				} else {
					if($value['Recibo_Folio']<>'' ){
						$t1 = $t1.$StringStrike."<sup>a)</sup>".$value['Recibo_Folio'].$StringStrike2."<br>";
					}
				}
					if($value['ReferenciaOPD']<>''){
						$t1 = $t1.$StringStrike."<sup>b)</sup>".$value['ReferenciaOPD'].$StringStrike2."<br>";
					}
					if($value['Aclaraciones']<>''){
						$t1 = $t1.$StringStrike."<sup>c)</sup>".$value['Aclaraciones'].$StringStrike2;
					}
				$t1 = $t1."</td>";

				$t1 = $t1.'<td style="'.$styleTD.'">';
					if ($value['descripcion'] <> ''){
						$t1 = $t1.$StringStrike."<sup>a)</sup>".$value['descripcion'].$StringStrike2.'<br>';
					}
					
					if($value['observaciones']<>"" ){
						$t1 = $t1.$StringStrike."<sup>b)</sup>".$value['observaciones'].$StringStrike2."<br>";
					}
					if($value['Aclaraciones']<>''){
						$t1 = $t1.$StringStrike."<sup>c)</sup>".$value['Aclaraciones'].$StringStrike2;
					}
				$t1 = $t1."</td>";

				$t1 = $t1.'<td align = "right" style="'.$styleTD.'">';
					// if($value['cargos']<>0){
						$t1 = $t1.$StringStrike.Pesos($value['cargos']).$StringStrike2;
						if ($value['Cancelado']==0){
						$GranCargo = $GranCargo + $value['cargos'];
						}
					// }
				$t1 = $t1."</td>";

				$t1 = $t1.'<td align = "right" style="'.$styleTD.'">';
					// if($value['abonos']<>0){
						$t1 = $t1.$StringStrike.Pesos($value['abonos']).$StringStrike2;
						if ($value['Cancelado']==0){
						$GranAbono = $GranAbono + $value['abonos'];
						}
					// }
				$t1 = $t1."</td>";


				if ($c == 1){ 
					$Calculo_Saldo = $value['Saldo']; // primer saldo
					$t1 = $t1.'<td align = "right" style="'.$styleTD.'">';
							// if($value['Saldo']<>0){
						$t1 = $t1.$StringStrike.Pesos($value['Saldo']).$StringStrike2;
					// }
					$t1 = $t1."</td>";

				} else {
					//CARGOS
					
						
						if ($value['Saldo'] == $value['Saldo_Calculado']){ // lo comparamos para ver si se calculo bien
							$t1 = $t1.'<td align = "right" style="'.$styleTD.'">';
							// if($value['Saldo']<>0){
								$t1 = $t1.$StringStrike.Pesos($value['Saldo']).$StringStrike2;
							// }
							$t1 = $t1."</td>";
						} else { //ERROR en Saldo
							// echo "*".$Diferencia;
							if($full==1){

								
								$DiferenciaDelAjuste = $Calculo_Saldo -  $value['Saldo'] ;

								$t1 = $t1.'<td align = "right" style="'.$styleTD.'">';
							// if($value['Saldo']<>0){
								$t1 = $t1.$StringStrike.Pesos($value['Saldo']).$StringStrike2;
								if ($value['Cancelado'] ==0){
								$t1 = $t1."<br><sup>[".$value['Saldo_Calculado']."]</sup>";
								$Desface=0;
								if ($value['Saldo']>$value['Saldo_Calculado']){
									$Desface = $value['Saldo'] - $value['Saldo_Calculado'];
									$t1 = $t1."<br><sup>* -".$Desface."</sup>";
								} else {
									$Desface = $value['Saldo_Calculado'] - $value['Saldo'];
									$t1 = $t1."<br><sup>* +".$Desface."</sup>";
								}
								
								}

								 
							// }
							$t1 = $t1."</td>";
							} else {

								$t1 = $t1.'<td align = "right" style="'.$styleTD.'">';
								// if($value['Saldo']<>0){
									$t1 = $t1.$StringStrike.Pesos($value['Saldo']).$StringStrike2;
								// }
								$t1 = $t1."</td>";
							}
						// echo "<hr>";						// 
					}
				

	
						
				}



				// $t1 = $t1.'<td align = "right" style="'.$styleTD.'">';
				// 	if($value['Saldo']<>0){
				// 		$t1 = $t1.$StringStrike.Pesos($value['Saldo']).$StringStrike2;
				// 	}
				// $t1 = $t1."</td>";
			$t1 = $t1."</tr>";

	
	$c = $c + 1;
}



}

$GranSaldo = $GranCargo - $GranAbono;
if($full==1){
$t1 = $t1.'<tr color="white" bgcolor="#555555"><td></td><td></td><td></td><td></td><td></td>';
$t1 = $t1.'<td align="right">'.Pesos($GranCargo).'</td>
<td align="right">'.Pesos($GranAbono).'</td>
<td align="right">'.Pesos($GranSaldo)."</td></tr>";
}


}
// $t1 = $t1.'</table>';
return $t1;
}



function ContratoCancelado($contrato, $IdDelegacion, $OriginData){
	require("config.php");	$t1='';
	
                $sql7 = "SELECT cancelado from contratos WHERE numcontrato = '".$contrato."' and OriginData='".$OriginData."'";
                //echo $sql7.'<br>';
				$rc= $Vivienda -> query($sql7);
				if($value = $rc -> fetch_array())
				{
                           if($value['cancelado']==1){
							   return TRUE;
								  //  $t1 = $t1.'<tbody background="icon/cancelado.jpg">';
								//   $t1 = $t1.'<div style="width:100%; height:500px; background:url(icon/cancelado.png)"><table style="width:100%;"><tbody background="icon/cancelado.png"><tbody>';
								  
                           }else{
							//$t1 = $t1.'<tbody>';
								return FALSE;
                           }

                       
                } else {
					return FALSE;
				}
				

}



function EdoCuentaCancelado($contrato, $IdDelegacion){
	require("config.php");	$t1='';
	
                $sql7 = "SELECT cancelado from contratos WHERE numcontrato = '".$contrato."'";
                //echo $sql7.'<br>';

               $ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", $sql7);
               $array = json_decode($ConsultaDATA, true);
               if(is_array($array)){            
                   foreach ($array as $value) {
                       if (isset($value['r'])){// si hay un error
                           $t1 = $t1."*Error: ".$value['r'];
                           $error = $value['r'];
                       } else {
                           if($value['cancelado']==1){
						  //  $t1 = $t1.'<tbody background="icon/cancelado.jpg">';
						  	$t1 = $t1.'<div style="width:100%; height:500px; background:url(icon/cancelado.png)"><table style="width:100%;"><tbody background="icon/cancelado.png">CANCELADO<tbody>';
                           }else{
                            //$t1 = $t1.'<tbody>';
                           }

                       }
                    }
				}
				return $t1;
}



function VEdoCuentaCancelado($contrato, $OriginData){
	require("config.php");	$t1='';
	$t1="";
	$sql7 = "SELECT Cancelado from contratos WHERE numcontrato = '".$contrato."' and  OriginData='".$OriginData."'";
	// echo $sql7.'<br>';
	$rc= $Vivienda -> query($sql7);
	if($value = $rc -> fetch_array())
	{

		if($value['Cancelado']==1){
		//  $t1 = $t1.'<tbody background="icon/cancelado.jpg">';
		// $t1 = $t1.'<div style="width:100%; height:500px; background:url(icon/cancelado.png)"><table style="width:100%;"><tbody background="icon/cancelado.png">CANCELADO<tbody>';
		}else{
		//$t1 = $t1.'<tbody>';
		}

                      
	}
	return $t1;
}



function EdoCuentaInfo2($contrato, $IdDelegacion){
	require("config.php");	$t1='';
	$sql5 = "SELECT ISNULL(idLote,'') AS idLote, ISNULL(IdDelegacion,'') AS IdDelegacion, ISNULL(IdPrograma,'') AS IdPrograma, ISNULL(Folio,'') AS Folio, ISNULL(NumContrato,'') AS NumContrato, ISNULL(solicitud,'') AS solicitud, ISNULL(IdMunicipio,'') AS IdMunicipio, ISNULL(IdColonia,'') AS IdColonia, ISNULL(seccion, '') AS seccion, ISNULL(fila, '') AS fila, ISNULL(manzana,'') AS manzana, ISNULL(lote,'') AS lote, ISNULL(calle,'') AS calle, ISNULL(colonia,'') AS colonia, ISNULL(superficie,'') AS superficie, ISNULL(precio,'') AS precio, ISNULL(IdMandante,'') AS IdMandante
	FROM  lotes
	WHERE NumContrato = '".$contrato."'";
   // echo $sql5.'<br>';
	$ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", $sql5);
	$array = json_decode($ConsultaDATA, true);
	if(is_array($array)){            
		foreach ($array as $value) {
			if (isset($value['r'])){// si hay un error
				// $t1 = $t1.'    Detalles: '.$value['r'];
				$error = $value['r'];
			} else {//si no hay errores escribimos
				$t1 = $t1.'Detalles: TERRENO: (ID '.$value['idLote'].')  Sección: '.$value['seccion'].'   Fila: '.$value['fila'].'  Manzana:  '.$value['manzana'].'  Lote: '.$value['lote'].'   Superficie: '.$value['superficie'].' m2 <br>
				COLONIA: '.$value['colonia'].' - Mandante: ';
				
				$sql6 = "SELECT ISNULL(Mandante,'') AS Mandante
				 from catalogodemandantes WHERE IdMandante = ".$value['IdMandante']."";
				 //ECHO $sql6.'<br>';

				$ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", $sql6);
				$array = json_decode($ConsultaDATA, true);
				if(is_array($array)){            
					foreach ($array as $value) {
						if (isset($value['r'])){// si hay un error
							$t1 = $t1."*Error: ".$value['r'];
							$error = $value['r'];
						} else {//si no hay errores escribimos
							$t1 = $t1.''.$value['Mandante'].'<br>';
							  
						}
					}
				}
				
				
			}
		}

	}










	return $t1;

}




function VEdoCuentaInfo2($contrato, $OriginData){
	require("config.php");	$t1='';
	$sql5 = "
	SELECT
	IFNULL( idLote, '' ) AS idLote,
	IFNULL( IdDelegacion, '' ) AS IdDelegacion,
	IFNULL( IdPrograma, '' ) AS IdPrograma,
	IFNULL( Folio, '' ) AS Folio,
	IFNULL( NumContrato, '' ) AS NumContrato,
	IFNULL( solicitud, '' ) AS solicitud,
	IFNULL( IdMunicipio, '' ) AS IdMunicipio,
	IFNULL( IdColonia, '' ) AS IdColonia,
	IFNULL( seccion, '' ) AS seccion,
	IFNULL( fila, '' ) AS fila,
	IFNULL( manzana, '' ) AS manzana,
	IFNULL( lote, '' ) AS lote,
	IFNULL( calle, '' ) AS calle,
	IFNULL( colonia, '' ) AS colonia,
	IFNULL( superficie, '' ) AS superficie,
	IFNULL( precio, '' ) AS precio,
	IFNULL( IdMandante, '' ) AS IdMandante 

	FROM  lotes
	WHERE NumContrato = '".$contrato."'";
//    echo $sql5.'<br>';
	$t1="";
	$rc= $Vivienda -> query($sql5);
    if($value = $rc -> fetch_array())
	{
				$t1 = $t1.'Detalles: TERRENO: (ID '.$value['idLote'].')  Sección: '.$value['seccion'].'   Fila: '.$value['fila'].'  Manzana:  '.$value['manzana'].'  Lote: '.$value['lote'].'   Superficie: '.$value['superficie'].' m2 <br>
				COLONIA: '.$value['colonia'].' - Mandante: ';
				
				$sql6 = "SELECT IFNULL(Mandante,'') AS Mandante
				 from catalogodemandantes WHERE IdMandante = '".$value['IdMandante']."'";
				//  ECHO $sql6.'<br>';
				 $rc2= $Vivienda -> query($sql6);
				if($value2 = $rc2 -> fetch_array())
				{	
					$t1 = $t1.''.$value2['Mandante'].' ('.$value['IdMandante'].')<br>';
				}
		
	}

	return "".$t1;

}




function EdoCuentaInfo1($contrato, $IdDelegacion){
	require("config.php");
	$sql4 = "SELECT ISNULL(Folio,'') AS Folio, ISNULL(MontoCredito,'') AS MontoCredito, ISNULL(MontoIntMora,'') AS MontoIntMora, ISNULL(MontoPago,'') AS MontoPago, ISNULL(MontoPagoInicial,'') AS MontoPagoInicial, ISNULL(MontoUltimoPago,'') AS MontoUltimoPago, ISNULL(TasaAnualFin,'') AS TasaAnualFin, ISNULL(TasaIntMora,'') AS TasaIntMora, ISNULL(TipoIntMoratorio,'') AS TipoIntMoratorio, ISNULL(TotalPagos,'') AS TotalPagos, ISNULL(IdLote,'') AS IdLote, ISNULL(IdMunicipioL,'') AS IdMunicipioL, ISNULL(IdColoniaL,'') AS IdColoniaL, isnull(seccion,'') as seccion, isnull(fila,'') as fila, 
	ISNULL(Manzana,'') AS Manzana, ISNULL(Lote,'') AS Lote
	from contratos
	WHERE  NumContrato = '".$contrato."'";
	//echo $sql4.'<br>';
	$ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", $sql4);
	$array = json_decode($ConsultaDATA, true);
	$t1='';
	if(is_array($array)){            
		foreach ($array as $value) {
			if (isset($value['r'])){// si hay un error
				$t1 = $t1."*Error: ".$value['r'];
				$error = $value['r'];
			} else {//si no hay errores escribimos
				$t1 = $t1.'Monto del crédito: <b>$'.number_format($value['MontoCredito'], 2, '.', ',').'</b> <br>
									Financiamiento: <b> '.$value['TasaAnualFin'].' </b>% Anual <br>Moratorios <b> '.$value['TasaIntMora'].'</b>% Mensual  <br>Enganche: <b>$'.number_format($value['MontoPagoInicial'], 2, '.', ',').'</b> <br>Mensualidad: <b>$'.number_format($value['MontoPago'], 2, '.', ',').'</b> <br>Núm. Pagos:<b>'.$value['TotalPagos'].'</b> <br>';
								
			}
		}

	}
	return $t1;

}
function VQR($contrato, $OriginData){
	require("config.php");
	$t1 = "";
	$sql4 = "
	select 
	CONCAT(
		'. OriginData,', OriginData,
		'. Delegacion,',  IdDelegacion, ' ', Delegacion, 
		'. Programa,', IdPrograma,' ',Programa,' ',ProgramaGral,
		'. Folio,', Folio, 
		'. NumContrato,',NumContrato, 
		'. IdSolicitante,',IdSolicitante, 
		'. Nombre,',NombreCompleto, 
		'. CURP,',CURP,
		'. FechaContrato,', CAST(FechaContrato as Date), 
		'. NumEscritura,',NumEscritura, 
		'. Saldo, ', Saldo, 
		'. Saldo_Moratorio=', Saldo_Moratorio
		
	) as QR
	
	FROM
		busqueda_vivienda_informacioncontratos 
	WHERE
		numcontrato = '".$contrato."' 
		AND OriginData = '".$OriginData."'
		
	";
	// echo $sql4.'<br>';
	$rc= $Vivienda -> query($sql4);
    if($value = $rc -> fetch_array())
	{
		return $value['QR']	;		
		
	}
	return $t1;

}

function VEdoCuentaInfo1($contrato, $OriginData){
	require("config.php");
	$t1 = "";
	$sql4 = " SELECT
	IFNULL( Folio, '' ) AS Folio,
	IFNULL( MontoCredito, '' ) AS MontoCredito,
	IFNULL( MontoIntMora, '' ) AS MontoIntMora,
	IFNULL( MontoPago, '' ) AS MontoPago,
	IFNULL( MontoPagoInicial, '' ) AS MontoPagoInicial,
	IFNULL( MontoUltimoPago, '' ) AS MontoUltimoPago,
	IFNULL( TasaAnualFin, '' ) AS TasaAnualFin,
	IFNULL( TasaIntMora, '' ) AS TasaIntMora,
	IFNULL( TipoIntMoratorio, '' ) AS TipoIntMoratorio,
	IFNULL( TotalPagos, '' ) AS TotalPagos,
	IFNULL( IdLote, '' ) AS IdLote,
	IFNULL( IdMunicipioL, '' ) AS IdMunicipioL,
	IFNULL( IdColoniaL, '' ) AS IdColoniaL,
	IFNULL( seccion, '' ) AS seccion,
	IFNULL( fila, '' ) AS fila,
	IFNULL( Manzana, '' ) AS Manzana,
	IFNULL( Lote, '' ) AS Lote 
	from contratos
	WHERE  NumContrato = '".$contrato."' and OriginData='".$OriginData."'";
	// echo $sql4.'<br>';
	$rc= $Vivienda -> query($sql4);
    if($value = $rc -> fetch_array())
	{


				$t1 = $t1.'Monto del crédito: <b>$'.number_format($value['MontoCredito'], 2, '.', ',').'</b> <br>
									Financiamiento: <b> '.$value['TasaAnualFin'].' </b>% Anual <br>Moratorios <b> '.$value['TasaIntMora'].'</b>% Mensual  <br>Enganche: <b>$'.number_format($value['MontoPagoInicial'], 2, '.', ',').'</b> <br>Mensualidad: <b>$'.number_format($value['MontoPago'], 2, '.', ',').'</b> <br>Núm. Pagos:<b>'.$value['TotalPagos'].'</b> <br>';
								
		
	}
	return $t1;

}

function PingDelegacion($IdDelegacion){

	$ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", "SELECT count(*) as Resultado from catalogodevpn");
	// var_dump($ConsultaDATA);
	$array = json_decode($ConsultaDATA, true);
	// var_dump($array);
    if(is_array($array)){            
        foreach ($array as $value) {
            if (isset($value['r'])){// si hay un error                
                $error = $value['r'];
				return FALSE;
			} else 
			{
				// echo  $value['Resultado'];
				return TRUE;
			}
		}
	} else {
		// var_dump($array);
		// echo "No es un array";
		return FALSE;
	}
}

function EdoCuenta_Domicilio($IdPrograma, $IdDelegacion, $Folio){
	$sql2 = "
                            SELECT isnull(datosdomicilio.Calle1,'') as Calle1, isnull(datosdomicilio.Calle2,'') as Calle2,
                                isnull(datosdomicilio.CalleyNum,'') as CalleyNum,
                                isnull(datosdomicilio.IdColonia,'') as IdColonia, isnull(colonias.colonia,'') as Colonia
                            FROM datosdomicilio 
                                    inner join colonias on colonias.IdColonia=datosdomicilio.IdColonia
                            WHERE (IdDelegacion = ".$IdDelegacion.") AND (IdPrograma = ".$IdPrograma.") AND (Folio = ".$Folio.")";
                       
                         $ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", $sql2);
                         $array = json_decode($ConsultaDATA, true);
                     
                         if(is_array($array)){            
                             foreach ($array as $value) {
                                 if (isset($value['r'])){// si hay un error
                                     return "*Error: ".$value['r'];
                                     $error = $value['r'];
                                 } else {//si no hay errores escribimos
                                    return 'Domicilio: '.$value['CalleyNum'].' '.$value['Calle1'].' '.$value['Calle2'].'  
                                    , Colonia: '.$value['Colonia'].'
                                    
                                       ';
                                 }
                            }
                        }
}

function EdoCuentaPDF($contrato, $leyenda, $Delegacion, $FechaContrato, $Beneficiario, $t1, $cancelado,$txtQR){
	require_once('pdf/tcpdf.php');
    // ob_end_clean();        

	class PDFEDOCUENTA extends TCPDF {
		public $str;
		public $Delegacion;
		public $NumContrato;
		public $FechaContrato;
		public $Beneficiario;

		public function Header() {
			// Logo
			$image_file = K_PATH_IMAGES.'pdf_logo.jpg';
			$icono = K_PATH_IMAGES.'user.png';
			
			$this->Image($image_file, 15, 5, 60, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);

			// $this->Image($icono, 15, 19, 5, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
			// Set font
			$this->SetFont('helvetica', 'B', 6);
			// Title
		 //    $this->Cell(0, 10, 'INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		 // $this->Text(100,5, 'INSTITUTO TAMAULIPECO DE VIVIENDA Y URBANISMO'); 
		 $this->Text(90,5, ' I N S T I T U T O  T A M A U L I P E C O   D E   V I V I E N DA    Y  U R B A N I S M O '); 
		 $this->SetFont('helvetica', 'B', 10);
		 $this->Text(100,8, '         ESTADO DE CUENTA '); 

		 $this->SetFont('courier', 'R', 7); $this->Text(85,12, ''); $this->SetFont('courier', 'B', 8); $this->Text(90,12, 'Contrato: '.$this->NumContrato); 
		 $this->SetFont('courier', 'R', 6); $this->Text(85,15, ''); $this->SetFont('courier', 'B', 6); $this->Text(100,15, 'Fecha del Contrato:'.$this->FechaContrato); 

		 $this->SetFont('helvetica', 'B', 12);
		//  $this->SetTextColor(0,91,160);
		 $this->SetTextColor(0,0,0);
		 $this->Image($icono, 15, 19, 5, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		 $this->Text(20,19, '  '.$this->Beneficiario); 
		//  $this->Cell(0, 0, $this->Beneficiario, 1, 1, 'C');
		//  $this->MultiCell(0, 0,  $this->Beneficiario , 1, 'C', false, 1);

		}
	
		public function Footer() {
			// Position at 15 mm from bottom
			$this->SetY(-15);
			// Set font
		 //    $line_width = (0.85 / $this->k);
		 //    $this->Ln(1);
		 $this->SetFont('helvetica', 'I', 6);
		 //    $pdf->SetXY(0, 100);                   
		 $this->SetTextColor(0,0,0);
			// Page number
			$linea= "______________________________________________________________________________________________________________________________________________________________";
		 //    $this->Cell(0, 0, $linea, 0, false, 'L', 0, '', 0, false, 'T', 'M');
		 //    $this->Cell(0, 20, $this->str.' | Pag. '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M');
		 // $str = $this->str." |  Pag. ".$this->getAliasNumPage().'/'.$this->getAliasNbPages();
		 $paginas = "Pag. ".$this->getAliasNumPage().'/'.$this->getAliasNbPages();
		 // $this->SetTextColor(205,205,205);
		 $this->Text(15,263, $linea); 
		 // $this->SetTextColor(129,129,129);
		 $this->SetFont('helvetica', 'B', 9); $this->Text(15,266, $paginas); 
		 // $this->SetTextColor(165,165,165);
		 $this->SetFont('helvetica', 'R', 7); 
		 $this->Text(32,266, substr($this->str,0,140)); 
		 $this->Text(32,269, substr($this->str,140,)); 
		 // $this->Cell(0, 20, $this->str.'. Pag. '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'L', 0, '', 0, false, 'T', 'M');
		}
	}       
	
	$pdf = new PDFEDOCUENTA(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetKeywords('Reporte ITAVU');
	//$pdf->SetHeaderData('pdf_logo.jpg', '40','');
	$pdf->SetHeaderData('', '10', '', 'ITAVU  '.$leyenda);
	//$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));
	$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
	$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
	
	// $pdf->setFooterData('', '10', '', 'ITAVU  '.$string);
	$pdf->str = $leyenda;
	$pdf->NumContrato = $contrato." | Delegación: ".$Delegacion;
	$pdf->FechaContrato = $FechaContrato;
	$pdf->Beneficiario = $Beneficiario;
	$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
	
	// set margins
	$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
	$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
	#Establecemos los márgenes izquierda, arriba y derecha:
	$pdf->SetMargins(15, 25 , 15);

	#Establecemos el margen inferior:
	// $pdf->SetAutoPageBreak(true,25);  
	
	// set auto page breaks
   $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
	
	// set image scale factor
	$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
	
	// set some language-dependent strings (optional)
	if (@file_exists(dirname(__FILE__).'pdf/lang/eng.php')) {
		require(dirname(__FILE__).'pdf/lang/eng.php');
		$pdf->setLanguageArray($l);
	}
	// set font
	$pdf->SetFont('helvetica', '', 9);
	// add a page
	$pages = $pdf->getNumPages();
	
	$pdf->AddPage('P', 'LETTER'); //en la tabla de reporte L o P
	$html = "".$t1."";
  
	$pag = $pdf->PageNo();
   //echo $cancelado;
   //  if($cancelado == TRUE){
   // 	 $pdf->Image('icon/cancelado.png', 18, 70,180, 100, '', '', '', false, 300, '', false, false, 0);
   //  }
   // $pdf->text
   $style = array(
	   'border' => true,
	   'padding' => 5,
	   'fgcolor' => array(0,0,0),
	   'bgcolor' => false
   );
   $pdf->write2DBarcode($txtQR, 'QRCODE,H', 167, 33, 35, 35, $style, 'C');

   $pdf->Write(0, ' ', '*', 0, 'C', TRUE, 0, false, false, 0) ;
	$pdf->writeHTML($html, true, false, true, false, '');// Print text using writeHTMLCell()
   
	//ob_end_clean();
   $pdf->Output('EdoCuenta'.$contrato, 'I');


}


function EdoCuenta_InfoFooter($contrato, $nitavu, $IdDelegacion, $myip){
	require("config.php");
	$sql9 = "select CONNECTIONPROPERTY('local_net_address') AS IP, BaseDeDatos, EstacionDeTrabajo from busqueda_vivienda_informacionfinanciera where NumContrato = '".$contrato."'";
	//echo $sql9.'<br>';
		$ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WSContratos", "Test", $sql9);
		$array = json_decode($ConsultaDATA, true);
		
		$string=""; global $string;
		if(is_array($array)){            
			foreach ($array as $value) {
				if (isset($value['r'])){// si hay un error
					$string = $string."*Error: ".$value['r'];
					$string = $value['r'];
				} else {//si no hay errores escribimos
					$ip = substr($value['IP'], 0, 7);
				   
				$string = "Impreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($nitavu)."(".$nitavu.") SRV ".$ip."***********, BD ".$value['BaseDeDatos']."; PC ".$value['EstacionDeTrabajo'].". ";
				historia($nitavu, "EdoCuenta: vio el contrato ".$contrato." en Delegacion con Id ".$IdDelegacion.", desde la ip ".$myip.$string);
				
				}
			}
		}
		return $string;
}


function TablaDinamica_MySQL($tbCont, $sql, $IdDiv, $IdTabla, $Clase, $Tipo, $ClaseTabla='tabla', $titulo='',$orientacion='Portrait',$nombrearchivo='pdf'){
	require("config.php");

	if ($tbCont == '') {
        $r= $conexion -> query($sql);
        $tbCont = '<div id="'.$IdDiv.'" class="'.$Clase.'">
        <table id="'.$IdTabla.'" class="display" style="width:100%" class="'.$ClaseTabla.'" style="font-size:8pt;">';
    $tabla_titulos = ""; $cuantas_columnas = 0;
        $r2 = $conexion -> query($sql); while($finfo = $r2->fetch_field())
        {//OBTENER LAS COLUMNAS

                /* obtener posición del puntero de campo */
                $currentfield = $r2->current_field;       
                $tabla_titulos=$tabla_titulos."<th style='text-transform:uppercase; font-size:9pt;padding:8px; '>".$finfo->name."</th>";
                $cuantas_columnas = $cuantas_columnas + 1;        
        }

        $tbCont = $tbCont."  
        <thead>
        <tr>
            ".$tabla_titulos."  
        </tr>
        </thead>"; //Encabezados
        $tbCont = $tbCont."<tbody class='".$ClaseTabla."'>";
        $cuantas_filas=0;
        $r = $conexion -> query($sql); while($f = $r-> fetch_row())
        {//LISTAR COLUMNAS

            $tbCont = $tbCont."<tr>";        
            for ($i = 1; $i <= $cuantas_columnas; $i++) {      
                $tbCont = $tbCont."<td style='font-size:10pt;padding:8px;'>".$f[$i-1]."</td>";       
                }

            $tbCont = $tbCont."</tr>";
            $cuantas_filas = $cuantas_filas + 1;        
        }

        $tbCont = $tbCont."</tbody>";
        $tbCont = $tbCont."</table></div>";
	} else {
		if ($tbCont == 'Vivienda'){

			$r= $Vivienda -> query($sql);
				$tbCont = '<div id="'.$IdDiv.'" class="'.$Clase.'">
				<table id="'.$IdTabla.'" class="display" style="width:100%" class="tabla" 
				style=""
				>';
			$tabla_titulos = ""; $cuantas_columnas = 0;
				$r2 = $Vivienda -> query($sql); while($finfo = $r2->fetch_field())
				{//OBTENER LAS COLUMNAS

						/* obtener posición del puntero de campo */
						$currentfield = $r2->current_field;       
						$tabla_titulos=$tabla_titulos."<th style='text-transform:uppercase; font-size:9pt;'>".$finfo->name."</th>";
						$cuantas_columnas = $cuantas_columnas + 1;        
				}

				$tbCont = $tbCont."  
				<thead>
				<tr>
					".$tabla_titulos."  
				</tr>
				</thead>"; //Encabezados
				$tbCont = $tbCont."<tbody class='tabla'>";
				$cuantas_filas=0;
				$r = $Vivienda -> query($sql); while($f = $r-> fetch_row())
				{//LISTAR COLUMNAS

					$tbCont = $tbCont."<tr>";        
					for ($i = 1; $i <= $cuantas_columnas; $i++) {      
						$tbCont = $tbCont."<td style=''>".$f[$i-1]."</td>";       
						}

					$tbCont = $tbCont."</tr>";
					$cuantas_filas = $cuantas_filas + 1;        
				}

				$tbCont = $tbCont."</tbody>";
				$tbCont = $tbCont."</table></div>";

		} else {

		}
	}
	echo  $tbCont;

	$Botones = "
	dom: 'Bfrtip',
	buttons: [
		{
			extend:    'copyHtml5',
			text:      '<i class=\"fa fa-files-o\"></i>',
			titleAttr: 'Copy'
		},
		{
			extend:    'excelHtml5',
			text:      '<i class=\"fa fa-file-excel-o\"></i>',
			titleAttr: 'Excel'
		},
		{
		    extend:    'csvHtml5',
		    text:      '<i class=\"fa fa-file-text-o\"></i>',
		    titleAttr: 'CSV'
		},
		{
		    extend:    'pdfHtml5',
		    text:      '<i class=\"fa fa-file-pdf-o\"></i>',
		    titleAttr: 'PDF',
			title: '".$titulo."',
			messageBottom:'Fecha de Impresion: ".date_format( date_create($fecha), 'd-m-Y H:i:s') ."',
			filename: '".$nombrearchivo."',
			orientation: '".$orientacion."'
		}
	]
	";
		switch ($Tipo) {
			case 1: //Scroll Vertical
					echo '<script>
					$(document).ready(function() {
						$("#'.$IdTabla.'").DataTable( {
							"scrollY":        "200px",
							"scrollCollapse": true,
							"paging":         false,
							"language": {
								"decimal": ",",
								"thousands": "."
							}
						} );
					} );
					</script>';
				break;

			case 2: //Scroll Horizontal
					echo '<script>
					$(document).ready(function() {
						$("#'.$IdTabla.'").DataTable( {
							"scrollX": true,
							"scrollCollapse": true,
							"paging":         true,
							"language": {
								"decimal": ",",
								"thousands": "."
								
							},
							"order": [[ 1, "desc" ]]
							,responsive: true
							,'.$Botones.'
						} );
					} );
					</script>';
				break;
			
			default:
				echo '<script>
				$(document).ready(function() {
					$("#'.$IdTabla.'").DataTable( {
						"language": {
							"decimal": ",",
							"thousands": "."
						}
					} );
				} );
				</script>';
		}
       

}


function TicketTengoPermiso($nitavu, $IdTicket){
require("config.php");
$sql="
	select turnadoa as IdDpto,
	(select count(*) from aplicaciones_permisos where nitavu=".$nitavu." and idapp='ap66') as Permiso
	from cp_nuevosdocumentos where cp_nuevosdocumentos.id = ".$IdTicket."
";

//Buscamos en tramites el Tramite (IdTipoTramite) con el CURP
$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
		{
			//Se necesita el IdDependencia
			if ($f['Permiso']>0){
				return TRUE;
			} else {
				return FALSE;
			}
		}
		else { // Si aun no es capturado; 
			return FALSE;
		}


}

function TickesTotal(){
	require("config.php");
	$sql="
	SELECT count(*) as Valor FROM 	ticketLista_html";
	$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{
				//Se necesita el IdDependencia
				return $f['Valor'];
			}
			else { // Si aun no es capturado; 
				return FALSE;
			}
	
	
}

function TickesAbiertos(){
	require("config.php");
	$sql="
	SELECT count(*) as Valor FROM 	ticketLista_html WHERE Estado = 'ABIERTO (0)'";
	$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{
				//Se necesita el IdDependencia
				return $f['Valor'];
			}
			else { // Si aun no es capturado; 
				return FALSE;
			}
	
	
}



function TickesCerrados(){
	require("config.php");
	$sql="
	SELECT count(*) as Valor FROM 	ticketLista_html WHERE Estado = 'CERRADO (1)'";
	$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{
				//Se necesita el IdDependencia
				return $f['Valor'];
			}
			else { // Si aun no es capturado; 
				return FALSE;
			}
	
	
}

function TicketParticipo($nitavu, $IdTicket){
	require("config.php");
	$sql="
	select count(*) as Participacion from ticketsparticipacion Where nitavu=".$nitavu." and IdTicket = ".$IdTicket."";
	$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{
				//Se necesita el IdDependencia
				if ($f['Participacion']>0){
					return TRUE;
				} else {
					return FALSE;
				}
			}
			else { // Si aun no es capturado; 
				return FALSE;
			}
	
	
	}


function ConvertirFechaParaMySQL($strFecha){
	$FechaNacimiento = $strFecha;
	
	//Convertimos la Fecha de Nacimiento a un Formato Compatible para MySQL
	$FechaConFormatoCompatible = str_replace('/', '-', $FechaNacimiento); $FechaConFormatoCompatible = date('Y-m-d', strtotime($FechaConFormatoCompatible)); $FechaNacimiento = $FechaConFormatoCompatible;

	return $FechaConFormatoCompatible;

}

function Pesos($valor){
	return "$ ".number_format($valor,2,'.',',');
}

function GoogleDriveBusca($ruta, $file){
	require("config.php"); 
	$ruta = urlencode($ruta); // codificamos las variables largas
	$file = urlencode($file); // codificamos las variables largas

	$url= $URLwebserviceVivienda.":82/GoogleDrive/GoogleDriveBusqueda.php?ruta=".$ruta."&file=".$file."";
	$DataWb = file_get_contents($url);
	 //echo $DataWb;
	if ($DataWb === false) {
		return FALSE;
	} else {
		return $DataWb; // <-- contenido 
	}

    // header('Content-Type: application/json');
  

}


function DriveArchivoNombre($Archivo){
    // $Archivo = $value['Archivo'];                    
    $pos = strrpos($Archivo, '/', -1); 
    if ($pos === false) {
        
    } else {
        // var_dump($pos);
    }

    $ArchivoFinal = substr($Archivo, $pos +1, (strlen($Archivo) - $pos));
    return $ArchivoFinal;
}


function DriveRuta($Archivo){
    // $Archivo = $value['Archivo'];                    
    $pos = strrpos($Archivo, '/', -1); 
    if ($pos === false) {
        
    } else {
        // var_dump($pos);
    }

	$ArchivoFinal = substr($Archivo, $pos +1, (strlen($Archivo) - $pos));
	$posfinal = strlen($Archivo) - strlen($ArchivoFinal);
	$Ruta = substr($Archivo, 0,$pos);
    return $Ruta;
}


function HistoriaTramite($CURP, $IdPrograma, $IdDelegacion){
	
    require("config.php");
    require_once("lib/funciones.php");

   /* $sql = "
select 
IdPrograma, Programa,
Dependencia, 
IdTipoTramite as TipoTramiteId, 
NombreTramite,DescripcionTramite,
(SELECT Estado from tramites WHERE Curp = '".$CURP."' AND IdTipoTramite = TipoTramiteId) as Estado,
(SELECT NitavuCaptura from tramites WHERE Curp = '".$CURP."'AND IdTipoTramite = TipoTramiteId) as Capturista,
(SELECT nombre from empleados WHERE nitavu = Capturista) as Empleado,
(SELECT DptoCaptura from tramites WHERE Curp = '".$CURP."' AND IdTipoTramite = TipoTramiteId) as DptoCaptura,
(SELECT Fecha from tramites WHERE Curp = '".$CURP."' AND IdTipoTramite = TipoTramiteId) as FechaCaptura,
(SELECT Hora from tramites WHERE Curp = '".$CURP."' AND IdTipoTramite = TipoTramiteId) as HoraCaptura,
(SELECT IdTramite from tramites WHERE Curp = '".$CURP."' AND IdTipoTramite = TipoTramiteId) as FolioTramite
from tramitestipo

WHERE
	IdPrograma='".$IdPrograma."'
order by Dependencia	ASC
";*/

$sql = "SELECT tr.Estado, tr.NitavuCaptura as Capturista, tr.DptoCaptura, tr.Fecha as FechaCaptura, tr.Hora as HoraCaptura, tr.IdTramite as FolioTramite, tr.IdTipoTramite as TipoTramiteId, em.nombre as Empleado, tr.IdPrograma,tt.DescripcionTramite, tt.NombreTramite, 'P' as Proceso
FROM tramites as tr
inner join tramitestipo as tt on tt.IdTipoTramite = tr.IdTipoTramite
inner join empleados as em on em.nitavu = tr.NitavuCaptura
WHERE tr.Curp = '".$CURP."' AND tr.IdPrograma = ".$IdPrograma." and tr.IdDelegacion = ".$IdDelegacion."
union
SELECT tr.Estado, tr.NitavuCaptura as Capturista, tr.DptoCaptura, tr.Fecha as FechaCaptura, tr.Hora as HoraCaptura, tr.IdSolicitud as FolioTramite, tr.IdTipoSolicitud as TipoTramiteId, em.nombre as Empleado, tr.IdPrograma, tt.DescripcionSolicitud, tt.NombreSolicitud, 'S' as Proceso 
from solicitudestemp as tr 
inner join solicitudestipo as tt on tt.IdTipoSolicitud = tr.IdTipoSolicitud
inner join empleados as em on em.nitavu = tr.NitavuCaptura WHERE tr.Curp = '".$CURP."' AND tr.IdPrograma = ".$IdPrograma." and tr.IdDelegacion = ".$IdDelegacion."";

//echo $sql;
$tb="";



$tb =  "<table width='100%' border=0>";
$rc= $conexion -> query($sql);
$Programa = "";
while($f = $rc -> fetch_array()) {
    $Programa  = NombrePrograma($f['IdPrograma']);
    $info = "";
    $Estado = $f['Estado'];    
    if ($Estado == ''){
        $Estado=5;
        $info = "<b title='".$f['DescripcionTramite']."' style='cursor:pointer;'>".$f['NombreTramite']."</b>";
    } //Estado para no se ha realizado
    else {
		$info = "<b title='".$f['DescripcionTramite']."' style='cursor:pointer;'>".$f['NombreTramite']."</b><br><span style='font-size:7pt; font-family:Light;'> iniciado por ".$f['Empleado']." en ".DptoNombre($f['DptoCaptura'])." el ".fecha_larga($f['FechaCaptura'])." a las ".hora12($f['HoraCaptura'])." ";
		$proceso = $f['Proceso'];
		if($f['Proceso']=='P'){
			if(file_exists('tramitesFiles/AcuseSolicitud'.$f['FolioTramite'].'.pdf')==true){
				$info= $info."<a href='tramitesFiles/AcuseSolicitud".$f['FolioTramite'].".pdf' download='AcuseSolicitud.pdf' target='_blank'><img src='icon/pdf.png' style='width:15px;'></a>";
			}	
			if(file_exists('tramitesFiles/TarjetaAutorizacion'.$f['FolioTramite'].'.pdf')==true){
				$info= $info."<a href='tramitesFiles/TarjetaAutorizacion".$f['FolioTramite'].".pdf' download='TarjetaAutorizacion.pdf' target='_blank'><img src='icon/pdf.png' style='width:15px;'></a>";
			}
		}
	
		
		$info= $info." </span>";
	}
	$vinculo = "tr_iniciar.php?edit=".$f['FolioTramite'];
    $tb = $tb.HistoriaTramite_Punto($Estado, $info,$vinculo, $proceso); //Estado, Info

}




echo "<div id='HistoriaTramite' style='width:22%;margin-top:10px;vertical-align: top; display:inline-block;
padding: 10px;border: 1px solid #f0eddf;border-radius: 8px;background-color: #f9f7f5;
padding-bottom: 33px;'>";
echo "<span>".$Programa."</span>";
echo $tb;
echo "</table>";
echo "</div>";
}

function HistoriaTramite_separador(){
    return "<tr >"."<td width=104px valign=middle align=center>"."<img src='icon/tr_lineavertical.png'>"."</td>"."</td>"."</tr>";

}

function HistoriaTramite_Punto($Estado, $Info, $vinculo, $proceso){
	$punto = "";
	if($proceso == 'P'){
		switch ($Estado) {
			case 0:
				$punto = "<a href='".$vinculo."'><img src='icon/tr_o_gris.png' style='width:62px;' title='en curso...' style='cursor:pointer;'></a>";
				break;
			case 1:
				$punto = "<a href='".$vinculo."'><img src='icon/tr_o_azul.png' style='width:62px;' title='ejecutado'  style='cursor:pointer;'></a>";
				break;
			case 2:
				$punto = "<a href='".$vinculo."'><img src='icon/tr_o_verde.png' style='width:62px;' title='aprobado' style='cursor:pointer;'></a>";
				break;
			case 3:
				$punto = "<a href='".$vinculo."'><img src='icon/tr_o_rojo.png' style='width:62px;' title='rechazado' style='cursor:pointer;'></a>";
				break;
			
			case 4:
				$punto = "<a href='".$vinculo."'><img src='icon/tr_o_naranja.png' style='width:62px;' title='se regreso el tramite'  style='cursor:pointer;'></a>";
				break;
			default:
				$punto = "<img src='icon/tr_o_blanco.png' style='width:62px;' title='sin iniciar'  style='cursor:pointer;'>";
				break;
		}
	}else{
		switch ($Estado) {
			case 0:
				$punto = "<a href='".$vinculo."'><img src='icon/tr_o_gris.png' style='width:62px;' title='en curso...' style='cursor:pointer;'></a>";
				break;
			case 1:
				$punto = "<a href='".$vinculo."'><img src='icon/tr_o_verde.png' style='width:62px;' title='aprobado y en evaluación' style='cursor:pointer;'></a>";
				break;
			default:
				$punto = "<img src='icon/tr_o_blanco.png' style='width:62px;' title='sin iniciar'  style='cursor:pointer;'>";
				break;
		}
	}
    // HistoriaTramite_separador();
    return "<tr>"."<td width=104px valign=middle align=center>"
    .$punto
    ."</td>"
    ."<td rowspan=2 valign=top align=left>"
        . "<span style='font-size:8pt; color:gray;'>".$Info."</span>"
    ."</td>"."</tr>".HistoriaTramite_separador();

}

function TramiteValidarContinuidad($CURP, $IdTipoTramite, $IdPrograma, $IdDelegacion){
	require("config.php");
				$Dependencia = TramiteDependencia($IdTipoTramite); //<-- De que tramite depende
				echo "<script>console.log('Dependencia =  ".$Dependencia.",de IdTipoTramite = ".$IdTipoTramite."');</script>";
				if ($Dependencia == ''){//no necesita dependencia, ya que es el primero
					return TRUE;
				} else {//Validamos si el tramite anterior fue aprobado
					$EstadoDelTramite_delaDependencia = TramiteEstado($CURP, $IdPrograma, $IdDelegacion);
					
					echo "<script>console.log('Estado de la Dependencia =  ".$EstadoDelTramite_delaDependencia."');</script>";
					if ($EstadoDelTramite_delaDependencia == 2){ //2 == APROBADO
						return TRUE;

					} else {
						return FALSE;

					}
				}
}

function TramiteDependencia($IdTipoTramite){
	require("config.php");
	//Buscamos en tramites el Tramite (IdTipoTramite) con el CURP
	$sql = "SELECT * FROM tramitestipo WHERE IdTipoTramite='".$IdTipoTramite."'";	
	// echo $sql;
	$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{
				//Se necesita el IdDependencia
				return $f['Dependencia'];
			}
			else { // Si aun no es capturado; 
				return FALSE;
			}
}



function TramiteDptoBloqueado($IdTipoTramite, $IdDpto){
	require("config.php");
	//Buscamos en tramites el Tramite (IdTipoTramite) con el CURP
	$sql = "SELECT * FROM tramitesBloqueos WHERE IdTipoTramite='".$IdTipoTramite."' and IdDpto='".$IdDpto."'";	
	$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{
				//Se necesita el IdDependencia
				return TRUE;
			}
			else { // Si aun no es capturado; 
				return FALSE;
			}
}


function TramiteEstado($CURP, $IdPrograma, $IdDelegacion){
	require("config.php");
	//Buscamos en tramites el Tramite (IdTipoTramite) con el CURP
	$sql = "SELECT * FROM tramites WHERE  Curp='".$CURP."' and IdPrograma = ".$IdPrograma." and IdDelegacion = ".$IdDelegacion."";	
	//echo $sql;
	$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{
				
				return $f['Estado'];
			}
			else { 
				return FALSE;
			}
}

function TramiteTieneDependientes($IdTipoTramite){
	require("config.php");
	//Buscamos en tramites el Tramite (IdTipoTramite) con el CURP
	$sql = "select 
	count(*) as Valor
	from 
	tramiteslistarequisitos
	WHERE IdTipoTramite = ".$IdTipoTramite." and Clase >= 4 and Clase<=13";	
	// echo $sql;
	$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{
				
				return $f['Valor'];
			}
			else { 
				return FALSE;
			}
}
function FormularioTramite($FolioTramite, $CURP, $IdTipoTramite, $Nombres, $Apellido1, $Apellido2, $Sexo, $FechaNacimiento, $StatusCurp, $Usuario, $nivel, $Nacionalidad, $EntidadNacimiento, $numEntidadNacimiento, $IdDelegacion, $IdPrograma){
	require("config.php");
	$Tbl_Dependientes="";

	$ti="";
	
		//Identificar Folio Actual
		if ($FolioTramite <> ''){ // si nos dan un folio buscar y actualizar las variables planteadas para construir el form
			$CURP = TramiteCURP($FolioTramite);
			$IdTipoTramite = TramiteIdTipoTramite($FolioTramite);
			$Nombres = TramiteNombres($FolioTramite);
			$Apellido1 = TramiteApellido1($FolioTramite);
			$Apellido2= TramiteApellido2($FolioTramite);
			$Sexo = TramiteSexo($FolioTramite);
			$FechaNacimiento = TramiteFechaNacimiento($FolioTramite);
			$StatusCurp = TramiteStatusCurp($FolioTramite);
			$Nacionalidad = TramiteNacionalidad($FolioTramite);
			$EntidadNacimiento = TramiteEntidadNacimiento($FolioTramite);
	
		} else { // Si no esta el tramite creamos un folio nuevo
			$FolioTramite = ntramite(TRUE);    
		}
	
		//Guardar en la Primera Entrada, para consumir el Folio                
		if ( issetTramite($FolioTramite) == 0 ) {// si es la primera vez
			$sql = "INSERT INTO tramites(IdTramite, IdTipoTramite, Curp, NitavuCaptura,Fecha,Hora, DptoCaptura, NombreBeneficiario, IdDelegacion, IdPrograma) 
			VALUES ('".$FolioTramite."', '".$IdTipoTramite."', '".$CURP."','".$Usuario."', '".$fecha."','".$hora."', '".$IdDpto."', '".$Nombres." ".$Apellido1." ".$Apellido2."', '".$IdDelegacion."', ".$IdPrograma.")";
			echo $sql;
			if ($conexion->query($sql) == TRUE){                   
				ntramite(FALSE); // desechamos el id tramite actual
				echo "<script>console.log('Iniciando Tramite ' + '".$FolioTramite."')</script>";
				echo "<script>NPush('Se ha Iniciado el Tramite ' + '".$FolioTramite."', 'Plataforma ITAVU')</script>";
				echo 'entro a guardar lso datos del curp recibido';
				//Guardamos los datos principales
				if (GuardarTramiteDato($FolioTramite, 0, $CURP, "text", $Usuario, 0) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
				if (GuardarTramiteDato($FolioTramite, 1, $Nombres, "text", $Usuario, 0) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: Nombres');</script>"; }
				if (GuardarTramiteDato($FolioTramite, 2, $Apellido1, "text", $Usuario, 0) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito:Apellido1');</script>"; }
				if (GuardarTramiteDato($FolioTramite, 3, $Apellido2, "text", $Usuario, 0) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: Apellido2');</script>"; }
				if (GuardarTramiteDato($FolioTramite, 4, $Sexo, "text", $Usuario, 0) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: sexo');</script>"; }
				if (GuardarTramiteDato($FolioTramite, 5, date('d-m-Y', strtotime(str_replace('/', '-', $FechaNacimiento))), "date", $Usuario, 0) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: FechaNacimiento');</script>"; }
				if (GuardarTramiteDato($FolioTramite, 8, $StatusCurp, "text", $Usuario, 0) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: StatusCURP');</script>"; }

				if (GuardarTramiteDato($FolioTramite, 6, $Nacionalidad, "text", $Usuario, 0) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: Nacionalidad');</script>"; }
				if (GuardarTramiteDato($FolioTramite, 7, $EntidadNacimiento, "text", $Usuario, 0) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: Entidad de Nacimiento');</script>"; }
				if (GuardarTramiteDato($FolioTramite, 99, $numEntidadNacimiento, "text", $Usuario, 0) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: Entidad de Nacimiento');</script>"; }

			} else {
				mensaje("ERROR: al guardar el tramite, comuniquese con el Dpto de Informatica, y capture esta pantalla. <br>:".$sql,"tr_iniciar.php");
			}
		}
	
		$NombreDelTramite = TramiteNombre($IdTipoTramite); $DescripcionDelTramite = TramiteDescripcion($IdTipoTramite);
		//historia($Usuario, "tramites: Entro a capturar solicitud de ".$Nombres." ".$Apellido1." ".$Apellido2." con CURP: ".$CURP." del Tramite: ".$NombreDelTramite." con Folio: ".$FolioTramite);
		$Departamento = nitavu_dpto_nombre($Usuario);
		$IdDpto = nitavu_dpto($Usuario);
		$Edad = CalcularEdad($FechaNacimiento);
		//echo "nombre".$NombreDelTramite.'-'.$Departamento.'-'.$IdDpto.'-'.$Edad;
		
		//Prevalidacion
		//$IdPrograma= TramiteIdPrograma($FolioTramite);
		$NombreDelArchivoDePreValidacion = TramitePreValidacionName($IdTipoTramite);
		$Continuo = TRUE;
		if ($NombreDelArchivoDePreValidacion <> '' ){
			include($NombreDelArchivoDePreValidacion); //<-- Este archivo hara las validaciones necesarias, y cambiara $Continuo a FALSE si lo requiere
		} else {
			$Continuo = TRUE; //<-- Si no tiene definido un archivo de prevalidacion no la necesita
		}
		if ($Continuo == TRUE) { //<--- si puede continuar con el tramite
			echo "<script>console.log('entro if ');</script>";

				$Programa = TramiteProgramaNombre($IdPrograma);

				//SOLO SI ES TRÁMITE 2 BUSCAMOS AHORRO PREVIO
				/*if($IdTipoTramite == 2){
					
					//TIENE AHORRO PREVIO CAPTURADO POR SUELO LEGAL 
					if(TramiteAnteriorTieneAhorroPrevio($CURP, $IdPrograma)<>0){
						//SI NO TIENE NADA GUARDADO EN EL DATO
						$ahorro = TramiteAnteriorTieneAhorroPrevio($CURP, $IdPrograma);
						if(TramiteDato($FolioTramite, 91, 0) == ''){
							//INSERTAMOS EL REQUISITO AHORRO PREVIO (91)
							$TipoRequisito = TramiteRequisitoTipo(91);
							GuardarTramiteDato($FolioTramite, 91, $ahorro, $TipoRequisito, $Usuario, 0);
							//AgregarElRequisitoAhorroPrevio($FolioTramite, $ahorro, $nitavu, $fecha, $hora);
						}
						
					}
				
				}*/
				
				$ti = $ti. "<table class=''><tr style='background-color:white;'>
				<td align=center valign=middle width=50% style='background-color:white;'><img src='img/logo_copia.jpg' style='width:70%;'><td>
				<td valign=middle>    
				<b style='font-weight: bold;
				font-size: 22pt;    
				color: #337db2;'><b style='font-size:18pt;'>".$Programa."</b><br><b style='font-size:12pt;'>".$NombreDelTramite."</b><br><label style='font-size:8pt;'>".$DescripcionDelTramite."</label>
				
				<b style='font-size:12pt; font-color:orange; font-weight:bold;'>Folio de Tramite: ".$FolioTramite."</b>
				</td></tr></table>";
			
				$ti = $ti. "<div id='tramitesDatosDelSolicitante'>";
				$ti = $ti. "<table class='tabla'>";
				$ti = $ti. "<tr>";
				$ti = $ti. "<td width=30%><table><tr><td><img src='icon/atencion.png' style='width:18px;'></td><td>Solicitante:</td></tr></table></td>";
					
				$ti = $ti. "<td style=''><b style='font-size:14pt;'>".$Nombres." ".$Apellido1." ".$Apellido2."</b></td></tr>";
				$ti = $ti. "<tr><td style='' colspan=2 ><span class='Elemento'>Sexo: <b style='font-size:10pt;'>".$Sexo."</b></span> <span class='Elemento'> Fecha de Nacimiento: ".$FechaNacimiento." </span>";
				$ti = $ti. "<span class='Elemento'>Estado del CURP: ".$StatusCurp."</span> ";
				$ti = $ti. "<span class='Elemento'>CURP: ".$CURP."</span> ";
			
						//Convertimos la Fecha de Nacimiento a un Formato Compatible para MySQL
						$FechaConFormatoCompatible = str_replace('/', '-', $FechaNacimiento); $FechaConFormatoCompatible = date('Y-m-d', strtotime($FechaConFormatoCompatible)); $FechaNacimiento = $FechaConFormatoCompatible;
			
						$Edad = CalcularEdad($FechaNacimiento);
						$ti = $ti. "<span class='Elemento'>Edad: <b>".$Edad." años </b> "."</span>";
						$ti = $ti. "</td></tr>";
						$ti = $ti. "</table>";
			
						$ti = $ti. "</div>";
			
						$ti = $ti. "<form action='tr_guardar.php' method='POST'  enctype='multipart/form-data' >";
				//variables necesarias
					$ti = $ti. "<input type='hidden' name='CURP' value='".$CURP."'>";
					$ti = $ti. "<input type='hidden' name='IdTipoTramite' value='".$IdTipoTramite."'>";
					$ti = $ti. "<input type='hidden' name='Nombres' value='".$Nombres."'>";
					$ti = $ti. "<input type='hidden' name='Apellidos1' value='".$Apellido1."'>";
					$ti = $ti. "<input type='hidden' name='Apellidos2' value='".$Apellido2."'>";
					$ti = $ti. "<input type='hidden' name='Sexo' value='".$Sexo."'>";
					$ti = $ti. "<input type='hidden' name='FechaNacimiento' value='".$FechaNacimiento."'>";
					$ti = $ti. "<input type='hidden' name='StatusCurp' value='".$StatusCurp."'>";
					$ti = $ti. "<input type='hidden' name='Edad' value='".$Edad."'>";
			
					//separamos por Clases
					$sqlClase = "select distinct IdClase as IdClase,
					(select NombreClase from tramitesrequisitosclase where IdRequisitoClase =  IdClase) as NombreClase	from tramiteslosrequisitos where IdTipoTramite = ".$IdTipoTramite."	";
					//echo $sqlClase;
										
					$rClase= $conexion -> query($sqlClase); while($fClase = $rClase -> fetch_array()) {     
						if ($fClase['IdClase'] >= 4 and  $fClase['IdClase'] <= 13 ){ //Es Dependendientes
							
							$Tbl_Dependientes = $Tbl_Dependientes. "<h3 class='accordion' style='
							color: white;
							background-color: #ccc;
							padding: 5px;
							margin: 0px;
							'><table width=100% ><tr><td width=30px><img src='icon/page.png' style='width:20px;'></td><td>".$fClase['NombreClase']."</td></tr></table></h3>
							<div class='panel'>
							
							";
									//Imprimimos las Categorias
									$sql = "
									select DISTINCT cIdCatRequisito as IdCatRequisitos,
									(select Nombre from tramitesrequisitoscat WHERE tramitesrequisitoscat.IdCatRequisitos = tramiteslosrequisitos.cIdCatRequisito) as Nombre,
									(select color from tramitesrequisitoscat WHERE tramitesrequisitoscat.IdCatRequisitos = tramiteslosrequisitos.cIdCatRequisito) as color
									from tramiteslosrequisitos where IdTipoTramite = ".$IdTipoTramite." and IdClase = ".$fClase['IdClase']." and cIdCatRequisito <> '' 
									-- and cIdCatRequisito<> 4
									";
									$r2= $conexion -> query($sql); while($f2 = $r2 -> fetch_array()) {
										//echo $sql;
										
										$Tbl_Dependientes = $Tbl_Dependientes. "<div  id='Categoria".$f2['IdCatRequisitos']."_".$fClase['IdClase']."'style='background-color:".$f2['color']."; text-aling:left; width:100%;'>"; 
										$IdCategoria = $f2['IdCatRequisitos'];
										$Tbl_Dependientes = $Tbl_Dependientes. "<h1 class='accordion' style='width:100%; margin: 0px;font-size: 10pt;font-family:Light; text-transform: uppercase;'>".$f2['Nombre']."<img src='icon/flecha_abajo.png' style='width:18px; opacity:0.5'></h1>";
										$Tbl_Dependientes = $Tbl_Dependientes. "<div class='panel'>";
											//listamos los elementos de cada categoria
											$sql = "select * from tramiteslosrequisitos WHERE IdTipoTramite=".$IdTipoTramite." AND cIdCatRequisito=".$IdCategoria."  and IdClase=".$fClase['IdClase']."";                
											//echo $sql."<hr>";
											$r3= $conexion -> query($sql); while($f3 = $r3 -> fetch_array()) {                    
												$NombreDelRequisito = $f3['Requisito']; $Descripcion = $f3['Descripcion'];  $type = $f3['type']; $IdRequisito = $f3['cIdRequisito'];
												$IdClase = $fClase['IdClase'];
												$IdCategoria = $f2['IdCatRequisitos'];
												if ($fClase['IdClase'] == 0 and $IdCategoria == 4){
													// si soy el beneficiario ya no me pidas los datos de identificacion ciudadana
												} else { // si soy el conyugue, referencia u otro, pideme el curp y llena los datos
												
												
															if ($nivel == 2 ){// Si eres nivel 2, de vobo, solamente
																$readonly = "disabled";									
															} else {$readonly = "";
															
															}
															$Estado = TramiteEstado($CURP, $IdPrograma, $IdDelegacion);
															if ($Estado == 2){
																$readonly = "disabled";
															}
															if ($IdCategoria == 4 ){
																if ($IdRequisito == 0){ //CURP no
																} else {
																	$readonly = "disabled";
																}
																
															}
															// si el Estado == 2, entonces ya no se puede editar
															if ($f3['Cancelado'] == 0){
																$value = TramiteDato($FolioTramite, $IdRequisito, $fClase['IdClase']);
																switch ($type) {
																	case "file":                                    
																		if ($value <> '' ) { $vinculo = "<a href='".$value."' download='MiRequisito".$IdRequisito.".pdf' target=_blank><img src='icon/pdf.png' style='width:36px;'></a>"; 
																			if ($f3['Opcional'] == 0){
																				$Tbl_Dependientes = $Tbl_Dependientes."<div class='elemento'><table width=100%><tr><td style='width:95%;'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";    
																				$Tbl_Dependientes = $Tbl_Dependientes."<tr><td><form method='POST' enctype='multipart/form-data' id='Form".$IdRequisito."' ><input accept='application/pdf' type='file' name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' onchange='SubirArchivo(".$FolioTramite.", ".$IdRequisito.", ".$IdClase.")' required ".$readonly."></form></td><td width=13px valign=top ><div id='PDF".$IdRequisito."_".$IdClaseo."'>".$vinculo."</div></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																			} else {
																				$Tbl_Dependientes = $Tbl_Dependientes."<div class='elemento'><table width=100%><tr><td style='width:95%;'><label><b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
																				$Tbl_Dependientes = $Tbl_Dependientes."<tr><td><form method='POST' enctype='multipart/form-data' id='Form".$IdRequisito."' ><input  accept='application/pdf' type='file' name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' onchange='SubirArchivo(".$FolioTramite.", ".$IdRequisito.", ".$IdClase.")' ".$readonly."></form></td><td width=13px valign=top ><div id='PDF".$IdRequisito."_".$IdClase."'>".$vinculo."</div></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																			}
																		} else {
																			if ($f3['Opcional'] == 0){
																				$Tbl_Dependientes = $Tbl_Dependientes."<div class='elemento'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";    
																				$Tbl_Dependientes = $Tbl_Dependientes."<table width=100%><tr><td><form method='POST' enctype='multipart/form-data' id='Form".$IdRequisito."' ><input accept='application/pdf' type='file' name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' onchange='SubirArchivo(".$FolioTramite.", ".$IdRequisito.", ".$IdClase.")' required ".$readonly."></form></td><td width=13px valign=top ><div style='' id='PDF".$IdRequisito."_".$IdClase."'></div></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																			} else {
																				$Tbl_Dependientes = $Tbl_Dependientes."<div class='elemento'><label><b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																				$Tbl_Dependientes = $Tbl_Dependientes."<table width=100%><tr><td><form method='POST' enctype='multipart/form-data' id='Form".$IdRequisito."' ><input  accept='application/pdf' type='file' name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' onchange='SubirArchivo(".$FolioTramite.", ".$IdRequisito.", ".$IdClase.")' ".$readonly."></form></td><td width=13px valign=top ><div style='' id='PDF".$IdRequisito."_".$IdClase."'></div></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																			}
																		}
																		$Tbl_Dependientes = $Tbl_Dependientes."</div>";
																	break;
																	case "text":       
																	if ($value <> '' ) {
																		if ($IdRequisito == 0){ //CURP
																			$Tbl_Dependientes = $Tbl_Dependientes."<div class='elemento' style='background-color:#ffdea1;'><table width=100%><tr><td style='width:95%;'><label><b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
																			$Tbl_Dependientes = $Tbl_Dependientes."<tr><td><input  maxlength='18'  type='text' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  onkeypress='BuscaCURP(".$IdRequisito.",".$IdClase.", ".$FolioTramite.");'  name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='R".$IdRequisito."_".$IdClase."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";																		
																			
																			$Tbl_Dependientes = $Tbl_Dependientes."</div>";
																		} else {
																			if ($f3['Opcional'] == 0){
																				$Tbl_Dependientes = $Tbl_Dependientes."<div class='elemento'><table width=100%><tr><td style='width:95%;'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
																				$Tbl_Dependientes = $Tbl_Dependientes."<tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")' name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."'required ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																			} else {
																				$Tbl_Dependientes = $Tbl_Dependientes."<div class='elemento'><table width=100%><tr><td style='width:95%;'><label><b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
																				$Tbl_Dependientes = $Tbl_Dependientes."<tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																			}
																			
																			$Tbl_Dependientes = $Tbl_Dependientes."</div>";
																		}
																	}else{
																		if ($IdRequisito == 0){ //CURP
																			$Tbl_Dependientes = $Tbl_Dependientes."<div class='elemento' style='background-color:#ffdea1;'><label><b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																			$Tbl_Dependientes = $Tbl_Dependientes."<table width=100%><tr><td><input  maxlength='18'  type='text' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  onkeypress='BuscaCURP(".$IdRequisito.",".$IdClase.", ".$FolioTramite.");'  name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='R".$IdRequisito."_".$IdClase."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";																		
																			
																			$Tbl_Dependientes = $Tbl_Dependientes."</div>";
																		}else {
																			if ($f3['Opcional'] == 0){
																				$Tbl_Dependientes = $Tbl_Dependientes."<div class='elemento'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																				$Tbl_Dependientes = $Tbl_Dependientes."<table width=100%><tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")' name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."'required ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																			} else {
																				$Tbl_Dependientes = $Tbl_Dependientes."<div class='elemento'><label><b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																				$Tbl_Dependientes = $Tbl_Dependientes."<table width=100%><tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																			}
																			
																			$Tbl_Dependientes = $Tbl_Dependientes."</div>";
																		}
																	}
																	break;
										
																	case "number":	
																	if ($value <> '' ) {								
																		if ($f3['Opcional'] == 0){
																			$Tbl_Dependientes = $Tbl_Dependientes."<div class='elemento'><table width=100%><tr><td style='width:95%;'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
																			$Tbl_Dependientes = $Tbl_Dependientes."<tr><td><input type='number' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."'required ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																		} else {
																			$Tbl_Dependientes = $Tbl_Dependientes."<div class='elemento'><table width=100%><tr><td style='width:95%;'><label><b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
																			$Tbl_Dependientes = $Tbl_Dependientes."<tr><td><input type='number' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																		}
																	}else{
																		if ($f3['Opcional'] == 0){
																			$Tbl_Dependientes = $Tbl_Dependientes."<div class='elemento'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																			$Tbl_Dependientes = $Tbl_Dependientes."<table width=100%><tr><td><input type='number' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."'required ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																		} else {
																			$Tbl_Dependientes = $Tbl_Dependientes."<div class='elemento'><label><b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																			$Tbl_Dependientes = $Tbl_Dependientes."<table width=100%><tr><td><input type='number' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																		}
																	}
																		$Tbl_Dependientes = $Tbl_Dependientes."</div>";
																	break;
																	
																	case "date":
																	if ($value <> '' ) {	
																		if ($f3['Opcional'] == 0){
																			$Tbl_Dependientes = $Tbl_Dependientes."<div class='elemento'><table width=100%><tr><td style='width:95%;'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
																			$Tbl_Dependientes = $Tbl_Dependientes."<tr><td><input type='date' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")' onchange='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")' name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."'required ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																		} else {
																			$Tbl_Dependientes = $Tbl_Dependientes."<div class='elemento'><table width=100%><tr><td style='width:95%;'><label><b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
																			$Tbl_Dependientes = $Tbl_Dependientes."<tr><td><input type='date' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")' onchange='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																		}
																	}else{
																		if ($f3['Opcional'] == 0){
																			$Tbl_Dependientes = $Tbl_Dependientes."<div class='elemento'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																			$Tbl_Dependientes = $Tbl_Dependientes."<table width=100%><tr><td><input type='date' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")' onchange='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")' name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."'required ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																		} else {
																			$Tbl_Dependientes = $Tbl_Dependientes."<div class='elemento'><label><b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																			$Tbl_Dependientes = $Tbl_Dependientes."<table width=100%><tr><td><input type='date' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")' onchange='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																		}
																	}
																		$Tbl_Dependientes = $Tbl_Dependientes."</div>";
																	break;
																	
																
										
																	case  "select":
																	if ($value <> '' ) {	
																		$Tbl_Dependientes = $Tbl_Dependientes."<div class='elemento'><table width=100%><tr><td style='width:95%;'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
																		$Tbl_Dependientes = $Tbl_Dependientes."<tr><td>";
																		$Tbl_Dependientes = $Tbl_Dependientes."<select  id='".$IdRequisito."_".$IdClase."' onchange='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase."); buscarDependencias(".$IdRequisito.", ".$IdClase.", ".$FolioTramite.");'  name='".$IdRequisito."_".$IdClase."' style='margin-left: 0px; ' ".$readonly.">";
																		
																		$sql = "SELECT * FROM tramitesopcionesrequisitos where IdRequisito=".$IdRequisito."";
																		//echo $sql;
																		//echo "<script>console.log('CONSULTA ".$sql."');</script>"; 
																		$tmp="";
																		$r2x = $conexion -> query($sql);
																		while($fxx = $r2x -> fetch_array())
																		{
																			
															
																			if($fxx['ReqDepende']=='' and $fxx['IdOpcionDepende']=='' || $fxx['ReqDepende']==NULL and $fxx['IdOpcionDepende']==NULL){
																				if($value == $fxx['IdOpcion']){
																					$Tbl_Dependientes = $Tbl_Dependientes. '<option value="'.$fxx['IdOpcion'].'" selected>'.$fxx['Opcion'].'</option>';	
																				}else{
																					$Tbl_Dependientes = $Tbl_Dependientes. '<option value="'.$fxx['IdOpcion'].'">'.$fxx['Opcion'].'</option>';	
																				}
																			}else{
																				
															
																				$ids = explode('_', $value);
																				
																				
																											
																				if($fxx['ReqDepende']==$ids[1] and $fxx['IdOpcionDepende']==$ids[2]){
																					if($value ==$fxx['IdOpcion'].'_'.$fxx['ReqDepende'].'_'.$fxx['IdOpcionDepende']){
																						$Tbl_Dependientes = $Tbl_Dependientes. '<option value="'.$fxx['IdOpcion'].'_'.$fxx['ReqDepende'].'_'.$fxx['IdOpcionDepende'].'" selected>'.$fxx['Opcion'].'</option>';	
		
																					}else{
																						$Tbl_Dependientes = $Tbl_Dependientes. '<option value="'.$fxx['IdOpcion'].'">'.$fxx['Opcion'].'</option>';	
		
																					}
																				}
																			}
																			
																		}
																	}else{
																		$Tbl_Dependientes = $Tbl_Dependientes."<div class='elemento'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																		$Tbl_Dependientes = $Tbl_Dependientes."<table width=100%><tr><td>";
																		$Tbl_Dependientes = $Tbl_Dependientes."<select  id='".$IdRequisito."_".$IdClase."' onchange='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase."); buscarDependencias(".$IdRequisito.", ".$IdClase.", ".$FolioTramite.");'  name='".$IdRequisito."_".$IdClase."' style='margin-left: 0px; ' ".$readonly.">";
																		
																		$sql = "SELECT * FROM tramitesopcionesrequisitos where IdRequisito=".$IdRequisito."";
																		//echo $sql;
																		//echo "<script>console.log('CONSULTA ".$sql."');</script>"; 
																		$tmp="";
																		$r2x = $conexion -> query($sql);
																		while($fxx = $r2x -> fetch_array())
																		{
																			
															
																			if($fxx['ReqDepende']=='' and $fxx['IdOpcionDepende']=='' || $fxx['ReqDepende']==NULL and $fxx['IdOpcionDepende']==NULL){
																				if($value == $fxx['IdOpcion']){
																					$Tbl_Dependientes = $Tbl_Dependientes. '<option value="'.$fxx['IdOpcion'].'" selected>'.$fxx['Opcion'].'</option>';	
																				}else{
																					$Tbl_Dependientes = $Tbl_Dependientes. '<option value="'.$fxx['IdOpcion'].'">'.$fxx['Opcion'].'</option>';	
																				}
																			}else{
																				
															
																				$ids = explode('_', $value);
																				
																				//echo "<script>console.log('Valor".$value."');</script>";
																											
																				if($fxx['ReqDepende']==$ids[1] and $fxx['IdOpcionDepende']==$ids[2]){
																					if($value ==$fxx['IdOpcion'].'_'.$fxx['ReqDepende'].'_'.$fxx['IdOpcionDepende']){
																						$Tbl_Dependientes = $Tbl_Dependientes. '<option value="'.$fxx['IdOpcion'].'_'.$fxx['ReqDepende'].'_'.$fxx['IdOpcionDepende'].'" selected>'.$fxx['Opcion'].'</option>';	
		
																					}else{
																						$Tbl_Dependientes = $Tbl_Dependientes. '<option value="'.$fxx['IdOpcion'].'">'.$fxx['Opcion'].'</option>';	
		
																					}
																				}
																			}
																			
																		}
																	}
																		
																		$Tbl_Dependientes = $Tbl_Dependientes. "</select></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";	
																		$Tbl_Dependientes = $Tbl_Dependientes. "</div>";
										
																	break;
										
										
																	default:
																		
																		if ($f3['Opcional'] == 0){
																			$Tbl_Dependientes = $Tbl_Dependientes."<div class='elemento' style='background-color:orange;'><label>** Tipo de dato no definido; <b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																			$Tbl_Dependientes = $Tbl_Dependientes."<table width=100%><tr><td>*<input type='text' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  name='".$IdRequisito."' id='".$IdRequisito."_".$IdClase."' value='".$value."_".$IdClase."'required></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																		} else {
																			$Tbl_Dependientes = $Tbl_Dependientes."<div class='elemento' style='background-color:orange;'><label>* Tipo de dato no definido; <b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																			$Tbl_Dependientes = $Tbl_Dependientes."<table width=100%><tr><td>*<input type='text' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  name='".$IdRequisito."' id='".$IdRequisito."_".$IdClase."' value='".$value."_".$IdClase."'></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																		}
																		
																		$Tbl_Dependientes = $Tbl_Dependientes."</div>";
																}
																
															
										
															}
														}// if de distincion de beneficiario
														
											}
							
							
											$Tbl_Dependientes = $Tbl_Dependientes. "<br><br><br>";
							
											$Tbl_Dependientes = $Tbl_Dependientes. "</div>";
											$Tbl_Dependientes = $Tbl_Dependientes. "</div>";
											
											
									} // fin de las categoria
									$Tbl_Dependientes = $Tbl_Dependientes. "</div>";

							
						} else {
						$ti = $ti. "<h3 style='
						color: white;
						background-color: #ccc;
						padding: 5px;
						margin: 0px;
						'><table width=100%><tr><td width=30px><img src='icon/page.png' style='width:20px;'></td><td>".$fClase['NombreClase']."</td></tr></table></h3>";
								//Imprimimos las Categorias
								$sql = "
								select DISTINCT cIdCatRequisito as IdCatRequisitos,
								(select Nombre from tramitesrequisitoscat WHERE tramitesrequisitoscat.IdCatRequisitos = tramiteslosrequisitos.cIdCatRequisito) as Nombre,
								(select color from tramitesrequisitoscat WHERE tramitesrequisitoscat.IdCatRequisitos = tramiteslosrequisitos.cIdCatRequisito) as color
								from tramiteslosrequisitos where IdTipoTramite = ".$IdTipoTramite." and IdClase = ".$fClase['IdClase']." and cIdCatRequisito <> '' 
								-- and cIdCatRequisito<> 4
								";
								//echo $sql;
								$r2= $conexion -> query($sql);
								while($f2 = $r2 -> fetch_array()) {									
									$ti = $ti. "<div  id='Categoria".$f2['IdCatRequisitos']."_".$fClase['IdClase']."'style='background-color:".$f2['color']."; text-aling:left; width:100%;'>"; 
									$IdCategoria = $f2['IdCatRequisitos'];
									$ti = $ti. "<h1 class='accordion' style='width:100%; margin: 0px;font-size: 10pt;font-family:Light; text-transform: uppercase;'>".$f2['Nombre']."<img src='icon/flecha_abajo.png' style='width:18px; opacity:0.5'></h1>";
									$ti = $ti. "<div class='panel'>";	
										//listamos los elementos de cada categoria
										$sql = "select * from tramiteslosrequisitos WHERE IdTipoTramite=".$IdTipoTramite." AND cIdCatRequisito=".$IdCategoria."  and IdClase=".$fClase['IdClase']."";                
										//echo $sql."<hr>";
										$r3= $conexion -> query($sql); 
										while($f3 = $r3 -> fetch_array()) {                    
											$NombreDelRequisito = $f3['Requisito'];
											$Descripcion = $f3['Descripcion']; 
											$type = $f3['type']; 
											$IdRequisito = $f3['cIdRequisito'];
											$IdClase = $fClase['IdClase'];
											$IdCategoria = $f2['IdCatRequisitos'];
											if ($fClase['IdClase'] == 0 and $IdCategoria == 4){
												// si soy el beneficiario ya no me pidas los datos de identificacion ciudadana
											} else { // si soy el conyugue, referencia u otro, pideme el curp y llena los datos
										
											
														if ($nivel == 2 ){// Si eres nivel 2, de vobo, solamente
															$readonly = "disabled";									
														} else {$readonly = "";
														
														}
														$Estado = TramiteEstado($CURP, $IdPrograma, $IdDelegacion);
														if ($Estado == 2){
															$readonly = "disabled";
														}
														if ($IdCategoria == 4 ){
															if ($IdRequisito == 0){ //CURP no
															} else {
																$readonly = "disabled";
															}
															
														}
														// si el Estado == 2, entonces ya no se puede editar
														if ($f3['Cancelado'] == 0){
															$value = TramiteDato($FolioTramite, $IdRequisito, $fClase['IdClase']);
															switch ($type) {
																case "file":                                    
																	if ($value <> '' ) { $vinculo = "<a href='".$value."' download='MiRequisito".$IdRequisito.".pdf' target=_blank><img src='icon/pdf.png' style='width:36px;'></a>"; 
																		if ($f3['Opcional'] == 0){
																			$ti = $ti."<div class='elemento'><table width=100%><tr><td style='width:95%;'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";    
																			$ti = $ti."<tr><td><form method='POST' enctype='multipart/form-data' id='Form".$IdRequisito."' ><input accept='application/pdf' type='file' name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' onchange='SubirArchivo(".$FolioTramite.", ".$IdRequisito.", ".$IdClase.")' required ".$readonly."></form></td><td width=13px valign=top ><div id='PDF".$IdRequisito."_".$IdClaseo."'>".$vinculo."</div></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																		} else {
																			$ti = $ti."<div class='elemento'><table width=100%><tr><td style='width:95%;'><label><b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
																			$ti = $ti."<tr><td><form method='POST' enctype='multipart/form-data' id='Form".$IdRequisito."' ><input  accept='application/pdf' type='file' name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' onchange='SubirArchivo(".$FolioTramite.", ".$IdRequisito.", ".$IdClase.")' ".$readonly."></form></td><td width=13px valign=top ><div id='PDF".$IdRequisito."_".$IdClase."'>".$vinculo."</div></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																		}
																	} else {
																		if ($f3['Opcional'] == 0){
																			$ti = $ti."<div class='elemento'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";    
																			$ti = $ti."<table width=100%><tr><td><form method='POST' enctype='multipart/form-data' id='Form".$IdRequisito."' ><input accept='application/pdf' type='file' name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' onchange='SubirArchivo(".$FolioTramite.", ".$IdRequisito.", ".$IdClase.")' required ".$readonly."></form></td><td width=13px valign=top ><div style='' id='PDF".$IdRequisito."_".$IdClase."'></div></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																		} else {
																			$ti = $ti."<div class='elemento'><label><b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																			$ti = $ti."<table width=100%><tr><td><form method='POST' enctype='multipart/form-data' id='Form".$IdRequisito."' ><input  accept='application/pdf' type='file' name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' onchange='SubirArchivo(".$FolioTramite.", ".$IdRequisito.", ".$IdClase.")' ".$readonly."></form></td><td width=13px valign=top ><div style='' id='PDF".$IdRequisito."_".$IdClase."'></div></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																		}
																	}
																	$ti = $ti."</div>";
																break;
																case "text":       
																if ($value <> '' ) {
																	if ($IdRequisito == 0){ //CURP
																		$ti = $ti."<div class='elemento' style='background-color:#ffdea1;'><table width=100%><tr><td style='width:95%;'><label><b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
																		$ti = $ti."<tr><td><input  maxlength='18'  type='text' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  onkeypress='BuscaCURP(".$IdRequisito.",".$IdClase.", ".$FolioTramite.");'  name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='R".$IdRequisito."_".$IdClase."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";																		
																		
																		$ti = $ti."</div>";
																	}else if($IdRequisito == 91){
																		//if(TramiteAnteriorTieneAhorroPrevio($CURP, $IdPrograma)<>0){
																			//echo "<script>console.log('Entro primer if".TramiteAnteriorTieneAhorroPrevio($CURP, $IdPrograma)."');</script>";
																			
																			if ($f3['Opcional'] == 0){
																				$ti = $ti."<div class='elemento'><table width=100%><tr><td style='width:95%;'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
																				$ti = $ti."<tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")' name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."'required readonly></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																			} else {
																				$ti = $ti."<div class='elemento'><table width=100%><tr><td style='width:95%;'><label><b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
																				$ti = $ti."<tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' readonly></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																			}
																		/*}else{
																			if ($f3['Opcional'] == 0){
																				$ti = $ti."<div class='elemento'><table width=100%><tr><td style='width:95%;'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
																				$ti = $ti."<tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")' name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."'required ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																			} else {
																				$ti = $ti."<div class='elemento'><table width=100%><tr><td style='width:95%;'><label><b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
																				$ti = $ti."<tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																			}
																		}*/
																		$ti = $ti."</div>";
																		
																	} else {
																		if ($f3['Opcional'] == 0){
																			$ti = $ti."<div class='elemento'><table width=100%><tr><td style='width:95%;'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
																			$ti = $ti."<tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")' name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."'required ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																		} else {
																			$ti = $ti."<div class='elemento'><table width=100%><tr><td style='width:95%;'><label><b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
																			$ti = $ti."<tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																		}
																		
																		$ti = $ti."</div>";
																	}
																}else{
																	if ($IdRequisito == 0){ //CURP
																		$ti = $ti."<div class='elemento' style='background-color:#ffdea1;'><label><b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																		$ti = $ti."<table width=100%><tr><td><input  maxlength='18'  type='text' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  onkeypress='BuscaCURP(".$IdRequisito.",".$IdClase.", ".$FolioTramite.");'  name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='R".$IdRequisito."_".$IdClase."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";																		
																		
																		$ti = $ti."</div>";
																	}else if($IdRequisito == 91){
																		//if(TramiteAnteriorTieneAhorroPrevio($CURP, $IdPrograma)<>0){
																			//echo "<script>console.log('Entro primer if".TramiteAnteriorTieneAhorroPrevio($CURP, $IdPrograma)."');</script>";
																			
																			if ($f3['Opcional'] == 0){
																				$ti = $ti."<div class='elemento'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																				$ti = $ti."<table width=100%><tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")' name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."'required readonly></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																			} else {
																				$ti = $ti."<div class='elemento'><label><b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																				$ti = $ti."<table width=100%><tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' readonly></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																			}
																		/*}else{
																			if ($f3['Opcional'] == 0){
																				$ti = $ti."<div class='elemento'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																				$ti = $ti."<table width=100%><tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")' name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."'required ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																			} else {
																				$ti = $ti."<div class='elemento'><label><b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																				$ti = $ti."<table width=100%><tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																			}
																		}*/
																		$ti = $ti."</div>";
																	} else {
																		if ($f3['Opcional'] == 0){
																			$ti = $ti."<div class='elemento'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																			$ti = $ti."<table width=100%><tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")' name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."'required ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																		} else {
																			$ti = $ti."<div class='elemento'><label><b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																			$ti = $ti."<table width=100%><tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																		}
																		
																		$ti = $ti."</div>";
																	}
																}
																break;
									
																case "number":	
																if ($value <> '' ) {								
																	if ($f3['Opcional'] == 0){
																		$ti = $ti."<div class='elemento'><table width=100%><tr><td style='width:95%;'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
																		$ti = $ti."<tr><td><input type='number' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."'required ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																	} else {
																		$ti = $ti."<div class='elemento'><table width=100%><tr><td style='width:95%;'><label><b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
																		$ti = $ti."<tr><td><input type='number' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																	}
																}else{
																	if ($f3['Opcional'] == 0){
																		$ti = $ti."<div class='elemento'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																		$ti = $ti."<table width=100%><tr><td><input type='number' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."'required ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																	} else {
																		$ti = $ti."<div class='elemento'><label><b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																		$ti = $ti."<table width=100%><tr><td><input type='number' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																	}
																}
																	$ti = $ti."</div>";
																break;
																
																case "date":
																if ($value <> '' ) {	
																	if ($f3['Opcional'] == 0){
																		$ti = $ti."<div class='elemento'><table width=100%><tr><td style='width:95%;'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
																		$ti = $ti."<tr><td><input type='date' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")' onchange='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")' name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."'required ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																	} else {
																		$ti = $ti."<div class='elemento'><table width=100%><tr><td style='width:95%;'><label><b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
																		$ti = $ti."<tr><td><input type='date' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")' onchange='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																	}
																}else{
																	if ($f3['Opcional'] == 0){
																		$ti = $ti."<div class='elemento'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																		$ti = $ti."<table width=100%><tr><td><input type='date' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")' onchange='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")' name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."'required ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																	} else {
																		$ti = $ti."<div class='elemento'><label><b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																		$ti = $ti."<table width=100%><tr><td><input type='date' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")' onchange='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  name='".$IdRequisito."_".$IdClase."' id='".$IdRequisito."_".$IdClase."' value='".$value."' ".$readonly."></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																	}
																}
																	$ti = $ti."</div>";
																break;
																
															
									
																case  "select":
																if ($value <> '' ) {	
																	$ti = $ti."<div class='elemento'><table width=100%><tr><td style='width:95%;'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
																	$ti = $ti."<tr><td>";
																	$ti = $ti."<select  id='".$IdRequisito."_".$IdClase."' onchange='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase."); buscarDependencias(".$IdRequisito.", ".$IdClase.", ".$FolioTramite.");'  name='".$IdRequisito."_".$IdClase."' style='margin-left: 0px; ' ".$readonly.">";
																	
																	$sql = "SELECT * FROM tramitesopcionesrequisitos where IdRequisito=".$IdRequisito."";
																	//echo $sql;
																	//echo "<script>console.log('CONSULTA ".$sql."');</script>"; 
																	$tmp="";
																	$r2x = $conexion -> query($sql);
																	while($fxx = $r2x -> fetch_array())
																	{
																		
														
																		if($fxx['ReqDepende']=='' and $fxx['IdOpcionDepende']=='' || $fxx['ReqDepende']==NULL and $fxx['IdOpcionDepende']==NULL){
																			if($value == $fxx['IdOpcion']){
																				$ti = $ti. '<option value="'.$fxx['IdOpcion'].'" selected>'.$fxx['Opcion'].'</option>';	
																			}else{
																				$ti = $ti. '<option value="'.$fxx['IdOpcion'].'">'.$fxx['Opcion'].'</option>';	
																			}
																		}else{
																			
														
																			$ids = explode('_', $value);
																			
																			//echo "<script>console.log('Valor".$value."');</script>";
																										
																			if($fxx['ReqDepende']==$ids[1] and $fxx['IdOpcionDepende']==$ids[2]){
																				if($value ==$fxx['IdOpcion'].'_'.$fxx['ReqDepende'].'_'.$fxx['IdOpcionDepende']){
																					$ti = $ti. '<option value="'.$fxx['IdOpcion'].'_'.$fxx['ReqDepende'].'_'.$fxx['IdOpcionDepende'].'" selected>'.$fxx['Opcion'].'</option>';	
	
																				}else{
																					$ti = $ti. '<option value="'.$fxx['IdOpcion'].'">'.$fxx['Opcion'].'</option>';	
	
																				}
																			}
																		}
																		
																	}
																}else{
																	$ti = $ti."<div class='elemento'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																	$ti = $ti."<table width=100%><tr><td>";
																	$ti = $ti."<select  id='".$IdRequisito."_".$IdClase."' onchange='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase."); buscarDependencias(".$IdRequisito.", ".$IdClase.", ".$FolioTramite.");'  name='".$IdRequisito."_".$IdClase."' style='margin-left: 0px; ' ".$readonly.">";
																	
																	$sql = "SELECT * FROM tramitesopcionesrequisitos where IdRequisito=".$IdRequisito."";
																	//echo $sql;
																	//echo "<script>console.log('CONSULTA ".$sql."');</script>"; 
																	$tmp="";
																	$r2x = $conexion -> query($sql);
																	while($fxx = $r2x -> fetch_array())
																	{
																		
														
																		if($fxx['ReqDepende']=='' and $fxx['IdOpcionDepende']=='' || $fxx['ReqDepende']==NULL and $fxx['IdOpcionDepende']==NULL){
																			if($value == $fxx['IdOpcion']){
																				$ti = $ti. '<option value="'.$fxx['IdOpcion'].'" selected>'.$fxx['Opcion'].'</option>';	
																			}else{
																				$ti = $ti. '<option value="'.$fxx['IdOpcion'].'">'.$fxx['Opcion'].'</option>';	
																			}
																		}else{
																			
														
																			$ids = explode('_', $value);
																			
																			//echo "<script>console.log('Valor".$value."');</script>";
																										
																			if($fxx['ReqDepende']==$ids[1] and $fxx['IdOpcionDepende']==$ids[2]){
																				if($value ==$fxx['IdOpcion'].'_'.$fxx['ReqDepende'].'_'.$fxx['IdOpcionDepende']){
																					$ti = $ti. '<option value="'.$fxx['IdOpcion'].'_'.$fxx['ReqDepende'].'_'.$fxx['IdOpcionDepende'].'" selected>'.$fxx['Opcion'].'</option>';	
	
																				}else{
																					$ti = $ti. '<option value="'.$fxx['IdOpcion'].'">'.$fxx['Opcion'].'</option>';	
	
																				}
																			}
																		}
																		
																	}
																}
																	
																	$ti = $ti. "</select></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";	
																	$ti = $ti. "</div>";
									
																break;
									
									
																default:
																	
																	if ($f3['Opcional'] == 0){
																		$ti = $ti."<div class='elemento' style='background-color:orange;'><label>** Tipo de dato no definido; <b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																		$ti = $ti."<table width=100%><tr><td>*<input type='text' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  name='".$IdRequisito."' id='".$IdRequisito."_".$IdClase."' value='".$value."_".$IdClase."'required></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																	} else {
																		$ti = $ti."<div class='elemento' style='background-color:orange;'><label>* Tipo de dato no definido; <b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
																		$ti = $ti."<table width=100%><tr><td>*<input type='text' onkeyup='GuardarDato(".$FolioTramite.",".$IdRequisito.", ".$IdClase.")'  name='".$IdRequisito."' id='".$IdRequisito."_".$IdClase."' value='".$value."_".$IdClase."'></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."_".$IdClase."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
																	}
																	
																	$ti = $ti."</div>";
															}
															
														
									
														}
													}// if de distincion de beneficiario
													
										}
						
						
										$ti = $ti. "<br><br><br>";
						
										$ti = $ti. "</div>";
										$ti = $ti. "</div>";
								} // fin de las categoria
					}

				}// nodependientes
				// $Tbl_Dependientes = $Tbl_Dependientes."</div>";
				
				if ($Tbl_Dependientes <> ''){
				
				$Tbl_Dependientes = "<h3 class='accordion' style='
				color: white;
				background-color: #ccc;
				padding: 5px;
				margin: 0px;
				width:100%;
				'><table width=100% ><tr><td width=30px><img src='icon/page.png' style='width:20px;'></td><td>DEPENDIENTES!</td></tr></table></h3><div class='panel'> "
				.$Tbl_Dependientes."</div>";
				}

					
			
					$ti = $ti.$Tbl_Dependientes;
			
					$ti = $ti. "</form>";
					$ti = $ti."<hr>".TramiteLeyendaInferior($FolioTramite)."";
					

					
	
		return $ti;
	} // no paso la prevalidacion // en la prevalidacion incluir el mensaje
}

function CalcularEdad( $fecha ) {
    list($Y,$m,$d) = explode("-",$fecha);
    return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
}

function TramiteLeyendaInferior($id){	
	require("config.php");
		$sql = "select * from tramites where IdTramite='".$id."'";	
		// //echo $sql;
		$leyenda = "";
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{		
				$leyenda = "<label style='font-size:8pt;'>* Captura iniciada por ".nitavu_nombre($f['NitavuCaptura'])."(".$f['NitavuCaptura'].") el ".fecha_larga($f['Fecha'])." a las ".hora12($f['Hora'])." en ".DptoNombre($f['DptoCaptura'])."</label>";
				return $leyenda;
			}
		 else {return FALSE;}
}


function DptoNombre($id){	
	require("config.php");
		$sql = "select nombre from cat_gerarquia where id='".$id."'";	
		// //echo $sql;
		// $leyenda = "";
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{	return $f['nombre'];
			}
		 else {return FALSE;}
}

function DptoNombreCorto($id){	
	require("config.php");
		$sql = "select NomCorto from cat_gerarquia where id='".$id."'";	
		// //echo $sql;
		// $leyenda = "";
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{	return $f['NomCorto'];
			}
		 else {return FALSE;}
}

function issetTramite($id){	
	require("config.php");
		$sql = "select count(*) as Valor from tramites where IdTramite='".$id."'";	
		// //echo $sql;
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['Valor'];
			}
		 else {return FALSE;}
}

function TramitePreValidacionName($IdTipoTramite){	
	require("config.php");
		$sql = "select preValidacion as Valor from tramitestipo where IdTipoTramite='".$IdTipoTramite."'";	
		// //echo $sql;
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['Valor'];
			}
		 else {return FALSE;}
}

function TramiteValidacionName($IdTipoTramite){	
	require("config.php");
		$sql = "select Validacion as Valor from tramitestipo where IdTipoTramite='".$IdTipoTramite."'";	
		// //echo $sql;
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['Valor'];
			}
		 else {return FALSE;}
}

function TramiteEjecucionName($IdTipoTramite){	
	require("config.php");
		$sql = "select Ejecucion as Valor from tramitestipo where IdTipoTramite='".$IdTipoTramite."'";	
		// //echo $sql;
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['Valor'];
			}
		 else {return FALSE;}
}

function TramiteCURP($id){	
	require("config.php");
		$sql = "select Curp as Valor from tramites where IdTramite='".$id."'";	
		//echo $sql;
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['Valor'];
			}
		 else {return FALSE;}
}

function TramiteRequisitoOpcion($IdRequisito, $IdOpcion){	
	require("config.php");
		$sql = "select Opcion as Valor from tramitesopcionesrequisitos where IdRequisito='".$IdRequisito."' AND IdOpcion='".$IdOpcion."'";	
		// //echo $sql;
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['Valor'];
			}
		 else {return FALSE;}
}


function TramiteRequisitoTipo($id){	
	require("config.php");
		$sql = "select TipoRequisito as Valor from tramitesrequisitos where IdRequisito='".$id."'";	
		// //echo $sql;
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['Valor'];
			}
		 else {return FALSE;}
}


function TramiteIdTipoTramite($id){	
	require("config.php");
		$sql = "select IdTipoTramite as Valor from tramites where IdTramite='".$id."'";	
		//echo $sql;
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['Valor'];
			}
		 else {return FALSE;}
}

function TramiteIdPrograma($FolioTramite){	
	require("config.php");
		$sql = "select IdPrograma as Valor from tramites where IdTramite = ".$FolioTramite."";	
		//echo $sql;
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['Valor'];
			}
		 else {return FALSE;}
}


function TramiteProgramaNombre($IdPrograma){	
	require("config.php");
		$sql = "select Programa as Valor from programa where IdPrograma='".$IdPrograma."'";	
		// //echo $sql;
		$rc= $Vivienda -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['Valor'];
			}
		 else {return FALSE;}
}

function TramiteNombres($id){	
	require("config.php");
		$sql = "select Dato as Valor from tramitesinformacion where IdTramite='".$id."' AND IdRequisito=1";	//1 = Nombres
		// //echo $sql;
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['Valor'];
			}
		 else {return FALSE;}
}


function TramiteApellido1($id){	
	require("config.php");
		$sql = "select Dato as Valor from tramitesinformacion where IdTramite='".$id."' AND IdRequisito=2";	//2 = Apellido1
		// //echo $sql;
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['Valor'];
			}
		 else {return FALSE;}
}

function TramiteApellido2($id){	
	require("config.php");
		$sql = "select Dato as Valor from tramitesinformacion where IdTramite='".$id."' AND IdRequisito=3";	//3 = Apellido2
		// //echo $sql;
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['Valor'];
			}
		 else {return FALSE;}
}

function TramiteEntidadNacimiento($id){	
	require("config.php");
		$sql = "select Dato as Valor from tramitesinformacion where IdTramite='".$id."' AND IdRequisito=7";	//3 = Apellido2
		// //echo $sql;
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['Valor'];
			}
		 else {return FALSE;}
}



function TramiteNacionalidad($id){	
	require("config.php");
		$sql = "select Dato as Valor from tramitesinformacion where IdTramite='".$id."' AND IdRequisito=6";	//3 = Apellido2
		// //echo $sql;
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['Valor'];
			}
		 else {return FALSE;}
}

function TramiteSexo($id){	
	require("config.php");
		$sql = "select Dato as Valor from tramitesinformacion where IdTramite='".$id."' AND IdRequisito=4";	//4 = Sexo
		// //echo $sql;
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['Valor'];
			}
		 else {return FALSE;}
}

function TramiteFechaNacimiento($id){	
	require("config.php");
		$sql = "select Dato as Valor from tramitesinformacion where IdTramite='".$id."' AND IdRequisito=5";	//
		// //echo $sql;
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['Valor'];
			}
		 else {return FALSE;}
}

function TramiteStatusCurp($id){	
	require("config.php");
		$sql = "select Dato as Valor from tramitesinformacion where IdTramite='".$id."' AND IdRequisito=8";	//
		// //echo $sql;
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['Valor'];
			}
		 else {return FALSE;}
}

function issetTramiteDato($FolioTramite, $IdRequisito, $IdClase){	
	require("config.php");
		$sql = "select count(*) as Valor from tramitesinformacion where IdTramite='".$FolioTramite."' AND IdRequisito='".$IdRequisito."' and Clase=".$IdClase."";	
		//echo $sql; 
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['Valor'];
			}
		 else {return FALSE;}
}

function GuardarTramiteDato($FolioTramite, $IdRequisito, $Dato, $TipoRequisito, $NitavuCaptura, $IdClase){	
	require("config.php");
	 //Para Guardar los Datos Iniciales
	 if (issetTramiteDato($FolioTramite, $IdRequisito, $IdClase) == 0) {//identificamos si ya teiene dato
		//un insert
		return TramiteDatoInsert($FolioTramite, $IdRequisito, $Dato, $TipoRequisito, $NitavuCaptura, $IdClase);
	 } else {
		 //un update
		 return TramiteDatoUpdate($FolioTramite, $IdRequisito, $Dato, $NitavuCaptura, $IdClase);
	 }
}

function TramiteDatoInsert($FolioTramite, $IdRequisito, $Dato, $TipoRequisito, $NitavuCaptura, $IdClase){
	require("config.php");

	if($IdRequisito == 0){
		if(validarCurpUtilizado($FolioTramite,$Dato)<>0){
			echo "<script>$.toast({
				heading: 'Warning',
				text: 'Error:  Error al Guardar el Curp ".$txtCURP.",No pudes duplicar un CURP en un mismo trámite!;)',
				showHideTransition: 'plain',
				icon: 'warning'
			});</script>";
        }else{
			$sql = "INSERT INTO tramitesinformacion(IdTramite, IdRequisito, Dato, NitavuCaptura, Fecha, Hora, Clase) 
			VALUES('".$FolioTramite."', '".$IdRequisito."', '".$Dato."', '".$NitavuCaptura."','".$fecha."', '".$hora."', ".$IdClase.")";	
				//echo $sql;
			if ($conexion->query($sql) == TRUE){
				historia($NitavuCaptura,"tramites: Guardo en el Tramite con Folio " . $FolioTramite." el Requisito con Id ".$IdRequisito.", Dato: ".$Dato." de la Clase ".$IdClase."");
				return TRUE;	
			}
			else {
				return FALSE;
			}
		
		}
	}else{
		$sql = "INSERT INTO tramitesinformacion(IdTramite, IdRequisito, Dato, NitavuCaptura, Fecha, Hora, Clase) 
			VALUES('".$FolioTramite."', '".$IdRequisito."', '".$Dato."', '".$NitavuCaptura."','".$fecha."', '".$hora."', ".$IdClase.")";	
		//echo $sql; 					
		if ($conexion->query($sql) == TRUE){
			historia($NitavuCaptura,"tramites: Guardo en el Tramite con Folio " . $FolioTramite." el Requisito con Id ".$IdRequisito.", Dato: ".$Dato." de la Clase ".$IdClase."");
			return TRUE;	
		}
		else {
			return FALSE;
		}
	}
}

function TramiteDatoUpdate($FolioTramite, $IdRequisito, $Dato, $NitavuCaptura, $IdClase){
	require("config.php");
	//Obtener el valor actual
	$DatoActual = TramiteDato($FolioTramite, $IdRequisito, $IdClase);
	$sql = "UPDATE tramitesinformacion SET	Dato = '".$Dato."'	WHERE IdTramite = '".$FolioTramite."' AND IdRequisito='".$IdRequisito."' and Clase='".$IdClase."'";
	// echo $sql; 
	// echo "<script> console.log('".$sql."');</script>";
	
	if ($conexion->query($sql) == TRUE){
		historia($NitavuCaptura,"tramites: Actualizo en el Tramite con Folio " . $FolioTramite." el Requisito con Id ".$IdRequisito." de ".$DatoActual." a <b> ".$Dato."</b> de la Clase ".$IdClase);
		return TRUE;	
	}
	else {
		return FALSE;
	}

		
	
}

function TramiteDato($FolioTramite, $IdRequisito, $IdClase){
	require("config.php");	
	$sql = "select Dato from tramitesinformacion WHERE IdTramite='".$FolioTramite."'  AND IdRequisito='".$IdRequisito."' and Clase = ".$IdClase."";
	//echo $sql;
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
		{				
			return $f['Dato'];
		}
	 else {return FALSE;}

}

function TramiteActaHijos($FolioTramite){
	require("config.php");	
	$sql = "select Dato from tramitesinformacion WHERE IdTramite='".$FolioTramite."'  AND IdRequisito=30";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
		{				
			return $f['Dato'];
		}
	 else {return FALSE;}

}



function TramiteNombre($id){	
	require("config.php");
		$sql = "select NombreTramite as Valor from tramitestipo where IdTipoTramite='".$id."'";	
		//echo $sql;
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['Valor'];
			}
		 else {return FALSE;}
}

function TramiteDescripcion($id){	
	require("config.php");
		$sql = "select DescripcionTramite as Valor from tramitestipo where IdTipoTramite='".$id."'";	

		//echo $sql;
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{				
				return $f['Valor'];
			}
		 else {return FALSE;}
}



function seguimientomoratorio_add($IdDelegacion, $usuario, $cantidad,$Contratos){
	require("config.php");
	historia($usuario,"seguimientomoratorio: IdDelegacion = ".$IdDelegacion."(".DelegacionNombre($IdDelegacion)."), $ ".$cantidad."");
	$sql = "INSERT INTO seguimientomoratorio(IdDelegacion,nitavu,Moratorio, fecha, hora,Contratos) 
			VALUES(".$IdDelegacion.", '".$usuario."', ".$cantidad.", '".$fecha."', '".$hora."',".$Contratos.")";	
			// //echo $sql;					
	if ($conexion->query($sql) == TRUE){
		return TRUE;	
	}
	else {
		return FALSE;
	}

		
	
}


function DatosDeConeccion($IdDelegacion){
    $sql = "select * from catalogodevpn WHERE IdDelegacion='".$IdDelegacion."'";
    $info = "";
    $sqlData = DatosVivienda("0", "MONITOR", "PingDB", $sql);
    if ($sqlData == FALSE){
        return FALSE;
    } else {
        // echo $IdDelegacion.">".$sqlData."<br>";
        $array = json_decode($sqlData, true);    
        if(is_array($array)){        
            foreach ($array as $value) {            
                $info = $info."IdDelegacion: ".$value['IdDelegacion'].", "; 
                $info = $info."Ip de intento de coneccion: ".$value['IpPrivada'].", "; 
                $info = $info."Servidor: ".$value['NombreDelServer'].", "; 
                $info = $info."Instancia: ".$value['NomInstancia'].", "; 
                $info = $info."Puerto: ".$value['NumPuerto'].", "; 
                $info = $info."BD: ".$value['NombreBD'].""; 
                

            }
            return LimpiarComillas($info);


            
        } else {
            return FALSE;
        }
    }
    

    
    

}


function PingBD($IdDelegacion){
    $sql = "select top 1 * FROM lotes";
	$sqlData = DatosViviendaLarge($IdDelegacion, "MONITOR", "PingDB", $sql);
	
    if ($sqlData == FALSE){
        return FALSE;
    } else {
        // echo $IdDelegacion.">".$sqlData."<br>";
        $array = json_decode($sqlData, true);    
        if(is_array($array)){        
            return TRUE;
            
        } else {
            return FALSE;
        }
    }
    
    if ($IdDelegacion == '65'){ // SI ES LA ULTIMA DECIR RESUMEN
        echo "
        <script>
            var Inforesumen = $('#MonitorDelegacionesResumen').val();
            habla('No he podido conectarme a las Delegaciones de ' + Inforesumen + ', hay algún problema de conección, He guardado lineas en la historia. Puedes consultarlas en el Reporte llamado I.F.C, Incidencias de Fallas de Conección, El resto de las delegación hubo éxito.');
        </script>
        ";
    
    }
    
    

}

function ProgramaNombre($id){
	$ejercicio = date('Y');
	require("config.php");
		$sql = "
		select * from cat_programa where IdPrograma='".$id."'";	
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{
				// echo "<b style='font-size:9pt; font-family:Light'>".$f['Programa']."</b><br>";
				// echo "<label style='font-size:7pt;'>".$f['Descripcion'];
				// echo "<br><br>Fecha de Captura detectada: ".$f['FechaCaptura']."...".$f['FechaEnvio'];
				// echo "</label>";
				return $f['Programa'];
			}
		 else {return FALSE;}
}

function ProgramaInfo($id){
	$ejercicio = date('Y');
	require("config.php");
		$sql = "
		select * from cat_programa where IdPrograma='".$id."'";	
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{
				echo "<b style='font-size:9pt; font-family:Light'>".$f['Programa']."</b><br>";
				echo "<label style='font-size:7pt;'>".$f['Descripcion'];
				echo "<br><br>Fecha de Captura detectada: ".$f['FechaCaptura']."...".$f['FechaEnvio'];
				echo "</label>";
				
			}
		 else {return FALSE;}
}
function DelegacionNombre($id){
	$ejercicio = date('Y');
	require("config.php");
		$sql = "
		select * from cat_delegaciones where id='".$id."'";	
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{
				return $f['nombre'];
			}
		 else {return FALSE;}
}

function DelegacionRutaDeRespaldo($id){
	$ejercicio = date('Y');
	require("config.php");
		$sql = "
		select * from cat_delegaciones where id='".$id."'";	
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{
				return $f['RutaRespaldo'];
			}
		 else {return '';}
}

function DelegacionRutaDrive($id){
	$ejercicio = date('Y');
	require("config.php");
		$sql = "
		select * from cat_delegaciones where id='".$id."'";	
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{
				return $f['GoogleDriveERuta'];
			}
		 else {return '';}
}

function DelegacionNombreDb($id){
	$ejercicio = date('Y');
	require("config.php");
		$sql = "
		select * from cat_delegaciones where id='".$id."'";	
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{
				return $f['dbname'];
			}
		 else {return '';}
}

function CATgerarquia_nombre($id){
	$ejercicio = date('Y');
	require("config.php");
		$sql = "
		select * from cat_gerarquia where id='".$id."'";	
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{
				return $f['nombre'];
			}
		 else {return FALSE;}
}

function NFile($IdApp){
	require("config.php");
	$sql = "SELECT * FROM aplicaciones WHERE idapp='".$IdApp."'";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		$C = $f['c'] + 1;

		$sql="UPDATE aplicaciones SET c='".$C."' WHERE idapp='".$IdApp."'";
		// $resultado = $conexion -> query($sql);
		if ($conexion->query($sql) == TRUE) {
			return $C;
		}

	}		else {return  "";}
}

	

function ClimaDel($Id){
	require("config.php");	
	$sql = "select clima from cat_gerarquia Where id='".$Id."'";
	// //echo $sql;
	
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		if ($f['clima'] <> "") {
			return $f['clima'];
		} else {
			return "Sin informacion de clima";
		}
		
	}
	else {
		return "";
	}
}


function COLIdMunicipio($idcolp){
	require("config.php");	
	$sql = "select IdMunicipio from cat_colonias Where idcolp='".$idcolp."'";
	
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		return $f['IdMunicipio'];
	}
	else {
		return FALSE;
	}
}

function COLIdColonia($idcolp){
	require("config.php");	
	$sql = "select idcolonia from cat_colonias Where idcolp='".$idcolp."'";
	
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		return $f['idcolonia'];
	}
	else {
		return FALSE;
	}
}


function wowslider($IdApp, $width, $height){
	//esta funcion requiere la variable GET ?sl=    
	require("config.php");
	echo '<div id="wowslider-container1" style="width:'.$width.'; height:'.$height.';">';
	echo '<div class="ws_images">';
	echo '<ul>';
	$sql="select * from wowslider WHERE estado=0 and idapp='".$IdApp."'";
	$r= $conexion -> query($sql);
	while($f = $r -> fetch_array()) {
		
			echo '<li><img src="'.$f['src'].'" alt="imagen 1" title="'.$f['Titulo'].'" id="wows1_1"/ style="width:100%;height:100%;"></li>';
		
		
	}   
	echo '</ul>';
	echo '</div>';
	echo '</div>';
	
	}

	


function TurnosMisAreas($nitavu){
require("config.php");
$IdDpto = nitavu_dpto($nitavu);
//recuperacion del nivel 1	
$sql = "
SELECT
*
FROM	catareas_encargados
where nitavu = '".$nitavu."' and IdDelegacion='".$IdDpto."'";	

	$MisAreas="";
	$rc= $conexion -> query($sql);
	while($f = $rc -> fetch_array()) {
		$MisAreas = $MisAreas.$f['IdArea'].", ";
		

	}
	return substr($MisAreas, 0, -2);
}


function MisTurnosLista($nitavu){
	require("config.php");		
	$IdDpto = nitavu_dpto($nitavu);
	$sql="
	SELECT
		IdArea as Id_Area,
		(select Nombre from catareas Where IdArea = Id_Area) as Area,
		(select count(*) from turnos Where turnos.Area = Id_Area and turnos.Fecha = CURDATE() and Estado=0) as Turnos
	FROM
		catareas_encargados
	WHERE 
		nitavu='".$nitavu."' and IdDelegacion='".$IdDpto."'
	";
	// //echo $sql;	
	$rs= $conexion -> query($sql);
	$r = "";
	$r=$r."<table class='tabla' style='font-size:7pt; font-family:Light; background-color:white;border-radius:3px;'>";
    while($f = $rs -> fetch_array()) {
		$r = $r."<tr>";
		$r = $r."<td>".$f['Area']."</td>";
		$r = $r."<td>".$f['Turnos']."</td>";
		$r = $r."</tr>";
	}
	$r = $r."</table>";
	return $r;
}



function TurnosLista($IdDpto){
	require("config.php");	
	$sql="
	SELECT
		IdArea as Id_Area,
		Nombre as Area,
		(select count(*) from turnos Where turnos.Area = Id_Area and turnos.Fecha = CURDATE() and IdDelegacion='".$IdDpto."') as Turnos
	FROM
		catareas";
    $r= $conexion -> query($sql);
    while($f = $r -> fetch_array()) {

	}
}

function TurnoAreaNombre($IdArea){
	require("config.php");	
	$sql = "select Nombre from catareas Where IdArea='".$IdArea."'";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		return $f['Nombre'];
	}
	else {
		return FALSE;
	}
}


function MiTurnoActual_Detalle($nitavu){
	$IdDpto = nitavu_dpto($nitavu);
	require("config.php");	
	$sql = "
	SELECT
		*
	FROM
		turnos
	WHERE 
		nitavu='".$nitavu."' and turnos.DelegacionId='".$IdDpto."' and  turnos.Fecha = CURDATE()
		and Estado = 1
	ORDER BY AreaT DESC, Turno	ASC
	limit 1
	";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		return $f['Nombres']." ".$f['Paterno']." ".$f['Materno'];
	}
	else { return ""; }
}


function MiTurnoActual($nitavu){
	$IdDpto = nitavu_dpto($nitavu);
	require("config.php");	
	$sql = "
	SELECT
		*
	FROM
		turnos
	WHERE 
		nitavu='".$nitavu."' and turnos.DelegacionId='".$IdDpto."' and  turnos.Fecha = CURDATE()
		and Estado = 1
	ORDER BY AreaT DESC, Turno	ASC
	limit 1
	";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		return $f['Turno'];
	}
	else {
		return "";
	}
}

function TomarTurno($nitavu){
	require("config.php");	
	if (MiTurnoActual($nitavu) == "") { // sino tengo turnos
		$IdDpto = nitavu_dpto($nitavu);	//id de la delegacion de acuerdo con cat_gerarquia
		$MisAreas = TurnosMisAreas($nitavu);
		$sql = "
		SELECT
			*
		FROM
			turnos
		WHERE 
			turnos.DelegacionId='".$IdDpto."' and  turnos.Fecha = CURDATE() and Area in(".$MisAreas.") and Estado = 0
		ORDER BY AreaT DESC, Turno	ASC
		limit 1

		";
		if ($MisAreas == ""){
			echo "Sin modulos Asignados";
			echo "<script>
			NPush('El usuario actual, no tiene modulos asignados para Turnos, Comuniquese con su Administrador o el Departamento Tecnico','Plataforma ITAVU')
			</script>";
		} else {
			$rc= $conexion -> query($sql);
			if($f = $rc -> fetch_array())
			{	//actualizamos el estado
				$sql = "UPDATE turnos SET Estado=1,  nitavu='".$nitavu."', atendido_hora1='".$hora."' WHERE id='".$f['id']."'";
				if ($conexion->query($sql) == TRUE)
				{
					historia($nitavu,"TURNOS: tomo el turno ".$f['Turno']." de la Delegacion ".$f['Delegacion']);			
					return TRUE;
				} else {
					echo "Error ".$sql;
					// mensaje("ERROR: ".$sql,"");
					return FALSE;
				}
				

				
			}
			else {
				return FALSE;
			}
		}
	} else {return FALSE; 
		
	}
}


function FinalizarTurno($nitavu){
	require("config.php");	
	if (MiTurnoActual($nitavu) <> "") { // solo si  tengo turno
		$IdDpto = nitavu_dpto($nitavu);	//id de la delegacion de acuerdo con cat_gerarquia
		$sql = "
		SELECT
			*
		FROM
			turnos
		WHERE 
			nitavu='".$nitavu."' and turnos.DelegacionId='".$IdDpto."' and  turnos.Fecha = CURDATE()
			and Estado = 1
		ORDER BY AreaT DESC, Turno	ASC
		limit 1

		";
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
		{	//actualizamos el estado
			$sql = "UPDATE turnos SET Estado=2, atendido_hora2='".$hora."' WHERE id='".$f['id']."' ";
			if ($conexion->query($sql) == TRUE)
			{
				historia($nitavu,"TURNOS: Finalizo el turno ".$f['Turno']." de la Delegacion ".$f['Delegacion']);			
				return TRUE;
			} else {mensaje("ERROR: ".$sql,"");
				return FALSE;
			}
			

			
		}
		else {
			return FALSE;
		}
	} else {return FALSE;}
}


function FinalizarTurnoAuscente($nitavu){
	require("config.php");	
	if (MiTurnoActual($nitavu) <> "") { // solo si  tengo turno
		$IdDpto = nitavu_dpto($nitavu);	//id de la delegacion de acuerdo con cat_gerarquia
		$sql = "
		SELECT
			*
		FROM
			turnos
		WHERE 
			nitavu='".$nitavu."' and turnos.DelegacionId='".$IdDpto."' and  turnos.Fecha = CURDATE()
			and Estado = 1
		ORDER BY AreaT DESC, Turno	ASC
		limit 1

		";
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
		{	//actualizamos el estado
			$sql = "UPDATE turnos SET Estado=3, atendido_hora2='".$hora."' WHERE id='".$f['id']."' ";
			if ($conexion->query($sql) == TRUE)
			{
				historia($nitavu,"TURNOS: Finalizo el turno ".$f['Turno']." por Auscencia al llamado o  de la Delegacion ".$f['Delegacion']);			
				return TRUE;
			} else {mensaje("ERROR: ".$sql,"");
				return FALSE;
			}
			

			
		}
		else {
			return FALSE;
		}
	} else {return FALSE;}
}





function TurnosHoy($IdDpto){
	require("config.php");	
	$sql = "select count(*) as n from turnos where fecha = curdate()";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		return $f['n'];
	}
	else {
		return FALSE;
	}
}



function Turno($IdDpto, $Agregar){
	require("config.php");
	if ($Agregar == TRUE ){
		$Actual = Turno($IdDpto,FALSE);
		
		if (TurnosHoy($IdDpto)==0){ // si aun no hay turnos hoy, reinicia el contador
			$Nuevo = 1;
			$sql="UPDATE cat_gerarquia SET TurnoCount='$Nuevo' WHERE (id='".$IdDpto."')";
			if ($conexion->query($sql) == TRUE){
				historia("TURNOS","Se reinicio el contador de turnos de la delegacion ".$IdDpto);
				return $Nuevo;
			} else  {return FALSE;}
		} else { // sino continua con el contador
			$Nuevo = $Actual + 1;
			$sql="UPDATE cat_gerarquia SET TurnoCount='$Nuevo' WHERE (id='".$IdDpto."')";
			if ($conexion->query($sql) == TRUE){
				return $Nuevo;
			} else  {return FALSE;}

		}

	} else {
		$sql="select TurnoCount from cat_gerarquia where id='".$IdDpto."'";	
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
		{
			return $f['TurnoCount'];
		}
		else {
			return FALSE;
		}
	}
	
	
	//echo $sql;
}


function CrearTurno($IdDelegacion_dpto, $Area){
	require("config.php");
	
		$Turno = Turno($IdDelegacion_dpto,TRUE);
		//clinvo = 3 = viene desde el modulo de turnos
			// guardar el turno
			$sql = "INSERT INTO turnos(clinvo,DelegacionId,Fecha,Hora,nitavu,Turno,Area) 
								VALUES(	'3', '".$IdDelegacion_dpto."','".$fecha."','".$hora."', 'MODULO DE TURNOS','".$Turno."','".$Area."')";			
			
			if ($conexion->query($sql) == TRUE){
				
				return $Turno;	
		

			}
			else {
				return "ERROR";
			}
		
		
	
}


function CURP_detalle($cveAlfaEntFedNac, $fechaNacimiento, $nombres, $apellido1, $apellido2, $sexo, $usuario){
	docdigital_no(FALSE, 2); //ahorra 1 hoja
	//REQUISITOS DE CONSULTA DEL WEBSERVICE
	$RENAPO_User = 'itavu';
	// $RENAPO_Pass = '1t4vu.T4m';
	$RENAPO_Pass = 'WS719#1t4vu$';
	// $RENAPO_URLbyCURP="https://tres.sitam.tamaulipas.gob.mx/api/test/renapo/detalles/consultar";
	$RENAPO_URLbyCURP="https://sitam.tamaulipas.gob.mx/api/renapo/detalles/consultar";
    
    //Datos para la peticion
    // $cveAlfaEntFedNac= (String)"TS";
    // $fechaNacimiento="13/02/1981";
    // $nombres="JUAN JOSE";
    // $apellido1="PEDRAZA";
    // $apellido2="PERALES";
    // $sexo="H"; //H o M


	//Peticion
	$myObj = new stdClass;
	$myObj->usuario = $RENAPO_User;
	$myObj->password = $RENAPO_Pass;
    $myObj->cveAlfaEntFedNac = $cveAlfaEntFedNac;
    $myObj->fechaNacimiento = $fechaNacimiento;
    $myObj->nombres = $nombres;
    $myObj->apellido1 = $apellido1;
    $myObj->apellido2 = $apellido2;
    $myObj->sexo = $sexo;

	$myJSON = json_encode($myObj,JSON_UNESCAPED_SLASHES);
    // echo $myJSON;


	$post   =   curl_init ( $RENAPO_URLbyCURP ) ; // Inicializamos la URL
	curl_setopt($post, CURLOPT_POST, 1); //especificamos que sea POST
	curl_setopt($post, CURLOPT_POSTFIELDS, $myJSON); //adjuntamos los datos JSON
	curl_setopt ($post ,   CURLOPT_HTTPHEADER ,   array ( 'Content-Type: application/json' ) ) ;   // creamos el header
	curl_setopt($post, CURLOPT_RETURNTRANSFER, true);  

	//Estas las puse en false, ya que estoy en desarrollo en el equipo con xammp
	curl_setopt($post, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($post, CURLOPT_SSL_VERIFYHOST, FALSE);
	
    $R   =   curl_exec ( $post ); // ejecuatamos y almacemanos en $R
    historia($usuario,"CONSULTA CURP DETALLE: Consulto el CURP de ".$nombres." ".$apellido1." ".$apellido2.": ".$R);
	return $R;

    // echo $R;
    
    

}

function CURP($strCURP, $usuario){    
	docdigital_no(FALSE, 2); //ahorra 1 hoja
	require("config.php"); require_once("flor_funciones.php");
	if (CURP_limite() == TRUE){
		//REQUISITOS DE CONSULTA DEL WEBSERVICE

		//primera conexion a Renapo
		//$RENAPO_Pass = '1t4vu.T4m';
		//$RENAPO_URLbyCURP="https://tres.sitam.tamaulipas.gob.mx/api/test/renapo/curp/consultar";

		//segunda conexion a web service a RENAPO
		//$RENAPO_User = 'itavu';
		//$RENAPO_Pass = 'WS719#1t4vu$';
		//$RENAPO_URLbyCURP="https://sitam.tamaulipas.gob.mx/api/renapo/curp/consultar";

		//nuevas credenciales para conectarnos a la web service de RENAPO. Entregadas 02jun2025 via email
		$RENAPO_Header = 'Authorization: aXRhdnUuZGV2QHRhbWF1bGlwYXMuZ29iLm14fFkzV1lDdkVtVFZBVnlqN1hyUHN5R0V6SFdlamRfTTdWOVV3ZjA2bGJUejg=';
		$RENAPO_Endpoint = '/personas';

		$tipodesalida = 2;	//<---- cambiar aqui, la forma de salida a consultar el CURP (1 = Test y 2 = Produccion)
		IF($tipodesalida == 1){
			echo "MODO (TEST) ";
			$baseUrl = "https://testsitam.tamaulipas.gob.mx/renapov2/api/v1";
		} ELSE {
			echo "MODO (PRODUCCION) ";
			$baseUrl = "https://sitam.tamaulipas.gob.mx/renapov2/api/v1";
		}
		$params = ['curp' => trim($strCURP)];
		$urlConParametros = $baseUrl.$RENAPO_Endpoint . '?' . http_build_query($params);
		$ch = curl_init($urlConParametros);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, [$RENAPO_Header]);
		$R = curl_exec($ch);

		if (curl_errno($ch)) {
			echo 'Error en cURL: ' . curl_error($ch);
		} else {
			//echo "URL: " . $urlConParametros . "\n";
		}

		// Cerrar la sesión cURL
		curl_close($ch);

		historia($usuario,"CONSULTA CURP: Consulto el CURP de ".$strCURP.": ".$R);

		//validamos y almacenamos 
		$array = json_decode($R, true);
		if(is_array($array)){
			$sql = "INSERT INTO curp_consultas(exito, detalles, fecha, hora, usuario) VALUES ('1', '".$R."', '".$fecha."', '".$hora."','".$usuario."')";			
			$conexion->query($sql);
		} else {
			//hubo un error
			$sql = "INSERT INTO curp_consultas(exito, detalles, fecha, hora, usuario) VALUES ('0', '".$R."', '".$fecha."', '".$hora."','".$usuario."')";			
			$conexion->query($sql);
		}
		return $R;
	} else {
		return "Ha lledago al limite de la consulta de CURP diaria de ".$CURP_limite."/".CURPs_hoy().". Comuniquese con el Departamento de Informática";
		$Asunto = "Limite de CURP ".$CURP_limite."/".CURPs_hoy()."";
		$Mensaje = "<p><b>".$Asunto."</b></p>
		<p>
		Este aviso 
		</p>
		<p>AVISO: Automatico de la Plataforma</p>
		
		";
		$Remitente = "Plataforma ITAVU | Servicio CURP";
		InformaticosGo($Asunto, $Mensaje, $Remitente);
	}
}




function getPage($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}


function DatosVivienda($IdDelegacion, $Usuario, $DescripcionDeUso, $ConsultaMSSQLSERVER){
	require("config.php"); 
	require("flor_funciones.php");
	
	$IpPrivada = DelegacionIpPrivada($IdDelegacion);
	// if   (ping($IpPrivada,"80") == TRUE){

		
		
		// echo "Delegacion en Datos Vivienda: ".$IdDelegacion;
		
		//REQUISITOS DE CONSULTA DEL WEBSERVICE
		$RToken =  MiToken($Usuario, $DescripcionDeUso);
		if ($RToken == ""){
			$MiToken = MiToken_Init($Usuario, $DescripcionDeUso); // Generamos el token de consulta
		} else {
			$MiToken = $RToken;
		}

		$sql = urlencode($ConsultaMSSQLSERVER); // codificamos las variables largas

		$url= $URLwebserviceVivienda."/sql.asp?IdDel=".$IdDelegacion."&user=".$Usuario."&token=".$MiToken."&sql=".$sql; // preparamos la URL para el webservice de vivienda
		// echo "<br> URL Webservice: ".$url."<br>";
		$DataWb = file_get_contents($url);
		//echo $DataWb;
		// var_dump($DataWb);
		if ($DataWb === false) {
			return FALSE;
		} else {
			return $DataWb; // <-- contenido 
		}

		// header('Content-Type: application/json');
	// } else {
	// 	return FALSE;
	// }

}


function DatosViviendaLarge($IdDelegacion, $Usuario, $DescripcionDeUso, $ConsultaMSSQLSERVER){
	require("config.php"); 
	require_once("flor_funciones.php");
	
	// echo "Delegacion en Datos Vivienda: ".$IdDelegacion;
    
    //REQUISITOS DE CONSULTA DEL WEBSERVICE
    $RToken =  MiToken($Usuario, $DescripcionDeUso);
    if ($RToken == ""){
        $MiToken = MiToken_Init($Usuario, $DescripcionDeUso); // Generamos el token de consulta
    } else {
        $MiToken = $RToken;
    }

    // $sql = urlencode($ConsultaMSSQLSERVER); // codificamos las variables largas



		$url = $URLwebserviceVivienda."/sql_large.asp";
		$data = array('IdDel' => $IdDelegacion, 'user' => $Usuario, 'token' => $MiToken, 'sql'=>$ConsultaMSSQLSERVER);
		$options = array(
				'http' => array(
				'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
				'method'  => 'POST',
				'content' => http_build_query($data),
			)
		);
		
		// var_dump($data);
		$context  = stream_context_create($options);
		$DataWb = file_get_contents($url, false, $context);
		
		// var_dump($DataWb);
    	// echo $DataWb;
		if ($DataWb === FALSE) {
			return FALSE;
		} else {
			return $DataWb; // <-- contenido 
		}

    // header('Content-Type: application/json');
  



}


function Historia_UltimoMovimiento($nitavu){require("config.php");
	$sql="select * from historia where nitavu='$nitavu'  order by fecha DESC, hora DESC limit 1";	
	//echo $sql;
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		return "".fecha_larga($f['fecha'])." a las ".hora12($f['hora']);
	}
	else {
		return "";
	}
}


function Historia_PrimerMovimiento($nitavu){require("config.php");
	$sql="select * from historia where nitavu='$nitavu'  order by fecha ASC, hora ASC limit 1";	
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		return "".fecha_larga($f['fecha'])." a las ".hora12($f['hora']);
	}
	else {
		return "";
	}
}
function HorarioDpto($nitavu){
	require("config.php");
	$dpto = nitavu_dpto($nitavu);
	$sql = "SELECT * FROM cat_gerarquia WHERE (id='".$dpto."')";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		if($f['nivel']=='del'){
			return $f['id'];
		}else{
			return "*";
		}
	}
	else
	{
		return '';
	}
}

function HorarioInicio($nitavu){require("config.php");
	$DptoId = HorarioDpto($nitavu);
	$sql="select * from horarios WHERE DptoId='$DptoId'";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
		{
				return $f['HorarioInicio'];			
		}
	 else {return FALSE;}
}




function Horariofin($nitavu){require("config.php");
	$DptoId = HorarioDpto($nitavu);
	$sql="select * from horarios WHERE DptoId='$DptoId'";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
		{
				return $f['HorarioFin'];			
		}
	 else {return FALSE;}
}


function horariosexcepcion($usuario){	
require("config.php");	
	$sql="select count(*) as n from  horariosexcepcion where fecha=CURDATE() and nitavu='$usuario'";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
		{
			return $f['n'];
			
		}
	 else {return '';}


}

function horariosTengoExcepcion($usuario){	
	require("config.php");	
		$sql="select count(*) as n from  horariosexcepcion where fecha=CURDATE() and nitavu='$usuario' and Autorizo<>''";
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{
				return $f['n'];
				
			}
		 else {return 'FALSE';}
	
	
	}

	
	
function horariosexcepcionN(){	
	require("config.php");	
		$sql="select count(*) as n from  horariosexcepcion where fecha=CURDATE()";
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{
				return $f['n'];
				
			}
		 else {return '';}
	
	
	}

function EsInabil(){require("config.php");	
	$sql="select count(*) as n from diasinhabiles where Dia0=CURDATE()";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
		{
			if ($f['n']>=1){
				return TRUE;
			} else{
				return FALSE;
			}
			
		}
	 else {return FALSE;}
}




// FUNCIONES PARA MEJORAR LA SEGURIDAD
function ValidaVAR($valor){
    $output = TRUE;
    $peligro = "SCRIPT"; if(preg_match('/'.$peligro.'/i', $valor)){ $output = FALSE; } 
    $peligro = "<"; if(preg_match('/'.$peligro.'/i', $valor)){ $output = FALSE; } 
    $peligro = "script"; if(preg_match('/'.$peligro.'/i', $valor)){ $output = FALSE; } 
    $peligro = ">"; if(preg_match('/'.$peligro.'/i', $valor)){ $output = FALSE; } 
    $peligro = "SELECT"; if(preg_match('/'.$peligro.'/i', $valor)){ $output = FALSE; } 
    $peligro = "COPY"; if(preg_match('/'.$peligro.'/i', $valor)){ $output = FALSE; } 
    $peligro = "DROP"; if(preg_match('/'.$peligro.'/i', $valor)){ $output = FALSE; } 
    $peligro = "DUMP"; if(preg_match('/'.$peligro.'/i', $valor)){ $output = FALSE; } 
    // $peligro = "OR"; if(preg_match('/'.$peligro.'/i', $valor)){ $output = FALSE; } 
    $peligro = "LIKE"; if(preg_match('/'.$peligro.'/i', $valor)){ $output = FALSE; } 
    $peligro = "'"; if(preg_match('/'.$peligro.'/i', $valor)){ $output = FALSE; } 
    $peligro = "\""; if(preg_match('/'.$peligro.'/i', $valor)){ $output = FALSE; } 

    return $output;
}

function LimpiarVAR($valor){
    $output = LimpiarVAR_FrontEnd($valor);
	$output = LimpiarVAR_BackEnd($valor);
	$output =  LimpiarComillas($valor);
    return $output;
}

        

function LimpiarComillas($valor)
{
	
	$valor = addslashes($valor);     
	$valor = str_ireplace("'","",$valor);
	$valor = str_ireplace('"',"",$valor);
	$valor = str_ireplace("'","",$valor);
	$valor = str_ireplace('"',"",$valor);
	$valor = str_ireplace("'","",$valor);
	$valor = str_ireplace('"',"",$valor);
	$valor = str_ireplace("'","",$valor);
	$valor = str_ireplace('"',"",$valor);
	$valor = str_ireplace("'","",$valor);
	$valor = str_ireplace('"',"",$valor);
	$valor = str_ireplace("'","",$valor);
	$valor = str_ireplace('"',"",$valor);
	$valor = str_ireplace("'","",$valor);
	$valor = str_ireplace('"',"",$valor);
	$valor = str_ireplace("'","",$valor);
	$valor = str_ireplace('"',"",$valor);
	$valor = str_ireplace("'","",$valor);
	$valor = str_ireplace('"',"",$valor);
	$valor = str_ireplace("'","",$valor);
	$valor = str_ireplace('"',"",$valor);
	$valor = str_ireplace("'","",$valor);
	$valor = str_ireplace('"',"",$valor);
	$valor = str_ireplace("'","",$valor);
	$valor = str_ireplace('"',"",$valor);
	$valor = str_ireplace("'","",$valor);
	$valor = str_ireplace('"',"",$valor);
	$valor = str_ireplace("'","",$valor);
	$valor = str_ireplace('"',"",$valor);
	$valor = str_ireplace("'","",$valor);
	$valor = str_ireplace('"',"",$valor);
	
	
	return $valor;
}


    function LimpiarVAR_BackEnd($valor)
    {
        
        $valor = addslashes($valor);     
        $valor = str_ireplace("SELECT","",$valor);
        $valor = str_ireplace("COPY","",$valor);
        $valor = str_ireplace("DELETE","",$valor);
        $valor = str_ireplace("DROP","",$valor);
        $valor = str_ireplace("DUMP","",$valor);
        // $valor = str_ireplace(" OR ","",$valor);
        $valor = str_ireplace("%","",$valor);
        $valor = str_ireplace("LIKE","",$valor);
        $valor = str_ireplace("--","",$valor);
        $valor = str_ireplace("^","",$valor);
        $valor = str_ireplace("[","",$valor);
        $valor = str_ireplace("]","",$valor);	
        $valor = str_ireplace("!","",$valor);
        $valor = str_ireplace("¡","",$valor);
        $valor = str_ireplace("?","",$valor);
        $valor = str_ireplace("=","",$valor);
        $valor = str_ireplace("&","",$valor);
        $valor = str_ireplace("<SCRIPT>","",$valor);
        $valor = str_ireplace("<script>","",$valor);
        $valor = str_ireplace(">","",$valor);
        $valor = str_ireplace("<","",$valor);
        
        return $valor;
    }

   
    function LimpiarVAR_FrontEnd($input) {
     
      $search = array(
        '@<script[^>]*?>.*?</script>@si',   // Elimina javascript
        '@<[\/\!]*?[^<>]*?>@si',            // Elimina las etiquetas HTML
        '@<style[^>]*?>.*?</style>@siU',    // Elimina las etiquetas de estilo
        '@<![\s\S]*?--[ \t\n\r]*>@'         // Elimina los comentarios multi-línea
      );
     
        $output = preg_replace($search, '', $input);
        return $output;
      }
     
    function sanitize($input) {
        if (is_array($input)) {
            foreach($input as $var=>$val) {
                $output[$var] = sanitize($val);
            }
        }
        else {
            if (get_magic_quotes_gpc()) {
                $input = stripslashes($input);
            }
            $input  = cleanInput($input);
            $output = mysql_real_escape_string($input);
        }
        return $output;
	}
	





	
function IPautorizada($ip){
	// require("config.php");		
	// $sql = "SELECT * FROM ipinterface WHERE ipcliente='".$ip."'";
	// $rc= $conexion -> query($sql);	
	// if($f = $rc -> fetch_array())
	// {return TRUE;}
	// else{ return FALSE;}
}


function  IPdelete($usuarioAdmin, $ipcliente){
	require("config.php");	
	$sql = "DELETE from ipinterface WHERE ipcliente ='".$ipcliente."'";
	
	if ($conexion->query($sql) == TRUE)
	{
		historia($usuarioAdmin,"(".addslashes($sql).") Elimino una nueva IP");
		return TRUE;
		

	}
	else
	{
		historia($usuarioAdmin,"ERROR al eliminar ip (".addslashes($sql).")");
		return FALSE;
		
	}
}


function  IPguardar ($usuarioAdmin, $ipcliente, $empleado, $macaddress, $ipgateway, $ipmask, $pc_name, $pc_marca, $pc_modelo, $pc_memoria, $pc_hd, $pc_descripcion, $pc_serie, $pc_inventario, $comentarios){
	require("config.php");	
	$sql = "INSERT INTO ipinterface
	(ipcliente, username, macaddress, ipgateway, ipmask, pc_name, pc_marca, pc_modelo, pc_memoria, pc_hd, pc_descripcion, pc_serie, pc_inventario, comentarios)
	VALUES
	('$ipcliente', '$empleado', '$macaddress','$ipgateway', '$ipmask', '$pc_name', '$pc_marca', '$pc_modelo', '$pc_memoria', '$pc_hd', '$pc_descripcion','$pc_serie', '$pc_inventario', '$comentarios')";
	//echo $sql;
	if ($conexion->query($sql) == TRUE)
	{
		historia($usuarioAdmin,"(".addslashes($sql).") Agrego una nueva IP");
		return TRUE;
		

	}
	else
	{
		historia($usuarioAdmin,"ERROR al guardar ip (".addslashes($sql).")");
		return FALSE;
		
	}
}




function  IPupdate ($usuarioAdmin, $ipcliente, $empleado, $macaddress, $ipgateway, $ipmask, $pc_name, $pc_marca, $pc_modelo, $pc_memoria, $pc_hd, $pc_descripcion, $pc_serie, $pc_inventario, $comentarios){
	require("config.php");		
	$sql = "
	UPDATE ipinterface
	SET 
		username='$empleado',
		macaddress='$macaddress',
		ipgateway='$ipgateway',
		ipmask='$ipmask',
		pc_name='$pc_name',
		pc_marca='$pc_marca',
		pc_modelo='$pc_modelo',
		pc_memoria='$pc_memoria',
		pc_hd='$pc_hd',
		pc_descripcion='$pc_descripcion',
		pc_serie='$pc_serie',
		pc_inventario='$pc_inventario',
		pc_inventario='$pc_inventario'


	WHERE ipcliente = '".$ipcliente."'
	";

	// //echo $sql;
	if ($conexion->query($sql) == TRUE)
	{
		historia($usuarioAdmin," Actualizo una nueva IP; con el query =  (".addslashes($sql).") ");
		return TRUE;
		

	}
	else
	{
		historia($usuarioAdmin,"ERROR al actualizar ip (".addslashes($sql).")");
		return FALSE;
		
	}
}




function SESSION_init($id, $user, $session_name, $session_comentario, $ip){
	require("config.php");	
	$sql = "INSERT INTO sessiones (id, session_name,  usuario, fecha, hora, comentarios,ipcliente) 
	VALUES ('".$id."', '".$session_name."', '".$user."', '".$fecha."', '".$hora."', '".$session_comentario."', '".$ip."')";
	// mensaje($sql,'login.php');
		if ($conexion->query($sql) == TRUE)
			{return TRUE;}
		else {return FALSE;}
}


function SESSION_close($id){
	require("config.php");
	$sql="UPDATE sessiones  SET cierre_fecha='".$fecha."', cierre_hora='".$hora."'  WHERE id='".$id."'";
	// //echo $sql;
	if ($conexion->query($sql) == TRUE)
		{return TRUE;}
	else {return FALSE;}
}


function SESSION_tiempo($id){
    require("config.php");
    $sql = 'SELECT TIMEDIFF(CURTIME(), hora) as transcurrido, sessiones.* from sessiones where id="'.$id.'"' ;
    // //echo $sql;
    $r= $conexion -> query($sql); if($f = $r -> fetch_array()){
            return $f['transcurrido'];
    }else{
            return FALSE;
    }
        

}



function SESSION_tiempoRound($id){
    require("config.php");
    $sql = 'SELECT ROUND(TIMEDIFF(CURTIME(), hora)) as transcurrido, sessiones.* from sessiones where id="'.$id.'"' ;
    // //echo $sql;
    $r= $conexion -> query($sql); if($f = $r -> fetch_array()){
            return $f['transcurrido'];
    }else{
            return FALSE;
    }
        

}


function FER_validaID($id){
	$ejercicio = date('Y');
	require("config.php");
		$sql = "
		select * from fer where  nfer_id='".$id."'";	
	
		// //echo $sql;
		$rc= $conexion -> query($sql);
		
		if($f = $rc -> fetch_array())
			{

				return TRUE;
			}
		 else {return FALSE;}
}



function FER_curp($curp){
	$ejercicio = date('Y');
	require("config.php");
		$sql = "
		select * from fer where curp='".$curp."'";	
	
		// //echo $sql;
		$rc= $conexion -> query($sql);
		
		if($f = $rc -> fetch_array())
			{

				return "Ya ha sido beneficiado con la curp ".$f['curp']." a nombre de ".$f['nombre'].", por la cantidad de $".$f['cantidad']." el ".$f['autorizo_fecha'];
			}
		 else {return "";}
}


function CATgerarquia_director(){
	$ejercicio = date('Y');
	require("config.php");
		$sql = "
		select * from cat_gerarquia where id='1'";	
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{
				return $f['titular'];
			}
		 else {return FALSE;}
}


function CATgerarquia_credito(){
	$ejercicio = date('Y');
	require("config.php");
		$sql = "
		select * from cat_gerarquia where id='60'";	
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{
				return $f['titular'];
			}
		 else {return FALSE;}
}

function CATgerarquia_finanzas(){
	$ejercicio = date('Y');
	require("config.php");
		$sql = "
		select * from cat_gerarquia where id='54'";	
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{
				return $f['titular'];
			}
		 else {return FALSE;}
}

function CATgerarquia_coordinador(){
	$ejercicio = date('Y');
	require("config.php");
		$sql = "
		select * from cat_gerarquia where id='19'";	
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{
				return $f['titular'];
			}
		 else {return FALSE;}
}



function CATgerarquia_contabilidad(){
	$ejercicio = date('Y');
	require("config.php");
		$sql = "
		select * from cat_gerarquia where id='57'";	
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{
				return $f['titular'];
			}
		 else {return FALSE;}
}

//***** FUNCIONES FER- FONDO ECONOMICO DE RESERVA

function FER_sustento(){
	$ejercicio = date('Y');
	require("config.php");
		$sql = "
		select * from fer_fondos where ejercicio='".$ejercicio."'";	
	
		// //echo $sql;
		$rc= $conexion -> query($sql);
		
		if($f = $rc -> fetch_array())
			{
				return $disponible = $f['sustento'] ;
			}
		 else {return FALSE;}
}


function FER_fechafin(){
	$ejercicio = date('Y');
	require("config.php");
		$sql = "
		select * from fer_fondos where ejercicio='".$ejercicio."'";	
	
		// //echo $sql;
		$rc= $conexion -> query($sql);
		
		if($f = $rc -> fetch_array())
			{
				return $disponible = $f['fechafin'] ;
			}
		 else {return FALSE;}
}



function FondoEconomicoDeReserva(){
	$ejercicio = date('Y');
	require("config.php");
		$sql = "SELECT
		sum( cantidad ) as Ejercido,
		(select Fondo from fer_fondos where ejercicio='".$ejercicio."') as FERcapital
		
	FROM
		fer 
	WHERE
		ejercicio = ".$ejercicio." and estado=0";
		// //echo $sql;
		$rc= $conexion -> query($sql);
		$disponible= 0;
		if($f = $rc -> fetch_array())
			{
				$disponible = $f['FERcapital'] ;
			}
		return $disponible;
}


 function FechaInicioAdmin(){
	require("config.php");
	$sql="SELECT FechaInicio
	FROM cat_administraciones
	WHERE DATE(NOW()) BETWEEN FechaInicio AND FechaTermino ";
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{
				return $f['FechaInicio'];
			}
		 else {return FALSE;}
 }

 function FechaTerminaAdmin(){
	require("config.php");
	$sql="SELECT FechaTermino
	FROM cat_administraciones
	WHERE DATE(NOW()) BETWEEN FechaInicio AND FechaTermino ";
		$rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
			{
				return $f['FechaTermino'];
			}
		 else {return FALSE;}
 }

function FERdisponible(){
	//por año
$ejercicio = date('Y');
require("config.php");
	$sql = "SELECT
	sum( cantidad ) as Ejercido,
	(select Fondo from fer_fondos where ejercicio='".$ejercicio."') as FERcapital
	
FROM
	fer 
WHERE
	ejercicio = ".date('Y')." and estado=0";
	$rc= $conexion -> query($sql);
	$disponible= 0;
	if($f = $rc -> fetch_array())
		{
			$disponible = $f['FERcapital'] - $f['Ejercido'];
		}
	return $disponible;
}

function FERdisponibleSexenio(){

	$ejercicio = date('Y');
	require("config.php");
		$sql = "SELECT
		(
		SELECT Fondo FROM fer_fondos 
		WHERE DATE(NOW()) BETWEEN fechainicio AND fechafin  LIMIT 1		
		)
		-
		(SELECT  sum(Cantidad) as cantidad
		FROM `fer`
		where autorizo_fecha>='".FechaInicioAdmin()."' and autorizo_fecha<='".FechaTerminaAdmin()."' and estado=0) as disponible
		";
		$rc= $conexion -> query($sql);
		$disponible= 0;
		if($f = $rc -> fetch_array())
			{
				$disponible = $f['disponible'];
			}
		return $disponible;
	}

function NIdConsulta($consulta){
	require("config.php");
	$sql = "SELECT * FROM contadores WHERE id='0'";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
					{
		if ($consulta==TRUE) {
						return $f['IdConsulta'];
		}
		else
		{ // sino es consulta entonces aumentarle y aumentar el contador de ceropapel
		// la diferencia entre ceropapel y este, es que cero papel se multiplica
		// por las copias que se entregan o con copia, para estadistica de cuanto se ha ahorrado
		$docdigital = $f['IdConsulta'];
		$docdigitalnew = $docdigital + 1;
		
		
		$sql="UPDATE contadores SET IdConsulta='".$docdigitalnew."'  WHERE id='0'";
		$resultado = $conexion -> query($sql);
		if ($conexion->query($sql) == TRUE) {
			return $f['IdConsulta'];
		}
		else {return  FALSE;}
					}
	}
	else
	{ return FALSE;}
}

function Nfer_new($consulta){
	require("config.php");
	$sql = "SELECT * FROM contadores WHERE id='0'";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
					{
		if ($consulta==TRUE) {
						return $f['Nfer'];
		}
		else
		{ // sino es consulta entonces aumentarle y aumentar el contador de ceropapel
		// la diferencia entre ceropapel y este, es que cero papel se multiplica
		// por las copias que se entregan o con copia, para estadistica de cuanto se ha ahorrado
		$docdigital = $f['Nfer'];
		$docdigitalnew = $docdigital + 1;
		
		
		$sql="UPDATE contadores SET Nfer='".$docdigitalnew."'  WHERE id='0'";
		$resultado = $conexion -> query($sql);
		if ($conexion->query($sql) == TRUE) {
			return $f['Nfer'];
		}
		else {return  FALSE;}
					}
	}
	else
	{ return FALSE;}
}

function Nfer_new2($consulta){
	require("config.php");
	//$ejercicio = date('Y');
	$sql="SELECT * FROM cat_administraciones where FechaInicio<'".$fecha."' and FechaTermino>='".$fecha."' ";
	$arc= $conexion -> query($sql);
	if ($fechas= $arc -> fetch_array())
		{
			$FechaInicio=$fechas['FechaInicio'];
			$FechaTermino=$fechas['FechaTermino'];
		}

	

	$sql = "SELECT MAX(nfer_id)+1 as Nfer  FROM fer where autorizo_fecha>='".$FechaInicio."'" ;
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
					{
		if ($consulta==TRUE) {
						return $f['Nfer'];
		}
		else
		{ // sino es consulta entonces aumentarle y aumentar el contador de ceropapel
		// la diferencia entre ceropapel y este, es que cero papel se multiplica
		// por las copias que se entregan o con copia, para estadistica de cuanto se ha ahorrado
		//$docdigital = $f['Nfer'];
		//$docdigitalnew = $docdigital + 1;					
		}
	}
	else
	{ return FALSE;}
}

function Ncert_new($consulta){
	require("config.php");
	$ejercicio = date('Y');
	echo $ejercicio;	
	$sql = "SELECT MAX(IFNULL(numcertificado,0))+1 as nuevocert FROM fer where estado=0 and ejercicio='".$ejercicio."'"  ;
	echo $sql;
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
					{
		if ($consulta==TRUE) {
			if ($f['nuevocert'] == null){
				return 1;
			}
			else
			{
				echo $f['nuevocert'];
				return $f['nuevocert'];
			}			
						
		}
		else
		{ // sino es consulta entonces aumentarle y aumentar el contador de ceropapel
		// la diferencia entre ceropapel y este, es que cero papel se multiplica
		// por las copias que se entregan o con copia, para estadistica de cuanto se ha ahorrado
		//$docdigital = $f['Nfer'];
		//$docdigitalnew = $docdigital + 1;					
		}
	}
	else
	{ return FALSE;}
}

function AhorrePapel($consulta, $cuantas){
	require("config.php");
	$sql = "SELECT * FROM contadores WHERE id='0'";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		if ($consulta==TRUE) {
			return $f['docdigital'];
		}
		else
		{ // sino es consulta entonces aumentarle y aumentar el contador de ceropapel
		// la diferencia entre ceropapel y este, es que cero papel se multiplica
		// por las copias que se entregan o con copia, para estadistica de cuanto se ha ahorrado
		$docdigital = $f['docdigital'];
		$docdigitalnew = $docdigital + 1;
		$ceropapel = $f['ceropapel'] + $cuantas;
		$sql="UPDATE contadores SET docdigital='".$docdigitalnew."', ceropapel='".$ceropapel."' WHERE id='0'";
		$resultado = $conexion -> query($sql);
			if ($conexion->query($sql) == TRUE) {
				return $f['docdigital'];
			}
			else {return  FALSE;}
		}
	}
	else
	{ return FALSE;}
}
function Estadistica_UsuariosOnLine(){
	require("config.php");
	$sql = "SELECT
	count(DISTINCT nitavu) as n

FROM
	historia 
WHERE
	fecha=curdate()";
	$rc= $conexion -> query($sql);	
	if($f = $rc -> fetch_array())
		{return $f['n'];}
	else
		{ return FALSE;}
}


function Estadistica_Empleados(){
	require("config.php");
	$sql = "SELECT count(*) as n FROM empleados WHERE estado=''";
	$rc= $conexion -> query($sql);	
	if($f = $rc -> fetch_array())
		{return $f['n'];}
	else
		{ return FALSE;}
}

function nitavu_valida($id){
	require("config.php");
	$sql = "SELECT * FROM empleados WHERE nitavu='".$id."' and estado=''";
	$rc= $conexion -> query($sql);
	$msg="";
	if($f = $rc -> fetch_array())
	{return TRUE;}
	else
	{ return FALSE;}
}



function nitavu_nip($id){
	require("config.php");
	$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
	$rc= $conexion -> query($sql);
	$msg="";
	if($f = $rc -> fetch_array())
	{return $f['nip'];}
	else
	{ return "";}
	}


	function nitavu_nivel($id){
		require("config.php");
		$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
		$rc= $conexion -> query($sql);
		$msg="";
		if($f = $rc -> fetch_array())
		{return $f['nivel'];}
		else
		{ return "";}
		}

		

function EnviarSMS($celular, $mensaje){
	require("config.php");
	$sql = "INSERT INTO sms (celular, mensaje, envia, fecha, hora) 
	VALUES ('".$celular."', '".$mensaje."','2809','".$fecha."', '".$hora."')";
	// //echo $sql;
		if ($conexion->query($sql) == TRUE)
			{return TRUE;}
		else {return FALSE;}

}

function EstoyenDelegacion($nitavu){
	require("config.php");
	$miDpto = nitavu_dpto($nitavu);
	$sql = "SELECT * FROM cat_gerarquia WHERE (id='".$miDpto."')";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		return $f['nivel'];
	}
	else
	{
		return '';
	}
}


function LimpiandoCelular($celular){
    $celular0 = str_replace(" ", "", $celular); //quitando espacios
    $celular0 = str_replace("-", "", $celular0); //quitando guiones
    $celular0 = str_replace("*", "", $celular0); //quitando asteriscos
    $celular0 = str_replace("(", "", $celular0); //quitando asteriscos
    $celular0 = str_replace(")", "", $celular0); //quitando asteriscos
    
    if (is_numeric($celular0)){ // si no tiene letras

        if (strlen($celular0) ==10){ // solo pasamos los que tengan longitud 10
            return $celular0;
        } else {
            return FALSE;
        }
    
    } else {
        return FALSE;
    }

    
}

function SMS_comentarios($imei){
	require("config.php"); $sql = "SELECT * FROM sms_dispositivos WHERE imei='".$imei."'";
	$rc= $conexion -> query($sql);	if($f = $rc -> fetch_array())
	{
		return $f['comentarios'];
	}
	
	else
	{ return FALSE;}
}


function xmlNomina($id){
require("config.php");
$sql = "SELECT * FROM nominas WHERE id='".$id."'";
$rc= $conexion -> query($sql);
$msg="";
if($f = $rc -> fetch_array())
{
	return $f['xmlCont'];
}

else
{ return FALSE;}
}


function mysql_XML($nombreItem) {
require("config.php");
$sql = "SELECT * FROM nominas WHERE id='".$nombreItem."'";
$resultado= $conexion -> query($sql);
$msg="";
//if($f = $resultado -> fetch_array())
//{	
	$campo = array();
	
	// llenamos el array de nombres de campos
	for ($i=0; $i<mysql_num_fields($resultado); $i++)
		$campo[$i] = mysql_field_name($resultado, $i);
	
	// creamos el documento XML	
	$dom = new DOMDocument('1.0', 'UTF-8');
	$doc = $dom->appendChild($dom->createElement($nombreDoc));
	
	// recorremos el resultado
	for ($i=0; $i<mysql_num_rows($resultado); $i++) {
		
		// creamos el item
		$nodo = $doc->appendChild($dom->createElement($nombreItem));
		
		// agregamos los campos que corresponden
		for ($b=0; $b<count($campo); $b++) {
			$campoTexto = $nodo->appendChild($dom->createElement($campo[$b]));
			$campoTexto->appendChild($dom->createTextNode(mysql_result($resultado, $i, $b)));
		}
	}

	// retornamos el archivo XML como cadena de texto
	$dom->formatOutput = true; 
	return $dom->saveXML();    
//}


}

function NominaAdd($nitavu, $xmlCont, $FechaIni, $FechaFin, $periodo, $autorizo){
require("config.php");
$sql = "INSERT INTO nominas
(nitavu, xmlCont, FechaIni, FechaFin, historia_nitavu, historia_fecha, historia_hora, periodo)
VALUES
('$nitavu', '$xmlCont', '$FechaIni','$FechaFin','$autorizo','$fecha','$hora','$periodo')";
if ($conexion->query($sql) == TRUE)
{	//echo "ok";
	//notificamos
	$mensaje="<p>Buen dia ".nitavu_nombre($nitavu)."</p>";
	$mensaje=$mensaje."<p>Ya esta disponible el recibo de tu nomina en la plataforma, correspondiente al perido ".$periodo." que comprende de ".$FechaIni." a ".$FechaFin."</p>";
	$mensaje=$mensaje."<p>Para descargarlo entra a la plataforma con tus datos de acceso, y en la parte inferior en preferencias, encontraras la pestaña <b>Mi Nomina</b></p><p>Si no te ha llegado notificacion a tu correo, te sugiero activarlo en la plataforma o comlibrte al departamento de Informatica.</p><p>Un Saludo</p>";
	$mensaje=$mensaje."";
	$quienEnvia = titular('57'); //Titular de Contabilidad
	notificacion_add($nitavu, 'Nomina '.$FechaIni.' a '.$FechaFin, $fecha, $quienEnvia, $mensaje);
	historia($autorizo,"Integro a la plataforma el recibo de nomina del empleado ".nitavu_nombre($nitavu)."");
	return TRUE;

}
	else
{	////echo $sql;
	return FALSE;
}
}


function Nitavu_real($NEmpleado){
    $real = substr($NEmpleado, 1, 10);
    if (substr($real, 0, 1) == '0'){
        $real = substr($NEmpleado, 2, 10);    
        
        if (substr($real, 0, 1) == '0'){
			$real = substr($NEmpleado, 3, 10);    
				if (substr($real, 0, 1) == '0'){
					$real = substr($NEmpleado, 4, 10);    
				}

        }    
    }
    return $real;
}


function NominaPeriodo($FechaInicio, $FechaFin){
require("config.php");
$sql = "select numeroperiodo from nom10002 where nom10002.fechainicio >='".$FechaInicio."' and nom10002.fechafin <='".$FechaFin."'";
////echo $sql;
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{return $f['numeroperiodo'];}
else
	{return 'FALSE';}
}

function SexoNomina($NEmpleado){
require("config.php");
$sql = "select sexo from nom10001 where nom10001.codigoempleado ='".$NEmpleado."'";
////echo $sql;
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{return $f['sexo'];}
else
	{return '';}
}


function EdoCivilNomina($NEmpleado){
require("config.php");
$sql = "select estadocivil from nom10001 where nom10001.codigoempleado ='".$NEmpleado."'";
////echo $sql;
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{return $f['estadocivil'];}
else
	{return '';}
}

function recibirCorreos($id){
require("config.php");
$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{return $f['recibirCorreos'];}
else
	{return FALSE;}
}

function informar_usuariosapps($idapp, $contenido,$yo){
require("config.php"); $texto="";
$sql = "select empleados.nitavu, nombre from empleados, aplicaciones_permisos WHERE empleados.nitavu = aplicaciones_permisos.nitavu AND aplicaciones_permisos.idapp='".$idapp."'";
//echo $sql;
$r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())
{
	$texto ="<p> Buen Dia <b>".$f['nombre']."</b></p>";
	$texto = $texto."<p>Con el áfan de mejorar el modo en el que interactuas con la plataforma y apoyarte en su manejo, hemos actualizado la ayuda de la aplicacion ".app_nombre($idapp).".</p>";
	$texto = $texto."<br><br><b>ACTUALIZACION:</b>".$contenido;
	notificacion_add($f['nitavu'], 'Actualizacion de '.app_nombre($idapp), $fecha, '2809', $contenido);
	historia($yo,"Informo de la actualizacion de ".app_nombre($idapp)." a ".$f['nombre']);
}


}

function insertar_widget($idapp, $usuario)
{
	if (sanpedro($idapp, $usuario)==TRUE){
		echo "<div class='widget'>";	
		include("widget_actividad.php");
		echo "</div>";
	}
}

function sonido_mensaje($n){
if ($n>0){
$tmp="";
$tmp = $tmp.'<script >';
$tmp = $tmp.'var sounds = new Array(';
$tmp = $tmp.'new Audio("audios/mensaje.wav"), ';
$tmp = $tmp.'	
var i = 1;
playSnd();

function playSnd() {
    i++;
    if (i == sounds.length) return;
    sounds[1].currentTime = -5;
    sounds[i].addEventListener("ended", playSnd);
    sounds[i].play();
}
</script>

';
echo $tmp;
}


}


function ayuda_nombre($id){
require("config.php");
$sql = "SELECT * FROM aplicaciones WHERE idapp='".$id."'";
$rc= $conexion -> query($sql);
$msg="";
if($f = $rc -> fetch_array())
	{ return "<h1>".$f['nombre']."</h1>"."<label>(".$f['descripcion'].")</label>";  }
else {return FALSE;}

}


function ayuda_ayuda($id){
require("config.php");
$sql = "SELECT ayuda, idapp FROM aplicaciones WHERE idapp='".$id."'";
$rc= $conexion -> query($sql);
$msg="";
if($f = $rc -> fetch_array())
	{ return $f['ayuda'];}
else {return FALSE;}

}


function misnotificaciones_n($user){
require("config.php");
$sql = "SELECT count(*) as n FROM notificaciones	 WHERE lectura_fecha='0000-00-00' and nitavu='".$user."'";
$rc= $conexion -> query($sql);
$msg="";
if($f = $rc -> fetch_array())
	{	
		return $f['n'];}
else {return 0;}

}

function segundosNotificacion($user){
	$anterior = ultimoNumero($user);
	$n= misnotificaciones_n($user);
	$agregadas = $n - $anterior;
	echo $anterior;
	echo $n;
	$nn=(3*$agregadas);
	echo $nn;
	return $nn;
}

function traerContenidoNotificacion($usuario, $agregadas){
require("config.php");
	//echo $agregadas;
	$sql = "SELECT nitavu_manda,contenido FROM notificaciones WHERE lectura_fecha='0000-00-00' and nitavu='".$usuario."' ORDER BY id DESC LIMIT ".$agregadas."";
	////echo $sql;
	$contenido="";
	if(!empty($sql) == true){
		$rc= $conexion -> query($sql);
		if($rc){
			while($f = $rc -> fetch_array()){
				$contenido = $contenido.'/'.$f['nitavu_manda'].','.$f['contenido'];
			}
		}
		
	}
	return $contenido;
}

function actualizarNuevoNumero($n,$user){
require("config.php");
$sql = "UPDATE empleados SET numNoti='".$n."' WHERE nitavu='".$user."'";
$resultado = $conexion -> query($sql);
	if ($conexion->query($sql) == TRUE) {
		return TRUE;
	}
	else {
		return FALSE;
	}
}

function ultimoNumero($user){
require("config.php");
$sql = "SELECT numNoti FROM empleados WHERE nitavu='".$user."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array()){	
	return $f['numNoti'];
}else{
	return 0;
}

}


function org_json(){
//ESTA FUNCION AFECTA 3 NIVELES EN SU BUSQUEDA, DE NECESITARSE MAS AJUSTAR LA BUSQUED A MAS	
require("config.php");
$j="";
$sql = "SELECT * FROM cat_gerarquia WHERE id='0'";

if ($conexion->query($sql) == TRUE){
	$r2 = $conexion -> query($sql = "SELECT * FROM cat_gerarquia WHERE id='0'"); while($f = $r2 -> fetch_array())
	{if (org_dependencias($f['id'])==0){$j=$j."{'name' : '".$f['nombre']."', 'title': '".nitavu_nombre($f['titular'])."', 'className': '".$f['nivel']."'},";}
	else{
		$j=$j."'name' : '".$f['nombre']."', 'title': '".nitavu_nombre($f['titular'])."', 'className': '".$f['nivel']."', 'children':[";


		$r3 = $conexion -> query($sql = "SELECT * FROM cat_gerarquia WHERE dependencia='".$f['id']."'"); while($f3 = $r3 -> fetch_array())
		{if (org_dependencias($f3['id'])==0){$j=$j."{'name' : '".$f['nombre']."', 'title': '".nitavu_nombre($f3['titular'])."', 'className': '".$f3['nivel']."'},";}
		else{
			$j=$j."{'name' : '".$f3['nombre']."', 'title': '".nitavu_nombre($f3['titular'])."', 'className': '".$f3['nivel']."', 'children':[";


		$r4 = $conexion -> query($sql = "SELECT * FROM cat_gerarquia WHERE dependencia='".$f3['id']."'"); while($f4 = $r4 -> fetch_array())
		{if (org_dependencias($f4['id'])==0){$j=$j."{'name' : '".$f4['nombre']."', 'title': '".nitavu_nombre($f4['titular'])."', 'className': '".$f4['nivel']."'},";}
		else{
			$j=$j."{'name' : '".$f4['nombre']."', 'title': '".nitavu_nombre($f4['titular'])."', 'className': '".$f4['nivel']."', 'children':[";


		$r5 = $conexion -> query($sql = "SELECT * FROM cat_gerarquia WHERE dependencia='".$f4['id']."'"); while($f5 = $r5 -> fetch_array())
		{if (org_dependencias($f5['id'])==0){$j=$j."{'name' : '".$f5['nombre']."', 'title': '".nitavu_nombre($f5['titular'])."', 'className': '".$f5['nivel']."'},";}
		else{
			$j=$j."{'name' : '".$f5['nombre']."', 'title': '".nitavu_nombre($f5['titular'])."', 'className': '".$f5['nivel']."', 'children':[";


		
		$r6 = $conexion -> query($sql = "SELECT * FROM cat_gerarquia WHERE dependencia='".$f5['id']."'"); while($f6 = $r6 -> fetch_array())
		{if (org_dependencias($f6['id'])==0){$j=$j."{'name' : '".$f6['nombre']."', 'title': '".nitavu_nombre($f6['titular'])."', 'className': '".$f6['nivel']."'},";}
		else{
			$j=$j."{'name' : '".$f6['nombre']."', 'title': '".nitavu_nombre($f6['titular'])."', 'className': '".$f6['nivel']."', 'children':[";


		$r7 = $conexion -> query($sql = "SELECT * FROM cat_gerarquia WHERE dependencia='".$f6['id']."'"); while($f7 = $r7 -> fetch_array())
		{if (org_dependencias($f7['id'])==0){$j=$j."{'name' : '".$f7['nombre']."', 'title': '".nitavu_nombre($f7['titular'])."', 'className': '".$f7['nivel']."'},";}
		else{
			$j=$j."{'name' : '".$f7['nombre']."', 'title': '".nitavu_nombre($f7['titular'])."', 'className': '".$f7['nivel']."', 'children':[";

		$r8 = $conexion -> query($sql = "SELECT * FROM cat_gerarquia WHERE dependencia='".$f7['id']."'"); while($f8 = $r8 -> fetch_array())
		{if (org_dependencias($f8['id'])==0){$j=$j."{'name' : '".$f8['nombre']."', 'title': '".nitavu_nombre($f8['titular'])."', 'className': '".$f8['nivel']."'},";}
		else{
			$j=$j."{'name' : '".$f8['nombre']."', 'title': '".nitavu_nombre($f8['titular'])."', 'className': '".$f8['nivel']."', 'children':[";


		


		$j =$j."]},"; //3
		}  
		//$j = substr($j, 0, -2);//quita coma
		}	
		


		$j =$j."]},"; //3
		}  
		//$j = substr($j, 0, -2);//quita coma
		}	
		


		$j =$j."]},"; //3
		}  
		//$j = substr($j, 0, -2);//quita coma
		}	


		$j =$j."]},"; //3
		}  
		//$j = substr($j, 0, -2);//quita coma
		}	



		$j =$j."]},"; //3
		}  
		//$j = substr($j, 0, -2);//quita coma
		}	



		$j =$j."]},"; //3
		}
		//$j = substr($j, 0, -2);//quita coma
		}	


		$j =$j."]"; //3
	}}

}

return $j;

}


function org_dependencias($nodo){
//ESTA FUNCION AFECTA 3 NIVELES EN SU BUSQUEDA, DE NECESITARSE MAS AJUSTAR LA BUSQUED A MAS	
require("config.php");
$j="";
$sql = "select count(*) as n from cat_gerarquia where dependencia = '".$nodo."'";
if ($conexion->query($sql) == TRUE)
{	$rc = $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		return $f['n'];
	}
	else {
		return 0;
	}

} else {
	return 0;
}



}



function submenu_add($url, $icono, $texto1, $texto2){
		echo "<article>";
		echo "<table width=100%><tr><td width=50%>";		
		echo "<a href='$url' rel='MyModal:open'><img src='icon/$icono'></a></td>";
		echo "<td width=50%><a href='$url'>$texto1<br><b> $texto2</b></a></td>";
		echo "</tr></table>";
		echo "</article>";
}

function quienesmijefe($nuc){
//ESTA FUNCION AFECTA 3 NIVELES EN SU BUSQUEDA, DE NECESITARSE MAS AJUSTAR LA BUSQUED A MAS	
require("config.php");
$midpto = nitavu_dpto($nuc);

$sql = "SELECT * FROM cat_gerarquia WHERE id='".$midpto."'";
////echo $sql;
if ($conexion->query($sql) == TRUE)
{	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{if ($f['titular']==''){//si no hay titular
			//buscamos de quien depende el dpto------------------------------------------ 2
			$sql = "SELECT * FROM cat_gerarquia WHERE id='".$f['dependencia']."'";			
			////echo $sql;
			if ($conexion->query($sql) == TRUE)
			{	$rc2= $conexion -> query($sql);
				if($f2 = $rc2 -> fetch_array()){
				if ($f2['titular']==''){//si este tampoco tiene titular vamos al siguiente
					//buscamos de quien depende este dpto------------------------------------------ 3
					$sql = "SELECT * FROM cat_gerarquia WHERE id='".$f2['dependencia']."'";
					////echo $sql;
					if ($conexion->query($sql) == TRUE)
					{	$rc3= $conexion -> query($sql);
						if($f3 = $rc3 -> fetch_array()){
						if ($f3['titular']==''){//si este tampoco tiene titular vamos al siguiente
							
									//buscamos de quien depende este dpto------------------------------------------ 4
										$sql = "SELECT * FROM cat_gerarquia WHERE id='".$f3['dependencia']."'";
										////echo $sql;
										if ($conexion->query($sql) == TRUE)
										{	$rc4= $conexion -> query($sql);
											if($f4 = $rc4 -> fetch_array()){
											if ($f4['titular']==''){//si este tampoco tiene titular vamos al siguiente
												


												
											}
											else{return $f4['titular']; //Damos el titular de este dpto en su nivel 3		
											}
										}}



						}
						else{return $f3['titular']; //Damos el titular de este dpto en su nivel 3		
						}
					}}




				} else{return $f2['titular']; //Damos el titular de este dpto
				}

			}}




	}
		else{return $f['titular']; //Titular de tu Dpto
	}}
}
else { return FALSE;}

	

}


function refresh($page){
//header('location:$page');
echo "<script> 

window.location.replace('$page'); 

</script>";
	
}
function estoy_enmesadetemas($id, $tema){
require("config.php");
$sql = "SELECT * FROM pendientes_eq WHERE integrante='".$id."' and nombre='".$tema."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
	return TRUE;
}
else
{ return FALSE;}
}


function tema_estado($id){
require("config.php");
$sql = "SELECT * FROM pendientes WHERE id='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
	return $f['estado'];
}
else
{ return FALSE;}
}




function pendientes_eq_nombre($id){
require("config.php");
$sql = "SELECT * FROM pendientes_eq WHERE id='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
	return $f['nombre'];
}
else
{ return FALSE;}
}

function pendientes_autor($id){
require("config.php");
$sql = "SELECT * FROM pendientes WHERE id='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
	return $f['autor'];
}
else
{ return FALSE;}
}




function pendientes_id_nombre($id){
require("config.php");
$sql = "SELECT * FROM pendientes WHERE id='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
	return $f['tema'];
}
else
{ return FALSE;}
}



function pendientes_tema_equipo($id){
require("config.php");
$sql = "SELECT * FROM pendientes WHERE id='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
	return $f['equipo'];
}
else
{ return FALSE;}
}


function correo($mail_dest, $mail_dest_name, $replymail, $replymail_name, $asunto, $contenido, $nuc, $file1='', $file2=''){
//sleep(3);//retraso programado
require("config.php");
$Asunto = $asunto;
$Contenido = $contenido;
$CorreoDestino = $mail_dest;
$DestinoName = $mail_dest_name;

	if (EnviarCorreo($Asunto, $Contenido, $CorreoDestino, $DestinoName)==TRUE){
		return TRUE;
	} else {
		return FALSE;
	}

}











function pases_dptosaut_n($nitavu){
require("config.php"); $dptos = "";
$sql = "SELECT count(*) as n FROM empleados_salidas_autoriza_excepcion WHERE (nitavu='".$nitavu."')";
////echo $sql;
	$rc = $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		return $f['n'];
	}

}





function pases_dptosaut($nitavu){
require("config.php"); $dptos = "";
$sql = "SELECT * FROM empleados_salidas_autoriza_excepcion WHERE (nitavu='".$nitavu."')";
$r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())
{
	$dptos = $dptos.$f['dpto'].", ";
}
return substr($dptos, 0, -2);
}



function pases_dptosaut_nombre($nitavu){
require("config.php"); $dptos = "";
$sql = "SELECT * FROM empleados_salidas_autoriza_excepcion WHERE (nitavu='".$nitavu."')";
////echo $sql;
$r2 = $conexion -> query($sql); while($f = $r2 -> fetch_array())
{
	$dptos = $dptos.dpto_id($f['dpto']).", ";
}
return substr($dptos, 0, -2);
}


function misdptos($nuc){
	require("config.php");
	// /recuperacion del nivel 1	
	if ($nuc == ""){
		return "";
	} else {
	$sql = "
	SELECT
		cat_gerarquia.id as Edpto,
		cat_gerarquia.titular as Etitular,
		cat_gerarquia.nombre,
		(SELECT nombre from empleados where nitavu=Etitular) as nombre
	FROM	cat_gerarquia
	where dependencia = '".nitavu_dpto($nuc)."'
	
	
	";	
	//echo "<hr>1:<br>".$sql;
	$misdptos=nitavu_dpto($nuc).", ";
	$rc= $conexion -> query($sql);
	while($f = $rc -> fetch_array()) {
		//"<hr> 1:<br>".var_dump($f)."";
		$misdptos = $misdptos.$f['Edpto'].", ";
	
		//recuperacion del nivel 2	
		$sql = "
		SELECT
			cat_gerarquia.id as Edpto,
			cat_gerarquia.titular as Etitular,
			cat_gerarquia.nombre,
			(SELECT nombre from empleados where nitavu=Etitular) as nombre
		FROM	cat_gerarquia
		where dependencia = '".$f['Edpto']."'
	
	
		";	
		//echo "<hr>2:<br>".$sql;
		$rc2= $conexion -> query($sql);
		while($f2 = $rc2 -> fetch_array()) {
			//"<hr> 2:<br>".var_dump($f2)."";
			$misdptos = $misdptos.$f2['Edpto'].", ";
	
			//recuperacion del nivel 3
			//recuperacion del nivel 2	
			$sql = "
			SELECT
				cat_gerarquia.id as Edpto,
				cat_gerarquia.titular as Etitular,
				cat_gerarquia.nombre,
				(SELECT nombre from empleados where nitavu=Etitular) as nombre
			FROM	cat_gerarquia
			where dependencia = '".$f2['Edpto']."'
	
	
			";	
			//	echo "<hr>3:<br>".$sql;
			$rc3= $conexion -> query($sql);
			while($f3 = $rc3-> fetch_array()) {
				//"<hr> 3:<br>".var_dump($f3)."";
				$misdptos = $misdptos.$f3['Edpto'].", ";
	
				//recuperacion del nivel 4
				$sql = "
				SELECT
					cat_gerarquia.id as Edpto,
					cat_gerarquia.titular as Etitular,
					cat_gerarquia.nombre,
					(SELECT nombre from empleados where nitavu=Etitular) as nombre
				FROM	cat_gerarquia
				where dependencia = '".$f3['Edpto']."'
	
	
				";	
				//	echo "<hr>4:<br>".$sql;
				$rc4= $conexion -> query($sql);
				while($f4 = $rc4 -> fetch_array()) {
					//"<hr> 4:<br>".var_dump($f4)."";
					$misdptos = $misdptos.$f4['Edpto'].", ";
	
	
			}//4
	
		}//3
	
	}//2
	
	}//1
	return substr($misdptos, 0, -2);

	}
}



function misdptos_sinmi($nuc){
	require("config.php");
//recuperacion del nivel 1	
$sql = "
SELECT
	cat_gerarquia.id as Edpto,
	cat_gerarquia.titular as Etitular,
	cat_gerarquia.nombre,
	(SELECT nombre from empleados where nitavu=Etitular) as nombre
FROM	cat_gerarquia
where dependencia = '".nitavu_dpto($nuc)."'


";	
//echo "<hr>1:<br>".$sql;
$misdptos="";
$rc= $conexion -> query($sql);
while($f = $rc -> fetch_array()) {
	//"<hr> 1:<br>".var_dump($f)."";
	$misdptos = $misdptos.$f['Edpto'].", ";

	//recuperacion del nivel 2	
	$sql = "
	SELECT
		cat_gerarquia.id as Edpto,
		cat_gerarquia.titular as Etitular,
		cat_gerarquia.nombre,
		(SELECT nombre from empleados where nitavu=Etitular) as nombre
	FROM	cat_gerarquia
	where dependencia = '".$f['Edpto']."'


	";	
	//echo "<hr>2:<br>".$sql;
	$rc2= $conexion -> query($sql);
	while($f2 = $rc2 -> fetch_array()) {
		//"<hr> 2:<br>".var_dump($f2)."";
		$misdptos = $misdptos.$f2['Edpto'].", ";

		//recuperacion del nivel 3
		//recuperacion del nivel 2	
		$sql = "
		SELECT
			cat_gerarquia.id as Edpto,
			cat_gerarquia.titular as Etitular,
			cat_gerarquia.nombre,
			(SELECT nombre from empleados where nitavu=Etitular) as nombre
		FROM	cat_gerarquia
		where dependencia = '".$f2['Edpto']."'


		";	
		//	echo "<hr>3:<br>".$sql;
		$rc3= $conexion -> query($sql);
		while($f3 = $rc3-> fetch_array()) {
			//"<hr> 3:<br>".var_dump($f3)."";
			$misdptos = $misdptos.$f3['Edpto'].", ";

			//recuperacion del nivel 4
			$sql = "
			SELECT
				cat_gerarquia.id as Edpto,
				cat_gerarquia.titular as Etitular,
				cat_gerarquia.nombre,
				(SELECT nombre from empleados where nitavu=Etitular) as nombre
			FROM	cat_gerarquia
			where dependencia = '".$f3['Edpto']."'


			";	
			//	echo "<hr>4:<br>".$sql;
			$rc4= $conexion -> query($sql);
			while($f4 = $rc4 -> fetch_array()) {
				//"<hr> 4:<br>".var_dump($f4)."";
				$misdptos = $misdptos.$f4['Edpto'].", ";


		}//4

	}//3

}//2

}//1
return substr($misdptos, 0, -2);
}

function comida_salio($id, $autorizo, $quien){
require("config.php");
$sql = "UPDATE empleados_salidas_temporal SET registro_salida='".$hora."' wHERE id='".$id."'";
////echo $sql;
$resultado = $conexion -> query($sql);
if ($conexion->query($sql) == TRUE) {
	historia($autorizo, "Dio salida del pase de comida con ID".$id.", de ".nitavu_nombre($quien)." (".$quien.")");
	//header('location:../vigilancia3.php');
	return TRUE;
}
else {
	return FALSE;
}
}

function ActCurpSexoEstadoCivil($Nitavu_real, $Curp, $Sexo, $EdoCivil, $autorizo){
require("config.php");
    $sql = "UPDATE empleados SET curp='".$Curp."', sexo='".$Sexo."', estadocivil='".$EdoCivil."' WHERE nitavu='".$Nitavu_real."'";
    ////echo $sql;
    
    //$resultado = $conexion -> query($sql);
   if ($conexion->query($sql) == TRUE){
        historia($autorizo, "Actualizo el Curp (".$Curp."), Sexo(".$Sexo.") y Estado Civil(".$EdoCivil.") de ".nitavu_nombre($Nitavu_real));        
        
    }
    else {echo "error".$sql;}
}


function correo_limite(){
require("config.php");
$sql = "SELECT count(*) as n from correos where fecha=CURDATE()";
////echo $sql;
$limite=0; $nuc='';
$resultado = $conexion -> query($sql);
if ($conexion->query($sql) == TRUE) {
	if($f = $resultado -> fetch_array())
	{	
		$limite = $correo_limite - $f['n']; //Correos disponibles

		if ($limite<0){$limite=0;} // Si sale negativo = 0		
		
		if ($limite<=50) //Alerta
		{
			notificacion_add ('2809', 'chat', $fecha, '2809', '<b class=alerta>ALERTA</b> de correos: Se ha llegado a su limite, quedan '.$limite.' de '.$correo_limite.'. Se han intentado enviar correos, se han marcado como no enviados.'); //alerta juanjonitavu		
			notificacion_add ('1533', 'chat', $fecha, '2809', '<b class=alerta>ALERTA</b> de correos: Se ha llegado a su limite, quedan '.$limite.' de '.$correo_limite.'. Se han intentado enviar correos, se han marcado como no enviados.'); //alerta javier
			
		} 

		return $limite;

		
	} 

}
else {return 0;}

}


function comida_entro($id, $autorizo, $quien){
require("config.php");
$sql = "UPDATE empleados_salidas_temporal SET registro_entrada='".$hora."' wHERE id='".$id."'";
$resultado = $conexion -> query($sql);
if ($conexion->query($sql) == TRUE) {
	historia($autorizo, "Dio entrada al pase de comida con ID".$id.", de ".nitavu_nombre($quien)." (".$quien.")");
	//header('location:../vigilancia3.php');
	return TRUE;
}
else {
	return FALSE;
}
}




function nocomida_salio($id, $autorizo, $quien){
require("config.php");
$sql = "UPDATE empleados_salidas_temporal SET registro_salida='".$hora."' wHERE id='".$id."'";
////echo $sql;
$resultado = $conexion -> query($sql);
if ($conexion->query($sql) == TRUE) {
	historia($autorizo, "Dio salida del pase de salida Oficial con ID".$id.", de ".nitavu_nombre($quien)." (".$quien.")");
	//header('location:../vigilancia3.php');
	return TRUE;
}
else {
	return FALSE;
}
}

function nocomida_entro($id, $autorizo, $quien){
require("config.php");
$sql = "UPDATE empleados_salidas_temporal SET registro_entrada='".$hora."' wHERE id='".$id."'";
$resultado = $conexion -> query($sql);
if ($conexion->query($sql) == TRUE) {
	historia($autorizo, "Dio entrada al pase de salida Oficial con ID".$id.", de ".nitavu_nombre($quien)." (".$quien.")");
	//header('location:../vigilancia3.php');
	return TRUE;
}
else {
	return FALSE;
}
}
















function ingresos_totales($IdDelegacion, $fecha_){ //NOTIFICACIONES, TOTALES
require("config.php");		
$sql = "select sum(ingresos) as ingreso from ingresos_vivienda where IdDelegacion=".$IdDelegacion." and fecha='".$fecha_."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{if ($f['ingreso']==''){return 0; }else {return $f['ingreso'];}
	
	} else {return 0;}
}


function notifi_total($nitavu){ //NOTIFICACIONES, TOTALES
require("config.php");		
$sql = "SELECT count(*) as n FROM notificaciones WHERE (nitavu='".$nitavu."')";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{return $f['n'];} else {return 0;}
}

function notifi_sinleer($nitavu){ //NOTIFICACIONES, TOTALES
require("config.php");		
$sql = "SELECT count(*) as n FROM notificaciones WHERE (nitavu='".$nitavu."' AND lectura_hora='')";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{return $f['n'];} else {return 0;}
}



function notifi_leidas($nitavu){ //NOTIFICACIONES, TOTALES
require("config.php");		
$sql = "SELECT count(*) as n FROM notificaciones WHERE (nitavu='".$nitavu."' AND lectura_hora<>'')";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{return $f['n'];} else {return 0;}
}


function notifi_enviadassinleer($nitavu){ //NOTIFICACIONES, TOTALES
require("config.php");		
$sql = "SELECT count(*) as n FROM notificaciones WHERE (nitavu_manda='".$nitavu."'AND lectura_hora='') ORDER by entregar_fecha ASC";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{return $f['n'];} else {return 0;}
}

function comida_aut($nitavu){ //consulta experiencia del usuario
require("config.php");		
$sql = "select comida from empleados where nitavu='".$nitavu."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{
	return $f['comida'];

	} else {
		return 0;
	}
}


function comida_salida($nitavu){ //consulta experiencia del usuario
require("config.php");		
$sql = "select * from empleados_salidas_temporal where nitavu='".$nitavu."' and fecha='".$fecha."' and asunto='COMIDA'";
////echo $sql;
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{
	return $f['registro_salida'];

	} else {
		return FALSE;
	}
}


function comida_salida2($nitavu, $fecha2){ //consulta experiencia del usuario
require("config.php");		
$sql = "select * from empleados_salidas_temporal where nitavu='".$nitavu."' and fecha='".$fecha2."' and asunto='COMIDA'";
////echo $sql;
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{
	return $f['registro_salida'];

	} else {
		return FALSE;
	}
}


function comida_estado($nitavu){ //consulta experiencia del usuario
require("config.php");		
$sql = "select * from empleados_salidas_temporal where nitavu='".$nitavu."' and fecha='".$fecha."' and asunto='COMIDA'";
////echo $sql;
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
	if ($f['autorizo_nitavu']==''){
			return "Esperando autorizacion del pase para comida de las ".$f['hora_desde'];
		} else
		{
			return "Pase Autorizado por ".nitavu_nombre($f['autorizo_nitavu'])." y disponible en Caseta";

		}
		

} else {
	return FALSE;
}
}


function comida_trestante($nitavu){ //consulta experiencia del usuario
require("config.php");		
$sql = "select * from empleados_salidas_temporal where nitavu='".$nitavu."' and fecha='".$fecha."' and asunto='COMIDA'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{
		$thasta = tiempo_sumar_hr(comida_aut($f['nitavu']), $f['registro_salida']);
		$trestante = tiempo_restar_hr($hora, $thasta);
	if (($f['registro_entrada']=='00:00:00') AND ($f['registro_salida']<>'00:00:00')  ){//aun esta afuera
		if ($trestante > comida_salida($f['nitavu']) ){
			if ($f['registro_entrada']=='' or $f['registro_entrada']=='00:00:00')
			{
				$trestante = tiempo_restar_hr($thasta, $hora);//se hace con la hora el retraso ya que no entro
			}
			else {
				$trestante = tiempo_restar_hr($thasta, $f['registro_entrada']);//se hace con la hora de registro de entrada, para dar cuanto se retraso
			}
			return "-".$trestante;	
		} else {return $trestante."";}

	} else {
		// ya se realizo el pase
		if (($f['registro_entrada']=='00:00:00') AND ($f['registro_salida']=='00:00:00')  ){
			//Pase sin realizar
			return '*'.'Salida: '.hora12($f['registro_salida']).", Entrada: ".hora12($f['registro_entrada']);	
		} else {
			return '+'.'Salida: '.hora12($f['registro_salida']).", Entrada: ".hora12($f['registro_entrada']);
		}
		
	}
	
		

	} else {
		return 0;
	}
}

function paselibre($npase){ //consulta experiencia del usuario
require("config.php");		
$sql = "SELECT id from empleados_salidas_temporal where id='".$npase."'";
	$rc= $conexion -> query($sql); if($f = $rc -> fetch_array())
	{return FALSE;	}
	else {return  TRUE;}

}

function xd($idap, $nitavu){ //consulta experiencia del usuario
require("config.php");		
$sql = "SELECT	* from xd where idap='".$idap."' and iduser='".$nitavu."'";
	$rc= $conexion -> query($sql); if($f = $rc -> fetch_array())
	{return $f['c'];	}
	else {return  0;}

}

function xd_update($idap, $nitavu){//actualizar sd
require("config.php");		
$sql = "SELECT	* from xd where idap='".$idap."' and iduser='".$nitavu."'";
	$rc= $conexion -> query($sql); if($f = $rc -> fetch_array())
	{//update
		$c = xd($idap, $nitavu) + 1;
		$sql="UPDATE xd SET c='".$c."', fecha ='".$fecha."', url='".URLActual()."' WHERE idap='".$idap."' and iduser='".$nitavu."'";
		if ($conexion->query($sql) == TRUE)
			{return 'Actualizada entrada para'.$idap.' con '.$nitavu;}
		else {return 'No se actualizo';}



	
	} else { // insert
		$sql = "INSERT INTO xd (idap, iduser, c, fecha, url) VALUES ('".$idap."', '".$nitavu."', 1, '".$fecha."','".URLActual()."')";
		if ($conexion->query($sql) == TRUE)
			{return 'Agregada entrada para '.$idap.' con '.$nitavu;}
		else {return 'No se agrego entrada';}

	}




}
















//REPORTEADOR

function pendientes_($nitavu){
require("config.php");
$id_aplicacion ="ap54"; //ap06=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){

$sql2="select * from pendientes_direccion where pendiente_estado = 0 ";
$r2 = $conexion -> query($sql2);
//$msg = nombre_corto($nitavu,0)." ".nombre_corto($nitavu,1)." Tienes ";
$msg = "";
$pendientes =  "";
$c = 0;
while($f = $r2 -> fetch_array())
	{//$df recorre la lista de las delegaciones
	$pendientes = $pendientes.$f['pendiente_nombre'].", ";
	$c= $c +1;
	}
//$msg = $msg.$c." pendientes, en la Mesa de Temas. "	.$pendientes.".";
if ($c>0) {//habla($msg);
}
return $msg;
}

}






function habla($quedigo){
	echo "<script>habla('".$quedigo."', 'Spanish Latin American Female', {volume: 100}); </script>";
	// echo "<script>responsiveVoice.speak('".$quedigo."', 'Spanish Latin American Female', {volume: 100}); </script>";
	//echo "<script>responsiveVoice.speak('".$quedigo."', 'Spanish Female', {volume: 100}); </script>";
      //onclick='responsiveVoice.speak("Hola Mundo", "Spanish Latin American Female");' type='button' value='🔊 Play'  class='Mbtn btn-default'/>
   //responsiveVoice.speak('Probando Sintetizador de audio', 'Spanish Female', {volume: 100});
   //responsiveVoice.speak('Probando Sintetizador de audio', 'Spanish Latin American Female', {volume: 100});
   //onstart: StartCallback, onend: EndCallback}
}



	function pendiente_direccion_participantes_faltan($tema){
	require("config.php");		
		$sql = "
		SELECT
			*,
			nitavu as nitavu_,
			(select count(*) from pendientes_direccion_votos where votador=nitavu_ and pendiente_nombre='".$tema."') as participacion

		FROM
			aplicaciones_permisos
		WHERE
			idapp = 'ap54'
			
		";
		$cuantos=0;
		$r2 = $conexion -> query($sql); while($lista = $r2 -> fetch_array())
		{
			if ($lista['participacion']==0){
				$cuantos = $cuantos +1;
			}

		}
		return $cuantos;

	}


	function pendiente_direccion_total(){
	require("config.php");		
		$sql = "SELECT	count(*) as n FROM	pendientes_direccion WHERE
		MONTH (pendiente_fecha) = MONTH (NOW())	AND 	YEAR (pendiente_fecha) = YEAR (NOW())";
		$rc= $conexion -> query($sql); if($f = $rc -> fetch_array())
		{return $f['n'];	}
		else {return  $f['n'];}

	}


	function pendiente_direccion_sinaprobar(){
	require("config.php");		
		$sql = "SELECT	count(*) as n FROM	pendientes_direccion WHERE
		MONTH (pendiente_fecha) = MONTH (NOW())	AND 	YEAR (pendiente_fecha) = YEAR (NOW()) AND pendiente_estado=0";
		$rc= $conexion -> query($sql); if($f = $rc -> fetch_array())
		{return $f['n'];	}
		else {return  $f['n'];}

	}


	function pendiente_direccion_ok(){
	require("config.php");		
		$sql = "SELECT	count(*) as n FROM	pendientes_direccion WHERE
		MONTH (pendiente_fecha) = MONTH (NOW())	AND 	YEAR (pendiente_fecha) = YEAR (NOW()) AND pendiente_estado=1";
		$rc= $conexion -> query($sql); if($f = $rc -> fetch_array())
		{return $f['n'];	}
		else {return  $f['n'];}

	}

	function pendiente_direccion_x(){
	require("config.php");		
		$sql = "SELECT	count(*) as n FROM	pendientes_direccion WHERE
		MONTH (pendiente_fecha) = MONTH (NOW())	AND 	YEAR (pendiente_fecha) = YEAR (NOW()) AND pendiente_estado=2";
		$rc= $conexion -> query($sql); if($f = $rc -> fetch_array())
		{return $f['n'];	}
		else {return  $f['n'];}

	}

	function pendiente_direccion_voto($nombre, $nitavu_){
	require("config.php");		
		$sql = "SELECT  * FROM pendientes_direccion_votos WHERE pendiente_nombre='".$nombre."' AND votador='".$nitavu_."'";
		$rc= $conexion -> query($sql); if($f = $rc -> fetch_array())
		{return $f['voto'];	}
		else {return 'FALSE';}

	}


	function pendiente_direccion_votos($nombre, $voto){
	require("config.php");		
		$sql = "SELECT  count(*) as n FROM pendientes_direccion_votos WHERE pendiente_nombre='".$nombre."' AND voto='".$voto."'";
		$rc= $conexion -> query($sql); if($f = $rc -> fetch_array())
		{return $f['n'] ;	}
		else {return 0;}
	}




function embarque_permiso($id){
require("config.php");
$sql = "SELECT * FROM embarques_proveedores WHERE id='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{ return $f['nombre'];} else {return "";}
}



function embarque_proveedor($id){
require("config.php");
$sql = "SELECT * FROM embarques_proveedores WHERE id='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{ return $f['nombre'];} else {return "";}
}

function embarque_rastreo_url($id){
require("config.php");
$sql = "SELECT * FROM embarques_guias WHERE guia='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{ 
		return embarque_proveedor_url($f['paqueteria_id']);
	}
}


function embarque_asignado($id){
require("config.php");
$sql = "SELECT * FROM embarques_guias WHERE guia='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{ 
		return $f['asignacion'];
	}
}

function embarque_origen($id){
require("config.php");
$sql = "SELECT * FROM embarques_guias WHERE guia='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{ 
		return $f['origen'];
	}
}


function embarque_destino($id){
require("config.php");
$sql = "SELECT * FROM embarques_guias WHERE guia='".$id."'";
//echo "<div id='AppDetalle'>".$sql."</div>";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{ 
		
		return $f['destino'];
	}
}



function embarque_recibido($id){
require("config.php");
$sql = "SELECT * FROM embarques_guias WHERE guia='".$id."'";
//echo "<div id='AppDetalle'>".$sql."</div>";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{ 
		return $f['recibido'];
	}
}



function embarque_codigo($id){
require("config.php");
$sql = "SELECT * FROM embarques_guias WHERE guia='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{ 
		return $f['token'];
	}
}

function embarque_descripcion($id){
require("config.php");
$sql = "SELECT * FROM embarques_guias WHERE guia='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{ 
		return $f['descripcion'];
	}
}

function embarque_proveedor_url($id){
require("config.php");
$sql = "SELECT * FROM embarques_proveedores WHERE id='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{ return $f['url_rastreo'];} else {return "";}
}


function reporte_tabla($id){
require("config.php");
$sql = reporte_sql($id);
$cuantas_columnas=0;
$tabla_titulos = "";
$r2 = $conexion -> query($sql); while($finfo = $r2->fetch_field())
{//OBTENER LAS COLUMNAS

        /* obtener posición del puntero de campo */
        $currentfield = $r2->current_field;       
       	$tabla_titulos=$tabla_titulos."<th>".$finfo->name."</th>";
       	$cuantas_columnas = $cuantas_columnas + 1;        
}

$tabla_contenido=""; $cuantas_filas=0;
$r = $conexion -> query($sql); while($f = $r-> fetch_row())
{//LISTAR COLUMNAS

    $tabla_contenido = $tabla_contenido."<tr>";        
    for ($i = 1; $i <= $cuantas_columnas; $i++) {      
        $tabla_contenido = $tabla_contenido."<td>".$f[$i-1]."</td>";       
        }

    $tabla_contenido = $tabla_contenido."</tr>";
    $cuantas_filas = $cuantas_filas + 1;        
}


$t = "<h3>".reporte_titulo($id)."</h3>";
$t = $t."<label class='reporte_descripcion'
>".reporte_descripcion($id)."</label>";

$t = $t."<table class='tabla'>".$tabla_titulos.$tabla_contenido."</table>";
return $t;

}





function reporte_tabla2($id){
require("../config.php");
$sql = reporte_sql($id);
$cuantas_columnas=0;
$tabla_titulos = "<tr>";
$r2 = $conexion -> query($sql); while($finfo = $r2->fetch_field())
{//OBTENER LAS COLUMNAS

        /* obtener posición del puntero de campo */
        $currentfield = $r2->current_field;       
       	$tabla_titulos=$tabla_titulos.'<td style="background-color:black; color:white;">'.$finfo->name."</td>";
       	$cuantas_columnas = $cuantas_columnas + 1;        
}
$tabla_titulos = $tabla_titulos."</tr>";
$tabla_contenido=""; $cuantas_filas=0;
$r = $conexion -> query($sql); while($f = $r-> fetch_row())
{//LISTAR COLUMNAS

    $tabla_contenido = $tabla_contenido."<tr>";        
    for ($i = 1; $i <= $cuantas_columnas; $i++) {      
        $tabla_contenido = $tabla_contenido."<td>".$f[$i-1]."</td>";       
        }

    $tabla_contenido = $tabla_contenido."</tr>";
    $cuantas_filas = $cuantas_filas + 1;        
}


$t = '<h5 style="text-align:center">'.reporte_titulo($id)."</div>";
$t = $t.'<div style="font-size: xx-small;">'.reporte_descripcion($id)."</div>";

$t = $t.'<table border="1" style="font-size: xx-small;">'.$tabla_titulos.$tabla_contenido."</table>";
return $t;

}






?>

<?php





function nfoto($consulta){
require("config.php");
$sql = "SELECT * FROM contadores WHERE id='0'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
	if ($consulta==TRUE) {
	return $f['nfoto'];
}
else
{ // sino es consulta entonces aumentarle y aumentar el contador de ceropapel
// la diferencia entre ceropapel y este, es que cero papel se multiplica
// por las copias que se entregan o con copia, para estadistica de cuanto se ha ahorrado
	$n2 = $f['nfoto'] + 1;
	$sql="UPDATE contadores SET nfoto='".$n2."' WHERE id='0'";
	$resultado = $conexion -> query($sql);
	if ($conexion->query($sql) == TRUE) {
	return $f['nfoto'];
	}
	else {return  FALSE;}
	}
	}
	else
	{ return FALSE;}
}





function npase($consulta){
require("config.php");
$sql = "SELECT * FROM contadores WHERE id='0'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
	if ($consulta==TRUE) {
	return $f['npase_idenficador'].$f['npase'];
}
else
{ // sino es consulta entonces aumentarle y aumentar el contador de ceropapel
// la diferencia entre ceropapel y este, es que cero papel se multiplica
// por las copias que se entregan o con copia, para estadistica de cuanto se ha ahorrado
	$n2 = $f['npase'] + 1;
	//$n2 = $f['npase_idenficador'].$n2;
	$sql="UPDATE contadores SET npase='".$n2."' WHERE id='0'";
	$resultado = $conexion -> query($sql);
	if ($conexion->query($sql) == TRUE) {
	return $f['npase_identificador'].$n2;
	}
	else {return  FALSE;}
	}
	}
	else
	{ return FALSE;}
}




function token_correo($consulta){
require("config.php");
$sql = "SELECT * FROM contadores WHERE id='0'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
	if ($consulta==TRUE) {
	return $f['npase_idenficador'].$f['correo_token'];
}
else
{ // sino es consulta entonces aumentarle y aumentar el contador de ceropapel
// la diferencia entre ceropapel y este, es que cero papel se multiplica
// por las copias que se entregan o con copia, para estadistica de cuanto se ha ahorrado
	$n2 = $f['correo_token'] + 1;
	//$n2 = $f['npase_idenficador'].$n2;
	$sql="UPDATE contadores SET correo_token='".$n2."' WHERE id='0'";
	$resultado = $conexion -> query($sql);
	if ($conexion->query($sql) == TRUE) {
	return $f['npase_identificador'].$n2;
	}
	else {return  FALSE;}
	}
	}
	else
	{ return FALSE;}
}





function tarjeta_dpto($id){
require("config.php");
$sql = "SELECT * FROM cat_gerarquia WHERE id='".$id."'";
$rc= $conexion -> query($sql);
$msg="";
if($f = $rc -> fetch_array())
{

	echo "<div id='dpto_box'>";
	echo "<h1>".$f['nombre']."</h1>";
	echo "<table><tr>";
	$foto= "<img src='fotos/".$f['titular'].".jpg' class='foto_org1'>";
	//echo "<td width='20%'>".$foto."</td>";
	echo "<td>";
	echo "<h3>".nitavu_nombre($f['titular'])."</h3>";
	echo "<nav>";
	echo "<a href='' class=''><img src='icon/tel.png' style='width: 18px;'><span class='pc'>".nitavu_tel($f['titular'])."</span></a>";
	echo "<a href='' class=''><img src='icon/mail.png' style='width: 18px;'></a>";
	echo "<a href='' class=''><img src='icon/msg.png' style='width: 18px;'></a>";
	echo "</nav>";
	echo "</td>";
	echo "</tr></table>";
	echo "</div>";


}
else
{ return "";}



}

function sentimental($msg){
  	  echo "<div id='sentimental'>";
      echo "<table border='0'>";
      echo "<tr>";
      echo "<td width='50px' align='left' valign='middle'><img src='icon/404.png'></td>";
      echo "<td align='center'  valign='middle'>".$msg."</td>";
      echo "</tr>";
      echo "</table>";
      echo "</div>";

}


function req_alertas($nitavu_, $sugerencia){
require("config.php");
//funcion que otorga acceso a las aplicaciones
$sql = "INSERT INTO req_conceptos_alertas
(nitavu, fecha, id_concepto)
VALUES
('$nitavu_', '$fecha', '$sugerencia')";
if ($conexion->query($sql) == TRUE)
{	//echo "ok";
	return 'TRUE';
}
	else
{	////echo $sql;
	return 'FALSE';
}
}

function req_sugerencia($nitavu_, $sugerencia){
require("config.php");
//funcion que otorga acceso a las aplicaciones
$sql = "INSERT INTO req_conceptos_sugerencias
(nitavu, fecha, concepto)
VALUES
('$nitavu_', '$fecha', '$sugerencia')";
if ($conexion->query($sql) == TRUE)
{	//echo "ok";
	return 'TRUE';
}
	else
{	////echo $sql;
	return 'FALSE';
}
}





function nivel_detalle($n, $clase){
require("config.php");
$sql = "SELECT * FROM aplicaciones_nivelusuario WHERE id='".$n."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{

	echo "<div id='nivel_detalle'>";
	echo "<table border='0'><tr>";
	echo "<td align='right' width='50%'><img src='icon/nivel_".$n.".png' class='".$clase."'></td><td align='left' width='50%'>".$f['modo']."</td>";
	echo "</tr></table>";
	echo "</div>";
}
else
{
	
}

}








function doc_historia($id, $programa, $folio, $delegacion){
require("config.php");
$sql = "SELECT * FROM digital_itavu WHERE id_documento='".$id."' and programa='".$programa."' and folio='".$folio."' and delegacion='".$delegacion."'";
////echo $sql;
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
	return $f['historia'];
}
else
{
	return '';
}

}






function manzana_pendientes($id_colonia, $id_municipio, $manzana){
require("config.php");
$sql = "
SELECT
	count(*) as n
FROM
	notificadores_visitas
WHERE
	id_colonia = '".$id_colonia."' and manzana='".$manzana."' and visitada='' and id_municipio='".$id_municipio."'
";
////echo $sql;
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
	return $f['n'];
}
else
{
	return '';
}

}


function cat_edo_vivienda($id){
require("config.php");
$sql = "
select cat_estado_lotes_vivienda.EstatusLote
from cat_estado_lotes_vivienda
WHERE cat_estado_lotes_vivienda.IdEstatus = ".$id."

";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
	return $f['EstatusLote'];
}
else
{
	return '';
}

}



function escritura_lista($contrato){
require("config.php");
// $sql = "SELECT * FROM tmp_escrituraslistas WHERE contrato='".$contrato."'";
// $rc= $conexion -> query($sql);
// if($f = $rc -> fetch_array())
// {
// 	return 'TRUE';
// }
// else
// {
// 	return 'FALSE';
// }
return 'FALSE';
}





function notificadores_colonia_faltan($colonia){
require("config.php");
$sql = "SELECT
	count(*) AS total,
	(
		SELECT
			count(*)
		FROM
			notificadores_visitas
		WHERE
			id_colonia = '".$colonia."'
		AND visitada = 'TRUE'
	) AS visitadas,
	(
		100 / count(*) * (
			SELECT
				count(*)
			FROM
				notificadores_visitas
			WHERE
				id_colonia = '".$colonia."'
			AND visitada = 'TRUE'
		)
	) AS porcentaje
FROM
	notificadores_visitas
WHERE
	id_colonia = '".$colonia."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
	$faltan = $f['total'] - $f['visitadas'];
	return $faltan;
}
else
{
	return 'FALSE';
}

}




function notificadores_colonia_manzana_avance($colonia, $m){
require("config.php");
$sql = "SELECT
	count(*) AS total,
	(
		SELECT
			count(*)
		FROM
			notificadores_visitas
		WHERE
			id_colonia = '".$colonia."'
		AND visitada = 'TRUE'
		AND manzana = '".$m."'
	) AS visitadas,
	(
		100 / count(*) * (
			SELECT
				count(*)
			FROM
				notificadores_visitas
			WHERE
				id_colonia = '".$colonia."'
			AND visitada = 'TRUE'
		)
	) AS porcentaje
FROM
	notificadores_visitas
WHERE
	id_colonia = '".$colonia."'
	AND manzana='".$m."'
	";

////echo $sql;
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
	if ($f['porcentaje']<=100 AND $f['porcentaje']>1)
	{ return $f['porcentaje'];}
	else {
		return "0";
	}
}
else
{
	return 'FALSE';
}

}




function notificadores_colonia_avance($colonia){
require("config.php");
$sql = "SELECT
	count(*) AS total,
	(
		SELECT
			count(*)
		FROM
			notificadores_visitas
		WHERE
			id_colonia = '".$colonia."'
		AND visitada = 'TRUE'
	) AS visitadas,
	(
		100 / count(*) * (
			SELECT
				count(*)
			FROM
				notificadores_visitas
			WHERE
				id_colonia = '".$colonia."'
			AND visitada = 'TRUE'
		)
	) AS porcentaje
FROM
	notificadores_visitas
WHERE
	id_colonia = '".$colonia."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
	return $f['porcentaje'];
}
else
{
	return 'FALSE';
}

}




function id_estadoubv_nombre($id){
require("config.php");
$sql = "SELECT * FROM cat_estado_ubv WHERE id='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
	return $f['nombre'];
}
else
{
	return '';
}

} 






function id_transpaso($id){
require("config.php");
$sql = "SELECT * FROM cat_transpasos  WHERE id='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
	return $f['nombre'];
}
else
{
	return '';
}

} 







function id_estado_lote_nombre($id){
require("config.php");
$sql = "SELECT * FROM cat_estado_lotes WHERE id='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
	return $f['nombre'];
}
else
{
	return '';
}

} 

function programa_nombre($id){
require("config.php");
$sql = "SELECT * FROM cat_programa WHERE IdPrograma='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
	return $f['Programa'];
}
else
{
	return '';
}

}

function colonia_nombre($id, $id_municipio){
require("config.php");
$sql = "SELECT * FROM cat_colonias WHERE (IdColonia='".$id."' AND IdMunicipio='".$id_municipio."')";
////echo $sql;
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
	return $f['Colonia'];
}
else
{
	return '';
}

}


function lotes_colonia($IdMunicipio, $IdColonia){
require("config.php");
$sql = "SELECT * FROM lotes WHERE (IdMunicipio='".$IdMunicipio."' AND IdColonia='".$IdColonia."')";
$r = $conexion -> query($sql);
$r_count = $r -> num_rows;
return $r_count;
}


function lotes_($IdMunicipio, $IdColonia){
require("config.php");
$sql = "SELECT * FROM lotes WHERE (IdMunicipio='".$IdMunicipio."' AND IdColonia='".$IdColonia."')";
$r = $conexion -> query($sql);
$r_count = $r -> num_rows;
return $r_count;
}




function app_icono($idapp){
	require("config.php");
	$sql = "SELECT * FROM aplicaciones WHERE idapp='".$idapp."'";
	$rc= $conexion -> query($sql);
	$msg="";
	if($f = $rc -> fetch_array())
	{
		return $f['icono'];
		
	
	}
	else
	{ return FALSE;}
}

function app_descripcion($idapp){
require("config.php");
$sql = "SELECT * FROM aplicaciones WHERE idapp='".$idapp."'";
$rc= $conexion -> query($sql);
$msg="";
if($f = $rc -> fetch_array())
{
	return $f['nombre']."(".$f['descripcion'].")";
	

}
else
{ return FALSE;}
}


function notifica_mejora($idapp, $m, $quien){
require("config.php");
$sqlx = "SELECT * FROM aplicaciones_permisos WHERE (idapp='".$idapp."' )";
$c=0;
$r= $conexion -> query($sqlx);	
while($f2 = $r -> fetch_array())
				{
				//echo nitavu_nombre($f2['nitavu'])."<br>";
				notifica ($f2['nitavu'], "Mejora de la Aplicacion ".app_nombre($idapp), date('Y-m-d'), $quien,$m); //SU personal
				//echo notifica ($f2['nitavu'], "Mejora de la Aplicacion ", $fecha, $quien,$m); //SU personal
				
				$c= $c +1;
				}
return $c;				

}



function dpto_id($id){
require("config.php");
if ($id>0){
$sql = "SELECT * FROM cat_gerarquia WHERE id='".$id."'";
$rc= $conexion -> query($sql);
$msg="";
if($f = $rc -> fetch_array())
{
return $f['nombre'];
}
else
{ return FALSE;}
}else {return '';}
}



function soytitular($id){
require("config.php");
$sql = "SELECT * FROM cat_gerarquia WHERE titular='".$id."'";
$rc= $conexion -> query($sql);
$msg="";
if($f = $rc -> fetch_array()){
	return $f['id'];
}else{
	return 'FALSE';}
}


function titular($id){
require("config.php");
$sql = "SELECT * FROM cat_gerarquia WHERE id='".$id."'";
//echo $sql;
$rc= $conexion -> query($sql);
$msg="";
if($f = $rc -> fetch_array())
{
return $f['titular'];
}
else
{ return 'FALSE';}
}

function notifica ($usuario, $asunto, $entregar_fecha, $itavu_manda, $contenido){

	return notificacion_add ($usuario, $asunto, $entregar_fecha, $itavu_manda, $contenido);
}



function dir_list_count($ruta){
$directorio = opendir("
$ruta"); //ruta actual
$tmp="";
$path=".".$ruta;
$directorio=dir($path);
//echo "Directorio ".$path.":<br><br>";
$c=0;
while ($archivo = $directorio->read())
{
	if ($archivo<>"." and $archivo<>".."){
    //$tmp=$tmp.$archivo.", ";
	$c= $c +1;

	}


}

return $c;
$directorio->close();

}



function dir_list($ruta){
$ruta=$ruta.".";
$directorio = opendir("$ruta"); //ruta actual
$tmp="";
$path=".".$ruta;
$directorio=dir($path);
echo "Directorio ".$path."<br><br>";
while ($archivo = $directorio->read())
{
	if ($archivo<>"." and $archivo<>".."){
    $tmp=$tmp.$archivo.", ";
	}


}

return $tmp;
$directorio->close();

}



function FTP_existe_archivo($archivo){
	$id_ftp=FTP_conectar(); //Obtiene un manejador y se conecta al Servidor FTP
	$fileSize = ftp_size($id_ftp, FTP_ruta().$archivo);
	if ($fileSize != -1) {return "TRUE";} else {return "FALSE";}
}

function FTP_descargar($archivo){
	$lista="";
	$id_ftp=FTP_conectar(); //Obtiene un manejador y se conecta al Servidor FTP
	ftp_pasv($id_ftp, true);
	//echo $archivo;
	
	
	// intenta descargar $server_file y guardarlo en $local_file
	if (ftp_get($id_ftp, "tmp/".$archivo, "".$archivo, FTP_BINARY)) {
    		//return "Se ha guardado satisfactoriamente en $archivo\n";
			return "TRUE";
	} else {
		    return "FALSE";
	}

	 
}

function FTP_descargar_doc($archivo){
	$lista="";
	$id_ftp=FTP_conectar(); //Obtiene un manejador y se conecta al Servidor FTP
	ftp_pasv($id_ftp, true);
	//echo $archivo;

	// intenta descargar $server_file y guardarlo en $local_file
	if (ftp_get($id_ftp, "tmp/".$archivo, "".$archivo, FTP_BINARY)) {
    		//return "Se ha guardado satisfactoriamente en $archivo\n";
			return "TRUE";
	} else {
		    return "FALSE";
	}

	 
}

function get_ftp_mode($file)
{    
    $path_parts = pathinfo($file);
    
    if (!isset($path_parts['extension'])) return FTP_BINARY;
    switch (strtolower($path_parts['extension'])) {
        case 'am':case 'asp':case 'bat':case 'c':case 'cfm':case 'cgi':case 'conf':
        case 'cpp':case 'css':case 'dhtml':case 'diz':case 'h':case 'hpp':case 'htm':
        case 'html':case 'in':case 'inc':case 'js':case 'm4':case 'mak':case 'nfs':
        case 'nsi':case 'pas':case 'patch':case 'php':case 'php3':case 'php4':case 'php5':
        case 'phtml':case 'pl':case 'po':case 'py':case 'qmail':case 'sh':case 'shtml':
        case 'sql':case 'tcl':case 'tpl':case 'txt':case 'vbs':case 'xml':case 'xrc':
            return FTP_ASCII;
    }
    return FTP_BINARY;
}

function FTP_lista(){
	$lista="";
	$id_ftp=FTP_conectar(); //Obtiene un manejador y se conecta al Servidor FTP
	$files = ftp_nlist($id_ftp, '.');
	foreach ($files as $file) {

	$lista = $lista.FTP_ruta().$file . "<br>";
	}
	return $lista;
}
function FTP_leer($archivo_nombre){
$ftp_url="ftp://".FTP_USER.":".FTP_PASSWORD."@".FTP_SERVER.FTP_DIR.$archivo_nombre;
//ftp://desarrollo2:jpedraza@ftp.172.16.90.3/home/desarrollo2/public_html/tam.png

echo $ftp_url;
$archivo = fopen ($ftp_url, "r");
if (!$archivo) {
		return "ERROR";
		
}else {return $archivo;}

}

function FTP_conectar(){
//Permite conectarse al Servidor FTP
	
	$id_ftp=ftp_connect(FTP_SERVER,FTP_PORT); //Obtiene un manejador del Servidor FTP
	//$id_ftp=ftp_ssl_connect(FTP_SERVER,FTP_PORT); //Obtiene un manejador del Servidor FTP
	ftp_login($id_ftp,FTP_USER,FTP_PASSWORD); //Se loguea al Servidor FTP
	ftp_pasv($id_ftp, TRUE); //Establece el modo de conexión
return $id_ftp; //Devuelve el manejador a la función
}


function FTP_subir_post($archivo_local,$archivo_remoto){
//if (isset($_FILES[$archivo_local])){	
	//Sube archivo de la maquina Cliente al Servidor (Comando PUT)
	$id_ftp=FTP_conectar(); //Obtiene un manejador y se conecta al Servidor FTP

	if (ftp_put($id_ftp,FTP_ruta().$archivo_remoto,$_FILES[$archivo_local]['tmp_name'],FTP_BINARY)){
		return "TRUE";} else {return "FALSE";}
	//Sube un archivo al Servidor FTP en modo Binario
	ftp_quit($id_ftp); //Cierra la conexion FTP
//} else {return "FALSE";}
}

function FTP_subir($archivo_local,$archivo_remoto){
	//Sube archivo de la maquina Cliente al Servidor (Comando PUT)
	$id_ftp=FTP_conectar(); //Obtiene un manejador y se conecta al Servidor FTP
	// echo "REMOTO:".$id_ftp,FTP_ruta().$archivo_remoto."\n";
	// echo  "LOCAL:".$archivo_local;
	if (ftp_put($id_ftp,FTP_ruta().$archivo_remoto,$archivo_local,FTP_BINARY)){
		return "TRUE";} else {return "FALSE";}
	//Sube un archivo al Servidor FTP en modo Binario
	ftp_quit($id_ftp); //Cierra la conexion FTP
}

function FTP_ruta(){
	//Obriene ruta del directorio del Servidor FTP (Comando PWD)
	$id_ftp=FTP_conectar(); //Obtiene un manejador y se conecta al Servidor FTP
	$Directorio=ftp_pwd($id_ftp); //Devuelve ruta actual p.e. "/home/willy"
	ftp_quit($id_ftp); //Cierra la conexion FTP
return $Directorio."/"; //Devuelve la ruta a la función
}




//select * from aplicaciones_historia where date_format (fecha_lanzamiento, '%m') = date_format (now(), '%m')
function app_new($id){
require("config.php");
$sql = "
SELECT	COUNT(*) AS n
FROM		aplicaciones_historia
WHERE		(date_format(fecha_lanzamiento, '%m') = date_format(now(), '%m'))
AND  idapp='".$id."'";
$rc= $conexion -> query($sql);
$msg="";
if($f = $rc -> fetch_array())
	{
		if ($f['n']<=0)
		{
			
		}
		else 
		{
			return $f['n'];}
		}
else
	{return " ";}
}


function isURL($url){ 
  if(getimagesize($url))
  	{
    	return true; 
    }else
    {
    	return false;
 	}


}



function IMGweb_tam($clase, $img){
$url="https://www.flickr.com/photos/gobtam/";
$html = file_get_contents($url);
$doc = new DOMDocument();
@$doc->loadHTML($html);
$tags = $doc->getElementsByTagName('img');
$n= 1;
foreach ($tags as $tag) {
			$img = $tag->getAttribute('src'); //echo "<img src='$img'>"."<br>";	
			if (strlen($img)>4){
				$ext = substr($img,-3);
				//if (($ext <> 'gif') and ($ext <> 'png')){
					$srcs[$n]=$img;

					$n= $n+1;
				//	}
			}
	
}

$imgs_encontradas = $n;
$n_rnd =  rand(1, $imgs_encontradas);//seleccionar una en las que se encontro

if ($img=="TRUE"){
	return "<img title='$n_rnd' value='".$srcs[$n_rnd]."' class='$clase'>"; // la enviamos armada con la clase seleccionada
	//return "<img src='".$srcs[0]."' class='$clase'>"; // la enviamos armada con la clase seleccionada
}else{
	return "".$srcs[$n_rnd].""; 
}

}






function Google_images($palabra, $clase, $img){
$palabra= str_replace(" ", "+", $palabra);	
$url="http://www.google.com.mx/search?q=$palabra&source=lnms&tbm=isch&sa=X&ved=0ahUKEwiJs5L4hcPWAhXBLSYKHR9qDGAQ_AUICigB&biw=1680&bih=941";
$html = file_get_contents($url);
$doc = new DOMDocument();
@$doc->loadHTML($html);
$tags = $doc->getElementsByTagName('img');
$n= 1;
foreach ($tags as $tag) {
			$img = $tag->getAttribute('src'); //echo "<img src='$img'>"."<br>";	
			if (strlen($img)>4){
				$ext = substr($img,-3);
				//if (($ext <> 'gif') and ($ext <> 'png')){
					$srcs[$n]=$img;

					$n= $n+1;
				//	}
			}
	
}

$imgs_encontradas = $n;
$n_rnd =  rand(1, $imgs_encontradas);//seleccionar una en las que se encontro

if ($img=="TRUE"){
	return "<img title='$n_rnd' value='".$srcs[$n_rnd]."' class='$clase'>"; // la enviamos armada con la clase seleccionada
	//return "<img src='".$srcs[0]."' class='$clase'>"; // la enviamos armada con la clase seleccionada
}else{
	return "".$srcs[$n_rnd].""; 
}

}


function copiar_img($origen, $destino)
{$msgE='';
$imagen = file_get_contents($origen); // guardamos la imagen en la variable
//file_put_contents('images/imagen_copiada.jpg',$imagen); // guardamos la

	if(file_put_contents($destino,$imagen))
	{ $msgE= "TRUE";
	} else{
		//$msgE= "No se actualizo ".$nombredelcontrol.", ";
		$msgE= "FALSE";
	}
	

return $msgE;
}




// function ping($host, $port) 
// {
// 	//  error_reporting(0);
// 	// // $host = '193.33.186.70'; 
// 	// // $port = 80; 
// 	// $waitTimeoutInSeconds = 2; 
// 	// if($fp = fsockopen($host,$port,$errCode,$errStr,$waitTimeoutInSeconds)){   
// 	//    // It worked 
// 	// //    echo $host."OK";
// 	//    return TRUE;
	   
// 	// } else {
// 	//    // It didn't work 
// 	// //    echo $host."X";
// 	//    return FALSE;
	   
// 	// } 
// 	// fclose($fp);

// 	// $programResult = shell_exec('my script');
	

// 	$str = utf8_encode( exec("ping ".$host) );
// 	return $str;
// 	// if ($str == 0){
// 	// echo "ping succeeded";
// 	// return TRUE;
// 	// }else{
// 	// echo "ping failed";
// 	// return FALSE;
// 	// }
// }




function estado_laboral($id){
require("config.php");
$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
$rc= $conexion -> query($sql);
$msg="";
if($f = $rc -> fetch_array())
	{
	return $f['estado'];

	}
	else
	{
	return '';
	}

}



function mensaje($mensaje, $link){
require("seguridad.php"); 
if (isset($nitavu)){
	$IdEmpleado = $nitavu;
} else{
	$IdEmpleado = "";
}


if ($link==""){
	$link = "index.php";
}
$tipo = substr($mensaje, 0,5);    // devuelve "ef"
if ($tipo=='ERROR'){
	Problema_create("PLATAFORMA", "fn mensaje: ".$mensaje."=>".$link, $IdEmpleado);
}
if ($tipo=='ERROR'){	
	// Problema_create("PLATAFORMA", "".$Mensaje."=>".$link, $IdEmpleado);
	echo '<div id="modal_error"></div>';
}
else{
echo '<div id="modal_oscuro"></div>';
}
	

//echo '<div class="padre">';
//echo '<span class="hijo">';
		if ($tipo=='ERROR'){echo '<div id="msg_error">';}
		else{echo '<div id="mensaje">';}
		echo '<p>'.$mensaje.'</p>';
		echo '<a class="Mbtn btn-danger" href="'.$link.'">Aceptar</a>  ';
		//echo '<a class="Mbtn btn-cancel" href="'.$link.'">Cerrar</a>';
		//habla($mensaje);
		echo '</div>';
		
//echo '</span>';
//echo '</div>';

}

	



function mensaje_html($mensaje, $link=''){
	require("seguridad.php"); 
	if (isset($nitavu)){
		$IdEmpleado = $nitavu;
	} else{
		$IdEmpleado = "";
	}
	
	
	if ($link==""){
		$link = "index.php";
	}
	$tipo = substr($mensaje, 0,5);    // devuelve "ef"
	if ($tipo=='ERROR'){
		Problema_create("PLATAFORMA", "fn mensaje: ".$Mensaje."=>".$link, $IdEmpleado);
	}
	if ($tipo=='ERROR'){	
		// Problema_create("PLATAFORMA", "".$Mensaje."=>".$link, $IdEmpleado);
		echo '<div id="modal_error"></div>';
	}
	else{
	echo '<div id="modal_oscuro"></div>';
	}
		
	
	//echo '<div class="padre">';
	//echo '<span class="hijo">';
			
			echo '<div id="mensaje" style="
			background-color: red;
			width: 50%;
			display: inline-block;
			position: fixed;
			top: 8%;
			left: 23%;
			border-radius: 5px;
			text-align: center;
			font-size: 14pt;
			color: white;
			font-family: Arial;
			padding-bottom:20px;
			">';
			echo '<p>'.$mensaje.'</p>';
			if ($link <> ''){
			echo '<a style="background-color: #0064A7; color: white;  box-shadow: 0 3px #005a96; padding: 10px;
			border-radius: 5px; text-decoration: none;	background-color: #0064A7; color: white; font-family: Arial; box-shadow: 0 3px #005a96; 
			padding:8px;border-radius:8px;text-decoration:none;

			" href="'.$link.'">Aceptar</a>  ';			
			}
			echo '</div>';
			
	//echo '</span>';
	//echo '</div>';
	
}
	
	
	


function ltbox_foto($nitavu, $src, $origen){
$mensaje="
";	

echo '<div id="modal_box"></div>';

//echo '<div class="padre">';
//echo '<span class="hijo">';
		
		echo '<div id="ltbox_foto">';

		echo "<img src='".$src."'>";


		echo '<a class="Mbtn btn-secundario" href="'.$origen.'">Regresar</a>  ';
		echo '</div>';
		
//echo '</span>';
//echo '</div>';

}

	



function mensaje_mantenimiento($nitavu, $link){
	
$mensaje="
<h3 class='alerta'>SECCION EN MANTENIMIENTO</H3>
Disculpe las molestias ".nombre_corto($nitavu,0).", estamos trabajando en mejoras para esta seccion. En breve estara disponible.<br>
Gracias por su comprensión.
";	
if ($link=="") {$link = "../index.php";}

echo '<div id="modal_mantenimiento"></div>';

//echo '<div class="padre">';
//echo '<span class="hijo">';
		
		echo '<div id="mensaje">';
		echo '<p>'.$mensaje.'</p>';
		echo '<a class="Mbtn btn-default" href="'.$link.'">Aceptar</a>  ';
		//echo '<a class="Mbtn btn-cancel" href="'.$link.'">Cerrar</a>';
		echo '</div>';
		
//echo '</span>';
//echo '</div>';

}

	


function habla_notis($pases, $notis){
$tmp="";

$tmp = $tmp.'<script >';

$tmp = $tmp.'var sounds = new Array(';
if ($notis<9){
for ($x = 0; $x <= $notis; $x++) {
    $tmp = $tmp.'new Audio("audio/ring_.wav"), ';
	
} 
}
else
{
	$tmp = $tmp.'new Audio("audio/ring_.wav"), ';
}

	
//$tmp = $tmp.'new Audio("audio/ring_01.wav"), ';	
// $tmp = $tmp.'new Audio("audio/tiene.mp3"), ';

// if ($pases>0){
// 	if ($pases>9) {$tmp = $tmp.'new Audio("audio/algunos.mp3"), ';}
// 	if ($pases==1) {$tmp = $tmp.'new Audio("audio/1.mp3"), ';}
// 	if ($pases==2) {$tmp = $tmp.'new Audio("audio/2.mp3"), ';}
// 	if ($pases==3) {$tmp = $tmp.'new Audio("audio/3.mp3"), ';}
// 	if ($pases==4) {$tmp = $tmp.'new Audio("audio/4.mp3"), ';}
// 	if ($pases==5) {$tmp = $tmp.'new Audio("audio/5.mp3"), ';}
// 	if ($pases==6) {$tmp = $tmp.'new Audio("audio/6.mp3"), ';}
// 	if ($pases==7) {$tmp = $tmp.'new Audio("audio/7.mp3"), ';}
// 	if ($pases==8) {$tmp = $tmp.'new Audio("audio/8.mp3"), ';}
// 	if ($pases==9) {$tmp = $tmp.'new Audio("audio/9.mp3"), ';}	
	
// 	if ($pases==1) {$tmp = $tmp.'new Audio("audio/pase.mp3"), ';} else
// 	{$tmp = $tmp.'new Audio("audio/pases.mp3"), ';}

// 	if ($notis>0) {
// 		$tmp = $tmp.'new Audio("audio/y.mp3"), ';
// 	}
// } 


// if ($notis>0){
// 	if ($notis>9) {$tmp = $tmp.'new Audio("audio/algunas.mp3"), ';}
// 	if ($notis==1) {$tmp = $tmp.'new Audio("audio/1.mp3"), ';}
// 	if ($notis==2) {$tmp = $tmp.'new Audio("audio/2.mp3"), ';}
// 	if ($notis==3) {$tmp = $tmp.'new Audio("audio/3.mp3"), ';}
// 	if ($notis==4) {$tmp = $tmp.'new Audio("audio/4.mp3"), ';}
// 	if ($notis==5) {$tmp = $tmp.'new Audio("audio/5.mp3"), ';}
// 	if ($notis==6) {$tmp = $tmp.'new Audio("audio/6.mp3"), ';}
// 	if ($notis==7) {$tmp = $tmp.'new Audio("audio/7.mp3"), ';}
// 	if ($notis==8) {$tmp = $tmp.'new Audio("audio/8.mp3"), ';}
// 	if ($notis==9) {$tmp = $tmp.'new Audio("audio/9.mp3"), ';}	
	
// 	if ($notis==1) {$tmp = $tmp.'new Audio("audio/notificacion.mp3"), ';} else
// 	{$tmp = $tmp.'new Audio("audio/notificaciones.mp3"), ';}
// } 
// $tmp = $tmp.'new Audio("audio/pendientes.mp3"), ';


$tmp = $tmp.'
	new Audio("audio/silencio.wav"));
var i = -1;
playSnd();

function playSnd() {
    i++;
    if (i == sounds.length) return;
    sounds[1].currentTime = -5;
    sounds[i].addEventListener("ended", playSnd);
    sounds[i].play();
}
</script>

';

if (($notis>0) or ($pases>0)){
	echo $tmp;
}

}





function grafica_bar_histo($campo, $tabla,$especial,$titulo, $w, $h){
	require("config.php");
	$tmp="";
				$c=0;
				$sql2="SELECT DISTINCT ".$campo."  as campo FROM ".$tabla;
				$r2 = $conexion -> query($sql2);
					$tmp= $tmp."['Fecha','Notificaciones'],";
				while($a = $r2 -> fetch_array())
					{
					$sqlx = "SELECT COUNT(*) as n FROM ".$tabla." where ".$campo."='".$a['campo']."'";
					////echo $sqlx;
					$rc= $conexion -> query($sqlx);
					if($f = $rc -> fetch_array())
						{
							$c= $f['n'];
						}
						//$c= solicitudes_jornada_apoyo($a['apoyo']);
						if ($especial=="nitavu") {
									$tmp= $tmp."['".nitavu_nombre($a['campo'])."',".$c."],";
						}
						
						if ($especial=="apoyo") {
									$tmp= $tmp."['".$a['campo']."',".$c."],";
						}
						
						
				
					//echo $a['apoyo']."=".$c."<br>";
					}
				$data =   trim($tmp, ',');
				$grafica = "
<script type='text/javascript'>
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);
function drawChart() {
var data = google.visualization.arrayToDataTable([
				".$data."
				
				
				]);
var options = {
title: 'Top de Notificaciones Diarias',
hAxis: {title: 'Fechas',  titleTextStyle: {color: '#333'}},
vAxis: {minValue: 0}
};
var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
chart.draw(data, options);
}
</script>
<div id='chart_div' style='width: 80%; height: 500px; padding:0px; margin:0px; display:inline-block;'></div>
";
return $grafica;
}
function grafica_pastel($campo, $tabla,$especial,$titulo, $w, $h){
require("config.php");
$tmp="";
$c=0;
$sql2="SELECT DISTINCT ".$campo."  as campo FROM ".$tabla;
$r2 = $conexion -> query($sql2);
while($a = $r2 -> fetch_array())
{
$sqlx = "SELECT COUNT(*) as n FROM ".$tabla." where ".$campo."='".$a['campo']."'";
////echo $sqlx;
$rc= $conexion -> query($sqlx);
if($f = $rc -> fetch_array())
{
$c= $f['n'];
}
//$c= solicitudes_jornada_apoyo($a['apoyo']);
if ($especial=="nitavu") {
$tmp= $tmp."['".nitavu_nombre($a['campo'])."',".$c."],";
}

if ($especial=="apoyo") {
$tmp= $tmp."['".$a['campo']."',".$c."],";
}



//echo $a['apoyo']."=".$c."<br>";
}
$data =   trim($tmp, ',');
$grafica = "
<script type='text/javascript'>
	google.charts.load('current', {'packages':['corechart']});
	google.charts.setOnLoadCallback(drawChart);
function drawChart() {
// Create the data table.
var data = new google.visualization.DataTable();
data.addColumn('string', 'Topping');
data.addColumn('number', 'Slices');
data.addRows([
				".$data."
				
				
				]);
// Set chart options
var options = {'title':'".$titulo."',
'width':".$w.",
'height':".$h."};
// Instantiate and draw our chart, passing in some options.
var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
chart.draw(data, options);
}
</script>
<div id='grafica'><div id='chart_div'></div></div>
";
return $grafica;
}

function presolicitud_no($consulta, $cuantas){
require("config.php");
$sql = "SELECT * FROM contadores WHERE id='0'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
if ($consulta==TRUE) {
return $f['presolicitud'];
}
else
{ // sino es consulta entonces aumentarle y aumentar el contador de ceropapel
// la diferencia entre ceropapel y este, es que cero papel se multiplica
// por las copias que se entregan o con copia, para estadistica de cuanto se ha ahorrado
$docdigital = $f['presolicitud'];
$docdigitalnew = $docdigital + 1;
$ceropapel = $f['ceropapel'] + $cuantas;
$sql="UPDATE contadores SET presolicitud='".$docdigitalnew."', ceropapel='".$ceropapel."' WHERE id='0'";
$resultado = $conexion -> query($sql);
if ($conexion->query($sql) == TRUE) {
return $f['presolicitud'];
}
else {return  FALSE;}
}
}
else
{ return FALSE;}
}


function notificaciones_faltantes($delegacion_id,$brigada_id){
require("config.php");
$sql = "SELECT * FROM notificaciones_old WHERE (id_delegacion='".$delegacion_id."' AND brigada_id='".$brigada_id."' AND folio<>'X')";
$r = $conexionmigra -> query($sql);
$r_count = $r -> num_rows;
return $r_count;

}
function tantos($edad){
$msg="";
if ($edad<=0) {$msg=$edad;}
if (($edad>=20) AND ($edad<30) ){$msg="Veintitantos";}
if (($edad>=30) AND ($edad<40) ){$msg="Treintitantos";}
if (($edad>=40) AND ($edad<50) ){$msg="Cuarentaytantos";}
if (($edad>=50) AND ($edad<60) ){$msg="Cincuentaitantos";}
if (($edad>=60) AND ($edad<70) ){$msg="Sesentaytantos";}
if (($edad>=70) AND ($edad<80) ){$msg="Ochentaytantos";}
if (($edad>=80) AND ($edad<90) ){$msg="Noventaytantos";}
if ($edad>=90) {$msg=$edad;}
return $msg;
}
function cumples_estemes(){
require("config.php");
$sql = "select * from empleados where date_format (fecha_nacimiento, '%m') = date_format (now(), '%m')";
$r = $conexion -> query($sql);
$msg ="";
$c=0;
while($f = $r -> fetch_array())
{
$c= $c+1;
$msg= $msg."".nombre_corto($f['nitavu'],0).", ";
}
if ($c>0){
return "Este mes hay ".$c." cumpleañeros, "." Haz <a class='alerta' href='cumples_lista.php'>clic aqui para saber mas.</a>";
}
else{
return "";
}

}



function cumples_estemes_quienes(){
require("config.php");
$sql = "select * from empleados where date_format (fecha_nacimiento, '%m') = date_format (now(), '%m')";
$r = $conexion -> query($sql);
$msg ="";
$c=0;
while($f = $r -> fetch_array())
{
$c= $c+1;
$msg= $msg."".nombre_corto($f['nitavu'],0).", ";
}
if ($c>0){
$habla = 	"Este mes tenemos ".$c." cumpleañeros, ".$msg;
//habla();
echo "<script>responsiveVoice.speak('".$habla."', 'Spanish Latin American Female', {volume: 100}); </script>";

return "Este mes tenemos ".$c." cumpleañeros, ";
}
else{
return "";
}

}


function edad_curp($fechanacimiento){
	list($ano,$mes,$dia) = explode("/",$fechanacimiento);
	$ano_diferencia  = date("Y") - $ano;
	$mes_diferencia = date("m") - $mes;
	$dia_diferencia   = date("d") - $dia;
if ($dia_diferencia < 0 || $mes_diferencia < 0)
	$ano_diferencia--;
	return $ano_diferencia;
}

function edad($fechanacimiento){
	list($ano,$mes,$dia) = explode("-",$fechanacimiento);
	$ano_diferencia  = date("Y") - $ano;
	$mes_diferencia = date("m") - $mes;
	$dia_diferencia   = date("d") - $dia;
if ($dia_diferencia < 0 || $mes_diferencia < 0)
	$ano_diferencia--;
	return $ano_diferencia;
}
function completar1($id){
require("config.php");
$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
$rc= $conexion -> query($sql);
$completar=0;
$msg="";
if($f = $rc -> fetch_array())
{
if ($f['domicilio_calle']=='') {
$completar= $completar + 1;
$msg = $msg. "Calle, ";
}
if ($f['domicilio_num_ext']=='') {
$completar= $completar + 1;
$msg = $msg. "Num Ext, ";
}
// if ($f['domicilio_num_int']=='') {
// 	$completar= $completar + 1;
// 	$msg = $msg. "Num Int, ";
// }
// if ($f['domicilio_entrecalles']=='') {
// 	$completar= $completar + 1;
// 	$msg = $msg. "Entre Calles, ";
// }
if ($f['domicilio_ciudad']=='') {
$completar= $completar + 1;
$msg = $msg. "Ciudad, ";
}
if ($f['domicilio_colonia']=='') {
$completar= $completar + 1;
$msg = $msg. "colonia, ";
}
if ($f['domicilio_cp']=='') {
$completar= $completar + 1;
$msg = $msg. "CP, ";
}
if ($f['estadocivil']=='0' or $f['estadocivil']=='') {
$completar= $completar + 1;
$msg = $msg. "Estado Civil, ";
}
// if ($f['telefono2']=='') {
// 	$completar= $completar + 1;
// 	$msg = $msg. " * Telefono de Casa, ";
// }
if ($f['telefono_movil']=='') {
$completar= $completar + 1;
$msg = $msg. "Celular, ";
}
// if ($f['correoelectronico']=='') {
// 	$completar= $completar + 1;
// 	$msg = $msg. "correo ";
// }
if ($completar>0){
return "Tiene ".$completar." faltantes de llenar. (".$msg.")";
}
}
else
{ return '';}
}

function municipio_nombre($id){
require("config.php");
$sql = "SELECT * FROM cat_municipios WHERE IdMunicipio='".$id."'";
$rc= $conexion -> query($sql);
$msg="";
if($f = $rc -> fetch_array())
{
return $f['nombre'];

}
else
{
return '';
}
}


function DelegacionDelMunicipio($id){
	require("config.php");
	$sql = "SELECT * FROM cat_municipios WHERE IdMunicipio='".$id."' limit 1";
	// //echo $sql;
	$rc= $conexion -> query($sql);
	$msg="";
	if($f = $rc -> fetch_array())
	{
	return $f['del'];
	
	}
	else
	{
	return '';
	}
	


}


function MunicipioDelegacion1($id){
	require("config.php");
	$sql = "SELECT * FROM cat_municipios WHERE del='".$id."' limit 1";
	// //echo $sql;
	$rc= $conexion -> query($sql);
	$msg="";
	if($f = $rc -> fetch_array())
	{
	return $f['IdMunicipio'];
	
	}
	else
	{
	return '';
	}
	


}

function pase_id_nombre($id){
require("config.php");
$sql = "SELECT * FROM empleados_salidas_temporal WHERE id='".$id."'";
$rc= $conexion -> query($sql);
$msg="";
if($f = $rc -> fetch_array())
{
return nitavu_nombre($f['nitavu']);

}
else
{
return '';
}


}
function brigada($id){
require("config.php");
$sql = "SELECT * FROM brigadas WHERE id='".$id."'";
$rc= $conexion -> query($sql);
$msg="";
if($f = $rc -> fetch_array())
{
return $f['nombre'];

}
else
{
return '';
}


}
function beneficiario_nombre_curp($id){
require("config.php");
$sql = "SELECT * FROM beneficiarios WHERE curp='".$id."'";
$rc= $conexion -> query($sql);
////echo $sql;
if($f = $rc -> fetch_array())
{
return $f['nombre']." ".$f['paterno']." ".$f['materno'];

}
else
{
return '';
}


}
function beneficiario_old_curp($id){
require("config.php");
$sql = "SELECT * FROM beneficiarios_old WHERE id_solicitante='".$id."'";
$rc= $conexionmigra -> query($sql);
$msg="";
if($f = $rc -> fetch_array())
{
return $f['curp'];

}
else
{
return '';
}


}
function beneficiario_idsol($id){
require("config.php");
$sql = "SELECT * FROM beneficiarios WHERE id_solicitante='".$id."'";
$rc= $conexion -> query($sql);
$msg="";
if($f = $rc -> fetch_array())
{
return $f['nombre']." ".$f['paterno']." ".$f['materno'];

}
else
{
return '';
}


}
function notificaciones_entregadas($delegacion_id,$brigada_id){
require("config.php");
$sql = "SELECT * FROM notificaciones_old WHERE (id_delegacion='".$delegacion_id."' AND brigada_id='".$brigada_id."' AND folio='X')";
$r = $conexionmigra -> query($sql);
$r_count = $r -> num_rows;
return $r_count;

}
function notificaciones_disponibles($delegacion_id, $brigada_id){
require("config.php");
$sql = "SELECT * FROM notificaciones_old WHERE (id_delegacion='".$delegacion_id."' AND brigada_id='".$brigada_id."')";
$r = $conexionmigra -> query($sql);
$r_count = $r -> num_rows;
return $r_count;

}
function beneficiario_updatetmp($consulta){
require("config.php");
$resultado = $conexion -> query($sql);
if ($conexion->query($sql) == TRUE) {

return 'OK';
}
else {
return 'X';
}
}
function beneficiario_historia($curp, $string){
require("config.php");
$sql = "SELECT * FROM beneficiarios WHERE curp='".$curp."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{//
$string2 = $f['historia']."<br>".$fecha." : ".$hora." ".$string;

$sql="UPDATE beneficiarios SET historia='".$string2."' WHERE curp='".$curp."'";
$resultado = $conexion -> query($sql);
if ($conexion->query($sql) == TRUE) {
return TRUE;
}
else {return  FALSE;}
}
else
{ return FALSE;}
}
function beneficiario_notirepetidas($curp, $string){
require("config.php");
$sql = "SELECT * FROM beneficiarios WHERE curp='".$curp."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{//
$string2 = $f['noti_repetidas']."<br>".$fecha." : ".$hora." ".$string;

$sql="UPDATE beneficiarios SET noti_repetidas='".$string2."' WHERE curp='".$curp."'";
$resultado = $conexion -> query($sql);
if ($conexion->query($sql) == TRUE) {
return TRUE;
}
else {return  FALSE;}
}
else
{ return FALSE;}
}



function buscar($action, $placeholder, $brig){
echo '                <div id="beta_buscar">';
	echo '<form action="'.$action.'" method="get">';
		if (isset($brig)){
		echo '<input type="hidden" name="'.$brig.'" id="brig" value="">';
		}
		echo '<table broder="1" width="100%"><tr>';
			echo '<td>                    <input required="required" type="text" id="beta_buscar_input" name="busqueda" placeholder="'.$placeholder.'" /></td>';
			echo '<td align="right" width="15px">                    
			<button id="beta_buscar_boton">
			<img  src="icon/buscar.png"></button>
			</td>';
		echo '</tr></table>';
	echo '</form>';
echo '                </div>';
//onclick="searchToggle(this, event)
}

function buscarSinRequired($action, $placeholder, $brig){
	echo '                <div id="beta_buscar">';
		echo '<form action="'.$action.'" method="get">';
			if (isset($brig)){
			echo '<input type="hidden" name="'.$brig.'" id="brig" value="">';
			}
			echo '<table broder="1" width="100%"><tr>';
				echo '<td>                    <input type="text" id="beta_buscar_input" name="busqueda" placeholder="'.$placeholder.'" /></td>';
				echo '<td align="right" width="15px">                    
				<button id="beta_buscar_boton">
				<img  src="icon/buscar.png"></button>
				</td>';
			echo '</tr></table>';
		echo '</form>';
	echo '                </div>';
	//onclick="searchToggle(this, event)
	}


function titulo($string){
echo "<span id='titulares'>";
	echo "<b>".$string."</b>";
echo "</span>";
}
function limpiar_tel($s){
$s = str_replace("-","",$s);
$s = str_replace("(","",$s);
$s = str_replace(")","",$s);
$s = str_replace(" ","",$s);
//para ampliar los caracteres a reemplazar agregar lineas de este tipo:
//$s = str_replace(“caracter-que-queremos-cambiar”,”caracter-por-el-cual-lo-vamos-a-cambiar”,$s);
return $s;
}
function  es_https(){
if (isset($_SERVER['HTTPS'])) {
// Codigo a ejecutar si se navega bajo entorno seguro.
return TRUE;
} else {
// Codigo a ejecutar si NO se navega bajo entorno seguro.
return FALSE;
}
}
function hora12($hora_){
return date("g:ia",strtotime($hora_));
}
function nacimiento($nitavu_){
require("config.php");
$sql = "SELECT * FROM empleados WHERE nitavu='".$nitavu_."'";
$rc= $conexion -> query($sql);
$msg="";
if($f = $rc -> fetch_array())
{
return $f['fecha_nacimiento'];

}


}

function notificadores_pendientes($nitavu){
require("config.php");
$id_delegacion = midelegacion_id($nitavu);
if ($id_delegacion=='') {
	$sql = "SELECT	count(*) as n FROM	notificadores_visitas WHERE	visitada = ''";
} else {$sql = "SELECT	count(*) as n FROM	notificadores_visitas WHERE	visitada = ''AND delegacion = '".$id_delegacion."'";}
////echo $sql;
$rc= $conexion -> query($sql);
$msg="";
if($f = $rc -> fetch_array())
{
	return $f['n'];
}



}



function notificadores_pendientes_vobo($nitavu, $nivel){
require("config.php");
if ($nivel=='2') {
	$id_delegacion = midelegacion_id($nitavu);
	$sql = "
	SELECT
	count(*) as n
	FROM
		notificadores_visitas
	WHERE
		
		vobo='' and visitada<>''
		AND delegacion='".$id_delegacion."'
	";

	}

if ($nivel=='1') {
	$sql="SELECT
	count(*) as n
	FROM
		notificadores_visitas
	WHERE
		visitada<>'' AND vobo=''
	";
}
////echo $sql;
$rc= $conexion -> query($sql);
$r_count = $rc -> num_rows;
if ($r_count>0){
$msg="";
if($f = $rc -> fetch_array())
{
	return $f['n'];
}
}


}



function misdelegaciones_conid($id){
require("config.php");
$sql2="SELECT * FROM notificaciones_config WHERE id='".$id."' ";
$r2 = $conexion -> query($sql2);
$tmp ="";
while($df = $r2 -> fetch_array())
{//$df recorre la lista de las delegaciones
$tmp = $tmp.$df['delegacion_id'].", ";
}
$midelegacion = midelegacion($id);
$p2 = explode(" ",$midelegacion);
$midelegacion_lugar =  $p2[1]; // esto muestra la primera palabra
if ($midelegacion_lugar=='Coordinacion'){}
else{$midelegacion_id = busca_id_delegacion($midelegacion_lugar);}
$tmp = $tmp." ".strtoupper($midelegacion_id).".";
return $tmp;
//$delegaciones_aut = substr($delegaciones_aut, 0, -2); //quita la ultima coma.
}



function misdelegaciones($id){
require("config.php");
$sql2="SELECT * FROM notificaciones_config WHERE id='".$id."' ";
$r2 = $conexion -> query($sql2);
$tmp ="";
while($df = $r2 -> fetch_array())
{//$df recorre la lista de las delegaciones
	$tmp = $tmp.delegacion_id($df['delegacion_id']).", ";
}

$midelegacion = midelegacion($id);
$p2 = explode(" ",$midelegacion);
$midelegacion_lugar =  $p2[1]; // esto muestra la primera palabra

if ($midelegacion_lugar=='Coordinacion'){}
	else{$midelegacion_id = busca_id_delegacion($midelegacion_lugar);}


$tmp = $tmp." ".strtoupper($midelegacion_lugar).".";

return $tmp;
//$delegaciones_aut = substr($delegaciones_aut, 0, -2); //quita la ultima coma.
}


function midelegviviendanombre($nitavu){
	require("config.php");
	$sql="";
	$sql="SELECT	 
	cat_gerarquia.iddelegvivienda, 
	cat_delegaciones.nombre as nombredelegacion
FROM
	cat_gerarquia
	INNER JOIN
	cat_delegaciones
	ON 
		cat_gerarquia.iddelegvivienda = cat_delegaciones.id
	INNER JOIN
	empleados
	ON 
		cat_gerarquia.id = empleados.dpto
WHERE
	empleados.nitavu =".$nitavu; 
$res= $conexion -> query($sql);	
if ($rst=$res->fetch_array()){
	if ($rst['nombredelegacion']==''){
		return 'OFICINAS CENTRALES';
	}else{
		return $rst['nombredelegacion'];
	}


}


}

function midelegviviendaid($nitavu){
	require("config.php");
	$sql="";
	$sql="SELECT	 
	cat_gerarquia.iddelegvivienda, 
	cat_delegaciones.nombre as nombredelegacion
FROM
	cat_gerarquia
	INNER JOIN
	cat_delegaciones
	ON 
		cat_gerarquia.iddelegvivienda = cat_delegaciones.id
	INNER JOIN
	empleados
	ON 
		cat_gerarquia.id = empleados.dpto
WHERE
	empleados.nitavu =".$nitavu; 
$res= $conexion -> query($sql);	
if ($rst=$res->fetch_array()){
	if ($rst['iddelegvivienda']==''){
		//return 0;
		return 'OFICINAS CENTRALES';
	}else{
		return $rst['iddelegvivienda'];
	}
}
else{
	return 'OFICINAS CENTRALES';
}
}




function solicitudes_jornada_apoyo($a){
require("config.php");
$sqlx = "SELECT COUNT(*) as n from solicitudes_jornada where apoyo='".$a."'";
$rc= $conexion -> query($sqlx);
if($f = $rc -> fetch_array())
{

return $f['n'];
}
else
{
return '';
}


}


function CatgerarquiaNivel($id){
	require("config.php");
	$dpto = nitavu_dpto($id);
	$sql = "SELECT * FROM cat_gerarquia WHERE (id='".$dpto."')";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		 return $f['nivel'];
			
		
	}
	else
	{
	return '';
	}
}


function soydelegacion($id){
require("config.php");
$dpto = nitavu_dpto($id);
$sql = "SELECT * FROM cat_gerarquia WHERE (id='".$dpto."')";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
	if($f['nivel']=='Del'){
		return $f['id'];
	}else{
	return FALSE;
	}
}
else
{
return '';
}
}



function delegacion_id($id){
require("config.php");
$sql = "SELECT * FROM cat_delegaciones WHERE (id='".$id."')";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{

return $f['nombre'];
}
else
{
return '';
}


}
function beneficiario_old_nombre($id){
require("config.php");
$sql = "SELECT * FROM empleados WHERE (nitavu='".$nitavu_."' AND departamento like '%legacion%')";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{

return $f['departamento'];
}
else
{
return 'OFICINAS CENTRALES';
}


}


function midelegacion($nitavu_){
require("config.php");
$sql = "SELECT
	cat_gerarquia.id,
	cat_gerarquia.nombre,
	cat_gerarquia.nivel,
	empleados.nitavu,
	empleados.dpto
FROM
	cat_gerarquia,
	empleados
WHERE
	empleados.dpto = cat_gerarquia.id
AND	
	empleados.nitavu = '".$nitavu_."'
and 
	cat_gerarquia.nivel = 'Del'";
	////echo $sql;
$rc= $conexion -> query($sql); if($f = $rc -> fetch_array())
{
	return $f['nombre'];
}
else
{
	return 'OFICINAS CENTRALES';
}

}




function midelegacionconid($nitavu_){
require("config.php");
$sql = "SELECT
	cat_gerarquia.id,
	cat_gerarquia.nombre,
	cat_gerarquia.nivel,
	empleados.nitavu,
	empleados.dpto
FROM
	cat_gerarquia,
	empleados
WHERE
	empleados.dpto = cat_gerarquia.id
AND	
	empleados.nitavu = '".$nitavu_."'
and 
	cat_gerarquia.nivel = 'del'";
	////echo $sql;
$rc= $conexion -> query($sql); if($f = $rc -> fetch_array())
{
	return $f['id'];
}
else
{
	return 'OFICINAS CENTRALES';
}

}

function midelegacion_id($nitavu_){
require("config.php");
$sql = 
"
SELECT
	empleados.nitavu, 
	cat_gerarquia.id, 
	cat_gerarquia.nombre as delegacion_nombre, 
	cat_gerarquia.nivel, 
	cat_delegaciones.nombre as delegacion,
	empleados.dpto,
	empleados.nombre,
	cat_delegaciones.id as iddel
FROM
	cat_gerarquia
	RIGHT JOIN
	empleados
	ON 
		cat_gerarquia.id = empleados.dpto
	LEFT JOIN
	cat_delegaciones
	ON 
		cat_gerarquia.iddelegvivienda = cat_delegaciones.id
		where empleados.nitavu='".$nitavu_."'";

/* "
SELECT
	cat_gerarquia.id,
	cat_gerarquia.nombre AS 'delegacion_nombre',
	cat_gerarquia.nivel,
	empleados.nitavu,
	empleados.dpto,
	cat_delegaciones.nombre AS 'delegacion',
	empleados.nombre,
	cat_delegaciones.id as 'iddel'
FROM
	cat_gerarquia,
	empleados,
	cat_delegaciones
WHERE
	empleados.dpto = cat_gerarquia.id
AND cat_gerarquia.nivel = 'Del'
AND cat_gerarquia.nombre LIKE CONCAT('%', cat_delegaciones.nombre, '%')
AND nitavu = '".$nitavu_."'
 */
////echo $sql;
$rc= $conexion -> query($sql); if($f = $rc -> fetch_array())
{
	return $f['iddel'];
}
else
{
	return '';
}
}


function acceso($nitavu_,$nip){
require("config.php");
$sql = "SELECT * FROM empleados WHERE (nitavu='".$nitavu_."' AND nip='".$nip."')";
$resultado = $conexion -> query($sql);
if ($conexion->query($sql) == TRUE)
{
return TRUE;
}
else
{
return FALSE;
}
}


function fecha_nacimiento($nitavu_,$fechanac, $guarda){
require("config.php");
if ($guarda == TRUE){
$sql="UPDATE empleados SET fecha_nacimiento='".$fechanac."' WHERE (nitavu='".$nitavu_."')";
$resultado = $conexion -> query($sql);
if ($conexion->query($sql) == TRUE)
{
return TRUE;
}
else {return FALSE;}
}
else
{
$sql = "SELECT * FROM empleados WHERE nitavu='".$nitavu_."'";
$rc= $conexion -> query($sql);
$msg="";
if($f = $rc -> fetch_array())
{
return $f['fecha_nacimiento']=='';

}

}

}
function asistencia_entrada($nitavu_){
require("config.php");
$sql = "SELECT * FROM asistencia WHERE nitavu='".$nitavu_."' AND fecha='".$fecha."'";
$rc= $conexion -> query($sql);
$msg="";
if($f = $rc -> fetch_array())
{
return $f['entrada'];
}
else
{ return '';}
}
function busca_id_delegacion($string){
require("config.php");

$sql = "SELECT * FROM cat_delegaciones WHERE (nombre like'%".$string."%')";
////echo $sql;
$rc= $conexion -> query($sql);
////echo $sql;
if($f = $rc -> fetch_array())
{
return $f['id'];
}
else
{
return 'X';
}


}
function asistencia_salida($nitavu_){
require("config.php");
$sql = "SELECT * FROM asistencia WHERE nitavu='".$nitavu_."' AND fecha='".$fecha."'";
$rc= $conexion -> query($sql);
$msg="";
if($f = $rc -> fetch_array())
{
return $f['salida'];
}
else
{ return "";}
}
function nombre_corto($nitavu_,$x){
require("config.php");
$sql = "SELECT * FROM empleados WHERE nitavu='".$nitavu_."'";
$rc= $conexion -> query($sql);
$msg="";
if($f = $rc -> fetch_array())
{
$cadena = $f['nombre'];
$parte = explode(" ",$cadena);
return $parte[$x]; // esto muestra la primera palabra
}
else
{ return FALSE;}
}
function pase_estado($empleado, $desde, $hasta, $todos){
require("config.php");
$tmp = "";
$tmp = "<div class='normal bold grande'>Mostrando pases de ".fecha_larga($desde)." a ".fecha_larga($hasta)." </div>";
$tmp = $tmp. "<table border='0' class='tabla'>";
	$tmp = $tmp. "<tr class='tabla_titulo'>";
		//echo "<td>ID</td>";
		$tmp = $tmp. "<td>ID de Pase</td>";
		$tmp = $tmp. "<td>SOLICITANTE</td>";
		//$tmp = $tmp. "<td>Solicitado</td>";
		$tmp = $tmp. "<td>DESCRIPCION</td>";
		$tmp = $tmp. "<td width='30%'>ESTADO</td>";
	$tmp = $tmp. "</tr>";
	if ($todos=="TRUE"){
			$sql = '
			select 
			fecha,
			nitavu as NEmpleado, dpto,
			(select nombre from empleados where nitavu=NEmpleado) as Nombre,
			(select nombre from cat_gerarquia where id=dpto) as Departamento,

			(select comida from empleados where nitavu=NEmpleado) as TAutorizado,
			registro_salida as TSalida,
			registro_entrada as TEntrada,
			(SELECT SEC_TO_TIME((TIMESTAMPDIFF(MINUTE , TSalida, TEntrada ))*60)) as TUtilizado,
			(SELECT SEC_TO_TIME((TIMESTAMPDIFF(MINUTE , TUtilizado, TAutorizado ))*60)) as TSobrante,
			(
			SELECT IF(TSobrante <0,"RETRASO","")
			) as Estado,



			empleados_salidas_temporal.*
			from 
			empleados_salidas_temporal
			where
			
			
			 fecha>="'.$desde.'" AND fecha<="'.$hasta.'"
			and registro_salida <> "" and registro_entrada  <>""


			ORDER by solicito_fecha, solicito_hora';
			
	}
	else
	{

			$sql = '
			select 
			fecha,
			nitavu as NEmpleado, dpto,
			(select nombre from empleados where nitavu=NEmpleado) as Nombre,
			(select nombre from cat_gerarquia where id=dpto) as Departamento,

			(select comida from empleados where nitavu=NEmpleado) as TAutorizado,
			registro_salida as TSalida,
			registro_entrada as TEntrada,
			(SELECT SEC_TO_TIME((TIMESTAMPDIFF(MINUTE , TSalida, TEntrada ))*60)) as TUtilizado,
			(SELECT SEC_TO_TIME((TIMESTAMPDIFF(MINUTE , TUtilizado, TAutorizado ))*60)) as TSobrante,
			(
			SELECT IF(TSobrante <0,"RETRASO","")
			) as Estado,



			empleados_salidas_temporal.*
			from 
			empleados_salidas_temporal
			where 
			
		
			fecha>="'.$desde.'" AND fecha<="'.$hasta.'"
		
			and nitavu="'.$empleado.'"

			ORDER by solicito_fecha, solicito_hora';
	}
	$r = $conexion -> query($sql);
	// echo $sql;
	$aut="";
	$m="";
	while($f = $r -> fetch_array())
	{ // resultado de la busqueda.................
	if ($f['asunto']=='COMIDA'){
		if ($f['Estado']=='RETRASO'){
			$tmp=$tmp. "<tr class='tabla_tr tabla' style='background-color:red;'>";
		}else {
			$tmp=$tmp. "<tr class='tabla_tr tabla'>";
		}
	} else {
		$tmp=$tmp. "<tr class='tabla_tr tabla' style='background-color:cyan;'>";
		// $tmp=$tmp. "<tr class='tabla_tr tabla'>";
	}
	
		//echo "<td>".$f['id']."</td>";
		$tmp=$tmp. "<td><b style='color:black; font-size:12pt;'>".$f['id']."</b><br>";
		$tmp=$tmp. "<b>Para: ".fecha_larga($f['fecha'])." para las ".$f['hora_desde']."</b><br>";
		$tmp=$tmp. "Solicitado: ".fecha_larga($f['fecha']).""."</td>";
		
		$tmp=$tmp."<td> <b style='font-size:12pt;'>".$f['Nombre']."</b><br>".$f['Departamento']."</td>";

		$tmp=$tmp."<td>";
		if ($f['asunto']== 'COMIDA'){
			$tmp=$tmp."*Tiempo Autorizado:".$f['TAutorizado']."<br>";
		}

		$tmp=$tmp."Tiempo Salida:".$f['TSalida']."<br>";
		$tmp=$tmp."Tiempo Entrada:".$f['TEntrada']."<hr>";		
		$tmp=$tmp."Tiempo Utilizado:".$f['TUtilizado']."<br>";
		if ($f['asunto']== 'COMIDA'){
		if ($f['TSobrante']<0){
			$tmp=$tmp."<b style='background-color:red; color:white;'>Tiempo Sobrante:".$f['TSobrante']."</b><br>";
		} else {
			$tmp=$tmp."Tiempo Sobrante:".$f['TSobrante']."<br>";
		}
		}
		if ($f['asunto']== 'COMIDA'){
			$tmp=$tmp."Estado:".$f['Estado']."<br>";
		}


		$tmp=$tmp."</td>";


		$tmp =$tmp."<td>";
		//$tmp=$tmp. "<td>".$f['solicito_hora']."</td>";
		
		if ($f['autorizo_nitavu']==''){
			$aut="PENDIENTE AUTORIZACION";
		} else {$aut=$m."<br>Autorizado por ".nitavu_nombre($f['autorizo_nitavu'])." a las ".$f['autorizo_hora']." a ".fecha_larga($f['autorizo_fecha']);}


		if ($f['rechazada']=='TRUE'){
			$aut="<b class='alerta bold'>RECHAZADO </b>por ".nitavu_nombre($f['autorizo_nitavu'])." a las ".$f['autorizo_hora']." de ".fecha_larga($f['autorizo_fecha']);
			} 
		else {
			$m = "<b class='normal bold'>Registro:</b>, Salida ".$f['registro_salida']." y regreso ".$f['registro_entrada'];
			
		}
		
		$tmp = $tmp. "".$f['asunto'].": ".$f['justificacion']."<br>".$aut."<br>".$m."</td>";
	$tmp = $tmp. "</tr>";
	}//while
$tmp = $tmp. "</table>";
return $tmp;
}
function pases_desfase($nitavu_, $desde, $hasta, $detalles){
require("config.php");
$sql = "SELECT * FROM empleados_salidas_temporal WHERE (registro_entrada>hora_hasta) AND
(solicito_fecha>='".$desde."') AND (solicito_fecha<='".$hasta."') AND
(nitavu='".$nitavu_."') ORDER by dpto ASC";
$rc= $conexion -> query($sql);
$resumen="";
$r2="";
$total_retraso="00:00:00";

while($f = $rc -> fetch_array()) {
$retraso =  tiempo_restar_hr($f['registro_salida'],$f['registro_entrada']);
$lapso =  tiempo_restar_hr($f['hora_desde'],$f['hora_hasta']);
$lapsoytole =tiempo_sumar_hr($lapso,$tolerancia);
//$resumen=$resumen."b=".$lapsoytole;
if ($retraso>$lapsoytole){
$total_retraso = tiempo_sumar_hr($total_retraso,$retraso);
if ($f['registro_salida']>$f['hora_desde']){
$desfase_permiso = tiempo_restar_hr($f['hora_desde'],$f['registro_salida']);
if ($desfase_permiso>$tolerancia){
//$r2="Salio despues de la hora solicitada ".$desfase_permiso."min";
}
}
else
{
$desfase_permiso = tiempo_restar_hr($f['registro_salida'],$f['hora_desde']);
if ($desfase_permiso>$tolerancia){
//$r2="Salio ".$desfase_permiso." minutos antes de la hora que solicito";
}

}
$resumen = $resumen. "<cite>".fecha_larga($f['solicito_fecha'])." [".$lapso."min] para las ".$f['hora_desde']."<span class='tenue'>(Salida: ".$f['registro_salida'].", Regreso: ".$f['registro_entrada'].")</span> </cite>";
$resumen = $resumen. "<a target='_blank' href='auscencia_pase_estado.php?empleado=".$f['nitavu']."&desde=".$f['solicito_fecha']."&hasta=".$f['solicito_fecha']."'> Ver detalles del pase ".$f['id']."</a><br>";
if ($r2<>""){$resumen=$resumen.$r2;}
$resumen= $resumen."";
}
}
if ($detalles=='TRUE'){
if ($resumen<>""){return "<strong class='alerta grande'>".$total_retraso." min.</strong><br><lu>".$resumen."</lu>";}
}
else
{
return $total_retraso;
}

}
function dia_semana2($fecha_){
$dias = array('Lun','Mar','Mie','Jue','Vie','Sab','Dom');
$n= date('N', strtotime($fecha_));
$fecha = $dias[$n-1];
return $fecha;
//return $fecha_;
//return date('N', strtotime($fecha_));
}
function dia_semana($fecha_){
$dias = array('Lunes','Martes','Miercoles','Jueves','Viernes','Sabado','Domingo');
$n= date('N', strtotime($fecha_));
$fecha = $dias[$n-1];
return $fecha;
//return $fecha_;
//return date('N', strtotime($fecha_));
}


function fecha_lite($fecha_){
//return  dia_semana($fecha_)." ".date('d/m/Y', strtotime($fecha_));
$mes = date('m', strtotime($fecha_));
$mes = (int)$mes -1;
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$mes_largo = $meses[$mes];
//$fecha_salida = dia_semana($fecha_)." ".date('d', strtotime($fecha_))." de ".$mes_largo." de ".date('Y', strtotime($fecha_));;

$fecha_salida = "<div id='fecha_lite'>";
$fecha_salida = $fecha_salida."<span id='fecha_lite_dia'>".dia_semana($fecha_)."</span>";
$fecha_salida = $fecha_salida."<span id='fecha_lite_dia2'>".date('d', strtotime($fecha_))."</span><br>";
$fecha_salida = $fecha_salida."<span id='fecha_lite_resto'>".$mes_largo." de ".date('Y', strtotime($fecha_))."</span>";


$fecha_salida = $fecha_salida."</div>";


return $fecha_salida;
}


function fecha_larga($fecha_){
//return  dia_semana($fecha_)." ".date('d/m/Y', strtotime($fecha_));
$mes = date('m', strtotime($fecha_));
$mes = (int)$mes -1;
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$mes_largo = $meses[$mes];
$fecha_salida = dia_semana($fecha_)." ".date('d', strtotime($fecha_))." de ".$mes_largo." de ".date('Y', strtotime($fecha_));;

return $fecha_salida;
}

function fecha_larga_cumple($fecha_){
//return  dia_semana($fecha_)." ".date('d/m/Y', strtotime($fecha_));
$mes = date('m', strtotime($fecha_));
$mes = (int)$mes -1;
$meses = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$mes_largo = $meses[$mes];
$fecha_salida = dia_semana($fecha_)." ".date('d', strtotime($fecha_))." de ".$mes_largo;

return $fecha_salida;
}





function itop($ip){
require("config.php");
$sql = "SELECT * FROM ipinterface WHERE (ipaddress='".$ip."')";
$r2 = $conexionitop -> query($sql);
$tmp="";
while($f = $r2 -> fetch_array())
{//Categorias de Aplicaciones


echo $f['comment']. " [ mac:".$f['macaddress'].", Gateway: ".$f['ipgateway']."]";


}
}
function pases_detalles($id){
require("config.php");
$sql = "SELECT * FROM empleados_salidas_temporal WHERE (id='$id')";

//$pases = $r -> num_rows;
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
return "".$f['id']." de las ".$f['hora_desde']."hr a las ".$f['hora_hasta']." para el ".$f['fecha']." de asunto ".$f['asunto'];
}
else
{
return FALSE;
}


}


function pases_quien($id){
require("config.php");
$sql = "SELECT * FROM empleados_salidas_temporal WHERE (id='$id')";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
{
return $f['nitavu'];
}
else
{
return FALSE;
}
}


function cuanto_empleados(){
require("config.php");
$sql = "select count(*) as n from empleados where estado=''";
$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
		{return $f['n'];}
	else {return 0;}

}




function cuanto_empleados_correo(){
require("config.php");
$sql = "select count(*) as n from empleados where estado='' and correoelectronico<>''";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{return $f['n'];}
	else {return 0;}

}


function cuanto_empleados_correo_ok(){
require("config.php");
$sql = "select count(*) as n from empleados where estado='' and correoelectronico<>'' and correo_vobo='1'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{return $f['n'];}
	else {return 0;}

}



function carga_apps_free_info(){
require("config.php");
$sql = "SELECT * FROM aplicaciones WHERE (idapcat='8') AND estado = 0  ";
$r2 = $conexion -> query($sql);
$tmp="";
while($f = $r2 -> fetch_array())
{//Categorias de Aplicaciones


$tmp = $tmp."<article>";
	$tmp = $tmp. "<a href='".$f['vinculo']."'>";
		$tmp = $tmp. "<table border='0'><tr><td>";
			
			if ($f['icono']<>"") {
			$tmp = $tmp. "<img src='./icon/".$f['icono']."' class='icono_menu'>";
			}
		$tmp = $tmp. "</td><td><b class='normal menu_font_n'>".$f['nombre'].":</b> ";
		$tmp = $tmp. "<cite class='tenue menu_font_d pc'>".$f['descripcion']."</cite>";
	$tmp = $tmp. "</td></tr></table></a></article>";
	
	
	}
	return $tmp;
	}
	function carga_apps_free(){
	require("config.php");
	$sql = "SELECT * FROM aplicaciones WHERE (idapcat='2') AND version estado = 0 ";
	$r2 = $conexion -> query($sql);
	$tmp="";
	while($f = $r2 -> fetch_array())
	{//Categorias de Aplicaciones
	
	
	$tmp = $tmp."<article>";
		$tmp = $tmp. "<a href='".$f['vinculo']."'>";
			$tmp = $tmp. "<table border='0'><tr><td>";
				
				if ($f['icono']<>"") {
				$tmp = $tmp. "<img src='./icon/".$f['icono']."' class='icono_menu'>";
				}
			$tmp = $tmp. "</td><td><b class='normal menu_font_n'>".$f['nombre'].":</b> ";
			$tmp = $tmp. "<cite class='tenue menu_font_d pc'>".$f['descripcion']."</cite>";
		$tmp = $tmp. "</td></tr></table></a></article>";
		
		
		}
		return $tmp;
		}

function carga_apps($idapcat, $nitavu, $todas){
		require("config.php");
		
		$sql = "SELECT * FROM aplicaciones WHERE (idapcat='".$idapcat."') AND estado=0  ";
		$r2 = $conexion -> query($sql);
		$tmp="";
		while($f = $r2 -> fetch_array())
		{//Categorias de Aplicaciones
		if ($todas==FALSE) {
			if (sanpedro($f['idapp'],$nitavu)==TRUE){
			$tmp = $tmp."<article>";
			$tmp = $tmp. "<a href='".$f['vinculo']."'>";
				$tmp = $tmp. "<table border='0'><tr><td>";
					
					if ($f['icono']<>"") {
					$tmp = $tmp. "<img src='./icon/".$f['icono']."' class='icono_menu'>";
					}
				$tmp = $tmp. "</td><td><b class='normal menu_font_n'>".$f['nombre'].":</b> ";
				$tmp = $tmp. "<cite class='tenue menu_font_d pc'>".$f['descripcion']."</cite>";
			$tmp = $tmp. "</td><td width='10px'>";
			
			// if (app_new($f['idapp'])>=1){
			// 	$tmp= $tmp."<b class='pc new'><a class='tchico tenue' href='info_acercade.php#".$f['idapp']."'>".app_new($f['idapp'])."</a></b>";}
				
			$tmp = $tmp."</td></tr></table></a></article>";
			
			}
		}
		else{

			$tmp = $tmp."<article>";
			$tmp = $tmp. "<a href='".$f['vinculo']."'>";
				$tmp = $tmp. "<table border='0'><tr><td>";
					
					if ($f['icono']<>"") {
					$tmp = $tmp. "<img src='./icon/".$f['icono']."' class='icono_menu'>";
					}
				$tmp = $tmp. "</td><td><b class='normal menu_font_n'>".$f['nombre'].":</b> ";
				$tmp = $tmp. "<cite class='tenue menu_font_d pc'>".$f['descripcion']."</cite>";
			$tmp = $tmp. "</td><td width='10px'>";
			
			// if (app_new($f['idapp'])>=1){
			// 	$tmp= $tmp."<b class='pc new'><a class='tchico tenue' href='info_acercade.php#".$f['idapp']."'>".app_new($f['idapp'])."</a></b>";}
				
			$tmp = $tmp."</td></tr></table></a></article>";
			
			
		}
		} 

		return $tmp;
}



			function visitas($nitavu){
			require("config.php");
			$nivel = aplicacion_nivel('ap15', $nitavu);
			$dpto = nitavu_dpto($nitavu);
			if ($nivel=='1') {
			$sql = "SELECT * FROM visitas WHERE (autorizo_nitavu='')";
			$r= $conexion -> query($sql);
			$visitas = $r -> num_rows;
			return $visitas;
			}
			
			if ($nivel=='2') {
			$sql = "SELECT * FROM visitas WHERE (autorizo_nitavu='' AND dpto='".$dpto."')";
			$r= $conexion -> query($sql);
			$visitas = $r -> num_rows;
			return $visitas;
			}
			
			}
			function pases($nitavu){
			require("config.php");
			$nivel = aplicacion_nivel('ap12', $nitavu);
			$dpto = nitavu_dpto($nitavu);
			$pases = 0;
			if ($nivel==1) {
			$sql = "SELECT * FROM empleados_salidas_temporal WHERE (autorizo_nitavu='' AND solicito_fecha>='".$fecha."')";
			$r= $conexion -> query($sql);
			$pases = $r -> num_rows;
			}
			
			if ($nivel==2) {
			$sql = "SELECT * FROM empleados_salidas_temporal WHERE (autorizo_nitavu='' AND dpto='".$dpto."' AND solicito_fecha>='".$fecha."')";
			$r= $conexion -> query($sql);
			$pases = $r -> num_rows;
			}
			
			return $pases;
			}

function archivo_pases($nitavu, $fecha_, $hr_salida){
	$nombrearchivo = "salidas/".$nitavu."_".str_replace("-", "", $fecha_)."_".str_replace(":", "", $hr_salida)."";
	return $nombrearchivo;
}


			function tiempo_restar_fecha($fecha_i, $fecha_f){
			$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
			$dias 	= abs($dias); $dias = floor($dias);
			return $dias;
			}
			function tiempo_sumar_hr($horaini,$horafin)
			{
			$horai=substr($horaini,0,2);
			$mini=substr($horaini,3,2);
			$segi=substr($horaini,6,2);
			
			$horaf=substr($horafin,0,2);
			$minf=substr($horafin,3,2);
			$segf=substr($horafin,6,2);
			
			$ini=((($horai*60)*60)+($mini*60)+$segi);
			$fin=((($horaf*60)*60)+($minf*60)+$segf);
			
			$dif=$fin+$ini;
			
			$difh=floor($dif/3600);
			$difm=floor(($dif-($difh*3600))/60);
			$difs=$dif-($difm*60)-($difh*3600);
			return date("H:i:s",mktime($difh,$difm,$difs));
			}


function tiempo_restar_hr($horaini,$horafin)
{
	$horai=substr($horaini,0,2);
	$mini=substr($horaini,3,2);
	$segi=substr($horaini,6,2);

	$horaf=substr($horafin,0,2);
	$minf=substr($horafin,3,2);
	$segf=substr($horafin,6,2);

$ini=((($horai*60)*60)+($mini*60)+$segi);
$fin=((($horaf*60)*60)+($minf*60)+$segf);

$dif=$fin-$ini;

	$difh=floor($dif/3600);
	$difm=floor(($dif-($difh*3600))/60);
	$difs=$dif-($difm*60)-($difh*3600);
	return date("H:i:s",mktime($difh,$difm,$difs));


}
			function geo_guarda($nitavu_, $lat, $lon, $descripcion){
			require("config.php");
			$sql = "INSERT INTO empleados_geo
			(nitavu, lat, lon, fecha, hora, descripcion)
			VALUES
			('$nitavu_', '$lat', '$lon', '$fecha', '$hora','$descripcion')";
			if ($conexion->query($sql) == TRUE)
			{
			return TRUE;
			//header('location:../index.php');a
			}
			else
			{
			return FALSE;
			////echo $sql;
			}
			}
			function chat_guardamsj($nitavu_, $mensaje){
			require("config.php");
			$sql = "INSERT INTO chat
			(nitavu, mensaje, fecha, hora)
			VALUES
			('$nitavu_', '$mensaje', '$fecha', '$hora')";
			if ($conexion->query($sql) == TRUE)
			{
			return TRUE;
			//header('location:../index.php');
			}
			else
			{
			return FALSE;
			////echo $sql;
			}
			}


function historia($nitavu_, $descripcion, $IdApp=""){
require("config.php");
	if ($ModoProduccion == TRUE){
		$descripcion = addslashes($descripcion);
		if ($IdApp == ""){
			$sql = "INSERT INTO historia
			(nitavu, fecha, hora, descripcion)
			VALUES
			('$nitavu_', '$fecha', '$hora','$descripcion')";
		} else {
			$sql = "INSERT INTO historia
			(nitavu, fecha, hora, descripcion, IdApp)
			VALUES
			('$nitavu_', '$fecha', '$hora','$descripcion','".$IdApp."')";
		}

		if ($conexion->query($sql) == TRUE)
		{	
			return TRUE;
		}
			else
		{	
			return FALSE;
		}
	} else {
		return FALSE;
	}
}
			

			
			function aplicacion_historia($nitavu_, $descripcion, $version){
			require("config.php");
			//funcion que otorga acceso a las aplicaciones
			$sql = "INSERT INTO aplicacion_historia
			(nitavu, fecha, descripcion, version)
			VALUES
			('$nitavu_', '$fecha', '$descripcion', '$version')";
			if ($conexion->query($sql) == TRUE)
			{
			return TRUE;
			}
			else
			{
			return FALSE;
			}
			}
			function valida_fecha($fecha_){
			if(preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $fecha_)){
			//it's ok
			return TRUE;
			}else{
			//it's bad
			return FALSE;
			}
			}
			function sugerencia($msg){
			$msg = '
			<div id="sugerencias" style="margin-top:10px;">
				<table border="0"><tr>
					<td><img src="./icon/sugerencia.png" class="icono"></td>
					<td class="normal" style="font-size:8pt;">
						'.$msg.'
					</td></tr></table>
				</div>
				';
				return $msg;
				}
				function ponerpdf($archivo,$clase)
				{
				if (file_exists($archivo)){
				return '<iframe src="'.$archivo.'" class="'.$clase.'">
				</iframe>
				<a title="Haga clic aqui para verlo completo" style="color:white;font-weight:bold;" href="'.$archivo.'" target class="Mbtn btn-tercero">
				<table width=100%>
				<tr><td><img src="icon/pdf.png" style="width:25px;"></td>
				<td>				
				Ver completo
				</td></tr>
				</table></a>
				<br><br>';
				}
				else
				{
				return 'Aun no hay archivo';
				}
				}
				
				// function ponerfoto($archivo,$clase)
				// {
					
				// if (file_exists($archivo)){
				
				// //return '<a href="'.$archivo.'" target="_blank"><img src="'.$archivo.'" class="'.$clase.'"></a>';
				// return '<img src="'.$archivo.'" class="'.$clase.'">';

				// }
				// else
				// {
				// return '<img src="img/sinfoto.png" class="'.$clase.'">';
				// }
				// }
				function ponerfoto_org($archivo,$n)
				{
				if (file_exists($archivo)){
				return '<a href="empleados_edit.php?pes=gral&n='.$n.'"><img src="'.$archivo.'" width=100px; height=130px;></a>';
				}
				else
				{
				return '';
				}
				
			}
				function ponerfoto_app($archivo,$clase)
				{
				if (file_exists($archivo)){
				return '<a href="'.$archivo.'"><img src="'.$archivo.'" class="'.$clase.'"></a>';
				}
				else
				{
				//return '<img src="img/sinfoto.png" class="'.$clase.'">';
				return "";
				}
				}
				function ponericono($archivo,$clase)
				{
				if (file_exists($archivo)){
				return '<img src="'.$archivo.'" class="'.$clase.'">';
				}
				else
				{
				return '<img src="icon/sinfoto.png" class="'.$clase.'">';
				}
				}

				function subir2($nombredelcontrol, $archivo, $ext)
				//set_time_limit(5000); // aumenta el tiempo ejecucion del script 5min
				{
				$msgE='';
				if (substr($_FILES[$nombredelcontrol]['type'], 0, 11)=="application"){
					//$msgE ="(".$_FILES[$nombredelcontrol]."no es una foto)";
				}
				else
					{
						if ($_FILES[$nombredelcontrol]['size']<20000000) {
						//$target_path = "".$donde."/";
						$target_path = $archivo.'.'.$ext;
							if(move_uploaded_file($_FILES[$nombredelcontrol]['tmp_name'], $target_path))
							{ $msgE= "";} else{
							//$msgE= "No se actualizo ".$nombredelcontrol.", ";
							$msgE ="no subio";
							}
						} else {//$msgE ="(tamaño superior 10mb)";
						}
				
				}
				
				return $msgE;
				}

//  function renombrarimagenes($carpeta)
//  {
	
// 	if(is_dir($carpeta)){//comprueba que $carpeta sea un directorio					
// 		if($dir = opendir($carpeta)){//abre el directrio					
// 			//recorre el directorio mientras haya archivos
			
// 			while(($archivo = readdir($dir)) !== false){
				
// 				//el if compara que no sea elementos . .. o htaccess
// 				if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess')
// 				{								
// 					$pos = strpos('-', $archivo);

// 					if ($pos === false) {
						
// 						$nombre= explode('.',substr($archivo, 0, strlen($archivo)));
// //echo "<br>".$nombre[0]."==>".$nombre[1];
// 						rename($carpeta."/".$archivo,$carpeta."/".$nombre[0].'-'.ndocumento(false).".".$nombre[1]);
// 					}
// 					else
// 					{
						
// 					}
// 				}
// 			}
			
// 			closedir($dir);
// 		}
// 	}

//  }



function ponerfoto($archivo,$clase)
				{
				//obtengo el directorio
				$carpeta= substr($archivo, 0,  stripos($archivo, '/'));
				//obtengo el Nombre del archivo sin el directorio
				
				//$nombre= explode('-',substr($archivo, stripos($archivo, '/')+1, strlen($archivo)));
						
				
				$pos = strpos('-', $archivo);
				if ($pos === false) {
					$nombre= explode('.',substr($archivo, stripos($archivo, '/')+1, strlen($archivo)));
					//$nombre= explode('.',substr($nombre[0], stripos($nombre[0], '/')+1, strlen($nombre[0])));
					//echo "<br>".$archivo;
				//	$nombre[0]=$archivo;
				
				}
				else
				{
					$nombre= explode('-',substr($archivo, stripos($archivo, '/')+1, strlen($archivo)));
					$nombre= explode('.',substr($nombre[0], stripos($nombre[0], '/')+1, strlen($nombre[0])));	
				}
				
			
				//echo $nombre[0];
				$valores=null;
				$i=0;
				$ext=null;;


								if(is_dir($carpeta)){//comprueba que $carpeta sea un directorio					
									if($dir = opendir($carpeta)){//abre el directrio					
										//recorre el directorio mientras haya archivos
										while(($archivo = readdir($dir)) !== false){
											
											//el if compara que no sea elementos . .. o htaccess
											if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess'){								
												//creamos nuestro elemento comparativo
												//por medio de una funcion de cadena
												
												//obtenemos el nombre de cada archivo en nuestro directorio
												//echo "<br>".$archivo;
																						 
												$comparacion = substr($archivo, 0,  stripos($archivo, '-'));
												
												//comparamos el elemento con nuestro patron
												//y si se cumple lo guardamos en un vector para posteriormente obtener el mayor

											   
												if ($nombre[0] == $comparacion){

													$numero= explode('.',substr($archivo, stripos($archivo, '-')+1, strlen($archivo)));											
													$valores[$i]=$numero[0];
													$ext[$i]=$numero[1];													
													$i++;
												
												}
											}
										}
										
										closedir($dir);
									}
								}

								if ($valores<>''){
								if(sizeof($valores)>1)
								{
									$clave = array_search(max($valores), $valores);
									$ext1=$ext[$clave];
									$archivo= $carpeta."/".$nombre[0]."-".max($valores).".".$ext1;
								}
								else
								{
									$ext1=$ext[0];
									$archivo= $carpeta."/".$nombre[0]."-".$valores[0].".".$ext1;
								 }
								
							    
								 if (file_exists($archivo))
								 {

									if($ext1=='pdf')
									{
										return '<iframe src="'.$archivo.'" class="'.$clase.'"></iframe><a href="'.$archivo.'" target class="btn"><br>Ver completo</a>';
									}
									else
									{
										
										return '<img id="foto" src="'.$archivo.'" class="'.$clase.'">';
									}
								 
								}
								else
								{
									 return '<img src="icon/nofoto.jpg" class="'.$clase.'">';
									 echo "<script>console.log(".$archivo.");</script>";
								}
								}else {
									echo "<script>console.log(".$archivo.");</script>";
									return '<img src="icon/nofoto.jpg" class="'.$clase.'">';
								}
}	







function ponerfoto_src($archivo,$clase)
				{
					
				//obtengo el directorio
				$carpeta= substr($archivo, 0,  stripos($archivo, '/'));
				//obtengo el Nombre del archivo sin el directorio

				//Excelente Yesi! :D, 				
				//Marca un error, si recibe en $archivo  una extension, Ajustarla para (quitar la extension si la detecta)
				//Esto es para que acepte donde se aplico anteriormente esta funcion
				
				//$nombre= explode('-',substr($archivo, stripos($archivo, '/')+1, strlen($archivo)));
						
				
				$pos = strpos('-', $archivo);
				if ($pos === false) {
					$nombre= explode('.',substr($archivo, stripos($archivo, '/')+1, strlen($archivo)));
					//$nombre= explode('.',substr($nombre[0], stripos($nombre[0], '/')+1, strlen($nombre[0])));
					//echo "<br>".$archivo;
				//	$nombre[0]=$archivo;
				
				}
				else
				{
					$nombre= explode('-',substr($archivo, stripos($archivo, '/')+1, strlen($archivo)));
					$nombre= explode('.',substr($nombre[0], stripos($nombre[0], '/')+1, strlen($nombre[0])));	
				}
				
			
				//echo $nombre[0];
				$valores=null;
				$i=0;
				$ext=null;;


								if(is_dir($carpeta)){//comprueba que $carpeta sea un directorio					
									if($dir = opendir($carpeta)){//abre el directrio					
										//recorre el directorio mientras haya archivos
										while(($archivo = readdir($dir)) !== false){
											
											//el if compara que no sea elementos . .. o htaccess
											if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess'){								
												//creamos nuestro elemento comparativo
												//por medio de una funcion de cadena
												
												//obtenemos el nombre de cada archivo en nuestro directorio
												//echo "<br>".$archivo;
																						 
												$comparacion = substr($archivo, 0,  stripos($archivo, '-'));
												
												//comparamos el elemento con nuestro patron
												//y si se cumple lo guardamos en un vector para posteriormente obtener el mayor

											   
												if ($nombre[0] == $comparacion){

													$numero= explode('.',substr($archivo, stripos($archivo, '-')+1, strlen($archivo)));											
													$valores[$i]=$numero[0];
													$ext[$i]=$numero[1];													
													$i++;
												
												}
											}
										}
										
										closedir($dir);
									}
								}

								if ($valores<>''){
								if(sizeof($valores)>1)
								{
									$clave = array_search(max($valores), $valores);
									$ext1=$ext[$clave];
									$archivo= $carpeta."/".$nombre[0]."-".max($valores).".".$ext1;
								}
								else
								{
									$ext1=$ext[0];
									$archivo= $carpeta."/".$nombre[0]."-".$valores[0].".".$ext1;
								 }
								
							    
								 if (file_exists($archivo))
								 {

									
										
									return ''.$archivo.'';
									
								 
								}
								else
								{
								 	return 'icon/sinfoto.png';
								}
								}
}	






function ponerfoto_correo($archivo,$clase)
{
	require('config.php');
	
	$style='border-radius:5px;width:80%;border-width:1px;border-style:solid;border-color:#C8C8C8;padding:10px;background-color:#E5E5E5;';
				//obtengo el directorio
				$carpeta= substr($archivo, 0,  stripos($archivo, '/'));
				//obtengo el Nombre del archivo sin el directorio

				//Excelente Yesi! :D, 				
				//Marca un error, si recibe en $archivo  una extension, Ajustarla para (quitar la extension si la detecta)
				//Esto es para que acepte donde se aplico anteriormente esta funcion
				
				//$nombre= explode('-',substr($archivo, stripos($archivo, '/')+1, strlen($archivo)));
						
				
				$pos = strpos('-', $archivo);
				if ($pos === false) {
					$nombre= explode('.',substr($archivo, stripos($archivo, '/')+1, strlen($archivo)));
					//$nombre= explode('.',substr($nombre[0], stripos($nombre[0], '/')+1, strlen($nombre[0])));
					//echo "<br>".$archivo;
				//	$nombre[0]=$archivo;
				
				}
				else
				{
					$nombre= explode('-',substr($archivo, stripos($archivo, '/')+1, strlen($archivo)));
					$nombre= explode('.',substr($nombre[0], stripos($nombre[0], '/')+1, strlen($nombre[0])));	
				}
				
			
				//echo $nombre[0];
				$valores=null;
				$i=0;
				$ext=null;;


								if(is_dir($carpeta)){//comprueba que $carpeta sea un directorio					
									if($dir = opendir($carpeta)){//abre el directrio					
										//recorre el directorio mientras haya archivos
										while(($archivo = readdir($dir)) !== false){
											
											//el if compara que no sea elementos . .. o htaccess
											if($archivo != '.' && $archivo != '..' && $archivo != '.htaccess'){								
												//creamos nuestro elemento comparativo
												//por medio de una funcion de cadena
												
												//obtenemos el nombre de cada archivo en nuestro directorio
												//echo "<br>".$archivo;
																						 
												$comparacion = substr($archivo, 0,  stripos($archivo, '-'));
												
												//comparamos el elemento con nuestro patron
												//y si se cumple lo guardamos en un vector para posteriormente obtener el mayor

											   
												if ($nombre[0] == $comparacion){

													$numero= explode('.',substr($archivo, stripos($archivo, '-')+1, strlen($archivo)));											
													$valores[$i]=$numero[0];
													$ext[$i]=$numero[1];													
													$i++;
												
												}
											}
										}
										
										closedir($dir);
									}
								}

								if ($valores<>''){
								if(sizeof($valores)>1)
								{
									$clave = array_search(max($valores), $valores);
									$ext1=$ext[$clave];
									$archivo= $carpeta."/".$nombre[0]."-".max($valores).".".$ext1;
								}
								else
								{
									$ext1=$ext[0];
									$archivo= $carpeta."/".$nombre[0]."-".$valores[0].".".$ext1;
								 }
								
							    
								 if (file_exists($archivo))
								 {

									if($ext1=='pdf')
									{
										return '<iframe src="'.$archivo.'" class="'.$clase.'"></iframe><a href="'.$archivo.'" target class="btn"><br>Ver completo</a>';
									}
									else
									{
										//se quitan las ' y agrega style sin clase, y se agrega la url
										
										return '<img src='.$urlsite."/".$archivo.' style='.$style.'>';
									}
								 
								}
								else
								{
								 	return '<img src='.$urlsite.'/icon/sinfoto.png  style='.$style.'>';
								}
								}
}	



function subir($nombredelcontrol, $archivo,$ext) //--------------------------------------------------------------------------

{ $ext =''; $msgE='';
require_once("yes_funciones.php");
//OBTENTGO LA EXTENSIÓN 
//$ext= substr($_FILES[$nombredelcontrol]['name'],strlen($_FILES[$nombredelcontrol]['name'])-3,3);	
$ext = pathinfo( $_FILES[$nombredelcontrol]['name'], PATHINFO_EXTENSION );

if ( isset( $_FILES ) && isset( $_FILES[$nombredelcontrol] ) && !empty( $_FILES[$nombredelcontrol]['name'] && !empty($_FILES[$nombredelcontrol]['tmp_name']) ) ) 
{
	//Hemos recibido el fichero
	//Comprobamos que es un fichero subido por PHP, y no hay inyección por otros medios
	if ( ! is_uploaded_file( $_FILES[$nombredelcontrol]['tmp_name'] ) ) 
	{$msgE= "ERROR: El fichero encontrado no fue procesado por la subida correctamente";} 

	// si es un formato de imagen o pdf		
	if($_FILES[$nombredelcontrol]["type"]=="image/jpg"||$_FILES[$nombredelcontrol]["type"]=="image/jpeg" || $_FILES[$nombredelcontrol]["type"]=="image/pjpeg" || $_FILES[$nombredelcontrol]["type"]=="image/gif" || $_FILES[$nombredelcontrol]["type"]=="image/png" ||mime_content_type($_FILES[$nombredelcontrol]['tmp_name']) == 'application/pdf'  )
	{
		$destino=$archivo.'-'.ndocumento(False).'.'.$ext;			
		if ( is_file($destino ) )
		{
			$msgE= "ERROR: Ya existe almacenado un fichero con ese nombre";
			@unlink(ini_get('upload_tmp_dir').$_FILES[$nombredelcontrol]['tmp_name']);			
		}
			
		if ( ! @move_uploaded_file($_FILES[$nombredelcontrol]['tmp_name'], $destino) ) 
		{
			$msgE= "ERROR: No se ha podido mover el fichero enviado a la carpeta de destino";
			@unlink(ini_get('upload_tmp_dir').$_FILES[$nombredelcontrol]['tmp_name']);
			
		}
		else
		{
			//$msgE= $destino. "";
			$msgE="Archivo subido con exito.!!";
		}
	}
	else
	{
		$msgE= "ERROR: El archivo que intenta subir no tiene un formato correcto.";
		
	}
				
	
	}
	return $msgE;

}//----------------------------------------------------------------------------------------------------------------


				// function subir($nombredelcontrol, $archivo, $ext)
				// {
				// $msgE='';
				
				// if (substr($_FILES[$nombredelcontrol]['type'], 0, 11)=="application"){
				// $msgE= "ERROR: Es una aplicacion";
				// }
				// else
				// {

				// if ($_FILES[$nombredelcontrol]['size']<2000000) 
				// {
					
				// 	if(!empty($_FILES[$nombredelcontrol]['name']))
				// 	{
				// 	//$target_path = "".$donde."/";
				// 	$target_path = $archivo.'.'.$ext;
				// 	if(move_uploaded_file($_FILES[$nombredelcontrol]['tmp_name'], $target_path))
				// 	{ $msgE= "La foto se  ". $archivo.'.'.$ext. " ha guardado exito<br>";
				// 	} 
				// 	else
				// 	{
				// 	//$msgE= "No se actualizo ".$nombredelcontrol.", ";
				
				// 	$msgE= "No se actualizo o cargo foto ";
				// 	}
				// 	}
				// }
				//  else {
				// $msgE ="ERROR: El archivo que intenta subir es mayor de 2mb";
				// }
				
				// }
				
				// return $msgE;
				// }
				
				function subirpdf($nombredelcontrol, $archivo, $ext)
				{
				$msgE='';
				
				if (substr($_FILES[$nombredelcontrol]['type'], 0, 11)=="application"){
				$msgE= "ERROR: Es una aplicacion".substr($_FILES[$nombredelcontrol]['type'], 0, 11);
				}
				else
				{
				if ($_FILES[$nombredelcontrol]['size']<20000000) {
				//$target_path = "".$donde."/";
				$target_path = $archivo.'.'.$ext;
				if(move_uploaded_file($_FILES[$nombredelcontrol]['tmp_name'], $target_path))
				{ $msgE= "El documento se  ". $archivo.'.'.$ext. " ha guardado exito<br>";
				} else{
				//$msgE= "No se actualizo ".$nombredelcontrol.", ";
				//$msgE= "No se actualizo o cargo foto ";
				}
				} else {
				$msgE ="ERROR: El archivo que intenta subir es mayor de 2mb";
				}
				
				}
				
				return $msgE;
				}

				function subirpdf2 ($nombredelcontrol, $archivo)
				{
				$ebook = $_FILES[$nombredelcontrol]['tmp_name'];
				if ($_FILES[$nombredelcontrol]['error'] !== 0) {
				//return 'Error al subir el archivo (¿demasiado grande?)';
				} else {
					if ( mime_content_type($_FILES[$nombredelcontrol]['tmp_name']) == 'application/pdf')
					{
						$ruta_ebook = 'docs/' . $archivo . '.pdf';
						if (move_uploaded_file($ebook, $ruta_ebook)) {
						return  "Doc ".$archivo." guardado.";
						} else {
							return  "No se guardo ".$archivo;
						}
					}
				}
				}


				function subirpdf3 ($nombredelcontrol, $archivo)
				{
				$ebook = $_FILES[$nombredelcontrol]['tmp_name'];
				if ($_FILES[$nombredelcontrol]['error'] !== 0) {
				//return 'Error al subir el archivo (¿demasiado grande?)';
				} else {
					if ( mime_content_type($_FILES[$nombredelcontrol]['tmp_name']) == 'application/pdf')
					{
						//$ruta_ebook = 'docs/' . $archivo . '.pdf';
						if (move_uploaded_file($ebook, $archivo)) {
						return  "TRUE";
						} else {
							return  "FALSE ";
						}
					}
				}
				}


				function notificaciones_ver($no_oficio,$nitavu_){
				require("config.php");
				$sql = "SELECT * FROM notificaciones WHERE (nitavu='".$nitavu_."' AND id='".$no_oficio."')";
				$rc= $conexion -> query($sql);
				if($f = $rc -> fetch_array())
				{
				$sql="UPDATE notificaciones SET lectura_fecha='".$fecha."', lectura_hora='".$hora."' WHERE (nitavu='".$nitavu_."' AND id='".$no_oficio."')";
				////echo $sql;
				$resultado = $conexion -> query($sql);
				if ($conexion->query($sql) == TRUE)
				{
				return TRUE;
				}
				else
				{
				return FALSE;
				}
				
				}
				else
				{
				return FALSE;
				}
				
				}
				function ceropapel(){
				require("config.php");
				$sql = "SELECT * FROM contadores WHERE id='0'";
				$rc= $conexion -> query($sql);
				if($f = $rc -> fetch_array())
				{
				return $f['ceropapel'];
				}
				
				}
				function docdigital_no($consulta, $cuantas){
				require("config.php");
				$sql = "SELECT * FROM contadores WHERE id='0'";
				$rc= $conexion -> query($sql);
				if($f = $rc -> fetch_array())
				{
				if ($consulta==TRUE) {
				return $f['docdigital'];
				}
				else
				{ // sino es consulta entonces aumentarle y aumentar el contador de ceropapel
				// la diferencia entre ceropapel y este, es que cero papel se multiplica
				// por las copias que se entregan o con copia, para estadistica de cuanto se ha ahorrado
				$docdigital = $f['docdigital'];
				$docdigitalnew = $docdigital + 1;
				$ceropapel = $f['ceropapel'] + $cuantas;
				$sql="UPDATE contadores SET docdigital='".$docdigitalnew."', ceropapel='".$ceropapel."' WHERE id='0'";
				$resultado = $conexion -> query($sql);
				if ($conexion->query($sql) == TRUE) {
				return $f['docdigital'];
				}
				else {return  FALSE;}
				}
				}
				else
				{ return FALSE;}
				}
				
					function ver($no_oficio){
					require("config.php");
					//funcion que otorga acceso a las aplicaciones
					$sql = "INSERT INTO notificaciones
					(nitavu, asunto, entregar_fecha, nitavu_manda, contenido)
					VALUES
					('$usuario', '$asunto', '$entregar_fecha','$itavu_manda', '$contenido')";
					if ($conexion->query($sql) == TRUE)
					{
					return TRUE;
					}
					else
					{
					return FALSE;
					}
					}

function notificacion_add ($usuario, $asunto, $entregar_fecha, $itavu_manda, $contenido){
//echo $usuario;
//echo $asunto;
//echo $entregar_fecha;
//echo $itavu_manda;
//echo $contenido;

// sleep(1);//retraso programado	
require("config.php");
if ($usuario <> ''){
$npase = npase(FALSE);
$sql = "INSERT INTO notificaciones
	(nitavu, asunto, entregar_fecha, nitavu_manda, contenido, id)
VALUES
	('$usuario', '$asunto', '$entregar_fecha','$itavu_manda', '$contenido', '$npase')";
////echo $sql;
if ($conexion->query($sql) == TRUE)
{
	if (nitavu_correo_valido($usuario)==TRUE){//si tiene correo valido
		if ($asunto <>'chat'){//que no sea chat
			$quien = nitavu_correo($itavu_manda);
			$quien_nombre = nitavu_nombre($itavu_manda);

			//echo "correo: ".$quien;
			// $quien. $quien_nombre;
			correo(nitavu_correo($usuario), nitavu_nombre($usuario), $quien, $quien_nombre, $asunto, $contenido, $usuario);
		}
	}
	return TRUE;
}
else
	{return FALSE;}
}
}

					function notificaciones_detalle($oficio){
					require("config.php");
					$sql = "SELECT * FROM notificaciones WHERE no_oficio='".$oficio."'";
					$rc= $conexion -> query($sql);
					$hay = 0;
					$msg="";
					while($m = $rc -> fetch_array()) {
					$msg= $msg."<li>".$m['no_oficio']." entregada ".$m['entregar_fecha']." a ".nitavu_nombre($m['nitavu']).". Asunto: ".$m['asunto']."";
						if ($m['lectura_hora']=="") {
						$msg = $msg.". Aun sin leer"	;
						}
						else {
						$msg = $msg. ", leida el ".$m['lectura_fecha']." a las ".$m['lectura_hora']."hrs.";
						}
					echo "</li>";
					$hay = $hay +1;
					}
					//$msg = $msg."</lu>";
					$msg=$msg."";
					if ($hay>0) {
					return $msg."";
					}
					else{
					return "";
					}
					
					}
					function aplicaciones_nivel($n){
					require("config.php");
					$sql = "SELECT * FROM aplicaciones_permisos	 WHERE nitavu='".$n."'";
					$rc= $conexion -> query($sql);
					$msg="";
					if($f = $rc -> fetch_array())
					{
					
					return $f['nivel'];
					}
					else
					{ return FALSE;}
					}
					function aplicacion_categoria($idapp){
					require("config.php");
					$sql = "SELECT * FROM aplicaciones	WHERE idapp='".$idapp."'";
					$rc= $conexion -> query($sql);
					$msg="";
					if($f = $rc -> fetch_array())
					{
					return $f['idapcat'];
					}
					else
					{ return FALSE;}
					}
					function nivel_que($n){
					require("config.php");
					$sql = "SELECT * FROM aplicaciones_nivelusuario	 WHERE id='".$n."'";
					$rc= $conexion -> query($sql);
					$msg="";
					if($f = $rc -> fetch_array())
					{
					
					return $f['modo'];
					}
					else
					{ return FALSE;}
					}
					function idapp_categoria($idapp){
					require("config.php");
					$sql = "SELECT * FROM aplicaciones WHERE idapp='".$idapp."'";
					$rc= $conexion -> query($sql);
					$msg="";
					if($f = $rc -> fetch_array())
					{
					
					
					return $msg['idapcat'];
					}
					else
					{ return FALSE;}
					}

function app_detalle($idapp, $nitavu=""){
	require("config.php"); 
	$sql = "SELECT * FROM aplicaciones WHERE idapp='".$idapp."'";
	$rc= $conexion -> query($sql);	
	
	//$nitavu = $_SESSION['nitavu'];
	xd_update($idapp, $nitavu);
	historia($nitavu, " Entro a aplicacion "."(".$idapp.") ".app_nombre($idapp));
	//toast($nitavu);
	$msg="";
	if($f = $rc -> fetch_array())
	{
	
	
	
		$msg="<a href='".app_vinculo($idapp)."' style='cursor:pointer; margin-top:-100px;  z-index:5000;' 
		title='Haga clic para regresar a la principal de esta aplicacion'>
	
		<table border=0 width=100%><tr>";
			$msg= $msg."<td width=20px align=left><a href='index.php'><img src='img/logoitavu.jpg' style='height: 50px;
			margin-top: -1px;'>"."</a></td>";
			// $msg= $msg."<td align=center valign=middle width=20px>";
			// 	$archivo = "icon/".$f['icono'];
				
			// 	$foto = "<img src='icon/".$f['icono']."' class='pc' style='
			// 	width:45px; margin-left:20px;
			// 	'>";
			// 	$msg = $msg.$foto;
				
			// $msg=  $msg. "</td>";
			
			$msg = $msg."<td align=center valign=top><span class='app_titulo' style='color:white;'>".$f['nombre']."</span><span class='app_version'></span><br>";
			$msg = $msg."<span class='app_des'>".$f['descripcion']."</span></td>";
			
	
			$notis = CuantasNotificaciones($nitavu);
			if ($notis >0){
				$msg = $msg."<td class='pc' width=50px align=left><a title='Tienes ".$notis." notificaciones' href='notificaciones.php'>
				<img id='IconoDeAyuda' src='icon/notificacion_icon2.png' 
				style='
				
				';
				>
				</a></span></td>";
			} else {
				$msg = $msg."<td class='pc' width=50px align=left><a title='Sin Notificaciones' href='notificaciones.php'>
				<img id='IconoDeAyuda' src='icon/notificacion_icon.png' 
				style='
		
				';
				></a></span></td>";
			}


			if (sanpedro('ap06', $nitavu, 1)==TRUE){
				// $UltimaVisita = app_ultimavisita($idapp);
				// $imagen = "icon/".app_icono($idapp);
				// if ($UltimaVisita<>''){
				// 	Toast("Ultima Visita ".$UltimaVisita,10,$imagen);
				// }

	
				$msg = $msg."<td class='pc' width=50px align=left><a title='Quien usa esta App' href='aplicaciones_permisos.php?idapp=".$f['idapp']."'>
				<img id='IconoDeAyuda' src='icon/ayuda3.png' 
				style='
		
				';
				></a></span></td>";
			}
			$msg = $msg."<td class='pc' width=50px align=left><a title='Ir a la ayuda de esta aplicacion ' href='ayuda.php?idapp=".$f['idapp']."'>
			<img id='IconoDeAyuda' src='icon/ayuda2.png' 
			style='
	
			';
			></a></span></td>";
			
	
		$msg= $msg."</tr></table></a>
		</div>
		<div id='BloqueEspaciado' style='height:50px;'></div>
		";
	
		if ($f['require_token']==1){
			if (isset($_GET['tkn'])){
				$TokenInput = VarClean($_GET['tkn']);
				global $TokenIn;
				$TokenIn = $TokenInput;
				// echo "Validando Token ".$TokenInput."<br>";
				
	
				echo "
				<script>
				function ValidaToken(){   
					TokenInput = '".$TokenInput."';
					idapp = '".$idapp."';
					$('#preloader').show();
					$.ajax({
						url: 'gentoken_dat.php',
						type: 'post',			
						data: {TokenInput:TokenInput, idapp:idapp},
						success: function(data){
						$('#R').html(data);
						$('#preloader').hide();
						}
					});
					
				}
				ValidaToken();
				</script>
				";
	
	
			} else {
				echo "
				<script>
				var TokenInput = window.prompt('Es necesario el TOKEN', '');
				window.location.href = '?tkn='+TokenInput
				</script>
				";
			}
		}
		return $msg;
	}
	else
	{	 return FALSE;}
	
	
}
	
											function app_nombre($idapp){
					require("config.php");
					$sql = "SELECT * FROM aplicaciones WHERE idapp='".$idapp."'";
					$rc= $conexion -> query($sql);
					$msg="";
					if($f = $rc -> fetch_array())
					{
					return $f['nombre'];
					}
					else
					{ return FALSE;}
					}

					function app_vinculo($idapp){
					require("config.php");
					$sql = "SELECT * FROM aplicaciones WHERE idapp='".$idapp."'";
					$rc= $conexion -> query($sql);
					$msg="";
					if($f = $rc -> fetch_array())
					{
					return $f['vinculo'];
					}
					else
					{ return FALSE;}
					}

					function app_version($idapp){
					require("config.php");
					$sql = "SELECT * FROM aplicaciones WHERE idapp='".$idapp."'";
					$rc= $conexion -> query($sql);
					$msg="";
					if($f = $rc -> fetch_array())
					{
					return $f['version'];
					}
					else
					{ return FALSE;}
					}
					function notificaciones_count($nitavu){
					require("config.php");
					$sql = "SELECT * FROM notificaciones WHERE (nitavu='".$nitavu."' AND lectura_hora='')";
					$r = $conexion -> query($sql);
					$r_count = $r -> num_rows;
					return $r_count;
					
					}
					function aplicacion_nivel($idapp,$usuario){
					require("config.php");
					//funcion que otorga acceso a las aplicaciones
					$sql = "SELECT * FROM aplicaciones_permisos WHERE (nitavu='".$usuario."' AND idapp='".$idapp."')";
					$rc= $conexion -> query($sql);
					if($f = $rc -> fetch_array())
					{

						//historia($usuario,"Usando la aplicacion [".$idapp."] ".app_nombre($idapp)." (".$f['nivel']).")";

						return $f['nivel'];

					}
					else
					{ return 0;}
					}

					function aplicacion_nivel_quien($idapp,$nivel){
					require("config.php");
					//funcion que otorga acceso a las aplicaciones
					$sql = "SELECT * FROM aplicaciones_permisos WHERE (nivel='".$nivel."' AND idapp='".$idapp."')";
					////echo $sql;
					$rc= $conexion -> query($sql);
					if($f = $rc -> fetch_array())
					{

						//historia($usuario,"Usando la aplicacion [".$idapp."] ".app_nombre($idapp)." (".$f['nivel']).")";
						return $f['nitavu'];

					}
					else
					{ return '';}
					}

function sanpedro ($idapp,$usuario,$NoProblem=0){
require("config.php");
//funcion que otorga acceso a las aplicaciones
//pero a san pedro no le importa tu nivel, si estas en la lista te deja pasar
$sql = "SELECT * FROM aplicaciones_permisos WHERE (nitavu='".$usuario."' AND idapp='".$idapp."' )";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{
	xd_update($idapp,$usuario);//guarda la experiencia del usuario
	
	// si la app tiene estado 1 = bloquear

	//if es la caja o tramites bloquear si es dia inabil


	//si es dia inabil, bloquear todo excepto las de la listapermita por usuario y de ese dia
	
	
	return TRUE;

	}
else
	{ //historia($usuario, "Se le nego el acceso a la aplicacion con ID ".$idapp); 
		if ($NoProblem == 0){
			Problema_create("ACCESO", "Intento de acceso a ".$idapp." ".app_nombre($idapp), $usuario, $idapp);
		}
		return FALSE;

	}
}







					function dedondeeres($id){
					require("config.php");
					$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
					$rc= $conexion -> query($sql);
					$msg="";
					if($f = $rc -> fetch_array())
					{
					return $f['ciudad'].", Tamaulipas.";
					}
					else
					{ return FALSE;}
					}
					function pase_quien_autoriza_dpto($dpto){
					//para saber los autorizados en un departamento para aprobar el pase
					require("config.php");
					$sql = "SELECT * FROM empleados WHERE departamento='".$dpto."'";
					$rc= $conexion -> query($sql);
					$msg="";
					while($f = $rc -> fetch_array())
					{
					$nivel = aplicacion_nivel('ap12', $f['nitavu']);
					if (($nivel == '3') OR ($nivel == '2') OR ($nivel == '1'))   {
					$msg = $msg.nitavu_nombre($f['nitavu']).", ";
					
					}
					//$msg = $msg.$f['nitavu']." nivel: ".$nivel."<br>";
					}
					return $msg;
					}
					
					function nitavu_tel_ext($id){
					require("config.php");
					$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
					$rc= $conexion -> query($sql);
					$msg="";
					if($f = $rc -> fetch_array())
					{
					return $f['telefono_extension'];
					}
					else
					{ return "";}
					}

					function nitavu_celular($id){
					require("config.php");
					$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
					$rc= $conexion -> query($sql);
					$msg="";
					if($f = $rc -> fetch_array())
					{
					return $f['telefono_movil'];
					}
					else
					{ return "";}
					}


					function nitavu_correo_valido($id){
					require("config.php");
					// $sql = "SELECT * FROM empleados WHERE nitavu='".$id."' and correo_vobo=1";
					$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
					$rc= $conexion -> query($sql);					
					if($f = $rc -> fetch_array())
						{return TRUE;}
					else
						{return FALSE;}
					}

					function nitavu_tel($id){
					require("config.php");
					$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
					$rc= $conexion -> query($sql);
					$msg="";
					if($f = $rc -> fetch_array())
					{
					return $f['telefono'];
					}
					else
					{ return FALSE;}
					}


function nitavu_profesion($id){
					require("config.php");
					$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
					$rc= $conexion -> query($sql);
					$msg="";
					if($f = $rc -> fetch_array())
					{
						return $f['profesion_abr'];
					}


}


function nitavu_profesionfull($id){
	require("config.php");
	$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
	$rc= $conexion -> query($sql);
	$msg="";
	if($f = $rc -> fetch_array())
	{
		return $f['profesion'];
	}


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
{return $f['nombre'];}
}
else
{ return FALSE;}
}
					function nitavu_nombre2($id){
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
					{ return '<span style=color:red>sin asignacion</span>';}
					}
					
					function dpto_au($id){
					require("config.php");
					$sql = "SELECT * FROM empleados_salidas_temporal WHERE id='".$id."'";
					$rc= $conexion -> query($sql);
					$msg="";
					if($f = $rc -> fetch_array())
					{return nitavu_dpto($f['nitavu']);}
					else
					{ return FALSE;}
					}

					function nitavu_dpto($id){
					require("config.php");
					$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
					$rc= $conexion -> query($sql);
					$msg="";
					if($f = $rc -> fetch_array())
							{return $f['dpto'];}
					else
							{ return FALSE;}
					}

					function nitavu_dpto_nivel($id){
						require("config.php");
						$sql="SELECT cat_gerarquia.nivel FROM cat_gerarquia
						RIGHT JOIN   empleados	ON 	cat_gerarquia.id = empleados.dpto
						WHERE	empleados.nitavu ='".$id."'";
						//$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
						$rc= $conexion -> query($sql);
						$msg="";
						if($f = $rc -> fetch_array())
								{return $f['nivel'];}
						else
								{ return FALSE;}
					}


					function nitavu_dpto_nombre($id){
					require("config.php");
					$sql = "SELECT
							dpto as depa,
							(select nombre from cat_gerarquia where id=depa and id<>0) as departamento
							FROM
							empleados
							WHERE nitavu='".$id."'";
					//echo $sql;							
					$rc= $conexion -> query($sql);
					$msg="";
					if($f = $rc -> fetch_array())
							{return $f['departamento'];}
					else
							{ return FALSE;}
					}


					function nitavu_puesto($id){
					require("config.php");
					$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
					$rc= $conexion -> query($sql);
					$msg="";
					if($f = $rc -> fetch_array())
					{return $f['puesto'];}
					else
					{ return FALSE;}
					}

					function nitavu_correo($id){
					require("config.php");
					$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
					$rc= $conexion -> query($sql);					
					if($f = $rc -> fetch_array())
					{return $f['correoelectronico'];}
					else
					{ return "";}
					}


					function user_quien($id){
					require("config.php");
					$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
					$rc= $conexion -> query($sql);
					$msg="";
					if($f = $rc -> fetch_array())
					{
					
					$msg ="<b>".$f['nombre']."</b>, ".$f['puesto']." de ".$f['departamento'];
					
					return $msg;
					}
					else
					{ return FALSE;}
					}
					function user_historia($id){
					require("config.php");
					$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
					$rc= $conexion -> query($sql);
					$msg="";
					if($f = $rc -> fetch_array())
					{
					
					$msg ="".$f['historia']."<br>";
					
					return $msg;
					}
					else
					{ return FALSE;}
					}
					function user_legend($id){
					require("config.php");
					$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
					$rc= $conexion -> query($sql);
					$msg="";
					if($f = $rc -> fetch_array())
					{
					
					$msg = $msg."<b>".$f['nombre']."</b><br>";
					$msg = $msg.$f['puesto']." de ".$f['departamento'];
					
					return $msg;
					}
					else
					{ return FALSE;}
					}





function user_alertas($id){
require("config.php");
$sql = "SELECT * FROM empleados WHERE nitavu='".$id."'";
$rc= $conexion -> query($sql);$msg="";
if($f = $rc -> fetch_array())
{
	$msg="";
		if ($f['nitavu']==$f['nip']) // una alerta; PONERLAS EN ARTICLEca
					{
					$msg = $msg."<article><a href='nip_update.php'>".
						"<b>Debe cambiar su NIP por seguridad.</b> <cite> Debido a que de manera predeterminada es el mismo que su Numero de ITAVU</cite>"
					."</a></article>";
					}
					
					$pases = pases($f['nitavu']);
	if ($pases>0) // una alerta; PONERLAS EN ARTICLE
					{
					$msg = $msg."<article><a href='auscencia_temporal_autoriza.php'>".
						"<b>Hay ".$pases." pases por aprobar</b> </cite>"
					."</a></article>";
					}
					
					$visitas = visitas($f['nitavu']);
					if ($visitas>0) // una alerta; PONERLAS EN ARTICLE
					{
					//$msg = $msg."<article><a href='visitas.php'>".
					//	"<b>Tienes ".$visitas." Visitas, Verifica las aprobaciones</b> </cite>"
					//."</a></article>";
					}
					$desface = pases_desfase($f['nitavu'], $fecha, $fecha, 'FALSE')	;
					if ($desface>0) // una alerta; PONERLAS EN ARTICLE
					{
					$msg = $msg."<article>".
						"<b>Tienes ".$desface."min. de retraso en tu pase de salida</b> "
					."</article>";
					}
					
					$naci = $f['fecha_nacimiento'];
					if ($naci=='0000-00-00') // una alerta; PONERLAS EN ARTICLE
					{
					$msg = $msg."<article><form action='' method='GET'>
						<b>Apoyanos para completar tus datos: </b><label>¿Cual es tu fecha de nacimiento? </label>
						<input type='date' name='nac' value='".$naci."'> <input type='submit' value='Guardar' class='Mbtn btn-secundario'>
					</form>";
					$msg = $msg."
					";
					$msg = $msg."</article>";
					}
					
					if ($f['correoelectronico']==''){//si no tiene
						$msg = $msg."<article>Si deseas recibir notificaciones en tu correo, <a href='perfil.php?pes=personales'>Registralo</a>.<label>Mediante este, se hara saber de tus actividades y pendientes en la plataforma</label>";
						if ($f['correo_vobo']<=0){
					
						}
						$msg = $msg."</article>";
					}else{//si ya tiene correo
						if ($f['correo_vobo']<=0){
						$msg = $msg."<article style='background-color:red; color:white'><a href='perfil.php?pes=personales'>Tu correo aun no ha sido activado, si no ha recibido el correo de activacion vaya a sus preferencias y de clic en activar. </a>";
						$msg = $msg."</article>";					
						}
	
					}
					
						if (sanpedro('ap54', $id)==TRUE){//solo los que tengan permiso
						if (pendientes_($id)<>''){
							$msg = $msg."<article><a href='pendientes_direccion.php'>".pendientes_($id)."</a></article>";}
						}

				// $aviso="
				// <b class='tgrande normal'>ATENTO AVISO<br> </b><b class='normal'> Apreciados compañeros:</b> 

				// <p>Con la intentencion de apoyar a nuestro hermanos que están viviendo una situación dificil, a causa del sismo que se registro el día de ayer en diversos estados de la República, se les hace una atenta invitación para que los puedan ayudar donando agua embotellada, alimentos no perecederos, material de limpieza o de curación, en el área de recursos humanos se estarán recibiendo los apoyos. </p>

				// <p>Posteriormente, los viveres serán llevados a los lugares de acopio autorizados para su traslado a los lugares afectados. </p>
				// <b>AGRADECEMOS TU VALIOSA COOPERACIÓN.</b> 

				// ";
				// $msg = $msg."<article>".
				// 		" ".$aviso.""
				// 	."</article>";
				
				// $cumples = cumples_estemes();
				// //habla(cumples_estemes_quienes());
				// if ($cumples<>''){
				// $msg = $msg."<article>".$cumples."</article>";
				

				// }
			
			return $msg;
			
			}
			else
			{ return FALSE;}
			}

















function detectar()
{
	$browser=array("IE","OPERA","MOZILLA","NETSCAPE","FIREFOX","SAFARI","CHROME");
	$os=array("WIN","MAC","LINUX");
	# definimos unos valores por defecto para el navegador y el sistema operativo
	$info['browser'] = "OTHER";
	$info['os'] = "OTHER";
	# buscamos el navegador con su sistema operativo
	foreach($browser as $parent)
	{
	$s = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $parent);
	$f = $s + strlen($parent);
	$version = substr($_SERVER['HTTP_USER_AGENT'], $f, 15);
	$version = preg_replace('/[^0-9,.]/','',$version);
	if ($s)
	{
	$info['browser'] = $parent;
	$info['version'] = $version;
	
	}
	}
	# obtenemos el sistema operativo
	foreach($os as $val)
	{
	if (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),$val)!==false)
	$info['os'] = $val;
	}
	# devolvemos el array de valores
	
	//echo getenv('HTTP_CLIENT_IP');
	//echo getenv('HTTP_X_FORWADED_FOR');
	//echo getenv('REMOTE_ADDR');
	$infofull="<br>";
	//$infofull = $infofull. "Usuario: ".gethostname()."<br>";
	$infofull = $infofull. "SO: ".$info['os']."<br>";
	$infofull = $infofull. "Nav: ".$info['browser']."<br>";
	$infofull = $infofull. "Ver: ".$info['version']."<br>";
	$infofull = $infofull. "Agente ".$_SERVER['HTTP_USER_AGENT']."<br>";
	
	$infofull = $infofull. "ip: ".getenv('HTTP_CLIENT_IP')."<br>";
	$infofull = $infofull. "ip: ".getenv('HTTP_X_FORWADED_FOR')."<br>";
	$infofull = $infofull. "ip: ".getenv('REMOTE_ADDR')."<br>";
	
	
	
	
	return $infofull;
}


function InfoEquipo()
{
	$browser=array("IE","OPERA","MOZILLA","NETSCAPE","FIREFOX","SAFARI","CHROME");
	$os=array("WIN","MAC","LINUX");
	# definimos unos valores por defecto para el navegador y el sistema operativo
	$info['browser'] = "OTHER";
	$info['os'] = "OTHER";
	# buscamos el navegador con su sistema operativo
	foreach($browser as $parent)
	{
	$s = strpos(strtoupper($_SERVER['HTTP_USER_AGENT']), $parent);
	$f = $s + strlen($parent);
	$version = substr($_SERVER['HTTP_USER_AGENT'], $f, 15);
	$version = preg_replace('/[^0-9,.]/','',$version);
	if ($s)
	{
	$info['browser'] = $parent;
	$info['version'] = $version;
	
	}
	}
	# obtenemos el sistema operativo
	foreach($os as $val)
	{
	if (strpos(strtoupper($_SERVER['HTTP_USER_AGENT']),$val)!==false)
	$info['os'] = $val;
	}
	# devolvemos el array de valores
	if (getenv('HTTP_CLIENT_IP')) {
		$ip = getenv('HTTP_CLIENT_IP');
	  } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
		$ip = getenv('HTTP_X_FORWARDED_FOR');
	  } elseif (getenv('HTTP_X_FORWARDED')) {
		$ip = getenv('HTTP_X_FORWARDED');
	  } elseif (getenv('HTTP_FORWARDED_FOR')) {
		$ip = getenv('HTTP_FORWARDED_FOR');
	  } elseif (getenv('HTTP_FORWARDED')) {
		$ip = getenv('HTTP_FORWARDED');
	  } else {
		// Método por defecto de obtener la IP del usuario
		// Si se utiliza un proxy, esto nos daría la IP del proxy
		// y no la IP real del usuario.
		$ip = $_SERVER['REMOTE_ADDR'];
	  }
	//echo getenv('HTTP_CLIENT_IP');
	//echo getenv('HTTP_X_FORWADED_FOR');
	//echo getenv('REMOTE_ADDR');
	$infofull="";
	//$infofull = $infofull. "Usuario: ".gethostname()."<br>";
	$infofull = $infofull. "SO:".$info['os'].",";
	$infofull = $infofull. "Navegador: ".$info['browser'].",";
	$infofull = $infofull. "Version:".$info['version']."";
	// $infofull = $infofull. "".$_SERVER['HTTP_USER_AGENT']."<br>";
	
	$red = "";
	// if ($ip <> '' ){$red = $red."ip:".$ip;	}
	if (strlen(getenv('HTTP_CLIENT_IP')) > 3 ){$red = $red." ".getenv('HTTP_CLIENT_IP');}
	if (strlen(getenv('HTTP_X_FORWADED_FOR')) > 3 ){$red = $red.", ".getenv('HTTP_X_FORWADED_FOR');}
	if (strlen(getenv('REMOTE_ADDR')) > 3 ){$red = $red.", ".getenv('REMOTE_ADDR');}

	if ($red <> ''){
		$infofull = $infofull.", Red: (".$red.")";
	}
	
	
	
	
	return $infofull;
}


function insertar_mapa(){//inserta el mapa interactivo, y entraga variable $_GET['m'] del municipio que seleccino
//para usar esta funcion se espera en la pagina presente la var ?m=	* CONSIDERARLO
require("config.php");
echo '<section id="municipios_seleccion"><div id=municipios> <h4>Municipios: </h4>';
$sql2="SELECT * FROM cat_municipios order by Municipio ASC";
$r2 = $conexion -> query($sql2);
$seleccionados="";
   if (isset($_GET['mm'])){ // si hay seleccionado un MULTIPLE municipio
         $municipios_select = explode(",", $_GET['mm']);
         $municipios_n = count($municipios_select);         
         $municipios_n2 = $municipios_n -1;
   }
   while($df = $r2 -> fetch_array())
   {//$df recorre la lista de las delegaciones
      echo "<div>";      
      if (isset($_GET['mm'])){ // si hay seleccionado un MULTIPLE municipio
      for ($i = 0; $i <= $municipios_n2; $i++) {         
         if ($municipios_select[$i]==$df['IdMunicipio']){   
               echo "<a href='?m=".$df['IdMunicipio']."' id='m".$df['IdMunicipio']."' class='municipio_resaltado'>".$df['nombre']."</a>"; 
               $seleccionados = $df['IdMunicipio'].",";
               //break;
         }
      }//for

      $seleccionados_ = explode(",", $seleccionados);$seleccionados_n = count($seleccionados_);       
      $seleccionados_n2 = $seleccionados_n -1;     
      for ($i = 0; $i <= $seleccionados_n2; $i++) {         
         {
            if ($seleccionados_[$i]==$df['IdMunicipio']){
               //echo "=";
               break;
            }
            else {
               echo "<a href='?m=".$df['IdMunicipio']."' id='m".$df['IdMunicipio']."' class='municipios'>".$df['nombre']."</a>"; 
               break;

            }
         }

         //echo $i;
         //echo $municipios_select[$i]."-".$df['IdMunicipio']."|";
         // $i = $i +1;             
         
      }//for
          

         


      //}
      echo "</div>";

   }



      if (isset($_GET['m'])){ // si hay seleccionado un municipio
         if ($_GET['m']==$df['IdMunicipio']){   
            echo "<a href='?m=".$df['IdMunicipio']."' id='m".$df['IdMunicipio']."' class='municipio_resaltado'>".$df['nombre']."</a></div>"; 
         }
         else {
            echo "<a href='?m=".$df['IdMunicipio']."' id='m".$df['IdMunicipio']."' class='municipios'>".$df['nombre']."</a></div>"; 
         }

      }


   }
echo '</div>';


echo "<div id='mapa_tamaulipas'>";

echo '
<svg version="1.1" id="Layer_1" data-municipio="Layer_1"  x="0px" y="0px" viewBox="0 0 325.656 665.291" enable-background="new 0 0 325.656 665.291" xml:space="preserve">';


$sql2="SELECT * FROM cat_municipios order by Municipio ASC";
$r2 = $conexion -> query($sql2);
   while($df = $r2 -> fetch_array())
   {//$df recorre la lista de las delegaciones
      echo "<a href='?m=".$df['IdMunicipio']."'>";
      echo "<path ";
      $id= "m".$df['IdMunicipio']."";

      echo  "onmouseover=".chr(34)."javascript:document.getElementById('$id').className='municipio_resaltado'".chr(34)."; "; 
      echo  "onmouseout=".chr(34)."javascript:document.getElementById('$id').className='municipios'".chr(34).";";    

      echo "id='map".$df['IdMunicipio']."' ";


   
      if (isset($_GET['mm'])){ // si hay seleccionado un MULTIPLE municipio
      for ($i = 0; $i <= $municipios_n2; $i++) {         
         if ($municipios_select[$i]==$df['IdMunicipio']){   
            echo 'class="municipios_resalta"';

            // echo "<a href='?m=".$df['IdMunicipio']."' id='m".$df['IdMunicipio']."' class='municipio_resaltado'>".$df['nombre']."</a>"; 
               $seleccionados = $df['IdMunicipio'].",";
               //break;
         }
      }//for

      $seleccionados_ = explode(",", $seleccionados);$seleccionados_n = count($seleccionados_);       
      $seleccionados_n2 = $seleccionados_n -1;     
      for ($i = 0; $i <= $seleccionados_n2; $i++) {// si ya esta seleccionado poner sin seleccion     
         
            if ($seleccionados_[$i]==$df['IdMunicipio']){
               //echo "=";
               break;
            }
            else {
               echo 'class="municipios_mapa"';
               //echo "<a href='?m=".$df['IdMunicipio']."' id='m".$df['IdMunicipio']."' class='municipios'>".$df['nombre']."</a>";  
               break;

            }
         }//for
      }//getmm





      if (isset($_GET['m'])){ // si hay un municipio seleccionado

      if ("m".$_GET['m']=="m".$df['IdMunicipio']) {echo 'class="municipios_resalta"';} else {echo 'class="municipios_mapa"';}
      } else {echo 'class="municipios_mapa"';}{echo 'class="municipios_mapa"';}

      echo " d='".$df['data']."'>";
      echo $df['nombre'];
      echo "</path>";
      echo "</a>";
      

   }
   echo "</div>";
}




function CrearPase($npase, $empleado, $hr_salida, $justificacion, $asunto, $gen){	
require("config.php");
if ($npase == FALSE){
	$npase = npase(FALSE); //Solicitamos el Numero de Pase
}
$midpto = nitavu_dpto($empleado);		
$sql = "INSERT INTO empleados_salidas_temporal
		(id, nitavu, hora_desde, justificacion,  asunto, fecha, dpto)
		VALUES
		('$npase','$empleado', '$hr_salida',  '$justificacion', '$asunto', '$fecha','$midpto');";
		$h="";
//echo $sql;		
if ($conexion->query($sql) == TRUE)
	{		$m="<p>Solicito pase de Salida para <b>".$asunto."</b></p><p>".$justificacion.", para el dia ".fecha_larga($fecha)." a las ".$hr_salida."</p><p>*Solicitado por ".nitavu_nombre($gen)."</p>";
			notificacion_add (titular(nitavu_dpto($empleado)), 'Solicito Salida para el '.fecha_larga($fecha), $fecha, $empleado, $m);
			//notificacion_add ($empleado, 'chat', $fecha, $gen, 'Te he activado una solicitud de pase'.$m);
			$h="<p>".nitavu_nombre($empleado)." (".$empleado.") ha solicitado un pase de salida para <span class='tenue'><b>".$asunto."</b>".$justificacion.". ";
			$h = $h."para el dia ".$fecha."</p>.";
			historia($empleado, $h);
			return TRUE;
	}
else
	{
			historia($empleado, "ERROR | (".$sql.") al intentar guardar pase de salida");
			return FALSE;
			mensaje ("Error :".$sql,'');
			
	}



}




//------    CONVERTIR NUMEROS A LETRAS         ---------------
//------    Máxima cifra soportada: 18 dígitos con 2 decimales
//------    999,999,999,999,999,999.99
// NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE BILLONES
// NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE MILLONES
// NOVECIENTOS NOVENTA Y NUEVE MIL NOVECIENTOS NOVENTA Y NUEVE PESOS 99/100 M.N.

function numtoletras($xcifra)
{
    $xarray = array(0 => "Cero",
        1 => "UN", "DOS", "TRES", "CUATRO", "CINCO", "SEIS", "SIETE", "OCHO", "NUEVE",
        "DIEZ", "ONCE", "DOCE", "TRECE", "CATORCE", "QUINCE", "DIECISEIS", "DIECISIETE", "DIECIOCHO", "DIECINUEVE",
        "VEINTI", 30 => "TREINTA", 40 => "CUARENTA", 50 => "CINCUENTA", 60 => "SESENTA", 70 => "SETENTA", 80 => "OCHENTA", 90 => "NOVENTA",
        100 => "CIENTO", 200 => "DOSCIENTOS", 300 => "TRESCIENTOS", 400 => "CUATROCIENTOS", 500 => "QUINIENTOS", 600 => "SEISCIENTOS", 700 => "SETECIENTOS", 800 => "OCHOCIENTOS", 900 => "NOVECIENTOS"
    );
//
    $xcifra = trim($xcifra);
    $xlength = strlen($xcifra);
    $xpos_punto = strpos($xcifra, ".");
    $xaux_int = $xcifra;
    $xdecimales = "00";
    if (!($xpos_punto === false)) {
        if ($xpos_punto == 0) {
            $xcifra = "0" . $xcifra;
            $xpos_punto = strpos($xcifra, ".");
        }
        $xaux_int = substr($xcifra, 0, $xpos_punto); // obtengo el entero de la cifra a covertir
        $xdecimales = substr($xcifra . "00", $xpos_punto + 1, 2); // obtengo los valores decimales
    }

    $XAUX = str_pad($xaux_int, 18, " ", STR_PAD_LEFT); // ajusto la longitud de la cifra, para que sea divisible por centenas de miles (grupos de 6)
    $xcadena = "";
    for ($xz = 0; $xz < 3; $xz++) {
        $xaux = substr($XAUX, $xz * 6, 6);
        $xi = 0;
        $xlimite = 6; // inicializo el contador de centenas xi y establezco el límite a 6 dígitos en la parte entera
        $xexit = true; // bandera para controlar el ciclo del While
        while ($xexit) {
            if ($xi == $xlimite) { // si ya llegó al límite máximo de enteros
                break; // termina el ciclo
            }

            $x3digitos = ($xlimite - $xi) * -1; // comienzo con los tres primeros digitos de la cifra, comenzando por la izquierda
            $xaux = substr($xaux, $x3digitos, abs($x3digitos)); // obtengo la centena (los tres dígitos)
            for ($xy = 1; $xy < 4; $xy++) { // ciclo para revisar centenas, decenas y unidades, en ese orden
                switch ($xy) {
                    case 1: // checa las centenas
                        if (substr($xaux, 0, 3) < 100) { // si el grupo de tres dígitos es menor a una centena ( < 99) no hace nada y pasa a revisar las decenas
                            
                        } else {
                            $key = (int) substr($xaux, 0, 3);
                            if (TRUE === array_key_exists($key, $xarray)){  // busco si la centena es número redondo (100, 200, 300, 400, etc..)
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux); // devuelve el subfijo correspondiente (Millón, Millones, Mil o nada)
                                if (substr($xaux, 0, 3) == 100)
                                    $xcadena = " " . $xcadena . " CIEN " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3; // la centena fue redonda, entonces termino el ciclo del for y ya no reviso decenas ni unidades
                            }
                            else { // entra aquí si la centena no fue numero redondo (101, 253, 120, 980, etc.)
                                $key = (int) substr($xaux, 0, 1) * 100;
                                $xseek = $xarray[$key]; // toma el primer caracter de la centena y lo multiplica por cien y lo busca en el arreglo (para que busque 100,200,300, etc)
                                $xcadena = " " . $xcadena . " " . $xseek;
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 0, 3) < 100)
                        break;
                    case 2: // checa las decenas (con la misma lógica que las centenas)
                        if (substr($xaux, 1, 2) < 10) {
                            
                        } else {
                            $key = (int) substr($xaux, 1, 2);
                            if (TRUE === array_key_exists($key, $xarray)) {
                                $xseek = $xarray[$key];
                                $xsub = subfijo($xaux);
                                if (substr($xaux, 1, 2) == 20)
                                    $xcadena = " " . $xcadena . " VEINTE " . $xsub;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                                $xy = 3;
                            }
                            else {
                                $key = (int) substr($xaux, 1, 1) * 10;
                                $xseek = $xarray[$key];
                                if (20 == substr($xaux, 1, 1) * 10)
                                    $xcadena = " " . $xcadena . " " . $xseek;
                                else
                                    $xcadena = " " . $xcadena . " " . $xseek . " Y ";
                            } // ENDIF ($xseek)
                        } // ENDIF (substr($xaux, 1, 2) < 10)
                        break;
                    case 3: // checa las unidades
                        if (substr($xaux, 2, 1) < 1) { // si la unidad es cero, ya no hace nada
                            
                        } else {
                            $key = (int) substr($xaux, 2, 1);
                            $xseek = $xarray[$key]; // obtengo directamente el valor de la unidad (del uno al nueve)
                            $xsub = subfijo($xaux);
                            $xcadena = " " . $xcadena . " " . $xseek . " " . $xsub;
                        } // ENDIF (substr($xaux, 2, 1) < 1)
                        break;
                } // END SWITCH
            } // END FOR
            $xi = $xi + 3;
        } // ENDDO

        if (substr(trim($xcadena), -5, 5) == "ILLON") // si la cadena obtenida termina en MILLON o BILLON, entonces le agrega al final la conjuncion DE
            $xcadena.= " DE";

        if (substr(trim($xcadena), -7, 7) == "ILLONES") // si la cadena obtenida en MILLONES o BILLONES, entoncea le agrega al final la conjuncion DE
            $xcadena.= " DE";

        // ----------- esta línea la puedes cambiar de acuerdo a tus necesidades o a tu país -------
        if (trim($xaux) != "") {
            switch ($xz) {
                case 0:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN BILLON ";
                    else
                        $xcadena.= " BILLONES ";
                    break;
                case 1:
                    if (trim(substr($XAUX, $xz * 6, 6)) == "1")
                        $xcadena.= "UN MILLON ";
                    else
                        $xcadena.= " MILLONES ";
                    break;
                case 2:
                    if ($xcifra < 1) {
                        $xcadena = "CERO PESOS $xdecimales/100 M.N.";
                    }
                    if ($xcifra >= 1 && $xcifra < 2) {
                        $xcadena = "UN PESO $xdecimales/100 M.N. ";
                    }
                    if ($xcifra >= 2) {
                        $xcadena.= " PESOS $xdecimales/100 M.N. "; //
                    }
                    break;
            } // endswitch ($xz)
        } // ENDIF (trim($xaux) != "")
        // ------------------      en este caso, para México se usa esta leyenda     ----------------
        $xcadena = str_replace("VEINTI ", "VEINTI", $xcadena); // quito el espacio para el VEINTI, para que quede: VEINTICUATRO, VEINTIUN, VEINTIDOS, etc
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("UN UN", "UN", $xcadena); // quito la duplicidad
        $xcadena = str_replace("  ", " ", $xcadena); // quito espacios dobles
        $xcadena = str_replace("BILLON DE MILLONES", "BILLON DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("BILLONES DE MILLONES", "BILLONES DE", $xcadena); // corrigo la leyenda
        $xcadena = str_replace("DE UN", "UN", $xcadena); // corrigo la leyenda
    } // ENDFOR ($xz)
    return trim($xcadena);
}

// END FUNCTION

function subfijo($xx)
{ // esta función regresa un subfijo para la cifra
    $xx = trim($xx);
    $xstrlen = strlen($xx);
    if ($xstrlen == 1 || $xstrlen == 2 || $xstrlen == 3)
        $xsub = "";
    //
    if ($xstrlen == 4 || $xstrlen == 5 || $xstrlen == 6)
        $xsub = "MIL";
    //
    return $xsub;
}

// END FUNCTION
// function Toast($Texto,$Tipo,$img){
// switch ($Tipo) {
// 	case 0:
// 		echo '
// 			<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
// 				<div class="toast-header">
// 				<img src="..." class="rounded mr-2" alt="...">
// 				<strong class="mr-auto">Plataforma</strong>
// 				<small class="text-muted">.$Texto."</small>
// 				<button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
// 					<span aria-hidden="true">&times;</span>
// 				</button>
// 				</div>
// 				<div class="toast-body">
// 				See? Just like this.
// 				</div>
// 			</div>
// 		';
// 	break;

// 	case 1:
// 	break;

// 	default:
// 	break;

// }

// }


function Toast($Texto,$Tipo=5,$img=""){
require("seguridad.php"); if (isset($nitavu)){$IdEmpleado = $nitavu;} else{$IdEmpleado = "";}
if ($Tipo==2){Problema_create("PLATAFORMA", "TOAST: ".$Texto, $IdEmpleado);}

	$img = $img."?".date ("His");
	SonidoBoop();
    switch ($Tipo) {
        case 0:
            echo "<script>";
                echo "$.toast('".$Texto."');   ";
            echo "</script>";
            break;
        case 1: //Informativo
            echo "<script>";
            echo "
            $.toast({
                heading: 'Information',
                text: '".$Texto."',
                showHideTransition: 'slide',
                icon: 'info'
            })
            ";
            echo "</script>";
            break;
       
        case 2: //Error
            echo "<script>";
            echo "
            $.toast({
                heading: 'Error',
                text: '".$Texto."',
                showHideTransition: 'slide',
                icon: 'error'
            })

			$('#AudioError')[0].play();
            ";

            echo "</script>";
            break;

        case 3: //Warning
                echo "<script>";
                echo "
                $.toast({
                    heading: 'Warning',
                    text: '".$Texto."',
                    showHideTransition: 'slide',
                    icon: 'warning'
                })
				$('#AudioError')[0].play();
                ";
				
                echo "</script>";
                break;

                

        case 4: //Success
            echo "<script>";
            echo "
            $.toast({
                heading: 'Success',
                text: '".$Texto."',
                showHideTransition: 'slide',
                icon: 'success'
            })
			$('#AudioSuccess')[0].play();
            ";
            echo "</script>";
            break;
    

        case 5: //fijo
            echo "<script>";
            echo "
            $.toast({
                heading: '',
                text: '".$Texto."',                
                hideAfter: false
                
            })
            ";
            echo "</script>";
            break;
        
        case 6: //imagen normal
                echo "<script>";
                echo "
                $.toast({
                    heading: '',
                    text: '".$Texto."<img style=width:100% src=".$img.">"."',                
                    
                    
                })
                ";
                echo "</script>";
        break;                


        case 7: //imagen sucess
            echo "<script>";
            echo "
            $.toast({
                heading: '',
                text: '".$Texto."<img style=width:100% src=".$img.">"."',                
                hideAfter: false,
                icon:'success'
                
            })
            ";
            echo "</script>";
        break;                


        case 8: //imagen warning
            echo "<script>";
            echo "
            $.toast({
                heading: '',
                text: '".$Texto."<img style=width:100% src=".$img.">"."',                
                hideAfter: false,
                icon:'warning'
                
            })
            ";
            echo "</script>";
        break;                

        case 9: //imagen error
            echo "<script>";
            echo "
            $.toast({
                heading: '',
                text: '".$Texto."<img style=width:100% src=".$img.">"."',                
                hideAfter: false,
                icon:'error'
                
            })
            ";
            echo "</script>";
        break;                

        case 10: //imagen normal auto
            echo "<script>";
            echo "
            $.toast({
                heading: '',
                text: '".$Texto."<img style=width:100% src=".$img.">"."',                
                showHideTransition: 'slide'
                
            })
            ";
            echo "</script>";
    break;                


    case 11: //imagen sucess auto
        echo "<script>";
        echo "
        $.toast({
            heading: '',
            text: '".$Texto."<img style=width:100% src=".$img.">"."',                
            
            icon:'success',
            showHideTransition: 'slide'
            
        })
        ";
        echo "</script>";
    break;                


    case 12: //imagen warning auto
        echo "<script>";
        echo "
        $.toast({
            heading: '',
            text: '".$Texto."<img style=width:100% src=".$img.">"."',                
           
            icon:'warning',
            showHideTransition: 'slide'
            
        })
        ";
        echo "</script>";
    break;                

    case 13: //imagen error auto
        echo "<script>";
        echo "
        $.toast({
            heading: '',
            text: '".$Texto."<img style=width:100% src=".$img.">"."',                
            
            icon:'error',
            showHideTransition: 'slide'
            
        })
        ";
        echo "</script>";
    break;                


        default:
           echo "<script>";
               echo "$.toast('".$Texto."');   ";
           echo "</script>";
    }
}

function CalcularCarteraVencida($IdDelegacion, $Desde, $Hasta){
	require("config.php");
	
	
	$MSSQL = "
	SELECT  * FROM
	( 
	
		SELECT 
		Vivienda_EstadisticaCarteraVencida.*,
		ROW_NUMBER ( ) OVER ( ORDER BY Vivienda_EstadisticaCarteraVencida.NumContrato ) AS row 
		from Vivienda_EstadisticaCarteraVencida WHERE IdDelegacion = ".$IdDelegacion."
		
	) a 
	WHERE row >  ".$Desde."  AND row <= ".$Hasta."  ORDER BY row
	";        
		   echo $MSSQL."<br>";
	$ConsultaDATA = DatosViviendaLarge($IdDelegacion, $nitavu, "CarteraVencida", $MSSQL);               
	$array = json_decode($ConsultaDATA, true); 
	$error = "";
	$sqlInsert="";
	$Msg = "";
	if(is_array($array)){            
		foreach ($array as $value) {
			if (isset($value['r'])){// si hay un error
								// echo "*Error: ".$value['r'];
								$error = $value['r'];
			} else {//si no hay errores escribimos
				$MesesDeAtraso = $value['MesesDeAtraso'];
				$Años = $value['Años'];
				$IdDelegacionX = $value['IdDelegacion'];
				$IdPrograma = $value['IdPrograma'];
				$NumContrato = $value['NumContrato'];
				$Saldo = $value['Saldo'];
				$Saldo_Moratorio = $value['Saldo_Moratorio'];
				$IdColonia = $value['IdColonia'];
				$Colonia = $value['Colonia'];
				// $Fecha = $fecha();
				// $nitavu = $nitavu;
								
	
				// Insertar en la Base de Datos de MariaDb
				$sqlInsert = "
				INSERT INTO carteravencida_seguimiento
				(MesesDeAtraso, Años, IdDelegacion, IdPrograma, NumContrato, Saldo, Saldo_Moratorio, IdColonia, Colonia, Fecha, nitavu)
				VALUES
					(".$MesesDeAtraso.", ".$Años.", ".$IdDelegacionX.",".$IdPrograma.",'".$NumContrato."',".$Saldo.",".$Saldo_Moratorio.", ".$IdColonia.",'".$Colonia."', '".$fecha."', '".$nitavu."' );                            
				";
				echo $sqlInsert;
				if ($sqlInsert <> ''){
					if ($conexion->query($sqlInsert) == TRUE)   {
						// echo "Insertado,";
					} else {
						// echo "Error (".$sqlInsert.")";
	
					}
				}
				
			}                   
		}
	} else { $error  = "No es un Array"; }
	
	if ($error == ''){
		return TRUE;
	} else {
		return FALSE;
	}
					// var_dump($ConsultaDATA);
					// echo "<hr>SQL para insertar: ".$sqlInsert;
					
	
					// historia($nitavu,"Ingreso de manera automatica el calculo de la Cartera vencida de la delegacion ".$IdDelegacion."");
					// echo '
					// <script>
					//     window.location.href = "carteravencida.php?IdDelegacion='.$IdDelegacion.'";
					// </script>
					// ';
}


function TablaDinamica_Vivienda($tbCont, $sql, $IdDiv, $IdTabla, $Clase, $Tipo){
	require("config.php");
	
	if ($tbCont == '') {
        $r= $Vivienda -> query($sql);
        $tbCont = '<div id="'.$IdDiv.'" class="'.$Clase.'">
        <table id="'.$IdTabla.'" class="display" style="width:100%" class="tabla" style="font-size:8pt;">';
    $tabla_titulos = ""; $cuantas_columnas = 0;
        $r2 = $conexion -> query($sql); while($finfo = $r2->fetch_field())
        {//OBTENER LAS COLUMNAS

                /* obtener posición del puntero de campo */
                $currentfield = $r2->current_field;       
                $tabla_titulos=$tabla_titulos."<th style='text-transform:uppercase; font-size:9pt;'>".$finfo->name."</th>";
                $cuantas_columnas = $cuantas_columnas + 1;        
        }

        $tbCont = $tbCont."  
        <thead>
        <tr>
            ".$tabla_titulos."  
        </tr>
        </thead>"; //Encabezados
        $tbCont = $tbCont."<tbody class='tabla'>";
        $cuantas_filas=0;
        $r = $conexion -> query($sql); while($f = $r-> fetch_row())
        {//LISTAR COLUMNAS

            $tbCont = $tbCont."<tr>";        
            for ($i = 1; $i <= $cuantas_columnas; $i++) {      
                $tbCont = $tbCont."<td style='font-size:10pt;'>".$f[$i-1]."</td>";       
                }

            $tbCont = $tbCont."</tr>";
            $cuantas_filas = $cuantas_filas + 1;        
        }

        $tbCont = $tbCont."</tbody>";
        $tbCont = $tbCont."</table></div>";
	} else {
		
	}
	echo  $tbCont;
		switch ($Tipo) {
			case 1: //Scroll Vertical
					echo '<script>
					$(document).ready(function() {
						$("#'.$IdTabla.'").DataTable( {
							"scrollY":        "200px",
							"scrollCollapse": true,
							"paging":         false,
							"language": {
								"decimal": ",",
								"thousands": "."
							}
						} );
					} );
					</script>';
				break;

			case 2: //Scroll Horizontal
					echo '<script>
					$(document).ready(function() {
						$("#'.$IdTabla.'").DataTable( {
							"scrollX": true,
							"scrollCollapse": true,
							"paging":         true,
							"language": {
								"decimal": ",",
								"thousands": "."
							}
						} );
					} );
					</script>';
				break;
			
			default:
				echo '<script>
				$(document).ready(function() {
					$("#'.$IdTabla.'").DataTable( {
						"language": {
							"decimal": ",",
							"thousands": "."
						}
					} );
				} );
				</script>';
		}
       

}


function cortaFrase($frase, $maxPalabras, $f) {
    $noTerminales = ["de"];
    $palabras = explode(" ", $frase);
    $numPalabras = count($palabras);
    if ($f == 0){
        if ($numPalabras > $maxPalabras) {
            $offset = $maxPalabras - 1;
            while (in_array($palabras[$offset], $noTerminales) && $offset < $numPalabras) { $offset++; }
            return implode(" ", array_slice($palabras, 0, $offset+1));
        } 
    } else {
        if ($numPalabras > $maxPalabras) {
            $offset = $maxPalabras - 1;
            while (in_array($palabras[$offset], $noTerminales) && $offset > $numPalabras) { $offset++; }
            return implode(" ", array_slice($palabras, $maxPalabras, $offset+4));
        } 
    }

    return $frase;
}


function MsgBox_Lite($mensaje, $link){
require("seguridad.php"); if (isset($nitavu)){$IdEmpleado = $nitavu;} else{$IdEmpleado = "";}


    if ($link=="") {$link = "index.php";}
    $tipo = substr($mensaje, 0,5);  
	
	if ($tipo=='ERROR'){Problema_create("PLATAFORMA", "MsgBox_Lite: ".$mensaje, $IdEmpleado);}

	echo "<script>$('body').scrollTop(0);</script>";
    if ($tipo=='ERROR'){
        echo '<div id="modal_error" style="
        visibility:visible;opacity:1;background-color:#7D0000;opacity:0.9;position:fixed;top:0;left:0;right:0;bottom:0;margin:0;z-index:809;transition:all 1s;width:100%
        
        "></div>';}
        else{
        echo '<div id="modal_oscuro" style="
        visibility:visible;opacity:1;background-color:rgba(0,0,0,0.8);opacity:0.9;position:fixed;top:0;left:0;right:0;bottom:0;margin:0;z-index:999;transition:all 1s;width:100%
        "></div>';}        
            if ($tipo=='ERROR'){echo '<div id="msg_error" style="
                width:50%;top:20%;left:20%;right:20%;margin:0px;border-radius:0px;
                color:red;text-align:center;border-radius:10px;border:2px solid #FF0000;background-color:white;width:50%;position:absolute;top:20%;right:20%;z-index:2010;opacity:1;padding:10px;margin:0px;margin-top:100px;transition:all 0.5s cubic-bezier(.46,.03,.52,.96);
                ">';}
            else{echo '<div id="mensaje" style="
                color:black;text-align:center;border-radius:10px;border:2px solid white;background-color:white;width:50%;position:absolute;top:20%;right:20%;z-index:2010;opacity:1;padding:10px;margin:10px;margin-top:100px;transition:all 5s cubic-bezier(.46,.03,.52,.96);
                ">';}
            echo '<p style="
                font-family:Verdana;
                font-size:10pt;
            ">'.$mensaje.'</p>';
            echo '<a style="
                background-color:#00769D;
                color:white;
                font-family: Verdana;
                padding: 7px;
                border-radius: 4px;
                text-decoration: none;
                font-weight: bold;
                font-size:11pt;
            " target=_parent href="'.$link.'">Aceptar</a>  ';
            echo '</div>';
            echo "<script>$('body').scrollTop(0);</script>";
    
}

function GeoData($lat,$lon)
{
    // https://nominatim.openstreetmap.org/reverse?format=json&lat=23.7411286&lon=-99.1566962
    $url = 'http://nominatim.openstreetmap.org/reverse?format=json&lat='.$lat.'&lon='.$lon;
    // echo $url;
    $context = stream_context_create(
        array(
            "http" => array(
                "header" => "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/50.0.2661.102 Safari/537.36"
            )
        )
    );
    
    $archivo_web = file_get_contents($url, false, $context);
    $archivo = json_decode($archivo_web);

    // echo $archivo_web."<hr>";
    // var_dump($archivo);
    // echo "<hr>";
    // echo $archivo->address->{'city'};
    return $archivo;

}
function DigitalFile_nombre($IdFile){
	require("config.php");
	$sql = "SELECT * FROM digitalfiles  WHERE IdFile='".$IdFile."' ";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	$html = "";
	if($f = $r -> fetch_array())
	{
		return $f['FileName']."";
	} else {
		return '';
	}
}

function DigitalFile_propietario($IdFile){
	require("config.php");
	$sql = "SELECT * FROM digitalfiles  WHERE IdFile='".$IdFile."' ";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	$html = "";
	if($f = $r -> fetch_array())
	{
		return $f['Propietario']."";
	} else {
		return '';
	}
}


function DigitalFile_view($IdFile, $nitavu){
	require("config.php");
	$Permiso = 0;
	$sql = "SELECT count(*) as Permiso FROM digitalfile_permisos  WHERE IdFile='".$IdFile."' and IdUser='".$nitavu."'";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	$html = "";
	if($f = $r -> fetch_array())
	{
		$Permiso =  $f['Permiso']."";
	} 

	if (DigitalFile_propietario($IdFile) == $nitavu){
		$Permiso = 1;

	}

	if ($Permiso > 0){
		return TRUE;
	} else {
		return FALSE;
	}

}

function DigitalFile_Info($IdFile){
	require("config.php");
	$sql = "SELECT * FROM digitalfiles  WHERE IdFile='".$IdFile."' ";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	$html = ""; $R="";
	if($f = $r -> fetch_array())
	{
		$R.="<tr><td width=20% >";
        $R.="<a href='DigitalFile_download.php?id=".$f['IdFile']."'>";
        $R.="<img src='icon/pdf.png' style='width:32px;' title='Subido el ".$f['fecha']." a ".$f['hora']." por ".$f['Propietario']."'> ".$f['FileName'];
        $R.="</a>";
        $R.="</td>";
        $R.="<td><b style='font-size:11pt;'>".$f['Descripcion']."</b>";
        $R.="<br><cite>".$f['Tags']."</cite></td>";
		$R.="<td><img src='icon/user.png' style='width:32px;'>".nitavu_nombre($f['Propietario'])."<br>                      <cite style='font-size:7pt;'>Usuario Administrador</cite></td></tr>";
		return "<table class=''>".$R."</table>";
	} else {
		return '';
	}
}

function SonidoBoop(){
    
	echo '<script>
	$("#AudioBoop")[0].play();
	</script>
	';
	   
	}
	
	
function SonidoBoop2(){

echo '<script>
$("#AudioBoop2")[0].play();
</script>
';
	
}


function User_UltimaActividad($nitavu){
	require("config.php");
	$sql = "select * from actividad where NEmpleado='".$nitavu."'  order by fecha DESC limit 1";	
	// echo $sql;
	$r= $conexion -> query($sql);					
	$html = ""; $R="";
	if($f = $r -> fetch_array())
	{
		return $f['fecha']." - ".$f['hora']." = ".$f['Descripcion'];
	} else {
		return '';
	}
}

function NotificaError($txtError, $txtAsunto){
	require("config.php");
	$CorreoTo="printepolis@gmail.com";
	if (correo($CorreoTo, "Error Plataforma", 'itavu.informatica@tam.gob.mx', 'Error Plataforma', $txtAsunto, $txtError, "")==TRUE){	
		sleep(1);
		Toast("Se notifico",0,"");
	} else {}

	$CorreoTo="itavu.informatica@tam.gob.mx";
	if (correo($CorreoTo, "Error Plataforma", 'itavu.informatica@tam.gob.mx', 'Error Plataforma', $txtAsunto, $txtError, "")==TRUE){	
		sleep(1);
		Toast("Se notifico",0,"");
	} else {}

}


function DiaInabil($Cuando){require("config.php");	
	$sql="select * from diasinhabiles where Dia0='$Cuando'";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
		{
			// return "".fecha_larga($f['Dia0'])." - ".$f['Comentario'];
			return TRUE;

			
		}
	 else {return FALSE;}
}

function DiaInabil_comentario($Cuando){require("config.php");	
	$sql="select * from diasinhabiles where Dia0='$Cuando'";
	$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
		{
			return $f['Comentario']." (por ".nitavu_nombre($f['Autorizo'])." el ".$f['fecha'].")";
			// return TRUE;

			
		}
	 else {return FALSE;}
}



function CheckServiciosGoogle(){

require_once("viaticos_fun.php");
    $addressFrom = "Victoria, Tamaulipas";
    $addressTo = "Tampico, Tamaulipas";
    // echo "Origen: ".$addressFrom.", Destino: ".$addressTo;
    
        $distance = getDistance($addressFrom, $addressTo, "K");
        if (is_numeric($distance)){
            $distance = $distance + rand(60,70);
            $Distancia =  number_format($distance, 2, '.', '');        
            // Toast("Distancia ".$addressFrom." a ".$addressTo." obtenida correctamente de los Servicios de Google Cloud",4,"");
			return TRUE;
        } else {        
            
            Toast("Error  al obtener informacion de los Servicios Google",2,"");
            // MsgBox_Lite("ERROR al obtener los Servicios de Google","");
			return FALSE;
        }
    
    
}

function nitavu_direccion($id){
require("config.php");
$sql = "SELECT * FROM empleadosfull_noactivity WHERE nitavu='".$id."'";
$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		return $f['Direccion'];
	}
	else
	{ 
		return "";
	}
}

function nitavu_adscripcion($id){
	require("config.php");
	$sql = "SELECT * FROM empleadosfull_noactivity WHERE nitavu='".$id."'";
	$rc= $conexion -> query($sql);
	$msg="";
	if($f = $rc -> fetch_array())
	{return $f['adscripcion'];}
	else
	{ return "";}
}


function nitavu_rfc($id){
	require("config.php");
	$sql = "SELECT * FROM empleadosfull_noactivity WHERE nitavu='".$id."'";
	$rc= $conexion -> query($sql);
	$msg="";
	if($f = $rc -> fetch_array())
	{return $f['rfc'];}
	else
	{ return "";}
}



function ciHistory($IdCi, $nitavu){
	require("config.php");
	$sql = "INSERT INTO ci_history(IdCi, nitavu, fecha) 
			VALUES ('".$IdCi."', '".$nitavu."', '".$fecha."')";
		// echo $sql;
	if ($conexion->query($sql) == TRUE){                   		
		return TRUE;
	} else {
		return FALSE;
	}



}



function app_ultimavisita($idapp, $nitavu=""){
	require("config.php");
	if ($nitavu ==""){
		$sql = "select 
		*
		from actividad_apps where IdApp='".$idapp."' and IdEmpleado<>''	 order by UltimaVisita DESC limit 1,1";
	} else {
		$sql = "select 
		*
		from actividad_apps where IdApp='".$idapp."' and IdEmpleado='".$nitavu."'";
	}

	$rc= $conexion -> query($sql);
	// echo $sql;
	if($f = $rc -> fetch_array())
	{	if ($nitavu ==""){
				return fecha_larga($f['UltimaVisita'])." por ".$f['Empleado'];
		} else {
			
			return fecha_larga($f['UltimaVisita'])." por ".$f['Empleado']."<br> ".$f['url'];
		}
	
	}
	else
	{ return "";}

}


function InfoLogin(){
require("config.php");		
$sql = "
	SELECT 
	(select count(DISTINCT IdEmpleado) from actividad_apps WHERE UltimaVisita = curdate()) as Usuarios_Hoy,
	(select count(DISTINCT IdApp) from actividad_apps WHERE UltimaVisita = curdate()) as App_Hoy,	
	(select hora from historia order by id DESC  limit 1) as UltimaVisita,
	(SELECT TIMESTAMPDIFF(DAY, (select fecha from historia   limit 1), curdate()) ) as Dias
	
";
$r= $conexion -> query($sql);

//echo $sql;
if($f = $r -> fetch_array()){
	return "
	Hoy <b>".$f['Usuarios_Hoy']."</b> usuarios han entrado. <br>
	<b>".$f['App_Hoy']."</b> aplicaciones han sido utilizadas hoy. <br>
	Ha estado activa esta plataforma  <b>".$f['Dias']."</b> dias.<br>";
}


}




function sql_to_table($sql, $BdPlataforma, $IdTabla="MiTabla"){
require("config.php");

if ($BdPlataforma == "Plataforma"){
	
	$tbCont = '<div id="'.$IdDiv.'" class="'.$Clase.'" style="width:100%">
			<table id="'.$IdTabla.'" class="display" style="width:100%" class="tabla" style="font-size:8pt;">';
			$tabla_titulos = ""; $cuantas_columnas = 0;
			$r2 = $Vivienda -> query($sql); while($finfo = $r2->fetch_field())
			{//OBTENER LAS COLUMNAS
	
					/* obtener posición del puntero de campo */
					$currentfield = $r2->current_field;       
					$tabla_titulos=$tabla_titulos."<th style='text-transform:uppercase; font-size:9pt;'>".$finfo->name."</th>";
					$cuantas_columnas = $cuantas_columnas + 1;        
			}
	
			$tbCont = $tbCont."  
			<thead>
			<tr>
				".$tabla_titulos."  
			</tr>
			</thead>"; //Encabezados
			$tbCont = $tbCont."<tbody class='tabla'>";
			$cuantas_filas=0;
			$r = $Vivienda -> query($sql);
			 while($f = $r-> fetch_row())
			{//LISTAR COLUMNAS
	
				$tbCont = $tbCont."<tr>";        
				for ($i = 1; $i <= $cuantas_columnas; $i++) {      
					$tbCont = $tbCont."<td style='font-size:10pt;'>".$f[$i-1]."</td>";       
					}
	
				$tbCont = $tbCont."</tr>";
				$cuantas_filas = $cuantas_filas + 1;        
			}
	
			$tbCont = $tbCont."</tbody>";
			$tbCont = $tbCont."</table></div>";
}


if ($BdPlataforma == "Vivienda"){
	
	$tbCont = '<div id="'.$IdDiv.'" class="'.$Clase.'" style="width:100%">
	<table id="'.$IdTabla.'" class="display" style="width:100%" class="tabla" style="font-size:8pt;">';
	$tabla_titulos = ""; $cuantas_columnas = 0;
	$r2 = $Vivienda -> query($sql); 
	
	while($finfo = $r2->fetch_field())
	{//OBTENER LAS COLUMNAS

			/* obtener posición del puntero de campo */
			$currentfield = $r2->current_field;       
			$tabla_titulos=$tabla_titulos."<th style='text-transform:uppercase; font-size:9pt;'>".$finfo->name."</th>";
			$cuantas_columnas = $cuantas_columnas + 1;        
	}

	$tbCont = $tbCont."  
	<thead>
	<tr>
		".$tabla_titulos."  
	</tr>
	</thead>"; //Encabezados
	$tbCont = $tbCont."<tbody class='tabla'>";
	$cuantas_filas=0;
	$r = $Vivienda -> query($sql);
	 while($f = $r-> fetch_row())
	{//LISTAR COLUMNAS

		$tbCont = $tbCont."<tr>";        
		for ($i = 1; $i <= $cuantas_columnas; $i++) {      
			$tbCont = $tbCont."<td style='font-size:10pt;'>".$f[$i-1]."</td>";       
			}

		$tbCont = $tbCont."</tr>";
		$cuantas_filas = $cuantas_filas + 1;        
	}

	$tbCont = $tbCont."</tbody>";
	$tbCont = $tbCont."</table></div>";

}
	return $tbCont;
}


function EnviarNotificacion ($usuario, $asunto, $contenido){
	require("config.php");
	if ($usuario <> ''){
	// $npase = npase(FALSE);
	$sql = "INSERT INTO notificaciones
		(nitavu, asunto, contenido, entregar_fecha)
	VALUES
		('$usuario', '$asunto', '$contenido', '$fecha')";
	
	if ($conexion->query($sql) == TRUE)
	{
		return TRUE;
	}
	else
	{return FALSE;}
	
	}

}


function CuantasNotificaciones($nitavu){
	require("config.php");

	$sql = "select count(*) as n from notificaciones where nitavu='".$nitavu."' and visto=0";
	$r= $conexion -> query($sql);					
	
	if($f = $r -> fetch_array())
	{
		return $f['n'];
	} else {
		return 0;
	}
}

function guardareporte($idreporte,$sql,$nitavu, $fecha1, $fecha2, $dato1,$dato2,$bd ){
	require("config.php");

	$sqlnew = "Update reportes_exporta set queryx='".$sql."', nitavu=".$nitavu.", fecha1='".$fecha1."',fecha2='".$fecha2."',dato1='".$dato1."',dato2='".$dato2."' where id=".$idreporte ;
	if ($bd=='produccion_itavu'){
		$r= $conexion -> query($sqlnew);		
		return true;			
	}
	else{
		$r= $vivienda -> query($sqlnew);					
		return true;
	}
	
	/* if($f = $r -> fetch_array())
	{
		return true;
	} else {
		return false;
	} */
}

//*funciones para reportes 

function ReporteTipo2($id_rep){
    require("config.php");   
    // var_dump($dbUser);
    $sql = "select * from reportes WHERE id_rep ='".$id_rep."'";        
    
    $r= $conexion -> query($sql);
    if($f = $r -> fetch_array())
    {
        return $f['out_type'];
    } else {
        return "FALSE";
    }
        
}

function PermisoReporte_Ver2($IdUser,$IdRep){
    require("config.php");   
    $sql = "select count(*) as n
    
    from reportes_permisos WHERE IdUser ='".$IdUser."' and id_rep='".$IdRep."'";
    $rc= $conexion -> query($sql);
    
    
    if($f = $rc -> fetch_array())
    {
        if ($f['n']==1)  {
            return TRUE; // es admin
        } else {
            return FALSE; // no es admin
        }
    } else {
        return FALSE;
    }

}

function UltimasBusquedas_buble2($IdUser){
    require("config.php");	    
    $sql = "select DISTINCT Search from search where IdUser = '".$IdUser."' order by IdSearch DESC limit 10";
    // echo $sql;
    $rx = $conexion->query($sql);    
    if ($conexion->query($sql) == TRUE){
        echo "<div id='UltimasBusquedas_buble'>";
        
        while($fx= $rx -> fetch_array()) {  
           
            echo "<a class='Buble'  style='background-color:".Preference("ColorSecundario", "", "").";'           
            href='index.php?q=".$fx['Search']."' title='haga clic aqui para realizar esta busqueda'>".$fx['Search']."</a>";
            
        }
        
        echo "</div>";
        

    } else {
        
    }

}


//*** FUNCION PARA TICKETS */
//OBTIENE NUMERO DE OFICIO
function oficioCaso($id){
    require("config.php");
    $sql = "SELECT * FROM cp_nuevosdocumentos WHERE id='".$id."'";
    $enviar = '';
    $r = $conexion -> query($sql);
    while($f = $r -> fetch_array())
    { // resultado de la busqueda.................
        $enviar = $f['oficioNumero'];
    }
    return $enviar;
}


?>



