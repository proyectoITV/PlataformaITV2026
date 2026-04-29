<?php
require("seguridad.php");
require("components.php");
require_once("config.php");
require_once("lib/funciones.php");

// error_reporting(0); //<-- para simular produccion

// $FechaNomina = VarClean($_POST['FechaNomina']);
// $IdEmpleado = VarClean($_POST['IdEmpleado']);
// $FechaNominaString = str_replace("-", "", $FechaNomina);

$Review=FALSE;


// if(!empty($_FILES)){     
//     $upload_dir = "uploads/";
//     $fileName = $_FILES['file']['name'];
//     $uploaded_file = $upload_dir.$fileName;    
//     if(move_uploaded_file($_FILES['file']['tmp_name'],$uploaded_file)){
//         //Insertamos la informacion en la tabla
//         $mysql_insert = "INSERT INTO uploads (file_name, upload_time)VALUES('".$fileName."','".date("Y-m-d H:i:s")."')";
//         mysqli_query($conn, $mysql_insert) or die("database error:". mysqli_error($conn));
//     }   
// }

foreach( $_FILES['File_XML']['tmp_name'] as $key => $tmp_name)
{
        if ( $_FILES['File_XML']['error'][$key] > 0 ) {
            echo '
            <div class="alert alert-danger" role="alert">
                Error: al subir el archivo XML '.$_FILES['File_XML']['error'][$key]. '
            </div>';

        }
        else {
            $path = $_FILES['File_XML']['name'][$key];
            $ext = pathinfo($path, PATHINFO_EXTENSION);
            
            if ($ext == 'xml'){
                //Desencriptado
                $msg = "";
                $archivo_xml = $_FILES['File_XML']['tmp_name'][$key];
                $xmlCont = file_get_contents($archivo_xml);

                $FechaNomina = XML_FechadeNomina($xmlCont);
                $FechaNominaString = str_replace("-", "", $FechaNomina);
                $IdEmpleado = XML_IdEmpleado($xmlCont);
                $FechaInicial = XML_FechaInicial($xmlCont);
                $FechaFinal = XML_FechaFinal($xmlCont);
                // var_dump($FechaNomina);
                
                // // addslashes() // escapa
                // // stripslashes() // quita los caracteres escapados
                $ArchivoNominaXML = 'nominas/'.$IdEmpleado."_".$FechaNominaString.".xml";    
                if (move_uploaded_file($_FILES['File_XML']['tmp_name'][$key], $ArchivoNominaXML)){
                    $msg = $msg."<br>"."Se ha subido correctamente el archivo .".$ArchivoNominaXML;

                    $NominaFile="";
                    $NominaFile = NominaFile($IdEmpleado, $FechaNomina);
                    // var_dump($NominaFile);
                    if ($NominaFile == ''){                    
                            $sql = "
                            INSERT INTO nominas(nitavu, FechaNomina, fecha, hora, iduser, File, FechaPagoInicial, FechaPagoFinal)
                            VALUES (
                                '".$IdEmpleado."',".                         
                                "'".$FechaNomina."',".
                                "'".$fecha."',".
                                "'".$hora."',".
                                "'".$nitavu."',".
                                "'".$ArchivoNominaXML."',".
                                "'".$FechaInicial."',".
                                "'".$FechaFinal."'".
                                
                                
                                
                                ")";    
                                // echo $sql;
                            if ($conexion->query($sql) == TRUE){
                                $Review = TRUE;

                                $Sueldo =  XML_Percepciones_Total($xmlCont); Sueldo_update($IdEmpleado, $Sueldo);
                                $ImpRetenidos =  XML_ImpuestosRetenidos_Total($xmlCont); ImpuestosRetenidos_update($IdEmpleado, $ImpRetenidos);
                                $Deducciones =  XML_Deducciones_Total($xmlCont); Deducciones_update($IdEmpleado, $Deducciones);
                                $InicioLaboral =  XML_FechaInicioLaboral($xmlCont); InicioLaboral_update($IdEmpleado, $InicioLaboral);
                                

                                Toast("Subido correctamente el XML de ".$FechaNomina." de ".nitavu_nombre($IdEmpleado),4,"");
                                historia($nitavu,"Subio la nomina XML de ".nitavu_nombre($IdEmpleado)." (".$IdEmpleado.") de ".$FechaNomina);
                            } else {
                                
                                Toast("ERROR al guardar el XML de ".$FechaNomina." de ".nitavu_nombre($IdEmpleado),2,"");
                            }
                    } else { //Actualizamos
                                         
                            $sql = "
                            UPDATE nominas
                            SET  
                                fecha='".$fecha."',
                                hora='".$hora."',
                                iduser='".$nitavu."'
                            
                            WHERE nitavu='".$IdEmpleado."' and FechaNomina='".$FechaNomina."'
                            ";                                
                            // echo $sql;
                            if ($conexion->query($sql) == TRUE){
                                $Review = TRUE;
                                Toast("Actualizo correctamente el XML de ".$FechaNomina." de ".nitavu_nombre($IdEmpleado),1,"");
                                historia($nitavu,"Actualizo la nomina XML de ".nitavu_nombre($IdEmpleado)." (".$IdEmpleado.") de ".$FechaNomina);
                            } else {
                                
                                Toast("ERROR al guardar el XML de ".$FechaNomina." de ".nitavu_nombre($IdEmpleado),2,"");
                            }
                        
                    }



                       
                    $asunto = "Tu nomina del ".$FechaNomina." (ITAVU)";
                    $contenido = "
                        <p>Estimado <b> ".nitavu_nombre($IdEmpleado).":</b><br>
                        ".nitavu_puesto($IdEmpleado)." de ".nitavu_dpto_nombre($IdEmpleado)."<br>
                        
                        </p>
                    

                        <p>Le informamos que ya esta disponible la descarga y consulta de su nomina.</p>


                        <p> Puede consultarla en su navegador de internet entrando a la siguiente pagina: <a href='https://plataformaitavu.tamaulipas.gob.mx/minomina'>https://plataformaitavu.tamaulipas.gob.mx/minomina</a>

                        <br><br>

                        Los datos de acceso son los mismos que en la Plataforma del Instituto:<br>
                        <table><tr><td>        
                        Usuario: <b>".$IdEmpleado."</b></td><td>
                        Contraseña: <b style='color:red;'>".nitavu_nip($IdEmpleado)."</b></td></tr></table>
                        </p>
                        
                        
                        <p>
                        <p>
                        <b>Atte. <br>
                        Ing. Sergio Cruz Hernandez<br>
                        <b>Dpt. de Contabilidad</b>
                        
                        
                        </b> 
                        <p style='font-size:8pt;'>NOTA: Este es un correo generado por la Plataforma al subir los archivos de nomina.</p>
                    ";
                        
                    if (correo(nitavu_correo($IdEmpleado), nitavu_nombre($IdEmpleado), 'itavu.informatica@tam.gob.mx', 'Dpto. de Contabilidad ITAVU', $asunto, $contenido, $nitavu)==TRUE){
                    // if (correo(nitavu_correo($IdEmpleado), nitavu_nombre($IdEmpleado), 'jesus.uresti@tam.gob.mx', 'Dpto. de Contabilidad ITAVU', $asunto, $contenido, $nitavu)==TRUE){
                        sleep(1);
                        Toast("Se envio correo a ".nitavu_nombre($IdEmpleado)." informandole la disponibilidad de su archivo de nomina",0,"");
                    } else {
                        Toast("Hubo un problema al enviarle correo a ".nitavu_nombre($IdEmpleado)."",2,"");

                    }


                } else {
                    $msg = $msg."<br>problemas para subir el archivo ".$_FILES['File_XML']['tmp_name'][$key];
                }
                
                // Toast($msg."(".$FechaNomina." de ".nitavu_nombre($IdEmpleado).")",0,"");
                



















            } else {
                Toast("Archivo no Valido (".$_FILES['File_XML']['name'][$key].")",2,"");
            }
       
        }

echo "<script>
$('#txtFechaNomina').val('".$FechaNomina."');
ReloadContenido();</script>";    
}
sleep(1);
if ($Review == TRUE) { // si todo salio bien recargar contenido con la fecha

    // $Contenido = "<h3>Nomina detectada de <b>".$FechaNomina."</b></h3>";
    // echo "<script>$('#Contenido').html('$Contenido')</script>";
//     $FechaNomina = VarClean($_POST['FechaNomina']);
// $IdEmpleado = VarClean($_POST['IdEmpleado']);
// $FechaNominaString = str_replace("-", "", $FechaNomina);
 
    
    
}

?>