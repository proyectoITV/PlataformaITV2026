<?php
require("config.php");
require_once('seguridad.php');
require_once('lib/funciones.php');
require_once('pdf/tcpdf.php');
require('lib/flor_funciones.php');
require('lib/yes_funciones.php');

$idrep=$_GET['idrep'];
$nitavu = $_GET['nitavu'];
$search= $_GET['ss'];

//idrep
//1- indicadores_dir actividades activas (0,1)
//2-indicadores_dir actividades archivadas(3)
//3-indicadores_depto actividades activas(0,1)
//4-indicadores_depto actividades archivadas(3)




$vuelta=0;
    //historia($nitavu, 'Veo el reporte de la lista de mandantes con los montos por pagar, y todos los saldos.');

    $tabla = "";
     //FILTRAR POR DIRECCION
    if ($idrep==1){
        // if(nitavu_dpto($nitavu)==1){
        //     $sql ="select * from actividades_indicadores";
        // }else{
        //     $sql ="select * from actividades_indicadores where IdDireccion = ".nitavu_dpto($nitavu)."";
        // }


        if(nitavu_dpto($nitavu)==1){
            //$sql ="select * from actividades_indicadores";
            $sql =" SELECT *, (CASE WHEN prioridad='A' THEN 0 WHEN prioridad='B' THEN 2 WHEN prioridad='M' THEN 1 END) as valorprioridad 
            FROM actividades_indicadores WHERE  Estatus!=3 and Estatus!=2  ORDER BY IdDireccion, valorprioridad";
        }else{
           // $sql ="select * from actividades_indicadores where IdDireccion = ".nitavu_dpto($nitavu)."";
            $sql =" SELECT *, (CASE WHEN prioridad='A' THEN 0 WHEN prioridad='B' THEN 2 WHEN prioridad='M' THEN 1 END) as valorprioridad 
            FROM actividades_indicadores WHERE Estatus!=3 and Estatus!=2 and IdDireccion = ". quienEsmiDireccion(nitavu_dpto($nitavu))."  ORDER BY IdDireccion, valorprioridad";
            //and Estatus!=3
            
        }
    } 

    if ($idrep==2){
        if(nitavu_dpto($nitavu)==1){
            //$sql ="select * from actividades_indicadores";
            $sql =" SELECT *, (CASE WHEN prioridad='A' THEN 0 WHEN prioridad='B' THEN 2 WHEN prioridad='M' THEN 1 END) as valorprioridad 
            FROM actividades_indicadores WHERE  Estatus=3  ORDER BY IdDireccion, valorprioridad";
        }else{
           // $sql ="select * from actividades_indicadores where IdDireccion = ".nitavu_dpto($nitavu)."";
            $sql =" SELECT *, (CASE WHEN prioridad='A' THEN 0 WHEN prioridad='B' THEN 2 WHEN prioridad='M' THEN 1 END) as valorprioridad 
            FROM actividades_indicadores WHERE Estatus=3 and IdDireccion = ". quienEsmiDireccion(nitavu_dpto($nitavu))."  ORDER BY IdDireccion, valorprioridad";
            //and IdDireccion = ".nitavu_dpto($nitavu)."  ORDER BY IdDireccion, valorprioridad";
            echo $sql;
            //and Estatus!=3
        }
    }


    if ($idrep==3){
        if (nitavu_dpto_nivel($nitavu)=='dir'){       
            $sql=" Select * from  actividades_dpto INNER JOIN cat_gerarquia on actividades_dpto.IdDepartamento=cat_gerarquia.id where actividades_dpto.IdDireccion=19 
            and (cat_gerarquia.nombre like '%".$search."%' or actividades_dpto.Actividad like '%".$search."%' or actividades_dpto.Tema like'%".$search."%')  and Estatus not in (2,3) ";    
            //$sql="Select * from  actividades_dpto where IdDireccion=".quienEsmiDireccion(nitavu_dpto($nitavu))." and Estatus not in (2,3) ";
            //$sql="Select * from  actividades_dpto where IdDireccion=".quienEsmiDireccion(nitavu_dpto($nitavu))." and Estatus not in (2,3) ORDER BY IdDepartamento";
        }else{
            $sql="Select * from  actividades_dpto where IdDepartamento=".nitavu_dpto($nitavu)." and Estatus not in (2,3)  ";
        } 
        $sql=$sql."ORDER BY IdDepartamento";
    } 
    if ($idrep==4){

        if (nitavu_dpto_nivel($nitavu)=='dir'){            
            $sql="Select * from  actividades_dpto INNER JOIN cat_gerarquia on actividades_dpto.IdDepartamento=cat_gerarquia.id where actividades_dpto.IdDireccion=19 
          and (cat_gerarquia.nombre like '%".$search."%' or actividades_dpto.Actividad like '%".$search."%' or actividades_dpto.Tema like'%".$search."%')  and Estatus=3 ";
           // $sql="Select * from  actividades_dpto where IdDireccion=".quienEsmiDireccion(nitavu_dpto($nitavu))." and Estatus=3 ";
      //  echo 'search es : '.$search   ;
        }else{
            $sql="Select * from  actividades_dpto where IdDepartamento=".nitavu_dpto($nitavu)." and Estatus=3  ";
        } 
        $sql=$sql."ORDER BY IdDepartamento";
    } 
    // if ($idrep==5){
    //     if (nitavu_dpto_nivel($nitavu)=='dir'){            
    //         $sql=" Select * from  actividades_empleados INNER JOIN cat_gerarquia on actividades_dpto.IdDepartamento=cat_gerarquia.id where actividades_dpto.IdDireccion=19 
    //         and (cat_gerarquia.nombre like '%".$search."%' or actividades_dpto.Actividad like '%".$search."%' or actividades_dpto.Tema like'%".$search."%')  and Estatus not in (2,3) ";
          
    //     }else{
    //         $sql="Select * from  actividades_empleados where nitavu=".$nitavu." and Estatus not in (2,3)  ORDER BY IdActividad";
          
    //     } 
    // }
        // if(nitavu_dpto($nitavu)==1){
        //     $sql ="select * from actividades_indicadores";
        // }else{
        //     $sql ="select * from actividades_indicadores where IdDireccion = ".nitavu_dpto($nitavu)."";
        // }
    //echo $sql ;
    $rc = $conexion -> query($sql);
    

    $tabla = $tabla.'<br><br><table border="1" border-color="#BC2E22" align = "center"  style="padding:3px;"> ';   
    $tabla = $tabla.'<tr  style="font-size:8pt; color:black;" >';   //bgcolor="#CB372A"
    $tabla = $tabla.'<th style="width:2%;  " rowspan="2"><b>NO</b></th>';
    if ($idrep==1){
        $tabla = $tabla.'<th style="width:3%;" rowspan="2"><b>INF<br>GOB</b></th>';
        $tabla = $tabla.'<th style="width:3%;" rowspan="2"><b>PRIO</b></th>';
    }   
    $tabla = $tabla.'<th style="width:13%;" rowspan="2"><b>TEMA</b></th>';
    $tabla = $tabla.'<th style="width:18%;" rowspan="2"><b>ACTIVIDAD</b></th>';
    $tabla = $tabla.'<th style="width:4%;" rowspan="2"><b>META</b></th>';
    $tabla = $tabla.'<th style="width:3%;" rowspan="2"><b>OK</b></th>';   
    $tabla = $tabla.'<th style="width:6%;" rowspan="2"><b>PROGRESO</b></th>'; 
    $tabla = $tabla.'<th colspan="2" style="width:14%;"><b>PROGRAMA</b></th>';
    $tabla = $tabla.'<th colspan="2" style="width:10%;"><b>AVANCE ACUM.</b></th>';
    $tabla = $tabla.'<th style="width:10%;" rowspan="2"><b>RESPONSABLE</b></th>'; ;
    $tabla = $tabla.'<th style="width:14%;" rowspan="2"><b>OBSERVACIONES</b></th>';
    $tabla = $tabla.'</tr>';
    $tabla = $tabla.'<tr    style="font-size:7pt; color:black;">';   //bgcolor="#CB372A" 
    $tabla = $tabla.'<td style="width:7%;"><b>INICIO</b></td>';
    $tabla = $tabla.'<td style="width:7%;"><b>TERMINO</b></td>';  
    $tabla = $tabla.'<td style="width:6%;"><b>FECHA</b></td>';  
    $tabla = $tabla.'<td style="width:4%;">%</td>';  
     
    $tabla = $tabla.'</tr>';
   
    

    if ($rc->num_rows>0){
        
      
      
        while($r1 = $rc -> fetch_array()){
            $vuelta++;
            $tabla = $tabla."<tr style='font-size:7pt;'>";

            if ($idrep==1 or $idrep==2){
                $tabla = $tabla.'<td style="width:2%; ">'.$vuelta.'</td>';
                }else
                {
                    $tabla = $tabla.'<td style="width:2%; color: '.colorbar_catjerarquia($r1['IdDepartamento']).'">'.$vuelta.'</td>';
                }

               
                if ($idrep==1){
                    $tabla = $tabla.'<td style="width:3%;">'.$r1['informedegobierno'].'</td>';
                    $tabla = $tabla.'<td style="width:3%; color: '.colorbar_catjerarquia($r1['IdDireccion']).'">'.$r1['prioridad'].'</td>';
                }
                //echo "<td style='font-size:13px; color: ".colorbar_catjerarquia($f['IdDireccion'])."'><b><center>".$f['prioridad']."</center></b></td>";
                 $tabla = $tabla.'<td style="width:13%;text-align:justify;">'.$r1['Tema'].'</td>';
                 $tabla = $tabla.'<td style="width:18%;text-align:justify;">'.$r1['Actividad'].'</td>';
                 if ($idrep==1 or $idrep==2){
                 $tabla = $tabla.'<td style="width:4%; color: '.colorbar_catjerarquia($r1['IdDireccion']).'">'.$r1['meta'].'</td>';
                 }else
                 {
                    $tabla = $tabla.'<td style="width:4%;">'.$r1['meta'].'</td>';
                 }
               
                if($r1['Estatus']==3 || $r1['Estatus']==1)
                {
                    $tabla = $tabla.'<td style="width:3%;"><img  style="margin-top:15px" src="img/check.jpg" width="15" height="8"> </td>';
                }else
                {
                    $tabla = $tabla.'<td style="width:3%;"> </td>';
                }
                // //style="vertical-align: middle;"
                // $tabla=$tabla.'<td > <center>                
                // <div class="progress progress-blue"><span style="width: '.$r1['Avance'].'%; background-color: '.colorbar_catjerarquia($r1['IdDireccion']).';"><b>'.$r1['Avance'].'%</b></span></div>                
                // </center></td>';



                if ($idrep==1 or $idrep==2){
                    $tabla=$tabla.'<td > <center>                
                    <div class="progress progress-blue"><span style="width: '.$r1['Avance'].'%; background-color: '.colorbar_catjerarquia($r1['IdDireccion']).';"><b>'.$r1['Avance'].'%</b></span></div>                
                    </center></td>';
                    }else
                    {
                        $tabla=$tabla.'<td > <center>                
                        <div class="progress progress-blue"><span style="width: '.$r1['Avance'].'%; background-color: '.colorbar_catjerarquia($r1['IdDepartamento']).';"><b>'.$r1['Avance'].'%</b></span></div>                
                        </center></td>';
                    }

//                $tabla = $tabla.'<td style="width:6%;">'.$r1['Avance'].'%</td>';
                $tabla = $tabla.'<td style="width:7%;">'.$r1['FechaInicio'].'</td>';              
                $tabla = $tabla.'<td style="width:7%;">'.$r1['FechaTermino'].'</td>';
                $tabla = $tabla.'<td style="width:6%;">'.$r1['FechaInicio'].'</td>';       
                 

                $encargado = titular($r1['IdDireccion']);
                $nombreencargado = nitavu_nombre($encargado);
                $tabla = $tabla.'<td  style="width:4%; ">'.$r1['Avance'].'</td>';
                $tabla = $tabla.'<td style="width:10%; text-align:justify;">'.DptoNombre($r1['IdDepartamento']).'</td>';           
                $tabla = $tabla.'<td  style="width:14%;text-align:justify; "><font size="7">'.$r1['Comentarios'].'</font></td>';  
            $tabla = $tabla."</tr>";       
        }
        $tabla = $tabla."</table>";
    }

    

    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('ACTIVIDADES');
    $pdf->SetKeywords('Reporte ITAVU');
    //$pdf->SetHeaderData('pdf_logo.jpg', '40','', '');
    $midpto = nitavu_dpto($nitavu);
    

    if ($idrep==1){
        $nombreDpto = DptoNombre($r1['IdDireccion']);
    }else{
        $nombreDpto = DptoNombre(nitavu_dpto($nitavu));
        //$nombreDpto = DptoNombre(nitavu_dpto($nitavu));
    }   

    if($midpto==1)
        {
        $titulo='ACTIVIDADES';
    }
    else{
        $titulo='ACTIVIDADES: '.$nombreDpto;//strtoupper($nombreDpto);
    }

    //--
       /*  $PDF_HEADER_TITLE="Titulo del PDF";
        $PDF_HEADER_STRING="SEgunda linea";
        $PDF_HEADER_STRING="tercera linea";
        $PDF_HEADER_LOGO="pdf_logo.jpg"; //Solo me funciona si esta dentro de la carpeta images de la libreria
        $PDF_HEADER_LOGO_WIDTH=50;
    
        $pdf->SetHeaderData($PDF_HEADER_LOGO, $PDF_HEADER_LOGO_WIDTH, $PDF_HEADER_TITLE, $PDF_HEADER_STRING);
     */
    //--

    $pdf->SetHeaderData('pdf_logo.jpg', '40', $titulo, "Impreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($nitavu));

    //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', '');
    //$link = "http://".$urlnueva[0]."/md_lista.php";
    $url="";
    $link = $url;
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
    $pdf->SetFooterData("Impreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($nitavu),array(0, 64, 0),array(0, 64, 128));

    $pdf->setPrintFooter(true);
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
    $pdf->AddPage('L', 'LEGAL'); //en la tabla de reporte L o P
    $html = $tabla;
    //echo $html; aqui escribe el contenido de la consulta
    $pdf->Image('@' . $img, 300, 0, '', '', '', $link, 'rigth', false, 0, '', false, false, 0, false, false, false);
    
    $pdf->writeHTML($html, true, false, true, false, '');

    // reset pointer to the last page
    $pdf->lastPage();
    //Close and output PDF document}
    ob_end_clean();
    $pdf->Output('reporte.pdf', 'I');
        //else ok
   //     echo $html;

?>