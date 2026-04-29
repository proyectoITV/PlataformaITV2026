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
$VModelo = VarClean($_POST['VModelo']);
$VAdscripcion = VarClean($_POST['VAdscripcion']);
$VCilindros = VarClean($_POST['VCilindros']);
$VIdPropietario = VarClean($_POST['VIdPropietario']);
if ($IdVehiculo == ''){
    Toast("Error, Vehiculo no identificado",2,"");
} else{
    $sql="UPDATE vehiculos SET     
    Serie = '".$VSerie."',
    Tipo = '".$VTipo."',
    Placas = '".$VPlacas."',
    Clave_marca = '".$VMarca."',
    Clave_Color = '".$VColor."',
    IdEstatus = '".$VEstatus."',
    Comentario = '".$VComentario."',
    Modelo = '".$VModelo."',
    Cilindros = '".$VCilindros."',
    IdPropietario='".$VIdPropietario."'
    WHERE Num_economico='".$IdVehiculo."'";
   
    $resultado = $conexion -> query($sql);
    if ($conexion->query($sql) == TRUE) {
    
        //GUARDAR EL DPTO AL QUE ESTA ADSCRIPTO. 
         $idResponsbaleAnterior=IdResponsableVehiculo($IdVehiculo);
        if($VAdscripcion!=$idResponsbaleAnterior)
        { 
            $sql1="UPDATE vehiculos_periododeuso SET  Cancelado = 1, Observaciones='Vehiculo que ha sido cambiado de adscripcion' ,  Fecha_Final='".$fecha."'  WHERE Num_economico='".$IdVehiculo."' and Cancelado=0";    
             if ($conexion->query($sql1) == TRUE) 
             {
                $sql2="INSERT INTO vehiculos_periododeuso(IdResponsable,Num_economico,Fecha_inicial) VALUES ('".$VAdscripcion."','".$IdVehiculo."','".$fecha."')";
                if ($conexion->query($sql2) == TRUE) 
                {
                    Toast("Actualizado con exito",1,"");
                }else {
                    Toast("No se pudo actualizar el perido de uso",2,"");
                }

            }else {
                Toast("No se pudo actualizar",2,"");
            }
         }   
         // Se verifica si el IdEstatus=1 para dar de baja tambien en la tabla el periododeUso y guardar la Fechafinal
         if($VEstatus==1)
         { 
             $sql1="UPDATE vehiculos_periododeuso SET  Observaciones='Vehiculo marcado como inactivo' , Fecha_Final='".$fecha."'  WHERE Num_economico='".$IdVehiculo."' and Cancelado=0";     
              if ($conexion->query($sql1) == TRUE) 
              {
                     Toast("Actualizado con exito",1,"");                
             }else {
                 Toast("No se pudo actualizar el periodo de Uso",2,"");
             }
          }   
 
        
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
        Toast("Guardado Correctamente ".$IdVehiculo."",4,"");
        historia($nitavu,"[vehiculos] Actualizo la información ".addslashes($sql));

    }else {
        Toast("Error al Guardar".$IdVehiculo."",2,"");
    }
    unset($sql,$resultado);
}

?>