<?php
require ("rintera-config.php");
require ("components.php");
// include("seguridad.php");   
// $("#Lin_"+IdUser).css("background-color","green");

$IdUser = VarClean($_POST['IdUser']);
$IdUserAdmin = VarClean($_POST['IdUserAdmin']);
$id_rep = VarClean($_POST['id_rep']);



$sql = "select * from reportes_permisos WHERE id_rep ='".$id_rep."' and IdUser='".$IdUser."' limit 1";        
// echo $sql;
    $r= $db0 -> query($sql);
    if($f = $r -> fetch_array())
    {//Tiene Permiso
        //Si tiene se lo quitamos
        if (QuitarPermiso($id_rep,$IdUser,$IdUserAdmin)==TRUE){
            echo '<script> $("#Lin_'.$IdUser.'").css("background-color","white");
            $("#Etiqueta_'.$IdUser.'").html("");
            </script>';
            Toast("Se ha retirado el Permiso a ".UserName($IdUser)." para usar el reporte #".$id_rep,1,"");
        } else {
            Toast("ERROR al dar el Permiso a ".UserName($IdUser)." para usar el reporte #".$id_rep,2,"");
            echo '<script> $("#Lin_'.$IdUser.'").css("background-color","green");
            $("#Etiqueta_'.$IdUser.'").html("Con Acceso");
            </script>';
        }
    } else {//No tiene Permiso


        if (DarPermiso($id_rep,$IdUser,$IdUserAdmin)==TRUE){
            echo '<script> $("#Lin_'.$IdUser.'").css("background-color","green");
            $("#Etiqueta_'.$IdUser.'").html("Con Acceso");
            </script>';
            Toast("Se ha otorgado el Permiso a ".UserName($IdUser)." para usar el reporte #".$id_rep,4,"");
        } else {
            Toast("ERROR al otorgar el Permiso a ".UserName($IdUser)." para usar el reporte #".$id_rep,2,"");
            echo '<script> $("#Lin_'.$IdUser.'").css("background-color","white");
            $("#Etiqueta_'.$IdUser.'").html("");
            </script>';
        }


    //Agregamos
        // echo '<script> $("#Lin_'.$IdUser.'").css("background-color","white")</script>';
    }



?>