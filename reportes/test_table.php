<?php
include ("head.php");

//consulta mediante DataFromMySQL
$Query = "select nitavu, nombre from empleados limit 10"; 
$ClaseDiv = "container"; $ClaseTabla = ""; 
$IdCon = 1;  // Id de coneccion, de la tabla dbs
$Tipo = 4; // 0 = html, 1= DataTable, 2 = PDF, 3 = Excel, 4 = Word
$Tabla = DataFromMySQL($Query, $ClaseDiv,$ClaseTabla, $IdCon,$Tipo, $nitavu);
echo $Tabla;


//Consulta mediante el Webservice
// $WSTipo= 5; //0 = json del webservice, 1 = tabla html, 2 = DataTable, 3 pdf, 4=Excel, 5 = Word
// $IdCon = 4; //Conecciones de la tabla dbs
// $ClaseDiv = ""; $ClaseTabla = ""; //sugerencia= clase tabla
// $IdUser = $nitavu;
// echo DataFromSQLSERVERTOJSON($IdCon,"select top 15 IdLote,IdDelegacion,IdPrograma from lotes",$WSTipo,$ClaseTabla,$ClaseDiv, $nitavu);






include ("footer.php");
?>