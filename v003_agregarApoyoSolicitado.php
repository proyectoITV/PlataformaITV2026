<?php 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");

if(isset($_POST['x'])){
    $x = $_POST['x'];
    $FolioTramite = $_POST['FolioTramite'];
    $IdTipoSolicitud = $_POST['IdTipoSolicitud'];
    $IdCategoria = buscarApoyosAnteriores($FolioTramite);

    if($IdCategoria == FALSE){
        echo 'ERROR: Favor de comlibrse con el Dpto de Informatica.';
    }


    echo "<h1 class='accordion1' style='width:100%; margin: 0px;font-size: 10pt;font-family:Light; text-transform: uppercase;'>Apoyo Solicitado<img src='icon/flecha_abajo.png' style='width:18px; opacity:0.5;'></h1>";
    echo "<div class='panel'>";
               
    echo "<div class='elemento'><label><b>Tipo de Apoyo</b><br> <cite></cite></label>";
    echo "<table width=100%><tr><td>";
    echo "<select  id='138_".$IdCategoria."' onchange='GuardarDato(".$FolioTramite.",138, ".$IdCategoria.");' name='138_".$IdCategoria."' style='margin-left: 0px; '>";
    
    $sql = "SELECT * FROM tipoapoyos";
    $r2x = $Vivienda -> query($sql);
    echo '<option value="9999">SELECCIONE UNA OPCION...</option>';
    while($fxx = $r2x -> fetch_array())
    {
        
        echo '<option value="'.$fxx['IdTipoApoyo'].'">'.$fxx['TipoApoyo'].'</option>';	
        
    }
    
    echo  "</select></td><td width=13px><div style='display:none;' id='Loader138_".$IdCategoria."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK138_".$IdCategoria."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";	
    echo  "</div>";

    echo "<div class='elemento'><label><b>Unidad de Medida</b><br> <cite></cite></label>";
    echo "<table width=100%><tr><td>";
    echo "<select  id='139_".$IdCategoria."' onchange='GuardarDato(".$FolioTramite.",139, ".$IdCategoria.");' name='139_".$IdCategoria."' style='margin-left: 0px; '>";
        
    $sql = "SELECT * FROM unidaddemedida";
    $r2x = $Vivienda -> query($sql);
    echo '<option value="9999">SELECCIONE UNA OPCION...</option>';
    while($fxx = $r2x -> fetch_array())
    {
        
        echo '<option value="'.$fxx['Idunidaddemedida'].'">'.$fxx['unidaddemedida'].'</option>';	
        
    }

    echo  "</select></td><td width=13px><div style='display:none;' id='Loader139_".$IdCategoria."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK139_".$IdCategoria."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";	
    echo  "</div>";

    echo "<div class='elemento'><table width=100%><tr><td style='width:95%;'><label><b>Cantidad</b><br> <cite></cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
    echo "<tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",140, ".$IdCategoria.")'  name='140_".$IdCategoria."' id='140_".$IdCategoria."'></td><td width=13px><div style='display:none;' id='Loader140_".$IdCategoria."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK140_".$IdCategoria."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
    echo "</div>";
    
    echo "<div class='elemento'><table width=100%><tr><td style='width:95%;'><label><b>Costo</b><br> <cite></cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
    echo "<tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",141, ".$IdCategoria.")'  name='141_".$IdCategoria."' id='141_".$IdCategoria."'></td><td width=13px><div style='display:none;' id='Loader141_".$IdCategoria."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK141_".$IdCategoria."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
    echo "</div>";

    echo "</div>";
}


?>


