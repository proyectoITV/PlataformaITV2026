<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/yes_funciones.php");


if(isset($_POST['IdDelegacion']) and isset($_POST['IdPrograma']) and isset($_POST['Folio'])
and isset($_POST['Campo']) and isset($_POST['Valor']) and isset($_POST['NitavuMod']) ) 
    {
        $IdDelegacion = $_POST['IdDelegacion'];      
        $IdPrograma = $_POST['IdPrograma'];    
        $Folio = $_POST['Folio'];         
        $Campo=$_POST['Campo'];
        $Valor=$_POST['Valor'];
        $nitavuMod=$_POST['NitavuMod'];
        $IdSolicitante=$_POST['IdSolicitante'];
        $Tabla=$_POST['Tabla'];
        $ti='';

    
        echo "Tabla". $Tabla;
//vERIFICAMOS SI EL IDLOTE NO ESTA VACIO. SI NO ESTA VACIO NOS IDICA QUE SE VA HACER UNA ACTUALIZACION DE LA TABLA LOTES
//DE LO CONTARARIO EL CAMBIO SE REALIZARÁ EN LA TABLA DATOS EVALUACION  
if($Tabla=='solicitantes')
{    echo "entro";
     if (GuardarDatoSolicitantes($IdSolicitante, $Campo,  $Valor,$nitavuMod) == FALSE)
     {  echo "<script>console.log('Error al guadar en el IdSolicitante: ".$IdSolicitante.", Campo:".$Campo." con valor: ".$Valor."');</script>";  }
     else
     {   echo "<script>console.log('Se Actualizo IdSolicitante: ".$IdSolicitante.", Campo:".$Campo." con valor: ".$Valor."');</script>";}
}
else if($Tabla=='Domicilio')
{    
    if (GuardarDatoDatosDomicilio($IdDelegacion,$IdPrograma,$Folio, $Campo,  $Valor,$nitavuMod) == FALSE)
    {  echo "<script>console.log('Error al guadar solicitud con IdDelegacion " . $IdDelegacion." IdPrograma".$IdPrograma." Folio ".$Folio."el campo ".$Campo. " a <b> ".$Valor."<b>');</script>";  }
    else
    {   echo "<script>console.log('Actualizo  la solicitud con IdDelegacion " . $IdDelegacion." IdPrograma".$IdPrograma." Folio ".$Folio."el campo ".$Campo. " a <b> ".$Valor."</b>');</script>";}
}
else if($Tabla=='solicitudes')
{    
    if (GuardarDatoSolicitudes($IdDelegacion,$IdPrograma,$Folio, $Campo,  $Valor,$nitavuMod) == FALSE)
    {  echo "<script>console.log('Error al guadar la solicitud con IdDelegacion " . $IdDelegacion." IdPrograma".$IdPrograma." Folio ".$Folio."el campo ".$Campo. " a <b> ".$Valor."<b>');</script>";  }
    else
    {   echo "<script>console.log('Actualizo  la solicitud con IdDelegacion " . $IdDelegacion." IdPrograma".$IdPrograma." Folio ".$Folio."el campo ".$Campo. " a <b> ".$Valor."</b>');</script>";}
}
else if($Tabla=='Empleo')
{    
    if (GuardarDatoEmpleo($IdDelegacion,$IdPrograma,$Folio, $Campo,  $Valor,$nitavuMod) == FALSE)
    {  echo "<script>console.log('Error al guadar  la solicitud con IdDelegacion " . $IdDelegacion." IdPrograma".$IdPrograma." Folio ".$Folio."el campo ".$Campo. " a <b> ".$Valor."<b>');</script>";  }
    else
    {   echo "<script>console.log('Actualizo  la solicitud con IdDelegacion " . $IdDelegacion." IdPrograma".$IdPrograma." Folio ".$Folio."el campo ".$Campo. " a <b> ".$Valor."</b>');</script>";}
}



 //Escribimos otra vez el select               
 if($Campo == "IdRegimenSoc"){             
    if ($Valor <> '' ) {
        if ($Valor == 1) 
        {   $ti = $ti. '<option value="0" >NO ESPECIFICADO</option>';
            $ti = $ti. '<option value="1" selected>SOCIEDAD CONYUGAL</option>';	
            $ti = $ti. '<option value="2">SEPARACION DE BIENES </option>';	
        }
        else  if ($Valor == 2) 
        {   $ti = $ti. '<option value="0" >NO ESPECIFICADO</option>';
            $ti = $ti. '<option value="1" >SOCIEDAD CONYUGAL</option>';	
            $ti = $ti. '<option value="2" selected>SEPARACION DE BIENES</option>';	 
        }
                                                
    }  
    else
    {
        $ti = $ti. '<option value="0" >NO ESPECIFICADO</option>';
        $ti = $ti. '<option value="1" >SOCIEDAD CONYUGAL</option>';	
        $ti = $ti. '<option value="2" selected>SEPARACION DE BIENES</option>';
    }        
}
 //Escribimos otra vez el select               
 if($Campo == "IdEstadoCivil"){             
    if ($Valor <> '' ) {
        if ($Valor == 1) 
        {   $ti = $ti. '<option value="0" >NO ESPECIFICADO</option>';
            $ti = $ti. '<option value="1" selected>CASADO(A) </option>';	
            $ti = $ti. '<option value="4">SOLTERO(A) </option>'	;
        }
        else  if ($Valor == 4) 
        {   $ti = $ti. '<option value="0" >NO ESPECIFICADO</option>';
            $ti = $ti. '<option value="1" >CASADO(A) </option>';	
            $ti = $ti. '<option value="4" selected>SOLTERO(A) </option>';		 
        }
                                                
    }  
    else
    {
        $ti = $ti. '<option value="0" >NO ESPECIFICADO</option>';
        $ti = $ti. '<option value="1" >CASADO(A) </option>';	
        $ti = $ti. '<option value="4" >SOLTERO(A) </option>';
    }        
}
  //Escribimos otra vez el select               
  if($Campo == "IdOcupacion"){             
    if ($Valor <> '' ) {
        $sql="select * from ocupaciones";                
            $r2x = $Vivienda -> query($sql); 
                        
            while($fxx = $r2x -> fetch_array())
            {
                if($Valor == $fxx['IdOcupacion']){
                    $ti = $ti. '<option value="'.$fxx['IdOcupacion'].'" selected>'.$fxx['Ocupacion'].'</option>';	
                    
                }else{
                    $ti = $ti. '<option value="'.$fxx['IdOcupacion'].'">'.$fxx['Ocupacion'].'</option>';	
                }                      
            }
    }  
    else
    {
        $sql="select * from ocupaciones";                     
        $r2x = $conexion -> query($sql);                                   
        while($fxx = $r2x -> fetch_array())
            {                        
                $ti = $ti. '<option value="'.$fxx['IdOcupacion'].'">'.$fxx['Ocupacion'].'</option>';	   
            }
    }        
}

 //Escribimos otra vez el select               
 if($Campo == "NacionalidadSol"){  
             
    if ($Valor <> '' ) 
    {
        if (strpos($Valor, "MEXICA") !== false) 
        {   $ti = $ti. ' <option value="">Seleccione </option>'; 
            $ti = $ti. ' <option value="MEXICANO(A)" selected>MEXICANO(A) </option>';	
            $ti = $ti. ' <option value="EXTRANJERO(A)">EXTRANJERO(A) </option>';	
        }
        else
        {   $ti = $ti. ' <option value="">Seleccione </option>'; 
            $ti = $ti. ' <option value="MEXICANO(A)">MEXICANO(A) </option>';	
            $ti = $ti. ' <option value="EXTRANJERO(A)" selected>EXTRANJERO(A) </option>'; 
        }    
                                                    
        }  
        else
        {   $ti = $ti. ' <option value="">Seleccione </option>'; 
            $ti = $ti. ' <option value="MEXICANO(A)">MEXICANO(A) </option>';	
            $ti = $ti. ' <option value="EXTRANJERO(A)">EXTRANJERO(A) </option>'; 
        }        
}

 //Escribimos otra vez el select               
 if($Campo == "IdSexo"){             
    if ($Valor <> '' ) {
        $sql="SELECT	* from SEXO where IdSexo<3";             
            $r2x = $Vivienda -> query($sql); 
                        
            while($fxx = $r2x -> fetch_array())
            {
                if($Valor == $fxx['IdSexo']){
                    $ti = $ti. '<option value="'.$fxx['IdSexo'].'" selected>'.$fxx['Sexo'].'</option>';	
                    
                }else{
                    $ti = $ti. '<option value="'.$fxx['IdSexo'].'">'.$fxx['Sexo'].'</option>';	
                }                      
            }
    }  
    else
    {
        $sql="SELECT	* from SEXO where IdSexo<3";                   
        $r2x = $conexion -> query($sql);                                   
        while($fxx = $r2x -> fetch_array())
            {                        
                $ti = $ti. '<option value="'.$fxx['IdSexo'].'">'.$fxx['Sexo'].'</option>';	   
            }
    }        
}

//Escribimos otra vez el select               
if($Campo == "Idorigen"){             
    if ($Valor <> '' ) {
        $sql="SELECT	* from estados";         
            $r2x = $Vivienda -> query($sql); 
                        
            while($fxx = $r2x -> fetch_array())
            {
                if($Valor == $fxx['IdEstado']){
                    $ti = $ti. '<option value="'.$fxx['IdEstado'].'" selected>'.$fxx['Estado'].'</option>';	
                    
                }else{
                    $ti = $ti. '<option value="'.$fxx['IdEstado'].'">'.$fxx['Estado'].'</option>';	
                }                      
            }
    }  
    else
    {
        $sql="SELECT	* from estados";                  
        $r2x = $conexion -> query($sql);                                   
        while($fxx = $r2x -> fetch_array())
            {                        
                $ti = $ti. '<option value="'.$fxx['IdEstado'].'">'.$fxx['Estado'].'</option>';	   
            }
    }        
}


    echo $ti;

}else
{
    echo 'No se recibieron correctamente los datos, intentelo de nuevo';
}
?>