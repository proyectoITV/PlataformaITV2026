<?php 
require("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require_once("lib/yes_funciones.php");
?>
<br><br>
<?php

$idDepartamento=nitavu_dpto($nitavu);
$id_aplicacion ="ap87";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    $IdRequisito = $_POST['IdRequisito']; if (ValidaVAR($IdRequisito)==TRUE){$IdRequisito = LimpiarVAR($IdRequisito);} else {$IdRequisito = "";}
    $IdClase = $_POST['IdClase']; if (ValidaVAR($IdClase)==TRUE){$IdClase = LimpiarVAR($IdClase);} else {$IdClase = "";}
    $txtCURP = $_POST['txtCURP']; if (ValidaVAR($txtCURP)==TRUE){$txtCURP = LimpiarVAR($txtCURP);} else {$txtCURP = "";}
    $FolioTramite = $_POST['FolioTramite']; if (ValidaVAR($FolioTramite)==TRUE){$FolioTramite = LimpiarVAR($FolioTramite);} else {$FolioTramite = "";}
    $Usuario = $nitavu;
    

    
    
    
    $ResultadoDelCURP = CURP($txtCURP, $Usuario);  $c = 1; $array = json_decode($ResultadoDelCURP, true);
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
                
                if ($exito == TRUE)
                {
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
                     
                    
                        if(validarCurpUtilizado($FolioTramite,$txtCURP)<>0)
                        {
                            echo "<script>$.toast({
                                heading: 'Warning',
                                text: 'Error:  Error al Guardar el Curp ".$txtCURP.",No pudes duplicar un CURP en un mismo trámite!;)',
                                showHideTransition: 'plain',
                                icon: 'warning'
                            });</script>";
                        }
                        else{
                            
                        
                            if ($ErrorDelCurp == ''){ // si no teiene errores el CURP continuamos
                
                            //Guardamos los valores en los campos que se requieran
                            
                            //---- CURP
                            $IdRequisitoSave =  $IdRequisito; //<-- Es el requisito de origien que es 0, la IdClase sera la misma de origen
                            $Dato = $txtCURP; //<-- Curp encontrado
                            $TipoRequisito = TramiteRequisitoTipo($IdRequisitoSave, $IdClase);
                             if (GuardarTramiteDato($FolioTramite, $IdRequisitoSave, $Dato, $TipoRequisito, $Usuario, $IdClase) == FALSE){ //<-- Guarda el campo
                                echo "<script>$.toast({
                                    heading: 'Warning',
                                    text: 'Error:  Error al Guardar el Curp ".$txtCURP.", con status: ".$ErrorDelCurp.", Dato: ".$Dato.". Verifique que este correctamente la captura!;)',
                                    showHideTransition: 'plain',
                                    icon: 'warning'
                                });</script>";
                             } else  {
                                //>>> Escribir valores en los input
                                echo "<script>$('#".$IdRequisitoSave."_".$IdClase."').val('".$Dato."');</script> ";
                             }
                
                            //--- Nombre
                            $IdRequisitoSave =  1; //<-- Es el requisito de origien que es 0, la IdClase sera la misma de origen
                            $Dato = $value['nombres']; //<-- Curp encontrado
                            $TipoRequisito = TramiteRequisitoTipo($IdRequisitoSave, $IdClase);
                            if (GuardarTramiteDato($FolioTramite, $IdRequisitoSave, $Dato, $TipoRequisito, $Usuario, $IdClase) == FALSE) //<-- Guarda el campo
                            {
                                echo "<script>$.toast({
                                    heading: 'Warning',
                                    text: 'Error:  Error al Guardar el Curp ".$txtCURP.", con status: ".$ErrorDelCurp.", Dato: ".$Dato.". Verifique que este correctamente la captura!;)',
                                    showHideTransition: 'plain',
                                    icon: 'warning'
                                });</script>";
                             } else  {
                                //>>> Escribir valores en los input
                                echo "<script>$('#".$IdRequisitoSave."_".$IdClase."').val('".$Dato."');</script> ";
                             }
                
                
                            //--- Apellido Paterno
                            $IdRequisitoSave =  2; //<-- Es el requisito de origien que es 0, la IdClase sera la misma de origen
                            $Dato = $value['apellido1']; //<-- Curp encontrado
                            $TipoRequisito = TramiteRequisitoTipo($IdRequisitoSave, $IdClase);
                            if (GuardarTramiteDato($FolioTramite, $IdRequisitoSave, $Dato, $TipoRequisito, $Usuario, $IdClase) == FALSE) //<-- Guarda el campo
                            {
                                echo "<script>$.toast({
                                    heading: 'Warning',
                                    text: 'Error:  Error al Guardar el Curp ".$txtCURP.", con status: ".$ErrorDelCurp.", Dato: ".$Dato.". Verifique que este correctamente la captura!;)',
                                    showHideTransition: 'plain',
                                    icon: 'warning'
                                });</script>";
                             } else  {
                                //>>> Escribir valores en los input
                                echo "<script>$('#".$IdRequisitoSave."_".$IdClase."').val('".$Dato."');</script> ";
                             }
                
                
                            //--- Apellido Materno
                            $IdRequisitoSave =  3; //<-- Es el requisito de origien que es 0, la IdClase sera la misma de origen
                            $Dato = $value['apellido2']; //<-- Curp encontrado
                            $TipoRequisito = TramiteRequisitoTipo($IdRequisitoSave, $IdClase);
                            if (GuardarTramiteDato($FolioTramite, $IdRequisitoSave, $Dato, $TipoRequisito, $Usuario, $IdClase)==FALSE) //<-- Guarda el campo
                            {
                                echo "<script>$.toast({
                                    heading: 'Warning',
                                    text: 'Error:  Error al Guardar el Curp ".$txtCURP.", con status: ".$ErrorDelCurp.", Dato: ".$Dato.". Verifique que este correctamente la captura!;)',
                                    showHideTransition: 'plain',
                                    icon: 'warning'
                                });</script>";
                             } else  {
                                //>>> Escribir valores en los input
                                echo "<script>$('#".$IdRequisitoSave."_".$IdClase."').val('".$Dato."');</script> ";
                             }
                
                            //---  Sexo
                            $IdRequisitoSave =  4; //<-- Es el requisito de origien que es 0, la IdClase sera la misma de origen
                            $Dato = $value['sexo']; //<-- Curp encontrado
                            $TipoRequisito = TramiteRequisitoTipo($IdRequisitoSave, $IdClase);
                            if (GuardarTramiteDato($FolioTramite, $IdRequisitoSave, $Dato, $TipoRequisito, $Usuario, $IdClase) == FALSE) //<-- Guarda el campo
                            {
                                echo "<script>$.toast({
                                    heading: 'Warning',
                                    text: 'Error:  Error al Guardar el Curp ".$txtCURP.", con status: ".$ErrorDelCurp.", Dato: ".$Dato.". Verifique que este correctamente la captura!;)',
                                    showHideTransition: 'plain',
                                    icon: 'warning'
                                });</script>";
                             } else  {
                                //>>> Escribir valores en los input
                                echo "<script>$('#".$IdRequisitoSave."_".$IdClase."').val('".$Dato."');</script> ";
                             }
                
                
                            //---  Fecha Nacimiento
                            $IdRequisitoSave =  5; //<-- Es el requisito de origien que es 0, la IdClase sera la misma de origen
                            $Dato = ConvertirFechaParaMySQL($value['fechNac']); //<-- Curp encontrado
                            
                            $TipoRequisito = TramiteRequisitoTipo($IdRequisitoSave, $IdClase);
                            if (GuardarTramiteDato($FolioTramite, $IdRequisitoSave, $Dato, $TipoRequisito, $Usuario, $IdClase) == FALSE) //<-- Guarda el campo
                            {
                                echo "<script>$.toast({
                                    heading: 'Warning',
                                    text: 'Error:  Error al Guardar el Curp ".$txtCURP.", con status: ".$ErrorDelCurp.", Dato: ".$Dato.". Verifique que este correctamente la captura!;)',
                                    showHideTransition: 'plain',
                                    icon: 'warning'
                                });</script>";
                             } else  {
                                //>>> Escribir valores en los input
                                echo "<script>$('#".$IdRequisitoSave."_".$IdClase."').val('".$Dato."');</script> ";
                             }
                
                
                            //---  Nacionalidad
                            $IdRequisitoSave =  6; //<-- Es el requisito de origien que es 0, la IdClase sera la misma de origen
                            $Dato = $value['nacionalidad']; //<-- Curp encontrado
                            $TipoRequisito = TramiteRequisitoTipo($IdRequisitoSave, $IdClase);
                            if (GuardarTramiteDato($FolioTramite, $IdRequisitoSave, $Dato, $TipoRequisito, $Usuario, $IdClase)== FALSE) //<-- Guarda el campo
                            {
                                echo "<script>$.toast({
                                    heading: 'Warning',
                                    text: 'Error:  Error al Guardar el Curp ".$txtCURP.", con status: ".$ErrorDelCurp.", Dato: ".$Dato.". Verifique que este correctamente la captura!;)',
                                    showHideTransition: 'plain',
                                    icon: 'warning'
                                });</script>";
                             } else  {
                                //>>> Escribir valores en los input
                                echo "<script>$('#".$IdRequisitoSave."_".$IdClase."').val('".$Dato."');</script> ";
                             }
                
                
                            //---  Entidad Federativa de Nacimiento
                            $IdRequisitoSave =  7; //<-- Es el requisito de origien que es 0, la IdClase sera la misma de origen
                            $Dato = $value['nombreEntidadNac']; //<-- Curp encontrado
                            $TipoRequisito = TramiteRequisitoTipo($IdRequisitoSave, $IdClase);
                            if (GuardarTramiteDato($FolioTramite, $IdRequisitoSave, $Dato, $TipoRequisito, $Usuario, $IdClase) == FALSE) //<-- Guarda el campo
                            {
                                echo "<script>$.toast({
                                    heading: 'Warning',
                                    text: 'Error:  Error al Guardar el Curp ".$txtCURP.", con status: ".$ErrorDelCurp.", Dato: ".$Dato.". Verifique que este correctamente la captura!;)',
                                    showHideTransition: 'plain',
                                    icon: 'warning'
                                });</script>";
                             } else  {
                                //>>> Escribir valores en los input
                                // echo "<script>$('#".$IdRequisitoSave."_".$IdClase."').val('".$Dato."');</script> ";
                                echo "<script>$('#".$IdRequisitoSave."_".$IdClase."').prepend('<option value=".$Dato." selected >".$Dato."</option>');</script>";
                             }
                
                
                
                            //---  Status del CURP
                            $IdRequisitoSave =  8; //<-- Es el requisito de origien que es 0, la IdClase sera la misma de origen
                            $Dato = $value['statusCurp']; //<-- Curp encontrado
                            $TipoRequisito = TramiteRequisitoTipo($IdRequisitoSave, $IdClase);
                            if (GuardarTramiteDato($FolioTramite, $IdRequisitoSave, $Dato, $TipoRequisito, $Usuario, $IdClase) == FALSE) //<-- Guarda el campo
                            {
                                echo "<script>$.toast({
                                    heading: 'Warning',
                                    text: 'Error:  Error al Guardar el Curp ".$txtCURP.", con status: ".$ErrorDelCurp.", Dato: ".$Dato.". Verifique que este correctamente la captura!;)',
                                    showHideTransition: 'plain',
                                    icon: 'warning'
                                });</script>";
                             } else  {
                                //>>> Escribir valores en los input
                                echo "<script>$('#".$IdRequisitoSave."_".$IdClase."').val('".$Dato."');</script> ";
                             }

                              //---  Status del CURP
                            $IdRequisitoSave =  99; //<-- Es el requisito de origien que es 0, la IdClase sera la misma de origen
                            $Dato = $value['numEntidadReg']; //<-- Curp encontrado
                            $TipoRequisito = TramiteRequisitoTipo($IdRequisitoSave, $IdClase);
                            if (GuardarTramiteDato($FolioTramite, $IdRequisitoSave, $Dato, $TipoRequisito, $Usuario, $IdClase) == FALSE) //<-- Guarda el campo
                            {
                                echo "<script>$.toast({
                                    heading: 'Warning',
                                    text: 'Error:  Error al Guardar el Curp ".$txtCURP.", con status: ".$ErrorDelCurp.", Dato: ".$Dato.". Verifique que este correctamente la captura!;)',
                                    showHideTransition: 'plain',
                                    icon: 'warning'
                                });</script>";
                             } else  {
                                //>>> Escribir valores en los input
                                echo "<script>$('#".$IdRequisitoSave."_".$IdClase."').val('".$Dato."');</script> ";
                             }
                
                 
                }
                else{
                        echo "<script>$.toast({
                            heading: 'Warning',
                            text: 'Error al calcular el CURP ".$txtCURP.", verifique que este correctamente la captura;)',
                            showHideTransition: 'plain',
                            icon: 'warning'
                        });</script>";
                    }
                }

                }
                else{
                        echo "<script>$.toast({
                            heading: 'Warning',
                            text: 'Error al calcular el CURP ".$txtCURP.", verifique que este correctamente la captura;)',
                            showHideTransition: 'plain',
                            icon: 'warning'
                        });</script>";
                    }
            }
        }
    // if(is_array($array)){ foreach ($array as $value) {if ($c==2){

    //     $StatusCurp = $value['statusCurp'];
    //      //Validamos el Estado del CURP
    //     $ErrorDelCurp = "";
    //     switch ($StatusCurp) {
    //     case "BD": $ErrorDelCurp = "Baja por Defuncion"; break;
    //     case "BDA":$ErrorDelCurp = "Baja por duplicidad";break;
    //     case "BCC":$ErrorDelCurp = "Baja por Cambio en CURP"; break;
    //     case "BCN":$ErrorDelCurp = "Baja no afectando a CURP"; break;
    //     default: $ErrorDelCurp = "";
    //     }
    //     if ($ErrorDelCurp == ''){ // si no teiene errores el CURP continuamos

    //         //Guardamos los valores en los campos que se requieran
            
    //         //---- CURP
    //         $IdRequisitoSave =  $IdRequisito; //<-- Es el requisito de origien que es 0, la IdClase sera la misma de origen
    //         $Dato = $txtCURP; //<-- Curp encontrado
    //         $TipoRequisito = TramiteRequisitoTipo($IdRequisitoSave, $IdClase);
    //          if (GuardarTramiteDato($FolioTramite, $IdRequisitoSave, $Dato, $TipoRequisito, $Usuario, $IdClase) == FALSE){ //<-- Guarda el campo
    //             echo "<script>$.toast({
    //                 heading: 'Warning',
    //                 text: 'Error:  Error al Guardar el Curp ".$txtCURP.", con status: ".$ErrorDelCurp.", Dato: ".$Dato.". Verifique que este correctamente la captura!;)',
    //                 showHideTransition: 'plain',
    //                 icon: 'warning'
    //             });</script>";
    //          } else  {
    //             //>>> Escribir valores en los input
    //             echo "<script>$('#".$IdRequisitoSave."_".$IdClase."').val('".$Dato."');</script> ";
    //          }

    //         //--- Nombre
    //         $IdRequisitoSave =  1; //<-- Es el requisito de origien que es 0, la IdClase sera la misma de origen
    //         $Dato = $value['nombres']; //<-- Curp encontrado
    //         $TipoRequisito = TramiteRequisitoTipo($IdRequisitoSave, $IdClase);
    //         if (GuardarTramiteDato($FolioTramite, $IdRequisitoSave, $Dato, $TipoRequisito, $Usuario, $IdClase) == FALSE) //<-- Guarda el campo
    //         {
    //             echo "<script>$.toast({
    //                 heading: 'Warning',
    //                 text: 'Error:  Error al Guardar el Curp ".$txtCURP.", con status: ".$ErrorDelCurp.", Dato: ".$Dato.". Verifique que este correctamente la captura!;)',
    //                 showHideTransition: 'plain',
    //                 icon: 'warning'
    //             });</script>";
    //          } else  {
    //             //>>> Escribir valores en los input
    //             echo "<script>$('#".$IdRequisitoSave."_".$IdClase."').val('".$Dato."');</script> ";
    //          }


    //         //--- Apellido Paterno
    //         $IdRequisitoSave =  2; //<-- Es el requisito de origien que es 0, la IdClase sera la misma de origen
    //         $Dato = $value['apellido1']; //<-- Curp encontrado
    //         $TipoRequisito = TramiteRequisitoTipo($IdRequisitoSave, $IdClase);
    //         if (GuardarTramiteDato($FolioTramite, $IdRequisitoSave, $Dato, $TipoRequisito, $Usuario, $IdClase) == FALSE) //<-- Guarda el campo
    //         {
    //             echo "<script>$.toast({
    //                 heading: 'Warning',
    //                 text: 'Error:  Error al Guardar el Curp ".$txtCURP.", con status: ".$ErrorDelCurp.", Dato: ".$Dato.". Verifique que este correctamente la captura!;)',
    //                 showHideTransition: 'plain',
    //                 icon: 'warning'
    //             });</script>";
    //          } else  {
    //             //>>> Escribir valores en los input
    //             echo "<script>$('#".$IdRequisitoSave."_".$IdClase."').val('".$Dato."');</script> ";
    //          }


    //         //--- Apellido Materno
    //         $IdRequisitoSave =  3; //<-- Es el requisito de origien que es 0, la IdClase sera la misma de origen
    //         $Dato = $value['apellido2']; //<-- Curp encontrado
    //         $TipoRequisito = TramiteRequisitoTipo($IdRequisitoSave, $IdClase);
    //         if (GuardarTramiteDato($FolioTramite, $IdRequisitoSave, $Dato, $TipoRequisito, $Usuario, $IdClase)==FALSE) //<-- Guarda el campo
    //         {
    //             echo "<script>$.toast({
    //                 heading: 'Warning',
    //                 text: 'Error:  Error al Guardar el Curp ".$txtCURP.", con status: ".$ErrorDelCurp.", Dato: ".$Dato.". Verifique que este correctamente la captura!;)',
    //                 showHideTransition: 'plain',
    //                 icon: 'warning'
    //             });</script>";
    //          } else  {
    //             //>>> Escribir valores en los input
    //             echo "<script>$('#".$IdRequisitoSave."_".$IdClase."').val('".$Dato."');</script> ";
    //          }

    //         //---  Sexo
    //         $IdRequisitoSave =  4; //<-- Es el requisito de origien que es 0, la IdClase sera la misma de origen
    //         $Dato = $value['sexo']; //<-- Curp encontrado
    //         $TipoRequisito = TramiteRequisitoTipo($IdRequisitoSave, $IdClase);
    //         if (GuardarTramiteDato($FolioTramite, $IdRequisitoSave, $Dato, $TipoRequisito, $Usuario, $IdClase) == FALSE) //<-- Guarda el campo
    //         {
    //             echo "<script>$.toast({
    //                 heading: 'Warning',
    //                 text: 'Error:  Error al Guardar el Curp ".$txtCURP.", con status: ".$ErrorDelCurp.", Dato: ".$Dato.". Verifique que este correctamente la captura!;)',
    //                 showHideTransition: 'plain',
    //                 icon: 'warning'
    //             });</script>";
    //          } else  {
    //             //>>> Escribir valores en los input
    //             echo "<script>$('#".$IdRequisitoSave."_".$IdClase."').val('".$Dato."');</script> ";
    //          }


    //         //---  Fecha Nacimiento
    //         $IdRequisitoSave =  5; //<-- Es el requisito de origien que es 0, la IdClase sera la misma de origen
    //         $Dato = ConvertirFechaParaMySQL($value['fechNac']); //<-- Curp encontrado
            
    //         $TipoRequisito = TramiteRequisitoTipo($IdRequisitoSave, $IdClase);
    //         if (GuardarTramiteDato($FolioTramite, $IdRequisitoSave, $Dato, $TipoRequisito, $Usuario, $IdClase) == FALSE) //<-- Guarda el campo
    //         {
    //             echo "<script>$.toast({
    //                 heading: 'Warning',
    //                 text: 'Error:  Error al Guardar el Curp ".$txtCURP.", con status: ".$ErrorDelCurp.", Dato: ".$Dato.". Verifique que este correctamente la captura!;)',
    //                 showHideTransition: 'plain',
    //                 icon: 'warning'
    //             });</script>";
    //          } else  {
    //             //>>> Escribir valores en los input
    //             echo "<script>$('#".$IdRequisitoSave."_".$IdClase."').val('".$Dato."');</script> ";
    //          }


    //         //---  Nacionalidad
    //         $IdRequisitoSave =  6; //<-- Es el requisito de origien que es 0, la IdClase sera la misma de origen
    //         $Dato = $value['nacionalidad']; //<-- Curp encontrado
    //         $TipoRequisito = TramiteRequisitoTipo($IdRequisitoSave, $IdClase);
    //         if (GuardarTramiteDato($FolioTramite, $IdRequisitoSave, $Dato, $TipoRequisito, $Usuario, $IdClase)== FALSE) //<-- Guarda el campo
    //         {
    //             echo "<script>$.toast({
    //                 heading: 'Warning',
    //                 text: 'Error:  Error al Guardar el Curp ".$txtCURP.", con status: ".$ErrorDelCurp.", Dato: ".$Dato.". Verifique que este correctamente la captura!;)',
    //                 showHideTransition: 'plain',
    //                 icon: 'warning'
    //             });</script>";
    //          } else  {
    //             //>>> Escribir valores en los input
    //             echo "<script>$('#".$IdRequisitoSave."_".$IdClase."').val('".$Dato."');</script> ";
    //          }


    //         //---  Entidad Federativa de Nacimiento
    //         $IdRequisitoSave =  7; //<-- Es el requisito de origien que es 0, la IdClase sera la misma de origen
    //         $Dato = $value['nombreEntidadNac']; //<-- Curp encontrado
    //         $TipoRequisito = TramiteRequisitoTipo($IdRequisitoSave, $IdClase);
    //         if (GuardarTramiteDato($FolioTramite, $IdRequisitoSave, $Dato, $TipoRequisito, $Usuario, $IdClase) == FALSE) //<-- Guarda el campo
    //         {
    //             echo "<script>$.toast({
    //                 heading: 'Warning',
    //                 text: 'Error:  Error al Guardar el Curp ".$txtCURP.", con status: ".$ErrorDelCurp.", Dato: ".$Dato.". Verifique que este correctamente la captura!;)',
    //                 showHideTransition: 'plain',
    //                 icon: 'warning'
    //             });</script>";
    //          } else  {
    //             //>>> Escribir valores en los input
    //             // echo "<script>$('#".$IdRequisitoSave."_".$IdClase."').val('".$Dato."');</script> ";
    //             echo "<script>$('#".$IdRequisitoSave."_".$IdClase."').prepend('<option value=".$Dato." selected >".$Dato."</option>');</script>";
    //          }



    //         //---  Status del CURP
    //         $IdRequisitoSave =  8; //<-- Es el requisito de origien que es 0, la IdClase sera la misma de origen
    //         $Dato = $value['statusCurp']; //<-- Curp encontrado
    //         $TipoRequisito = TramiteRequisitoTipo($IdRequisitoSave, $IdClase);
    //         if (GuardarTramiteDato($FolioTramite, $IdRequisitoSave, $Dato, $TipoRequisito, $Usuario, $IdClase) == FALSE) //<-- Guarda el campo
    //         {
    //             echo "<script>$.toast({
    //                 heading: 'Warning',
    //                 text: 'Error:  Error al Guardar el Curp ".$txtCURP.", con status: ".$ErrorDelCurp.", Dato: ".$Dato.". Verifique que este correctamente la captura!;)',
    //                 showHideTransition: 'plain',
    //                 icon: 'warning'
    //             });</script>";
    //          } else  {
    //             //>>> Escribir valores en los input
    //             echo "<script>$('#".$IdRequisitoSave."_".$IdClase."').val('".$Dato."');</script> ";
    //          }


            


    //     } else {
    //         echo "<script>$.toast({
    //             heading: 'Warning',
    //             text: 'Error: CURP No valido ".$txtCURP.", con status: ".$ErrorDelCurp.". Verifique que este correctamente la captura!;)',
    //             showHideTransition: 'plain',
    //             icon: 'warning'
    //         });</script>";
    //     }
    //         // echo "CURP: ".$value['CURP']."<br>";
    //         // echo "Nombre: ".$value['nombres']."<br>";
    //         // echo "Apellido Paterno: ".$value['apellido1']."<br>";
    //         // echo "Apellido Materno: ".$value['apellido2']."<br>";
    //         // echo "Sexo: ".$value['sexo']."<br>";
    //         // echo "Fecha de Nacimiento: ".$value['fechNac']."<br>";
    //         // echo "Nacionalidad: ".$value['nacionalidad']."<br>";
    //         // echo "Estado del CURP: ".$value['statusCurp']."<br>";
    //         // echo "Entidad de Nacimiento: ".$value['nombreEntidadNac']."<br>";

            
            
    //     } $c= $c +1; }
    } 
    else
    { 
        echo "<script>$.toast({
            heading: 'Warning',
            text: 'Error al calcular el CURP ".$txtCURP.", verifique que este correctamente la captura;)',
            showHideTransition: 'plain',
            icon: 'warning'
        });</script>";
    }



    
    
   
  
}else{
    // mensaje('No tiene permiso para esta aplicación','index.php');
}





?>



<?php include ("./lib/body_footer.php"); ?>
