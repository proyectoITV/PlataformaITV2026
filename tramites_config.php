<?php
include("./lib/body_head.php");
include("./lib/body_menu.php"); 



$idDepartamento=nitavu_dpto($nitavu);
$id_aplicacion ="ap95";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
$nivel=3;
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    $MiDpto = nitavu_dpto($nitavu);
    $pags=20;
    historia($nitavu,'['.$id_aplicacion.'] Usando tramites App para Configurar el acceso'); 
    echo "<h5 >".app_detalle($id_aplicacion, $nitavu)."</div>";	

    echo "<br><br><table width=100%>";
    echo "<tr><td>";

    if (isset($_GET['IdTipoTramite'])){
        $IdTipoTramite = $_GET['IdTipoTramite']; if (ValidaVAR($IdTipoTramite)==TRUE){$IdTipoTramite = LimpiarVAR($IdTipoTramite);} else {$IdTipoTramite = "";}
        $sql="select * from tramitesListadePermisos WHERE IdTipoTramite='".$IdTipoTramite."' order by IdEmpleado ";
        // echo $sql;
       
        // echo "<a title='Retirar el Permiso' class='Mbtn btn-cancel' href='?IdTipoTramite=".$IdTipoTramite."&cancel=".$f['IdEmpleado']."'><img style='width:13px;' src='icon/cancel.png'></a>";
        //Cancelar usuario
        if (isset($_GET['cancel']) and isset($_GET['IdPermiso'])){
            $UsuarioParaCancelar = $_GET['cancel']; if (ValidaVAR($UsuarioParaCancelar)==TRUE){$UsuarioParaCancelar = LimpiarVAR($UsuarioParaCancelar);} else {$UsuarioParaCancelar = "";}
            $IdPermiso = $_GET['IdPermiso']; if (ValidaVAR($IdPermiso)==TRUE){$IdPermiso = LimpiarVAR($IdPermiso);} else {$IdPermiso = "";}
            if (TramitePermisoRetirar($IdTipoTramite, $UsuarioParaCancelar, $IdPermiso, $nitavu )==TRUE){
                mensaje("Se le han retirado correctamente los permisos al usuario seleccionado","tramites_config.php");

            } else {
                mensaje("ERROR: Al intentar retirar los permisos al usuario seleccionado","tramites_config.php");
            }

        }

        if (isset($_POST['btnPermiso'])){
            $IdPermiso = $_POST['IdPermiso']; if (ValidaVAR($IdPermiso)==TRUE){$IdPermiso = LimpiarVAR($IdPermiso);} else {$IdPermiso = "";}
            $IdEmpleado = $_POST['IdEmpleado']; if (ValidaVAR($IdEmpleado)==TRUE){$IdEmpleado = LimpiarVAR($IdEmpleado);} else {$IdEmpleado = "";}
            if (TramitePermisoAgregar($IdTipoTramite, $IdEmpleado, $IdPermiso, $nitavu ) == TRUE){
                mensaje("Se han otorgado correctamente los permisos","tramites_config.php");
            } else {
                mensaje("ERROR al otorgar los permisos","tramites_config.php");
            }

        }
        

        echo "<h4>Agregar Accesos a <b style='color:#54B3E0;'>".TramiteNombre($IdTipoTramite)." de ".TramiteProgramaNombre($IdTipoTramite)."</b>"."</h4>";
        echo "<table class='tabla'>";
        echo "<th></th><th>Empleado</th><th>Permiso</th><th>Acciones</th>";
        $r= $conexion -> query($sql);
        while($f = $r -> fetch_array()) {
            echo "<tr>";
                echo "<td style='background-color:#54B3E0;'>";
                
                if ($f['Permiso']==0){
                    echo "<img src='icon/avion.png' style='width:40px;'><br>";
                }
                
                if ($f['Permiso']==1){
                    echo "<img src='icon/vobo2.png' style='width:40px;'><br>";
                }
                
                if ($f['Permiso']==2){
                    echo "<img src='icon/check.png' style='width:40px;'><br>";
                }
                
                echo "</td>";


                echo "<td>";
                echo $f['IdEmpleado']." - ".$f['Empleado']."<br><cite class='tenue'>".$f['Departamento']."</cite>";
                echo "</td>";

                
                echo "<td>";
                echo $f['Permiso']." - <cite class='tenue'>".$f['PermisoDescripcion']."</cite>";
                echo "</td>";


                echo "<td width=20px>";
                echo "<a title='Retirar el Permiso' class='Mbtn btn-cancel' href='?IdTipoTramite=".$IdTipoTramite."&cancel=".$f['IdEmpleado']."&IdPermiso=".$f['Permiso']."'><img style='width:13px;' src='icon/cancel.png'></a>";
                echo "</td>";
            echo "</tr>";

        }
        echo "</table>";


        echo "<hr>";
        echo "<div id='Accesar' style='
        background-color:antiquewhite;
            padding: 10px;
            border: 1px solid orange;
            border-radius: 5px;
            text-align: left;
        
        '>";
        
        echo "<form id='tramitesAcceso' method='POST' accion=''> ";
        echo "<input type='hidden' id='IdTipoTramite' name='IdTipoTramite' value='".$IdTipoTramite."'>";
        echo "<div><input type='text' name='Tramite' value='".TramiteNombre($IdTipoTramite)." de ".TramiteProgramaNombre($IdTipoTramite)."' readonly></div>";

        echo "<div>";
        echo "<select id='IdPermiso' name='IdPermiso' required>";
        echo "<option value='0'>Captura</option>";
        echo "<option value='1'>VoBo</option>";
        echo "<option value='2'>Aprobar, Rechazar y Devolver</option>";
        echo "</select>";
        echo "</div>";

        echo "<span>";
        echo "<select id='IdPermiso' name='IdEmpleado' required>";
        $sql="
        select 
            nitavu,
            nombre,
            dpto as IdDpto,
            (select nombre from cat_gerarquia where id = IdDpto) as Departamento,
            puesto


            from empleados where estado='' order by nombre
        ";
        $r= $conexion -> query($sql);
        while($f = $r -> fetch_array()) {
            echo "<option value='".$f['nitavu']."'>".$f['nombre']." - ".$f['puesto']." de ".$f['Departamento']. "</option>";
        }
        echo "</select>";
        echo "</span>";

        echo "<div><input type='submit' name='btnPermiso' class='Mbtn btn-AzulTam' value='Otorgar Acceso'>";

        echo "</form>";
        echo "</div>";
    }


    



    echo "</td><td width=30%; valign=top>";
    //tramites ami cargo
    $sql="select * from tramitestipo WHERE IdDptoEjecucion='".$MiDpto."'";
    // echo $sql;
    echo "<div id='tramitesConfig'>";
    echo "<h4>tramites bajo responsabilidad de mi Departamento:</h4>";
    $r= $conexion -> query($sql);
    while($f = $r -> fetch_array()) {
        echo "<span><a href='?IdTipoTramite=".$f['IdTipoTramite']."' title='Haga clic aquí para configurar el Tramite'>".$f['NombreTramite']."</a> <br>[".$f['Programa']."]<cite>".$f['DescripcionTramite']."</cite></span>
        ";
    }
    echo "</div>";
    echo "</td></tr></table>";

} else {mensaje("ERROR: no tiene acceso a esta aplicacion","");}







include ("./lib/body_footer.php"); ?>