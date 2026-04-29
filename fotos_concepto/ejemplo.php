<?php
include_once ("./unica/seguridad.php");
include_once ("./unica/config.php");
include_once ("./unica/funciones.php");

?>


<?php

 
    $sql = "select * from cat_gerarquia where nivel = 'dir' ";			
   
    $MisDepartamentos = '';    
        
        
    
    //echo $sql;
    $r= $conexion -> query($sql);
    while($f = $r -> fetch_array()) {

        echo '<br>'.nitavu_nombre($f['titular']).' -- ';
        $MisDepartamentos =  misdptos($f['titular']);
        //echo $MisDepartamentos;

        echo contar($MisDepartamentos);
        
    }




function contar($MisDepartamentos){
    require("unica/config.php");
    $sql2 = "select count(*) as n from empleados where dpto in ($MisDepartamentos) and estado = ''";
        //echo $sql2;
        $rc= $conexion -> query($sql2);
        if($f2 = $rc -> fetch_array())
        {
            echo $f2['n'];
        }
}



?>