<?php
require("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require("lib/curp_fun.php");
require("var_clean.php");
$id_aplicacion ="v002";
// error_reporting(0); //<-- para simular produccion
$NumContrato = VarClean($_POST['_NumContrato']);
$nitavu = VarClean($_POST['nitavu']);
// sleep(10);
echo "<script>$('#PanelLoader').css('background-color','rgb(16, 117, 13)');</script>";
$sql = "SELECT * from contratos where NumContrato='".$NumContrato."'";
$r = $Vivienda -> query($sql);
$n =  mysqli_num_rows($r);
echo "<script>$('#EdoPDFLoader').hide();</script>";
echo "<script>$('#EdoPDF').html('');</script>";

if ($n <= 0){
    Toast("No se han encontrado contratos con el numero ".$NumContrato."",2,"");
} else {
    echo "Se han encontrado ".$n." contratos";
    echo "<table width=100% class='table table-striped' style='font-size: 8pt;'>";
    echo "<th>Contrato</th>";
    echo "<th>Delegacion</th>";
    echo "<th style='cursor:pointer;' title='Esto es la delegación de donde fue migrada la información'>Delegacion Origen</th>";
    while($f = $r -> fetch_array())
    {
        echo "<tr>";
        echo "<td>";
        if (nitavu_dpto($nitavu)==55){//por ahora solo para Informatica
            echo "<img title='Visualizar Edo. de Cuenta con marcado de desface' src='icon/inspect.png' style='width:23px; cursor:pointer;' onclick='CargaContrato_PDF(".$f['OriginData'].",1);'>";
        }
        echo "
        <b title='Ver Edo. de Cuenta' class='link-primary' style='cursor:pointer;' onclick='CargaContrato_PDF(".$f['OriginData'].",0);'>".$f['NumContrato']."</b>
        
        </td>";
        echo "<td style='cursor:pointer;' title='IdDelegacion = ".$f['IdDelegacion']."'>".DelegacionNombre($f['IdDelegacion'])."</td>";
        echo "<td style='cursor:pointer;' title='OriginData = ".$f['OriginData']."'>".DelegacionNombre($f['OriginData'])."</td>";
        echo "</tr>";
    }
    echo "</table>";

}


?>

