<?php
include ("lib/body_head.php");
?>

<?php
    require("plantilla-core.php");
$id_aplicacion ="ap113"; 
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";        
    xd_update($id_aplicacion,$nitavu); historia($nitavu, $id_aplicacion." | Entro a contratación");
    echo "<br><br>";

    if(isset($_GET['delegacion']) and isset($_GET['programa']) and isset($_GET['folio'])){
        $IdDelegacion = $_GET['delegacion'];
        $IdPrograma = $_GET['programa'];
        $Folio = $_GET['folio'];
        $nitavu = $_GET['nitavu'];
        $del =  midelegacion_id($nitavu);

        $idlote = $_POST['idlote'];
        $municipio = $_POST['municipio']; 
        $colonia = $_POST['colonia'];
        $seccion = $_POST['seccion'];
        $fila = $_POST['fila'];
        $manzana = $_POST['manzana'];  
        $lote = $_POST['lote'];
       
        $IdTipoMoneda = $_POST['IdTipoMoneda'];
        $MontoCredito = $_POST['precio'];
        $IdPagoInicial = $_POST['IdPagoInicial'];
        $MontoPagoInicial =  $_POST['MontoPagoInicial'];
        $TipoPago = $_POST['TipoPago'];
        $NumMensualidades = $_POST['TotalPagos'];
        $MontoPago = $_POST['MontoPago'];
        $MontoUltimoPago = $_POST['MontoUltimoPago'];
        $TasaAnualFin = $_POST['TasaAnualFin'];
        if(isset($_POST['TipoIntMoratorio'])){
            $TipoIntMoratorio = $_POST['TipoIntMoratorio'];
        }else{
            $TipoIntMoratorio = 0;
        }
       
        $TasaIntMora = $_POST['TasaIntMora'];
        $PeriodoMora = $_POST['PeriodoMora'];
        $TotalAFinanciar = $_POST['totalafinanciar'];

        $oficioAutorizacion = $_POST['oficioAutorizacion'];
        $fallecimiento = $_POST['fallecimiento'];
        $parentesco = $_POST['parentesco'];

        $nomcolonia = $_POST['nomcolonia'];
        $superficie = $_POST['superficie'];
        $colindancia1 = $_POST['colindancia1'];
        $colindancia2 = $_POST['colindancia2'];
        $colindancia3 = $_POST['colindancia3'];
        $colindancia4 = $_POST['colindancia4'];
        $beneficiario = $_POST['beneficiario'];


        //DATOS DEL AVAL
        $NombreAval = $_POST['NombreAval'];
        $CalleAval = $_POST['CalleAval'];
        $EntreCalleAval = $_POST['EntreCalleAval'];
        $EntreCalleAval2 = $_POST['EntreCalleAval2'];
        $MunicipioAval = $_POST['MunicipioAval'];
        if(isset($_POST['ColoniaAval'])){
            $ColoniaAval = $_POST['ColoniaAval'];
        }else{
            $ColoniaAval = "";
        }
        if(isset($_POST['ColoniaAval'])){
            $ColoniaAval = $_POST['ColoniaAval'];
        }else{
            $ColoniaAval = "";
        }
        if(isset($_POST['CPAval'])){
            $CPAval = $_POST['CPAval'];
        }else{
            $CPAval = "";
        }
        if(isset($_POST['TelCasaAval'])){
            $TelCasaAval = $_POST['TelCasaAval'];
        }else{
            $TelCasaAval = "";
        }
        if(isset($_POST['TelTabajoAval'])){
            $TelTrabajoAval  = $_POST['TelTabajoAval'];
        }else{
            $TelTrabajoAval  = "";
        }
        if(isset($_POST['LugarTrabajoAval'])){
            $LugarTrabajoAval = $_POST['LugarTrabajoAval'];
        }else{
            $LugarTrabajoAval = "";
        }
        if(isset($_POST['DomicilioTrabajoAval'])){
            $DomicilioTrabajoAval = $_POST['DomicilioTrabajoAval'];
        }else{
            $DomicilioTrabajoAval = "";
        }
        



        //VERIFICAMOS SI EL ORIGIN DATA. SI PERTENCE A ALGUIEN DE OFICINAS CENTRALES ENTONCES OBTENEMOS EL VALOR SELECCIONADO
        if($del==0)
        {
            if( isset($_POST['delegacionDondeTrabajar']))
            {
                $del=$_POST['delegacionDondeTrabajar'];
                
            }
        }

        if (postBlock($_POST['postID'])) {
            // No existe doble post
            // Procesamos la informaciÃ³n
        } else {
            // Doble post, no procesamos el form
            mensaje('No es posible enviar la información nuevamente','contratarCredito.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion);        
            return;
        }


     /* VALIDACIONES ANTES DE GENERAR UN CONTRATO */
     
        $NCertSubsidioF = NCertSubsidioF($IdDelegacion, $IdPrograma, $Folio);
        $SubsidioFonhapo = SubsidioFonhapo($IdDelegacion, $IdPrograma, $Folio);
        $NCertSubsidioI = NCertSubsidioI($IdDelegacion, $IdPrograma, $Folio);
        $SubsidioItavu = SubsidioItavu($IdDelegacion, $IdPrograma, $Folio);
        //VALIDAMOS LOS SUBSIDIOS
        if((($NCertSubsidioF > 0) Or $SubsidioFonhapo == 0) and (($NCertSubsidioI > 0) Or $SubsidioItavu == 0) ){
            if($NCertSubsidioF > 0 ){
                $sql = "select * from historicopagos where numcontrato='".$NumContrato."' and tipomov=9 and cancelado=0";
               // echo $sql;
                $r2= $Vivienda -> query($sql);
                $r_count2 = $r2 -> num_rows;
                if($r_count2>0){
                    modalSinRedirigir("Se detectó un subsidio Federal ya aplicado a esta cuenta, imposible continuar");
                }
                
                
            }
            if ($IdPrograma <> 248){
                if ($NCertSubsidioI > 0){
                    $sql = "select * from historicopagos where numcontrato='".$NumContrato."' and tipomov=7 and cancelado=0";
                  //  echo $sql;
                    $r2= $Vivienda -> query($sql);
                    $r_count2 = $r2 -> num_rows;
                    if($r_count2>0){
                        modalSinRedirigir("Se detectó un subsidio Estatal ya aplicado a esta cuenta, imposible continuar");
                    }
                }
            }
                   
        }else{
            mensaje("Error, no se puede grabar la info del contrato, falta informacion de un subsidio",'contratar.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion.'&idlote='.$idlote.'&ediar=');
        }


       //FALTARIA VER COMO SACAR LA FECHA EMISION CUANDO SEA UN EDIT
        $FechaEmision = $fecha; 
        $FechaBaseCobranza = date("Y-m-d",strtotime($fecha. "+ 2 month"));
       
        //ESTA VALIDACION NO SÉ COMO SE HARIA
       /* if($Aval == ""){
            modalSinRedirigir("La informacion del Aval no ha sido proporcionada!...");
        }*/

        //GENERAMOS UN NUM CONTRATO 
        $NumContrato = GenerarNumContrato($IdDelegacion,$IdPrograma,$municipio,$nitavu);
        //echo 'Contrato'. $NumContrato;
        //Generamos un procedimiento para guardar todo en la bd

        $sql = "CALL registrarContrato('$NumContrato',
        '',
        '$NombreAval',
        '$CalleAval',
        '$DomicilioTrabajoAval',
        '$EntreCalleAval',
        '$ColoniaAval',
        '$LugarTrabajoAval',
        '$TelCasaAval',
        '$TelTrabajoAval',
        '$EntreCalleAval2',
        0,
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '$fecha',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '$FechaEmision',
        '',
        '',
        '',
        '',
        '',
        '',
        '$Folio',
        '',
        '',
        '',
        '',
        '$IdDelegacion',
        '$nitavu',
        '',
        '',
        '$IdPagoInicial',
        '$IdPrograma',
        '',
        '$IdTipoMoneda',
        '$TipoPago',
        '',
        '',
        '',
        '$MontoCredito',
        '',
        '$MontoPago',
        '$MontoPagoInicial', 
        '$MontoUltimoPago',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '$PeriodoMora',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '$TasaAnualFin',
        '$TasaIntMora',
        '$TipoIntMoratorio', 
        '$NumMensualidades',
        '',
        '',
        '$idlote',
        '$municipio',
        '$colonia',
        '$seccion',
        '$fila',
        '$manzana',
        '$lote',
        '',
        '',
        '$FechaBaseCobranza',
        '',
        '',
        '',
        '$oficioAutorizacion',
        '',
        '',
        '$fallecimiento',
        '$parentesco',
        '',
        '',
        '',
        '',
        '',
        '',
        '',
        '$IdDelegacion')";
            
        //echo $sql;
       
        if ($Vivienda->query($sql) == TRUE){
   //INSERTAR EN CONTROL CONTRATOS
            /*(VVP_NumContrato, VVP_FechaCorteAnterior, VVP_FechaProximoCorte, VVP_EstatusCuenta, VVP_FechaReactivacion, VVP_Observaciones,
             VVP_Enviar, VVP_IdEmpCrea, VVP_IdEmpModifica, VVP_FechaCaptura, VVP_FechaUltimaMod, VVP_FechaEnvio, VVP_FechaActualizaDomParaNotificacion, VVP_OrigenDeEnvio, VPP_OriginData)*/
         
             $fechaCorte = ObtenerFechaCorteContrato();
             $sql1 = "CALL registrarControlContratos('$NumContrato','','".$fechaCorte."','2','','',  
            '','$nitavu','','$fecha','','','','','$IdDelegacion')";
           // echo $sql1;
            if ($Vivienda->query($sql1) == TRUE){
                //mensaje('Contrato registrado con éxito.','contratacion.php');          
                $sql2 = "CALL spActualizaLotesAlContratar($idlote,'$NumContrato',$IdDelegacion,$IdPrograma, $Folio,'$MontoCredito','$nitavu')";
               // echo $sql2;
                if ($Vivienda->query($sql2) == TRUE){
                    if(actualizarAprobadoContratar($IdDelegacion, $IdPrograma, $Folio)==TRUE){
                        //INSERTAR HISTORICO PAGOS
                        //INSERTAMOS REGISTRO DE CREDITO
                        if(existenPagosDeAhorro($Folio, $IdPrograma, $IdDelegacion)>0){
                          
                         //   echo 'entro';
                            $sql3 = "CALL registrarHistoricoPagos('$NumContrato','1','',NOW(),'$fechaCorte','','','','','',
                            '','','','','','','','','','',
                            '','','','','','','','','',
                            '','','','','".$MontoCredito."','','','','".$MontoCredito."',
                            'PIC','1','','','$nitavu','',NOW(),'','','','','',
                            '','','','','','','','',0,'','$IdDelegacion')";
                        }else{
                        //   echo 'entro2';
                            $sql3 = "CALL registrarHistoricoPagos('$NumContrato','1','',NOW(),'$fechaCorte','','','','','',
                            '','','','','','','','','','',
                            '','','','','','','','','',
                            '','','','','".$MontoCredito."','','','','".$MontoCredito."',
                            'PIC','1','','','$nitavu','',NOW(),'','','','','',
                            '','','','','','','','',0,'','$IdDelegacion')";
                        }
                       // echo $sql3;
                        if ($Vivienda->query($sql3) == TRUE){
                            //AGREGAR TODOS LOS REGISTROS DE PAGOS INICIALES PARA INSERTARLOS EN HISTORICO
                            
                            if(agregarPagosdeAhorro($Folio, $IdPrograma, $IdDelegacion, $NumContrato, $nitavu)==TRUE){                               
                                   
                                   echo "<center><h1>Asignación de lote</h1></center>";
                                  // echo "<div style='width: 100%; height: 100%;'><iframe id='CartaAsignacion' name='CartaAsignacion' style='width: 100%; height: 100%;' src='carga_contrato.php?IdPlantilla=3&lote=".$lote."&manzana=".$manzana."&nomcolonia=".$nomcolonia."&superficie=".$superficie."&colindancia1=".$colindancia1."&colindancia2=".$colindancia2."&colindancia3=".$colindancia3."&colindancia4=".$colindancia4."&beneficiario=".$beneficiario."'>Tu navegador no soporta iframes...</iframe></div>";
                               
                                    //seleccionar la plantilla a mostrar la obtenemos del programa
                                    //$IdPlantilla = plantillaPrograma($IdPrograma);                                   

                                    $IdPlantilla=IdPlantilla(nombrePlantilla($idlote));
                                    if($IdPlantilla!=0){
                                    //CREAMOS PLANTILLA
                                    crearPlantilla($IdPlantilla, $NumContrato, $TotalAFinanciar, $nitavu);
                                    }else{
                                        mensaje('Aviso: No se puede imprimir el contrato, no existe una plantilla registrada para este lote.','contratar.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion.'&idlote='.$idlote.'&ediar=');
                                    }
                                    
                                    
                                   echo "<script>
                                        NPush('Contrato registrado con éxito.','Plataforma ITAVU')
                                    </script>";
                               

                            }else{
                                $sqlDelete="CALL spDeleteContrato('$NumContrato', '$IdDelegacion', '$IdPrograma','$Folio','$idlote','$nitavu')";
                              //  echo $sqlDelete;
                                if ($Vivienda->query($sqlDelete) == TRUE){
                                    historia($nitavu, 'Se eliminaron con éxito los registros del contrato por que ocurrio un error al momento de registrar pagos de ahorro en historico pagos');
                                }else{
                                    historia($nitavu, 'ERROR: Al eliminar los registros del contrato por que ocurrio un error al momento de registrar pagos de ahorro en historico pagos');
                                }
                                mensaje('ERROR: Al momento de ingresar los pagos de ahorro.','contratar.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion.'&idlote='.$idlote.'&ediar=');
                            }

                        }else{
                            $sqlDelete="CALL spDeleteContrato('$NumContrato', '$IdDelegacion', '$IdPrograma','$Folio','$idlote','$nitavu')";
                          //  echo $sqlDelete;
                            if ($Vivienda->query($sqlDelete) == TRUE){
                                historia($nitavu, 'Se eliminaron con éxito los registros del contrato por que ocurrio un error al momento de registrar en historico pagos');
                            }else{
                                historia($nitavu, 'ERROR: Al eliminar los registros del contrato por que ocurrio un error al momento de registrar en historico pagos');
                            }
                            mensaje('ERROR: al momento de registrar en historico pagos.','contratar.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion.'&idlote='.$idlote.'&ediar=');
                        }

                    }else{
                        $sqlDelete="CALL spDeleteContrato('$NumContrato', '$IdDelegacion', '$IdPrograma','$Folio','$idlote','$nitavu')";
                     //   echo $sqlDelete;
                        if ($Vivienda->query($sqlDelete) == TRUE){
                            historia($nitavu, 'Se eliminaron con éxito los registros del contrato por que ocurrio un error al momento de actualizar solicitudes el campo aprobado contratar');
                        }else{
                            historia($nitavu, 'ERROR: Al eliminar los registros del contrato por que ocurrio un error al momento de actualizar solicitudes el campo aprobado contratar');
                        }
                        mensaje('ERROR: al momento de actualizar el registro en solicitudes.','contratar.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion.'&idlote='.$idlote.'&ediar=');
                    }
                 
                }else{
                    $sqlDelete="CALL spDeleteContrato('$NumContrato', '$IdDelegacion', '$IdPrograma','$Folio','$idlote','$nitavu')";
                  //  echo $sqlDelete;
                    if ($Vivienda->query($sqlDelete) == TRUE){
                        historia($nitavu, 'Se eliminaron con éxito los registros del contrato por que ocurrio un error al momento de registrar en tabla lotes');
                    }else{
                        historia($nitavu, 'ERROR: Al eliminar los registros del contrato por que ocurrio un error al momento de registrar en tabla lotes');
                    }
                    mensaje('ERROR: al momento de actualizar el registro en Lotes.'.$sql2,'contratar.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion.'&idlote='.$idlote.'&ediar=');
                 }

            }else{
                $sqlDelete="CALL spDeleteContrato('$NumContrato', '$IdDelegacion', '$IdPrograma','$Folio','$idlote','$nitavu')";
             //   echo $sqlDelete;
                if ($Vivienda->query($sqlDelete) == TRUE){
                    historia($nitavu, 'Se eliminaron con éxito los registros del contrato por que ocurrio un error al momento de registrar control contratos');
                }else{
                    historia($nitavu, 'ERROR: Al eliminar los registros del contrato por que ocurrio un error al momento de registrar control contratos');
                }
                mensaje('ERROR: al momento de registrar el contrato en control contratos.','contratar.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion.'&idlote='.$idlote.'&ediar=');
            }
        }else{
            echo "Falló CALL: (" . $Vivienda->errno . ") " . $Vivienda->error;
            $sqlDelete="CALL spDeleteContrato('$NumContrato', '$IdDelegacion', '$IdPrograma','$Folio','$idlote','$nitavu')";
          //  echo $sqlDelete;
            if ($Vivienda->query($sqlDelete) == TRUE){
                historia($nitavu, 'Se eliminaron con éxito los registros del contrato por que ocurrio un error al momento de registrar el contrato');
            }else{
                historia($nitavu, 'ERROR: Al eliminar los registros del contrato por que ocurrio un error al momento de registrar el contrato');
            }
            mensaje('ERROR: al momento de registrar un contrato, favor de intentarlo nuevamente.','contratar.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion.'&idlote='.$idlote.'&ediar=');
        }

         
    }else{
        mensaje("ERROR: no se recibio la información aedcuadamente, favor de intentarlo de nuevo.",'contratar.php?_folio='.$Folio.'&programa='.$IdPrograma.'&delegaciones='.$IdDelegacion.'&idlote='.$idlote.'&ediar=');
    }
}else{
    mensaje("ERROR: no tienes acceso a este modulo","");
}



?>
<script>

</script>
<?php include ("lib/body_footer.php"); ?>