<?php
require("lib/funciones.php");
require("config.php");


//Variables de entrada

if (isset($_GET['cp']) and isset($_GET['Clase']) and isset($_GET['FolioTramite'])){
    $ValorGuardado = TramiteDato($_GET['FolioTramite'], '60', $_GET['Clase']);
    $strOptionSelected = "";
    if ($ValorGuardado <> FALSE){
        $strOptionSelected = "<option value='".$ValorGuardado."' selected>".$ValorGuardado."</option>";

    } else {
        
    }
    
    //obtenemos el Estado segun el Codigo Postal
    $sql="select DISTINCT d_mnpio as Valor from CodigosPostales WHERE d_codigo = '".$_GET['cp']."'";	
    $r= $conexion -> query($sql);
    $strOption = "";    
    while($f = $r -> fetch_array()) {
        $strOption = $strOption."<option value='".$f['Valor']."'>".$f['Valor']."</option>";
    }
    echo '<script>';
    
    echo '$("#60_'.$_GET['Clase'].'").empty().prepend("'.$strOption.'");'; //<-- Llenamos el Estado
    echo '$("#60_'.$_GET['Clase'].'").prepend("'.$strOptionSelected.'");'; //<-- Se agrega como seleccionado el dato que tenga guardado
    // echo "GuardarDato(".$_GET['FolioTramite'].",60, ".$_GET['Clase'].")"; //<- Guardamos el elemento
    
    echo '</script>';


} else {
    echo "Sin Parametros";
}


?>