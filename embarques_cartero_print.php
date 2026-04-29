<?php 	require("config.php");


if (isset($_GET['nuc']) AND isset($_GET['guia'])){//si se cumplen estas variables ejecutar el reporte
        historia($_GET['nuc'],"Vio Envio con NPase de la guia ".$_GET['guia']);
        reporte_guia($_GET['guia']); // llamamos al reporte pdf   
}
else{mensaje("Error al iniciar el reporte", 'embarques.php');}


///------- funcion para generar el reporte de guia -------------------------
function reporte_guia($guia){
    require('config.php');
    require_once('pdf/tcpdf.php');    
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->setPrintHeader(false);
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    if (@file_exists(dirname(__FILE__).'pdf/lang/eng.php')) {require_once(dirname(__FILE__).'pdf/lang/eng.php');$pdf->setLanguageArray($l);}
    $pdf->SetFont('dejavusans', '', 7); $pdf->AddPage('P'); //en la tabla de reporte L o P

    //VARIABLES DE ESTILOS
    $recuadro = "border: 2px #000000 solid; border-radius:5px; font-size: 28pt; font-weight:bold; padding:10px; width:50%;";
    $recuadro2 = "border: 0px #000000 solid; border-radius:5px; font-size: 14pt; font-weight:bold; padding:10px; width:100%;";
    $recuadro3 = "border: 0px #000000 solid; border-radius:5px; font-size: 12pt;  padding:10px; width:100%;";
    $recuadro4 = "border: 0px #000000 solid; border-radius:5px; font-size: 8pt;  padding:10px; width:100%;";
    $stylebar = array(
        'position' => '',
        'align' => 'C',
        'stretch' => false,
        'fitwidth' => true,
        'cellfitalign' => '',
        'border' => false,
        'hpadding' => 'auto',
        'vpadding' => 'auto',
        'fgcolor' => array(0,0,0),
        'bgcolor' => false, //array(255,255,255),
        'text' => true,
        'font' => 'helvetica',
        'fontsize' => 8,
        'stretchtext' => 40
    );
    $styleqr = array(
        'border' => true,
        'vpadding' => 'auto',
        'hpadding' => 'auto',
        'fgcolor' => array(0,0,0),
        'bgcolor' => false, //array(255,255,255)
        'module_width' => 1, // width of a single module in points
        'module_height' => 1 // height of a single module in points
    );




    $sql = "
SELECT
	embarques_cartero.asignacion as Qasignacion,
	(select nombre from empleados where nitavu=Qasignacion) as Asignacion1_nombre,
	embarques_cartero.asignacion2 as Qasignacion2,
	(select nombre from empleados where nitavu=Qasignacion2) as Asignacion2_nombre,
	embarques_cartero.origen as Qorigen,
	(select nombre from cat_gerarquia where id = Qorigen) as origen_nombre,
	embarques_cartero.registro as Qregistro,
	(select nombre from empleados where nitavu=Qregistro) as registro_nombre,
	embarques_cartero.idpase as QNPase,
	(select  autorizo_nitavu from empleados_salidas_temporal where id=QNPase) as Autorizo,
	(select  rechazada from empleados_salidas_temporal where id=QNPase) as Rechazada,
	embarques_cartero.*
FROM
	embarques_cartero
    WHERE
        idpase = '".$guia."'
    ";
    $rc= $conexion -> query($sql); 
    if($f = $rc -> fetch_array())
    { 
        $pdf->SetXY(0, 0);
        $pdf->Image('img/itavu_plantilla.jpg', '', '', 120, 190, '', '', 'T', false, 300, '', false, false, 0, false, false, false);    

        //$pdf->SetFont('times', 'BI', 20, '', 'false');
        $pdf->SetFont('', 'B', 18, '', 'false');
        $pdf->Text(73, 34, ''.$guia); 

        $pdf->SetXY(0   , 34); 
        $pdf->write1DBarcode($guia, 'C128', '', '', '', 24, 0.7, $stylebar, 'N');       
        
        $pdf->SetFont('', 'B', 10, '', 'false');
        $pdf->Text(73, 54, ''.$f['registro_fecha']); 
        
        $pdf->SetFont('', 'B', 10, '', 'false');
        $pdf->Text(10, 70, ''.$f['origen_nombre']);

        $pdf->SetFont('', '', 10, '', 'false');
        $pdf->Text(10, 75, 'Registro el envio: '.$f['registro_nombre']);
        $pdf->Text(10, 80, 'Designación para entregar: '.$f['Asignacion1_nombre']);

        if ($f['Asignacion2_nombre']<>''){
            $pdf->Text(10, 85, 'y '.$f['Asignacion2_nombre']);
        }

        $pdf->Text(8, 104, ''.$f['destino']);
        // $pdf->Text(8, 109, ''.substr($f['destino_domicilio'],0,60).""); 
        // $pdf->Text(8, 114, ''.substr($f['destino_domicilio'],60,120).""); 
        // $pdf->Text(8, 119, ''.substr($f['destino_domicilio'],120,180).""); 
        
        $ancho=55; $n=109; $a=0; $b=$ancho; $lineas=3; $salto=5; 
        for ($i = 1; $i <= $lineas; $i++) {
            $pdf->Text(8, $n, ''.substr($f['destino_domicilio'],$a,$ancho).""); 
            $n = $n + $salto; $a=$b; $b = $b + $ancho;
        }




        $pdf->Text(8, 124, ''.$f['destino_ciudad']);
        $pdf->Text(8, 129, 'TELEFONO:'.$f['destino_telefono']);

        $pdf->SetFont('', '', 7, '', 'false');
        $ancho=78; $n=135; $a=0; $b=$ancho; $lineas=10; $salto=3; 
        for ($i = 1; $i <= $lineas; $i++) {
            $pdf->Text(6, $n, substr($f['descripcion'],$a,$ancho).""); 
            $n = $n + $salto; $a=$b; $b = $b + $ancho;
        }


        if ($f['recibido']<>''){
            
            $pdf->StartTransform();
            $pdf->Rotate(-50);

            $pdf->SetTextColor(255,0,0);            
            $pdf->SetFont('', 'B', 48, '', 'false');
            $pdf->Text(8, 200,'RECIBIDO'); 
            

            
            
            //$pdf->Cell(120,10,'RECIBIDO',1,1,'L',0,'');
            $pdf->StopTransform();
        }




    }



$pdf->lastPage();
$pdf->Output('reporte.pdf', 'I');
}







