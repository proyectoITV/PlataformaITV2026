<?php 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");

if(isset($_POST['x'])){
    $x = $_POST['x'];
    $FolioTramite = $_POST['FolioTramite'];
    $IdTipoSolicitud = $_POST['IdTipoSolicitud'];
    $IdCategoria = buscarDependientesAnteriores($FolioTramite);

    if($IdCategoria == FALSE){
        echo 'ERROR: Favor de comlibrse con el Dpto de Informatica.';
    }


    echo "<h1 class='accordion1' style='width:100%; margin: 0px;font-size: 10pt;font-family:Light; text-transform: uppercase;'>Datos Dependientes<img src='icon/flecha_abajo.png' style='width:18px; opacity:0.5;'></h1>";
    echo "<div class='panel'>";
       
    echo "<div class='elemento' style='background-color:#ffdea1;'><table width=100%><tr><td style='width:95%;'><label><b>CURP</b><br> <cite></cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
    echo "<tr><td><input  maxlength='18'  type='text' onkeyup='GuardarDato(".$FolioTramite.",0, ".$IdCategoria.")'  onkeypress='BuscaCURP(0,".$IdCategoria.", ".$FolioTramite.",1,".$IdTipoSolicitud."); mayus(this);'  name='0_".$IdCategoria."' id='0_".$IdCategoria."'></td><td width=13px><div style='display:none;' id='Loader0_".$IdCategoria."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='R0_".$IdCategoria."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";																		            
    echo "</div>";

    echo "<div class='elemento'><table width=100%><tr><td style='width:95%;'><label><b>Nombre</b><br> <cite></cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
    echo "<tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",1, ".$IdCategoria.")'  name='1_".$IdCategoria."' id='1_".$IdCategoria."'></td><td width=13px><div style='display:none;' id='Loader1_".$IdCategoria."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK1_".$IdCategoria."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
    echo "</div>";
    
    
    echo "<div class='elemento'><table width=100%><tr><td style='width:95%;'><label><b>Apellido Paterno</b><br> <cite></cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
    echo "<tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",2, ".$IdCategoria.")'  name='2_".$IdCategoria."' id='2_".$IdCategoria."'></td><td width=13px><div style='display:none;' id='Loader2_".$IdCategoria."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK2_".$IdCategoria."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
    echo "</div>";

    echo "<div class='elemento'><table width=100%><tr><td style='width:95%;'><label><b>Apellido Materno</b><br> <cite></cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
    echo "<tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",3, ".$IdCategoria.")'  name='3_".$IdCategoria."' id='3_".$IdCategoria."'></td><td width=13px><div style='display:none;' id='Loader3_".$IdCategoria."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK3_".$IdCategoria."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
    echo "</div>";
        
    echo "<div class='elemento'><label><b>Sexo</b><br> <cite></cite></label>";
    echo "<table width=100%><tr><td>";
    echo "<select  id='4_".$IdCategoria."' onchange='GuardarDato(".$FolioTramite.",4, ".$IdCategoria.");' name='4_".$IdCategoria."' style='margin-left: 0px; '>";
    
        $sql = "SELECT * FROM cat_sexo";
        $r2x = $conexion -> query($sql);
        echo  '<option value="9999">SELECCIONE UNA OPCION...</option>';
        while($fxx = $r2x -> fetch_array())
        {
           
                echo  '<option value="'.$fxx['IdSexo'].'">'.$fxx['Sexo'].'</option>';	
           
            
            
        }
    echo  "</select></td><td width=13px><div style='display:none;' id='Loader4_".$IdCategoria."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK4_".$IdCategoria."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";	
    echo  "</div>";

    echo "<div class='elemento'><table width=100%><tr><td style='width:95%;'><label><b>Fecha de Nacimiento</b><br> <cite></cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
    echo "<tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",5, ".$IdCategoria.")'  name='5_".$IdCategoria."' id='5_".$IdCategoria."'></td><td width=13px><div style='display:none;' id='Loader5_".$IdCategoria."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK5_".$IdCategoria."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
    echo "</div>";
    
    echo "<div class='elemento'><table width=100%><tr><td style='width:95%;'><label><b>Nacionalidad</b><br> <cite></cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
    echo "<tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",6, ".$IdCategoria.")'  name='6_".$IdCategoria."' id='6_".$IdCategoria."'></td><td width=13px><div style='display:none;' id='Loader6_".$IdCategoria."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK6_".$IdCategoria."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
    echo "</div>";

    echo "<div class='elemento'><label><b>Entidad Federativa</b><br> <cite></cite></label>";
    echo "<table width=100%><tr><td>";
    echo "<select  id='7_".$IdCategoria."' onchange='GuardarDato(".$FolioTramite.",7, ".$IdCategoria.");' name='7_".$IdCategoria."' style='margin-left: 0px; '>";
        
        $sql = "SELECT * FROM cat_estados";
        $r2x = $conexion -> query($sql);
        echo  '<option value="9999">SELECCIONE UNA OPCION...</option>';
        while($fxx = $r2x -> fetch_array())
        {
            
                echo  '<option value="'.$fxx['IdEstado'].'">'.$fxx['Estado'].'</option>';
         
                
            
        }
    echo  "</select></td><td width=13px><div style='display:none;' id='Loader7_".$IdCategoria."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK7_".$IdCategoria."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";	
    echo  "</div>";

    echo "<div class='elemento'><table width=100%><tr><td style='width:95%;'><label><b>Estatus Curp</b><br> <cite></cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
    echo "<tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",8, ".$IdCategoria.")'  name='8_".$IdCategoria."' id='8_".$IdCategoria."'></td><td width=13px><div style='display:none;' id='Loader8_".$IdCategoria."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK8_".$IdCategoria."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
    echo "</div>";

    echo "<div class='elemento'><label><b>Trabaja</b><br> <cite></cite></label>";
    echo "<table width=100%><tr><td>";
    echo "<select  id='20_".$IdCategoria."' onchange='GuardarDato(".$FolioTramite.",20, ".$IdCategoria.");' name='20_".$IdCategoria."' style='margin-left: 0px; '>";
    
        $sql = "SELECT * FROM cat_opciones";
        $r2x = $conexion -> query($sql);
        echo  '<option value="9999">SELECCIONE UNA OPCION...</option>';
        while($fxx = $r2x -> fetch_array())
        {
                echo  '<option value="'.$fxx['IdOpcion'].'">'.$fxx['Opcion'].'</option>';
         
        }

        echo  "</select></td><td width=13px><div style='display:none;' id='Loader20_".$IdCategoria."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK20_".$IdCategoria."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";	
        echo  "</div>";
       
    echo "<div class='elemento'><table width=100%><tr><td style='width:95%;'><label><b>Ingreso Mensual</b><br> <cite></cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
    echo "<tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",28, ".$IdCategoria.")'  name='28_".$IdCategoria."' id='28_".$IdCategoria."'></td><td width=13px><div style='display:none;' id='Loader28_".$IdCategoria."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK28_".$IdCategoria."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
    echo "</div>";

    if($IdTipoSolicitud == 3 || $IdTipoSolicitud == 0){
        echo "<div class='elemento'><label><b>Parentesco</b><br> <cite></cite></label>";
        echo "<table width=100%><tr><td>";
        echo "<select  id='137_".$IdCategoria."' onchange='GuardarDato(".$FolioTramite.",137, ".$IdCategoria.");' name='137_".$IdCategoria."' style='margin-left: 0px; '>";
        
            $sql = "SELECT * FROM parentesco";
            $r2x = $Vivienda -> query($sql);
            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
            while($fxx = $r2x -> fetch_array())
            {
                echo '<option value="'.$fxx['IdParentesco'].'">'.$fxx['Parentesco'].'</option>';	
            }
    
            echo  "</select></td><td width=13px><div style='display:none;' id='Loader137_".$IdCategoria."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK137_".$IdCategoria."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";	
            echo  "</div>";
    }else{
        echo "<div class='elemento'><table width=100%><tr><td style='width:95%;'><label><b>Parentesco</b><br> <cite></cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>";
        echo "<tr><td><input type='text' onkeyup='GuardarDato(".$FolioTramite.",102, ".$IdCategoria.")'  name='102_".$IdCategoria."' id='102_".$IdCategoria."'></td><td width=13px><div style='display:none;' id='Loader102_".$IdCategoria."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK102_".$IdCategoria."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";
        echo "</div>";
    }
    
        
    echo "</div>";
}


?>


