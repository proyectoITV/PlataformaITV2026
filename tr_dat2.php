<?php 
 require("seguridad.php"); 
 require_once("config.php");
 require_once("lib/funciones.php");
 require_once("lib/flor_funciones.php");
//  ob_end_clean();
?>

<?php

$idDepartamento=nitavu_dpto($nitavu);
$id_aplicacion ="ap87";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    // echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";	    
    $FolioTramite = $_POST['Folio']; if (ValidaVAR($FolioTramite)==TRUE){$FolioTramite = LimpiarVAR($FolioTramite);} else {$FolioTramite = "";}
    $IdRequisito = $_POST['IdRequisito']; if (ValidaVAR($IdRequisito)==TRUE){$IdRequisito = LimpiarVAR($IdRequisito);} else {$IdRequisito = "";}
    $IdClase = $_POST['IdClase']; if (ValidaVAR($IdClase)==TRUE){$IdClase = LimpiarVAR($IdClase);} else {$IdClase = "";}
    
    // $Valor = $_POST['value']; if (ValidaVAR($Valor)==TRUE){$Valor = LimpiarVAR($Valor);} else {$Valor = "";}
    $Usuario = $nitavu;
    $type = TramiteRequisitoTipo($IdRequisito);
    if ($type == 'file'){
        $ruta = 'tramitesFiles';
        $NombreDelArchivo = $ruta."/".$IdClase."_".$FolioTramite."_".$IdRequisito.".pdf";
        $ArchivoTmp = $_FILES[$IdRequisito]['tmp_name'];
		if ($_FILES[$IdRequisito]['error'] !== 0) {
				//return 'Error al subir el archivo (¿demasiado grande?)';
		} else {
            if ( mime_content_type($_FILES[$IdRequisito]['tmp_name']) == 'application/pdf')
            {
                if (move_uploaded_file($ArchivoTmp, $NombreDelArchivo)) { //se subio correctamente
                    //Guardar Dato
                    GuardarTramiteDato($FolioTramite, $IdRequisito, $NombreDelArchivo, "file", $nitavu, $IdClase); //<--- guardamos el nombre del archivo como dato
                    //entregar hipervinculo al archivo
                    echo "<a href='".$NombreDelArchivo."' download='MiRequisito".$IdRequisito.".pdf' target=_blank><img src='icon/pdf.png' style='width:36px;'></a>";

        

                
                } else {
                    echo "<b style='color:red;' >ERROR: al subir el archivo, intentelo nuevamente.</b>";
                }
            } else {
                echo "<b style='color:red;' >ERROR: no es un archivo valido</b>";
            }
        }




    } else {

        if (GuardarTramiteDato($FolioTramite, $IdRequisito, $Valor, "", $Usuario, $IdClase) == FALSE) {
            echo "<script>console.log('Error al guadar Folio: ".$FolioTramite.", IdRequisito:".$IdRequisito." con valor: ".$Valor."');</script>"; 
            
        } else {
            echo "<script>console.log( '* Se Actualizo Folio: ".$FolioTramite.", IdRequisito:".$IdRequisito." con valor: ".$Valor."');</script>"; 
            historia($Usuario, "tramites: Actualizo Folio: ".$FolioTramite.", IdRequisito:".$IdRequisito." con valor: ".$Valor."");
            $ti = "";  $type = TramiteRequisitoTipo($IdRequisito, $IdClase);
            if ($type == 'select') {//Escribimos otra vez el select
                // $ti = $ti."<div class='elemento'><label>*<b>".$NombreDelRequisito."</b><br> <cite>".$Descripcion."</cite></label>";
                // $ti = $ti."<table width=100%><tr><td>";
                // $ti = $ti."<select  id='".$IdRequisito."' onclick='GuardarDato(".$FolioTramite.",".$IdRequisito.")'  name='".$IdRequisito."' style='margin-left: 0px; '>";
                $sql = "SELECT * FROM tramitesopcionesrequisitos where IdRequisito=".$IdRequisito;
                $tmp="";
                $r2x = $conexion -> query($sql);
                while($fxx = $r2x -> fetch_array())
                    {
                        $ti = $ti. '<option value="'.$fxx['IdOpcion'].'">'.$fxx['Opcion'].'</option>';	
                    }
                    $ti = $ti. '<option value="'.$Valor.'" selected>'.TramiteRequisitoOpcion($IdRequisito, $Valor).'</option>';	
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




