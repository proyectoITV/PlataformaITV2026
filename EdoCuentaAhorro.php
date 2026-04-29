
<?php
//require_once('pdf/tcpdf.php');

require("config.php");
require_once('seguridad.php');
require_once('lib/funciones.php');
ob_end_clean();
require('lib/flor_funciones.php');
require('lib/yes_funciones.php');

$id_aplicacion ="v002"; 
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
// error_reporting(0);
if (sanpedro($id_aplicacion, $nitavu)==TRUE){   
    $iddelagacion = $_GET['IdDelegacion']; if (ValidaVAR($iddelagacion)==TRUE){$iddelagacion = LimpiarVAR($iddelagacion);} else {$iddelagacion = "";}
    $idprograma = $_GET['IdPrograma']; if (ValidaVAR($idprograma)==TRUE){$idprograma = LimpiarVAR($idprograma);} else {$idprograma = "";}
    $folio = $_GET['Folio']; if (ValidaVAR($folio)==TRUE){$folio = LimpiarVAR($folio);} else {$folio = "";}
    $OriginData = $_GET['OriginData']; if (ValidaVAR($OriginData)==TRUE){$OriginData = LimpiarVAR($OriginData);} else {$OriginData = "";}    

    $cancelado=0;
    $t1 = ""; 

 historia($nitavu, 'Consulto el estado de cuenta del folio '.$folio.' del programa '.$idprograma.' delegacion'.$iddelagacion.' y OriginData='.$OriginData);
 $sql = " SELECT   delegaciones.Delegacion As Delegacion, programa.Programa, 
 pagos.NumPago, pagos.FolioRec, pagos.Fecha, pagos.Importe, pagos.Observaciones, 
 CONCAT(IFNULL(Pers.Nombre,''),IFNULL(Pers.Paterno,''),IFNULL(Pers.Materno,'')) as NombreCompleto,Pers.Curp,
  Sol.FechaCaptura As FechaSol,
 (Case when Sol.Cancelado = 0 then 'Vigente' else 'Cancelado' End) As Estatus,  
 (SELECT DescripcionMovimiento FROM descripcionmovimiento AS Dm WHERE idTipoMov = pagos.idTipoMov) AS Concepto, delegaciones.iddelegacion, programa.idprograma, pagos.folio, pagos.IdEmpCrea As Cajero
 FROM  solicitantes AS Pers RIGHT OUTER JOIN
 solicitudes AS Sol ON Pers.IdSolicitante = Sol.IdSolicitante RIGHT OUTER JOIN
 pagos ON Sol.IdDelegacion = pagos.IdDelegacion AND Sol.IdPrograma = pagos.IdPrograma AND Sol.Folio = pagos.Folio LEFT OUTER JOIN
 delegaciones ON pagos.IdDelegacion = delegaciones.IdDelegacion LEFT OUTER JOIN
 programa ON pagos.IdPrograma = programa.IdPrograma
 Where pagos.Cancelado = 0
 And   pagos.IdDelegacion = ".$iddelagacion." And   pagos.IdPrograma = ".$idprograma." And   pagos.Folio = ".$folio." and pagos.OriginData=".$OriginData." LIMIT 1";

//echo $sql;
 $rc= $Vivienda -> query($sql);
 if($value = $rc -> fetch_array())
 {

     $CanceladoText = "";
     if ($value['Estatus']=="Cancelado"){
         $CanceladoText='<b style="font-size:10pt; color:red;">SOLICITUD CANCELADO</b>';
     }
     $cancelado = $value['Estatus'];  $t1 = '';
     $Delegacion = $value['Delegacion']; 
     $Programa = $value['Programa'];
     $FechaContrato = $value['FechaSol'];
     $Beneficiario = $value['NombreCompleto'];
      
     $IdDelegacion = $value['iddelegacion'];
     $IdPrograma = $value['idprograma'];
     $Folio = $value['folio'];
     $contrato='';

     ///$t1 = $t1.VEdoCuentaCancelado($contrato, $OriginData);

     $t1 = $t1.'
     <table width="100%" border=""  >
     
         <tr>
         <td colspan="5" width="44%" align="left" valign="top" style="font-size:7pt;" ><b style="font-size:7pt; color:#67B7E3;">DATOS DE LA SOLICITUD:</b>'.$CanceladoText.'<br>'.'Delegacion:<b>'.$value['Delegacion'].'('.$value['iddelegacion'].')</b><br>Programa:<b>'.$value['Programa'].'('.$value['idprograma'].')</b><br>Folio:<b>'.$value['folio'].'</b></td>';
         $t1 = $t1.'<td colspan="2" width="44%" align="left" valign="top" style="font-size:7pt;" ><b style="font-size:7pt; color:#67B7E3;">DATOS DEL BENEFICIARIO:<BR></b>'.
         
         '
         Curp: <b>'.$value['Curp'].'</b><br>';
         
         $Domicilio = VEdoCuentaDomicilio($contrato, $IdDelegacion, $value['idprograma'], $value['folio'],$OriginData);


         $t1 = $t1.''.$Domicilio.'<br>';
         // $t1 = $t1.'Estatus Cuenta: <b>'.EstatusCuenta($contrato).'</b>
         $t1 = $t1.'
         '.'</td>
         <td></td>
         </tr>
     ';
    
     $t1 = $t1.'<br><br><br><br><br><br><br><table border="0" width=90%>'.VEdoCuentaTablaDePagosAhorro($value['iddelegacion'],$value['idprograma'], $value['folio']).'</table>';


    

     
     $t1 = $t1.'</table>';


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
   

}
EdoCuentaPDF($contrato, $string, $Delegacion, fecha_larga($FechaContrato), $Beneficiario, $t1, $ContratoCancelado, $txtQR);

 } else {
     echo "<center><div style='
     width:60%;
     padding:200px;
     font-size:15pt;
     font-family:Light;
     color:white;
     text-align:center;
     background:gray;
     '>";
     echo "Información no encontrada!";
     echo "</div></center>";

 }
 

}else {mensaje("Error: No esta autorizado para ver Estados de Cuenta.","index.php");}
?>