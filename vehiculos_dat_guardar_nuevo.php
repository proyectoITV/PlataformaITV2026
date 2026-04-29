<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("vehiculos_fun.php");
require_once("lib/flor_funciones.php");


$IdVehiculo  = VarClean($_POST['IdVehiculo']);
$VSerie  = VarClean($_POST['VSerie']);
$VTipo  = VarClean($_POST['VTipo']);
$VPlacas  = VarClean($_POST['VPlacas']);
$VMarca  = VarClean($_POST['VMarca']);
$VColor  = VarClean($_POST['VColor']);
$VEstatus = VarClean($_POST['VEstatus']);
$VComentario = VarClean($_POST['VComentario']);
$VAdscripcion = VarClean($_POST['VAdscripcion']);
$VCilindros = VarClean($_POST['VCilindros']);
$IdPropietario = VarClean($_POST['IdPropietario']);
if ($IdVehiculo == ''){
    Toast("Error, Vehiculo no identificado",2,"");
} else{
    // $sql="UPDATE vehiculos SET     
    // Serie = '".$VSerie."',
    // Tipo = '".$VTipo."',
    // Placas = '".$VPlacas."',
    // Clave_marca = '".$VMarca."',
    // Clave_Color = '".$VColor."',
    // IdEstatus = '".$VEstatus."',
    // Comentario = '".$VComentario."'

    // WHERE Num_economico='".$IdVehiculo."'";

    $sql="
    INSERT INTO vehiculos
    (Num_economico, Serie, Tipo, Placas, Clave_marca, Clave_Color, IdEstatus, Comentario,Cilindros,IdPropietario) VALUES(
        '".$IdVehiculo."',
        '".$VSerie."',
        '".$VTipo."',
        '".$VPlacas."',
        '".$VMarca."',
        '".$VColor."',
        '".$VEstatus."',
        '".$VComentario."',
        '".$VCilindros."',
        '".$VIdPropietario."'
    )
    
    ";
     //echo '<script>Console.log("'. $sql.'");</script>';
    // $resultado = $conexion -> query($sql);
    if ($conexion->query($sql) == TRUE) {

        //SE INSERTA REGISTRO EN LA TABLA periodo DE USO PARA IDENTIDICAR EN QUE DPTO ESTA ADSCRIPTO
        $sql2="INSERT INTO vehiculos_periododeuso(IdResponsable,Num_economico,Fecha_inicial) VALUES ('".$VAdscripcion."','".$IdVehiculo."','".$fecha."')";
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
    }
    unset($sql,$resultado);
}

?>