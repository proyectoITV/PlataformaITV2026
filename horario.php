<?php include ("lib/body_head.php");include ("./lib/body_menu.php");?>

<!-- <script src="https://code.jquery.com/jquery-1.12.1.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="lib/timedropper.js"></script> -->

		

<?php 
$id_aplicacion ="ap85";
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
// 1 = Acceso Total, 2 = Solo mi delegación tanto a aprobar como al horario, 3 = Solo puedo aprobar los que dependen de mi, sin mover el horario
// $nivel = 2;
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	

    xd_update($id_aplicacion,$nitavu);//guarda la experiencia del usuario
    historia($nitavu, "Entro a la aplicacion,".$id_aplicacion.", para Administrar los horarios");
    
    if (isset($_GET['sol'])){
        echo "<h1>EXCEPCIONES DE TRABAJO FUERA DEL HORARIO</h1>";
        if ($nivel == 1 ) {
            $sql = " select * from  horariosexcepcion where fecha=CURDATE()";
        }
        if ($nivel == 3  or $nivel==2) {
            $sql = " select * from  horariosexcepcion where fecha=CURDATE() and dpto in (".misdptos($nitavu).")";
        }
        // echo $sql;
        $r= $conexion -> query($sql);
        echo "<table class='tabla'>";
        while($f = $r -> fetch_array()) {
            echo "<tr>";
            echo "<td width=20px>";
            echo ponerfoto("fotos/".$f['nitavu'].".jpg",'foto_actividad');
            echo "</td>";
            echo "<td><b style='font-size:14pt'>".nitavu_nombre($f['nitavu'])."</b><br>".nitavu_dpto_nombre($f['nitavu'])."";
            echo "<br>".fecha_larga($f['fecha'])." | ".hora12($f['hora'])."</td>";
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
    } else{


    //horarios
    
    $sql="select DptoId as DptoID, (select nombre from cat_gerarquia where Id=DptoID) as Departamento, horarios.* from horarios order by Departamento";
    $r= $conexion -> query($sql);
    if ($nivel == 1 ) {echo "* puedes aprobar el acceso a todos.";}
    echo "<table class='tabla'>";
    echo "<th>Delegación</th><th>Inicio</th><th>Fin</th><th>Corte Caja </th><th></th>";
    while($f = $r -> fetch_array()) {
        if ($nivel == 1 ) {
                if ($f['DptoID']=='*'){
                    echo "<tr>";

                    echo "<form action='horario.php' method='POST'>";
                    echo "<td>";
                        echo "<b>Oficinas Centrales</b>";
                        echo "<input type='hidden' value='*' name='DptoId'>";
                    echo "</td>";
                
                    echo "<td>";
                        // echo "".$f['HorarioInicio'];
                        $horaN = substr($f['HorarioInicio'],0,5); 
                        echo "<input type='time' value='".$horaN."' name='HorarioInicio' id='HorarioInicio'>";
                    echo "</td>";
                    echo "<td>";
                        $horaN = substr($f['HorarioFin'],0,5); 
                        echo "<input type='time' value='".$horaN."' name='HorarioFin' id='HorarioFin'>";
                        
                    echo "</td>";
                
                    echo "<td>";
                        $horaN = substr($f['HoradeCorteCaja'],0,5); 
                        echo "<input type='time' value='".$horaN."' name='HoradeCorteCaja' id='HoradeCorteCaja'>";
                        
                        
                    echo "</td>";
                
                    echo "<td>";
                    echo "<button class='Mbtn btn-default'>Guardar</button>";
                    echo "</td>";
                
                    echo "</form>";
                    echo "</tr>";
                } else {
                    echo "<tr>";

                    echo "<form action='horario.php' method='POST'>";
                    echo "<td>";
                        // echo "<b>".$f['Departamento']."</b>[".$f['DptoID']."]";
                        echo "<b>".$f['Departamento']."</b>";
                        echo "<input type='hidden' value='".$f['DptoID']."' name='DptoId'>";
                    echo "</td>";
            
                    echo "<td>";
                        // echo "".$f['HorarioInicio'];
                        $horaN = substr($f['HorarioInicio'],0,5); 
                        echo "<input type='time' value='".$horaN."' name='HorarioInicio' id='HorarioInicio'>";
                    echo "</td>";
                    echo "<td>";
                        $horaN = substr($f['HorarioFin'],0,5); 
                        echo "<input type='time' value='".$horaN."' name='HorarioFin' id='HorarioFin'>";
                        
                    echo "</td>";
            
                    echo "<td>";
                        $horaN = substr($f['HoradeCorteCaja'],0,5); 
                        echo "<input type='time' value='".$horaN."' name='HoradeCorteCaja' id='HoradeCorteCaja'>";
                        
                        
                    echo "</td>";
            
                    echo "<td>";
                    echo "<button class='Mbtn btn-default'>Guardar</button>";
                    echo "</td>";
            
                    echo "</form>";
                    echo "</tr>";
            
                }
            } //fin nivel 1


            if ($nivel == 2 ) { // solo mi delegacion, no muestra oficinas centrales
                // echo "Solo puedo aprobar de mi departamento, asi como el horario";
                $MiDpto = nitavu_dpto($nitavu);
                if (CatgerarquiaNivel($nitavu)=='del'){
                //si soy delegacion distinguir y mostrar solo la mia
                if ($f['DptoID'] == $MiDpto){ //* validar al guardar que solo venga el autorizado */
                    echo "<tr>";

                    echo "<form action='horario.php' method='POST'>";
                    echo "<td>";
                        // echo "<b>".$f['Departamento']."</b>[".$f['DptoID']."]";
                        echo "<b>".$f['Departamento']."</b>";
                        echo "<input type='hidden' value='".$f['DptoID']."' name='DptoId'>";
                    echo "</td>";
            
                    echo "<td>";
                        // echo "".$f['HorarioInicio'];
                        $horaN = substr($f['HorarioInicio'],0,5); 
                        echo "<input type='time' value='".$horaN."' name='HorarioInicio' id='HorarioInicio'>";
                    echo "</td>";
                    echo "<td>";
                        $horaN = substr($f['HorarioFin'],0,5); 
                        echo "<input type='time' value='".$horaN."' name='HorarioFin' id='HorarioFin'>";
                        
                    echo "</td>";
            
                    echo "<td>";
                        $horaN = substr($f['HoradeCorteCaja'],0,5); 
                        echo "<input type='time' value='".$horaN."' name='HoradeCorteCaja' id='HoradeCorteCaja'>";
                        
                        
                    echo "</td>";
            
                    echo "<td>";
                    echo "<button class='Mbtn btn-default'>Guardar</button>";
                    echo "</td>";
            
                    echo "</form>";
                    echo "</tr>";
                }
            } else {//sino soy una delegacion no muestres nada

            }


            }//fin nivel 2


            
    }
    
    // el resto de ITAVU, Oficinas Centrales en DptoId = *
   
    echo "</table>";
    echo "<p>* La Plataforma reaccionara a estos horarios, cerrando el acceso a la misma con excepcion de titulares; así como la Caja cerrara a la hora de Corte Indicada</p>";

    
    echo "<a href='horario.php?sol=' class='Mbtn btn-tercero' style='color:black'>Aprobar accesos extratemporales</a>";
    echo "<br><br><br>";
    }


    // echo "-->".$_POST['DptoId'];
    if (isset($_POST['DptoId'])){
        $HorarioInicio = $_POST['HorarioInicio'];
        $HorarioFin = $_POST['HorarioFin'];
        $HoradeCorteCaja = $_POST['HoradeCorteCaja'];
        
        $DptoId = $_POST['DptoId'];
        $sql = "UPDATE horarios  SET HorarioInicio='$HorarioInicio', HorarioFin='$HorarioFin', HoradeCorteCaja='$HoradeCorteCaja'  WHERE DptoId='$DptoId'";
        
         
        if ($conexion->query($sql) == TRUE)
        {
            historia($nitavu, "Guardo ,".addslashes($sql).", los horarios");
            mensaje("Horario Guardado con exito para el ".dpto_id($_POST['DptoID']),'horario.php');

        } else {
            mensaje("ERROR: al guardar el horario del Dpto ".$_POST['DptoID'],'horario.php');
        }
    }


    if (isset($_GET['eu'])){
        $quien = $_GET['eu'];
        if (ValidaVAR($quien)==TRUE){$quien = LimpiarVAR($quien);

            $sql = "UPDATE horariosexcepcion SET Autorizo='$nitavu' WHERE nitavu='$quien' and fecha=CURDATE()";
            $r = $conexion -> query($sql); if ($conexion->query($sql) == TRUE) {
                mensaje("Acceso autorizado correctamente para ".nitavu_nombre($quien),'horario.php?sol=');
            }
                    

        }
    }




	} else {Mensaje("ERROR: no tienes acceso a esta aplicacion","");}







?>

<?php 
docdigital_no(FALSE, 1); //ahorra 1 hoja
include ("lib/body_footer.php"); ?>


