<?php
include("./lib/body_head.php");
include("./lib/body_menu.php"); 
?>
<?php

$idactividad=$_POST['idactividad'];
$avance=$_POST['avance'];
$comentario=$_POST['comentario'];
$fechaavance=$_POST['fechaavance'];

    /*ACTUALIZAMOS LA TABLA  INDICADORES*/
    if($avance=='100')
    {
        $sql=" UPDATE actividades_indicadores set avance=".$avance.", Estatus=1 where IdActividad='".$idactividad."'";  
    }else{
        $sql=" UPDATE actividades_indicadores set avance=".$avance." where IdActividad='".$idactividad."'";        
    }
        
 
    //echo $sql;
    if ($conexion->query($sql) == TRUE)
     {
           /*INSERTAMOS EN LA TABLA HISTORIAL*/
        $sql2=" Insert Into historial_actividades(Fecha,IdActividad,Comentario,Avance,nitavu)values('".$fechaavance."','$idactividad','$comentario','$avance','$nitavu')";        
       // echo $sql2;
        $conexion->set_charset('utf8mb4');
        if ($conexion->query($sql2) == TRUE)
         {
                
                $msg="Datos agregados correctamente";
                mensaje($msg,"indicadores_dir.php");  
        }
        else
        {
            $msg="Error inesperado ".$sql2; //<-- Descripcion de error
            mensaje($msg,"indicadores_dir.php");
        }
    }
    else
    {
        $msg="Error inesperado ".$sql; //<-- Descripcion de error
        mensaje($msg,"indicadores_dir.php");
    }
     
    
?>