<?php
require("seguridad.php"); 
// require_once("config.php");
// require_once("lib/funciones.php");
// require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion

//CONTRATOS FORANEOS

$IdDelegacion = $_POST['IdDel'];
$DelegacionNombre = delegacion_id($IdDelegacion);
$InformacionDelServidor = DatosDeConeccion($IdDelegacion);
$nitavu = $_POST['Nitavu'];

$consulta = "

select count(*) as Valor from busqueda_vivienda_informacionfinanciera where IdDelegacion<> ".$IdDelegacion."
";
$ConsultaDATA = DatosViviendaLarge($IdDelegacion, "WS TEST", "Test", $consulta);
$array = json_decode($ConsultaDATA, true);



if(is_array($array)){
    

     foreach ($array as $value) {
        if (isset($value['r'])){// si hay un error
            echo "Error: ".$value['r'];
            // echo "<span  title='".$consulta."'>".$value['Valor']."</span><br>";

        } else {
            
            // echo "".$value['Valor']."";
            echo "<span  title='".$consulta."'>".$value['Valor']."</span><br>";
            
         

        }
           
     }
} else {
    echo "<b style='display:block;' title='ERROR: No es un array' style='color:red;'>0</b>";
}
?>

