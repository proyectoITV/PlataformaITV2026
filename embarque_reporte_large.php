<?php 	require("config.php");


if (isset($_GET['nuc']) AND isset($_GET['guia'])){//si se cumplen estas variables ejecutar el reporte
    $ok= validar_guia($_GET['guia'], $_GET['nuc']);//Validamos que el usuario este aut para ver el reporte, origen, destino y titulares
    if ($ok == '' ){
        historia($_GET['nuc'],"Vio Ticket de la guia ".$_GET['guia']);
        embarques_impresion_visto($_GET['guia'], $_GET['nuc']);
        reporte_guia($_GET['guia']); // llamamos al reporte pdf
    
    } else {mensaje('ERROR: '.$ok,'embarques.php');}    
}
else{mensaje("Error al iniciar el reporte", 'embarques.php');}










function embarques_impresion_visto($guia, $user){
require("config.php");
$sql = "UPDATE embarques_guias SET visto_paraimprimir='1' wHERE guia='".$guia."'";
//echo $sql;
$resultado = $conexion -> query($sql);
if ($conexion->query($sql) == TRUE) {
	historia($user, "Vio la guia ".$guia." para imprimir");
	//header('location:../vigilancia3.php');
	return TRUE;
}
else {
	return FALSE;
}
}


///------- funcion para generar el reporte de guia -------------------------
function reporte_guia($guia){
require('config.php');

//seleccionar por proveedor
if (guia_proveedor($guia)=='1'){
    require_once('pdf/tcpdf.php');    
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    $pdf->setPrintHeader(false);
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
    $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
    if (@file_exists(dirname(__FILE__).'pdf/lang/eng.php')) {require_once(dirname(__FILE__).'pdf/lang/eng.php');$pdf->setLanguageArray($l);}
    $pdf->SetFont('dejavusans', '', 7); $pdf->AddPage('L'); //en la tabla de reporte L o P

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
        'border' => false,
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
        (select cat_gerarquia.nivel from cat_gerarquia where cat_gerarquia.id = Qorigen) as origen_tipo,	
        (select cat_delegaciones.ciudad from cat_delegaciones where cat_delegaciones.dpto_id = Qorigen) as origen_ciudad,
        (select cat_delegaciones.telefono from cat_delegaciones where cat_delegaciones.dpto_id = Qorigen) as origen_telefono,
        (select cat_delegaciones.domicilio from cat_delegaciones where cat_delegaciones.dpto_id = Qorigen) as origen_domicilio,
        (select cat_delegaciones.cp from cat_delegaciones where cat_delegaciones.dpto_id = Qorigen) as origen_cp,

        embarques_guias.destino as Qdestino,
        (select cat_gerarquia.nombre from cat_gerarquia where cat_gerarquia.id = Qdestino) as destino_nombre,
        (select cat_gerarquia.nivel from cat_gerarquia where cat_gerarquia.id = Qdestino) as destino_tipo,
        (select cat_delegaciones.ciudad from cat_delegaciones where cat_delegaciones.dpto_id = Qdestino) as destino_ciudad,
        (select cat_delegaciones.telefono from cat_delegaciones where cat_delegaciones.dpto_id = Qdestino) as destino_telefono,
        (select cat_delegaciones.domicilio from cat_delegaciones where cat_delegaciones.dpto_id = Qdestino) as destino_domicilio	,
        (select cat_delegaciones.cp from cat_delegaciones where cat_delegaciones.dpto_id = Qdestino) as destino_cp,
        embarques_guias.asignacion as Qasignacion,
        (select nombre from empleados where nitavu=Qasignacion) as asignacion_nombre,
        (select empleados.profesion_abr from empleados where nitavu=Qasignacion) as asignacion_abr,
        (select empleados.dpto from empleados where nitavu=Qasignacion) as asignacion_dpto,
        (select cat_gerarquia.nombre from cat_gerarquia where id=asignacion_dpto) as asignacion_dpto_nombre,	
        (select CONCAT(empleados.puesto, ' de ', asignacion_dpto_nombre) from empleados where nitavu=Qasignacion) as asignacion_puesto
    FROM
        embarques_guias
    WHERE
        guia = '".$guia."'
    "; //echo $sql;    

    $instrucciones = "
    <div id='AppDetalle'>INSTRUCCIONES PARA REGISTRAR RECEPCION</div>
    <ol>
        <li>Debe estar dentro de la plataforma https://plataformaitavu.tamaulipas.gob.mx</li>
        <li>En la aplicacion Embarques, aparecera en el recuadro de color naranja - POR LLEGAR - este paquete, seleccione la palomita de color verde para empezar el registro</li>
        <li>Le pedira el codigo de envio, que esta impreso en esta hoja junto al codigo QR</li>
        <li>(opcional) Puede indicar algun comentario, referente a lo que acaba de recibir.</li>
        <li>* El paquete lo puede recibir cualquier personal del DESTINO y registrarlo con esta hoja.</li>
        
    </ol>
    ";
    $url="";
    // echo $sql;
    $rc= $conexion -> query($sql); if($f = $rc -> fetch_array())
    { 
        $pdf->SetXY(0, 0);
        $pdf->Image('img/afimex_plantilla2.jpg', '', '', 215, 140, '', '', 'T', false, 300, '', false, false, 0, false, false, false);    
        
        
        //$pdf->Text(10, 5, 'NUMERO DE GUIA'); $pdf->Text(100, 5,$f['Proveedor']);
        
        //$pdf->SetFont('times', 'BI', 20, '', 'false');
        $pdf->SetFont('', 'B', 14, '', 'false');
        $pdf->Text(8, 115, ''.$guia); 
        
        
        $pdf->SetXY(5, 100); //codigo de barras  7 digitos EAN8        
        $pdf->write1DBarcode($guia, 'C128', '', '', '', 18, 0.5, $stylebar, 'N');       
        
        // $url = $urlsite.'embarques.php?recibir='.$f['guia'].'&guia='.$f['guia'].'&token='.$f['token'].'&descripcion=Registro por codigo QR';
        $pdf->write2DBarcode($guia, 'QRCODE,M', 180, 4, 30, 30, $styleqr, 'N'); 
        // $pdf->Text(150, 20, 'CODIGO DE ENVIO: '.$f['token']);
        

        $pdf->SetFont('', 'R', 8, '', 'false');
        $pdf->Text(38, 126, ''.$fecha." ".date("g:ia",strtotime($hora))); 
        

        

        // if (isset($_GET['notoken'])){

        // }else{
        // $url = $urlsite.'embarques.php?recibir='.$f['guia'].'&guia='.$f['guia'].'&token='.$f['token'].'&descripcion=Registro por codigo QR';
        // $pdf->write2DBarcode($url, 'QRCODE,M', 150, 25, 50, 50, $styleqr, 'N'); 
        // $pdf->Text(150, 20, 'CODIGO DE ENVIO: '.$f['token']);
        // }

        //====== CIUDAD DE ORIGEN ========
        $origen_ciudad = "Ciudad Victoria, Tam."; //ciudad por default
        if ($f['origen_tipo']=='del'){//si es del, ponemos la bd
            $origen_ciudad = $f['origen_ciudad'];}
        $pdf->SetFont('', 'R', 10, '', 'false');
        $pdf->Text(8, 86, ''.$origen_ciudad); 


        //====== REMITENTE ========
        $origen_remitente = $pyme_name; //ciudad por default
        $pdf->SetFont('', '', 8, '', 'false');
        $pdf->Text(8, 67, ''.$origen_remitente); 
        $pdf->SetFont('', 'R', 7, '', 'false'); $pdf->Text(8, 70, ''.$f['origen_nombre']); 


        
        //====== DOMICILIO ORIGEN ========
        if ($f['origen_tipo']=='del'){//si es delegacion usamos el de la delegacion
            $pdf->SetFont('', '', 8, '', 'false');
            //$pdf->Text(6, 118, ''.$f['origen_domicilio']); 
            $pdf->Text(8, 77, ''.substr($f['origen_domicilio'],0,60)."--"); 
            $pdf->Text(8, 80, ' -- '.substr($f['origen_domicilio'],60)."."); 
        }else{//sino es del usamos el de oficinas centrales
            $pdf->SetFont('', '', 7, '', 'false');
            $pdf->Text(8, 77, ''.$pyme_direccion);
            $pdf->Text(8, 80, ''.$pyme_direccion2);
        }
        
        //======  ORIGEN TELEFONO ========
        if ($f['origen_tipo']=='del'){//si es delegacion usamos el de la delegacion
            $pdf->SetFont('', 'B', 10, '', 'false');
            $pdf->Text(8, 95, 'Telefono: '.$f['origen_telefono']); 
        }else{//sino es del usamos el de oficinas centrales
            $pdf->SetFont('', '', 9, '', 'false');
            $pdf->Text(8, 95, ''.$pyme_tels);
            
        }
        
        //======  ORIGEN CP ========
        if ($f['origen_tipo']=='del'){ // sino es delegacion entonces es oficinas centrales
            $pdf->SetFont('', 'R', 9, '', 'false');
            $pdf->Text(56, 95, 'C.P.'.$f['origen_cp']); 
        }  else {                
            $pdf->SetFont('', 'R', 9, '', 'false');
            $pdf->Text(56, 95, 'C.P. 87020'); 
        }




        //====== CIUDAD DE DESTINO ========
        if ($f['foraneo']=='1' ){
        $destino_ciudad = $f['ciudad']; //ciudad por default        
        $pdf->SetFont('', 'R', 10, '', 'false');
        $pdf->Text(106, 87, ''.$destino_ciudad); 
        
        } else{        
        $destino_ciudad = "Ciudad Victoria, Tam."; //ciudad por default        
        if ($f['destino_tipo']=='del'){//si es del, ponemos la bd
            $destino_ciudad = $f['destino_ciudad'];}
        $pdf->SetFont('', 'R', 10, '', 'false');
        
        $pdf->Text(106, 87, ''.$destino_ciudad); 
        }


        //====== DESTINATARIO ========
        $origen_remitente = $pyme_name; //ciudad por default
        $pdf->SetFont('', '', 7.5, '', 'false');
        if ($f['foraneo']=='1'){
            $pdf->Text(106, 68, ''.$f['destino']); 
            $pdf->SetFont('', 'R', 8, '', 'false'); ; 

        }else {
        $pdf->Text(106, 68, ''.$origen_remitente); 
        $pdf->SetFont('', 'R', 8, '', 'false'); $pdf->Text(106, 71, ''.$f['destino_nombre']); }

            
        //====== DOMICILIO DESTINO ========
        if ($f['foraneo']=='1'){
             $pdf->SetFont('', '', 9, '', 'false');
            $pdf->Text(106, 77, ''.substr($f['domicilio'],0,60)."--"); 
            $pdf->Text(106, 80, ' -- '.substr($f['domicilio'],60)."."); 
        }
        else{
            if ($f['destino_tipo']=='del'){//si es delegacion usamos el de la delegacion
                $pdf->SetFont('', '', 8, '', 'false');
                $pdf->Text(106, 77, ''.substr($f['destino_domicilio'],0,60)."--"); 
                $pdf->Text(106, 80, ' -- '.substr($f['destino_domicilio'],60)."."); 
            }else{//sino es del usamos el de oficinas centrales
                $pdf->SetFont('', '', 8, '', 'false');
                $pdf->Text(106, 77, ''.$pyme_direccion);
                $pdf->Text(106, 80, ''.$pyme_direccion2);
            }
        }

        //======  ORIGEN TELEFONO ========
        if ($f['foraneo']=='1'){
            $pdf->SetFont('', 'R', 9, '', 'false');
            $pdf->Text(106, 95, ''.$f['telefono']); 
        }
        else {
            if ($f['destino_tipo']=='del'){//si es delegacion usamos el de la delegacion
                $pdf->SetFont('', 'R', 9, '', 'false');
                $pdf->Text(106,95, ''.$f['destino_telefono']); 
            }else{//sino es del usamos el de oficinas centrales
                $pdf->SetFont('', '', 9, '', 'false');
                $pdf->Text(106, 95, ''.$pyme_tels);
                
            }
        }

        //======  ORIGEN CP ========
        if ($f['destino_tipo']=='del'){ // sino es delegacion entonces es oficinas centrales
            $pdf->SetFont('', 'R', 9, '', 'false');
            $pdf->Text(158, 96, 'C.P.'.$f['destino_cp']); 
        }  else {                
            $pdf->SetFont('', 'R', 9, '', 'false');
            $pdf->Text(158, 96, 'C.P. 87020'); 
        }

           


    //     //====== RESO DEL DOC========
     
        $pdf->SetFont('', '', 9, '', 'false');
        // $pdf->Text(120, 130, 'Descripcion del envio:'); 
        $pdf->Text(120, 140, ''); 
        $pdf->writeHTML('<p style="'.$recuadro4.'">Descripcion:'.$f['descripcion'].'</p>', true, false, true, false, '');

        $pdf->SetFont('', 'I', 9, '', 'false');
        $pdf->Text(120, 155, 'Aut. del envio'); 
        
        $pdf->SetFont('', 'BI', 10,'', 'false');
        $pdf->Text(120, 175, $f['asignacion_abr'].' '.$f['asignacion_nombre']); 
        
        $pdf->SetFont('', 'I', 9, '', 'false');
        $pdf->Text(120, 180, $f['asignacion_puesto']); 
        

        //$pdf->Text(94, 177, ''.$f['asignacion_nombre']); 
        
        // $pdf->Text(100, 80, ''); $pdf->writeHTML('<span style="'.$recuadro2.'"> Origen: '.$f['origen_nombre'].'</span>', true, false, true, false, '');
        // $pdf->Text(100, 90, ''); $pdf->writeHTML('<span style="'.$recuadro2.'"> Destino: '.$f['destino_nombre'].'</span>', true, false, true, false, '');
        // $pdf->Text(100, 60, ''); $pdf->writeHTML('<span style="'.$recuadro3.'"> Registro: '.$f['registro_fecha'].', '.$f['registro_hora'].'</span>', true, false, true, false, '');
        // $pdf->Text(100, 105, ''); $pdf->writeHTML('<div style="'.$recuadro4.'">'.$f['descripcion'].'</div>', true, false, true, false, '');


        $url = $urlsite.'embarques.php?recibir='.$f['guia'].'&guia='.$f['guia'].'&token='.$f['token'].'&descripcion=Registro por codigo QR';
        $pdf->write2DBarcode($url, 'QRCODE,M', 220, 4, 30, 30, $styleqr, 'N'); 
        $pdf->Text(220, 35, 'CODIGO DE ENVIO: '.$f['token']);



        if ($f['recibido']<>''){
            
            $pdf->StartTransform();
            $pdf->Rotate(-30);
            $pdf->SetTextColor(255,0,0);            
            $pdf->SetFont('', 'B', 48, '', 'false');
            $pdf->Text(20, 150,'RECIBIDO'); 

            $pdf->SetFont('', 'B', 10, '', 'false');            
            $pdf->Text(30, 170,$f['recibio_fecha']." ".$f['recibio_hora']." | Empleado No. ".$f['recibido']); 
            
            
            //$pdf->Cell(120,10,'RECIBIDO',1,1,'L',0,'');
            $pdf->StopTransform();
        }




    }
}
else {

    mensaje("ERROR: No esta configurado el reporte para este proveedor, Disculpe las molestias. Comlibrse a soporte ",'embarques.php');
}

// PRINT VARIOUS 1D BARCODES

// CODE 39 - ANSI MH10.8M-1983 - USD-3 - 3 of 9.




//$pdf->Text(1, 1, '1,85');

$pdf->lastPage();
$pdf->Output('reporte.pdf', 'I');
}




