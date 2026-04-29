<?php


    require("config.php");
    require_once("lib/funciones.php");
    $msg = "";
    $c=0; $x=0; $tmp="";
    $nitavu = 0;
    $sql = "select * from correos where estado=0 and fecha=curdate()"; //0 no enviado, 2 re-enviado
    // $sql = "select * from correos limit 10";
    $rc= $conexion -> query($sql);
    if($fx = $rc -> fetch_array()){    
            $r2 = $conexion -> query($sql); 
            while($f = $r2 -> fetch_array())
            {
                //1.- paso uno cambiar el estado a 2, para que ya no entre en el proximo ciclo
                $sql = "UPDATE correos SET estado=2 WHERE id=".$f['id']."";
                //echo $sql;
                $r = $conexion -> query($sql); 
                if ($conexion->query($sql) == TRUE){

                }

                //2.- Reenviar el correo, si falla o no se vuelve a agregar a la cola con estado 1 ó 0
                //notificacion_add ($f['nuc'], "RE-".$f['asunto'], $fecha, $itavu_manda, $contenido);
                $enviado = correo(nitavu_correo($f['nuc']), nitavu_nombre($f['nuc']), $f['responder_a'], $f['responder_a_name'], "RE-".$f['asunto'], $f['contenido'], $f['nuc']);
                if($enviado == TRUE){
                    $tmp = "Se realizo re-envio del correo para ".$f['correo'].", ".$f['correo_name']." de ".$f['responder_a_name']." desde ".$f['responder_a']." con el asunto ".$f['asunto']." del dia ".$f['fecha']." que no se habia podido enviar";
                    historia("0", $tmp);
                    notificacion_add ($f['nuc'], 'chat', $fecha, $nitavu, $tmp);
                    $c=$c+1;

                } else {
                    $tmp = "Se intento realizar un reenvio del correo para ".$f['correo'].", ".$f['correo_name']." de ".$f['responder_a_name']." desde ".$f['responder_a']." con el asunto ".$f['asunto']." del dia ".$f['fecha']." que no se habia podido enviar. <B>SERIA CONVENIENTE QUE CHEQUES TU CUENTA DE CORREO, O LA ACTIVES PARA QUE TE PUEDAN LLEGAR LOS CORREOS DESDE LA PLATAFORMA</B>";
                    notificacion_add ($f['nuc'], 'chat', $fecha, "", $tmp);
                    $x=$x+1;
                    historia("0", $tmp);
                }
        }
    } else {
        echo "Sin tareas Pendientes.";
    }
echo "Se realizaron ".$c." reenvios de correos y fallaron ".$x;
historia("0", "Tarea de mantenimiento de reenvio de correos pendientes: ".$c.", y fallos:".$x);
// notificacion_add("0", 'chat', $fecha, "", "Tarea de mantenimiento de reenvio de correos pendientes: (".fecha_larga($fecha)." - ".hora12($hora)."".$c." y fallos:".$x);





echo "<img src='icon/ok.png' style='width:18px;'>";
?>