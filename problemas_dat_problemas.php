<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("lib/graficas_fun.php");


$sql = "select * from dashboard_problemas where fecha=curdate() order by IdProblema DESC";

$r= $conexion -> query($sql);   
echo "<h6 style='width: 100%;
text-align: center;
color: #eee;
font-size: 9pt;
margin-top: -5px;'>PROBLEMAS DETECTADOS ".fecha_larga($fecha).":</h6>";
echo "<table class='tabla_dark'>";
echo "<th>Que?</th>";
echo "<th>Cuando?</th>";
echo "<th>Quien?</th>";
echo "<th>Donde?</th>";
echo "<th width=50px>Que hago?</th>";
echo "<th width=50px>Ticket?</th>";
$c = 0;
while($f = $r -> fetch_array()) {

    if ($f['Actual']=='HOY'){
        if ($f['status']==0){
            echo "<tr style='background-color:#ff00005e;' title='Problema sin Resolver'>";
        } else {
            echo "<tr style='' title=''>";
        }
    } else {
        if ($f['status']==0){
            echo "<tr style='background-color:#ffa50033;' title='Problema sin Resolver Atrasado'>";
        } else {
            echo "<tr style=''>";
        }
    }

    
    if ($f['TAG'] =='LOGIN'){
        echo "<td> ".$f['IdProblema']."|  <b style='color:white; 
        background-color: #ff09ff;'>".$f['TAG'].":</b>   ".$f['Descripcion']."</td>";
    } else {
        echo "<td> ".$f['IdProblema']."|  <b style='color:white;'>".$f['TAG'].":</b>   ".$f['Descripcion']."</td>";
    }
    echo "<td> <b style='color:white;'>".hora12($f['hora'])." :</b>   ".$f['fecha']."</td>";
    echo "<td> <b style='color:white;'>".$f['IdEmpleado'].":</b>   ".$f['Empleado']."</td>";
    echo "<td> <b style='color:white;'>".$f['IdApp'].":</b>   ".$f['Aplicacion']."|".$f['Departamento']."</td>";
    echo "<td>";
    if ($f['status']==0){
        echo '
        <div class="form-check form-switch"  title="Switch para el status del Problema" style="cursor:pointer;">
            <input onclick="Status('.$f['IdProblema'].',1);" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" style="width:25px;" checked>
            
        </div>
        ';

        
    } else {
        echo '
        <div class="form-check form-switch" title="Switch para el status del Problema" style="cursor:pointer;">
            <input onclick="Status('.$f['IdProblema'].',0);"class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" style="width:25px;" >
            
        </div>
        ';
    }


    echo "</td>";
    echo "<td>";
    if ($f['status']==0){
        echo "<img src='icon/avion.png' style='width:23px'>";
    }
    echo "</td>";
    echo "</tr>";
    $c = $c +1;
}

    
unset($sql, $r, $f);




// //problemas no resueltos anteriores
// $sql = "select * from DashBoard_problemas where fecha<curdate() order by IdProblema DESC";
// $r= $conexion -> query($sql);   

// while($f = $r -> fetch_array()) {
//     if ($f['Actual']<>'HOY'){        
//         if ($f['status']==0){
//             echo "<tr style='background-color:#ffa50033;' title='Problema sin Resolver Atrasado'>";
//             if ($f['TAG'] =='LOGIN'){
//                 echo "<td> ".$f['IdProblema']."|  <b style='color:orange;'>".$f['TAG'].":</b>   ".$f['Descripcion']."</td>";
//             } else {
//                 echo "<td> ".$f['IdProblema']."|  <b style='color:white;'>".$f['TAG'].":</b>   ".$f['Descripcion']."</td>";
//             }
            
//             echo "<td> <b style='color:white;'>".hora12($f['hora'])." :</b>   ".$f['fecha']."</td>";
//             echo "<td> <b style='color:white;'>".$f['IdEmpleado'].":</b>   ".$f['Empleado']."</td>";
//             echo "<td> <b style='color:white;'>".$f['IdApp'].":</b>   ".$f['Aplicacion']."|".$f['Departamento']."</td>";
//             echo "<td>";
//             if ($f['status']==0){
//                 echo '
//                 <div class="form-check form-switch"  title="Switch para el status del Problema" style="cursor:pointer;">
//                     <input onclick="Status('.$f['IdProblema'].',1);" class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" style="width:25px;" checked>
                    
//                 </div>
//                 ';
        
                
//             } else {
//                 echo '
//                 <div class="form-check form-switch" title="Switch para el status del Problema" style="cursor:pointer;">
//                     <input onclick="Status('.$f['IdProblema'].',0);"class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" style="width:25px;" >
                    
//                 </div>
//                 ';
//             }
//             echo "</td>";

//             echo "<td>";
//             if ($f['status']==0){
//                 echo "<img src='icon/avion.png' style='width:23px'>";
//             }
//             echo "</td>";
        
//             echo "</tr>";



//         } else {
//             echo "<tr style=''>";
//         }
//     }

    
//    $c = $c +1;

// }
echo "</table>";


if ($c == 0){
    echo "
    <div style='background-color: #ce41b870;
    width: 50%;
    display: inline-block;
    padding: 10px;
    margin: 10px;
    border-radius: 5px;
    color: white;'>
        <b>Sin problemas</b> detectados el dia de hoy
    </div>";
}
    
unset($sql, $r, $f);




echo "<div class='GraficasDiv'>";
    $QueryG = "
    select DISTINCT left(hora,2) as Hora
    ,(select count(*) from dashboard_problemas where left(hora,2) = left(a.hora,2) and status=0 and fecha=curdate()) as Actividad
    from dashboard_problemas a where fecha=curdate() 

    ";
    $rF= $conexion -> query($QueryG);    
    $Datas = 0; $Labels="";
    while($Fr = $rF -> fetch_array()) {   
        $Datas.= $Fr['Actividad'].", ";
        $Labels.="'".$Fr['Hora']."',";
    }
    unset($rf);unset($Fr);
    $Datas = substr($Datas, 0, -1); //quita la ultima coma.
    $Labels = substr($Labels, 0, -1); //quita la ultima coma.

    echo '<div style="" class="Graficas">';    
    GraficaBarLine($Labels, $Datas, "Comportamiento x hora",1);
    echo '</div>';




    $QueryG = "
    select DISTINCT Departamento
    ,(select count(*) from dashboard_problemas where Departamento = a.Departamento and status=0 and fecha=curdate()) as Actividad
    from dashboard_problemas a where fecha=curdate() 

    ";
    $rF= $conexion -> query($QueryG);    
    $Datas = 0; $Labels="";
    while($Fr = $rF -> fetch_array()) {   
        $Datas.= $Fr['Actividad'].", ";
        $Labels.="'".$Fr['Departamento']."',";
    }
    unset($rf);unset($Fr);
    $Datas = substr($Datas, 0, -1); //quita la ultima coma.
    $Labels = substr($Labels, 0, -1); //quita la ultima coma.

    echo '<div style="" class="Graficas">';    
    GraficaPie($Labels, $Datas, "Concentracion");
    echo '</div>';

echo "</div>";
?>
 