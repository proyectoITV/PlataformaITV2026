<?php
// include ("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
if (isset($_GET['IdUser']) and isset($_GET['Token'])){
    $IdUser = $_GET['IdUser']; if (ValidaVAR($IdUser)==TRUE){$IdUser = LimpiarVAR($IdUser);} else {$IdUser = "";}
    $Token = $_GET['Token']; if (ValidaVAR($Token)==TRUE){$Token = LimpiarVAR($Token);} else {$Token = "";}
    



$ValidaToken = MiToken_valida($IdUser, $Token);            
if ($ValidaToken == TRUE){ //soy el mismo usuario que le dio clic


    echo "<div>";
    $sql= "select * from programa";
    $r = $Vivienda -> query($sql);		 
    echo "<table class='tabla'>";
    while($f = $r -> fetch_array()){
        echo "<tr>";
            echo "<td>";
            echo "<a href='?IdPrograma=".$f['IdPrograma']."'>".$f['Programa']."</a>";
            echo "</td>";
    
        echo "</tr>";
    
    }
    echo "</table>";
    echo "</div>";
    

    

    MiToken_Close($IdUser,$Token); //Cierro el token      
} else {//Token Invalido
    echo "* Parametros Incorrectos";
}

} else {
    echo "Parametros Incorrectos";
}

?>