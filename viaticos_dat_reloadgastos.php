<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("viaticos_fun.php");
// require_once("lib/flor_funciones.php");

$IdViatico = VarClean($_POST['IdViatico']);
$sql = "select * from viaticosgastos WHERE IdViatico='".$IdViatico."'";
$r= $conexion -> query($sql);
echo "<table class='tabla'>";
echo "<th style = 'background-color: #ddc9a3; color: black; height: 20px;'>Fecha</th>";
echo "<th style = 'background-color: #ddc9a3; color: black;'>Almuerzo</th>";
echo "<th style = 'background-color: #ddc9a3; color: black;'>Comida</th>";
echo "<th style = 'background-color: #ddc9a3; color: black;'>Cena</th>";
echo "<th style = 'background-color: #ddc9a3; color: black;'>Hospedaje</th>";
$Dia  = 0;
while($f = $r -> fetch_array()) {
    $Dia = date("N",strtotime($f['Fecha']));
    if ($Dia == 6 OR $Dia == 7 ){
        echo "<tr style='background-color:orange;'>";
    } else {
        if (DiaInabil($f['Fecha'])==TRUE){
            echo "<tr style='background-color:red;'>";
        } else {
            echo "<tr>";
        }
    }
    if (DiaInabil($f['Fecha'])==TRUE){
        echo "<td title='Dia inabil' style='cursor:help;'> ".fecha_larga($f['Fecha'])."<br><b style='font-family:Compacta;'>".DiaInabil_comentario($f['Fecha'])."</b></td>";
    } else {
        echo "<td> ".fecha_larga($f['Fecha'])."</td>";
    }
    
    echo "<td title='IdAlimentacion=".$f['Almuerzo']."'>";

    echo "$ ".viaticos_IdAlimentaciontoCantidad($f['Almuerzo']);
    // if ($f['Almuerzo']>0){
    //     echo " <button onclick='delGastoAlmuerzo(".$f['IdGasto'].")' class='' style='padding:2px; opacity:0.7; margin-top:-5px; border-radius:50%;'><img src='icon/x.png' style='width:8px;'></button>";
    // }
    echo "</td>";

    echo "<td>";
    echo "$ ".viaticos_IdAlimentaciontoCantidad($f['Comida']);
    // if ($f['Almuerzo']>0){
    //     echo " <button onclick='delGastoComida(".$f['IdGasto'].")' class='' style='padding:2px; opacity:0.7; margin-top:-5px; border-radius:50%;'><img src='icon/x.png' style='width:8px;'></button>";
    // }
    echo "</td>";

    echo "<td>";
    echo "$ ".viaticos_IdAlimentaciontoCantidad($f['Cena']);
    // if ($f['Almuerzo']>0){
    //     echo " <button onclick='delGastoCena(".$f['IdGasto'].")' class='' style='padding:2px; opacity:0.7; margin-top:-5px; border-radius:50%;'><img src='icon/x.png' style='width:8px;'></button>";
    // }
    echo "</td>";

    echo "<td>";
    echo "$ ".viaticos_IdHospedajeCantidad($f['IdHospedaje']);
    // if ($f['IdHospedaje']>0){
    //     echo " <button onclick='delGastoHospedaje(".$f['IdGasto'].")' class='' style='padding:2px; opacity:0.7; margin-top:-5px; border-radius:50%;'><img src='icon/x.png' style='width:8px;'></button>";
    // }
    echo "</td>";

    echo "</tr>";

}
unset($r,$f,$sql);
?>