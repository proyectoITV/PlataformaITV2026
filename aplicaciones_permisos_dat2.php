<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
// require("vehiculos_fun.php");
// require_once("lib/flor_funciones.php");

// $sql="select * from ci_html";
// TablaDinamica_MySQL("",$sql, "DivIP", "IpTabla", "", 2,"",""); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal

    if (isset($_POST['search'])){
        $search = VarClean($_POST['search']);
        if ($search == ""){
            $sql = "
            select 
    
            * from empleadosfull_noactivity
            where Aplicaciones like '%".$search."%' and estado=''
            ";
        } else {
            $sql = "
            select 
    
            * from empleadosfull_noactivity
            where Aplicaciones like '%".$search."%' and estado=''
            ";
        }

    } else {
        $sql = "
			

        select 

        a.nitavu,
        a.nombre, a.puesto,
        (select nombre from cat_gerarquia where id = a.dpto) as departamento,

        (select count(*) from aplicaciones_permisos where nitavu = a.nitavu) as Apps,
				(select GROUP_CONCAT(NIdApp) from aplicacionespermisos where IdEmpleado = a.nitavu) as Aplicaciones

        from empleados a where estado='' order by nombre
        
        ";
    }

    // echo $sql;
			$r = $conexion -> query($sql);
            echo "<h3>Empleados con acceso a la App (".$search.") <b> ".app_nombre($search)."</b></h3>";
			echo "<br><br><table class='tabla ' ><th>Empleado</th><th></th><th>Ultima Visita</th>";
			while($f = $r -> fetch_array())
				{ // resultado de la busqueda.................
					if ($f['Apps'] > 0 ) {
                        //style='background-color:#53f046;'
						echo "<tr >";
					} else {
						echo "<tr>";
					}
					
					// echo "<option value='".$f['nitavu']."'>".$f['nombre']. " (".$f['puesto']." de ".$f['departamento'].")</option>";
					echo "<td width=80px>";
					echo ponerfoto("fotos/".$f['nitavu'].".jpg",'foto_actividad');
					echo "</td>";
					
					


					echo "<td><a href='?nitavu=".$f['nitavu']."'
					style='display:block; color:black;'
					><b style='font-size:13pt;'>".$f['nombre']."</b><br><cite>".$f['puesto']." ".$f['departamento']."</cite><br>No.ITAVU: <b style='font-size:10pt;font-weight:bold'>".$f['nitavu']."</b></a></td>";
					
                    echo "<td>".app_ultimavisita($search, $f['nitavu'])."</td>";
					echo "</tr>";
				}
		
			echo "</table>";
			
		
?>