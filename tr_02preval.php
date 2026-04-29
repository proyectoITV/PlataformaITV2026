<?php
require ("config.php");

    $sql = "select IdTipoTramite as TipoTramiteId,
    (SELECT IdTramite from tramites WHERE Curp = '".$CURP."' AND IdTipoTramite = TipoTramiteId) as FolioTramite,
    (select IdTipoTramite from tramitestipo WHERE Dependencia = TipoTramiteId) as Siguiente
    from tramitestipo 
    WHERE IdPrograma='".$IdPrograma."' order by Dependencia ASC LIMIT 1";

    $rc= $conexion -> query($sql);
    if($f = $rc -> fetch_array())
    {				
        $f['FolioTramite'];

        if(TramitePreValidacionYaejecutada($FolioTramite, $IdTipoTramite) == ''){
            $sql1 = "select  ti.IdRequisito, ti.Dato, ti.clase
            from tramitesinformacion  as ti
            INNER JOIN tramiteslistaRequisitos as tlr on tlr.IdRequisito = ti.IdRequisito and tlr.Clase = ti.Clase
            where ti.IdTramite = ".$f['FolioTramite']." and tlr.IdTipoTramite=".$f['Siguiente']."";

            $r = $conexion -> query($sql1); 
            $r_count = $r -> num_rows;
            if($r_count > 0){
                while($fx = $r -> fetch_array()){
                    $TipoRequisito = TramiteRequisitoTipo($fx['IdRequisito']);
                    GuardarTramiteDato($FolioTramite, $fx['IdRequisito'], $fx['Dato'], $TipoRequisito, $Usuario, $fx['clase']);
                }   
                
                return TRUE;
            }
        }else{
            return TRUE;
        }

        
    }else{
        return FALSE;
    }



?>




