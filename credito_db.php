<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/yes_funciones.php");


if(isset($_POST['IdDelegacion']) and isset($_POST['IdPrograma']) and isset($_POST['Folio'])
and isset($_POST['Campo']) and isset($_POST['Valor']) and isset($_POST['NitavuMod']) and isset($_POST['IdLote']) )
    {
        $IdDelegacion = $_POST['IdDelegacion'];      
        $IdPrograma = $_POST['IdPrograma'];    
        $Folio = $_POST['Folio'];  
        $IdLote = $_POST['IdLote'];
        $Campo=$_POST['Campo'];
        $Valor=$_POST['Valor'];
        $nitavuMod=$_POST['NitavuMod'];
        $ti='';

    
//vERIFICAMOS SI EL IDLOTE NO ESTA VACIO. SI NO ESTA VACIO NOS IDICA QUE SE VA HACER UNA ACTUALIZACION DE LA TABLA LOTES
//DE LO CONTARARIO EL CAMBIO SE REALIZARÁ EN LA TABLA DATOS EVALUACION  
if($IdLote!='')
{    
    if (GuardarLotesDato($IdLote, $Campo,  $Valor,$nitavuMod) == FALSE)
    {  echo "<script>console.log('Error al guadar en el Idlote: ".$IdLote.", Campo:".$Campo." con valor: ".$Valor."');</script>";  }
    else
    {   echo "<script>console.log('Se Actualizo Idlote: ".$IdLote.", Campo:".$Campo." con valor: ".$Valor."');</script>";}
}
else
{
    if (GuardarDatoEnDatosEvaluacion($IdDelegacion, $IdPrograma,$Folio, $Campo,  $Valor,$nitavuMod) == FALSE)
    {   echo "<script>console.log('Error al guardar en DatosEvaluacion ".$IdDelegacion."-". $IdPrograma."-".$Folio.", Campo:".$Campo." con valor: ".$Valor."');</script>";      }
    else
    {  echo "<script>console.log('Se Actualizo con exito el dato en DatosEvaluacion: ".$IdDelegacion."-". $IdPrograma."-".$Folio.", Campo:".$Campo." con valor: ".$Valor."');</script>";     }

}       
    
    //Escribimos otra vez el select               
        if($Campo == "IdTipoMoneda"){
            if ($Valor <> '' ) {
                    $sql = "select * from tipomoneda";                  
                    $r2x = $Vivienda -> query($sql);                   
                    //$ti = $ti. '<option value="100">SELECCIONE UNA OPCION...</option>';
                    while($fxx = $r2x -> fetch_array())
                    {
                        if($Valor == $fxx['IdTipoMoneda']){
                            $ti = $ti. '<option value="'.$fxx['IdTipoMoneda'].'" selected>'.$fxx['TipoMoneda'].'</option>';	
                            
                        }else{
                            $ti = $ti. '<option value="'.$fxx['IdTipoMoneda'].'">'.$fxx['TipoMoneda'].'</option>';	
                        }                      
                    }
            }  
            else
            {
                $sql = "select * from tipomoneda"; 
                $r2x = $conexion -> query($sql);                                   
                while($fxx = $r2x -> fetch_array())
                    {                        
                        $ti = $ti. '<option value="'.$fxx['IdTipoMoneda'].'">'.$fxx['TipoMoneda'].'</option>';	   
                    }
            }    
        }
      
            //Escribimos otra vez el select               
            if($Campo == "IdPagoInicial"){             
                if ($Valor <> '' ) {
                    $sql="select * from tipopagoinicial";                  
                        $r2x = $Vivienda -> query($sql); 
                                       
                        while($fxx = $r2x -> fetch_array())
                        {
                            if($Valor == $fxx['IdPagoInicial']){
                                $ti = $ti. '<option value="'.$fxx['IdPagoInicial'].'" selected>'.$fxx['PagoInicial'].'</option>';	
                                
                            }else{
                                $ti = $ti. '<option value="'.$fxx['IdPagoInicial'].'">'.$fxx['PagoInicial'].'</option>';	
                            }                      
                        }
                }  
                else
                {
                    $sql="select * from tipopagoinicial";                   
                    $r2x = $conexion -> query($sql);                                   
                    while($fxx = $r2x -> fetch_array())
                        {                        
                            $ti = $ti. '<option value="'.$fxx['IdPagoInicial'].'">'.$fxx['PagoInicial'].'</option>';	   
                        }
                }        
            }

            //Escribimos otra vez el select               
            if($Campo == "AplicaGtsAdmon"){             
                if ($Valor <> '' ) {
                    $sql="select * from tipoaplicagtsadmon";                  
                        $r2x = $Vivienda -> query($sql); 
                                    
                        while($fxx = $r2x -> fetch_array())
                        {
                            if($Valor == $fxx['IdTipoAplicaGtsAdmon']){
                                $ti = $ti. '<option value="'.$fxx['IdTipoAplicaGtsAdmon'].'" selected>'.$fxx['TipoAplicaGtsAdmon'].'</option>';	
                                
                            }else{
                                $ti = $ti. '<option value="'.$fxx['IdTipoAplicaGtsAdmon'].'">'.$fxx['TipoAplicaGtsAdmon'].'</option>';	
                            }                      
                        }
                }  
                else
                {
                    $sql="select * from tipoaplicagtsadmon";                   
                    $r2x = $conexion -> query($sql);                                   
                    while($fxx = $r2x -> fetch_array())
                        {                        
                            $ti = $ti. '<option value="'.$fxx['IdTipoAplicaGtsAdmon'].'">'.$fxx['TipoAplicaGtsAdmon'].'</option>';	   
                        }
                }        
            }


        //Escribimos otra vez el select               
        if($Campo == "TipoPago"){             
            if ($Valor <> '' ) {
                $sql="select * from tipopago";                  
                    $r2x = $Vivienda -> query($sql); 
                                
                    while($fxx = $r2x -> fetch_array())
                    {
                        if($Valor == $fxx['IdTipoPago']){
                            $ti = $ti. '<option value="'.$fxx['IdTipoPago'].'" selected>'.$fxx['TipoPago'].'</option>';	
                            
                        }else{
                            $ti = $ti. '<option value="'.$fxx['IdTipoPago'].'">'.$fxx['TipoPago'].'</option>';	
                        }                      
                    }
            }  
            else
            {
                $sql="select * from tipopago";                   
                $r2x = $conexion -> query($sql);                                   
                while($fxx = $r2x -> fetch_array())
                    {                        
                        $ti = $ti. '<option value="'.$fxx['IdTipoPago'].'">'.$fxx['TipoPago'].'</option>';	   
                    }
            }        
        }

        
    //Escribimos otra vez el select               
    if($Campo == "TipoIntMoratorio"){             
        if ($Valor <> '' ) {
            $sql="select * from cattipointeres";                
                $r2x = $Vivienda -> query($sql); 
                            
                while($fxx = $r2x -> fetch_array())
                {
                    if($Valor == $fxx['IdTipoInteres']){
                        $ti = $ti. '<option value="'.$fxx['IdTipoInteres'].'" selected>'.$fxx['TipoInteres'].'</option>';	
                        
                    }else{
                        $ti = $ti. '<option value="'.$fxx['IdTipoInteres'].'">'.$fxx['TipoInteres'].'</option>';	
                    }                      
                }
        }  
        else
        {
            $sql="select * from cattipointeres";                   
            $r2x = $conexion -> query($sql);                                   
            while($fxx = $r2x -> fetch_array())
                {                        
                    $ti = $ti. '<option value="'.$fxx['IdTipoInteres'].'">'.$fxx['TipoInteres'].'</option>';	   
                }
        }        
    }

        echo $ti;
     

}else
{
    echo 'No se recibieron correctamente los datos, intentelo de nuevo';
}
?>