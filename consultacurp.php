<?php 
error_reporting(E_ALL);
ini_set('display_errors', '1');
include ("lib/body_head.php");
include ("lib/body_menu.php");
docdigital_no(FALSE, 2); //ahorra 1 hoja

echo "<div style='
        width:97%;
        margin:0px;
        
        margin-left:10px;
        padding:20px;
        margin-top: -35px;
    '>";

echo "<table width=100%><tr><td align=center><img src='img/logo_tam.png' style='width:180px'></td>";
echo "<td align=center style='font-size:14pt; font-weight:bold;'>Consulta de datos del CURP ".$_GET['curp']."</td>";
echo "<td align=center><img src='img/renapo.jpg' style='width:180px;'></td></tr></table><br><br>";
$txtCurp = $_GET['curp']; if (ValidaVAR($txtCurp)==TRUE){$txtCurp = LimpiarVAR($txtCurp);} else {$txtCurp = "";}
$ResultadoDelCURP = CURP($txtCurp, $nitavu); 
historia($nitavu,"Consulto el Curp ".$txtCurp);
$c = 1;

// var_dump($ResultadoDelCURP);
$array = json_decode($ResultadoDelCURP, true);
$exito = FALSE;
if(is_array($array)){    
    foreach ($array as $value) {
        // echo $c;
        if ($c==1){
            if ($value==1){
                $exito = TRUE;
                
            }
            $c=$c+1;
        } 
        else {
            if ($c == 3 and $exito == FALSE){
                echo "(".$c.")";
                mensaje("ERROR: <b style='font-size:14pt;'>".$value."</b>.<br> CURP consultada: ".$txtCurp,"");
                
            }
            if ($exito == TRUE){
                echo "<table class='tabla' style='font-size:14pt;'>";
                echo "<tr><td align=right>CURP: </td><td>".$value['CURP']."</td></tr>";
                echo "<tr><td align=right>Nombre: </td><td> ".$value['nombres']."</td></tr>";
                echo "<tr><td align=right>Apellido Paterno: </td><td>".$value['apellido1']."</td></tr>";
                echo "<tr><td align=right>Apellido Materno: </td><td>".$value['apellido2']."</td></tr>";
                echo "<tr><td align=right>Sexo: </td><td>".$value['sexo']."</td></tr>";
                echo "<tr><td align=right>Fecha de Nacimiento: </td><td>".$value['fechNac']."</td></tr>";
                echo "<tr><td align=right>Nacionalidad: </td><td>".$value['nacionalidad']."</td></tr>";
                echo "<tr><td align=right>Documento Probatorio:</td><td>".$value['docProbatorio']."</td></tr>";
                echo "<tr><td align=right>Numero de Acta: </td><td> ".$value['numActa']."</td></tr>";
                echo "<tr><td align=right>CRIP: </td><td>".$value['CRIP']."</td></tr>";
                echo "<tr><td align=right>Numero de Entidad Registrante: </td><td> ".$value['numEntidadReg']."</td></tr>";
                echo "<tr><td align=right>Clave de Municipio Registrante: </td><td> ".$value['cveMunicipioReg']."</td></tr>";
                // echo "Num. de Registro para Extranjeros: ".$value['NumRegExtranjeros']."<br>";
                echo "<tr><td align=right>Estado del CURP: </td><td> ".$value['statusCurp']."</td></tr>";
                echo "<tr><td align=right>Entidad de Nacimiento: </td><td>".$value['nombreEntidadNac']."</td></tr>";
                echo "<tr><td align=right>Entidad Registrante: </td><td> ".$value['nombreEntidadReg']."</td></tr>";
                echo "<tr><td align=right>Municipio Registrante </td><td>".$value['nombreMunicipioReg']."</td></tr>";
                echo "</table>";
            }  
        }
        
        // echo "<hr>";
        $c= $c +1;
    }
} else {
    sentimental("Error el servicio para consultar el CURP");
}



echo "<br><div style='
background-color:
#d9edf7;
border-color:
#bce8f1;
color:
#31708f;
border-width: 2px;
text-align: center;
padding: 20px 15px;
word-wrap: break-word;
'>¡Sugerencia! Para solicitar asistencia en el trámite, reportar datos incorrectos o en caso de algún problema, puedes comlibrte al centro de atención.
Teléfono 01 800 911 11 11, para CURP primero seleccionar opción 2 y posteriormente:<br>
Corrección o modificación : opción 1<br>
Baja de la curp: opción 2<br>
Obtención de la curp: opción 3<br>
También te puedes comlibr a través de correo electrónico a la dirección: contactorenapo@segob.gob.mx</div>";


echo "<label>NOTA: Esta no es una constancia de CURP, es un servicio para la consulta de los datos del CURP, a través un convenio de colaboración entre la Subsecretaria de Inovacion y Tecnologias de la Información y el Instituto Tamaulipeco de Vivienda y Urbanismo, donde se implementa el servicio para la consulta del CURP en RENAPO</label>";

$LimiteQuedan = $CURP_limite - CURPs_hoy();
if ($LimiteQuedan <= 0){
    $LimiteQuedan = 0;
    echo "<label style='font-size:12pt;color:white; background-color:red; width:100%; text-align:left;'><br>* Hoy solo puedes consultar ".$LimiteQuedan."</label>";
} else {
    echo "<label style='font-size:12pt;color:orange; text-align:left;'><br>* Hoy solo puedes consultar: ".$LimiteQuedan." peticiones al servicio del CURP</label>";
}
echo "<label style='font-size:12pt; text-align:left;'><br>* Usuario de consulta: ".$nitavu.",".nitavu_nombre($nitavu)." peticiones al servicio del CURP</label>";
echo "</div>";
include ("lib/body_footer.php"); ?>


