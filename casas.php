

<?php 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");
?>



<?php

$id_aplicacion ="ap99"; //Id de la aplicacion a cargar
$nivel = aplicacion_nivel($id_aplicacion, $nitavu); 
if (sanpedro($id_aplicacion, $nitavu)==TRUE){echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
    if ($nivel==1){ // PUEDE AGREGAR Y ACTUALIZAR CASAS, ASÍ COMO DESLIGARLA DE LA SOLICITUD
        
        if (isset($_GET['IdCasa'])){ //<-- casa seleccionada
            $IdCasa = $_GET['IdCasa']; if (ValidaVAR($IdCasa)==TRUE){$IdCasa = LimpiarVAR($IdCasa);} else {$IdCasa = "";}

            //Variables por cada campo a guardar
            $Dato1Casa = "";

            //Buscar si existe el IdCasa
            if (BuscarCasa($IdCasa) == TRUE){ 
                $Dato1Casa = "Dato desde la BD"; //<-- Llenar las variables
            }
                //construir el formulario
                echo "<form action='' method='POST' enctype='multipart/form-data'>";
                echo "<table width=100%>";
                    echo "<tr><td width=80%>";
                    echo "<span><label>Fotografia</label>";
                        $ArchivoDeFoto = "FotosCasas/".$IdCasa.".jpg";        
                        if (file_exists($ArchivoDeFoto)) {   
                            echo "<img src='".$ArchivoDeFoto."' style='width:500px; height:500px; border-radius:10px;'>";
                        }
                        echo "<br><input type='file' name='ArchivoParaSubir'>";
                    echo "</span>";

                    echo "<div>";
                    echo "<label>Etiqueta del Dato</label>";
                    echo "<input type='text' name='NombreCampo' value='".$Dato1Casa."' required>";
                    echo "</div>";
                    
                    
                    echo "<div>";
                    echo "<label>Confirme presionando el boton</label>";
                    if (BuscarCasa($IdCasa) == TRUE){ 
                        echo "<input type='submit' name='BtnGuardar' value='Guardar' class='Mbtn btn-azulTam'>";
                    } else {
                        echo "<input type='submit' name='BtnActualizar' value='Actualizar' class='Mbtn btn-celesteTam'>";
                    }
                    echo "</div>";
                    
                    

                echo "</td><td><div id='Panel0' style='width:97%; border-radius:9px; background-color:#F0F0E1; padding:10px;'>"; //Panel Derecho con información relacionada con la historia de la casa o asignacion actual
                    //aqui info
                    echo "Informacion del Panel";


                echo "</div></td>";
                echo "</tr></table>";
                echo "</form>";
            }

        
        
        
        echo "<div id='Delegaciones' style='width:100%; background-color:#F0F0E1;'>";
                echo "<label>Selecciona una delegacion:</label>";
                //Un distinc sobre la tabla de las casa para mostrar las delegaciones disponibles para seleccionar
                $Consulta="select @@version as IdDelegacion";
                $r= $conexion -> query($Consulta);
                while($f = $r -> fetch_array()) {
                    $IdDelegacion = $f['IdDelegacion'];
                    $Delegacion = "Delegacion";
                    echo "<a href='?IdDelegacion=".$IdDelegacion."' title='Haga clic aqui para seleccionar la delegacion' style='' class='Mbtn btn-celesteTam' >".$Delegacion."</a>";
                }
        echo "</div>";

        //Tabla para mostrar la lista de las casas
        if (isset($_GET['IdDelegacion'])){ // si ya selecciono una delegacion
            $sql="
            select CONCAT('<a href=casas.php?IdCasa=',nitavu, '>',nitavu,'</a>') as IdCasa,
            nombre from empleados";
            echo "<div id='ListaDeCasas' style='background-color:#EEEEEE; width:95%; display:inline-block;
            border-radius:5px; padding:10px; margin-top:20px;'>";
            echo "<h2>Casas disponibles</h2>";
            TablaDinamica_MySQL("",$sql, "CasasDiv", "TablaCasas", "", 2); 
            echo "</div>";
        }
        


    }

    if ($nivel==2){ // SOLO PUEDE ENTRAR UNA DELEGACION Y PUEDE CONSULTARLAS, UNA OPCION PARA ELEGIR CASA DEL BENEFICIARIO
        $IdDelegacion = midelegacion_id($nitavu);


    }

    if ($nivel==3){ // SOLO CONSULTA Y ESTADISTICAS DE CASAS


    }
    
    

} else {mensaje("ERROR: no autorizado","");}
function BuscarCasa($IdCasa){
    // require("config.php");

    return TRUE;
}
include ("./lib/body_footer.php");

?>                                  

