<?php
require_once("config.php");
ob_start();

//archivo para recibir 

$idreporte = isset($_GET['n']) ? intval($_GET['n']) : 0;
$reportTableMap = [
    1 => 'fer_reporte',
    5 => 'encuestas_reportes_del',
];

if ($idreporte <= 0 || !isset($reportTableMap[$idreporte])) {
    die("ID de reporte inválido o tabla no configurada para id=" . $idreporte);
}

$targetTable = $reportTableMap[$idreporte];

// Obtener datos del registro reportes
$sqldatosreg="Select * from reportes_exporta where id=".$idreporte;
$idreporte1=$conexion-> query($sqldatosreg);

if(!$idreporte1) {
    die("Error en la consulta: " . $conexion->error);
}

if($fdr = $idreporte1 -> fetch_array())
	{
        $nomBD=$fdr['basededatos'];
        $query = trim($fdr['queryx']);
        $query = rtrim($query, ";");

        if ($nomBD=='produccion_itavu'){
            $dbConn = $conexion;
        } else {
            $dbConn = $Vivienda;
        }

        if (!$dbConn->select_db($nomBD)) {
            die("Error al seleccionar la base de datos " . $nomBD . ": " . $dbConn->error);
        }

        $deleteSql = "DELETE FROM `" . $dbConn->real_escape_string($targetTable) . "`";
        if (!$dbConn->query($deleteSql)) {
            die("Error al vaciar la tabla " . $targetTable . ": " . $dbConn->error);
        }

        $insertSql = "INSERT INTO `" . $dbConn->real_escape_string($targetTable) . "` " . $query;
        if (!$dbConn->query($insertSql)) {
            die("Error al llenar la tabla " . $targetTable . ": " . $dbConn->error);
        }

        $inserted = $dbConn->affected_rows;
        //echo "Tabla " . $targetTable . " actualizada correctamente. Filas insertadas: " . $inserted;
        //exit;
	} else {
        die("Error: No se encontraron datos en reportes_exporta para id=" . $idreporte);
	}
echo "1";    

$sql="";
$sql="SELECT `COLUMN_NAME` 
FROM `INFORMATION_SCHEMA`.`COLUMNS` 
WHERE `TABLE_SCHEMA`='".$nomBD."' AND 
   `TABLE_NAME`='".$targetTable."'";

echo "SQL para obtener columnas: " . $sql . "\n";
echo "<script>console.log('SQL para obtener columnas: " . $sql . "');</script>";
$rc= $dbConn -> query($sql);
$row_cnt = $rc->num_rows;
$cont=0;

 
if($row_cnt>0)
{		

    $salida = "";
    $salida .= "<table>"; 
    $salida .= "<tr colspan=10>".$fdr['nombrereporte']."<tr>"; 
    $salida .= "<tr colspan=10>".$fdr['subtituloreporte']." ".$fdr['dato1'] ."<tr>"; 
    $salida .= "<thead> <th style='background-color:gray;'>Num.</th>";
    //creo los encabezados
    
     while($cat = $rc -> fetch_array())
    { // resultado de la busqueda.................
    $salida .= " <th style='background-color:gray;'>".$cat['COLUMN_NAME']."</th>";    
	}
     $salida .="</thead>";
}
else{
    die("Error: No se encontraron columnas para la tabla ".$targetTable);    
}


$sqldatos="SELECT * FROM ".$targetTable;
$rcdat= $dbConn -> query($sqldatos);

$row_cntdat = $rcdat->num_rows;
$contdat=0;

  if($row_cntdat>0)
 {		
    $salida .="<tbody><tr>";
     while($catdat = $rcdat -> fetch_array())
            { // resultado de la busqueda.................
            
                $salida .= "<tr>";
               // mysql_data_seek ( $rc, 0);
                //mysql_data_seek ( $cat, 0);
                $salida .= "<td>".$contdat=$contdat+1;"</td>";		  
                //$contdat=$contdat+1;
                //ciclo de columna

                $rc2= $conexion -> query($sql);
               
                while($cat2 = $rc2 -> fetch_array())
                    { // resultado de la busqueda.................
                    $salida .= " <td>".$catdat[$cat2['COLUMN_NAME']]."</td>";    
                    }

                $salida .= "</tr>";
                            
            } 
     $salida .="</tr></tbody>";
}  
  $salida .="</table>";

/* iso-8859-1
ISO-8859-1
utf-8
WORD
header('Content-type: application/vnd.ms-word');
header("Content-Disposition: attachment; filename=archivo.doc");
header("Pragma: no-cache");
 */
//pruebas
  ini_set('display_errors', 1);
error_reporting(E_ALL);

/* header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=ejemplo.xls");

echo "Nombre\tEdad\n";
echo "Juan\t25\n";
echo "Ana\t30\n"; 
echo $sql; 
 */

 header("Content-type: application/vnd.ms-excel; charset=UTF-8");
//header("Content-Disposition: attachment; filename=ExportadoExcelprueba.xls");
header("Content-Disposition: attachment; filename=ExportadoExcel".$hora.".xls");
header("Pragma: no-cache");
header("Expires: 0");
ob_end_clean();
echo $salida; 
 

?>