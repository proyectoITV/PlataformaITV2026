<?php
$Archivo="C:/Vivienda/Bases de Datos/Sistema de Vivienda/DcEstatal/Backup/DcEstatal_backup_2019_08_11_140003_5374926.bak";

echo "<b title='".$Archivo."'>".DriveArchivoNombre($Archivo)."</b>";

function DriveArchivoNombre($Archivo){
    // $Archivo = $value['Archivo'];                    
    $pos = strrpos($Archivo, '/', -1); 
    if ($pos === false) {
        
    } else {
        // var_dump($pos);
    }

    $ArchivoFinal = substr($Archivo, $pos +1, (strlen($Archivo) - $pos));
    return $ArchivoFinal;
}
?>