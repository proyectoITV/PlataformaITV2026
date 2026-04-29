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


$id_aplicacion = 'ap132';
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
$vuelta=0;
    //historia($nitavu, 'Veo el reporte de la lista de mandantes con los montos por pagar, y todos los saldos.');

    $tabla = "";
     //FILTRAR POR DIRECCION


        if ($idrep==4){
        
            if( (nitavu_dpto_nivel($nitavu)!='dir' and  $nivel==5) or titular(nitavu_dpto($nitavu))==$nitavu )
            {
              
    
                $sql="Select * from actividades_empleados INNER JOIN cat_gerarquia on actividades_empleados.IdDepartamento=cat_gerarquia.id 
                where( actividades_empleados.IdDepartamento=".nitavu_dpto($nitavu) ." or  actividades_empleados.IdDepartamento in (select id from cat_gerarquia 
                where dependencia in(".misdptos($nitavu).") ) ) and (cat_gerarquia.nombre like '%".$search ."%' or actividades_empleados.Actividad like '%".$search."%' or actividades_empleados.Tema like'%".$search."%')  and Estatus  in (3) 
                order by actividades_empleados.IdDepartamento, actividades_empleados.nitavu";
    
            }
            else if (nitavu_dpto_nivel($nitavu)=='dir' or  $nivel==5){       
                $sql="Select * from actividades_empleados INNER JOIN cat_gerarquia on actividades_empleados.IdDepartamento=cat_gerarquia.id 
                where( actividades_empleados.IdDepartamento=".nitavu_dpto($nitavu) ." or  actividades_empleados.IdDepartamento in (select id from cat_gerarquia 
                where dependencia in(".misdptos($nitavu).") ) ) and (cat_gerarquia.nombre like '%".$search ."%' or actividades_empleados.Actividad like '%".$search."%' or actividades_empleados.Tema like'%".$search."%')  and Estatus  in (3) 
                order by actividades_empleados.IdDepartamento, actividades_empleados.nitavu";
                //echo "soy direccion o tengo nivel 5";
    
            }
            else{
               // echo "soy un emplado normal1";
                $sql="Select * from  actividades_empleados where nitavu=".$nitavu." and IdDepartamento=".nitavu_dpto($nitavu) ." and Estatus  in (3)  ORDER BY IdActividad";
             
            } 
      }else
      {
        
        if( (nitavu_dpto_nivel($nitavu)!='dir' and  $nivel==5) or titular(nitavu_dpto($nitavu))==$nitavu )
        {
            $sql="Select * from actividades_empleados INNER JOIN cat_gerarquia on actividades_empleados.IdDepartamento=cat_gerarquia.id 
            where( actividades_empleados.IdDepartamento=".nitavu_dpto($nitavu) ." or  actividades_empleados.IdDepartamento in (select id from cat_gerarquia 
            where dependencia in(".misdptos($nitavu).") ) ) and (cat_gerarquia.nombre like '%".$search ."%' or actividades_empleados.Actividad like '%".$search."%' or actividades_empleados.Tema like'%".$search."%')  and Estatus not in (2,3) 
            order by actividades_empleados.IdDepartamento, actividades_empleados.nitavu";

        }
        else if (nitavu_dpto_nivel($nitavu)=='dir' or  $nivel==5){       
            $sql="Select * from actividades_empleados INNER JOIN cat_gerarquia on actividades_empleados.IdDepartamento=cat_gerarquia.id 
            where( actividades_empleados.IdDepartamento=".nitavu_dpto($nitavu) ." or  actividades_empleados.IdDepartamento in (select id from cat_gerarquia 
            where dependencia in(".misdptos($nitavu).") ) ) and (cat_gerarquia.nombre like '%".$search ."%' or actividades_empleados.Actividad like '%".$search."%' or actividades_empleados.Tema like'%".$search."%')  and Estatus not in (2,3) 
            order by actividades_empleados.IdDepartamento, actividades_empleados.nitavu";
            echo "soy direccion o tengo nivel 5";

        }
        else{           
            $sql="Select * from  actividades_empleados where nitavu=".$nitavu." and IdDepartamento=".nitavu_dpto($nitavu) ." and Estatus not in (2,3)  ORDER BY IdActividad";
        } 
      }
  
    //echo $sql ;
    $conexion->set_charset('utf8mb4');
    $rc = $conexion -> query($sql);
    

    $tabla = $tabla.'<br><br><table border="1" border-color="#BC2E22;" align = "center"  style="padding:3px; width:95%"> ';   
    $tabla = $tabla.'<tr  style="font-size:8pt; color:black;" bgcolor="#9d9d9d" >';   //bgcolor="#CB372A"
    $tabla = $tabla.'<th style="width:2%;"   ><b>NO</b></th>';
    // if ($idrep==1){
    //     $tabla = $tabla.'<th style="width:3%;" rowspan="2"><b>INF<br>GOB</b></th>';
    //     $tabla = $tabla.'<th style="width:3%;" rowspan="2"><b>PRIO</b></th>';
    // }   
    //$tabla = $tabla.'<th style="width:13%;" rowspan="2"><b>TEMA</b></th>';
    $tabla = $tabla.'<th style="width:30%;background: #9d9d9d;" ><b>ACTIVIDAD</b></th>';
    //$tabla = $tabla.'<th style="width:4%;" rowspan="2"><b>META</b></th>';
    $tabla = $tabla.'<th style="width:3%;" ><b>OK</b></th>';   
    $tabla = $tabla.'<th style="width:6%;" ><b>PROGRESO</b></th>'; 
    $tabla = $tabla.'<th  style="width:9%;"><b>FECHA</b></th>';
   // $tabla = $tabla.'<th  style="width:10%;"><b>ACTIVIDAD</b></th>';
    $tabla = $tabla.'<th style="width:20%;" ><b>DEPARTAMENTO</b></th>'; ;
    $tabla = $tabla.'<th style="width:20%;" ><b>RESPONSABLE</b></th>'; ;
    $tabla = $tabla.'<th style="width:14%;" ><b>OBSERVACIONES</b></th>';
    $tabla = $tabla.'</tr>';
    // $tabla = $tabla.'<tr    style="font-size:7pt; color:black;">';   //bgcolor="#CB372A" 
    // $tabla = $tabla.'<td style="width:7%;"><b>INICIO</b></td>';
    // $tabla = $tabla.'<td style="width:7%;"><b>TERMINO</b></td>';  
    // $tabla = $tabla.'<td style="width:6%;"><b>FECHA</b></td>';  
    // $tabla = $tabla.'<td style="width:4%;">%</td>';  
     
    // $tabla = $tabla.'</tr>';
   
    

    if ($rc->num_rows>0){
        
      
      
        while($r1 = $rc -> fetch_array()){
            $vuelta++;
            $tabla = $tabla."<tr style='font-size:7pt;'>";
                $tabla = $tabla.'<td style="width:2%;">'.$r1['IdActividad'].'</td>';
                // if ($idrep==1){
                //     $tabla = $tabla.'<td style="width:3%;">'.$r1['informedegobierno'].'</td>';
                //     $tabla = $tabla.'<td style="width:3%; color: '.colorbar_catjerarquia($r1['IdDireccion']).'">'.$r1['prioridad'].'</td>';
                // }
                //echo "<td style='font-size:13px; color: ".colorbar_catjerarquia($f['IdDireccion'])."'><b><center>".$f['prioridad']."</center></b></td>";
                 //$tabla = $tabla.'<td style="width:13%;text-align:justify;">'.$r1['Tema'].'</td>';
                 $tabla = $tabla.'<td style="width:30%;text-align:justify;">'.$r1['Actividad'].'</td>';
                 //$tabla = $tabla.'<td style="width:4%; color: '.colorbar_catjerarquia($r1['IdDireccion']).'">'.$r1['meta'].'</td>';
               
                if($r1['Estatus']==3 || $r1['Estatus']==1)
                {
                    $tabla = $tabla.'<td style="width:3%;"><img  style="margin-top:15px" src="img/check.jpg" width="15" height="8"> </td>';
                }else
                {
                    $tabla = $tabla.'<td style="width:3%;"> </td>';
                }
               
              
            $tabla = $tabla.'<td style="width:6%;vertical-align: middle;">'.$r1['Avance'].'%</td>';
                $tabla = $tabla.'<td style="width:9%; vertical-align: middle;">'.$r1['FechaInicio'].'</td>';              
               // $tabla = $tabla.'<td style="width:7%;">'.$r1['FechaTermino'].'</td>';
                //$tabla = $tabla.'<td style="width:6%;">'.$r1['FechaInicio'].'</td>';       
                // if ($idrep==1){
                //     $nombreDpto = DptoNombre($r1['IdDireccion']);
                // }else{
                    $nombreDpto = DptoNombre($r1['IdDepartamento']);
                //}    

                $encargado = titular($r1['IdDireccion']);
                $nombreencargado = nitavu_nombre($nitavu);
             

               $tabla = $tabla. "<td style='vertical-align: middle;'><center>".$nombreDpto."</center></td>"; 
               //se agrega nombre del personal
               $tabla = $tabla."<td style='vertical-align: middle;'><center>".$nombreencargado."</center></td>";
               // $ultimocomentario=UltimaObservacionDpto($f['IdActividad']);

                //$tabla = $tabla.'<td style="width:10%; text-align:justify;">'.$nombreDpto.'</td>';           
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
    
    if($midpto==1)
        {
        $titulo='ACTIVIDADES';
    }
    else{
        $titulo='ACTIVIDADES: '.strtoupper($nombreDpto);
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
      //  echo $html;

?>