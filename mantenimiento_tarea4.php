<?php


    require("config.php");
    require_once("lib/funciones.php");
    $msg = "";
    $c=0; $x=0; $tmp="";
    $nitavu = 0;



    $IdTarea = 1;
    if (TareaIsset($IdTarea)==TRUE){
        echo "Tarea ya ejecutada ";
        echo "<img src='icon/x.png' style='width:18px;'>";
    } else {

    $Hora1 = "20:00:00.0000";   $Hora2 = "24:00:00.0000";    //Ventana de Accion
    if ( ($hora>= $Hora1) and ($hora <=$Hora2) ) {
        echo "Horario Ideal";    
        Tarea("1", "Envio Resumen Ticket Mañanero", FALSE); //agrega la tarea

            $sql="
            -- Departamentos
            select 
            DISTINCT a.turnadoa,
            (select nombre from cat_gerarquia where id=a.turnadoa) as Departamento,
            (select count(*) from cp_nuevosdocumentos WHERE estado = 0 and baja = 0 and turnadoa = a.turnadoa) as NCasos
            
            from cp_nuevosdocumentos a
            WHERE estado = 0 and baja = 0 and turnadoa <> 0 
            -- and turnadoa = 55 or turnadoa=4
            
            ";
            $txtBody = "";
            $txtBody = $txtBody."";
            $r= $conexion -> query($sql);
            while($f = $r -> fetch_array()) {
                $txtBody = $txtBody."<p style='font-size:14pt;'>Actualmente hoy <b>".fecha_larga($fecha)."</b> a las <b style='color:orange;'>".hora12($hora)."</b>, tu Departamento <b>".$f['Departamento']."</b> tiene <b style='background-color:orange;color:white;font-weight:bold;font-size:16pt;'>".$f['NCasos']."
                pendientes por resolver</b>; en la aplicación de la plataforma ITAVU llamada Tickets.</p>";

                //Lista de Casos
                $sql2="
                        
                -- Casos
                select * from cp_nuevosdocumentos 
                WHERE turnadoa = ".$f['turnadoa']."
                and estado = 0 and baja = 0

                ";
                $txtBody = $txtBody."<table border=3><th>Origen</th><th>Asunto</th><th>Comentarios</th>";
                $r2= $conexion -> query($sql2);
                $c = 0;
                while($f2 = $r2 -> fetch_array()) {
                    if($c%2==0){
                        $txtBody= $txtBody.'<tr align=left style="right:0;  background-color:white">';
                    }else{
                        $txtBody= $txtBody.'<tr align=left style="right:0; background-color:#CACACA;">';
                    }
                    
                    $txtBody = $txtBody."<td align=left valing=top>";
                        $txtBody = $txtBody."ICdCaso: ".$f2['id']."<br>";
                        $txtBody = $txtBody."Fecha: ".$f2['fecha']."<br>";
                        $txtBody = $txtBody."De: <b style='color:orange;'>".$f2['remite'].", ".$f2['puesto']."</b>, ".$f2['dependencia']."<br>";
                        $txtBody = $txtBody."<b>".$f2['oficioNumero']."</b><br>";
                    $txtBody = $txtBody."</td>";

                    $txtBody = $txtBody."<td align=left valing=top>";
                        $txtBody = $txtBody."<b style='font-size:12pt;'>".$f2['asunto']."</b><br>";
                        $txtBody = $txtBody."<cite style='font-size:10pt;'>".$f2['descripcion']."</cite><br>";
                        $txtBody = $txtBody."<cite style='font-size:8pt;'>Capturo: ".nitavu_nombre($f2['nitavuCaptura'])."</cite><br>";
                    $txtBody = $txtBody."</td>";


                    $txtBody = $txtBody."<td>";
                    $sql3="
                    -- Comentarios
                    select * from cp_comentarios where CasoId = ".$f2['id']." order by ComentarioId

                    ";
                    
                    $r3= $conexion -> query($sql3);
                    while($f3 = $r3 -> fetch_array()) {

                    
                    $txtBody = $txtBody."<p><b style='font-size:10pt;color:orange;'>".nitavu_nombre($f3['Nuser'])."</b>:";
                    $txtBody = $txtBody."<cite style='font-size:10pt;'>".$f3['Comentario']."</cite>(".$f3['Fecha'].":".$f3['Hora'].")</p>";
                    
                    

                    }


                    $sql4="          
                    -- Involucradros
                    select * 
                    from cp_colaboradores
                    where  numcaso = ".$f2['id']."
                    ";
                    $r4= $conexion -> query($sql4);
                    $txtBody = $txtBody."Colaboradores:<br>";
                    while($f4 = $r4 -> fetch_array()) {
                        $txtBody = $txtBody."<p><b style='font-size:10pt;color:gray;'>".nitavu_nombre($f4['nitavu'])."</b>, autorizado por ".nitavu_nombre($f4['quienautorizo'])."</p>";
                    
                    }

                    $txtBody = $txtBody."</td>";
                    $txtBody = $txtBody."</tr>";
                    $c = $c+1;



                }
                $txtBody = $txtBody."</table>";

                if ($f['turnadoa']=='55' OR $f['turnadoa']=='4' ){
                    $sql5="        
                    select * from aplicacionespermisos where NIdApp = 'ap66' and IdDpto=".$f['turnadoa']."";
                } else {
                    $sql5="        
                    select * from aplicacionespermisos where NIdApp = 'ap66' and IdDpto=".$f['turnadoa']." and nivel in(1)
                ";

                }
                //
                
                $r5= $conexion -> query($sql5);        
                $Saludo = "";
                $txtCorreo = "";
                while($f5 = $r5 -> fetch_array()) {

                    $Saludo = "</p><b>Buen dia ".$f5['Nombre']."</b><br><cite>".nitavu_dpto_nombre($f5['IdEmpleado'])."</cite></p>";
                    $txtCorreo = $Saludo.$txtBody."<p><cite style='font-size:7pt;color:gray:'>Este correo es un envio automatizado de la actividad de Ticket, para mantenerte al tanto de tus pendientes, es enviado a los que tienen el permiso nivel 1.</cite></p><p><br>Para cualquier duda, estamos a tus ordenes<br><b>Departamento de Informatica ITAVU</p><hr>";
                    $correo = nitavu_correo($f5['IdEmpleado']);
                    if ( $correo <> ''){
                        echo "Se envia correo ".$correo."<br>"."";
                            $usuario = $f5['IdEmpleado'];
                            $quien = "informatica.itavu@gmail.com";
                            $quien_nombre = "Plataforma ITAVU";
                            $asunto = "Resumen de Ticket (".$f['Departamento'].")".$fecha.":".$hora;
                            $contenido = "".$txtCorreo;
                            $usuario = "2809";
                            correo(nitavu_correo($usuario), nitavu_nombre($usuario), $quien, $quien_nombre, $asunto, $contenido, $usuario);

                        
                        // correo(nitavu_correo($usuario), nitavu_nombre($usuario), $quien, $quien_nombre, $asunto, $contenido, $usuario);
                    } else {
                        //no se pudo enviar porque no tienen correo
                        echo "No se envia correo a ".$f5['IdEmpleado']." - ".$f5['Nombre'].":<br><br>".$txtCorreo."<hr>";
                        $usuario = "2809";
                        $quien = "informatica.itavu@gmail.com";
                        $quien_nombre = "Plataforma ITAVU";
                        $asunto = "problemas con el Correo ".$fecha;
                        $contenido = ""."<p>No se envia correo a ".$f5['IdEmpleado']." - ".$f5['Nombre'].":<br></p><br>".$txtCorreo."<hr>";
                        $usuario = "2809";
                        correo(nitavu_correo($usuario), nitavu_nombre($usuario), $quien, $quien_nombre, $asunto, $contenido, $usuario);
                    }

                
                    
                    
                }


                //Excepciones
                if ($f['turnadoa']=='55' OR $f['turnadoa']=='4' ){
                    //Pendientes de Soporte o Informatica
                    if ($f['turnadoa']=='4') {
                        $usuario = "2809";
                        $quien = "informatica.itavu@gmail.com";
                        $quien_nombre = "Plataforma ITAVU";
                        $asunto = "Resumen de Ticket (Soporte)".$fecha.":".$hora;
                        $contenido = "".$txtCorreo;
                        $usuario = "2809";
                        correo(nitavu_correo($usuario), nitavu_nombre($usuario), $quien, $quien_nombre, $asunto, $contenido, $usuario);


                        //Pendientes de Soporte o Informatica
                        $usuario = "1533";
                        $quien = "informatica.itavu@gmail.com";
                        $quien_nombre = "Plataforma ITAVU";
                        $asunto = "Resumen de Ticket (Soporte) ".$fecha.":".$hora;
                        $contenido = "".$txtCorreo;
                        $usuario = "2809";
                        correo(nitavu_correo($usuario), nitavu_nombre($usuario), $quien, $quien_nombre, $asunto, $contenido, $usuario);
                    }

                    if ($f['turnadoa']=='55') {
                        $usuario = "2809";
                        $quien = "informatica.itavu@gmail.com";
                        $quien_nombre = "Plataforma ITAVU";
                        $asunto = "Resumen de Ticket (Sistemas)".$fecha.":".$hora;
                        $contenido = "".$txtCorreo;
                        $usuario = "2809";
                        correo(nitavu_correo($usuario), nitavu_nombre($usuario), $quien, $quien_nombre, $asunto, $contenido, $usuario);


                        //Pendientes de Soporte o Informatica
                        $usuario = "1533";
                        $quien = "informatica.itavu@gmail.com";
                        $quien_nombre = "Plataforma ITAVU";
                        $asunto = "Resumen de Ticket (Sistemas) ".$fecha.":".$hora;
                        $contenido = "".$txtCorreo;
                        $usuario = "2809";
                        correo(nitavu_correo($usuario), nitavu_nombre($usuario), $quien, $quien_nombre, $asunto, $contenido, $usuario);
                    }



                }

                $txtBody = "";
            }

            // echo $txtBody;
                Tarea("1", "Envio Resumen Ticket Mañanero", TRUE); //Se actualiza la tarea
                echo "<img src='icon/ok.png' style='width:18px;'>";
    } else {
        echo "Fuera de Horario";
        echo "<img src='icon/x.png' style='width:18px;'>";
    }
    
  }

// notificacion_add("0", 'chat', $fecha, "", "Tarea de mantenimiento de reenvio de correos pendientes: (".fecha_larga($fecha)." - ".hora12($hora)."".$c." y fallos:".$x);






?>