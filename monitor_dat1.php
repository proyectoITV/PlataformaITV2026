<?php
//require("seguridad.php"); 
require("config.php");
require("lib/funciones.php");
// require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion

$IdDelegacion = $_POST['IdDel'];
// echo "IdDelegacion dat ".$IdDelegacion;
$DelegacionNombre = delegacion_id($IdDelegacion);
$InformacionDelServidor = DatosDeConeccion($IdDelegacion);
$nitavu = $_POST['Nitavu'];
// echo "TEST";
if (DbPing($IdDelegacion) == TRUE){
    echo "<img src='icon/ok.png' style='width:14px; cursor:pointer;' title='".$InformacionDelServidor."' >";     
    // habla("".$DelegacionNombre.", Muy Bien!.");   
} else {

    echo "<img src='icon/x.png' style='width:14px; cursor:pointer;' title='".$InformacionDelServidor."'>";    
    // echo "<script>
    //     var resumen = $('#MonitorDelegacionesResumen').val();
    //     resumen = resumen + '".$DelegacionNombre.",';
    //     $('#MonitorDelegacionesResumen').val(resumen);
    // </script>";
    // habla("Error en ".$DelegacionNombre);
    historia("MONITOR SYS", "Detecto por medio del Monitor de la Plataforma, que la base de datos de la Delegacion con Id ".$IdDelegacion." - ".$DelegacionNombre." se encontraba fuera de linea. ".$InformacionDelServidor.". Lo consulto ".$nitavu."-".nitavu_nombre($nitavu));
    
    //si no esta en linea avizar
    // $Remitente = $nitavu;
    // $Mensaje = "<b>Problema al intentar conectarse a la base de datos de la delegacion de .".$f['nombre']."</b><p>Favor de verificar problema. <br> Buen dia</p><br>";
    // $Asunto = "BD no disponible ".$f['nombre'];
    // InformarProblema($Asunto, $Mensaje, $Remitente);

    
}
// if ($IdDelegacion == '65'){ // SI ES LA ULTIMA DECIR RESUMEN
//     echo "
//     <script>
//         var Inforesumen = $('#MonitorDelegacionesResumen').val();
//         habla('No he podido conectarme a las Delegaciones de ' + Inforesumen + ', hay algún problema de conección, He guardado líneas  en la historia, con mas detalle. Puedes consultarlas en el Reporte llamado I EFE CE, Incidencias de Fallas de Conección, El resto de las delegación hubo éxito.');
//     </script>
//     ";

// }









?>

