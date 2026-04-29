<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("vehiculos_fun.php");
require_once("lib/flor_funciones.php");


$IdVehiculo  = VarClean($_POST['IdVehiculo']);
$NBitacora =  NIdVBitacora(FALSE);
$VInfo = Vehiculo_Info($IdVehiculo);
    // $Clave_servicio = VarClean($_POST['Clave_servicio']);
    $Clave_servicio = $NBitacora;
// echo "Clave servicio: ".$Clave_servicio;
    $Num_economico = $IdVehiculo;
    $Fecha_solicitud = VarClean($_POST['Fecha_solicitud']);
    $Fecha_ejecucion = VarClean($_POST['Fecha_ejecucion']);
    $clave_tipo_mant = VarClean($_POST['clave_tipo_mant']);
    $Km_prog = VarClean($_POST['Km_prog']);
    $Km_real = VarClean($_POST['Km_real']);
    $num_solicitud = VarClean($_POST['num_solicitud']);
    $num_factura = VarClean($_POST['num_factura']);
    $clave_proveedor = VarClean($_POST['clave_proveedor']);
    $Descripcion = VarClean($_POST['Descripcion']);
    $Costo_mano_obra = VarClean($_POST['Costo_mano_obra']);
    $Costo_refaccion = VarClean($_POST['Costo_refaccion']);
    $Importe_factura = VarClean($_POST['Importe_factura']);

$mErr="";
if ($Descripcion==''){
    $mErr.="Descripcion";
}

if ($mErr<>''){
    Toast("Debe llenar el campo ".$mErr,2,"");
} else {


    $sql="INSERT INTO vehiculos_bitacora
    (
        Clave_servicio,
        Num_economico,
        Fecha_solicitud,
        Fecha_ejecucion,
        clave_tipo_mant,
        Km_prog,
        Km_real,
        num_solicitud,
        num_factura,
        clave_proveedor,
        Descripcion,
        Costo_mano_obra,
        Costo_refaccion,
        act_fecha,
        act_hora,
        act_user,
        Importe_factura
    )
    VALUES(
        '".$Clave_servicio."',
        '".$Num_economico."',
        '".$Fecha_solicitud."',
        '".$Fecha_ejecucion."',
        '".$clave_tipo_mant."',
        '".$Km_prog."',
        '".$Km_real."',
        '".$num_solicitud."',
        '".$num_factura."',
        '".$clave_proveedor."',
        '".$Descripcion."',
        '".$Costo_mano_obra."',
        '".$Costo_refaccion."',
        '".$fecha."',
        '".$hora."',
        '".$nitavu."',
        '".$Importe_factura."'    
    )

    ";
    // echo $sql;
   //  echo "<script>console.log(".$sql.");</script>";
    // $resultado = $conexion -> query($sql);
    if ($conexion->query($sql) == TRUE) {
       
        // Toast("Eliminado Correctamente ".$IdVehiculo."",4,"");
        historia($nitavu,"[vehiculos] Registro Bitacora ".$NBitacora." para el Vehiculo".$VInfo."sql=".addslashes($sql));

        MsgBox_Lite("Bitacora ".$NBitacora." registrada correctamente para el Vehiculo ".$VInfo."-".$IdVehiculo."","vehiculos.php?id=".$IdVehiculo);
        // Toast("Bitacora ".$NBitacora." registrada correctamente para el Vehiculo ".$VInfo."-".$IdVehiculo."",4,"");

         
        if ( 0 < $_FILES['FileFoto']['error'] ) {
            $Err=  'Error: ' . $_FILES['FileFoto']['error']. '<br>';
            // Toast("Error: ".$Err,2,"");

        }
        else {
            $archivofinal = 'fotos_vehiculos/'.$IdVehiculo."_".$NBitacora.".jpg";            
            echo "Archivo Final = ".$archivofinal.", -> ".$_FILES['FileFoto']['tmp_name'];
            // rename("fotos_vehiculos/".$IdVehiculo.".jpg", "fotos_vehiculos/".$IdVehiculo."-".MiToken_generate().".jpg");
            if (move_uploaded_file($_FILES['FileFoto']['tmp_name'], $archivofinal)==TRUE){
                // echo '<script>ActualizaFoto();</script>';
                // Toast("Se subio la foto",6,$archivofinal);
                
            } else {
                // Toast("Error al subir la foto, o no selecciono una",3,"");
            }
        }


        if ( 0 < $_FILES['FileDoc']['error'] ) {
            $Err=  'Error: ' . $_FILES['FileDoc']['error']. '<br>';
            // Toast("Error: ".$Err,2,"");

        }
        else {
            $archivofinal = 'fotos_vehiculos/'.$IdVehiculo."_".$NBitacora.".pdf";            
            // rename("fotos_vehiculos/".$IdVehiculo.".jpg", "fotos_vehiculos/".$IdVehiculo."-".MiToken_generate().".jpg");
            if (move_uploaded_file($_FILES['FileDoc']['tmp_name'], $archivofinal)==TRUE){
                // echo '<script>ActualizaFoto();</script>';
                // Toast("Se subio la foto",6,$archivofinal);
                
            } else {
                // Toast("Error al subir la foto, o no selecciono una",3,"");
            }
        }


    }else {
        Toast("Error al Guardar ".$NBitacora."",2,"");
    }
    unset($sql,$resultado);

}
?>