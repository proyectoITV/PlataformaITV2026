<?php

require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("lib/laura_funciones.php");
require_once("lib/flor_funciones.php");
$VIdDesarrollador=IdNuevo('catdesarrolladores','IdDesarrollador');
$IdDesarrollador=VarClean($VIdDesarrollador);
$Nombre=VarClean($_POST['VNombre']);
$VRepresentante=VarClean($_POST['VRepresentante']);
$VCURP=VarClean($_POST['VCURP']);
$VRFC=VarClean($_POST['VCURP']);
$VTelefono=VarClean($_POST['VTelefono']);
$VDomicilio=VarClean($_POST['VDomicilio']);
$VContacto=VarClean($_POST['VContacto']);
$VCorreo=VarClean($_POST['VCorreo']);
$VTelContacto=VarClean($_POST['VTelContacto']);
       
if ($IdDesarrollador == ''){
    Toast("Error, Desarrollador no identificado",2,"");
} else{
    $sql="
    INSERT INTO catdesarrolladores
    (IdDesarrollador,Nombre,Representante_Legal,CURP,RFC,Telefono,DomicilioFiscal, Contacto_Empresa,CorreoElectronico, TelContacto, IdEmpCrea,FechaCaptura)
      values(
          ".$IdDesarrollador.",
          '".$Nombre."',
          '".$VRepresentante."',
          '".$VCURP."',
          '".$VRFC."',
          '".$VTelefono."',
          '".$VDomicilio."',
          '".$VContacto."',
          '".$VCorreo."',
          '".$VTelContacto."',
          '".$nitavu."',
          '".$fecha."'    
    )
    
    ";
     //echo '<script>Console.log("'. $sql.'");</script>';
    // $resultado = $conexion -> query($sql);
    if ($Vivienda->query($sql) == TRUE) {
        Toast("Actualizado con exito",1,"");
    }else {
        Toast("Error al Guardar Desarrollador ".$Nombre."",2,"");
    }
        //SE INSERTA REGISTRO EN LA TABLA periodo DE USO PARA IDENTIDICAR EN QUE DPTO ESTA ADSCRIPTO
        /* $sql2="INSERT INTO vehiculos_periododeuso(IdResponsable,Num_economico,Fecha_inicial) VALUES ('".$VAdscripcion."','".$IdVehiculo."','".$fecha."')";
        if ($conexion->query($sql2) == TRUE) 
        {         
        
        if ( 0 < $_FILES['VFile']['error'] ) {
            $Err=  'Error: ' . $_FILES['VFile']['error']. '<br>';
            // Toast("Error: ".$Err,2,"");

        }
        else {
            $archivofinal = 'fotos_vehiculos/'.$IdVehiculo.".jpg";            
            rename("fotos_vehiculos/".$IdVehiculo.".jpg", "fotos_vehiculos/".$IdVehiculo."_copia".MiToken_generate().".jpg");
            if (move_uploaded_file($_FILES['VFile']['tmp_name'], $archivofinal)==TRUE){
                echo '<script>ActualizaFoto();</script>';
                Toast("Se actualizo la foto",6,$archivofinal);
                
            } else {
                Toast("Error al subir el archivo",2,"");
            }


        }
        Toast("Guardado Correctamente ".$IdVehiculo."",3,"");
        MsgBox_Lite("Guardado Correctamente","vehiculos.php?id=".$IdVehiculo);
        historia($nitavu,"[vehiculos] Creo nuevo vehiculo ".addslashes($sql));
        } 
        else {
            Toast("No se agrego el peridodo de uso",2,"");
        }
   
    }else {
        $VInfo =  Vehiculo_Info($IdVehiculo);
        if ($VInfo==''){
            Toast("Error al Guardar".$IdVehiculo."",2,"");
        } else {
            Toast("Error, Ya se encuentra registrado ".$IdVehiculo." ".$VInfo,2,"");
        }
    } */
    unset($sql,$resultado);
}

?>