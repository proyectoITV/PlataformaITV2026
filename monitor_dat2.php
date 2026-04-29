<?php
//require("seguridad.php"); 
require("config.php");
require("lib/funciones.php");
// require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion

$IdDelegacion = $_POST['IdDel'];
// $IdDelegacion = 12;
// echo "Delegacion monitor_dat2.php ID = ".$IdDelegacion;

$DelegacionNombre = delegacion_id($IdDelegacion);
$InformacionDelServidor = DatosDeConeccion($IdDelegacion);
$nitavu = $_POST['Nitavu'];
// $nitavu = "2809";



$infoBKultimos7dias ="";
$infoTODO = "";
$sql = "SELECT CONVERT(CHAR(100), SERVERPROPERTY('Servername')) AS Servidor, msdb.dbo.backupset.database_name as bd, MAX(msdb.dbo.backupset.backup_finish_date) AS ultimosrespaldos FROM   msdb.dbo.backupmediafamily  INNER JOIN msdb.dbo.backupset ON msdb.dbo.backupmediafamily.media_set_id = msdb.dbo.backupset.media_set_id      WHERE      msdb..backupset.type = 'D'     GROUP BY        msdb.dbo.backupset.database_name      ORDER BY          msdb.dbo.backupset.database_name, ultimosrespaldos";
$sql = "
SELECT 
	
	REPLACE(msdb.dbo.backupset.server_name,'\','/') AS Servidor,
	msdb.dbo.backupset.database_name AS bd,
	msdb.dbo.backupset.backup_finish_date as Fecha,
	-- MAX ( msdb.dbo.backupset.backup_finish_date ) AS ultimosrespaldos,
	(	SELECT REPLACE(msdb.dbo.backupmediafamily.physical_device_name ,'\','/') )as Archivo
	-- ,	msdb.dbo.backupmediafamily.*
FROM
	msdb.dbo.backupmediafamily
	INNER JOIN msdb.dbo.backupset ON msdb.dbo.backupmediafamily.media_set_id = msdb.dbo.backupset.media_set_id 
WHERE
    msdb..backupset.type = 'D' AND msdb.dbo.backupmediafamily.physical_device_name not like '%{%' 
Order by Fecha DESC
";
// $sql = "select top (10) * FROM lotes";
$sqlData = DatosVivienda($IdDelegacion, "MONITOR", "PingDB", $sql);
// echo $sqlData;

if ($sqlData == FALSE){
    return FALSE;
} else {
    
    // echo $IdDelegacion.">".$sqlData."<br>";
    // addslashes stripslashes
    // $sqlData = str_ireplace("|","/",$sqlData);
    // echo $sqlData;
    $array = json_decode($sqlData, true);    
    // $array = json_decode($sqlData, true);    
    // var_dump($array);
    if(is_array($array)){   
        // echo "soy un array";
        $c=1; $RR="";
        foreach ($array as $value) {            
            $FechasDeComparacion="";    
            $f=$fecha;$e=FALSE;
            for( $i = 3; $i >= 0; $i-- ){
                if ($i == 0 ){
                    $FechaComparacion = date("d/m/Y"); //fecha actual
                } else {
                    $FechaComparacion = date("d/m/Y", strtotime("$f   -$i day"));
                }
                $FechasDeComparacion = $FechasDeComparacion."(".$i.")".$FechaComparacion.", ";
                $FechaUltimoRespaldo = substr($value['Fecha'], 0, 10);

                if ($FechaUltimoRespaldo == $FechaComparacion){
                    if ($FechaUltimoRespaldo == date("d/m/Y") ){//hoyr
                        $infoResaltada = $infoResaltada."<tr style='background-color:#2dd701;'>"; 
                    } else {
                        $infoResaltada = $infoResaltada."<tr style='background-color:#ff7c05;'>"; 
                    }
                    
                            $infoResaltada = $infoResaltada."<td>".$value['Servidor'].", "; 
                            $infoResaltada = $infoResaltada."BD: ".$value['bd'].", </td>"; 
                            $infoResaltada = $infoResaltada."<td title='Se comparo con ".$FechasDeComparacion."'> ".$value['Fecha']."</td>"; 
                            // $infoResaltada = $infoResaltada."<td> ".$FechaComparacion."</td>"; 
                            // $infoResaltada = $infoResaltada."<td> <img src='icon/ok.png' style='width:14px;'></td>"; 

                            $Archivo = $value['Archivo'];                    
                            $ArchivoParaBuscar = DriveArchivoNombre($Archivo);
                            $Archivo = "<b style='font-family:Compacta; font-weight:normal;' title='".$Archivo."'>".$ArchivoParaBuscar."</b>";
                            $infoResaltada = $infoResaltada."<td> ".$Archivo."</td>"; 

                            
                            $Ruta = DelegacionRutaDrive($IdDelegacion);
                            $GoogleDriveResultado = GoogleDriveBusca($Ruta, $ArchivoParaBuscar);
                            $infoResaltada = $infoResaltada."<td>".$GoogleDriveResultado."</td></tr>"; 
                            // $RR = $GoogleDriveResultado."";

                            if ($c == 1 and $i<=1 ){ //si es la fecha actual o dos atras
                                // $RR = "[".$c.",".$i."]".$GoogleDriveResultado."";
                                $RR = $GoogleDriveResultado.""; //<-- esta es la primera vuelta, es decir fecha hoy
                            } 
                            else {
                                //el resto de las vueltas
                                $RR2 = "<img title='c=".$c.", i=".$i."Hay respaldo de los ultimos 3 dias, pero falta el de hoy o subirse al Google Drive' src='icon/veri.png' style='width:17px;'>";
                                // $RR = "...";

                            }
                    $e=TRUE;
                } else { // si no son de la fecha de criterio buscarlos de todas maneras

                    $RR3 = "<img title='Sin respaldos recientes detectados' src='icon/x.png' style='width:17px;'>";
                }
               
            }
            if ($e==FALSE){
                $infoTODO = $infoTODO."<tr>"; 
                $infoTODO = $infoTODO."<td>".$value['Servidor'].", "; 
                $infoTODO = $infoTODO."BD: ".$value['bd'].", </td>"; 
                $infoTODO = $infoTODO."<td title='Se comparo con ".$FechasDeComparacion."'> ".$value['Fecha']."</td>"; 
                // $infoTODO = $infoTODO."<td> ".$FechaComparacion."</td>"; 
                // $infoTODO = $infoTODO."<td> <img src='icon/x.png' style='width:14px;'></td>"; 
                $Archivo = $value['Archivo'];       
                $ArchivoParaBuscar = DriveArchivoNombre($Archivo);             
                $Archivo = "<b style='font-family:Compacta; font-weight:normal;' title='".$Archivo."'>".$ArchivoParaBuscar."</b>";                    
                $infoTODO = $infoTODO."<td> ".$Archivo."</td>"; 

                    $Ruta = DelegacionRutaDrive($IdDelegacion);
                    $GoogleDriveResultado = GoogleDriveBusca($Ruta, $ArchivoParaBuscar);
                    $infoTODO = $infoTODO."<td>".$GoogleDriveResultado."</td></tr>"; 

                
            }
            
           

            

        }
       
        $c=$c+1;
        $tabla = "<BR><BR>".$InformacionDelServidor.":<BR><table class='tabla' width=100%><th>Servidor|BD</th><th>Fecha </th> <th>Archivo en Servidor </th><th>Archivo en Google Drive</th>".$infoResaltada.$infoTODO."</table>";
       
        // echo $infoBKultimos7dias."<hr>".$infoTODO;
        echo "<div     
        class='MyModal'style='font-size:7pt;'  id='DivBKmodal". $IdDelegacion."'>".$tabla."</div>";
        echo "
        <a href='#DivBKmodal".$IdDelegacion."' rel='MyModal:open'>";
        if ($RR <> ''){ echo $RR;}
        else {
            if ($RR2 <> ''){ echo $RR2;} else {            
                if ($RR3 <> ''){ echo $RR3;}
            }
        }
        
        if (    $RR == '' and $RR2 == '' and $RR3=''){
            echo ":(";
        }
            

        
        echo "
            
        </a>";

        // if ($infoResaltada == ""){
            
        //     echo "
        //     <a href='#DivBKmodal".$IdDelegacion."' rel='MyModal:open'>
        //     <img src='icon/x.png' style='width:14px; cursor:pointer;' >
        //     </a>
        //     ";    
        //     historia("MONITOR BK", "Se Detecto por medio del Monitor de la Plataforma, que la base de datos de la Delegacion con Id ".$IdDelegacion." - ".$DelegacionNombre." No tiene respaldo reciente (ultimos 7 dias). ".$InformacionDelServidor.", ".$infoTODO.". Lo consulto ".$nitavu."-".nitavu_nombre($nitavu));
        //     // echo "<script>
        //     //     var resumen = $('#MonitorDelegacionesBKResumen').val();
        //     //     resumen = resumen + '".$DelegacionNombre.",';
        //     //     $('#MonitorDelegacionesBKResumen').val(resumen);
        //     // </script>";
        //     // habla("Error en ".$DelegacionNombre);
            

            
        //     // return $infoTODO;
        // } else {
        //     historia("MONITOR BK OK", "Se Detectaron por medio del Monitor de la Plataforma, respaldos recientes de los ultimos 7 dias en la Delegacion con Id ".$IdDelegacion." - ".$DelegacionNombre." No tiene respaldo reciente (ultimos 7 dias). ".$InformacionDelServidor.", ".$infoBKultimos7dias.". Lo consulto ".$nitavu."-".nitavu_nombre($nitavu));

        //     echo "
        //     <a href='#DivBKmodal".$IdDelegacion."' rel='MyModal:open'>
        //     <img src='icon/ok.png' style='width:14px; cursor:pointer;' >
        //     </a>
        //     ";    

            
        //     // return $infoBKultimos7dias;
        // }
        
    } else {
        return FALSE;
    }
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

