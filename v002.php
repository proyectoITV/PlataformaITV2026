<?php
require("config.php");
require_once('seguridad.php');
require_once('lib/funciones.php');
ob_end_clean();
require('lib/flor_funciones.php');
// require_once('lib/pdf/tcpdf.php');

$id_aplicacion ="v002"; 
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
// error_reporting(0);
if (sanpedro($id_aplicacion, $nitavu)==TRUE){   

    $contrato = $_GET['numcontrato']; if (ValidaVAR($contrato)==TRUE){$contrato = LimpiarVAR($contrato);} else {$contrato = "";}
    $OriginData = $_GET['origindata']; if (ValidaVAR($OriginData)==TRUE){$OriginData = LimpiarVAR($OriginData);} else {$OriginData = "";}
    
    $cancelado=0;

       $t1 = ""; 
    historia($nitavu, 'Consulto el estado de cuenta con numero de contrato'.$contrato.' y OriginData='.$OriginData);
    $sql = "SELECT IdDelegacion,  Delegacion, IdPrograma, Programa, ProgramaGral, Folio, NumContrato, IdSolicitante, Paterno, Materno, Nombre,
    NombreCompleto, EstadoCivil, SectorCateg, IdMunicipio, Municipio, IdColonia, Colonia,
    seccion, fila, manzana, lote, superficie, eMail, OficioAutorizacion, Facebook,
    Twitter, IdMandante, 	CAST(FechaContrato as Date) AS FechaContrato, NombreDelDesarrollador, IdLote, NumEscritura, Cancelado, 	vivienda_informacioncontratos.Curp
    FROM vivienda_informacioncontratos WHERE numcontrato = '".$contrato."' and OriginData='".$OriginData."'";
    //  echo $sql;
    $rc= $Vivienda -> query($sql);
    if($value = $rc -> fetch_array())
	{

        $CanceladoText = "";
        if ($value['Cancelado']=="1"){
            $CanceladoText='<b style="font-size:10pt; color:red;">CONTRATO CANCELADO</b>';
        }
        $cancelado = $value['Cancelado'];  $t1 = '';
        $Delegacion = $value['Delegacion'];  $FechaContrato = $value['FechaContrato'];
        $Beneficiario = $value['NombreCompleto'];
        $IdDelegacion = $value['IdDelegacion'];
        

        $t1 = $t1.VEdoCuentaCancelado($contrato, $OriginData);

        $t1 = $t1.'
        <table width="100%" border=""  >
        
            <tr>
            <td colspan="5" width="44%" align="left" valign="top" style="font-size:7pt;" ><b style="font-size:7pt; color:#67B7E3;">DATOS DEL CONTRATO:</b>'.$CanceladoText.'<br>'.'Delegacion:<b>'.$value['Delegacion'].'('.$value['IdDelegacion'].')</b><br>Programa:<b>'.$value['programa'].'('.$value['IdPrograma'].')</b><BR>
            <b>'.$value['ProgramaGral'].'</b>
            
            ';
            $t1 = $t1."Folio:<b>".$value['Folio']."</b><br>";
            $t1=$t1.'<br>'.VEdoCuentaInfo1($contrato, $OriginData);
            $t1=$t1.'<br>'.vEdoCuentaInfo2($contrato, $OriginData);

            $t1 = $t1.'</td>';




            $t1 = $t1.'
            '.''
           
            .'
            <td colspan="2" width="44%" align="left" valign="top" style="font-size:7pt;" ><b style="font-size:7pt; color:#67B7E3;">DATOS DEL BENEFICIARIO:<BR></b>'.
            
            '
            Curp: <b>'.$value['Curp'].'</b>,<br>Municipio:<b>'.$value['Municipio'].'</b><br>Colonia:<b>'.$value['Colonia'].'</b><br>Manzana:<b>'.$value['manzana'].'</b>, Lote:<b>'.$value['lote'].'</b><br>';
            
            $Domicilio = VEdoCuentaDomicilio($contrato, $IdDelegacion, $value['IdPrograma'], $value['Folio'],$OriginData);


            $t1 = $t1.''.$Domicilio.'<br>';
            // $t1 = $t1.'Estatus Cuenta: <b>'.EstatusCuenta($contrato).'</b>
            $t1 = $t1.'

            
            
            '.'</td>
            <td></td>
            </tr>
        ';
        if (isset($_GET['full'])){
            $t1 = $t1.'<table>'.VEdoCuentaTablaDePagos($contrato, $IdDelegacion,$value['Cancelado'],$OriginData,1,0).'</table>';
        } else {
            if (isset($_GET['cancelados'])){
                $t1 = $t1.'<table>'.VEdoCuentaTablaDePagos($contrato, $IdDelegacion,$value['Cancelado'],$OriginData,0,1).'</table>';
            } else {
                $t1 = $t1.'<table>'.VEdoCuentaTablaDePagos($contrato, $IdDelegacion,$value['Cancelado'],$OriginData,0,0).'</table>';
            }
            

        }

        
        $t1 = $t1.'   
                
        <tr>
            <td colspan="8" valign="top" align="center">';
            
            $t1 = $t1.'<table border="0" width=100%> ';
            $t1 = $t1.'<tr><td valign="top" align="center"  width="32%">  ';
            $t1 = $t1.VEdoCuentaFooter1($contrato, $IdDelegacion, $value['IdPrograma'], $value['Folio'],$OriginData);
            
            $t1 = $t1.'</td> <td width="8px" > </td>';
        
            $t1 = $t1.'<td valign="top" align="center" width="32%">';
            $t1 = $t1.' '.VEdoCuentaFooter2($contrato, $IdDelegacion, $value['IdPrograma'], $value['Folio'],$OriginData);
            $t1 = $t1.'</td> <td width="8px"> </td>';
        
            $t1 = $t1.'<td valign="top" align="center" width="34%">';
            $t1 = $t1.' '.VEdoCuentaFooter3($contrato, $IdDelegacion, $value['IdPrograma'], $value['Folio'],$OriginData);
            $t1 = $t1.'</td><td width="8px"> </td> ';
        
        
            $t1 = $t1.'</tr> ';
            $t1 = $t1.'</table> ';
        
            
            $t1 = $t1.'       </td>
        
        </tr>

        <tr><td colspan="8">'.VEdoCuentaFooter4($contrato, $IdDelegacion, $value['IdPrograma'], $value['Folio'],$OriginData).'</td>
        </tr>
        
        </table>';
    } else {
        echo "<div style='
        width:60%;
        padding:200px;
        font-size:15pt;
        font-family:Light;
        color:white;
        text-align:center;
        '>";
        echo "Información no encontrada";
        echo "</div>";

    }
    
    // echo $t1;
    if ($t1 <> ''){
        // ob_start();
        
        $ContratoCancelado = ContratoCancelado($contrato, $IdDelegacion,$OriginData);
        // $ContratoCancelado = "";
        global $string; 
        $dpto = nitavu_dpto($nitavu);
        $departamento = nitavu_dpto_nombre($nitavu);
        
        // $string  = EdoCuenta_InfoFooter($contrato, $nitavu, $IdDelegacion,$myip);        
        $string  = "Consultado el ".fecha_larga($fecha).":".hora12($hora)." - ".$nitavu." - ".nitavu_nombre($nitavu)." - ".$departamento." | ".$MyIp;
        $string = $string.". Del. Origen: ".$OriginData." - ".DelegacionNombre($OriginData);
        $leyenda = $string;

        $txtQR = VQR($contrato, $OriginData).". nitavu, ".$nitavu.". FechaImpresion, ".$fecha;
        // echo $txtQR;
        // $Beneficiario = "TEST";
        // require_once('pdf/tcpdf.php');
        // ob_end_clean(); 
        EdoCuentaPDF($contrato, $string, $Delegacion, fecha_larga($FechaContrato), $Beneficiario, $t1, $ContratoCancelado, $txtQR);
    }
   
} else {mensaje("Error: No esta autorizado para ver Estados de Cuenta.","index.php");}
?>