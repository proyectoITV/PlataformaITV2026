<?php 	require("config.php");


if (isset($_GET['nuc']) AND isset($_GET['guia'])){//si se cumplen estas variables ejecutar el reporte
    $ok= validar_guia($_GET['guia'], $_GET['nuc']);//Validamos que el usuario este aut para ver el reporte, origen, destino y titulares
    if ($ok == '' ){
        historia($_GET['nuc'],"Vio PDF de la guia ".$_GET['guia']);
        pdf_guia($_GET['guia']); // llamamos al reporte pdf

    
    } else {mensaje('ERROR: '.$ok,'embarques.php');}    
}
else{mensaje("Error al iniciar el reporte", 'embarques.php');}










///------- funcion para generar el PDF de guia -------------------------
function pdf_guia($guia){
require('config.php');
if (embarque_proveedor($guia)==1){
    require_once('pdf/tcpdf.php');    
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->setPrintHeader(false); $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);  $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    if (@file_exists(dirname(__FILE__).'pdf/lang/eng.php')) {require_once(dirname(__FILE__).'pdf/lang/eng.php');$pdf->setLanguageArray($l);}
    $pdf->SetFont('dejavusans', '', 7); $pdf->AddPage('P'); //en la tabla de reporte L o P

    //VARIABLES DE ESTILOS
    $recuadro = "border: 2px #000000 solid; border-radius:5px; font-size: 28pt; font-weight:bold; padding:10px; width:100%; height:300em;";
    $recuadro2 = "border: 0px #000000 solid; border-radius:5px; font-size: 14pt; font-weight:bold; padding:10px; width:100%;";
    $recuadro3 = "border: 0px #000000 solid; border-radius:5px; font-size: 12pt;  padding:10px; width:100%;";
    $recuadro4 = "border: 0px #000000 solid; border-radius:5px; font-size: 8pt;  padding:10px; width:100%;";
    $style = array(
        'position' => '',
        'align' => 'C',
        'stretch' => false,
        'fitwidth' => true,
        'cellfitalign' => '',
        'border' => true,
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
        *,
        embarques_guias.paqueteria_id as Qprov,
        (select embarques_proveedores.nombre from embarques_proveedores where embarques_proveedores.id = Qprov) as Proveedor,
        embarques_guias.origen as Qorigen,
        (select cat_gerarquia.nombre from cat_gerarquia where cat_gerarquia.id = Qorigen) as origen_nombre,
        embarques_guias.destino as Qdestino,
        (select cat_gerarquia.nombre from cat_gerarquia where cat_gerarquia.id = Qdestino) as destino_nombre
        
    FROM
        embarques_guias
    WHERE
        guia = '".$guia."'
    "; //echo $sql;    
    $rc= $conexion -> query($sql); if($f = $rc -> fetch_array())
    {       
                $pdf->MultiCell(115, 5, '', 1, '', 0, 1, '', '', true);
                $pdf->Text(10, 10, ''); $pdf->writeHTML('<div style="'.$recuadro.'"></div>', true, false, true, false, '');


            //     $pdf->Text(10, 5, 'NUMERO DE GUIA'); $pdf->Text(100, 5,$f['Proveedor']);
            //     $pdf->Text(10, 10, '');
            //     $pdf->writeHTML('<div style="'.$recuadro.'">'.$f['guia'].'</div>', true, false, true, false, '');

            //     //$pdf->write1DBarcode($guia, 'C39', '', '', '', 30, 0.4, $style, 'N');
            //     $pdf->write1DBarcode($guia, 'EAN8', '', '', '', 30, 0.8, $style, 'N');
            //     //$pdf->write1DBarcode($guia, 'C128C', '', '', '', 30, 0.4, $style, 'N');
            //     if (isset($_GET['notoken'])){

            //     }else{
            //     $url = $urlsite.'embarques.php?recibir='.$f['guia'].'&guia='.$f['guia'].'&token='.$f['token'].'&descripcion=Registro por codigo QR';
            //     $pdf->write2DBarcode($url, 'QRCODE,M', 150, 25, 50, 50, $styleqr, 'N'); $pdf->Text(150, 25, 'CODIGO DE ENVIO: '.$f['token']);
            //     }

            //     $pdf->Text(100, 80, ''); $pdf->writeHTML('<span style="'.$recuadro2.'"> Origen: '.$f['origen_nombre'].'</span>', true, false, true, false, '');
            //    // $pdf->writeHTML('<p style="'.$recuadro4.'">'.$instrucciones.'</p>', true, false, true, false, '');
    }

$pdf->lastPage();
$pdf->Output('reporte.pdf', 'I');
}//fin id proveedor de afimex

}




//FUNCION PARA VALIDAR LA GUIA Y EL USUARIO
function validar_guia($guia, $usuario){require("config.php");
$ok='';$sql = "SELECT * FROM embarques_guias WHERE guia='".$guia."'"; //echo $sql;        
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
    {   //consulta y valida si el usuario esta aut. (solo origen, destino y titulares)
        $sql="select * from empleados where dpto in(".$f['origen'].",".$f['destino'].") and estado='' AND nitavu='".$usuario."'                      
        UNION
        select * from empleados where estado='' and nitavu=(select titular from cat_gerarquia where titular=nitavu) and nitavu='".$usuario."'";
        $rc2= $conexion -> query($sql);
        if($Aut = $rc2 -> fetch_array())
        {   //no hacemos nada, $ok pasa sin nada         
        } else {
            $ok ='Usuario no autorizado para ver esta guia';
        }
}
else {
    $ok = "Guia no registrada";
}   
return $ok; //------------------------
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
        
function embarque_proveedor($id){
require("config.php");
$sql = "SELECT * FROM embarques_guias WHERE guia='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{ 
		return $f['paqueteria_id'];
	}
}


?>