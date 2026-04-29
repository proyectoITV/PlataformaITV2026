<?php 
require("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");

?>
<br><br>
<?php

$idDepartamento=nitavu_dpto($nitavu);
$id_aplicacion ="ap87";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    // echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	    
    $FolioTramite = $_GET['Folio']; if (ValidaVAR($FolioTramite)==TRUE){$FolioTramite = LimpiarVAR($FolioTramite);} else {$FolioTramite = "";}
    $IdRequisito = $_GET['IdRequisito']; if (ValidaVAR($IdRequisito)==TRUE){$IdRequisito = LimpiarVAR($IdRequisito);} else {$IdRequisito = "";}
    $IdClase = $_GET['IdClase']; if (ValidaVAR($IdClase)==TRUE){$IdClase = LimpiarVAR($IdClase);} else {$IdClase = "";}
    $Valor = $_GET['value']; if (ValidaVAR($Valor)==TRUE){$Valor = LimpiarVAR($Valor);} else {$Valor = "";}
    $Usuario = $nitavu;
    $type = TramiteRequisitoTipo($IdRequisito, $IdClase);
    
    if ($type == 'file'){
        $ruta = 'tramitesFiles';
        $NombreDelArchivo = $ruta."/".$IdClase."_".$FolioTramite."_".$IdRequisito.".pdf";
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




    } else {
        
        if (GuardarTramiteDato($FolioTramite, $IdRequisito, $Valor, "", $Usuario, $IdClase) == FALSE) {
            echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito:".$IdRequisito." con valor: ".$Valor."');</script>"; 
            
        } else {
            echo "<script>console.log('Se Actualizo Folio: ".$FolioTramite.", IdRequisito:".$IdRequisito." con valor: ".$Valor."');</script>"; 
            historia($Usuario, "tramites: Actualizo Folio: ".$FolioTramite.", IdRequisito:".$IdRequisito." con valor: ".$Valor."");
            $ti = "";  $type = TramiteRequisitoTipo($IdRequisito, $IdClase);
            if ($type == 'select') {//Escribimos otra vez el select
                // $ti = $ti."<div class='elemento'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
                // $ti = $ti."<table width=100%><tr><td>";
                // $ti = $ti."<select  id='".$IdRequisito."' onclick='GuardarDato(".$FolioTramite.",".$IdRequisito.")'  name='".$IdRequisito."' style='margin-left: 0px; '>";
               
               if ($IdRequisito <> 95 or $IdRequisito <> 60 or $IdRequisito or 62) {// sino es estado municipio o colonia

               
                $sql = "SELECT * FROM tramitesopcionesrequisitos where IdRequisito=".$IdRequisito." ";
              //  echo "<script>console.log('".$sql."');</script>"; 
                $tmp="";
                $r2x = $conexion -> query($sql);
                while($fxx = $r2x -> fetch_array())
                    {
                        if($fxx['ReqDepende']=='' and $fxx['IdOpcionDepende']==''){

                           /* if($Valor==$fxx['IdOpcion'].'_'.$fxx['ReqDepende'].'_'.$fxx['IdOpcionDepende']){
                                $ti = $ti. '<option value="'.$fxx['IdOpcion'].'_'.$fxx['ReqDepende'].'_'.$fxx['IdOpcionDepende'].'" selected>'.$fxx['Opcion'].'</option>';	

                            }else */if($Valor ==$fxx['IdOpcion']){
                                $ti = $ti. '<option value="'.$fxx['IdOpcion'].'" selected>'.$fxx['Opcion'].'</option>';	
                                //$ti = $ti. '<option value="'.$value.'" selected>'.TramiteRequisitoOpcion($IdRequisito, $value).'</option>';	
                            }else{
                                $ti = $ti. '<option value="'.$fxx['IdOpcion'].'">'.$fxx['Opcion'].'</option>';	
                            }

                        }else{
                            //echo '<script>console.log("Entro else"+"'.$fxx['IdRequisito'].'")</script>';
                            //$ti = $ti. '<option value="'.$fxx['IdOpcion'].'">'.$fxx['ReqDepende'].'-'.$fxx['IdOpcionDepende'].'-'.$fxx['Opcion'].'</option>';	
                           $ids = explode('_', $Valor);
																			
                           // echo "<script>console.log('Valor".$Valor."');</script>"; 
                           echo "<script>console.log('Valor".$ids[0]."_".$ids[1]."_".$ids[2]."');</script>"; 							
                           if($fxx['ReqDepende']==$ids[1] and $fxx['IdOpcionDepende']==$ids[2]){
                                if($Valor ==$fxx['IdOpcion'].'_'.$fxx['ReqDepende'].'_'.$fxx['IdOpcionDepende']){
                                    $ti = $ti. '<option value="'.$fxx['IdOpcion'].'_'.$fxx['ReqDepende'].'_'.$fxx['IdOpcionDepende'].'" selected>'.$fxx['Opcion'].'</option>';	

                                }else{
                                    $ti = $ti. '<option value="'.$fxx['IdOpcion'].'">'.$fxx['Opcion'].'</option>';	

                                }
                            }

                        }
                    }
                } else {
                    // es Estado Municipio o Colonia
                    echo "<script>
                        var cp = $('#25_".$IdClase."').val();
                        //DomicilioCPEstado(cp, '".$IdClase."','".$FolioTramite."');
                        
                    </script>";
                }
                   // $ti = $ti. '<option value="'.$Valor.'" selected>'.TramiteRequisitoOpcion($IdRequisito, $Valor).'</option>';	
                // $ti = $ti. "</select></td><td width=13px><div style='display:none;' id='Loader".$IdRequisito."'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK".$IdRequisito."'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>";	
                // $ti = $ti. "</div>";
                
                echo $ti;



            }
        }

        


    }
  
}else{
    // mensaje('No tiene permiso para esta aplicación','index.php');
}





?>




