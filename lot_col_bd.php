<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/yes_funciones.php");

$IdMunicipio = $_POST['IdMunicipio'];      
$IdColonia = $_POST['IdColonia'];       
$Campo=$_POST['Campo'];
$Valor=$_POST['Valor'];
$nitavuMod=$_POST['NitavuMod'];
$ti='';
if (GuardarColoniaDato($IdMunicipio,$IdColonia, $Campo,  $Valor,$nitavuMod) == FALSE) {
  
    echo "<script>console.log('Error al guadar la Colonia con IdMunicipio " . $IdMunicipio." and IdColonia=.".$IdColonia.", Campo:".$Campo." con valor: ".$Valor."');</script>"; 
    
}else{
 //   echo "<script>console.log('Se Actualizo la Colonia con IdMunicipio " . $IdMunicipio." and IdColonia=.".$IdColonia.", Campo:".$Campo." con valor: ".$Valor."');</script>"; 
   
}    
    
    echo 'validar '.ValidarDatoActualColonia($IdMunicipio,$IdColonia,$Campo);
    
       
    
    //Escribimos otra vez el select
               
        if($Campo == "Idtipoadquisicioncol"){
            if ($Valor <> '' ) {
                    $sql = "SELECT * FROM  tipoadquisicioncol";                  
                    $r2x = $Vivienda -> query($sql);
                    //$ti = $ti. '<option value="100">SELECCIONE UNA OPCION...</option>';
                    while($fxx = $r2x -> fetch_array())
                    {
                        if($Valor == $fxx['Idtipoadquisicioncol']){
                            $ti = $ti. '<option value="'.$fxx['Idtipoadquisicioncol'].'" selected>'.$fxx['tipoadquisicioncol'].'</option>';	
                            
                        }else{
                            $ti = $ti. '<option value="'.$fxx['Idtipoadquisicioncol'].'">'.$fxx['tipoadquisicioncol'].'</option>';	
                        }
                        
                        
                    }
            }else{
                $sql = "SELECT * FROM  tipoadquisicioncol";  
                    $r2x = $conexion -> query($sql);
                    //$ti = $ti. '<option value="100">SELECCIONE UNA OPCION...</option>';
                    while($fxx = $r2x -> fetch_array())
                    {
                        
                        $ti = $ti. '<option value="'.$fxx['Idtipoadquisicioncol'].'">'.$fxx['tipoadquisicioncol'].'</option>';	
                        
                    }
            }
    
        }


         echo $ti;
    
?>