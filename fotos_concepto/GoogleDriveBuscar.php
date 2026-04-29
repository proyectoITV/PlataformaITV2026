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
if (isset($_GET['ruta']) and isset($_GET['file'])){
    // $directorio = opendir("G:\My Drive\RESPALDOS\Vivienda\Delegacion Abasolo"); //ruta actual
    // $ruta = "G:\My Drive\RESPALDOS\Vivienda\Delegacion Abasolo";
    
    $ruta = $_GET['ruta'];
    $Busqueda = $_GET['file'];
    chdir($ruta); //shell_exec("YourFile.exe");
    // echo "<div id='MyDirFile'>";
    $directorio = opendir($ruta); //ruta actual
    $encontrado = FALSE;
    $ArchivoEncontrado = "";
    while ($archivo = readdir($directorio)) //obtenemos un archivo y luego otro sucesivamente
    {
        if (is_dir($archivo))//verificamos si es o no un directorio
        {
           
        }
        else
        {
		 if ($archivo == $Busqueda){ //Encontrado
                $encontrado = TRUE;
                $ArchivoEncontrado = $archivo;
                
            }
//            echo $archivo."=".$Busqueda."<br>";
            
        }
    }
    
    
    if ($encontrado == TRUE){        
        echo "<img src='icon/ok.png' title='".$ArchivoEncontrado."' style='width:13px;'>"; 
    } else {
        echo "<img src='icon/x.png' title='No se encontro el archivo ".$ArchivoEncontrado."'style='width:13px;'>";
    }

    
    


    // echo "</div>";
        
}
?>
</body>
</html>