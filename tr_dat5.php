<?php 
require("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require_once("lib/yes_funciones.php");
?>

<?php
      
    $idTramite = $_GET['Folio'];
    $idTipoTramite = $_GET['IdTipoTramite'];
    $IdPrograma = $_GET['IdPrograma'];

    echo $idTramite.'-'.$idTipoTramite.'-'.$IdPrograma;
    $NombreDelArchivoDeEjecucion = TramiteEjecucionName($idTipoTramite);
    $Continuo = 'TRUE';
    if ($NombreDelArchivoDeEjecucion <> '' ){
        if (file_exists($NombreDelArchivoDeEjecucion)) {
            include($NombreDelArchivoDeEjecucion); //<-- Este archivo hara las ejecuciones necesarias, y cambiara $Continuo a FALSE si lo requiere
        }

    } else {
        $Continuo = 'TRUE'; //<-- Si no tiene definido un archivo de prevalidacion no la necesita
        
        
    }
    echo $Continuo;
     if ($Continuo == 'TRUE') {
    
        $info = detectar();
        if (TramiteAprobar($idTramite, $nitavu, $info) == TRUE){
            
            historia($nitavu, "El tramite ".$idTramite." fue  aprobado");
            $idTipoTramite=TramiteIdTipoTramite($idTramite);
            $idPrograma=TramiteIdPrograma($idTramite);
            $nombrePrograma=TramiteProgramaNombre($idTipoTramite);
            $nombreTramite=TramiteNombre($idTipoTramite);
            $nitavuCaptura=TramiteNitavuCaptura($idTramite);
            $msgNoti=''.$nombreTramite.' con  Folio'.$idTramite.' del programa '.$nombrePrograma.' fue <B>APROBADO</B>, puede continuar con la siguiente fase del tramite.<BR><BR><b>Atentamente:</b><br>'.nitavu_nombre($nitavu);

            //notificacion_add ($nitavuCaptura, 'El tramite '.$nombreTramite.' folio '.$idTramite.' fue APROBADO', date('Y-m-d'),$nitavu, $msgNoti);     
        
            //INSERTAMOS EL SIGUIENTE TRÁMITE POR DEFAULT
           /* if($idTipoTramite == 10){
                echo "<script>console.log('ENTRO A CONDICION ".$idTipoTramite."')</script>";
                $FolioTramiteNuevo = ntramite(TRUE);
                $sql= "INSERT INTO tramites (IdTramite, IdTipoTramite, Curp, NitavuCaptura, Fecha, Hora, DptoCaptura, Estado, NombreBeneficiario)
                VALUES (".$FolioTramiteNuevo.", '11','".TramiteDato($idTramite, 0, 0)."','','".$fecha."', '".$hora."',".IdDptoEjecucion(11).",'0','".TramiteDato($idTramite, 1, 0)." ".TramiteDato($idTramite, 2, 0)." ".TramiteDato($idTramite, 3, 0)."')";
                     echo "<script>console.log('sql".$sql." folio ".$FolioTramiteNuevo."')</script>";
                    if ($conexion->query($sql) == TRUE){     
                    ntramite(FALSE);              
                    historia($nitavu,'Se agregó un nuevo trámite de captura de pago');

                    echo "<script>console.log('Iniciando Tramite ' + '".$FolioTramiteNuevo."')</script>";
                    echo "<script>NPush('Se ha Iniciado el Tramite ' + '".$FolioTramiteNuevo."', 'Plataforma ITAVU')</script>";
                    //Guardamos los datos principales
                    if (GuardarTramiteDato($FolioTramiteNuevo, 0, TramiteDato($idTramite, 0, 0), "text", '', 0) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                    if (GuardarTramiteDato($FolioTramiteNuevo, 1, TramiteDato($idTramite, 1, 0), "text", '', 0) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: Nombres');</script>"; }
                    if (GuardarTramiteDato($FolioTramiteNuevo, 2, TramiteDato($idTramite, 2, 0), "text", '', 0) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito:Apellido1');</script>"; }
                    if (GuardarTramiteDato($FolioTramiteNuevo, 3, TramiteDato($idTramite, 3, 0), "text", '', 0) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: Apellido2');</script>"; }
                    if (GuardarTramiteDato($FolioTramiteNuevo, 4, TramiteDato($idTramite, 4, 0), "text", '', 0) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: sexo');</script>"; }
                    if (GuardarTramiteDato($FolioTramiteNuevo, 5, TramiteDato($idTramite, 5, 0), "date", '', 0) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: FechaNacimiento');</script>"; }
                    if (GuardarTramiteDato($FolioTramiteNuevo, 8, TramiteDato($idTramite, 8, 0), "text", '', 0) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: StatusCURP');</script>"; }
    
                    if (GuardarTramiteDato($FolioTramiteNuevo, 6, TramiteDato($idTramite, 6, 0), "text", '', 0) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: Nacionalidad');</script>"; }
                    if (GuardarTramiteDato($FolioTramiteNuevo, 7, TramiteDato($idTramite, 7, 0), "text", '', 0) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: Entidad de Nacimiento');</script>"; }
    
                } else {
                    historia($nitavu,'No se pudo agregar un nuevo trámite de captura de pago');
                    mensaje("ERROR: al guardar el tramite, comuniquese con el Dpto de Informatica, y capture esta pantalla. <br>:".$sql,"tr_iniciar.php");
                }
            }*/

            //INSERTAMOS LA SOLICITUD POR DEFAULT EN LA APP DE SOLICITUDES PARA QUE APAREZCA COMO PENDIENTE
            //Obtenemos el siguiente folio para solicitudes
            $FolioTramite = nsolicitud(TRUE); 
            $CURP = TramiteCURP($idTramite);
			$IdTipoTramite = TramiteIdTipoTramite($idTramite);
			$Nombres = TramiteNombres($idTramite);
			$Apellido1 = TramiteApellido1($idTramite);
			$Apellido2= TramiteApellido2($idTramite);
            $Sexo = TramiteSexo($idTramite);
            if($Sexo=='M'){
                $Sexo = 1;
            }else{
                $Sexo = 2;
            }
			$FechaNacimiento = TramiteFechaNacimiento($idTramite);
			$StatusCurp = TramiteStatusCurp($idTramite);
			$Nacionalidad = TramiteNacionalidad($idTramite);
            $EntidadNacimiento = TramiteEntidadNacimiento($idTramite);
            $idTipoSolicitud = TipoSolicitud($IdPrograma);
            $IdDpto = nitavu_dpto($nitavu);
            $Nombre = $Nombres.' '.$Apellido1.' '.$Apellido2;
            $IdDelegacion = obtenerDelegacionTramite($idTramite);
            
            $sql = "INSERT INTO solicitudestemp(IdSolicitud, IdTipoSolicitud, Curp, NitavuCaptura,Fecha,Hora, DptoCaptura, NombreBeneficiario, IdPrograma, IdDelegacion) 
            VALUES ('".$FolioTramite."', '".$idTipoSolicitud."', '".$CURP."','".$nitavu."', '".$fecha."','".$hora."', '".$IdDpto."', '".$Nombre."', ".$idPrograma.", ".$IdDelegacion.")";
            //echo $sql;
            if ($conexion->query($sql) == TRUE){
                historia($nitavu,"solicitudes: Guardo la solicitud con Folio desde la aplicacion presolicitudes " . $FolioTramite."");
                nsolicitud(FALSE);  
                //echo "<script>NPush('Se ha Iniciado la Solicitud ' + '".$FolioTramite."', 'Plataforma ITAVU')</script>";
                                        //Guardamos los datos principales
                if (GuardarSolicitudDato($FolioTramite, 0, $CURP, "text", $nitavu, 1,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 1, $Nombres, "text", $nitavu, 1,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: Nombres');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 2, $Apellido1, "text", $nitavu, 1,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito:Apellido1');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 3, $Apellido2, "text", $nitavu, 1,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: Apellido2');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 4, $Sexo, "text", $nitavu, 1,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: sexo');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 5, $FechaNacimiento, "date", $nitavu, 1,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: FechaNacimiento');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 8, $StatusCurp, "text", $nitavu, 1,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: StatusCURP');</script>"; }

                if (GuardarSolicitudDato($FolioTramite, 6, $Nacionalidad, "text", $nitavu, 1,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: Nacionalidad');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 7, TramiteDato($idTramite, 99, 0), "text", $nitavu, 1,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: Entidad de Nacimiento');</script>"; }
                //clase 0 para los datos del beneficiario
                if (GuardarSolicitudDato($FolioTramite, 51, TramiteDato($idTramite, 18, 0), "text", $nitavu, 8,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 72, TramiteDato($idTramite, 20, 0), "text", $nitavu, 8,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 34, TramiteDato($idTramite, 22, 0).' '.TramiteDato($idTramite, 21, 0), "text", $nitavu, 13,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 35, TramiteDato($idTramite, 24, 0), "text", $nitavu, 5,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 36, TramiteDato($idTramite, 23, 0), "text", $nitavu, 5,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 33, TramiteDato($idTramite, 25, 0), "text", $nitavu, 5,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 37, TramiteDato($idTramite, 26, 0), "text", $nitavu, 5,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 38, TramiteDato($idTramite, 27, 0), "text", $nitavu, 5,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 87, obtenerAhorroPrevioTramite($idTramite), "text", $nitavu, 11,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }


                //clase 1 para los datos de la referencia1
                if (GuardarSolicitudDato($FolioTramite, 1, TramiteDato($idTramite, 1, 1), "text", $nitavu, 12,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 2, TramiteDato($idTramite, 2, 1), "text", $nitavu, 12,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 3, TramiteDato($idTramite, 3, 1), "text", $nitavu, 12,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 34, TramiteDato($idTramite, 22, 1).' '.TramiteDato($idTramite, 21, 1).' '.TramiteDato($idTramite, 24, 1), "text", $nitavu, 12,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 51, TramiteDato($idTramite, 18, 1), "text", $nitavu, 12,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }

                //clase 2 para los datos de la referencia2
                if (GuardarSolicitudDato($FolioTramite, 1, TramiteDato($idTramite, 1, 2), "text", $nitavu, 13,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 2, TramiteDato($idTramite, 2, 2), "text", $nitavu, 13,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 3, TramiteDato($idTramite, 3, 2), "text", $nitavu, 13,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 34, TramiteDato($idTramite, 22, 2).' '.TramiteDato($idTramite, 21, 1).' '.TramiteDato($idTramite, 24, 1), "text", $nitavu, 13,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 51, TramiteDato($idTramite, 18, 2), "text", $nitavu, 13,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }

                //clase 3 para los datos del conyuge
                $sexoCony=  TramiteDato($idTramite, 4, 3);
                if($sexoCony=='M'){
                    $sexoCony = 1;
                }else{
                    $sexoCony = 2;
                }
                if (GuardarSolicitudDato($FolioTramite, 0, TramiteDato($idTramite, 0, 3), "text", $nitavu, 3,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 1, TramiteDato($idTramite, 1, 3), "text", $nitavu, 3,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 2, TramiteDato($idTramite, 2, 3), "text", $nitavu, 3,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 3, TramiteDato($idTramite, 3, 3), "text", $nitavu, 3,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 4, $sexoCony, "text", $nitavu, 3,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 5, TramiteDato($idTramite, 5, 3), "text", $nitavu, 3,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 6, TramiteDato($idTramite, 6, 3), "text", $nitavu, 3,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 7, TramiteDato($idTramite, 99, 3), "text", $nitavu, 3,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }
                if (GuardarSolicitudDato($FolioTramite, 8, TramiteDato($idTramite, 8, 3), "text", $nitavu, 3,1) == FALSE) {echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; }

                echo '<script> NPush("Se ha Iniciado la Solicitud para:'.$CURP.'-'.$Nombre.'", "PLataforma ITAVU")</script>';
            }
            else {
                echo '<script> NPush("ERROR: No se pudo crear la solicitud para:'.$CURP.'-'.$Nombre.'", "PLataforma ITAVU")</script>';
            }
            
            
            echo 'TRUE';
             
        } else {
            echo 'FALSE';
        }
        
    }else{
       echo  $Continuo;
        echo "<script>
               NPush('ERROR: No fue posible aprobar el trámite ".$NombreDelArchivoDeEjecucion."','Plataforma ITAVU');
            </script>";
    }


?>
