<?php header('Access-Control-Allow-Origin: *');
//GoogleDrive.php en servidor beta

?>
<html>
<head>

<style>
body {

}
#MyDir {
    font-size: 8pt;
    font-family: Verdana;
    color: #626262;
    width:100%; 
}


</style>
</head>
<body>
<?php
if (isset($_GET['ruta'])){
    // $directorio = opendir("G:\My Drive\RESPALDOS\Vivienda\Delegacion Abasolo"); //ruta actual
    // $ruta = "G:\My Drive\RESPALDOS\Vivienda\Delegacion Abasolo";
    
    $ruta = $_GET['ruta'];
    chdir($ruta); //shell_exec("YourFile.exe");
    echo "<div id='MyDir'>";
    $row = exec('dir /q ',$output,$error);
    echo "<table class='tabla'>";
    while(list(,$row) = each($output)){
        echo "<tr><td>".$row, "</td></tr>";
    }
    echo "</table>";

    if($error){
        echo "Error : $error<BR>";
        exit;
    }
    echo "</div>";
        
}
?>
</body>
</html>