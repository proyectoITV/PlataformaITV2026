<?php
require("seguridad.php");
require("config.php");
require("lib/funciones.php");
require("var_clean.php");
// Correo = $('#Correo').val();
// 			Movil = $('#Movil').val();
// 			Nacimiento = $('#Nacimiento').val();
// 			Profesion = $('#Profesion').val();
//             NIP = $('#NIP').val();
            
$Correo = VarClean($_POST['Correo']);
$Movil = VarClean($_POST['Movil']);
$Nacimiento = VarClean($_POST['Nacimiento']);
$Profesion = VarClean($_POST['Profesion']);
//$NIP = VarClean($_POST['NIP']);

// $archivo = 'fotos/'.$no .'';
// 		$msg= $msg.subir('foto_file', $archivo, 'jpg');
		
// 		//$archivo = 'firmas/'.$no.'';
// 		//$msg= $msg.subir('firma_file', $archivo, 'jpg');
		
// 		historia($no,'Cambie mi foto de perfil');
// echo $NFile;

// if ( 0 < $_FILES['archivo']['error'] ) {
//     echo 'Error: ' . $_FILES['archivo']['error'] . '<br>';
// }
// else {
    $archivo = 'fotos/'.$nitavu .'';
	$Subida = subir('archivo', $archivo, 'jpg');

    
    
    // if (move_uploaded_file($_FILES['archivo']['tmp_name'], $archivofinal)){
    //     Toast("Se ha guardado correctamente",4,"");
    // } else {
    //     Toast("Hubo un error al guardar el archivo ",2,"");
        
    // }
    
    
  // nip = '".$NIP."'
    //agregar el registro
    $sql = "UPDATE empleados SET 
        correoelectronico='".$Correo."',
        telefono_movil = '".$Movil."',
        fecha_nacimiento='".$Nacimiento."',
        profesion='".$Profesion."'
     



    WHERE nitavu='".$nitavu."'";
    // echo $sql;
    if ($conexion->query($sql) == TRUE){       
        Toast("Se han actualizado los datos. ".$Subida,4,"");
    } else {
        Toast("Error al guardar. ".$Subida,2,"");
    }

    
// }

?>