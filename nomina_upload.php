<?php
require("seguridad.php");
require("components.php");
require_once("config.php");
require_once("lib/funciones.php");

// error_reporting(0); //<-- para simular produccion

$FechaNomina = VarClean($_POST['FechaNomina']);
$IdEmpleado = VarClean($_POST['IdEmpleado']);
$FechaNominaString = str_replace("-", "", $FechaNomina);

$Review=FALSE;

if ( $_FILES['File_XML']['error'] > 0 ) {
    echo '
    <div class="alert alert-danger" role="alert">
    Error: al subir el archivo XML '.$_FILES['File_XML']['error']. '
    </div>';

}
else {
    
    if ( $_FILES['File_PDF']['error'] > 0 ) {
        echo '
        <div class="alert alert-danger" role="alert">
        Error: al subir el archivo PDF: '.$_FILES['File_PDF']['error']. '
        </div>';
    } else {

        $ArchivoNominaXML = 'nominas/'.$IdEmpleado."_".$FechaNominaString.".xml";    
        if (move_uploaded_file($_FILES['File_XML']['tmp_name'], $ArchivoNominaXML)){
    
            if (    NominaFile($IdEmpleado, $FechaNomina, 'XML') == ''  ){
            //agregar el registro
                $sql = "
                INSERT INTO nominas(nitavu, FechaNomina, FileType, fecha, hora, File,iduser)
                VALUES ('".$IdEmpleado."', '".$FechaNomina."','XML','".$fecha."','".$hora."','".$ArchivoNominaXML."','".$nitavu."')";    
                if ($conexion->query($sql) == TRUE){
                    $Review = TRUE;
                    Toast("Subido correctamente el XML de ".$FechaNomina." de ".nitavu_nombre($IdEmpleado),4,"");
                    historia($nitavu,"Subio la nomina XML de ".nitavu_nombre($IdEmpleado)." (".$IdEmpleado.") de ".$FechaNomina);
                } else {
                    echo '
                    <div class="alert alert-danger" role="alert">
                    Error: al guargar el archivo en la base de datos XML  '.$sql.'
                    </div>';
                }
            } else {
                $sql = "
                UPDATE nominas
                SET 
                fecha='".$fecha."',
                hora='".$hora."',
                iduser='".$nitavu."',
                File='".$ArchivoNominaXML."'
                WHERE nitavu ='".$IdEmpleado."' and FechaNomina='".$FechaNomina."' and FileType='XML'";
                
                if ($conexion->query($sql) == TRUE){
                    $Review = TRUE;
                    Toast("Se actualizo correctamente el XML de ".$FechaNomina." de ".nitavu_nombre($IdEmpleado),1,"");
                    historia($nitavu,"Actualizo la nomina XML de ".nitavu_nombre($IdEmpleado)." (".$IdEmpleado.") de ".$FechaNomina);
                } else {
                    echo '
                    <div class="alert alert-danger" role="alert">
                    Error: al guargar el archivo en la base de datos XML  '.$sql.'
                    </div>';
                }
            }
        } else {
            echo '
                    <div class="alert alert-danger" role="alert">
                    Error: al guargar el archivo  en el servidor XML  '.$_FILES['File_XML']['error'].'
                    </div>';
        }
        



        $ArchivoNominaPDF = 'nominas/'.$IdEmpleado."_".$FechaNominaString.".pdf";    
        if (move_uploaded_file($_FILES['File_PDF']['tmp_name'], $ArchivoNominaPDF)){
            if (NominaFile($IdEmpleado, $FechaNomina, 'PDF') == ''){
                $sql = "
                INSERT INTO nominas(nitavu, FechaNomina, FileType, fecha, hora, File, iduser)
                VALUES ('".$IdEmpleado."', '".$FechaNomina."','PDF','".$fecha."','".$hora."','".$ArchivoNominaPDF."','".$nitavu."')";    
                if ($conexion->query($sql) == TRUE){
                    $Review = TRUE;
                    SonidoBoop();
                    Toast("Subido corractamente el PDF de ".$FechaNomina." de ".nitavu_nombre($IdEmpleado),4,"");


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
                        <b>Atte. <br>
                        Ing. Sergio Cruz Hernandez<br>
                        <b>Dpt. de Contabilidad</b>
                        
                        
                        </b> 
                        
                        <br>
                       
                       
                        </p>
                
                        <p style='font-size:8pt;'>NOTA: Este es un correo generado por la Plataforma al subir los archivos de nomina.</p>
                    ";
                        
                    if (correo(nitavu_correo($IdEmpleado), nitavu_nombre($IdEmpleado), 'itavu.informatica@tam.gob.mx', 'Dpto. de Contabilidad ITAVU', $asunto, $contenido, $nitavu)==TRUE){
                    // if (correo(nitavu_correo($IdEmpleado), nitavu_nombre($IdEmpleado), 'jesus.uresti@tam.gob.mx', 'Dpto. de Contabilidad ITAVU', $asunto, $contenido, $nitavu)==TRUE){
                
                        Toast("Se envio correo a ".nitavu_nombre($IdEmpleado)." informandole la disponibilidad de su archivo de nomina",0,"");
                        
                    } else{
                        Toast("Hubo un problema al enviarle correo a ".nitavu_nombre($IdEmpleado)."",2,"");
                
                    }
                    echo "<script>ReloadContenido();</script>";
                    // sleep(1);


                } else {
                    echo '
                    <div class="alert alert-danger" role="alert">
                    Error: al guargar el archivo en la base de datos PDF '.$sql.'
                    </div>';
                }
            } 
            else {
                $sql = "
                UPDATE nominas
                SET 
                fecha='".$fecha."',
                hora='".$hora."',
                iduser='".$nitavu."',
                File='".$ArchivoNominaPDF."'
                WHERE nitavu ='".$IdEmpleado."' and FechaNomina='".$FechaNomina."' and FileType='PDF'";
                
                if ($conexion->query($sql) == TRUE){
                    $Review = TRUE;
                    SonidoBoop();
                    Toast("Se actualizo correctamente el PDF de ".$FechaNomina." de ".nitavu_nombre($IdEmpleado),1,"");
                    historia($nitavu,"Actualizo la nomina PDF de ".nitavu_nombre($IdEmpleado)." (".$IdEmpleado.") de ".$FechaNomina);
                } else {
                    echo '
                    <div class="alert alert-danger" role="alert">
                    Error: al guargar el archivo en la base de datos XML  '.$sql.'
                    </div>';
                }
            }
        } else {
            echo '
                    <div class="alert alert-danger" role="alert">
                    Error: al guargar el archivo  en el servidor PDF  '.$_FILES['File_PDF']['error'].'
                    </div>';
        }
   
}
}

