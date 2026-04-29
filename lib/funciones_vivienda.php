<?php
// FUNCIONES PARA VIVIENDA

function Vivienda_ProgramaExiste($IdPrograma){
	require("config.php");
	$sql = "SELECT * FROM programa  WHERE IdPrograma='".$IdPrograma."'";	
	$msg = "";
	$r= $Vivienda -> query($sql);if($f = $r -> fetch_array()){	
        return TRUE;
    } else {
        return FALSE;
    }
}

function Vivienda_ProgramaNombre($IdPrograma){
	require("config.php");
	$sql = "SELECT * FROM programa  WHERE IdPrograma='".$IdPrograma."'";	
	$msg = "";
	$r= $Vivienda -> query($sql);if($f = $r -> fetch_array()){	
        return $f['Programa'];
    } else {
        return '';
    }
}


function Vivienda_ProgramaActivo($IdPrograma){
	require("config.php");
	$sql = "SELECT * FROM programa  WHERE IdPrograma='".$IdPrograma."'";	
	$msg = "";
	$r= $Vivienda -> query($sql);if($f = $r -> fetch_array()){	
      if ($f['Activo']==0) {
          return FALSE;
      } else {
          return TRUE;
      }
    } else {
        return FALSE;
    }
}

?>