//FUNCION PARA VALIDAR LA GUIA Y EL USUARIO
function validar_guia($guia, $usuario){require("config.php");
$ok='';$sql = "SELECT * FROM embarques_guias WHERE guia='".$guia."'"; //echo $sql;        
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
    {   
        if ($f['foraneo']=='1'){
            $ok='';
        }
        else {
        if ($f['origen']<>'' and $f['destino']<>''){        
            //consulta y valida si el usuario esta aut. (solo origen, destino y titulares)
            $sql="select * from empleados where dpto in(".$f['origen'].",".$f['destino'].") and estado='' AND nitavu='".$usuario."'                      
            UNION
            select * from empleados where estado='' and nitavu=(select titular from cat_gerarquia where titular=nitavu limit 1) and nitavu='".$usuario."'";
            $rc2= $conexion -> query($sql);
            if($Aut = $rc2 -> fetch_array())
            {   //no hacemos nada, $ok pasa sin nada         
            } else {
                $ok ='Usuario no autorizado para ver esta guia';
            }
        } else{
            $ok='La datos de la guia no estan completos';
        }

    }
}
else {
    $ok = "Guia no registrada";
}   
return $ok; //------------------------
}



function guia_proveedor($id){
require("config.php");
$sql = "SELECT * FROM embarques_guias WHERE guia='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{ return $f['paqueteria_id'];} else {return "";}
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