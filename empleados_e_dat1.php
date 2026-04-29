<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
// require_once("lib/flor_funciones.php");

// error_reporting(0); //<-- para simular produccion
$id_aplicacion = 'ap03';
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
// $nivel=1;

//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap03"; //ap07=Permisos de Aplicacion
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    if ($nivel==1){
        $no = VarClean($_POST['n']);
        
        $nombre = VarClean($_POST['nombre_empleado']);        
        $puesto = VarClean($_POST['puesto']);
        $dpto = VarClean($_POST['dpto']);
        $Titular = VarClean($_POST['Titular']);
        $telefono_extension = VarClean($_POST['telefono_extension']);
        $telefono_movil = VarClean($_POST['telefono_movil']);
        $telefono2 = VarClean($_POST['telefono2']);
        $profesion_abr = VarClean($_POST['profesion_abr']);
        $profesion = VarClean($_POST['profesion']);
        $correoelectronico = VarClean($_POST['correoelectronico']);
        $estado = VarClean($_POST['estado']);
        $estadocivil = VarClean($_POST['estadocivil']);
        $domicilio_calle = VarClean($_POST['domicilio_calle']);
        $domicilio_num_ext = VarClean($_POST['domicilio_num_ext']);
        $domicilio_num_int = VarClean($_POST['domicilio_num_int']);
        $domicilio_entrecalles = VarClean($_POST['domicilio_entrecalles']);
        $domicilio_ciudad = VarClean($_POST['domicilio_ciudad']);
        $domicilio_colonia = VarClean($_POST['domicilio_colonia']);
        $domicilio_cp = VarClean($_POST['domicilio_cp']);
        $adscripcion = VarClean($_POST['adscripcion']);
        

        $fecha_nacimiento = VarClean($_POST['fecha_nacimiento']);
        $nivele = VarClean($_POST['nivel']);

        $curp = VarClean($_POST['curp']);
        $rfc = VarClean($_POST['rfc']);

        $msg="";

		$archivo = 'fotos/'.$no.'';
		$msg= $msg.subir('foto', $archivo, 'jpg');
		
        $departamento=dpto_id($dpto);
        
        $sql ="UPDATE empleados SET 
            nombre  = '".$nombre ."',
            puesto = '".$puesto."',
            dpto = '".$dpto."',  
            departamento ='".$departamento."',        
            telefono_extension = '".$telefono_extension."',
            telefono_movil = '".$telefono_movil."',
            telefono2 = '".$telefono2."',
            profesion_abr = '".$profesion_abr."',
            profesion = '".$profesion."',
            correoelectronico = '".$correoelectronico."',
            estado = '".$estado."',
            estadocivil = '".$estadocivil."',
            domicilio_calle = '".$domicilio_calle."',
            domicilio_num_ext = '".$domicilio_num_ext."',
            domicilio_num_int = '".$domicilio_num_int."',
            domicilio_entrecalles = '".$domicilio_entrecalles."',
            domicilio_ciudad = '".$domicilio_ciudad."',
            domicilio_colonia = '".$domicilio_colonia."',
            domicilio_cp = '".$domicilio_cp."',
            fecha_nacimiento = '".$fecha_nacimiento."',
            adscripcion = '".$adscripcion."',
            nivel = '".$nivele."',
            curp = '".$curp."',
            rfc = '".$rfc."'
 
        WHERE nitavu='$no'";

        echo $sql;

        if ($conexion->query($sql) == TRUE) {
            Toast("Actualizado correctamente".$msg,4,"");

            if ($Titular == 1) { //Si es titular
                $sql ="UPDATE cat_gerarquia SET titular='".$no."' WHERE id='".$dpto."'";			                
                if ($conexion->query($sql) == TRUE) {
                    Toast("Se actualizo el organigrama".$msg,4,"");
                }	else {
                    Toast("Hubo un problema al actualizar el organigrama".$msg,2,"");

                }


                if ($estado <> ''){ // y se dio de baja
                    $sql ="UPDATE cat_gerarquia SET titular='' WHERE id='".$dpto."'";			                
                    if ($conexion->query($sql) == TRUE) {
                        Toast("Se quito del organigrama".$msg,4,"");
                    }	else {
                        Toast("Hubo un problema al actualizar el organigrama 2".$msg,2,"");
    
                    }
    
                }
            }

            
        }

        Toast("".$msg,1,"");
        


    } else {
        Toast("Sin permiso",2,"");
    }
}
else {
    Toast("Sin permiso para usar la aplicacion",2,"");
}
    











// if (isset($no)) {

 
//  $nombre = $_POST['nombre'];


// $historia = user_historia($no).", Actualizo datos generales por ".user_legend($quien)." el ".$fecha;



// //$sql ="UPDATE empleados SET secc='$secc', sap='$sap', nombre='$nombre', nivel='$nivel', correoelectronico='$correoelectronico', telefono='$telefono', telefono_movil='$telefono_movil', fecha_nacimiento='$fecha_nacimiento',historia='$historia', telefono2='$telefono2', telefono_extension='$telefono_extension', profesion='$profesion', profesion_abr='$profesion_abr', direccion='$direccion', departamento='$departamento' WHERE nitavu='$no'";


// $sql ="UPDATE empleados SET nombre='$nombre', correoelectronico='$correoelectronico', telefono_movil='$telefono_movil', fecha_nacimiento='$fecha_nacimiento',historia='$historia', telefono2='$telefono2', domicilio_calle='$domicilio_calle', domicilio_num_int='$domicilio_num_int', domicilio_num_ext = '$domicilio_num_ext', domicilio_entrecalles = '$domicilio_entrecalles', domicilio_colonia='$domicilio_colonia', domicilio_cp='$domicilio_cp', estadocivil='$estadocivil', domicilio_ciudad='$domicilio_ciudad' WHERE nitavu='$no'";

// if ($conexion->query($sql) == TRUE) 
// 		{
// 		$msg="";

// 		$archivo = 'fotos/'.$no.'';
// 		$msg= $msg.subir('foto_file', $archivo, 'jpg');
		
// 		//$archivo = 'firmas/'.$no.'';
// 		//$msg= $msg.subir('firma_file', $archivo, 'jpg');
		
// 		historia($quien,'Actualizo datos de '.$no);
		
// 		$msg = $msg."Se ha Actualizado con exito con exito.";
// 		mensaje($msg,'empleados.php?search=');
// 		//header('location:../index.php');	

// 		} 
// 	else 
// 		{
// 		$msg="Error inesperado ".$sql; //<-- Descripcion de error
// 		//echo $sql;
// 		//creamos un historial de error extraordinario
// 		// header("location:../lib/error.php?er=".$msg);	
// 		} 
		
// }
// else {
// 	echo "algo anda mal";
// }
?>