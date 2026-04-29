<?php
include("./lib/body_head.php");
include("./lib/body_menu.php"); 
?>
<?php

$idactividad=$_POST['idactividad'];
$avance=$_POST['avance'];
$comentario=$_POST['comentario'];
$fechaavance=$_POST['fechaavance'];
$id_aplicacion = 'ap132';


    /*ACTUALIZAMOS LA TABLA  INDICADORES*/
    if($avance=='100')
    {
        $sql=" UPDATE actividades_empleados set avance=".$avance.", Estatus=1 where IdActividad='".$idactividad."'";  
    }else{
        $sql=" UPDATE actividades_empleados set avance=".$avance.", Estatus=0 where IdActividad='".$idactividad."'";        
    }
        
 
   // echo $sql;
    if ($conexion->query($sql) == TRUE)
     {
           /*INSERTAMOS EN LA TABLA HISTORIAL*/
        $sql2=" Insert Into historial_actividades_empleados(Fecha,IdActividad,Comentario,Avance,nitavu)values('".$fechaavance."','$idactividad','$comentario','$avance','$nitavu')";        
        //echo $sql2;
        $conexion->set_charset('utf8mb4');
        if ($conexion->query($sql2) == TRUE)
         {
                
               $msg="Datos agregados correctamente";

                    if(!empty($_FILES['nuevoDoc']['name']) != null){
                    
                    $doc = $_FILES["nuevoDoc"]["name"];
                    $num = ndocumento(TRUE);
                    //$directorio = 'docs/'; //Declaramos un  variable con la ruta donde guardaremos los archivos
                    $archivo = "documentos/".$num."_".$doc."";
                    $tmp =$_FILES["nuevoDoc"]["tmp_name"];
                    $subida = FTP_subir($tmp,$archivo);
            
                    //echo $subida;
                    if ($subida == "TRUE"){
                    documento_add($num, $doc, $nitavu,$id_aplicacion);
                    $sql = "Update historial_actividades_empleados set iddocumento=".$num .' where Id=(select Max(Id) from historial_actividades_empleados) ';
                    if ($conexion->query($sql) == TRUE){ 
                        ndocumento(FALSE);
                        historia($nitavu,'md_Subí un documento ala IdActividad: '.$idactividad .' archivo: '.$doc);
                        mensaje('Se ha subido el archivo con éxito.','indicadores_empleados.php');  
                    }else{
                        historia($nitavu,'Hubo un error al subir el archivo a la  IdActividad: '.$idactividad .' archivo: '.$doc);
                        mensaje('Hubo un error al subir el archivo ala Actividad','indicadores_empleados.php');  
                    }      
                    }else{    
                        historia($nitavu,'Hubo un error al subir el archivo a la  IdActividad: '.$idactividad .' archivo: '.$doc);
                        mensaje('Hubo un error al subir el archivo ala Actividad','indicadores_empleados.php');  
                    }
                    }else{
                      mensaje('No ha seleccionado ningun archivo.','indicadores_empleados.php');
                    }
             

                
        }
        else
        {
            $msg="Error inesperado ".$sql2; //<-- Descripcion de error
            mensaje($msg,"indicadores_empleados.php");
        }
    }
    else
    {
        $msg="Error inesperado ".$sql; //<-- Descripcion de error
        mensaje($msg,"indicadores_empleados.php");
    }
     
    
?>