sleep(1);
echo "<script>ReloadContenido();</script>";
// if ($Review == TRUE) { // si todo salio bien recargar contenido con la fecha

    // $Contenido = "<h3>Nomina detectada de <b>".$FechaNomina."</b></h3>";
    // echo "<script>$('#Contenido').html('$Contenido')</script>";
//     $FechaNomina = VarClean($_POST['FechaNomina']);
// $IdEmpleado = VarClean($_POST['IdEmpleado']);
// $FechaNominaString = str_replace("-", "", $FechaNomina);
    
    // $asunto = "Tu nomina del ".$FechaNomina." (ITAVU)";
    // $contenido = "
    //     <p>Estimado <b> ".nitavu_nombre($IdEmpleado).":</b><br>
    //     ".nitavu_puesto($IdEmpleado)." de ".nitavu_dpto_nombre($IdEmpleado)."<br>
        
    //     </p>
    

    //     <p>Le informamos que ya esta disponible la descarga y consulta de su nomina.</p>


    //     <p> Puede consultarla en su navegador de internet entrando a la siguiente pagina: <a href='https://plataformaitavu.tamaulipas.gob.mx/minomina'>https://plataformaitavu.tamaulipas.gob.mx/minomina</a>

    //     <br><br>

    //     Los datos de acceso son los mismos que en la Plataforma del Instituto:<br>
    //     <table><tr><td>        
    //     Usuario: <b>".$IdEmpleado."</b></td><td>
    //     Contraseña: <b style='color:red;'>".nitavu_nip($IdEmpleado)."</b></td></tr></table>
    //     </p>
        
        
    //     <p>
    //     <b>Atentamente</b> <br>
    //     <b>CP. Jesus Alberto Uresti Amaya</b><br>        
    //     Jefe del Dpto. de Contabilidad
    //     </p>

    //     <p style='font-size:8pt;'>NOTA: Este es un correo generado por la Plataforma al subir los archivos de nomina.</p>
    // ";
        
    // if (correo(nitavu_correo($IdEmpleado), nitavu_nombre($IdEmpleado), 'jesus.uresti@tam.gob.mx', 'Dpto. de Contabilidad ITAVU', $asunto, $contenido, $nitavu)==TRUE){
    // // if (correo(nitavu_correo($IdEmpleado), nitavu_nombre($IdEmpleado), 'jesus.uresti@tam.gob.mx', 'Dpto. de Contabilidad ITAVU', $asunto, $contenido, $nitavu)==TRUE){

    //     Toast("Se envio correo a ".nitavu_nombre($IdEmpleado)." informandole la disponibilidad de su archivo de nomina",0,"");
    //     sleep(1);
    // } else{
    //     Toast("Hubo un problema al enviarle correo a ".nitavu_nombre($IdEmpleado)."",2,"");

    // }
    echo "<script>ReloadContenido();</script>";
    
// }

?>