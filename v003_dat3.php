<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");

$IdCat = $_POST['IdCat']; 
$IdRequisito= $_POST['IdRequisito'];
$CURP = $_POST['txtCURP'];
$nitavu= $_POST['nitavu'];
$FolioTramite= $_POST['FolioTramite'];
$IdTipoSolicitud = $_POST['IdTipoSolicitud'];
$IdDpto = nitavu_dpto($nitavu);
$arr = $_POST['variables'];
$Nombre = $_POST['Nombre'];

    //Guardamos los datos principales
    for ($i = 0; $i < sizeof($arr); $i++){
        //FECHA DE NACIMIENTO
        if($i == 5){
            $fechaFormatoMysql = ConvertirFechaParaMySQL($arr[$i]);
            if (GuardarSolicitudDato($FolioTramite, 5, $fechaFormatoMysql, "date", $nitavu, $IdCat,1) == FALSE) {
                echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: FechaNacimiento');</script>"; 
            }else{
                echo "<script>console.log('Se guardo el dato correctamente: ".$arr[$i]."');</script>"; 
            }
        }else{
            //SI EL REQUISITO ES SEXO
            if($i==4){
                if($arr[$i]=='M'){
                    if (GuardarSolicitudDato($FolioTramite, $i, 1, "text", $nitavu, $IdCat,1) == FALSE) {
                        echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; 
                    }else{
                        echo "<script>console.log('Se guardo el dato correctamente: ".$arr[$i]."');</script>"; 
                    }
                }else{
                    if (GuardarSolicitudDato($FolioTramite, $i, 2, "text", $nitavu, $IdCat,1) == FALSE) {
                        echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; 
                    }else{
                        echo "<script>console.log('Se guardo el dato correctamente: ".$arr[$i]."');</script>"; 
                    }
                } 
            //SI ES CUALQUIER OTRO REQUISITO 
            }else{
                if (GuardarSolicitudDato($FolioTramite, $i, $arr[$i], "text", $nitavu, $IdCat,1) == FALSE) {
                    echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito: CURP');</script>"; 
                }else{
                    echo "<script>console.log('Se guardo el dato correctamente: ".$arr[$i]."');</script>"; 
                }
            }
            
        }
    }
?>