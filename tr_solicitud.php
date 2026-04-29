<?php
require("config.php");
//require_once('/seguridad.php');
require_once('lib/funciones.php');
require_once('pdf/tcpdf.php');
require('lib/flor_funciones.php');


    $idTramite=$_GET['folio'];
    $tabla = "";
   

    $tabla = $tabla.'<table align="center"><tr bgcolor="#6E6E6E"><td style="color:#FFFFFF"><b>programa</b></td></tr></table>'; 
    $tabla = $tabla.'<table align="center"><tr><td style="font-size:16px;"><b>SUELO LEGAL</b></td></tr></table>';
    
    $tabla = $tabla.'<table align="center"><tr bgcolor="#6E6E6E"><td STYLE="COLOR:#FFFFFF"><b>FOLIO SOLICITUD </b></td><td STYLE="COLOR:#FFFFFF"><b>FECHA SOLICITUD</b></td></tr></table>';
    $tabla = $tabla.'<table align="center"><tr><td>'.TramiteFolioVivienda($idTramite).' </td><td>'.fecha_larga(TramiteFechaCaptura($idTramite)).'</td></tr></table>';
    
    $tabla = $tabla.'<br><br>';
  
    $tabla = $tabla.'<table>';
        $tabla = $tabla.'<tr>';
            $tabla = $tabla.'<td  valign="middle" align="center" bgcolor="#6E6E6E" width="100px;" style="color:#FFFFFF; font-size:10px; vertical-align: middle;"><b>DATOS DEL SOLICITANTE</b></td>';
            $tabla = $tabla.'<td width="555px;" bgcolor="#6E6E6E">
            
                <table>
                    <tr>
                        <td bgcolor="#6E6E6E" align="center" style="color:#FFFFFF;"><b>GENERALES</b></td>
                    </tr>
                    <tr>
                        <td bgcolor="#FFFFFF" style="font-size:10px;">
                            NOMBRE:<b>'.TramiteDato($idTramite, 1, 0).' '.TramiteDato($idTramite, 2, 0).' '.TramiteDato($idTramite, 3, 0).' </b>           SEXO: <b>'.TramiteDatoExtendida($idTramite,4,0).'</b>             NACIONALIDAD:<b>'.TramiteDatoExtendida($idTramite,6,0).'</b> <BR>
                            ESTADO CIVIL: <b>'.TramiteDatoExtendida($idTramite,36,0).'</b>       LUGAR DE NACIMIENTO: <b>'.TramiteDatoExtendida($idTramite,40,0).'</b>       CURP: <b>'.TramiteDatoExtendida($idTramite,0,0).'</b><BR>
                            RFC: <b>'.TramiteDatoExtendida($idTramite,43,0).'</b>       DIRECCIÓN: <b>'.TramiteDatoExtendida($idTramite,21,0).'</b>       C.P.: <b>'.TramiteDatoExtendida($idTramite,25,0).'</b><BR>
                            FECHA DE NACIMIENTO: <b>'.TramiteDatoExtendida($idTramite,5,0).'</b> COLONIA: <b>'.TramiteDatoExtendida($idTramite,62,0).'</b> TEL: <b>'.TramiteDatoExtendida($idTramite,18,0).'</b><BR>
                            MUNICIPIO:<b>'.TramiteDatoExtendida($idTramite,60,0).'</b>  ESTADO: <b>'.TramiteDatoExtendida($idTramite,95,0).'</b>        JEFE DE FAMILIA: <b>'.TramiteDatoExtendida($idTramite,41,0).'</b>  FORM. ACADEMICA: <b>'.TramiteDatoExtendida($idTramite,46,0).'</b> 
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#6E6E6E" align="center" style="color:#FFFFFF;"><b>LABORALES</b></td>
                    </tr>
                    <tr>
                        <td bgcolor="#FFFFFF" style="font-size:10px;">
                            TRABAJA: <b>'.TramiteDatoExtendida($idTramite,47,0).'</b>  OCUPACIÓN: <b>'.TramiteDatoExtendida($idTramite,48,0).'</b>  EMPRESA: <b>'.TramiteDatoExtendida($idTramite,49,0).'</b>  TEL: <b>'.TramiteDatoExtendida($idTramite,56,0).'</b> <BR>
                            DIRRECCIÓN: <b>'.TramiteDatoExtendida($idTramite,51,0).'</b>  TIPO DE TRABAJO: <b>'.TramiteDatoExtendida($idTramite,52,0).'</b>  ING. MENSUAL: <b>$ '.number_format(TramiteDatoExtendida($idTramite,55,0),2,'.',',').'</b> <BR>
                        </td>
                    </tr>
                </table>
    
            </td>';
               
        $tabla = $tabla."</tr>";
        $tabla = $tabla.'<tr>';

        //transform: rotate(-90deg); 
            $tabla = $tabla.'<td valign="middle" align="center"  bgcolor="#6E6E6E" width="100px;" style="color:#FFFFFF; font-size:10px; vertical-align: middle;" ><b>DATOS DEL CONYUGE</b></td>';
            
            $tabla = $tabla.'<td bgcolor="#6E6E6E" width="555px;">
            
                <table>
                    <tr>
                        <td bgcolor="#6E6E6E" align="center" style="color:#FFFFFF;"><b>GENERALES</b></td>
                    </tr>
                    <tr>
                        <td bgcolor="#FFFFFF" style="font-size:10px;">
                            NOMBRE:<b>'.TramiteDato($idTramite, 1, 3).' '.TramiteDato($idTramite, 2, 3).' '.TramiteDato($idTramite, 3, 3).' </b>     FECHA DE NACIMIENTO: <b>'.TramiteDatoExtendida($idTramite,5,3).'</b> <BR>
                            LUGAR DE NACIMIENTO: <b>'.TramiteDatoExtendida($idTramite,40,3).'</b>   NACIONALIDAD: <b>'.TramiteDatoExtendida($idTramite,6,3).'</b><BR>
                            CURP:<b>'.TramiteDatoExtendida($idTramite,0,3).'</b> RFC: <b>'.TramiteDatoExtendida($idTramite,43,3).'</b> SEXO: <b>'.TramiteDatoExtendida($idTramite,4,3).'</b>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#6E6E6E" align="center" style="color:#FFFFFF;"><b>LABORALES</b></td>
                    </tr>
                    <tr>
                        <td bgcolor="#FFFFFF" style="font-size:10px;">
                            TRABAJA: <b>'.TramiteDatoExtendida($idTramite,47,3).'</b>  OCUPACIÓN: <b>'.TramiteDatoExtendida($idTramite,48,3).'</b>  EMPRESA: <b>'.TramiteDatoExtendida($idTramite,49,3).'</b>  TEL: <b>'.TramiteDatoExtendida($idTramite,56,3).'</b> <BR>
                            DIRRECCIÓN: <b>'.TramiteDatoExtendida($idTramite,51,3).'</b>  TIPO DE TRABAJO: <b>'.TramiteDatoExtendida($idTramite,52,3).'</b>  ING. MENSUAL: <b>$ '.number_format(TramiteDatoExtendida($idTramite,55,3),2,'.',',').'</b> <BR>
                        </td>
                    </tr>
                </table>
            </td>';
            
    $tabla = $tabla."</tr>";
    $tabla = $tabla."</table>";
   
    $tabla = $tabla.'<br><br>';

    $tabla = $tabla.'
    <table >
    <tr>
        <td >
            <table>
                <tr>
                    <td bgcolor="#6E6E6E" STYLE="COLOR:#FFFFFF">  <B>REFERENCIAS PERSONALES</B></td>
                    <td></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td border="1" >
            <table>
                <tr>    
                    <td>NOMBRE: <b>'.TramiteDato($idTramite, 1, 1).' '.TramiteDato($idTramite, 2, 1).' '.TramiteDato($idTramite, 3, 1).' </b> </td>
                    <td>DIRECCIÓN: <b> '.TramiteDato($idTramite, 21, 1).' No.'.TramiteDato($idTramite, 24, 1).' '.TramiteDato($idTramite, 22, 1).' </b></td>
                </tr>
                <tr>
                    <td>NOMBRE: <b>'.TramiteDato($idTramite, 1, 2).' '.TramiteDato($idTramite, 2, 2).' '.TramiteDato($idTramite, 3, 2).' </b> </td>
                    <td>DIRECCIÓN: <b>'.TramiteDato($idTramite, 21, 2).' No.'.TramiteDato($idTramite, 24, 2).' '.TramiteDato($idTramite, 22, 2).' </b></td>
                </tr>
            </table>
        </td>
    </tr>
    </table>';


    $tabla = $tabla.'<br><br>';

    $totalGasto = TramiteDato($idTramite, 78, 0) + TramiteDato($idTramite, 79, 0) + TramiteDato($idTramite, 80, 0) +TramiteDato($idTramite, 81, 0) +TramiteDato($idTramite, 82, 0) +TramiteDato($idTramite, 83, 0)+TramiteDato($idTramite, 84, 0);
    $tabla = $tabla.'
    <table >
    <tr>
        <td >
            <table>
                <tr>
                    <td bgcolor="#6E6E6E" STYLE="COLOR:#FFFFFF"> <B> INFORMACIÓN ECONÓMICA FAMILIAR </B></td>
                    <td></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td border="1" >
            <table>
                <tr style="font-size:9px;">    
                    <td></td>
                    <td> Alimento </td>
                    <td>Agua</td>
                    <td>Luz</td>
                    <td>Teléfono</td>
                    <td>Transporte</td>
                    <td>Educación</td>
                    <td>Otros</td>
                    <td><b>TOTAL</b></td>
                    
                </tr>
                <tr>
                    <td><b>EGRESOS</b></td>
                    <td>$'.number_format(TramiteDato($idTramite, 78, 0),2,'.',',').'  </td>
                    <td>$'.number_format(TramiteDato($idTramite, 79, 0),2,'.',',').' </td>
                    <td>$'.number_format(TramiteDato($idTramite, 80, 0),2,'.',',').' </td>
                    <td>$'.number_format(TramiteDato($idTramite, 81, 0),2,'.',',').' </td>
                    <td>$'.number_format(TramiteDato($idTramite, 82, 0),2,'.',',').' </td>
                    <td>$'.number_format(TramiteDato($idTramite, 83, 0),2,'.',',').' </td>
                    <td>$'.number_format(TramiteDato($idTramite, 84, 0),2,'.',',').' </td>
                    <td><b>$'.number_format($totalGasto,2,'.',',').'</b></td>
                </tr>
                <tr>
                    <td><b>INGRESOS</b></td>
                    <td> </td> 
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><b>$'.number_format(TramiteDato($idTramite, 77, 0),2,'.',',').'</b></td>
                </tr>
            </table>
        </td>
    </tr>
    </table>';

    $tabla = $tabla.'<BR><BR>';

    $sql1 = "SELECT Clase FROM tramitesinformacion WHERE IdTramite=".$idTramite." and Clase in (4,5,6,7,8,9,10,11,12,13) GROUP BY Clase";
    $r1 = $conexion -> query($sql1);

    if ($r1 -> num_rows >0){

        $tabla = $tabla.'
        <table >
        <tr>
            <td bgcolor="#6E6E6E" align="center" STYLE="COLOR:#FFFFFF">
                <B>PERSONAS DEPENDIENTES DEL SOLICITANTE</B>
            </td>
        </tr>
        <tr>
            <td border="1">
                <table align="center" style="font-size:10px;" >
                    <tr>    
                        <td width="200px;">NOMBRE </td>
                        <td width="100px;">parentesco </td>
                        <td width="80px;">FECHA NAC. </td>
                        <td width="60px;">SEXO </td>
                        <td width="70px;">INGRESO </td>
                        <td width="130px;">CURP </td>
                    </tr>';
            
        while($f1 = $r1 -> fetch_array()){

            $sql = "SELECT * FROM tramitesinformacion WHERE IdTramite=".$idTramite." and Clase = ".$f1['Clase']."";
            //echo $sql;
            $r = $conexion -> query($sql);

            while($f = $r -> fetch_array()){

                if($f['IdRequisito']==0){
                    $curpDep= $f['Dato'];
                }
                
                if($f['IdRequisito']==5){
                    $fechaNacDep = $f['Dato'];
                }
                if($f['IdRequisito']==4){
                    $sexoDep = $f['Dato'];
                    if($sexoDep == 'M'){
                        $sexoDep  = 'MUJER';
                    }else{
                        $sexoDep  = 'HOMBRE';
                    }
                }
                if($f['IdRequisito']==3){
                    $amaternoDep = $f['Dato'];
                }
                if($f['IdRequisito']==1){
                    $nombreDep = $f['Dato'];
                }
                if($f['IdRequisito']==2){
                    $apaternoDep = $f['Dato'];
                }
                if($f['IdRequisito']==55){
                    $ingresoDep = $f['Dato'];
                }
                if($f['IdRequisito']==96){
                    $parentescoDep = $f['Dato'];
                }
                
            }

            $tabla = $tabla.' <tr style="font-size:10px;">
                <td align="left"> '.$nombreDep.' '.$apaternoDep.' '.$amaternoDep.' </td>
                <td > '.$parentescoDep.'  </td>
                <td > '.$fechaNacDep.' </td>
                <td > '.$sexoDep.' </td>
                <td > $'.number_format($ingresoDep,2,'.',',').' </td>
                <td > '.$curpDep.' </td>
            </tr>';

        }

        $tabla = $tabla.'<tr>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                </tr>        
            </table>
            </td>
        </tr>
        </table>';
    }else{


        $tabla = $tabla.'
        <table >
        <tr>
            <td bgcolor="#6E6E6E" align="center" STYLE="COLOR:#FFFFFF">
                <B>PERSONAS DEPENDIENTES DEL SOLICITANTE</B>
            </td>
        </tr>
        <tr>
            <td border="1">
                <table align="center" >
                    <tr>    
                        <td>NOMBRE </td>
                        <td>parentesco </td>
                        <td>FECHA NAC. </td>
                        <td>SEXO </td>
                        <td>INGRESO </td>
                        <td>CURP </td>
                    </tr>
                    <tr>
                        <td height="100"> </td>
                        <td height="100"> </td>
                        <td height="100"> </td>
                        <td height="100"> </td>
                        <td height="100"> </td>
                        <td height="100"> </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
        </table>';
    }

    

    $tabla = $tabla.'<br><br>';


    $tabla = $tabla.'
    <table style="font-size:10px;" >
    
        <tr>
            <td width="300px;">TIPO DE VIVIENDA DONDE VIVEN ACTUALMENTE: </td>
            <td width="100px;" style="border-bottom: 1px solid #000"><b>'.TramiteDatoExtendida($idTramite,58,0).'</b></td>
            <td></td>
        </tr>
        <tr>
            <td width="300px;">NO. DE PERSONAS QUE HABITARAN EL LOTE SOLICITADO:</td>
            <td width="100px;" style="border-bottom: 1px solid #000"><b>'.TramiteDatoExtendida($idTramite,71,0).'</b></td>
            <td></td>
        </tr>
        <tr>
            <td width="300px;">NO. DE PERSONAS DEPENDIENTES DEL SOLICITANTE:</td>
            <td width="100px;" style="border-bottom: 1px solid #000"><b>'.TramiteCantidadDependientes($idTramite).'</b></td>
            <td></td>
        </tr>
        <tr>
            <td width="300px;">MUNICIPIO PARA EL CUAL ESTA SOLICITANDO EL LOTE:</td>
            <td width="100px;" style="border-bottom: 1px solid #000"><b>'.TramiteDatoExtendida($idTramite,70,0).'</b></td>
            <td></td>
        </tr>
  
   
    </table>';

    $tabla = $tabla.'<br><br>';
    $tabla = $tabla.'
    <table >
    <tr>
        <td >
            <table>
                <tr>
                    <td border="1" bgcolor="#6E6E6E" STYLE="COLOR:#FFFFFF">  <B>OBSERVACIONES</B></td>
                    <td ></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td border="1" >
            <table>
                <tr>    
                    <td height="100">'.TramiteDatoExtendida($idTramite,90,0).'</td>
                </tr> 
            </table>
        </td>
    </tr>
    </table>';

    $tabla = $tabla.'<br><br><br><br><br>';
    $tabla = $tabla.'
    <table >
    <tr>
        <td width="60px;"></td>
        <td width="250px;" style="border-top: 1px solid #000" >
            NOMBRE Y FIRMA DEL ENCUESTADOR   
        </td>
        <td width="50px;"></td>
        <td  width="250px;" style="border-top: 1px solid #000">
            NOMBRE Y FIRMA DEL SOLICITANTE
        </td>
        <td ></td>
    </tr>
    </table>';
    
    $tabla = $tabla.'<br><br>';
    $tabla = $tabla.'
    <table border="1">
    <tr>
        <td style="font-size: 10px;">
            AL FIRMAR LA SOLICITUD DECLARO, BAJO PROTESTA DE DECIR VERDAD, QUE TODA LA INFORMACION QUE HE PROPORCIONADO ES VEREZ Y 
            CORRECTA, LES AUTORIZO VERIFICAR LA INFORMACIÓN DE LA SOLICITUD, ESTOY DE ACUERDO EN QUE DE AUTORIZARME EL CREDITO, CUMPLIRE LOS 
            LINEAMIENTOS REQUERIDOS EN LOS CONTRATOS. EL FALSEAR INFORMACIÓN ES MOTIVO DE LA CANCELACIÓN DE LA SOLICITUD.
        </td>
    </tr>
    </table>';

    $tabla = $tabla.'<br><hr>';

    $tabla = $tabla.'<table>
    <tr><td></td></tr>
    </table>';

    $tabla = $tabla.'
    <br><br><br>
    <table align="center">
    <tr>
        <td border="1"  bgcolor="#6E6E6E" style="font-size: 10px; COLOR:#FFFFFF;">
           NO. SOLICITUD
        </td>
        <td>
        </td>
        <td border="1"  bgcolor="#6E6E6E" style="font-size: 10px; COLOR:#FFFFFF;">
            FECHA DE SOLICITUD
        </td>
    </tr>
    <tr>
        <td border="1" style="font-size: 10px;">
         <b>'.TramiteFolioVivienda($idTramite).'</b>
        </td>
        <td>
        </td>
        <td border="1">
            <b>'.fecha_larga(TramiteFechaCaptura($idTramite)).'</b>
        </td>
    </tr>
    </table>';

    //echo $tabla;
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
    // set document information
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetTitle('FORMATO DE SOLICITUD');
    $pdf->SetKeywords('Reporte ITAVU');
    //$pdf->SetHeaderData('pdf_logo.jpg', '40','', '');
    $pdf->SetHeaderData('pdf_logo.jpg', '40', '', "Impreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($nitavu));
    //$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, '', '');

  
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
    //$pdf->SetFooterData("Impreso: ".fecha_larga($fecha).", ".hora12($hora)." por ".nitavu_nombre($nitavu),array(0, 64, 0),array(0, 64, 128));

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
    $pdf->AddPage('P', 'LEGAL'); //en la tabla de reporte L o P
    $html = $tabla;
    $pdf->writeHTML($html, true, false, true, false, '');

    // reset pointer to the last page
    $pdf->lastPage();
    //Close and output PDF document}
    ob_end_clean();
    $pdf->Output('reporte.pdf', 'I');
  


?>