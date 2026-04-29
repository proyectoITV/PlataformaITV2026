<?php
require("config.php");
require_once('seguridad.php');
require_once('lib/funciones.php');
require_once('pdf/tcpdf.php');
require('lib/flor_funciones.php');
require('lib/yes_funciones.php');


$id_aplicacion ="viaticos"; //tabla aplicaciones
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
$orientacion='L';

if (sanpedro($id_aplicacion, $nitavu)==TRUE)
{
    // $iddir = $_POST['iddireccion'];    
     if (isset($_POST['idTipoReporte']) )
     {
         $idtiporep = $_POST['idTipoReporte'];
     }else
     {
        $idtiporep =0;
     }
    
     if (isset($_POST['idestatus']) )
     {
         $idestatus= $_POST['idestatus'];
     }
     if (isset($_POST['gastado']) )
     {
         $filtro= $_POST['gastado'];
       
     }else
     {
        $filtro='0';
     }

    if (isset($_POST['search']) )
    {
      $search = $_POST['search'];  
    }else
    {
       $search = "";  
    }
  
    if (isset($_POST['fechaI']) )
    {
        $fechaInicio = $_POST['fechaI'];
    }
    if (isset($_POST['fechaF']) )
    {
        $fechaFinal = $_POST['fechaF'];
    }

    if (isset($_POST['iddireccion']) and !empty($_POST['iddireccion']))
    {
     $iddireccion = $_POST['iddireccion'];  
      $nomdir=strtoupper(dpto_id($iddireccion));
    }else
    {
         $iddireccion = ""; 
         $nomdir="dir";
    }

    if (isset($_POST['iddepartamento']) and !empty($_POST['iddepartamento']))
    {
        $iddepartamento = $_POST['iddepartamento'];  
        $nomdpto=strtoupper(dpto_id($iddepartamento));
        $iddireccion=quienEsmiDireccion($iddepartamento);
        $nomdir=strtoupper(dpto_id($iddireccion));
    }else
    {
         $iddepartamento = "";  
         $nomdpto="";
    }

    if (isset($_POST['empleado']) and !empty($_POST['empleado']))
    {
     $empleado = $_POST['empleado'];  
     
    }else
    {
         $empleado = "";  
    }

    if($idtiporep==1){
        if( $idestatus=='1')
        {
            $status="GENERADO";
        }
        else if( $idestatus=='6')
        {
            $status="COMPROBADOS";
        }
        else if( $idestatus=='9')
        {
            $status="CANCELADOS";
        }
        else if( $idestatus=='11')
        {
            $status="NO COMPROBADOS";
        }
        $titulo='REPORTE DE VIATICOS '.$status;
    }else if($idtiporep==2){
        $titulo='REPORTE DE GASTADO EN VIATICOS';
    }else
    {
        $titulo='REPORTE';
    }
 
   

        $tablaDatos1='<BR><BR><table style="width:100%;font-size: 10px;">';
        $tablaDatos1=$tablaDatos1."<tr>"; 
        $tablaDatos1=$tablaDatos1.'<td  colspan="5" style="text-align: center; font-size: 13px;"><b>' .$titulo.'</b></td>';
        $tablaDatos1=$tablaDatos1."</tr>";

        $tablaDatos1=$tablaDatos1.'<tr>';   
        $tablaDatos1=$tablaDatos1.'<td  colspan="5" style="text-align: center;"></td>';
        $tablaDatos1=$tablaDatos1.'</tr>'; 

        if($filtro==1)
        {
        $tablaDatos1=$tablaDatos1.'<tr>';   
        $tablaDatos1=$tablaDatos1.'<td><b>DIRECCION</b></td>';
        $tablaDatos1=$tablaDatos1.'<td  colspan="3">'.$nomdir.'</td>';
        $tablaDatos1=$tablaDatos1.'<td></td>';
        $tablaDatos1=$tablaDatos1.'<td></td>';
        $tablaDatos1=$tablaDatos1.'<td></td>';        
        $tablaDatos1=$tablaDatos1.'</tr>';
        }
        else   if($filtro==2)
        {
            $tablaDatos1=$tablaDatos1.'<tr>';   
            $tablaDatos1=$tablaDatos1.'<td><b>DIRECCION</b></td>';
            $tablaDatos1=$tablaDatos1.'<td  colspan="3">'.$nomdir.'</td>';
            $tablaDatos1=$tablaDatos1.'<td></td>';
            $tablaDatos1=$tablaDatos1.'<td></td>';
            $tablaDatos1=$tablaDatos1.'<td></td>';        
            $tablaDatos1=$tablaDatos1.'</tr>';

            $tablaDatos1=$tablaDatos1.'<tr>';   
            $tablaDatos1=$tablaDatos1.'<td><b>DEPARTAMENTO</b></td>';
            $tablaDatos1=$tablaDatos1.'<td colspan="3">'.$nomdpto.'</td>';                      
            $tablaDatos1=$tablaDatos1.'</tr>'; 


        }else   if($filtro==3)
        {
           
          
            $tablaDatos1=$tablaDatos1.'<tr>';   
            $tablaDatos1=$tablaDatos1.'<td><b>DIRECCION</b></td>';
            $tablaDatos1=$tablaDatos1.'<td  colspan="3">'.strtoupper(dpto_id(quienEsmiDireccion(nitavu_dpto($empleado)))).'</td>';
            // $tablaDatos1=$tablaDatos1.'<td></td>';
            // $tablaDatos1=$tablaDatos1.'<td></td>';
            // $tablaDatos1=$tablaDatos1.'<td></td>';        
            $tablaDatos1=$tablaDatos1.'</tr>';

            $tablaDatos1=$tablaDatos1.'<tr>';   
            $tablaDatos1=$tablaDatos1.'<td><b>DEPARTAMENTO</b></td>';
            $tablaDatos1=$tablaDatos1.'<td colspan="3">'.strtoupper(dpto_id(nitavu_dpto($empleado))).'</td>';                      
            $tablaDatos1=$tablaDatos1.'</tr>'; 


            $tablaDatos1=$tablaDatos1.'<tr>';   
            $tablaDatos1=$tablaDatos1.'<td><b>EMPLEADO</b></td>';
            $tablaDatos1=$tablaDatos1.'<td  colspan="3">'.strtoupper(nitavu_nombre($empleado)).'</td>';
            // $tablaDatos1=$tablaDatos1.'<td></td>';
            // $tablaDatos1=$tablaDatos1.'<td></td>';
            // $tablaDatos1=$tablaDatos1.'<td></td>';        
            $tablaDatos1=$tablaDatos1.'</tr>';
        // } 
        }
       
        

        $tablaDatos1=$tablaDatos1.'<tr>';   
        $tablaDatos1=$tablaDatos1.'<td><b>RANGO DE FECHAS:</b></td>';  
        $tablaDatos1=$tablaDatos1.'<td>'.date_format( date_create($fechaInicio), 'd/m/Y').'</td>';  
        $tablaDatos1=$tablaDatos1.'<td><b>A:</b></td>';  
        $tablaDatos1=$tablaDatos1.'<td>'.date_format( date_create($fechaFinal), 'd/m/Y').'</td>';    
        $tablaDatos1=$tablaDatos1.'<td></td>';         
        $tablaDatos1=$tablaDatos1.'</tr>';   
 
        $tablaDatos1=$tablaDatos1.'</table><br><br>'; 

    if($idtiporep==0)
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
            
        if($idtiporep==1)
        {  $sql="SELECT
            a.IdViatico,
            a.NEmpleado,
            (select nombre from empleados where nitavu= a.NEmpleado) as Empleado,
            IFNULL((select CONCAT(Origen,'-',Destino) from viaticosrecorridos WHERE IdViatico = a.IdViatico limit 1),'Sin Definir') as Ruta,
            a.SalidaFecha,
            a.RegresoFecha,
            a.estatus,
            e.dpto,
            cg.IdDireccion,
            cg.nombre as NombreDpto,
            cgg.nombre as NombreDireccion,
            a.CapturaFecha
            
            FROM
            viaticos a inner join empleados as e on e.nitavu=a.NEmpleado
            inner join cat_gerarquia as cg on cg.id=e.dpto
            inner join cat_gerarquia as cgg on cgg.id=cg.IdDireccion
             WHERE Activa=1 ";
            if($idestatus==6 or $idestatus==9 OR $idestatus==11)
            {
                $sql=$sql." and estatus=".$idestatus;
            }  
                if( $iddepartamento != "" )
            {
                $sql=$sql." and  e.dpto='".$iddepartamento."'";
            }
            else if($iddireccion!='') {
                $sql=$sql." and  cg.IdDireccion='".$iddireccion."'";
            }
            else if($empleado!='')
            {
                $sql=$sql." and   a.NEmpleado='".$empleado."'";
            }
            $sql=$sql." ORDER BY            NEmpleado,            CapturaFecha,  a.estatus desc";
            
          
//echo $sql;

            $tabla_contenido2='<br><br><center><table style="width:100%; border: 0.3px solid black;">                            
            <tr style=" text-align: center; background-color:#BDBDBD;  font-weight:bold; border: 0.3px solid black; font-size: 10px;">
                <td  style="width:5%; text-align: center; background-color:#BDBDBD;border: 0.3px solid black; ">#</td>				
                <td  style="width:7%;vertical-align:middle; border: 0.3px solid black;">VIATICO</td>
                <td  style="width:8%;vertical-align:middle; border: 0.3px solid black;">FECHA CREA</td>
                <td  style="width:15%;vertical-align:middle; border: 0.3px solid black;">EMPLEADO</td>
                <td  style="width:15%;vertical-align:middle; border: 0.3px solid black;">DEPARTAMENTO</td>
                <td  style="width:18%;vertical-align:middle;border: 0.3px solid black;">RUTA</td>
                <td  style="width:20%;vertical-align:middle; border: 0.3px solid black;">FECHAS</td>
                <td  style="width:12%;vertical-align:middle; border: 0.3px solid black;">ESTATUS</td>
            </tr>';
         

            $rc= $conexion -> query($sql);               
            $cont=0;                            
           while($cat = $rc -> fetch_array())
                {
                    $cont=$cont+1;
                     $tabla_contenido2= $tabla_contenido2.'<tr style="text-align: center; border: 0.3px solid black; font-size:10px;"><td style="width:5%;  vertical-align:middle; border: 0.3px solid black;">'.$cont.'</td>';
                     $tabla_contenido2= $tabla_contenido2.'<td style=" width:7%; vertical-align:middle; border: 0.3px solid black;">'.$cat['IdViatico'].'</td>';
                     $tabla_contenido2= $tabla_contenido2.'<td style=" width:8%; vertical-align:middle; border: 0.3px solid black;">'.$cat['CapturaFecha'].'</td>';
                     $tabla_contenido2= $tabla_contenido2.'<td style=" width:15%; vertical-align:middle; border: 0.3px solid black;">'.$cat['Empleado'].'</td>';
                     $tabla_contenido2= $tabla_contenido2.'<td style=" width:15%; vertical-align:middle; border: 0.3px solid black;">'.$cat['NombreDpto'].'</td>';
                     $tabla_contenido2= $tabla_contenido2.'<td style=" width:18%; vertical-align:middle; border: 0.3px solid black;">'.$cat['Ruta'].'</td>';
                  
                    if ($cat['SalidaFecha']=='0000-00-00'){
                        $tabla_contenido2= $tabla_contenido2.'<td style=" width:20%; vertical-align:middle; border: 0.3px solid black;">Sin definir</td>';
                    } else {
                     
                        $tabla_contenido2= $tabla_contenido2.'<td style=" width:20%; vertical-align:middle; border: 0.3px solid black;">Salida:'.date_format(date_create($cat['SalidaFecha']), 'd-M-y').' - '.date_format(date_create($cat['RegresoFecha']), 'd-M-y').'</td>';
                   
                    }
                    if ($cat['estatus']=='1'){
                      
                        $status='EN TRAMITE';
                    } else if ($cat['estatus']=='2'){
                        $status='VOBO VIATICOS';
                    } else if ($cat['estatus']=='3'){
                        $status='IMPRESO';
                    }else if ($cat['estatus']=='4'){
                        $status='FIRMAS';
                    }else if ($cat['estatus']=='5'){
                        $status='PAGAR VIATICOS';
                    }else if ($cat['estatus']=='6'){
                        $status='COMPROBADO';
                    }else if ($cat['estatus']=='7'){
                        $status='VOBO COMISARIA';
                    }else if ($cat['estatus']=='8'){
                        $status='SIN PRESUPUESTO';
                    }else if ($cat['estatus']=='9'){
                        $status='CANCELADO';
                     }
                     else if ($cat['estatus']=='11'){
                        $status='NO COMPROBADO';
                     }
                     //else if ($cat['estatus']=='10'){
                    //     echo "<td style=' color: #f50202; font-weight: bold;'> Rechazado</td>";
                    // }
        
                     $tabla_contenido2= $tabla_contenido2.'<td style=" width:12%; vertical-align:middle; border: 0.3px solid black;">'. $status.'</td>';
                     $tabla_contenido2=$tabla_contenido2."</tr>";
            }  

        $tabla_contenido2=$tabla_contenido2."</table></center>";
            }
 
        
        else if($idtiporep==2)
        {
            $sql="SELECT
            a.IdViatico,
            a.NEmpleado,
            (select nombre from empleados where nitavu= a.NEmpleado) as Empleado,
            IFNULL((select CONCAT(Origen,'-',Destino) from viaticosrecorridos WHERE IdViatico = a.IdViatico limit 1),'Sin Definir') as Ruta,
            a.SalidaFecha,
            a.RegresoFecha,
            a.estatus,
            e.dpto,
            cg.IdDireccion,
            cg.nombre as NombreDpto,
            cgg.nombre as NombreDireccion,
            a.CapturaFecha,
            -- (select SubTotal from viaticosgastosfull_resumen  as vgf WHERE vgf.IdViatico=a.IdViatico and vgf.Tipo='ALIMENTACION') as TotalAlimentacion,
            -- (select SubTotal from viaticosgastosfull_resumen  as vgf WHERE vgf.IdViatico=a.IdViatico and vgf.Tipo='HOSPEDAJE') as TotalHospedaje,
            -- (select SubTotal from viaticosgastosfull_resumen  as vgf WHERE vgf.IdViatico=a.IdViatico and vgf.Tipo='COMBUSTIBLE') as TotalCombustible,
            -- (select sum(SubTotal) from viaticosgastosfull_resumen  as vgf WHERE vgf.IdViatico=a.IdViatico) as Total,
            -- (select sum(GastoComprobado) from viaticoscomprobaciones as vc WHERE vc.IdViatico=a.IdViatico) as Comprobado,
            -- (select sum(Faltante) from viaticoscomprobaciones as vc WHERE vc.IdViatico=a.IdViatico) as Faltante

            (select IFNULL(SubTotal,0) from viaticosgastosfull_resumen as vgf WHERE vgf.IdViatico=a.IdViatico and vgf.Tipo='ALIMENTACION') as TotalAlimentacion, 
(select IFNULL (SubTotal,0) from viaticosgastosfull_resumen as vgf WHERE vgf.IdViatico=a.IdViatico and vgf.Tipo='HOSPEDAJE') as TotalHospedaje,
(select IFNULL (SubTotal,0) from viaticosgastosfull_resumen as vgf WHERE vgf.IdViatico=a.IdViatico and vgf.Tipo='COMBUSTIBLE') as TotalCombustible,
(select IFNULL (sum(SubTotal),0) from viaticosgastosfull_resumen as vgf WHERE vgf.IdViatico=a.IdViatico) as Total,
(select IFNULL (sum(CantidadComprobada),0) from viaticoscomprobacion as vc WHERE vc.IdViatico=a.IdViatico) as Comprobado,
(select IFNULL (sum(SubTotal),0) from viaticosgastosfull_resumen as vgf WHERE vgf.IdViatico=a.IdViatico) -(select IFNULL (sum(CantidadComprobada),0) from viaticoscomprobacion as vc WHERE vc.IdViatico=a.IdViatico) as Faltante
            FROM
            viaticos a inner join empleados as e on e.nitavu=a.NEmpleado
            inner join cat_gerarquia as cg on cg.id=e.dpto
            inner join cat_gerarquia as cgg on cgg.id=cg.IdDireccion
            WHERE -- Activa=0 and 
            ( estatus=5 or estatus=6 or estatus=7 )";
            if( $iddepartamento != "" )
            {
                $sql=$sql." and  e.dpto='".$iddepartamento."'";
            }
            else if($iddireccion!='') {
                $sql=$sql." and  cg.IdDireccion='".$iddireccion."'";
            }
            else if($empleado!='')
            {
                $sql=$sql." and   a.NEmpleado='".$empleado."'";
            }
            $sql=$sql." ORDER BY            NEmpleado,            CapturaFecha,  a.estatus desc";
            

        echo $sql;

                $tabla_contenido2='<br><br><center><table style="width:100%; border: 0.3px solid black; font-size: 10px;">                            
                <tr style=" text-align: center; background-color:#BDBDBD;  font-weight:bold; border: 0.3px solid black;">
                    <td  style="width:5%; text-align: center; background-color:#BDBDBD;border: 0.3px solid black; ">#</td>				
                    <td  style="width:6%;vertical-align:middle; border: 0.3px solid black;">VIATICO</td>
                   
                    <td  style="width:14%;vertical-align:middle; border: 0.3px solid black;">EMPLEADO</td>
                    <td  style="width:12%;vertical-align:middle; border: 0.3px solid black;">DEPARTAMENTO</td>
                    <td  style="width:17%;vertical-align:middle;border: 0.3px solid black;">RUTA</td>
                    <td  style="width:14%;vertical-align:middle; border: 0.3px solid black;">FECHAS</td>
                    <td  style="width:7%;vertical-align:middle; border: 0.3px solid black;">TOTAL</td>     
                    <td  style="width:7%;vertical-align:middle; border: 0.3px solid black;">COMPROBADO</td>           
                    <td  style="width:7%;vertical-align:middle; border: 0.3px solid black;">FALTANTE</td>
                    <td  style="width:11%;vertical-align:middle; border: 0.3px solid black;">ESTATUS</td>
                </tr>';
             
 // <td  style="width:10%;vertical-align:middle; border: 0.3px solid black;">FECHA CREA</td>
                $rc= $conexion -> query($sql);               
                $cont=0;                            
               while($cat = $rc -> fetch_array())
                    {
                        $cont=$cont+1;
                         $tabla_contenido2= $tabla_contenido2.'<tr style="text-align: center; border: 0.3px solid black;"><td style="width:5%;  vertical-align:middle; border: 0.3px solid black;">'.$cont.'</td>';
                         $tabla_contenido2= $tabla_contenido2.'<td style=" width:6%; vertical-align:middle; border: 0.3px solid black;">'.$cat['IdViatico'].'</td>';
                        //  $tabla_contenido2= $tabla_contenido2.'<td style=" width:10%; vertical-align:middle; border: 0.3px solid black;">'.$cat['CapturaFecha'].'</td>';
                         $tabla_contenido2= $tabla_contenido2.'<td style=" width:14%; vertical-align:middle; border: 0.3px solid black;">'.$cat['Empleado'].'</td>';
                         $tabla_contenido2= $tabla_contenido2.'<td style=" width:12%; vertical-align:middle; border: 0.3px solid black;">'.$cat['NombreDpto'].'</td>';
                         $tabla_contenido2= $tabla_contenido2.'<td style=" width:17%; vertical-align:middle; border: 0.3px solid black;">'.$cat['Ruta'].'</td>';
                      
                        if ($cat['SalidaFecha']=='0000-00-00'){
                            $tabla_contenido2= $tabla_contenido2.'<td style=" width:14%; vertical-align:middle; border: 0.3px solid black;">Sin definir</td>';
                        } else {
                         
                            $tabla_contenido2= $tabla_contenido2.'<td style=" width:14%; vertical-align:middle; border: 0.3px solid black;">'.date_format(date_create($cat['SalidaFecha']), 'd-M-y').' - '.date_format(date_create($cat['RegresoFecha']), 'd-M-y').'</td>';
                       
                        }
                         $tabla_contenido2= $tabla_contenido2.'<td style=" width:7%; vertical-align:middle; border: 0.3px solid black;">$'.$cat['Total'].'</td>';
                         $tabla_contenido2= $tabla_contenido2.'<td style=" width:7%; vertical-align:middle; border: 0.3px solid black;">$'.$cat['Comprobado'].'</td>';
                         $tabla_contenido2= $tabla_contenido2.'<td style=" vertical-align:middle; border: 0.3px solid black;">$'.$cat['Faltante'].'</td>';
                         if($cat['estatus']==5)
                         {
                            $esatus='NO COMPROBADO';
                            $tabla_contenido2= $tabla_contenido2.'<td style=" width:11%; vertical-align:middle; border: 0.3px solid black; color:red">'.$esatus.'</td>';
                         }else{
                            $esatus='COMPROBADO';
                            $tabla_contenido2= $tabla_contenido2.'<td style=" width:11%; vertical-align:middle; border: 0.3px solid black; color:black">'.$esatus.'</td>';
                         }
                       
                         $tabla_contenido2=$tabla_contenido2."</tr>";
                }  

            $tabla_contenido2=$tabla_contenido2."</table></center>";
            }
            $html= $tablaDatos1.$tabla_contenido2;

 }



   // echo $html;

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('Viaticos');
    $pdf->SetKeywords('Reporte ITAVU');
    //$pdf->SetHeaderData('pdf_logo.jpg', '40','', '');
    $pdf->SetHeaderData('pdf_logo.jpg', '40', 'DIRECCIÓN DE ADMINISTRACION Y FINANZAS', 'DEPARTAMENTO DE VIATICOS');
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
   // $html = $tabla;
    //echo $html; //aqui escribe el contenido de la consulta
  //  $pdf->Image('@' . $img, 300, 0, '', '', '', $link, 'rigth', false, 0, '', false, false, 0, false, false, false);
    
    $pdf->writeHTML($html, true, false, true, false, '');

    // reset pointer to the last page
    $pdf->lastPage();
    //Close and output PDF document}
    ob_end_clean();
    $pdf->Output('reporte.pdf', 'I');
 }
else{echo "	<br><br>";echo "No tiene acceso a ".$id_aplicacion;}
?>