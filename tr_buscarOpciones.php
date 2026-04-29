<?php
require ("config.php");
require ("lib/funciones.php");

if(isset($_POST['IdRequisito'])){
    $FolioTramite = $_POST['FolioTramite'];
    $id = $_POST['IdRequisito'];
    $opcion = $_POST['IdOpcion'];
    $caso = $_POST['Caso'];
    $nitavu = $_POST['nitavu'];
    if(isset($_POST['IdReq'])){
        $idReq = $_POST['IdReq'];
        $IdClase = $_POST['IdClase'];
    }
   // echo 'id'.$id;
   // echo 'op'.$opcion;

    if($caso==1){
        
        $sql = "SELECT DISTINCT IdRequisito FROM tramitesopcionesrequisitos WHERE ReqDepende = ".$id."";
        // echo $sql;
        $r = $conexion -> query($sql);
        $info="";
        while($f = $r -> fetch_array()){ 
            $info= $info.$f['IdRequisito'].'-';
        }
        echo $info;
        
       
    }else{
        $DatoActual = TramiteDato($FolioTramite, $id, $IdClase);
        if($DatoActual <> "" || $DatoActual<> FALSE){
            $sql = "UPDATE tramitesinformacion SET	Dato = '' WHERE IdTramite = '".$FolioTramite."' AND IdRequisito='".$idReq."' and Clase='".$IdClase."'";
            echo $sql; 
            if ($conexion->query($sql) == TRUE){
                historia($nitavu,"tramites: Actualizo en el Tramite con Folio " . $FolioTramite." el Requisito con Id ".$id." de ".$DatoActual." a <b> vacio </b> de la Clase ".$IdClase);
                $sql1 = "SELECT * FROM tramitesopcionesrequisitos WHERE IdRequisito = ".$idReq." and ReqDepende = ".$id." and IdOpcionDepende='".$opcion."'";
                
                $r = $conexion -> query($sql1);
                
                while($f = $r -> fetch_array()){ 
                    echo '<option value="'.$f['IdOpcion'].'_'.$f['ReqDepende'].'_'.$f['IdOpcionDepende'].'">'.$f['Opcion'].'</option>';	
        
                }	
            }
            else {
                return FALSE;
            }
        }
        
    
       

            
    }
}





?>
