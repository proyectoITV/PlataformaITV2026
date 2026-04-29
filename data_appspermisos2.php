<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion
// $q = $_POST['q']; if (ValidaVAR($q)==TRUE){$q = LimpiarVAR($q);} else {$q = "";}
$UsuarioSeleccionado = $_POST['IdUser']; if (ValidaVAR($UsuarioSeleccionado)==TRUE){$UsuarioSeleccionado = LimpiarVAR($UsuarioSeleccionado);} else {$UsuarioSeleccionado = "";}
$IdUsuario = $_POST['nitavu']; if (ValidaVAR($IdUsuario)==TRUE){$IdUsuario = LimpiarVAR($IdUsuario);} else {$IdUsuario = "";}
$IdApp = $_POST['IdApp']; if (ValidaVAR($IdApp)==TRUE){$IdApp = LimpiarVAR($IdApp);} else {$IdApp = "";}
$Nivel = $_POST['Nivel']; if (ValidaVAR($Nivel)==TRUE){$Nivel = LimpiarVAR($Nivel);} else {$Nivel = "";}

if ($Nivel == 0){//Eliminar el Permiso
    $msg="";
	$sql="delete from aplicaciones_permisos WHERE
    idapp='".$IdApp."' and nitavu='".$UsuarioSeleccionado."'";
    
	if ($conexion->query($sql) == TRUE){                   
	 	historia($IdUsuario,"Se retiro el acceso a la aplicacion  ".$IdApp." - ".nitavu_nombre($UsuarioSeleccionado)." (".$UsuarioSeleccionado.")");
         Toast("Se ha retirado el acceso con exito",1,"");
            echo "<script>ActApps();</script>";
	} else {
	 	Toast("ERROR al eliminar permiso",2,"");
	}

} else {

    $sql="INSERT INTO aplicaciones_permisos
    (nitavu, idapp, nivel, fecha_autorizacion, quien_autorizo)
    VALUES('".$UsuarioSeleccionado."','".$IdApp."','".$Nivel."','".$fecha."','".$IdUsuario."')
    ";

    // echo $sql;
    
	if ($conexion->query($sql) == TRUE){                   
	 	historia($IdUsuario,"Se dio el acceso a la aplicacion  ".$IdApp." - ".nitavu_nombre($UsuarioSeleccionado)." (".$UsuarioSeleccionado.") con Nivel ".$Nivel);
         Toast("Se ha otorgado el acceso con exito",1,"");
            echo "<script>ActApps();</script>";
	} else {
        // echo $sql;
	 	Toast("ERROR al otorgar permiso",2,"");
	}

    // if ($IdApp=='rintera'){//Actualizar usuarios a rintera
    //     include('/rintera/updateuserfromplataforma_off.php');

    // }

}


			

?>