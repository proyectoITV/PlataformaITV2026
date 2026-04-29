<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("lib/yes_funciones.php");
require("lib/flor_funciones.php");
require("lib/laura_funciones.php");

//$IdLote=VarClean($_POST['idlote']);
//$NumContrato=VarClean($_POST['contrato']);
$historico=0;
$folio=VarClean($_POST['folio']);
$cuantoscontratos=VarClean($_POST['cuantoscontratos']);
$cualescontratos=VarClean($_POST['cualescontratos']);
$TipoPago=VarClean($_POST['TipoPago']);
$Referencia=VarClean($_POST['Referencia']);
$Concepto=VarClean($_POST['Concepto']);
if ($_POST['NumRec']){
$FechaPagoHis=VarClean($_POST['FechaPagoHis']);
$NumRec=VarClean($_POST['NumRec']);
$historico=1;
}

$MontoPago=VarClean($_POST['MontoPago']);

$sqlC="Select * from convdesarrollador where Folio=".$folio;
                $rc2= $Vivienda -> query($sqlC);   
                if($f = $rc2 -> fetch_array()) 
                {                   
                    //$Numcontrato=GenerarNumContrato($f['IdDelegacion'],$f['IdPrograma'],$f['IdMunicipio'],$nitavu);
                    if ($historico==0){
                        $NumRec=IdSiguienteFolioRecibo();
                    }
                    $ProxMov=NumMovDes($folio)+1;
                    $sql="
                            INSERT INTO pagosdesarrolladores
                            (IdDesarrollador,IdDelegacion, IdPrograma,Folio,FolioRecibo, FechaPago,LotesAbonados,
                            Concepto,Importe, NumPago, Tipopago,IdEmpCrea,FechaCaptura, Referencia, Cancelado,
                            contratospagados,OrigenDeEnvio";

                            if ($historico==1){
                                $sql=$sql.",FechaHistorica";
                            }   

                            $sql=$sql.")
                            values(
                                '".$f['IdDesarrollador']."',
                                '".$f['IdDelegacion']."',
                                '".$f['IdPrograma']."',
                                '".$folio."',
                                '".$NumRec."',
                                '".$fecha."',
                                '".$cuantoscontratos."',
                                '".$Concepto."',
                                '".$MontoPago."','".$ProxMov."',
                                '".$TipoPago."',
                                '".$nitavu."',
                                '".$fecha."',
                                '".$Referencia."',
                                0,
                                '".$cualescontratos."',0 )            
                            ";
                            
                        }
                        if ($Vivienda->query($sql) == TRUE) {
                            //se agrega para registrar recibo en tabla datosrecibos
                            //$reciboG=GuardaDatosRecibo($IdDelegacion ,$IdPrograma ,$Folio ,$NumContrato  ,$Pago,$TipoPago ,$Referencia ,$FechaOperacion ,$nitavu, $NumRec ,$NumeroMovimiento,63  ,0);
                            $reciboG=GuardaDatosRecibo($f['IdDelegacion'] ,$f['IdPrograma'] ,$folio ,""  ,$MontoPago,$TipoPago ,$Referencia ,$fecha ,$nitavu, $NumRec ,$ProxMov,63  ,0);
                            if ($reciboG="TRUE")					
                            {	//$acumula_puntos = $acumula_puntos + $contador_puntos;
                                historia($nitavu, "Pago global de desarrollador, al contrato='".$cualescontratos."' Folio Recibo".$NumRec); 	
                                actualizarFolioRecibo($NumRec);
                                $NumRec=strval($NumRec);
                                echo 'TRUE,'.$NumRec;
                                //$RES="TRUE";
                                //echo 'TRUE';
                                
                            }else
                            {
                                $RES='FALSE';
                                //Destruye_HistoricoPagos($NumContrato,$NumeroCuentaAntes,1) ;  
                                //echo "Al parecer ha ocurrido un problema en el almacenamiento del recibo, marco error la sección de datosRecibo (Adelentar pagos)";  
                            }				


                           // echo 'echo';
                            //echo "<script>$('#mensajes').html('Se registro pago global')";                            
                            //echo $numrec;
                            //.val('".$NumRec."');</script>";    
                            //return $NumRec;

                            //antes correcto
                            //$NumRec=strval($NumRec);
                            //echo 'TRUE,'.$NumRec;
                            
                        }





?>