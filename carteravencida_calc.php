<?php
// include("seguridad.php");
session_start();
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
error_reporting(0); //<-- para simular produccion



if (isset($_SESSION['nitavu'])){
    if (isset($_GET['IdDelegacion'])){
        $IdDelegacion = $_GET['IdDelegacion']; if (ValidaVAR($IdDelegacion)==TRUE){$IdDelegacion = LimpiarVAR($IdDelegacion);} else {$IdDelegacion = "";}
        $nitavu = $_GET['nitavu']; if (ValidaVAR($nitavu)==TRUE){$nitavu = LimpiarVAR($nitavu);} else {$nitavu = "";}
        // echo "IdDelegacion:".$IdDelegacion;
        if (CarteraVencida_CalculoHoy($IdDelegacion)==0){

                //Docificaremos a 1000 registros las operaciones
                $MSSQLuniverse = "SELECT count(*) as n from Vivienda_EstadisticaCarteraVencida WHERE IdDelegacion=6";
                $DATAuniverse = DatosViviendaLarge($IdDelegacion, $nitavu, "CarteraVencida-U", $MSSQLuniverse);
                $ArrayUniverse = json_decode($DATAuniverse, true); 
                $error = 0; $sqlInsert=""; $Universe = 0;
    
                if(is_array($ArrayUniverse)){            
                    foreach ($ArrayUniverse as $Val) {
                        if (isset($Val['r'])){echo "*Error: ".$Val['r']; $error = $value['r'];}
                        else { $Universe = $Val['n'];}
                    }
                } else {echo "Universe: sin formato array";}

                $UniverseBucle = round($Universe / 500);
                
                // echo "Universo de Registros: ".$Universe.", se necesitan ".$UniverseBucle." solicitudes al Servidor para completarlo";
                
                //Ejevucion del Bucle
                $RegC = 1;
                $Desde = 1; $Hasta = 500;
                for ($iU = 1; $iU <= $UniverseBucle; $iU++) {

                    // echo "<br>Desde = ".$Desde.", Hasta=".$Hasta;
                    CalcularCarteraVencida($IdDelegacion, $Desde, $Hasta);
                    $Desde = $Hasta + 1 ; $Hasta = $Hasta + 500;
    

                    // echo "Ejecucion de los bucles: ".$iU."<br>";
                }
                Toast("Se ha calculado la cartera vencida de esta delegación desde la fecha actual",1,"");

                // historia($nitavu,"Ingreso de manera automatica el calculo de la Cartera vencida de la delegacion ".$IdDelegacion."");
                // echo '
                // <script>
                //     window.location.href = "carteravencida.php?IdDelegacion='.$IdDelegacion.'";
                // </script>
                // ';
                





 

        } else {
            Toast("Ya hay un calculo de cartera vencida para esta delegacion",1,"");
        }



    } else {
        // echo "Sin Parametros";
        Toast("Sin Parametros",2,"");
    }
} else {
    // echo "Error inesperado";
    Toast("Error inesperado",2,"");
}






?>

