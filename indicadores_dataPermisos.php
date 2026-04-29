<?php
require ("config.php");
require ("components.php");
include("seguridad.php");

$IdEmpleado = VarClean($_POST['IdEmpleado']);





$id_aplicacion ="indicadores"; 
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
// $nivel = 1; //<--- Administrador completo
// $nivel = 2; //<--- Delegacion (Delegado)
// $nivel = 3; //<--- Oficinas Centrales
// $nivel = 4; //<-- Capturista
if (sanpedro($id_aplicacion, $nitavu)==TRUE){ 
        //UPdate o Insert        
        $sql = "select count(*) as n from aplicaciones_permisos where nitavu=".$IdEmpleado." and idapp='indicadores'";
        $rPermiso= $conexion -> query($sql);
        $Acceso = 0;
        if($Permiso = $rPermiso -> fetch_array())
        {
            if ($Permiso['n'] >= 1){
                $Acceso = 1;
            } 
        }
        else
        {            
        
        }
        unset($rPermiso,$Permiso);

        if ($Acceso == 1){//UPDATE borramos el permiso
            $sqlUp = "DELETE from aplicaciones_permisos
			WHERE nitavu='".$IdEmpleado."' and idapp='indicadores'
            ";
            echo $sqlUp;
			if ($conexion->query($sqlUp) == TRUE)
			{			
                Mensaje("Se ha retirado el acceso a al usuario ".$IdEmpleado." de esta aplicacion","indicadores.php?permisos=");
                historia($nitavu,"retiro el permiso a ".$IdEmpleado." de la apliccacion de indicadores");
			}
			else
			{
                Toast("Error al eliminar el permiso",2,"");
			}

        } else {//INSERT
            $sqlIn = "INSERT INTO aplicaciones_permisos
			(nitavu,idapp,nivel,quien_autorizo,fecha_autorizacion,descripcion)
			VALUES
            ('".$IdEmpleado."', 'indicadores','4', '".$nitavu."', '".$fecha."', '')";
            echo $sqlIn;
			if ($conexion->query($sqlIn) == TRUE)
			{			
                Mensaje("Se ha otorgado correctamente el permiso de capturista al usuario ".$IdEmpleado,"indicadores.php?permisos=");
                historia($nitavu,"otorgo el permiso a ".$IdEmpleado." en la apliccacion de indicadores");
			}
			else
			{
                Toast("Error al insertar permiso",2,"");
			}
        }





} else {mensaje("ERROR: no tienes acceso","");}



?>


<?php
// include ("./lib/body_footer.php"); //Cierre de Estructura de la Plaforma
?>