//FUNCIO COMPLEMENTARIA PARA MENSAJE
function mensaje($mensaje, $link){
if ($link=="") {$link = "../index.php";}
$tipo = substr($mensaje, 0,5);    // devuelve "ef"

	

//echo '<div class="padre">';
//echo '<span class="hijo">';
$style_msg = "color: black;
                                                                                                    text-align: center;
                                                                                                    border-radius: 10px;
                                                                                                    border: 2px solid white;
                                                                                                    background-color: white;
                                                                                                    width: 90%;
                                                                                                    position: absolute;
                                                                                                    top: 0%;
                                                                                                    left: 2%;
                                                                                                    right: 0%;
                                                                                                    z-index: 2010;
                                                                                                    opacity: 1;
                                                                                                    padding: 10px;
                                                                                                    margin: 10px;
                                                                                                    margin-top: 100px;
                                                                                                    transition: all 5s cubic-bezier(.46, .03, .52, .96)";
$style_msg_error = "    color: red;
                                                                                                    text-align: center;
                                                                                                    border-radius: 10px;
                                                                                                    border: 2px solid red;
                                                                                                    background-color: white;
                                                                                                    width: 90%;
                                                                                                    position: absolute;
                                                                                                    top: 0%;
                                                                                                    left: 2%;
                                                                                                    right: 0%;
                                                                                                    z-index: 2010;
                                                                                                    opacity: 1;
                                                                                                    padding: 10px;
                                                                                                    margin: 10px;
                                                                                                    margin-top: 100px;
                                                                                                    transition: all 5s cubic-bezier(.46, .03, .52, .96)";
                                                                                                    
		if ($tipo=='ERROR'){echo '<div id="msg_error" style="'.$style_msg_error.'">';}
		else{echo '<div id="mensaje" style="'.$style_msg.'">';}
		echo '<p>'.$mensaje.'</p>';
		echo '<a class="Mbtn btn-default" href="'.$link.'">Aceptar</a>  ';
		//echo '<a class="Mbtn btn-cancel" href="'.$link.'">Cerrar</a>';
		//habla($mensaje);
		echo '</div>';
		
//echo '</span>';
//echo '</div>';

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
        

?>