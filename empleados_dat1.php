<?php
// require("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion

//error_reporting(E_ALL); // Muestra todos los errores
//ini_set('display_errors', 1); // Asegura que se muestren en el navegador

$q = "";
if (isset($_GET['q']) and isset($_GET['user'])){

    $nitavu = $_GET['user'];
    $busqueda = $_GET['q'];
    $sql="
    select 
        *
    from empleadosfull_noactivity
    WHERE
    nitavu like '%".$busqueda."%' OR
    nombre like '%".$busqueda."%' OR
    DepartamentoNombre like '%".$busqueda."%'    
    order by nitavu DESC
    
    ";
    historia($nitavu,"EMPLEADOS: busco a ".$busqueda);
    // $sql = "select  *  from empleadosfull WHERE estado='' order by dpto";
        // echo $sql;
    $n=0;
    $r= $conexion -> query($sql);
    while($f = $r -> fetch_array()) {
        $n=$n+1;
        if ($f['estado']<>'')
            {
                echo "<article class='Rojillo'>";
            }
            else {
                
                
                
                    echo "<article >";
                
            }
        
        echo "<div id='EmpleadosFotoContainer'>";
        // echo "<a href='empleados_edit.php?pes=gral&n=".$f['nitavu']."' title='No. de empleado: ".$f['nitavu']."'>";
        // if ($f['EntroHoy']<=0){
        //     echo "<span title='No se conecto hoy'>";
        //     echo "<a href='empleados_e.php?n=".$f['nitavu']."'>";
        //     echo ponerfoto("fotos/".$f['nitavu'].".jpg",'FotoEmpleadosN');   
        //     echo "</a>";
        //     echo "</span>";
        // } else {
            echo "<span title='".$f['UltimaActividad']."'>";
            echo "<a href='empleados_e.php?n=".$f['nitavu']."'>";

            echo ponerfoto("fotos/".$f['nitavu'].".jpg",'FotoEmpleados');
            echo "</a>";
            echo "</span>";
        //}
        
        
        // echo "</a>";
        echo "</div>";
  
        echo "<span title='Numero de empleado = ".$f['nitavu']."' style='cursor:pointer;font-family:Compacta; font-size:9pt;'><b>".nombre_corto($f['nitavu'],0)."  ".nombre_corto($f['nitavu'],1)." </b>".nombre_corto($f['nitavu'],2)."</span>";
        
        echo "<br><span style='font-family:Compacta; font-size:8pt;color:gray;'>".$f['puesto']." - " .nitavu_dpto_nombre($f['nitavu'])."</span>";

        
        // echo "<b style='font-family:Light; font-size:10pt;'>".$f['profesion_abr']." ".$f['nombre']."</b>";
        // echo "<br><span style='font-family:Light; font-size:8pt;color:gray;'>".$f['puesto']." " .nitavu_dpto_nombre($f['nitavu'])."</span>";

        if (soytitular($f['nitavu']) == 'FALSE'){
            // echo "<br><span style='font-family:Light; font-size:7pt;color:gray;'>* Jefe inmediato: ".nitavu_nombre(quienesmijefe($f['nitavu']))."</span>";
        } 
        

        if ($f['estado']==''){
            if (soytitular($nitavu)<>'FALSE'){
            if ($nitavu == '2809' or $nitavu=='1596' or $nitavu=='2772' or $nitavu=='2878'){ //sueldo solo aparece al director, edgar y al dir. administrativo. paralos demas si tienen acceso a la ap02 podran verlo y editalo
                    // echo "<br><span style='font-family:Light; font-size:11pt;color:gray;'> Sueldo: $".number_format($f['sueldo'], 2, ".", ",")."</span>";
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
    if ($n<=0){        
        sentimental("No se han encontrado resultados con la busqueda : ".$busqueda."");
    }


        
        
} else 
    {
        echo "ERROR";
    }
       
    




















?>

