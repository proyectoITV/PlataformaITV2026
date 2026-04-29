<?php
require("seguridad.php");
require_ONCE("lib/funciones.php");
require("config.php");
    // if (isset($_POST["del"]))
    // {
      
    //  }


    $cveEntidad=$_POST["cveEntidad"];
    $fechanac=$_POST["fechaNac"];
    $nombres=$_POST["nombres"];
    $apellido1=$_POST["apellido1"];
    $apellido2=$_POST["apellido2"];
    $sexo=$_POST["sexo"];
    $usuario=$nitavu;

    $resultado=CURP_detalle($cveEntidad, $fechanac, $nombres, $apellido1, $apellido2, $sexo, $usuario);

;
  $c = 1;
 $exito = 'FALSE';
 $array = json_decode($resultado, true);
//$array = json_decode($ResultadoDelCURP, true);

if(is_array($array)){    
    foreach ($array as $value) {
        if ($c==1)
        {       
            if ($value==1)
            {
                 $exito = 'TRUE';
            }            
        } else {
            if ($exito =='TRUE'){

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

            
            //     echo "<form action='tr_accionestramites.php?pes=tramite' method='POST' >"; 
            //     echo "<div style='width:100%'>";
            //     echo "<div style='width: 40%; display: inline-block; vertical-align: TOP'>";
            //     echo "<center>";
            //      echo "<section id='aplicacionesReq' style='text-align: left; width: 85%;'>";
               
            //      echo "<article><table border='0'><tbody><tr><td></td>
            //      <td><b class='normal menu_font_n'>CURP:</b> <cite class='tenue menu_font_d '>".$value['CURP']." </cite></td><td width='10px'></td>
            //      <td style='display:none'> <input type='hidden' name='curp' value=".$value['CURP']." >  </td>
            //      </tr></tbody></table></article>";

            //  echo "<article><table border='0'><tbody><tr><td></td>
            //      <td><b class='normal menu_font_n'>Nombre:</b> <cite class='tenue menu_font_d '>".$value['nombres']."</cite></td><td width='10px'></td>
            //      <td style='display:none'> <input type='hidden' name='nombres' value=".$value['nombres']." >  </td>
            //      </tr></tbody></table></article>";

            //  echo "<article><table border='0'><tbody><tr><td></td>
            //      <td><b class='normal menu_font_n'>Apellido Paterno:</b> <cite class='tenue menu_font_d '>".$value['apellido1']."</cite></td><td width='10px'>
            //      <input type='hidden' name='apellido1' value=".$value['apellido1']." ></td>	
            //      </tr></tbody></table></article>";

            //  echo "<article><table border='0'><tbody><tr><td></td>
            //      <td><b class='normal menu_font_n'>Apellido Materno:</b> <cite class='tenue menu_font_d '>".$value['apellido2']." </cite></td><td width='10px'>
            //      <input type='hidden' name='apellido2' value=".$value['apellido2']." ></td>					
            //      </tr></tbody></table></article>";


            //  echo "<article><table border='0'><tbody><tr><td></td>
            //      <td><b class='normal menu_font_n'>Sexo:</b> <cite class='tenue menu_font_d '>".$value['sexo']."</cite></td><td width='10px'>
            //      <input type='hidden' name='sexo' value=".$value['sexo']." ></td>					
            //      </tr></tbody></table></article>";

            //  echo "<article><table border='0'><tbody><tr><td></td>
            //      <td><b class='normal menu_font_n'>Fecha de Nacimiento:</b> <cite class='tenue menu_font_d '>".$value['fechNac']."</cite></td><td width='10px'>
            //      <input type='hidden' name='fechNac' value=".$value['fechNac']." ></td>				
            //      </tr></tbody></table></article>";

            //  echo "<article><table border='0'><tbody><tr><td></td>
            //      <td><b class='normal menu_font_n'>Nacionalidad:</b> <cite class='tenue menu_font_d '>".$value['nacionalidad']."</cite></td><td width='10px'>
            //      <input type='hidden' name='nacionalidad' value=".$value['nacionalidad']." ></td>					
            //      </tr></tbody></table></article>";

            //  echo "<article><table border='0'><tbody><tr><td></td>
            //      <td><b class='normal menu_font_n'>Estado del CURP:</b> <cite class='tenue menu_font_d '>".$value['statusCurp']."</cite></td><td width='10px'>
            //      <input type='hidden' name='statusCurp' value=".$value['statusCurp']." ></td>                 
            //      </tr></tbody></table></article>";
                
                
            //     echo "</section>";
            //     echo "</center>";
            //     echo "</div>";
            //     echo "<div style='width: 10%; display: inline-block; VERTICAL-ALIGN: TOP'>";
            //     echo "<button type='submit' id='btnSig'  style='display:none;' class='Mbtn btn-default'>
            //     <img src='icon/flecha1.png'>
            //     </button>";
            //     // echo "<button type='' value='Consultar' class='Mbtn btn-default' onclick='cosnultarCurpDetalle()' >Siguiente</button>";
            //    /// echo "<a href='tr_accionestramites.php?pes=tramite' class='Mbtn btn-default' ><img src='icon/flecha1.png'></a>";
            //     echo "</div>";
            //     echo "</div>";
            //     echo "</form>";
            }else
            {	
                echo "<center>";
                echo "<section id='aplicacionesReq' style='width:100%;'><BR><BR><cite class='tenue  '>ERROR:<BR><BR>".$value." </cite><BR><BR></section>";
                echo "</center>";
            }
        
        }   

    $c= $c +1;    
}

} else {
    echo "ERROR: No es un array";
}


































// ECHO $resultado;
// if(is_array($array)){					
//     foreach ($array as $value) {  
//         $value['error'];     
//     if (isset($value['error'])){                          
//           echo  $value['error'];
//           echo "entrp";
//         }
//         // else
//         // {
           
//         //         echo "CURP: ".$value['CURP']."<br>";
//         //         echo "Nombre: ".$value['nombres']."<br>";
//         //         echo "Apellido Paterno: ".$value['apellido1']."<br>";
//         //         echo "Apellido Materno: ".$value['apellido2']."<br>";
//         //         echo "Sexo: ".$value['sexo']."<br>";
//         //         echo "Fecha de Nacimiento: ".$value['fechNac']."<br>";
//         //         echo "Nacionalidad: ".$value['nacionalidad']."<br>";
//         //         echo "Documento Probatorio: ".$value['docProbatorio']."<br>";
//         //         echo "Numero de Acta: ".$value['numActa']."<br>";
//         //         echo "CRIP: ".$value['CRIP']."<br>";
//         //         echo "Numero de Entidad Registrante ".$value['numEntidadReg']."<br>";
//         //         echo "Clave de Municipio Registrante: ".$value['cveMunicipioReg']."<br>";
//         //         // echo "Num. de Registro para Extranjeros: ".$value['NumRegExtranjeros']."<br>";
//         //         echo "Estado del CURP: ".$value['statusCurp']."<br>";
//         //         // echo "Entidad de Nacimiento: ".$value['nombreEntidadNac']."<br>";
//         //         // echo "Entidad Registrante: ".$value['nombreEntidadReg']."<br>";
//         //         // echo "Municipio Registrante ".$value['nombreMunicipioReg']."<br>";
            

//         // }
        
//     }
       
// }else
// {
//     $resultado="<p>ERROR.- NO ES UN ARRAY, FAVOR DE REVISAR LA CONSULTA </p>";
// }

?>