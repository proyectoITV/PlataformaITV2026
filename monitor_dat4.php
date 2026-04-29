<?php
//require("seguridad.php"); 
require("config.php");
require("lib/funciones.php");
// require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion

$IdDelegacion = $_POST['IdDel'];
$DelegacionNombre = delegacion_id($IdDelegacion);
$InformacionDelServidor = DatosDeConeccion($IdDelegacion);
$nitavu = $_POST['Nitavu'];
$RutaDelRespaldo = DelegacionRutaDeRespaldo($IdDelegacion);
$NombreDeLaBase = DelegacionNombreDb($IdDelegacion);
$NombreDelArchivo = $NombreDeLaBase."_".$fecha."_".$hora."_".$nitavu;
//limpiamos el nombre del archivo
$NombreDelArchivo = str_ireplace("-","_",$NombreDelArchivo);
$NombreDelArchivo = str_ireplace(":","_",$NombreDelArchivo);
$NombreDelArchivo = $NombreDelArchivo.".bak";
if ($RutaDelRespaldo <> ''){
//armar el script
$sql = "
BACKUP DATABASE [".$NombreDeLaBase."]
TO
  DISK = N'".$RutaDelRespaldo.$NombreDelArchivo."'
WITH
  NAME = N'".$NombreDelArchivo." - Backup',
  NOFORMAT, NOINIT, SKIP, REWIND, NOUNLOAD, COMPRESSION,  STATS = 10
  
";
// echo "<script>console.log('SQL para respaldo: ".$sql."');</script>";
$sqlData = DatosViviendaLarge($IdDelegacion, "MONITOR RESPALDO", "RESPALDO", $sql);
historia($nitavu,"Ejecutando Respaldo ".addslashes($sqlData)." desde ".addslashes($sql));

echo "<p>Respaldado <b>".$RutaDelRespaldo."".$NombreDelArchivo."</b> creado correctamente.</p>";
echo "<p>Favor de verificar que se suba a Google Drive</p>";


} else {
    echo "<script>NPush('Parametros incorrectos','RESPALDOS');</script>";
}




// if ($IdDelegacion == '0'){ // SI ES LA ULTIMA DECIR RESUMEN
//     echo "
//     <script>

//         var Inforesumen = $('#MonitorDelegacionesResumen').val();
//         var InforesumenBK = $('#MonitorDelegacionesBKResumen').val();
//         habla('No he podido conectarme a las Delegaciones de ' + Inforesumen + ', hay algún problema de conección, He guardado líneas  en la historia, con mas detalle. Puedes consultarlas en el Reporte llamado I EFE CE, Incidencias de Fallas de Conección, El resto de las delegación hubo éxito de conección. Tambien No he encontrado Respaldos recientes de los ultimos 7 dias en ' + InforesumenBK + ', Verificar que se hayan generado correctamente. Puedes consultar el reporte I EFE ERRE, Incidencia de Fallas de Respaldos, El resto de las delegación hubo éxito.');
//     </script>
//     ";

// }















?>

