<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("viaticos_fun.php");
// require_once("lib/flor_funciones.php");

$IdViatico = VarClean($_POST['IdViatico']);
$IdGastoF = VarClean($_POST['IdGastoF']);
$Comprobada = VarClean($_POST['Comprobada']);

if (viaticos_Status($IdViatico)==1){
    
    if (viaticosC_($IdGastoF) == TRUE) {//Update
        $sql = "select * from viaticosgastoscomprobables where IdGastoF='".$IdGastoF."'";
        // echo $sql;
        $r= $conexion -> query($sql);					
        if($V = $r -> fetch_array())
        {   $archivofinalPDF = "";
            if ( 0 < $_FILES['FilePDF'.$IdGastoF]['error'] ) {
                $Err=  'Error: ' . $_FILES['FilePDF'.$IdGastoF]['error']. '<br>';
            }
            else {
                $archivofinalPDF = 'viaticos_doc/'.$IdGastoF.".pdf";            
                echo "Archivo Final = ".$archivofinalPDF.", -> ".$_FILES['FilePDF'.$IdGastoF]['tmp_name'];
                // rename("fotos_vehiculos/".$IdVehiculo.".jpg", "fotos_vehiculos/".$IdVehiculo."-".MiToken_generate().".jpg");
                if (move_uploaded_file($_FILES['FilePDF'.$IdGastoF]['tmp_name'], $archivofinalPDF)==TRUE){
                    // echo '<script>ActualizaFoto();</script>';
                    echo "
                    <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'EXITO',
                        text: 'Se subio el PDF',
                        timer: 1500,
                        footer: ''
                    });
                    </script>";    
                    // Toast("Se subio el PDF",4,"");
                    
                } else {
                    // Toast("Error al subir la foto, o no selecciono una",3,"");
                    echo "
                    <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'ERROR',
                        text: 'Error al subir la foto, o no selecciono una ',
                        timer: 1500,
                        footer: ''
                    });
                    </script>";
                }
            }

            $archivofinalXML = "";
            if ( 0 < $_FILES['FileXML'.$IdGastoF]['error'] ) {
                $Err=  'Error: ' . $_FILES['FileXML'.$IdGastoF]['error']. '<br>';
            }
            else {
                $archivofinalXML = 'viaticos_doc/'.$IdGastoF.".xml";            
                echo "Archivo Final = ".$archivofinalXML.", -> ".$_FILES['FileXML'.$IdGastoF]['tmp_name'];
                // rename("fotos_vehiculos/".$IdVehiculo.".jpg", "fotos_vehiculos/".$IdVehiculo."-".MiToken_generate().".jpg");
                if (move_uploaded_file($_FILES['FileXML'.$IdGastoF]['tmp_name'], $archivofinalXML)==TRUE){
                    // echo '<script>ActualizaFoto();</script>';
                  // Toast("Se subio el XML",4,"");

                  echo "
                  <script>
                  Swal.fire({
                      icon: 'success',
                      title: 'EXITO',
                      text: 'Se subio el XML',
                      timer: 1500,
                      footer: ''
                  });
                  </script>";    
                    
                } else {
                    // Toast("Error al subir la foto, o no selecciono una",3,"");
                }
            }
            
            $sqlUp = "UPDATE  viaticoscomprobacion
            SET ";

            if ($archivofinalPDF <> ""){
                $sqlUp.="pdf1 = '".$archivofinalPDF."',";
            }
            
            if ($archivofinalXML<>""){
                $sqlUp.="xml = '".$archivofinalXML."',";
            }

            $sqlUp.="
            CantidadComprobada = '".$Comprobada."',
            act_user = '".$nitavu."',
            act_fecha = '".$fecha."',
            act_hora = '".$hora."'


            WHERE IdGastoF='".$IdGastoF."'
            ";        
            echo $sqlUp;
            if ($conexion->query($sqlUp) == TRUE){ 
                historia($nitavu,"[viaticosC] = Actualizo Comprobacion  ".$IdGastoF." por ".$Comprobada);	
                Toast("Comprobacion actualziada correctamente ",3,"");
                
    
                echo "<script>GastosReload();</script>";
            } else {
                Toast("Error al actualizar",2,"");
            }
            unset($sqlUp);
        } else {
            Toast("Viatico no localizado",2,"");
        }
    } else {//Insert
        $sql = "select * from viaticosgastoscomprobables where IdGastoF='".$IdGastoF."'";
        // echo $sql;
        $r= $conexion -> query($sql);					
        if($V = $r -> fetch_array())
        {  
            $archivofinalPDF = "";
            if ( 0 < $_FILES['FilePDF'.$IdGastoF]['error'] ) {
                $Err=  'Error: ' . $_FILES['FilePDF'.$IdGastoF]['error']. '<br>';
            }
            else {
                $archivofinalPDF = 'viaticos_doc/'.$IdGastoF.".pdf";            
                echo "Archivo Final = ".$archivofinalPDF.", -> ".$_FILES['FilePDF'.$IdGastoF]['tmp_name'];
                // rename("fotos_vehiculos/".$IdVehiculo.".jpg", "fotos_vehiculos/".$IdVehiculo."-".MiToken_generate().".jpg");
                if (move_uploaded_file($_FILES['FilePDF'.$IdGastoF]['tmp_name'], $archivofinalPDF)==TRUE){
                    // echo '<script>ActualizaFoto();</script>';
                    Toast("Se subio el PDF",4,"");
                    
                } else {
                    // Toast("Error al subir la foto, o no selecciono una",3,"");
                }
            }

            $archivofinalXML = "";
            if ( 0 < $_FILES['FileXML'.$IdGastoF]['error'] ) {
                $Err=  'Error: ' . $_FILES['FileXML'.$IdGastoF]['error']. '<br>';
            }
            else {
                $archivofinalXML = 'viaticos_doc/'.$IdGastoF.".xml";            
                echo "Archivo Final = ".$archivofinalXML.", -> ".$_FILES['FileXML'.$IdGastoF]['tmp_name'];
                // rename("fotos_vehiculos/".$IdVehiculo.".jpg", "fotos_vehiculos/".$IdVehiculo."-".MiToken_generate().".jpg");
                if (move_uploaded_file($_FILES['FileXML'.$IdGastoF]['tmp_name'], $archivofinalXML)==TRUE){
                    // echo '<script>ActualizaFoto();</script>';
                    Toast("Se subio el XML",4,"");
                    
                } else {
                    // Toast("Error al subir la foto, o no selecciono una",3,"");
                }
            }
            
            
            $sqlIn = "INSERT INTO viaticoscomprobacion
            (IdGastoF,IdViatico,Fecha,Tipo,Cantidad,pdf1,xml,CantidadComprobada,act_user,act_fecha,act_hora) 
            VALUES (
            '".$IdGastoF."', 
            '".$IdViatico."', 
            '".$V['Fecha']."',
            '".$V['Tipo']."',
            '".$V['Cantidad']."',
            '".$archivofinalPDF."',            
            '".$archivofinalXML."',
            '".$Comprobada."',
            '".$nitavu."',
            '".$fecha."',
            '".$hora."'
            
            )";        
            if ($conexion->query($sqlIn) == TRUE){ 
                historia($nitavu,"[viaticosC] = Guardo Comprobacion  ".$IdGastoF." por ".$Comprobada);	
                Toast("Comprobacion guardada correctamente ",4,"");
                echo "<script>GastosReload();</script>";
            } else {
                Toast("Error al Guardar",2,"");
            }
            unset($sqlIn);

        }  else {
           Toast("Viatico No Disponible",2,"");
        }
        unset($sql, $r, $V);
    }
    

} else {
    Toast("Estatus no Valido, archive primero el viatico para poder hacer la comprobacio",2,"");
}
?>
