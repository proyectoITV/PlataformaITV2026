<?php
//require("seguridad.php"); 
require("config.php");
require("lib/funciones.php");
// require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion

$IdDelegacion = $_POST['IdDel'];
// $IdDelegacion = 6;
$DelegacionNombre = delegacion_id($IdDelegacion);
$InformacionDelServidor = DatosDeConeccion($IdDelegacion);
$nitavu = $_POST['Nitavu'];
// $nitavu = "2809";




$infoBKultimos7dias2 ="";
$infoTODO2 = "";
$sql = "SELECT CONVERT(CHAR(100), SERVERPROPERTY('Servername')) AS Servidor, msdb.dbo.backupset.database_name as bd, MAX(msdb.dbo.backupset.backup_finish_date) AS ultimosrespaldos FROM   msdb.dbo.backupmediafamily  INNER JOIN msdb.dbo.backupset ON msdb.dbo.backupmediafamily.media_set_id = msdb.dbo.backupset.media_set_id      WHERE      msdb..backupset.type = 'D'     GROUP BY        msdb.dbo.backupset.database_name      ORDER BY          msdb.dbo.backupset.database_name, ultimosrespaldos";
// $sql = "select top (10) * FROM lotes";
$sqlData = DatosVivienda($IdDelegacion, "MONITOR", "PingDB", $sql);
//echo $sqlData;

if ($sqlData == FALSE){
    return FALSE;
} else {
    
    // echo $IdDelegacion.">".$sqlData."<br>";
    
    $array = json_decode(stripslashes($sqlData), true);    
    // var_dump($array);
    if(is_array($array)){   
        // echo "soy un array";
        foreach ($array as $value) {            
            $FechaUltimoRespaldo = substr($value['ultimosrespaldos'], 0, 10);
            $f=$fecha;
            for( $i = 1; $i >= 0; $i-- ){

                $FechaComparacion = date("d/m/Y", strtotime("$f   -$i day"));
                $FechaUltimoRespaldo = substr($value['ultimosrespaldos'], 0, 10);

                if ($FechaUltimoRespaldo == $FechaComparacion){
                    $infoBKultimos7dias2 = $infoBKultimos7dias2."<tr>"; 
                    $infoBKultimos7dias2 = $infoBKultimos7dias2."<td>".$value['Servidor'].", "; 
                    $infoBKultimos7dias2 = $infoBKultimos7dias2."BD: ".$value['bd'].", </td>"; 
                    $infoBKultimos7dias2 = $infoBKultimos7dias2."<td> ".$value['ultimosrespaldos']."</td>"; 
                    $infoBKultimos7dias2 = $infoBKultimos7dias2."<td> ".$FechaComparacion."</td>"; 
                    $infoBKultimos7dias2 = $infoBKultimos7dias2."<td> <img src='icon/ok.png' style='width:14px;'></td></tr>"; 
                    
                    
                 
                  
                } else {
                    // $infoTODO2 = $infoTODO2."Servidor: ".$value['Servidor'].", "; 
                    // $infoTODO2 = $infoTODO2."BD: ".$value['bd'].", "; 
                    // $infoTODO2 = $infoTODO2."Ultimo Respaldo: ".$value['ultimosrespaldos']."<br>";     
                    // $infoTODO2 =  $infoTODO2.$FechaUltimoRespaldo." = ".$FechaComparacion." == X <br>";

                    $infoTODO2 = $infoTODO2."<tr>"; 
                    $infoTODO2 = $infoTODO2."<td>".$value['Servidor'].", "; 
                    $infoTODO2 = $infoTODO2."BD: ".$value['bd'].", </td>"; 
                    $infoTODO2 = $infoTODO2."<td> ".$value['ultimosrespaldos']."</td>"; 
                    $infoTODO2 = $infoTODO2."<td> ".$FechaComparacion."</td>"; 
                    $infoTODO2 = $infoTODO2."<td> <img src='icon/x.png' style='width:14px;'></td></tr>"; 
                    
                }

               
            }
            
           

            

        }
        $tabla = "<BR><BR>".$InformacionDelServidor.":<BR><table class='tabla' width=100%><th>Servidor|BD</th><th>Respaldo </th> <th>Fecha Test </th><th>R</th>".$infoBKultimos7dias2.$infoTODO2."</table>";
       
        // echo $infoBKultimos7dias2."<hr>".$infoTODO2;
        echo "<div 
        
        class='MyModal' id='DivBKXmodal". $IdDelegacion."'>".$tabla."</div>";
        if ($infoBKultimos7dias2 == ""){
            historia("MONITOR BK", "Se Detecto por medio del Monitor de la Plataforma, que la base de datos de la Delegacion con Id ".$IdDelegacion." - ".$DelegacionNombre." No tiene respaldo reciente (ultimo  dia). ".$InformacionDelServidor.", ".$infoTODO2.". Lo consulto ".$nitavu."-".nitavu_nombre($nitavu));
            echo "
            <a href='#DivBKXmodal".$IdDelegacion."' rel='MyModal:open'>
            <img src='icon/x.png' style='width:14px; cursor:pointer;' >
            </a>
            ";    
            // echo "<script>
            //     var resumen = $('#MonitorDelegacionesBK2Resumen').val();
            //     resumen = resumen + '".$DelegacionNombre.",';
            //     $('#MonitorDelegacionesBK2Resumen').val(resumen);
            // </script>";
            // habla("Error en ".$DelegacionNombre);
            

            
            // return $infoTODO2;
        } else {
            historia("MONITOR BK OK", "Se Detectaron por medio del Monitor de la Plataforma, respaldos recientes de los ultimos 7 dias en la Delegacion con Id ".$IdDelegacion." - ".$DelegacionNombre." No tiene respaldo reciente (ultimo dia). ".$InformacionDelServidor.", ".$infoBKultimos7dias2.". Lo consulto ".$nitavu."-".nitavu_nombre($nitavu));
            echo "
            <a href='#DivBKXmodal".$IdDelegacion."' rel='MyModal:open'>
            <img src='icon/ok.png' style='width:14px; cursor:pointer;' >
            </a>
            ";    
            // return $infoBKultimos7dias2;
        }
        
    } else {
        return FALSE;
    }
}






if ($IdDelegacion == '0'){ // SI ES LA ULTIMA DECIR RESUMEN
    // echo "
    // <script>

    //     var Inforesumen = $('#MonitorDelegacionesResumen').val();
    //     var InforesumenBK = $('#MonitorDelegacionesBKResumen').val();
    //     var InforesumenBK2 = $('#MonitorDelegacionesBK2Resumen').val();

    //     var digo = 'No he podido conectarme a las Delegaciones de ' + Inforesumen + ', te guarde líneas de historia con los detalles, puedes consultarlo a tráves del reporte IFC';
    //     console.log(digo);
    //     if (InforesumenBK == ''){} else {
    //         digo = digo + '. Támbien te ínformo que no he encontrado respaldos recientes, de los últimos 7 dias en las delegaciones ' + InforesumenBK + '; estó lo podras ver en el reporte IFR.';
    //         console.log(digo);
    //     }

    //     if (InforesumenBK2 == ''){} else {
    //         digo = digo + '. Tampoco encontre algún respaldo de ayer de ' + InforesumenBK2
    //         console.log(digo);
    //     }
    //     console.log('final'+digo);

    //     habla(digo);
    // </script>
    // ";

}






















?>

