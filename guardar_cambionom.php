<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>

<?php
if(isset($_POST['delegaciones']) and isset($_POST['programa']) and isset($_POST['_folio']) ){
    $IdDelegacion = $_POST['delegaciones'];
    $IdPrograma = $_POST['programa'];
    $Folio = $_POST['_folio'];
    $Nombre = $_POST['nombre'];
    $Paterno = $_POST['ap'];
    $Materno = $_POST['am'];
    $FechaNac = $_POST['fechan'];
    $Sexo = $_POST['sexo'];
    if ($Sexo == 'M'){
        $Sexo = 1;
    }else{
        $Sexo = 2;
    }
    $Nacionalidad = $_POST['nacionalidad'];
    $CURP = $_POST['_curp'];
    $tipoPrograma = tipoTramitePrograma($IdPrograma);
        
    $NumContrato = buscarSiYaTieneContratoActivoOno($IdDelegacion, $IdPrograma, $Folio);

    $contratocancelado=ContratoCancelado($NumContrato, $IdDelegacion, $IdDelegacion);

    $IdSolicitante = buscarIdSolicitante($IdPrograma, $IdDelegacion, $Folio);

    //echo $CURP.'<br>';
    //echo $IdSolicitante;
    if($CURP == $IdSolicitante){
        mensaje('ERROR: Estas intentando ingresar el mismo beneficiario para esta solicitud.','cambiar_nombre.php');
    }else{
         //primero hay que revisar que el solicitante que quiere ingresar, no exista en la base de datos
        if(existeIdSolicitanteenSolicitantes($IdSolicitante)== ""){
            $sql = "UPDATE solicitantes SET Nombre = '".$Nombre."', Paterno = '".$Paterno."', Materno='".$Materno."', FNacimiento = '".$FechaNac."', IdSexo = '".$Sexo."', NacionalidadSol = '".$Nacionalidad."', CURP = '".$CURP."', FechaUltimaMod=NOW(), IdEmpModifica='".$nitavu."', IdSolicitante= '".$CURP."' WHERE IdSolicitante = '".$IdSolicitante."'";
            echo $sql;
            if ($Vivienda->query($sql) == TRUE) {
                $sql1 = "UPDATE solicitudes SET IdSolicitante = '".$CURP."', FechaUltimaMod=now(), IdEmpModifica='".$nitavu."' WHERE IdDelegacion = ".$IdDelegacion." and IdPrograma = ".$IdPrograma." and Folio = ".$Folio."";
                echo $sql1;
                if ($Vivienda->query($sql1) == TRUE) {
                    historia($nitavu,"Modifique al solicitante ".$IdSolicitante." con estos nuevos datos ".$CURP.", y la solcitud Folio ".$Folio.", IdDelegacion=".$IdDelegacion.", IdPrograma=".$IdPrograma."");
                    mensaje('Se han guardado los datos correctamente.', 'cambiar_nombre.php');
                }else{
                    mensaje('ERROR: hubo un problema, favor de intentarlo nuevamente.', 'cambiar_nombre.php');

                }
            }else{
                mensaje('ERROR: hubo un problema, favor de intentarlo nuevamente.', 'cambiar_nombre.php');
            }
        }else{
            $sql = "UPDATE solicitantes SET Nombre = '".$Nombre."', Paterno = '".$Paterno."', Materno='".$Materno."', FNacimiento = '".$FechaNac."', IdSexo = '".$Sexo."', NacionalidadSol = '".$Nacionalidad."', CURP = '".$CURP."', FechaUltimaMod=NOW(), IdEmpModifica='".$nitavu."' WHERE IdSolicitante = '".$CURP."'";
            echo $sql;
            if ($Vivienda->query($sql) == TRUE) {
                $sql1 = "UPDATE solicitudes SET IdSolicitante = '".$CURP."', FechaUltimaMod=now(), IdEmpModifica='".$nitavu."' WHERE IdDelegacion = ".$IdDelegacion." and IdPrograma = ".$IdPrograma." and Folio = ".$Folio."";
                echo $sql1;
                if ($Vivienda->query($sql1) == TRUE) {
                    historia($nitavu,"Modifique al solicitante ".$IdSolicitante." con estos nuevos datos ".$CURP.", y la solcitud Folio ".$Folio.", IdDelegacion=".$IdDelegacion.", IdPrograma=".$IdPrograma."");
                    mensaje('Se han guardado los datos correctamente.', 'cambiar_nombre.php');
                }else{
                    mensaje('ERROR: hubo un problema, favor de intentarlo nuevamente.', 'cambiar_nombre.php');

                }
            }else{
                mensaje('ERROR: hubo un problema, favor de intentarlo nuevamente.', 'cambiar_nombre.php');
            }
        // mensaje('ERROR: el solicitante que intentas introduci, ya se encuentra registrado.', 'cambiar_nombre.php');

        }
    }
    
}else{
    mensaje('No se recibieron correctamente los datos, intentelo de nuevo.','cambiar_nombre.php');

    
}

?>
<?php include ("lib/body_footer.php"); ?>