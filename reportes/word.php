<?php
require ("rintera-config.php");
require ("components.php");

$id_rep = VarClean($_GET['id_rep']);
$IdUser = VarClean($_GET['IdUser']);

// var_dump($id_rep);

//Consulta mediante el Webservice
$WSTipo= 1; //0 = json del webservice, 1 = tabla html, 2 = DataTable, 3 pdf

$ClaseDiv = ""; $ClaseTabla = ""; //sugerencia= clase tabla
$IdUser = $IdUser;
$Query =  QueryReporte($id_rep);
$IdCon = IdConReporte($id_rep); 
$Tipo = 0;

if ($Query == "FALSE") {
    echo "<img src='icons/word.png' style='width:15px'>ERROR: Reporte ".$id_rep." con datos insuficientes";    
} else {
    // 0 = Base de mysql de rintera
    // 1 = MySQL
    // 2 = WebService SQLSERVERTOJSON
    // 3 = Webservice MSSQL ASP (este envia por post o get sql con la consulta)
    $ConType = ConType($IdCon);
// $Tipo = 1; // 0 = html, 1= DataTable, 2 = PDF, 3 = Excel, 4 = Word
$Contenido = "";
switch ($ConType) {
    case 0:  //rintera
        $Contenido = DataFromMySQL($ClaseDiv,$ClaseTabla, $Tipo, $IdUser, $id_rep);
        break;

    case 1:  //MySQL        
        $Contenido = DataFromMySQL($ClaseDiv,$ClaseTabla, $Tipo, $IdUser,$id_rep);
        break;

    case 2:  //MSQLSERVERTOJSON      
        
        // $Data =  DataFromSQLSERVERTOJSON($IdCon, $Tipo,$ClaseTabla,$ClaseDiv, $IdUser);
        $Contenido =  DataFromSQLSERVERTOJSON($id_rep, $Tipo, $ClaseTabla, $ClaseDiv, $IdUser);
        break;
    
}

    
    
$Titulo = TituloReporte($id_rep);
$Descripcion = DescripcionReporte($id_rep);
    $Archivo = $StringFecha."_".$id_rep."_".$IdUser."";
    $ContenidoFinal = "<h1>".$Titulo."</h1><p>".$Descripcion."</p>".$Contenido;
    // header('Content-type: application/vnd.ms-excel;charset=iso-8859-15');
    // header('Content-Disposition: attachment; filename='.$Archivo.'.xls');
    // echo $ContenidoFinal;


    header('Content-type: application/vnd.ms-word;charset=iso-8859-15');
    header('Content-Disposition: attachment; filename='.$Archivo.'.doc');
    echo $Contenido;
    
    
    
}








?>