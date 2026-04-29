<?php include ("lib/body_head.php");include ("./lib/body_menu.php");?>

<!-- <script src="https://code.jquery.com/jquery-1.12.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="lib/timedropper.js"></script> -->

		

<?php 
$id_aplicacion ="ap85";
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	

    xd_update($id_aplicacion,$nitavu);//guarda la experiencia del usuario
    historia($nitavu, "Entro a la aplicacion,".$id_aplicacion.", para Administrar los horarios");
    
    
        echo "<h1>EXCEPCIONES DE TRABAJO FUERA DEL HORARIO</h1>";

        $sql = "
        select * from  horariosexcepcion where fecha=CURDATE()";
        $r= $conexion -> query($sql);
        echo "<table class='tabla'>";
        while($f = $r -> fetch_array()) {
            echo "<tr>";
            echo "<td width=20px>";
            echo ponerfoto("fotos/".$f['nitavu'].".jpg",'foto_actividad');
            echo "</td>";
            echo "<td><b style='font-size:14pt'>".nitavu_nombre($f['nitavu'])."</b><br>".nitavu_dpto_nombre($f['nitavu'])."";
            echo "<br>".fecha_larga($f['fecha'])."</td>";
            echo "<td>";
            if ($f['Autorizo'] == ''){
                echo "<a href='?eu=".$f['nitavu']."' class='Mbtn btn-default'>Autorizar</a>";

            } else {
                echo "Autorizado por ".$f['Autorizo']." - ".nitavu_nombre($f['Autorizo']);
            }

            echo "</td>";
            
            echo "</tr>";
        }
        echo "</table>";
    }


    // echo "-->".$_POST['DptoId'];
    // if (isset($_POST['DptoId'])){
    //     $HorarioInicio = $_POST['HorarioInicio'];
    //     $HorarioFin = $_POST['HorarioFin'];
    //     $HoradeCorteCaja = $_POST['HoradeCorteCaja'];
        
    //     $DptoId = $_POST['DptoId'];
    //     $sql = "UPDATE horarios  SET HorarioInicio='$HorarioInicio', HorarioFin='$HorarioFin', HoradeCorteCaja='$HoradeCorteCaja'  WHERE DptoId='$DptoId'";
        
         
    //     if ($conexion->query($sql) == TRUE)
    //     {
    //         historia($nitavu, "Guardo ,".addslashes($sql).", los horarios");
    //         mensaje("Horario Guardado con exito para el ".dpto_id($_POST['DptoID']),'horario.php');

    //     } else {
    //         mensaje("ERROR: al guardar el horario del Dpto ".$_POST['DptoID'],'horario.php');
    //     }
    // }


    // if (isset($_GET['eu'])){
    //     $quien = $_GET['eu'];
    //     if (ValidaVAR($quien)==TRUE){$quien = LimpiarVAR($quien);

    //         $sql = "UPDATE horariosexcepcion SET Autorizo='$nitavu' WHERE nitavu='$quien' and fecha=CURDATE()";
    //         $r = $conexion -> query($sql); if ($conexion->query($sql) == TRUE) {
    //             mensaje("Acceso autorizado correctamente para ".nitavu_nombre($quien),'horario.php?sol=');
    //         }
                    

    //     }
    // }




	} else {Mensaje("ERROR: no tienes acceso a esta aplicacion","");}







?>

<?php 
docdigital_no(FALSE, 1); //ahorra 1 hoja
include ("lib/body_footer.php"); ?>


