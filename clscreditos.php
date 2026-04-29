<?php

function IdNuevoPrograma($tabla){
    require("config.php"); /*No mover*/
    
    $sql = "SELECT max(IdCredito+1) as maximo from creditos";
    $rc= $Vivienda -> query($sql);
        if($f = $rc -> fetch_array())
        {
            return $f['maximo'];                                
        }
        else
        {
            //return 1;
            return FALSE;
        }    
    }

function DiasdeGracia($IdCredito,$DiasdeGracia)
{
		require("config.php");
		$sql = " UPDATE creditos set DiasdeGracia=".$DiasdeGracia." Where IdCredito=".$IdCredito;
        $rc= $conexion -> query($sql);
		if($f = $rc -> fetch_array())
		{
			//return $f['Concepto'];					
            return TRUE;
		}
		else
		{
			return FALSE;
		}
}

function IdDelegacion($Iddelegacion)


?>
