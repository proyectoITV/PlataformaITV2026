<?php
require("seguridad.php"); 
// require_once("config.php");
// require_once("lib/funciones.php");
// require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion

//CONTRATOS SANOS saldo

$IdDelegacion = $_POST['IdDel'];
$DelegacionNombre = delegacion_id($IdDelegacion);
$InformacionDelServidor = DatosDeConeccion($IdDelegacion);
$nitavu = $_POST['Nitavu'];

$consulta = "
select sum(Saldo_Moratorio) as Valor from busqueda_vivienda_informacionfinanciera where IdDelegacion=".$IdDelegacion." 
and IdPrograma NOT IN ( 240, 241 ) AND Cancelado=0
";
$ConsultaDATA = DatosViviendaLarge($IdDelegacion, $nitavu, "Saldos", $consulta);
$array = json_decode($ConsultaDATA, true);



if(is_array($array)){
    

     foreach ($array as $value) {
        if (isset($value['r'])){// si hay un error
            echo "Error: ".$value['r'];

        } else {
            
            echo "<span title='".$consulta."' > $ ".number_format($value['Valor'],2,'.',',')."</span>";
            echo "<div id='Div".$IdDelegacion."_MTDval' style='display:none;'>".$value['Valor']."</div>";   
            
         

        }
           
     }
} else {
    echo "<b style='display:block; color:red;' title='ERROR: No es un array' style='color:red;'>0</b>";
    echo "<div id='Div".$IdDelegacion."_MTDval' style='display:none;'>0</div>";   
}
?>

