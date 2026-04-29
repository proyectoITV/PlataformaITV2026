<?php
require ("config.php");
require ("components.php");
include("seguridad.php");

$IdTrimestre = VarClean($_POST['IdTrimestre']);
$Anio = VarClean($_POST['Anio']);
$id_aplicacion ="indicadores"; 
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
$IdDelegacion = VarClean($_POST['IdDelegacion']);
// var_dump($IdDelegacion);

if ($IdDelegacion <> ""){
if (sanpedro($id_aplicacion, $nitavu)==TRUE){ 
        function DOM_Campo($Label, $Campo, $IdTrimestre, $Anio, $IdDelegacion){
            require("config.php");
            echo '
            <div class="form-group col-4">
                <label for="">'.$Label.'</label>
                ';

                $Valorcillo="";
                $sqlValue = "select ".$Campo." as Campo from indicadorestrimestrales where Anio=".$Anio." and IdTrimestre=".$IdTrimestre." and IdDelegacion=".$IdDelegacion."";	                
                // echo $sqlValue;

                $rV= $conexion -> query($sqlValue);					
                if($CampoValor = $rV -> fetch_array())
                {
                    $Valorcillo = $CampoValor['Campo'];
                }
                unset($rV, $CampoValor);

                $Title =" ";
                $sqlHistoriaCampo = "
                select 
                (select nombre from empleados where nitavu = a.IdEmpleado) as Empleado,
                a.*
                    
                 from indicadorestrimestrales_historia a
                 WHERE Campo = '".$Campo."' and Anio ='".$Anio."' and IdTrimestre = '".$IdTrimestre."'

                 order by fecha DESC, hora DESC
                
                ";
                $rH= $conexion -> query($sqlHistoriaCampo);
                while($Historia = $rH -> fetch_array()) {
                    $Title.="".$Historia['Empleado']." escribio ".$Historia['Valor']." el ".$Historia['fecha']." a las ".hora12($Historia['hora'])."\n ";

                }
                unset($rH, $Historia);


                echo '
                <input type="number" class="form-control" id="'.$Campo.'" step="0.01" onchange="Save(`'.$Campo.'`,'.$IdTrimestre.','.$Anio.');" value="'.$Valorcillo.'"
                title="'.$Title.'"
                >';


            echo '
            </div>
        
        ';
        }

       
            echo "<h4 style='color:orange;' title='IdTrimestre=".$IdTrimestre."'>Informacion de Programas de Vivenda: </h4>";
            DOM_Campo('Total de Casas','Vivienda_total',$IdTrimestre, $Anio, $IdDelegacion);
            DOM_Campo('Costo de las Casas ($)','Vivienda_costo',$IdTrimestre, $Anio, $IdDelegacion);
            DOM_Campo('Enganches ($)','Vivienda_enganches',$IdTrimestre, $Anio, $IdDelegacion);
            DOM_Campo('Credito ($)','Vivienda_creditos',$IdTrimestre, $Anio, $IdDelegacion);
            DOM_Campo('Sub. Estatal ($)','Vivienda_subsidioEstatal',$IdTrimestre, $Anio, $IdDelegacion);
            DOM_Campo('Sub. Federal ($)','Vivienda_subsidioFederal',$IdTrimestre, $Anio, $IdDelegacion);
            DOM_Campo('Saldo ($)','Vivienda_Saldo',$IdTrimestre, $Anio, $IdDelegacion);
            echo "<br><hr style='opacity: 0.2;
            border: dashed black 1px;
            width: 100%;'>";

            echo "<h4 style='color:orange;' title='IdTrimestre=".$IdTrimestre."'>Informacion de Programas de Creditos: </h4>";
            DOM_Campo('Total Contratado ($)','Creditos_Contratado',$IdTrimestre, $Anio, $IdDelegacion);
            DOM_Campo('Cantidad de Contratos','Creditos_Contratos',$IdTrimestre, $Anio, $IdDelegacion);
            echo "<br><hr style='opacity: 0.2;
            border: dashed black 1px;
            width: 100%;'>";

            
            


            echo "<h4 style='color:orange;' title='IdTrimestre=".$IdTrimestre."'>Informacion de Programas de Lotes: </h4>";
            DOM_Campo('Lotes libres de asignación','Lotes_Libres',$IdTrimestre, $Anio, $IdDelegacion);
            DOM_Campo('Lotes asignados','Lotes_Asignados',$IdTrimestre, $Anio, $IdDelegacion);
            DOM_Campo('Lotes Regularizados','Lotes_Regularizados',$IdTrimestre, $Anio, $IdDelegacion);
            DOM_Campo('Ahorro Contratado ($)','Lotes_AhorroContratado',$IdTrimestre, $Anio, $IdDelegacion);
            DOM_Campo('Credito de Lotes ($)','Lotes_Credito',$IdTrimestre, $Anio, $IdDelegacion);
            DOM_Campo('Saldo de Lotes ($)','Lotes_Saldo',$IdTrimestre, $Anio, $IdDelegacion);
         
            echo "<br><hr style='opacity: 0.2;
            border: dashed black 1px;
            width: 100%;'>";

            

            
            
            
           


        







     
        echo '<script>';

        echo '</script>';


     





} else {mensaje("ERROR: no tienes acceso","");}

} else {
    echo '
    <div class="alert alert-danger" role="alert">
        Por favor seleccione antes la Delegacion, y despues clic en el Trimestre.
    </div>
    
    ';
        
}
?>


<?php
// include ("./lib/body_footer.php"); //Cierre de Estructura de la Plaforma
?>