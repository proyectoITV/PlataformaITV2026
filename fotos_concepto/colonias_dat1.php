<?php
require("unica/seguridad.php"); 
// require_once("unica/config.php");
// require_once("unica/funciones.php");
// require_once("unica/flor_funciones.php");

error_reporting(0); //<-- para simular produccion

$IdDelegacion = $_POST['IdDelegacion'];
$DelegacionNombre = delegacion_id($IdDelegacion);
// $InformacionDelServidor = DatosDeConeccion($IdDelegacion);
$nitavu = $_POST['nitavu'];
$all = $_POST['all'];
$m = $_POST['m'];

$QueBusco = $_POST['QueColonia']; if (ValidaVAR($QueBusco)==TRUE){$QueBusco = LimpiarVAR($QueBusco);} else {$QueBusco = "";}
if ($all == 1) { // todos
    $MSSQL = "
        select  
        -- isnull((select count(*) from Vivienda_InformacionContratos WHERE Colonia COLLATE Latin1_General_CI_AS = ViviendaColoniasDetectadas.Colonia or  DomicilioColonia COLLATE Latin1_General_CI_AS = ViviendaColoniasDetectadas.Colonia and IdDelegacion = Vivienda_InformacionContratos.IdDelegacion),0) as Contratos,
        ViviendaColoniasDetectadas.* from ViviendaColoniasDetectadas where IdDelegacion = ".$IdDelegacion." order by Colonia
    ";
} else {
    $MSSQL = "
        
        select  
        isnull((select count(*) from Vivienda_InformacionContratos WHERE Colonia COLLATE Latin1_General_CI_AS = ViviendaColoniasDetectadas.Colonia or  DomicilioColonia  COLLATE Latin1_General_CI_AS = ViviendaColoniasDetectadas.Colonia and IdDelegacion = Vivienda_InformacionContratos.IdDelegacion),0) as Contratos,
        ViviendaColoniasDetectadas.* from ViviendaColoniasDetectadas where IdDelegacion = ".$IdDelegacion." and Colonia like '%".$QueBusco."%' order by Colonia
    ";
}
// echo $MSSQL;

$ConsultaDATA = DatosViviendaLarge($IdDelegacion, $nitavu, "Colonias", $MSSQL);
$array = json_decode($ConsultaDATA, true);


echo "<h4>Colonias detectadas:</h4>
<table class='tabla'>";

if(is_array($array)){
    

     foreach ($array as $value) {
        if (isset($value['r'])){// si hay un error
            mensaje("Error: ".$value['r'],'colonias.php?m=');

        } else {
            if ($value['TipoColonia']=='Colonia'){
                echo "<tr style='background-color:#B0CC26;' title='Colonia de  ITAVU'>";
            } else {
                echo "<tr title='Domicilio Particular'>";
            }
            
            echo "<td>";            
            echo "<a title='Haz clic para ver informacion de la Colonia'  style='display:block;' href='colonias_info.php?IdDelegacion=".$IdDelegacion."&Col=".$value['Colonia']."&m=".$_POST['m']."'>".$value['Colonia']."</a>";
            echo "</td>";
            echo "<td>";
            echo $value['Contratos'];
            echo "</td>";
            
            echo "</tr>";
         

        }
           
     }
} else {
    mensaje("ERROR: No es un array <br>".$MSSQL."<hr>".$ConsultaDATA,'colonias.php?m=');
}

echo "</table><br><label style='font-size:8pt;'>* Este es el resultado de una busqueda en las colonias de ITAVU y del domicilio particular del beneficiario. Iluminadas en color verde las registradas en ITAVU; segun las bases de datos.</label>";







?>

