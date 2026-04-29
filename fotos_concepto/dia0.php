<?php include ("unica/body_head.php");include ("./unica/body_menu.php");?>



<?php 
$id_aplicacion ="ap83";
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<h5>".app_detalle($id_aplicacion)."</h5>";	

    xd_update($id_aplicacion,$nitavu);//guarda la experiencia del usuario
	historia($nitavu, "Entro a la aplicacion, para dar permisos de acceso a Bloqueo Maestro");

	
	echo "<div style='margin-top: 50px;' ></div> ";

	echo "<div id='req_mod' style='width:97%;' >";
	// echo "<h5><b>Otorgar permiso para usar Requisiciones</b></h>";

	echo "<form action='dia0.php' method='POST'>";
	echo "<input type='hidden' name='nitavu_' value='".$nitavu."'>";
	echo "<div><label>Seleccione el dia inabil</label>";
	echo "<input type='date' name='dia0' value='".$fecha."'></div>";

    echo "<span><label>Comentario o Justificación</label>";
	echo "<textarea name='comentario' style='height:100px;'></textarea></span>";

	echo "<span><label>* La plataforma cerrara operación en la mayoria de las aplicaciones, dejando acceso solamente a Directores, Subdirector y Jefes de Departamento. Habra una excepción de inicio de algunas aplicacion a solicitud, autorizadas por los jefes de dpto.</label>";
	echo "<input type='submit' value='Crear dia inábil' class='btn btn-default' name='BtnDia0'>";
	echo "</span>";
	echo "</form><br><br>";
	echo "</div>";




	echo "<div style='width:100%;'>";
	echo "<h1>Los siguientes dias estan marcados como inábiles</h1>";

    $sql = "SELECT count(*) as n FROM DiasInhabiles";
	$r2 = $conexion -> query($sql); while($fc = $r2 -> fetch_array()){
        if ($fc['n']>0){// si hay registros
            
            
            echo "<table class=tabla>";
            echo "<th>Dia inábil: </th><th>Autorizo</th><th></th>";
            $sql = "SELECT * FROM DiasInhabiles";
            $r21 = $conexion -> query($sql); while($f = $r21 -> fetch_array())
            {
                echo "<tr>";
                echo "<td><b style='font-size:12pt;'>".fecha_larga($f['Dia0'])."</b></td>";
                echo "<td> Registrado por <b>".nitavu_nombre($f['Autorizo'])."</b>";		
                echo "".nitavu_puesto($f['Autorizo'])." de ".nitavu_dpto_nombre($f['Autorizo']).
                "<br><span style='color:#00698C;'>".$f['Comentario']."</span></td>";
                
                if ($f['Dia0']==$fecha){// solo si es el mismo dia puedes eliminar el registro
                    echo "<td width=20px><a href='?eliminar=".$f['Dia0']."'><img src='icon/x.png' style='width:18px; height:18px;'></a>"."</td>";
                }
                

                echo "</tr>";

            }
            echo "</table>";

        } else {
            echo " * Aun no tiene fechas registradas";
        }
    }
    
	echo "<label>* Para eliminar una fecha del registro de clic en el boton Eliminar a la derecha de la lista; Solo podra eliminar el registro si es el mismo dia</label>";
	echo "</div>";
    
    


			

	if (isset($_POST['BtnDia0'])){
        $dia0 = $_POST['dia0'];
        $comentario = $_POST['comentario'];

		$sql = "INSERT INTO DiasInhabiles (dia0, Autorizo, Fecha, Hora, Comentario) VALUES('$dia0','$nitavu','$fecha','$hora','$comentario')";
		if ($conexion->query($sql) == TRUE)
			{	historia($nitavu, "Agrego el dia inabil ".$_POST['dia0']);				
				mensaje("Dia inabil, guardado correctamente. El  ".fecha_larga($dia0)." la plataforma cesara funciones con algunas excepciones",'dia0.php');			}
		else {
		
			mensaje("ERROR: Ha ocurrido un error".$sql,'');
		}
		


	}

	if (isset($_GET['eliminar'])){
		$sql = "DELETE FROM BloqueDiasInhabiles WHERE Dia0='".$_GET['eliminar']."'";
		if ($conexion->query($sql) == TRUE)
			{	historia($nitavu, "RETIRO el dia inabil de la plataforma a ".$_GET['eliminar']);				
				mensaje("Fecha eliminada correctamente",'stop.php');
			}
		else {
			
			mensaje("ERROR: Ha ocurrido un error".$sql,'dia0.php');
		}
	}


} else {Mensaje("ERROR: no tienes acceso a esta aplicacion","");}







?>

<?php 
docdigital_no(FALSE, 1); //ahorra 1 hoja
include ("unica/body_footer.php"); ?>


