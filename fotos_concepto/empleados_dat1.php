<?php
require("unica/seguridad.php"); 
require_once("unica/config.php");
require_once("unica/funciones.php");
require_once("unica/flor_funciones.php");

error_reporting(0); //<-- para simular produccion


$q = "";
if (isset($_GET['q']) and isset($_GET[user])){
    $nitavu = $_GET['user'];
    $busqueda = $_GET['q'];
    $sql="
    select 
        *
    from EmpleadosFull
    WHERE
    nitavu like '%".$busqueda."%' OR
    nombre like '%".$busqueda."%' OR
    DepartamentoNombre like '%".$busqueda."%'
    
    
    
    ";
    historia($_GET['user'],"EMPLEADOS: busco a ".$busqueda);
    // $sql = "select  *  from EmpleadosFull WHERE estado='' order by dpto";
    // echo $sql;
    $r= $conexion -> query($sql);
    while($f = $r -> fetch_array()) {
        if ($f['estado']<>'')
            {
                echo "<article class='Rojillo'>";
            }
            else {
                if (soytitular($f['nitavu'])<> 'FALSE'){
                    echo "<article class='Azulillo'>";
                } else {
                    echo "<article >";
                }
            }
        
        echo "<div id='EmpleadosFotoContainer'>";
        echo "<a href='empleados_edit.php?pes=gral&n=".$f['nitavu']."' title='No. de empleado: ".$f['nitavu']."'>";
        echo ponerfoto("fotos/".$f['nitavu'].".jpg",'FotoEmpleados');
        echo "</a>";
        echo "</div>";

        echo "<b style='font-family:Light; font-size:10pt;'>".$f['profesion_abr']." ".$f['nombre']."</b>";
        echo "<br><span style='font-family:Light; font-size:8pt;color:gray;'>".$f['puesto']." " .nitavu_dpto_nombre($f['nitavu'])."</span>";
        if (soytitular($f['nitavu']) == 'FALSE'){
            echo "<br><span style='font-family:Light; font-size:7pt;color:gray;'>* Jefe inmediato: ".nitavu_nombre(quienesmijefe($f['nitavu']))."</span>";
        } 
        

        if ($f['estado']==''){
            if (soytitular($nitavu)<>'FALSE'){
            if ($nitavu == '2809' or $nitavu=='1596' or $nitavu=='2772' or $nitavu=='2878'){ //sueldo solo aparece al director, edgar y al dir. administrativo. paralos demas si tienen acceso a la ap02 podran verlo y editalo
                    echo "<br><span style='font-family:Light; font-size:11pt;color:gray;'> Sueldo: $".number_format($f['sueldo'], 2, ".", ",")."</span>";
                }
            }

            if ($f['telefono_extension']<>""){
                echo "<span style='font-family:Light; font-size:10pt;color:black;'> | <img src='icon/tel.png' style='width:12px;'> <b>".$f['telefono_extension']."</b></span>";
            } 
            
        } else {
            echo "<span style='font-family:Light; font-size:10pt;color:black;'> <b>".$f['estado']."</b></span>";
        }
        


        echo "</article>";
    
    }


        
        
} else {echo "ERROR";}
       
    




















?>

