<?php
require ("config.php");
require ("lib/funciones.php");

$curp = $_POST['curp'];
$nitavu = $_POST['nitavu'];
//echo $curp;
$ResultadoDelCURP = CURP($curp, $nitavu); //<-- se entrega en formato JSON
$c = 1;
$exito = FALSE;
//Tratado de la informacion
$array = json_decode($ResultadoDelCURP, true);
if(is_array($array)){
    
    foreach ($array as $value) {
        if ($c==1){
            if ($value==1){
                $exito = TRUE;
            }
        } else {
            if ($exito == TRUE){
                echo "<form action='tr_accionestramites.php?pes=tramite' method='POST' >"; 
                echo "<div style='float: left; width: 85%; height: 40%;'>";
                echo "<div style='display: inline-block; VERTICAL-ALIGN: TOP; width: 100%;'>";
                
                echo "<section id='aplicacionesReq' style='text-align: left; width:100%'>";
               
                echo "<article><table border='0'><tbody><tr><td></td>
					<td><b class='normal menu_font_n'>CURP:</b> <cite class='tenue menu_font_d '>".$value['CURP']." </cite></td><td width='10px'></td>
					<td style='display:none'> <input type='hidden' name='curp' value=".$value['CURP']." >  </td>
                    </tr></tbody></table></article>";

                echo "<article><table border='0'><tbody><tr><td></td>
					<td><b class='normal menu_font_n'>Nombre:</b> <cite class='tenue menu_font_d '>".$value['nombres']."</cite></td><td width='10px'></td>
					<td style='display:none'> <input type='hidden' name='nombres' value=".$value['nombres']." >  </td>
                    </tr></tbody></table></article>";

                echo "<article><table border='0'><tbody><tr><td></td>
                    <td><b class='normal menu_font_n'>Apellido Paterno:</b> <cite class='tenue menu_font_d '>".$value['apellido1']."</cite></td><td width='10px'>
                    <input type='hidden' name='apellido1' value=".$value['apellido1']." ></td>	
                    </tr></tbody></table></article>";

                echo "<article><table border='0'><tbody><tr><td></td>
                    <td><b class='normal menu_font_n'>Apellido Materno:</b> <cite class='tenue menu_font_d '>".$value['apellido2']." </cite></td><td width='10px'>
                    <input type='hidden' name='apellido2' value=".$value['apellido2']." ></td>					
                    </tr></tbody></table></article>";


                echo "<article><table border='0'><tbody><tr><td></td>
                    <td><b class='normal menu_font_n'>Sexo:</b> <cite class='tenue menu_font_d '>".$value['sexo']."</cite></td><td width='10px'>
                    <input type='hidden' name='sexo' value=".$value['sexo']." ></td>					
                    </tr></tbody></table></article>";

                echo "<article><table border='0'><tbody><tr><td></td>
                    <td><b class='normal menu_font_n'>Fecha de Nacimiento:</b> <cite class='tenue menu_font_d '>".$value['fechNac']."</cite></td><td width='10px'>
                    <input type='hidden' name='fechNac' value=".$value['fechNac']." ></td>				
                    </tr></tbody></table></article>";

                echo "<article style='display:none;'><table border='0'><tbody><tr><td></td>
                    <td><b class='normal menu_font_n'>Nacionalidad:</b> <cite class='tenue menu_font_d '>".$value['nacionalidad']."</cite></td><td width='10px'>
                    <input type='hidden' name='nacionalidad' value=".$value['nacionalidad']." ></td>					
                    </tr></tbody></table></article>";

                echo "<article style='display:none;'><table border='0'><tbody><tr><td></td>
                    <td><b class='normal menu_font_n'>Entidad de Nacimiento:</b> <cite class='tenue menu_font_d '>".$value['cveEntidadNac']."</cite></td><td width='10px'>
                    <input type='hidden' name='entidad' value=".$value['cveEntidadNac']." ></td>					
                    </tr></tbody></table></article>";

                echo "<article style='display:none;'><table border='0'><tbody><tr><td></td>
                    <td><b class='normal menu_font_n'>Estado del CURP:</b> <cite class='tenue menu_font_d '>".$value['statusCurp']."</cite></td><td width='10px'>
                    <input type='hidden' name='statusCurp' value=".$value['statusCurp']." ></td>
					
                    </tr></tbody></table></article>";
                
                echo "</section>";
                echo "</div>";
                
                echo "</div>";

                echo "<div id='sig' style='float: left; width: 10%;'>";
                //href='tr_accionestramites.php?pes=tramite'
                    echo "<button type='submit' id='btnSig'  style='display:none; margin:5px;' class='Mbtn btn-default'>
                    <img src='icon/flecha1.png'> Siguiente
                    </button>";
                echo "</div>";
            echo "</form>";
                /*
                echo "<div id='resultadosCURP'>";
                echo "<label>Datos del CURP solicitado<br>";
                echo "<b>CURP: </b>".$value['CURP']."<br>";
                echo "<b>Nombre: </b>".$value['nombres']."<br>";
                echo "<b>Apellido Paterno: </b>".$value['apellido1']."<br>";
                echo "<b>Apellido Materno: </b>".$value['apellido2']."<br>";
                echo "<b>Sexo: </b>".$value['sexo']."<br>";
                echo "<b>Fecha de Nacimiento: </b>".$value['fechNac']."<br>";
                echo "<b>Nacionalidad: </b>".$value['nacionalidad']."<br>";
                echo "<b>Documento Probatorio: </b>".$value['docProbatorio']."<br>";
                echo "<b>Numero de Acta: </b>".$value['numActa']."<br>";
                echo "<b>CRIP: </b>".$value['CRIP']."<br>";
                echo "<b>Numero de Entidad Registrante </b>".$value['numEntidadReg']."<br>";
                echo "<b>Clave de Municipio Registrante: </b>".$value['cveMunicipioReg']."<br>";
                // echo "Num. de Registro para Extranjeros: ".$value['NumRegExtranjeros']."<br>";
                echo "<b>Estado del CURP: </b>".$value['statusCurp']."</label><br>";
                // echo "Entidad de Nacimiento: ".$value['nombreEntidadNac']."<br>";
                // echo "Entidad Registrante: ".$value['nombreEntidadReg']."<br>";
                // echo "Municipio Registrante ".$value['nombreMunicipioReg']."<br>";
            echo "</div>";
            */
            }else{	
                echo "<section id='aplicacionesReq' style='width:100%;'><BR><BR><cite class='tenue  '>ERROR:<BR><BR>".$value." </cite><BR><BR></section>";
            } 
        
        }  

    $c= $c +1;   
       
    }
} else {
    echo "No es un array";
}


?>
