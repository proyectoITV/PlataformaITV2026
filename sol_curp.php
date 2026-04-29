<?php 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");


    $nitavu = $_POST['nitavu'];

    $IdRequisito = $_POST['IdRequisito']; if (ValidaVAR($IdRequisito)==TRUE){$IdRequisito = LimpiarVAR($IdRequisito);} else {$IdRequisito = "";}
    $IdCat = $_POST['IdCat']; if (ValidaVAR($IdCat)==TRUE){$IdCat = LimpiarVAR($IdCat);} else {$IdCat = "";}
    $txtCURP = $_POST['txtCURP']; if (ValidaVAR($txtCURP)==TRUE){$txtCURP = LimpiarVAR($txtCURP);} else {$txtCURP = "";}
    // if (ValidaVAR($FolioTramite)==TRUE){$FolioTramite = LimpiarVAR($FolioTramite);} else {$FolioTramite = "";}
    $Usuario = $nitavu;
    

    $ResultadoDelCURP = CURP($txtCURP, $Usuario);  
    $c = 1; $array = json_decode($ResultadoDelCURP, true);
    $exito=FALSE;
    if(is_array($array)){                    
        foreach ($array as $value) {
            if ($c==1){
                if ($value==1){
                    $exito = TRUE;
                    
                }
                $c=$c+1;
            } 
            else {
                
                if ($exito == TRUE){
                    $StatusCurp = $value['statusCurp'];
                        //Validamos el Estado del CURP
                    $ErrorDelCurp = "";
                    switch ($StatusCurp) {
                    case "BD": $ErrorDelCurp = "Baja por Defuncion"; break;
                    case "BDA":$ErrorDelCurp = "Baja por duplicidad";break;
                    case "BCC":$ErrorDelCurp = "Baja por Cambio en CURP"; break;
                    case "BCN":$ErrorDelCurp = "Baja no afectando a CURP"; break;
                    default: $ErrorDelCurp = "";
                    }
                                           
                    if ($ErrorDelCurp == ''){ // si no teiene errores el CURP continuamos
                        //Guardamos los valores en los campos que se requieran
                        echo "".$value['CURP'].",".$value['nombres'].",".$value['apellido1'].",".$value['apellido2'].",".$value['sexo'].",".$value['fechNac'].",".$value['nacionalidad'].",".$value['numEntidadReg'].",".$value['statusCurp']."";
                    
                    }else{
                        echo "<script>$.toast({
                            heading: 'Warning',
                            text: 'Error al calcular el CURP ".$txtCURP.", verifique que este correctamente la captura;)',
                            showHideTransition: 'plain',
                            icon: 'warning'
                        });</script>";
                    }
                            

                }else{
                    echo "<script>$.toast({
                        heading: 'Warning',
                        text: 'Error al calcular el CURP ".$txtCURP.", verifique que este correctamente la captura;)',
                        showHideTransition: 'plain',
                        icon: 'warning'
                    });</script>";
                }
            }
        }
  
    }   


?>


