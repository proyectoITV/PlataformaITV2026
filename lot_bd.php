<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/yes_funciones.php");


$IdLote = $_POST['Idlote'];       
$Campo=$_POST['Campo'];
$Valor=$_POST['Valor'];
$nitavuMod=$_POST['NitavuMod'];
$ti='';
if (GuardarLotesDato($IdLote, $Campo,  $Valor,$nitavuMod) == FALSE) {
  
    echo "<script>console.log('Error al guadar en el Idlote: ".$IdLote.", Campo:".$Campo." con valor: ".$Valor."');</script>"; 
    
}else{
    echo "<script>console.log('Se Actualizo Idlote: ".$IdLote.", Campo:".$Campo." con valor: ".$Valor."');</script>"; 
    //historia($nitavuMod, "Lotes: Actualizo Idlote: ".$IdLote.", Campo:".$Campo." con valor: ".$Valor."");

if($Campo=='IdConceptoCargo' and $Valor==37)
{
    
    if (GuardarLotesDato($IdLote, 'ExigirCostoEscritura',  1 ,$nitavuMod) == FALSE) {
  
        echo "<script>console.log('Error al guadar en el Idlote: ".$IdLote.", Campo:ExigirCostoEscritura con valor: 1');</script>"; 
        
    }else{
        echo "<script>console.log('Se Actualizo Idlote: ".$IdLote.", Campo:ExigirCostoEscritura con valor: 1');</script>"; 
      //  historia($nitavuMod, "Lotes: Actualizo Idlote: ".$IdLote.", Campo:ExigirCostoEscritura con valor: 1");
    
}
}    
    
    echo ValidarDatoActualLote($IdLote,$Campo);
    
       
    
    //Escribimos otra vez el select
               
        if($Campo == "IdEstatus"){
            if ($Valor <> '' ) {
                    $sql = "SELECT * FROM  catcstatuslote";                  
                    $r2x = $Vivienda -> query($sql);
                    //$ti = $ti. '<option value="100">SELECCIONE UNA OPCION...</option>';
                    while($fxx = $r2x -> fetch_array())
                    {
                        if($Valor == $fxx['IdEstatus']){
                            $ti = $ti. '<option value="'.$fxx['IdEstatus'].'" selected>'.$fxx['EstatusLote'].'</option>';	
                            
                        }else{
                            $ti = $ti. '<option value="'.$fxx['IdEstatus'].'">'.$fxx['EstatusLote'].'</option>';	
                        }
                        
                        
                    }
            }else{
                    $sql = "SELECT * FROM  catcstatuslote"; 
                    $r2x = $conexion -> query($sql);
                    //$ti = $ti. '<option value="100">SELECCIONE UNA OPCION...</option>';
                    while($fxx = $r2x -> fetch_array())
                    {
                        
                        $ti = $ti. '<option value="'.$fxx['IdEstatus'].'">'.$fxx['EstatusLote'].'</option>';	
                        
                    }
            }
    
        }

        if($Campo == "IdTipoLote"){
            if ($Valor <> '' ) {
                    $sql = "SELECT * FROM  cattipolote";                  
                    $r2x = $Vivienda -> query($sql);
                  
                    while($fxx = $r2x -> fetch_array())
                    {
                        if($Valor == $fxx['IdTipoLote']){
                            $ti = $ti. '<option value="'.$fxx['IdTipoLote'].'" selected>'.$fxx['TipoLote'].'</option>';	
                            
                        }else{
                            $ti = $ti. '<option value="'.$fxx['IdTipoLote'].'">'.$fxx['TipoLote'].'</option>';	
                        }
                        
                        
                    }
            }else{
                    $sql = "SELECT * FROM  cattipolote"; 
                    $r2x = $conexion -> query($sql);
                   
                    while($fxx = $r2x -> fetch_array())
                    {
                        
                        $ti = $ti. '<option value="'.$fxx['IdTipoLote'].'">'.$fxx['TipoLote'].'</option>';	
                        
                    }
            }
    
        }


        if($Campo == "IdConceptoCargo"){
            if ($Valor <> '' ) {
                    $sql = "SELECT* FROM descripcionmovimiento WHERE idTipoMov IN (35 , 37)";                  
                    $r2x = $Vivienda -> query($sql);
                    $ti = $ti. '<option value="0">SELECCIONE UNA OPCION...</option>';
                    while($fxx = $r2x -> fetch_array())
                    {                      
                        if($Valor == $fxx['idTipoMov']){
                            $ti = $ti. '<option value="'.$fxx['idTipoMov'].'" selected>'.strtoupper ($fxx['DescripcionMovimiento']).'</option>';	
                            
                        }else{
                            $ti = $ti. '<option value="'.$fxx['idTipoMov'].'">'.strtoupper ($fxx['DescripcionMovimiento']).'</option>';	
                        }
                        
                        
                    }
            }else{
                    $sql = "SELECT* FROM descripcionmovimiento WHERE idTipoMov IN (35 , 37)"; 
                    $r2x = $conexion -> query($sql);
                    $ti = $ti. '<option value="0">SELECCIONE UNA OPCION...</option>';
                    while($fxx = $r2x -> fetch_array())
                    {
                        
                        $ti = $ti. '<option value="'.$fxx['idTipoMov'].'">'.strtoupper ($fxx['DescripcionMovimiento']).'</option>';	
                        
                    }
            }
    
        }

        

        if($Campo == "ContratoMaestro"){
            if ($Valor <> '' ) {
                    $idplantilla=idPlantillaContrato($Valor);
                    $sql = "SELECT* FROM cat_plantillas ";                  
                    $r2x = $Vivienda -> query($sql);
                    $ti = $ti. '<option value="0">SELECCIONE UNA OPCION...</option>';
                    while($fxx = $r2x -> fetch_array())
                    {                      
                        if($idplantilla == $fxx['Id']){
                            $ti = $ti. '<option value="'.$fxx['Id'].'" selected>'.strtoupper ($fxx['Archivo']).'</option>';	
                            
                        }else{
                            $ti = $ti. '<option value="'.$fxx['Id'].'">'.strtoupper ($fxx['Archivo']).'</option>';	
                        }
                        
                        
                    }
            }else{
                    $sql = "SELECT* FROM cat_plantillas"; 
                    $r2x = $conexion -> query($sql);
                    $ti = $ti. '<option value="0">SELECCIONE UNA OPCION...</option>';
                    while($fxx = $r2x -> fetch_array())
                    {
                        
                        $ti = $ti. '<option value="'.$fxx['Id'].'">'.strtoupper ($fxx['Archivo']).'</option>';	
                        
                    }
            }
    
        }
        echo $ti;
}
    
?>