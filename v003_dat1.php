<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
 
    $FolioTramite = $_GET['Folio']; if (ValidaVAR($FolioTramite)==TRUE){$FolioTramite = LimpiarVAR($FolioTramite);} else {$FolioTramite = "";}
    $IdRequisito = $_GET['IdRequisito']; if (ValidaVAR($IdRequisito)==TRUE){$IdRequisito = LimpiarVAR($IdRequisito);} else {$IdRequisito = "";}
    $IdCategoria = $_GET['IdCategoria']; if (ValidaVAR($IdCategoria)==TRUE){$IdCategoria = LimpiarVAR($IdCategoria);} else {$IdCategoria = "";}
    $Valor = $_GET['value']; if (ValidaVAR($Valor)==TRUE){$Valor = LimpiarVAR($Valor);} else {$Valor = "";}
    $tipoInfo = $_GET['tipoInfo']; if (ValidaVAR($tipoInfo)==TRUE){$tipoInfo = LimpiarVAR($tipoInfo);} else {$tipoInfo = "";}
    $Usuario = $_GET['nitavu'];
    $municipio = $_GET['municipio'];
    $type = SolicitudRequisitoTipo($IdRequisito, $IdCategoria);
    $depende = encontrarDependenciadeRequisito($IdRequisito);
    if ($type == 'file'){
        
        $ruta = 'SolicitudesFiles';
        $NombreDelArchivo = $ruta."/".$IdCategoria."_".$FolioTramite."_".$IdRequisito.".pdf";
        $ArchivoTmp = $_FILES[$nombredelcontrol]['tmp_name'];
		if ($_FILES[$nombredelcontrol]['error'] !== 0) {
				//return 'Error al subir el archivo (¿demasiado grande?)';
		} else {
            if ( mime_content_type($_FILES[$nombredelcontrol]['tmp_name']) == 'application/pdf')
            {
                if (move_uploaded_file($ArchivoTmp, $NombreDelArchivo)) { //se subio correctamente
                    //entregar hipervinculo al archivo
                    echo "<a href='".$NombreDelArchivo."' download='MiRequisito".$IdRequisito.".pdf'><img src='icon/pdf.png' style='width:13px;'></a>";

                } else {
                    echo "ERROR: al subir el archivo, intentelo nuevamente.";
                }
            } else {
                echo "ERROR: no es un archivo valido";
            }
        }
        //SI TIENE DEPENDENCIA ES UN CHECKBOX
    } else if($depende <> '0'){
        
            //GUARDAMOS EL DATO DEL CHECKBOX EN TRUE O FALSE
        if(GuardarSolicitudDato($FolioTramite, $IdRequisito, $Valor, "", $Usuario, $IdCategoria,$tipoInfo) == FALSE) {
            
            echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito:".$IdRequisito." con valor: ".$Valor."');</script>"; 
        }else{
            //Y GUARDAMOS EL REQUISITO DEL CUAL DEPENDE POR DEFAULT PARA EL MOEMENTO DE LLENAR
            //LO PONGO EN 1 POR DEFAULT PARA QUE TENGA UN VALOR Y SABER QUE HAY CHECKBOX LLENOS
            if(GuardarSolicitudDato($FolioTramite, $depende, 1, "", $Usuario, $IdCategoria,$tipoInfo) == FALSE) {
                echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito:".$depende." con valor: ".$Valor."');</script>"; 
            }
        }
    
    
    }else {
        //SI ES EL REQUISTO DE LOCALIDAD O COLONIA, SE HACE OTRO TRATAMEINTO POR QUE DEPENDEN DEL MUNICIPIO SELECCIONADO
        if(($IdRequisito==40 ) || ($IdRequisito==41 )){
            $ti = ""; 
            
            if(GuardarSolicitudDato($FolioTramite, $IdRequisito, $municipio.'_'.$Valor, "", $Usuario, $IdCategoria,$tipoInfo)== FALSE) {
                echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito:".$IdRequisito." con valor: ".$Valor."');</script>"; 
                
            }else{
                if($IdRequisito == 40){
                    if ($Valor <> '' ) {
                        
                        $sql = "SELECT * FROM localidad WHERE IdMunicipio = ".$municipio."";
                        $r2x = $Vivienda -> query($sql);
                        $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                        while($fxx = $r2x -> fetch_array())
                        {
                            if($Valor == $fxx['IdLocalidad']){
                                $ti = $ti. '<option value="'.$fxx['IdLocalidad'].'" selected>'.$fxx['Nombre_Localidad'].'</option>';	
                            }else{
                                $ti = $ti. '<option value="'.$fxx['IdLocalidad'].'">'.$fxx['Nombre_Localidad'].'</option>';	
                            }
                        } 
                    }else{
                        $sql = "SELECT * FROM localidad WHERE IdMunicipio = ".$municipio."";
                        $r2x = $Vivienda -> query($sql);
                        $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                        while($fxx = $r2x -> fetch_array())
                        {
                            
                            $ti = $ti. '<option value="'.$fxx['IdLocalidad'].'">'.$fxx['Nombre_Localidad'].'</option>';	
                            
                        }
                    }
    
                }else{
                    if ($Valor <> '' ) {
                        
                        $sql = "SELECT * from catcolonia WHERE IdMunicipio = ".$municipio."";
                        $r2x = $Vivienda -> query($sql);
                        $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                        while($fxx = $r2x -> fetch_array())
                        {
                            if($Valor == $fxx['IdColonia']){
                                $ti = $ti. '<option value="'.$fxx['IdColonia'].'" selected>'.$fxx['Colonia'].'</option>';	
                            }else{
                                $ti = $ti. '<option value="'.$fxx['IdColonia'].'">'.$fxx['Colonia'].'</option>';	 
                            }
                        }
                    }else{
                        $sql = "SELECT * from catcolonia WHERE IdMunicipio = ".$municipio."";
                        $r2x = $Vivienda -> query($sql);
                        $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                        while($fxx = $r2x -> fetch_array())
                        {
                            $ti = $ti. '<option value="'.$fxx['IdColonia'].'">'.$fxx['Colonia'].'</option>';	
                        }  
                    }                      
                }
                echo $ti;
            }
            
            
        }else {
            $ti = "";
         

            //CUALQUIER OTRO REQUISITO
            if (GuardarSolicitudDato($FolioTramite, $IdRequisito,  $Valor, "", $Usuario, $IdCategoria,$tipoInfo) == FALSE) {
                echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito:".$IdRequisito." con valor: ".$Valor."');</script>"; 
                
            }else{
                
            // echo "<script>console.log('Se guardo correctamente: ".$FolioTramite.", IdRequisito:".$IdRequisito." con valor: ".$Valor."');</script>"; 
                echo "<script>console.log('Se Actualizo Folio: ".$FolioTramite.", IdRequisito:".$IdRequisito." con valor: ".$Valor."');</script>"; 
                historia($Usuario, "tramites: Actualizo Folio: ".$FolioTramite.", IdRequisito:".$IdRequisito." con valor: ".$Valor."");
                $type = SolicitudRequisitoTipo($IdRequisito, $IdCategoria);
                if ($type == 'select') {//Escribimos otra vez el select
                
                    if($IdRequisito == 244){
                       
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM estados";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdEstado']){ 
                                    $ti = $ti. '<option value="'.$fxx['IdEstado'].'" selected>'.$fxx['Estado'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdEstado'].'">'.$fxx['Estado'].'</option>';	
                                }
                            }
                        }else{
                            $sql = "SELECT * FROM estados";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdEstado'].'">'.$fxx['Estado'].'</option>';		 
                            }
                        }                     
                    }else if($IdRequisito == 4){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM cat_sexo";
                            $r2x = $conexion -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdSexo']){
                                    $ti = $ti. '<option value="'.$fxx['IdSexo'].'" selected>'.$fxx['Sexo'].'</option>';	
                                    
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdSexo'].'">'.$fxx['Sexo'].'</option>';	
                                }
                                
                                
                            }
                        }else{
                            $sql = "SELECT * FROM cat_sexo";
                            $r2x = $conexion -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                
                                $ti = $ti. '<option value="'.$fxx['IdSexo'].'">'.$fxx['Sexo'].'</option>';	
                                
                            }
                        }
                    }else if($IdRequisito == 7){
                        if ($Valor <> '' ) {
                                $sql = "SELECT * FROM cat_estados";
                                $r2x = $conexion -> query($sql);
                                $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                                while($fxx = $r2x -> fetch_array())
                                {
                                    if($Valor == $fxx['IdEstado']){
                                        $ti = $ti. '<option value="'.$fxx['IdEstado'].'" selected>'.$fxx['Estado'].'</option>';
                                        
                                    }else{
                                        $ti = $ti. '<option value="'.$fxx['IdEstado'].'">'.$fxx['Estado'].'</option>';
                                    }
                                        
                                    
                                }
                        }else{
                                $sql = "SELECT * FROM cat_estados";
                                $r2x = $conexion -> query($sql);
                                $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                                while($fxx = $r2x -> fetch_array())
                                {
                                    
                                    $ti = $ti. '<option value="'.$fxx['IdEstado'].'">'.$fxx['Estado'].'</option>';	
                                    
                                }
                        }
                    }else if($IdRequisito == 11 || $IdRequisito == 20 || $IdRequisito == 104 || $IdRequisito == 144 || $IdRequisito == 145 || $IdRequisito == 160 || $IdRequisito == 163 || $IdRequisito == 171){
                        if ($Valor <> '' ) {
                                $sql = "SELECT * FROM cat_opciones";
                                $r2x = $conexion -> query($sql);
                                $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                                while($fxx = $r2x -> fetch_array())
                                {
                                    if($Valor == $fxx['IdOpcion']){
                                        $ti = $ti. '<option value="'.$fxx['IdOpcion'].'" selected>'.$fxx['Opcion'].'</option>';	
                                    }else{
                                        $ti = $ti. '<option value="'.$fxx['IdOpcion'].'">'.$fxx['Opcion'].'</option>';
                                    }
                                }
                            }else{
                                $sql = "SELECT * FROM cat_opciones";
                                $r2x = $conexion -> query($sql);
                                $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                                while($fxx = $r2x -> fetch_array())
                                {
                                    
                                    $ti = $ti. '<option value="'.$fxx['IdOpcion'].'">'.$fxx['Opcion'].'</option>';	
                                    
                                }
                            }
                    }else if($IdRequisito == 12){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM estadocivil";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdEstadoCivil']){
                                    $ti = $ti. '<option value="'.$fxx['IdEstadoCivil'].'" selected>'.$fxx['EstadoCivil'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdEstadoCivil'].'">'.$fxx['EstadoCivil'].'</option>';
                                }
                            }
                        }else{
                            $sql = "SELECT * FROM estadocivil";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdEstadoCivil'].'">'.$fxx['EstadoCivil'].'</option>';	
                            }
                        }
                    }else if($IdRequisito == 13){
                        if ($Valor <> '' ) {
                            if($Valor == '0'){
                                $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                                $ti = $ti. '<option value="0" selected>NO ESPECIFICADO</option>';	
                                $ti = $ti. '<option value="1">SOCIEDAD CONYUGAL</option>';
                                $ti = $ti. '<option value="2">SEPARACION DE BIENES</option>';   
                            }else if($Valor == '1'){
                                $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                                $ti = $ti. '<option value="0">NO ESPECIFICADO</option>';	
                                $ti = $ti. '<option value="1" selected>SOCIEDAD CONYUGAL</option>';
                                $ti = $ti. '<option value="2">SEPARACION DE BIENES</option>';    
                            }else if($Valor == '2'){
                                $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                                $ti = $ti. '<option value="0">NO ESPECIFICADO</option>';	
                                $ti = $ti. '<option value="1">SOCIEDAD CONYUGAL</option>';
                                $ti = $ti. '<option value="2" selected>SEPARACION DE BIENES</option>'; 
                            }else{
                                $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                                $ti = $ti. '<option value="0">NO ESPECIFICADO</option>';	
                                $ti = $ti. '<option value="1">SOCIEDAD CONYUGAL</option>';
                                $ti = $ti. '<option value="2">SEPARACION DE BIENES</option>';   
                            }
                        }else{
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            $ti = $ti. '<option value="0">NO ESPECIFICADO</option>';	
                            $ti = $ti. '<option value="1">SOCIEDAD CONYUGAL</option>';
                            $ti = $ti. '<option value="2">SEPARACION DE BIENES</option>';    
                        }
                    }else if($IdRequisito == 15){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM tipoidentificacion";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdTipoIdentificacion']){
                                    $ti = $ti. '<option value="'.$fxx['IdTipoIdentificacion'].'" selected>'.$fxx['TipoIdentificacion'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdTipoIdentificacion'].'">'.$fxx['TipoIdentificacion'].'</option>';	
                                }
                                
                            }
                        }else{
                            $sql = "SELECT * FROM tipoidentificacion";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                
                                $ti = $ti. '<option value="'.$fxx['IdTipoIdentificacion'].'">'.$fxx['TipoIdentificacion'].'</option>';	
                                
                            }
                        }
                    }else if($IdRequisito == 19){
                        if ($Valor <> '' ) {
                        $sql = "SELECT * FROM nivelescolar";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdNivelEscolar']){
                                    $ti = $ti. '<option value="'.$fxx['IdNivelEscolar'].'" selected>'.$fxx['NivelEscolar'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdNivelEscolar'].'">'.$fxx['NivelEscolar'].'</option>';	
                                }
                            }
                        }else{
                        $sql = "SELECT * FROM nivelescolar";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdNivelEscolar'].'">'.$fxx['NivelEscolar'].'</option>';	
                            }
                        }
                    }else if($IdRequisito == 21){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM ocupaciones";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdOcupacion']){
                                    $ti = $ti. '<option value="'.$fxx['IdOcupacion'].'" selected>'.$fxx['Ocupacion'].'</option>';
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdOcupacion'].'">'.$fxx['Ocupacion'].'</option>';
                                }	
                                
                            }
                        }else{
                            $sql = "SELECT * FROM ocupaciones";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                
                                $ti = $ti. '<option value="'.$fxx['IdOcupacion'].'">'.$fxx['Ocupacion'].'</option>';	
                                
                            }
                        }                      
                    }else if($IdRequisito == 25){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM tipotrabajo";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['Idtipotrabajo']){
                                    $ti = $ti. '<option value="'.$fxx['IdTipoTrabajo'].'" selected>'.$fxx['TipoTrabajo'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdTipoTrabajo'].'">'.$fxx['TipoTrabajo'].'</option>';
                                }
                            }
                        }else{
                            $sql = "SELECT * FROM tipotrabajo";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                
                                $ti = $ti. '<option value="'.$fxx['IdTipoTrabajo'].'">'.$fxx['TipoTrabajo'].'</option>';	
                                
                            }
                        }                     
                    }else if($IdRequisito == 30){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM prestaciones";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdPrestacion']){
                                    $ti = $ti. '<option value="'.$fxx['IdPrestacion'].'" selected>'.$fxx['Prestacion'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdPrestacion'].'">'.$fxx['Prestacion'].'</option>';
                                }
                            }
                        }else{
                            $sql = "SELECT * FROM prestaciones";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdPrestacion'].'">'.$fxx['Prestacion'].'</option>';	
                            } 
                        }                      
                    }else if($IdRequisito == 31){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM tiposcasa";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdTipoCasa']){
                                    $ti = $ti. '<option value="'.$fxx['IdTipoCasa'].'" selected>'.$fxx['TipoCasa'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdTipoCasa'].'">'.$fxx['TipoCasa'].'</option>';
                                }
                                
                            }       
                        }else{
                            $sql = "SELECT * FROM tiposcasa";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                
                                $ti = $ti. '<option value="'.$fxx['IdTipoCasa'].'">'.$fxx['TipoCasa'].'</option>';	
                                
                            }     
                        }             
                    }else if($IdRequisito == 39){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM municipios";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdMunicipio']){
                                    $ti = $ti. '<option value="'.$fxx['IdMunicipio'].'" selected>'.$fxx['Municipio'].'</option>';
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdMunicipio'].'">'.$fxx['Municipio'].'</option>';
                                }	
                                
                            }    
                        }else{
                            $sql = "SELECT * FROM municipios";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdMunicipio'].'">'.$fxx['Municipio'].'</option>';	
                            }
                        }              
                    }else if($IdRequisito == 49 ){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM municipios";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdMunicipio']){
                                    $ti = $ti. '<option value="'.$fxx['IdMunicipio'].'" selected>'.$fxx['Municipio'].'</option>';
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdMunicipio'].'">'.$fxx['Municipio'].'</option>';
                                }	
                                
                            }    
                        }else{
                            $sql = "SELECT * FROM municipios";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdMunicipio'].'">'.$fxx['Municipio'].'</option>';	
                            }
                        }              
                    }else if($IdRequisito == 61){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM documentos";
                            $r2x = $Vivienda -> query($sql); 
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';                             
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdDocumento']){
                                    $ti = $ti. '<option value="'.$fxx['IdDocumento'].'" selected>'.$fxx['Documento'].'</option>';
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdDocumento'].'">'.$fxx['Documento'].'</option>';
                                }	  
                            }
                        }else{
                            $sql = "SELECT * FROM documentos";
                            $r2x = $Vivienda -> query($sql); 
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';                             
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdDocumento'].'">'.$fxx['Documento'].'</option>';	  
                            }
                        }                    
                    }else if($IdRequisito == 62){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM tiposmejora";
                            $r2x = $Vivienda -> query($sql);     
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';                              
                            while($fxx = $r2x -> fetch_array())
                            { 
                                if($Valor == $fxx['IdTipoMejora']){
                                    $ti = $ti. '<option value="'.$fxx['IdTipoMejora'].'" selected>'.$fxx['TipoMejora'].'</option>';
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdTipoMejora'].'">'.$fxx['TipoMejora'].'</option>';
                                }	 
                            }
                        }else{
                            $sql = "SELECT * FROM tiposmejora";
                            $r2x = $Vivienda -> query($sql);     
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';                              
                            while($fxx = $r2x -> fetch_array())
                            { 
                                $ti = $ti. '<option value="'.$fxx['IdTipoMejora'].'">'.$fxx['TipoMejora'].'</option>';	 
                            }
                        }                      
                    }else if($IdRequisito == 63){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM situaciones";
                            $r2x = $Vivienda -> query($sql);  
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';                                  
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdSituacion']){
                                    $ti = $ti. '<option value="'.$fxx['IdSituacion'].'" selected>'.$fxx['Situacion'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdSituacion'].'">'.$fxx['Situacion'].'</option>';
                                }
                            }
                        }else{
                            $sql = "SELECT * FROM situaciones";
                            $r2x = $Vivienda -> query($sql);  
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';                                  
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdSituacion'].'">'.$fxx['Situacion'].'</option>';	
                            }  
                        }                    
                    }else if($IdRequisito == 89){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM paquetematerial";
                            $r2x = $Vivienda -> query($sql);     
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';                         
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdPaqueteMaterial']){
                                    $ti = $ti. '<option value="'.$fxx['IdPaqueteMaterial'].'" selected>'.$fxx['PaqueteMaterial'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdPaqueteMaterial'].'">'.$fxx['PaqueteMaterial'].'</option>';	
                                }
                            }
                        }else{
                            $sql = "SELECT * FROM paquetematerial";
                            $r2x = $Vivienda -> query($sql);     
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';                         
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdPaqueteMaterial'].'">'.$fxx['PaqueteMaterial'].'</option>';	
                            }
                        }                    
                    }else if($IdRequisito == 109){
                        if ($Valor <> '' ) {
                            $sql = "select * from tipomoneda";
                        //echo $sql;
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdTipoMoneda']){
                                    $ti = $ti. '<option value="'.$fxx['IdTipoMoneda'].'" selected>'.$fxx['TipoMoneda'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdTipoMoneda'].'">'.$fxx['TipoMoneda'].'</option>';	 
                                }
                            }
                        }else{
                            $sql = "select * from tipomoneda";
                        //echo $sql;
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdTipoMoneda'].'">'.$fxx['TipoMoneda'].'</option>';	
                            }
                        }                     
                    }else if($IdRequisito == 111){
                        if ($Valor <> '' ) {
                            $sql = "select * from tipopagoinicial";
                        //echo $sql;
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdPagoInicial']){
                                    $ti = $ti. '<option value="'.$fxx['IdPagoInicial'].'" selected>'.$fxx['PagoInicial'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdPagoInicial'].'">'.$fxx['PagoInicial'].'</option>';	
                                }
                            } 
                        }else{
                            $sql = "select * from tipopagoinicial";
                        //echo $sql;
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdPagoInicial'].'">'.$fxx['PagoInicial'].'</option>';	
                            }
                        }                      
                    }else if($IdRequisito == 113){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM tipoaplicagtsadmon";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdTipoAplicaGtsAdmon']){
                                    $ti = $ti. '<option value="'.$fxx['IdTipoAplicaGtsAdmon'].'" selected>'.$fxx['TipoAplicaGtsAdmon'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdTipoAplicaGtsAdmon'].'">'.$fxx['TipoAplicaGtsAdmon'].'</option>';	
                                }
                            }
                        }else{
                            $sql = "SELECT * FROM tipoaplicagtsadmon";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdTipoAplicaGtsAdmon'].'">'.$fxx['TipoAplicaGtsAdmon'].'</option>';	  
                            }
                        }                       
                    }else if($IdRequisito == 116 || $IdRequisito == 122){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM tipopago";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdTipoPago']){
                                    $ti = $ti. '<option value="'.$fxx['IdTipoPago'].'">'.$fxx['TipoPago'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdTipoPago'].'">'.$fxx['TipoPago'].'</option>';
                                }
                            }
                        }else{
                            $sql = "SELECT * FROM tipopago";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdTipoPago'].'">'.$fxx['TipoPago'].'</option>';	
                            }
                        }                       
                    }else if($IdRequisito == 125){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM cattipointeres";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdTipoInteres']){
                                    $ti = $ti. '<option value="'.$fxx['IdTipoInteres'].'" selected>'.$fxx['TipoInteres'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdTipoInteres'].'">'.$fxx['TipoInteres'].'</option>';	
                                }
                            }
                        }else{
                            $sql = "SELECT * FROM cattipointeres";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdTipoInteres'].'">'.$fxx['TipoInteres'].'</option>';	
                            }
                        }                      
                    }else if($IdRequisito == 137){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM parentesco";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdParentesco']){
                                    $ti = $ti. '<option value="'.$fxx['IdParentesco'].'" selected>'.$fxx['Parentesco'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdParentesco'].'">'.$fxx['Parentesco'].'</option>';	
                                }
                            }
                        }else{
                            $sql = "SELECT * FROM parentesco";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdParentesco'].'">'.$fxx['Parentesco'].'</option>';	
                            }
                        }                     
                    }else if($IdRequisito == 138){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM tipoapoyos";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdTipoApoyo']){
                                    $ti = $ti. '<option value="'.$fxx['IdTipoApoyo'].'" selected>'.$fxx['TipoApoyo'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdTipoApoyo'].'">'.$fxx['TipoApoyo'].'</option>';	
                                }
                            }
                        }else{
                            $sql = "SELECT * FROM tipoapoyos";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdTipoApoyo'].'">'.$fxx['TipoApoyo'].'</option>';	
                            }
                        }                   
                    }else if($IdRequisito == 139){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM unidaddemedida";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['Idunidaddemedida']){ 
                                    $ti = $ti. '<option value="'.$fxx['Idunidaddemedida'].'" selected>'.$fxx['unidaddemedida'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['Idunidaddemedida'].'">'.$fxx['unidaddemedida'].'</option>';	
                                }
                            }
                        }else{
                            $sql = "SELECT * FROM unidaddemedida";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['Idunidaddemedida'].'">'.$fxx['unidaddemedida'].'</option>';	
                            }
                        }                      
                    }else if($IdRequisito == 142){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM paquetematerial";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdPaqueteMaterial']){ 
                                    $ti = $ti. '<option value="'.$fxx['IdPaqueteMaterial'].'" selected>'.$fxx['PaqueteMaterial'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdPaqueteMaterial'].'">'.$fxx['PaqueteMaterial'].'</option>';	
                                }
                            }
                        }else{
                            $sql = "SELECT * FROM paquetematerial";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdPaqueteMaterial'].'">'.$fxx['PaqueteMaterial'].'</option>';	
                            }
                        }                     
                    }else if($IdRequisito == 147 || $IdRequisito == 149){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM periodo";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdPeriodo']){ 
                                    $ti = $ti. '<option value="'.$fxx['IdPeriodo'].'" selected>'.$fxx['Periodo'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdPeriodo'].'">'.$fxx['Periodo'].'</option>';
                                }
                            }
                        }else{
                            $sql = "SELECT * FROM periodo";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            { 
                                $ti = $ti. '<option value="'.$fxx['IdPeriodo'].'">'.$fxx['Periodo'].'</option>';	
                            } 
                        }                       
                    }else if($IdRequisito == 150){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM nivelescolar";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdNivelEscolar']){ 
                                    $ti = $ti. '<option value="'.$fxx['IdNivelEscolar'].'" selected>'.$fxx['NivelEscolar'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdNivelEscolar'].'">'.$fxx['NivelEscolar'].'</option>';	
                                }
                            }
                        }else{
                            $sql = "SELECT * FROM nivelescolar";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdNivelEscolar'].'">'.$fxx['NivelEscolar'].'</option>';	
                            }
                        }                      
                    }else if($IdRequisito == 157){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM ocupacionf";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdOcupacion']){ 
                                    $ti = $ti. '<option value="'.$fxx['IdOcupacion'].'" selected>'.$fxx['Ocupacion'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdOcupacion'].'">'.$fxx['Ocupacion'].'</option>';	
                                }
                            }
                        }else{
                            $sql = "SELECT * FROM ocupacionf";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdOcupacion'].'">'.$fxx['Ocupacion'].'</option>';	
                            }
                        }                      
                    }else if($IdRequisito == 166){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM tipomaterialpiso";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdTipoMaterialPiso']){ 
                                    $ti = $ti. '<option value="'.$fxx['IdTipoMaterialPiso'].'" selected>'.$fxx['TipoMaterialPiso'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdTipoMaterialPiso'].'">'.$fxx['TipoMaterialPiso'].'</option>';	
                                }
                            }
                        }else{
                            $sql = "SELECT * FROM tipomaterialpiso";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdTipoMaterialPiso'].'">'.$fxx['TipoMaterialPiso'].'</option>';	
                            }
                        }                      
                    }else if($IdRequisito == 167){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM tipomaterialtecho";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdTipoMaterialTecho']){ 
                                    $ti = $ti. '<option value="'.$fxx['IdTipoMaterialTecho'].'" selected>'.$fxx['TipoMaterialTecho'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdTipoMaterialTecho'].'">'.$fxx['TipoMaterialTecho'].'</option>';
                                }
                            }
                        }else{
                            $sql = "SELECT * FROM tipomaterialtecho";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdTipoMaterialTecho'].'">'.$fxx['TipoMaterialTecho'].'</option>';	
                            }
                        }                    
                    }else if($IdRequisito == 168){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM tipomaterialpared";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdTipoMaterialPared']){ 
                                    $ti = $ti. '<option value="'.$fxx['IdTipoMaterialPared'].'" selected>'.$fxx['TipoMaterialPared'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdTipoMaterialPared'].'">'.$fxx['TipoMaterialPared'].'</option>';	
                                }
                            }
                            
                        }else{
                        
                            $sql = "SELECT * FROM tipomaterialpared";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdTipoMaterialPared'].'">'.$fxx['TipoMaterialPared'].'</option>';	  
                            }
                        }                     
                    }else if($IdRequisito == 172){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM catmejoramiento";
                            $r2x = $conexion -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdOpcion']){ 
                                        $ti = $ti. '<option value="'.$fxx['IdOpcion'].'" selected>'.$fxx['Opcion'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdOpcion'].'">'.$fxx['Opcion'].'</option>';	
                                }
                            }
                        }else{
                            $sql = "SELECT * FROM catmejoramiento";
                            $r2x = $conexion -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdOpcion'].'">'.$fxx['Opcion'].'</option>';	 
                            }
                        }                     
                    }else if($IdRequisito == 174){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM catvivienda";
                            $r2x = $conexion -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdOpcion']){ 
                                        $ti = $ti. '<option value="'.$fxx['IdOpcion'].'" selected>'.$fxx['Opcion'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdOpcion'].'">'.$fxx['Opcion'].'</option>';	
                                }
                            }
                        }else{
                            $sql = "SELECT * FROM catvivienda";
                            $r2x = $conexion -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdOpcion'].'">'.$fxx['Opcion'].'</option>';	
                            }
                        }                     
                    }else if($IdRequisito == 176){
                        if ($Valor <> '' ) {
                            $sql = "SELECT * FROM estatus";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                if($Valor == $fxx['IdEstatus']){ 
                                     $ti = $ti. '<option value="'.$fxx['IdEstatus'].'" selected>'.$fxx['Estatus'].'</option>';	
                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdEstatus'].'">'.$fxx['Estatus'].'</option>';	
                                }
                            }
                        }else{
                            $sql = "SELECT * FROM estatus";
                            $r2x = $Vivienda -> query($sql);
                            $ti = $ti. '<option value="9999">SELECCIONE UNA OPCION...</option>';
                            while($fxx = $r2x -> fetch_array())
                            {
                                $ti = $ti. '<option value="'.$fxx['IdEstatus'].'">'.$fxx['Estatus'].'</option>';	
                            }
                        }                     
                    }
                    



                    echo $ti;

                    

                }
            }
        }

    
    
    
    
    
    
    
    
    
    
    
    
    
    }
?>