<?php
// require("seguridad.php"); 
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");

// error_reporting(0); //<-- para simular produccion



    $busqueda = VarClean($_GET['q']);


    if ($busqueda==''){
        sentimental("Escriba primero el nombre a buscar: ".$busqueda."");
    } else {
        $sql="
        select 
            *
        from empleadosfull_noactivity 
        WHERE
        nitavu like '%".$busqueda."%' OR
        nombre like '%".$busqueda."%' OR
        Direccion like '%".$busqueda."%' OR
        DepartamentoNombre like '%".$busqueda."%'    
        
        
        ";
        historia($nitavu,"viaticos busco empleados con: ".$busqueda);
        // $sql = "select  *  from empleadosfull WHERE estado='' order by dpto";
        // echo $sql;
        $n=0;
        $r= $conexion -> query($sql);
        echo "<div class='container'
        style='
            background-color:white;
            padding: 10px;
            border-radius: 16px;
        '
        
        >";

        echo "<h2 style='color: green;
        font-size: 19pt;'>Empleados de la busqueda: ".$busqueda."</h2>
        <table class='tabla'>";
        while($f = $r -> fetch_array()) {
            $n=$n+1;
            if ($f['estado']==''){
                echo "<tr>";
            } else {
                echo "<tr style='background-color:red;'>";
            }
            
                echo "<td width=20px>";
                echo ponerfoto("fotos/".$f['nitavu'].".jpg",'viaticosFotoE');   
                echo "</td>";
                

                echo "<td><b style='font-size:12pt'>".$f['nombre']."</b><br>".$f['puesto']." ".$f['DepartamentoNombre']."";
                echo "</td>";
                if ($f['estado']==''){
                    echo "<td class='pc'>Estado Laboral: Activo".$f['estado']."</td>";
                } else {
                    echo "<td class='pc'>Estado Laboral: ".$f['estado']."</td>";
                }
                if ($f['estado']==''){
                    echo "<td width=20px align=right><a style='color:#bc955c;;' href='?new=".$f['nitavu']."' title='haga clic aqui para Viaticar' class='btn-identidad-color1'>Viaticar</a></td>";
                } else {
                    echo "<td></td>";
                }
                
    

                echo "</tr>";
            
        }
        echo "</table>
        </div>";
        if ($n<=0){        
            sentimental("No se han encontrado resultados con la busqueda : ".$busqueda."");
        }
        
    }
        
       




















?>

