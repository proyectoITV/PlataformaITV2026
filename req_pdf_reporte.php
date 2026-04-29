<?php
require("config.php");
require_once('seguridad.php');
require_once('lib/funciones.php');
require_once('pdf/tcpdf.php');
require('lib/flor_funciones.php');
require('lib/yes_funciones.php');


$id_aplicacion ="ap58";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
$orientacion='P';

if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{
    $iddir = $_POST['iddireccion'];    
    if (isset($_POST['departamento']) && !empty($_POST['departamento'])) 
    {
        $iddpto = $_POST['departamento'];
    }
    else {
     $iddpto=0;
    }


    $search = $_POST['search'];  
    $idTipo = $_POST['idTipoRequisicion'];
    $fechaInicio = $_POST['fechaI'];
    $fechaFinal = $_POST['fechaF'];
    $nomdpto=strtoupper(dpto_id($iddpto));
    $nomdir=strtoupper(dpto_id($iddir));
    if($idTipo!=4){
        $titulo='REQUISICIONES ENTREGADAS';
    }else {
        $titulo='PRODUCTOS COMPRADOS';
    }
 

        $tablaDatos1='<BR><BR><table style="width:100%;font-size: 11px;">';
        $tablaDatos1=$tablaDatos1."<tr>"; 
        $tablaDatos1=$tablaDatos1.'<td  colspan="5" style="text-align: center; font-size: 13px;"><b>' .$titulo.'</b></td>';
        $tablaDatos1=$tablaDatos1."</tr>";

        $tablaDatos1=$tablaDatos1.'<tr>';   
        $tablaDatos1=$tablaDatos1.'<td  colspan="5" style="text-align: center;"></td>';
        $tablaDatos1=$tablaDatos1.'</tr>'; 

        $tablaDatos1=$tablaDatos1.'<tr>';   
        $tablaDatos1=$tablaDatos1.'<td><b>DIRECCION</b></td>';
        $tablaDatos1=$tablaDatos1.'<td  colspan="3">'.$nomdir.'</td>';
        $tablaDatos1=$tablaDatos1.'<td></td>';
        $tablaDatos1=$tablaDatos1.'<td></td>';
        $tablaDatos1=$tablaDatos1.'<td></td>';        
        $tablaDatos1=$tablaDatos1.'</tr>';
       
        if ($iddpto!=0)
        {
            $tablaDatos1=$tablaDatos1.'<tr>';   
            $tablaDatos1=$tablaDatos1.'<td><b>DEPARTAMENTO</b></td>';
            $tablaDatos1=$tablaDatos1.'<td colspan="3">'.$nomdpto.'</td>';
                      
            $tablaDatos1=$tablaDatos1.'</tr>'; 
        } 

        $tablaDatos1=$tablaDatos1.'<tr>';   
        $tablaDatos1=$tablaDatos1.'<td><b>RANGO DE FECHAS:</b></td>';  
        $tablaDatos1=$tablaDatos1.'<td>'.date_format( date_create($fechaInicio), 'd/m/Y').'</td>';  
        $tablaDatos1=$tablaDatos1.'<td><b>A:</b></td>';  
        $tablaDatos1=$tablaDatos1.'<td>'.date_format( date_create($fechaFinal), 'd/m/Y').'</td>';    
        $tablaDatos1=$tablaDatos1.'<td></td>';         
        $tablaDatos1=$tablaDatos1.'</tr>';   
 
        $tablaDatos1=$tablaDatos1.'</table><br><br>'; 

    if($idTipo==0)
        {
            $msg='No ha especificado el filtro  que se utilizará para generar para el reporte';        
            mensaje($msg,'req_reporte_requisiciones2.php');
        }
        else
        {

        $tablaDatos='<BR>
        <table style="vertical-align:middle;">
            <tr>
            <td align="right" style=" font-size: 9px;">';
            $tablaDatos=$tablaDatos."Impreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($nitavu);	
                
            $tablaDatos=$tablaDatos.'</td></tr>    
        </table>
        <br><br>'; 
            
        if($idTipo!=4)
        {     
            $orientacion='L';   
            $sql = " -- req
            SELECT rq.IdRequisicion,
            CASE cg.nivel WHEN UPPER('dir') THEN (select UPPER(nombre)from cat_gerarquia where id= cg.id) WHEN '-' THEN UPPER(cg.nombre)
            ELSE CASE cgg.nivel
            WHEN cg.nivel=(UPPER('dpto') ) THEN ( CASE cg.nivel when 'del' THEN (select UPPER(nombre)from cat_gerarquia where id=19 ) else (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cgg.id )) END )
            WHEN cg.nivel= UPPER('sub') THEN (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cgg.id )) 
            WHEN cg.nivel=UPPER('staft') THEN (select UPPER(nombre)from cat_gerarquia where id= (select dependencia from cat_gerarquia where id= cg.id )) 
            WHEN cg.nivel=UPPER('CONSEJO') THEN UPPER(cg.nombre) END
            END 
            AS Direccion, 
            UPPER(cg.nombre) as Departamento, 
            tr.Requisicion, er.DesEstatus,   rq.FechaMod FROM req_requisiciones AS rq 
            INNER JOIN req_detallerequisicion AS dr on rq.IdRequisicion=dr.IdRequisicion
            INNER JOIN req_estatusreq AS er ON rq.IdEstatus=er.IdEstatus

            INNER JOIN req_tiporequisicion tr ON tr.IdTipoRequisicion=rq.IdTipoRequisicion 
            INNER JOIN cat_gerarquia AS cg ON cg.id=dr.IdDepartamento 
            LEFT JOIN cat_gerarquia AS cgg ON cgg.id=cg.dependencia ";
            // sr.FechaCrea, INNER JOIN req_seguimiento AS sr ON sr.IdRequisicion=rq.IdRequisicion "; 
            $sql = $sql."WHERE ";
            $sql = $sql."(rq.IdEstatus <> 6 and rq.IdEstatus<> 2) ";
        
        
            if($iddir>0 && $iddir!=$iddpto)
            {
                //$sql = $sql." AND (cgg.id = ".$iddir.") ";
                //$sql = $sql." AND (cgg.id = ".$iddir.") ";
                if($iddir==19 && ($iddpto!=20 && $iddpto!=21))
                {
                    $sql = $sql." AND (cgg.id in(select  cat_gerarquia.id from cat_gerarquia where dependencia= 21 or id= 21))";
                }else{
                $sql = $sql." AND (cgg.id in(select  cat_gerarquia.id from cat_gerarquia where dependencia= ".$iddir." or id= ".$iddir."))";
                }
                //$sql = $sql." AND (cgg.id in(select  cat_gerarquia.id from cat_gerarquia where dependencia= ".$iddir." or id= ".$iddir."))";
            }
            
            if($iddpto>0)
            {
                $sql = $sql." AND (cg.id = ".$iddpto.") ";
            }
            /// $sql = $sql."AND ((sr.FechaCrea>= '".$fechaInicio."' AND sr.FechaCrea<= '".$fechaFinal."' ) AND sr.IdEstatus=3) ";    // descomentar para requisiciones autorizadas
            $sql = $sql."AND ((rq.FechaMod>= '".$fechaInicio."' AND rq.FechaMod<  DATE_ADD('".$fechaFinal."', INTERVAL 1 DAY) ) AND rq.IdEstatus=5) "; 

            $sql = $sql." AND ((rq.idTipoRequisicion =".$idTipo.")) ";
            //$sql = $sql."GROUP BY rq.IdRequisicion ORDER BY sr.FechaCrea ASC"; // descomentar para requisiciones autorizadas
            $sql = $sql."GROUP BY rq.IdRequisicion ORDER BY rq.IdRequisicion ASC";
            //echo $sql;
            $rc= $conexion -> query($sql); 
            $r_count = $rc -> num_rows;
                
            if ($r_count<=0)
                    {   
                        historia($nitavu,'Req_Busqueda fallida de '.$search.'-'.$fechaInicio.'-'.$fechaFinal);
                    }
            else
            {             
                    
                historia($nitavu,'Req_Busqueda exitosa de '.$search.'-'.$fechaInicio.'-'.$fechaFinal);    
                $tabla_contenido2='<center><table style="width:100%; border: 0.3px solid black; font-size: 10px;">                            
                <tr style=" text-align: center; background-color:#BDBDBD;  font-weight:bold;">
                    <td  style="width:5%; text-align: center;  border: 0.3px solid black;">#</td>				
                    <td  style="width:5%;vertical-align:middle; border: 0.3px solid black;">ID REQ</td>
                    <td  style="width:30%;vertical-align:middle; border: 0.3px solid black;">DIRECCION</td>
                    <td  style="width:20%;vertical-align:middle; border: 0.3px solid black;">DEPARTAMENTO</td>
                    <td  style="width:20%;vertical-align:middle; border: 0.3px solid black;">TIPO REQUISICION</td>
                    <td  style="width:10%;vertical-align:middle; border: 0.3px solid black;">ESTATUS</td>
                    <td  style="width:10%;vertical-align:middle; border: 0.3px solid black;">FECHA CREA</td>
                </tr>';
                $rc= $conexion -> query($sql);               
                $cont=0;                            
                while($cat = $rc -> fetch_array())
                    {
                        $cont=$cont+1;
                        $tabla_contenido2= $tabla_contenido2.'<tr ><td style="width:5%; text-align: center; border: 0.3px solid black; ">'.$cont.'</td>';
                        $tabla_contenido2= $tabla_contenido2.'<td style="width:5%; border: 0.3px solid black;">'.$cat['IdRequisicion'].'</td>';
                        $tabla_contenido2= $tabla_contenido2.'<td style="width:30%; border: 0.3px solid black;">'.$nomdir.'</td>';
                        $tabla_contenido2= $tabla_contenido2.'<td style="width:20%; border: 0.3px solid black;">'.$cat['Departamento'].'</td>'; 
                        $tabla_contenido2= $tabla_contenido2.'<td style="width:20%; border: 0.3px solid black;">'.$cat['Requisicion'].'</td>';                
                        $tabla_contenido2= $tabla_contenido2.'<td style="width:10%; border: 0.3px solid black;">'. $cat['DesEstatus'].'</td>'; 
                        $tabla_contenido2= $tabla_contenido2.'<td style="width:10%; border: 0.3px solid black;">'.date_format( date_create($cat['FechaMod']), 'd/m/Y').'</td></tr>';         
                    }  
                    $tabla_contenido2=$tabla_contenido2."</table></center><br><br><br><br>";
                    $html= $tablaDatos1.$tablaDatos.$tabla_contenido2;              
                    
            }   
        }
    else 
    {
        $orientacion='P';
        $sql = " -- req 
            SELECT dr.IdConcepto,rc.Concepto, sum(dr.cantidad) as Cantidad ,rq.FechaMod,tr.Requisicion
            FROM req_detallerequisicion AS dr RIGHT JOIN req_conceptos AS rc ON dr.IdConcepto=rc.IdConcepto 
            LEFT JOIN req_requisiciones AS rq on rq.IdRequisicion=dr.IdRequisicion
             
            INNER JOIN req_tiporequisicion as tr on tr.IdTipoRequisicion=rc.IdTipoRequisicion   
            INNER JOIN cat_gerarquia AS cg ON cg.id=dr.IdDepartamento 
            LEFT JOIN cat_gerarquia AS cgg ON cgg.id=cg.dependencia 
            WHERE dr.Cancelado=0 AND  (dr.IdRequisicion IS NOT NULL or dr.IdRequisicion!=0)";
            ///$sql = $sql."AND sr.IdEstatus=3 ";  //descomentar para requisiciones autorizadas
           /// $sql = $sql."AND rq.IdEstatus in(3,4,5) ";//descomentar para requisiciones autorizadas
            $sql = $sql."AND (rc.Concepto LIKE '%".$search."%' ) ";
                
             if($iddir>0 && $iddir!=$iddpto )
        {
            //$sql = $sql." AND (cgg.id = ".$iddir.") ";
            if($iddir==19 && ($iddpto!=20 && $iddpto!=21))
            {
                $sql = $sql." AND (cgg.id in(select  cat_gerarquia.id from cat_gerarquia where dependencia= 21 or id= 21))";
            }else{
            $sql = $sql." AND (cgg.id in(select  cat_gerarquia.id from cat_gerarquia where dependencia= ".$iddir." or id= ".$iddir."))";
            }
        }
         
           
            if($iddpto>0)
            {
                $sql = $sql." AND (cg.id = ".$iddpto.") ";
            }
            //$sql = $sql."AND (sr.FechaCrea>= '".$fechaInicio."' AND sr.FechaCrea<= '".$fechaFinal."' ) ";    //descomentar para requisiciones autorizadas
            $sql = $sql."AND ((rq.FechaMod>= '".$fechaInicio."' AND rq.FechaMod<  DATE_ADD('".$fechaFinal."', INTERVAL 1 DAY) ) AND rq.IdEstatus=5) "; 
            $sql = $sql."GROUP BY dr.IdConcepto HAVING sum(dr.Cantidad)>0 order by rc.Concepto ";
        
            
      
            $rc= $conexion -> query($sql);    
            $r_count = $rc -> num_rows;
            
        if ($r_count<=0)
            {   // en caso de haya resultados, hacer uno nuevo
                historia($nitavu,'Req_Busqueda fallida de '.$search.'-'.$fechaInicio.'-'.$fechaFinal);
               
                //mensaje($msg,"./req.php");
            }else
            {           
                $cont=0;
                historia($nitavu,'Req_Busqueda exitosa de '.$search.'-'.$fechaInicio.'-'.$fechaFinal); 

                $tabla_contenido2='<center><table style="width:100%; border: 0.3px solid black; font-size: 10px;">                            
                <tr style=" text-align: center; background-color:#BDBDBD;  font-weight:bold;">
                    <td  style="width:10%; text-align: center;  border: 0.3px solid black;">#</td>	
                    <td  style="width:70%;vertical-align:middle; border: 0.3px solid black;">CONCEPTO</td>                
                    <td  style="width:20%;vertical-align:middle; border: 0.3px solid black;">CANTIDAD</td>
                </tr>';
                //echo $sql;
                $rc= $conexion -> query($sql);               
                $cont=0;                            
                while($cat = $rc -> fetch_array())
                    {
                        $cont=$cont+1;
                        $tabla_contenido2= $tabla_contenido2.'<tr ><td style="width:10%; text-align: center; border: 0.3px solid black; ">'.$cont.'</td>';
                        $tabla_contenido2= $tabla_contenido2.'<td style="width:70%; border: 0.3px solid black;">'.$cat['Concepto'].'</td>';                                            
                        $tabla_contenido2= $tabla_contenido2.'<td style="width:20%; border: 0.3px solid black;  text-align: center;">'.$cat['Cantidad'].'</td></tr>';         
                    }  
                    $tabla_contenido2=$tabla_contenido2."</table></center><br><br><br><br>";
                    $html= $tablaDatos1.$tablaDatos.$tabla_contenido2;       
            }
    }
}



    //echo $html;

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('REQUISICIONES');
    $pdf->SetKeywords('Reporte ITAVU');
    //$pdf->SetHeaderData('pdf_logo.jpg', '40','', '');
    $pdf->SetHeaderData('pdf_logo.jpg', '40', 'DIRECCIÓN DE ADMINISTRACION Y FINANZAS', 'DEPARTAMENTO DE ADQUISICIONES');
    //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', '');
    //$link = "http://".$urlnueva[0]."/md_lista.php";
    
    //$img = file_get_contents('C:\pdz-server\htdocs\img\regreso.png');
    $img = file_get_contents('img/regreso.png');
    
    // set header and footer fonts
    $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', 9));
    //$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
    $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
    // set default monospaced font
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    // set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
   // $pdf->SetFooterData("Impreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($nitavu),array(0, 30, 0),array(0, 30, 20));

    $pdf->setPrintFooter(TRUE);
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
    $pdf->SetFont('helvetica', '', 9);
    // add a page
    $pdf->AddPage($orientacion, 'A4'); //en la tabla de reporte L o P
    //$html = $tabla;
    //echo $html; aqui escribe el contenido de la consulta
    $pdf->Image('@' . $img, 300, 0, '', '', '', $link, 'rigth', false, 0, '', false, false, 0, false, false, false);
    
    $pdf->writeHTML($html, true, false, true, false, '');

    // reset pointer to the last page
    $pdf->lastPage();
    //Close and output PDF document}
    echo $sql;
    //ob_end_clean();
  // $pdf->Output('reporte.pdf', 'I');
 }
else{echo "	<br><br>";echo "No tiene acceso a ".$id_aplicacion;}
?>