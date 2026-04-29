<?php
require("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
// require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion

$txtBusqueda = $_POST['txtBusqueda'];
$txtIdMunicipio = $_POST['txtIdMunicipio'];
$nitavu = $_POST['nitavu'];

$txtBusqueda = $_POST['txtBusqueda']; if (ValidaVAR($txtBusqueda)==TRUE){$txtBusqueda = LimpiarVAR($txtBusqueda);} else {$txtBusqueda = "";}
$txtIdMunicipio = $_POST['txtIdMunicipio']; if (ValidaVAR($txtIdMunicipio)==TRUE){$txtIdMunicipio = LimpiarVAR($txtIdMunicipio);} else {$txtIdMunicipio = "";}

$LabelBusqueda="";
if ($txtIdMunicipio == ''){//todas
    $sql="select * from catcolonia  WHERE Colonia like '%".$txtBusqueda."%' order by IdMunicipio";
    $LabelBusqueda="* Buscando en todas las Colonias del Estado de Tamaulipas";
} else {//busca solo en el municipio
    $sql="select * from catcolonia  WHERE Colonia like '%".$txtBusqueda."%' and IdMunicipio = '".$txtIdMunicipio."' order by IdMunicipio";
    $LabelBusqueda="* Buscando en todas las Colonias del Municipio <b title='IdMunicipio=".$txtIdMunicipio."'>".municipio_nombre($txtIdMunicipio)."</b>";
}

// echo $sql;
$r= $Vivienda -> query($sql);
echo "<div id='Leyenda' style='font-size:7pt; width:100%; background-color: #f2f2f2;' title='Informacion para interpretar los colores en el listado'>";
echo "<span style='
color:purple;
display:inline-block;
margin: 5px;

width:100px;
'>Posible Error</span>";

echo "<span style='
color:red;
display:inline-block;
margin: 5px;

width:100px;
'>Moratorios</span>";



echo "<span style='
color:green;
display:inline-block;
margin: 5px;

width:100px;
'>Con Saldo</span>";


echo "</div>";
echo "<table class='tabla'>";

echo "<th>Colonia</th>";
// echo "<th width=50px></th>";

while($f = $r -> fetch_array()) {

    $info = InfoColonia($f['IdMunicipio'],$f['IdColonia']);
    $SaldoColonia = InfoColonia_Saldo($f['IdMunicipio'],$f['IdColonia']);
    $SaldoMoratorio = InfoColonia_Moratorio($f['IdMunicipio'],$f['IdColonia']);

    if ($SaldoColonia < 0 ){//ERROR DE CALCULO
        echo "<tr style='background-color:purple' title='Este registro de información es posible que contenga un error, favor de verificar y solicitar correccion con el area correspondiente'>";
    }  else {
        if ($SaldoMoratorio > 0){ //Si tiene Moratorio
            echo "<tr style='background-color:red' title='Esta colonia cuenta con rezago de moratorios'>";
        } else {
            if ($SaldoColonia > 0){
                echo "<tr style='background-color:green' title='Esta colonia no tiene moratorios'>";
            } else {
                echo "<tr style=''>";
                
            }
        }

    }
    

    
    echo "<td>";

  

    echo "<a href='#InfoCol".$f['IdMunicipio']."_".$f['IdColonia']."'
    rel='MyModal:open'
    class=''
    style='
    display:block;
    color:black;
    '>";
    if ($info == ''){ //* para indicar que no hay una estadistica de esta colonia
        echo "*";
    } else {
        
    }
    echo "<b  style='font-weight:bold; font-size:10pt;' title='IdColonia=".$f['IdColonia'].", IdMunicipio=".$f['IdMunicipio']." se capturo el ".$f['FechaCaptura']."'>".$f['Colonia']."</b> en ".municipio_nombre($f['IdMunicipio'])."";
    
    echo "</a></td>";
    // echo "<td>";
    // echo "<a href='#InfoCol".$f['IdMunicipio']."_".$f['IdColonia']."'
    // rel='MyModal:open'
    // class=''
    // style='
    
    // '>";
    // echo "<img src='icon/entrar.png' style='width:35px;'>";
    // echo "</a>";

    

    // echo "</td>";
    echo "</tr>";


    echo "<div id='InfoCol".$f['IdMunicipio']."_".$f['IdColonia']."' class='MyModal'>";
    echo "<h1>Colonia ".$f['Colonia']." de ".municipio_nombre($f['IdMunicipio'])."</h1>";
    
    if ($info == ''){
        echo "No se encontra estadistica guardada de esta colonia.";
    } else {
        echo $info;
    }
    echo "</div>";
}
echo "</table>";
echo "<br><br><label style='font-size:8pt; color:gray;'>* No hay una estadistica.</label><br><br>";









?>

