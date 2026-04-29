<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("viaticos_fun.php");
// require_once("lib/flor_funciones.php");

$IdViatico = VarClean($_POST['IdViatico']);

           $archivofinalPDF = "";
            if ( 0 < $_FILES['FilePDF']['error'] ) {
                $Err=  'Error: ' . $_FILES['FilePDF']['error']. '<br>';
            }
            else {
                $archivofinalPDF = 'viaticos_doc/'.$IdViatico."_recibo.pdf";            
                // echo "Archivo Final = ".$archivofinalPDF.", -> ".$_FILES['FilePDF']['tmp_name'];
                if (move_uploaded_file($_FILES['FilePDF']['tmp_name'], $archivofinalPDF)==TRUE){
                    // echo '<script>ActualizaFoto();</script>';
                    Toast("Se subio el PDF",4,"");
                    
                } else {
                    // Toast("Error al subir la foto, o no selecciono una",3,"");
                }
            }

           
            if ($archivofinalPDF <> ""){
                $sqlUp = "UPDATE  viaticos SET pdf='".$archivofinalPDF."'
                WHERE IdViatico='".$IdViatico."'
                ";
            
           
            if ($conexion->query($sqlUp) == TRUE){ 
                historia($nitavu,"[viaticos] = Subio recibo escaneado de viaticos");	
                Toast("Archivo Subido correctamente ",4,"");
                echo "<script>Div_EscaneadoR();</script>";
                
            }
        }
             
?>
