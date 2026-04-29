<?php
    require("seguridad.php");
    //require("lib/funciones.php");
    //require("config.php");
    if (isset($_POST["del"]))
    {
        $del=$_POST["del"];   
    //    $del= isset($_POST["del"]);
        
        $consulta = "SELECT IDDELEGACION, DELEGACION FROM delegaciones WHERE TIPO=0 ORDER BY DELEGACION";
       // echo $consulta;
                $ConsultaDATA = DatosVivienda(0, "WS", "Test1", $consulta);
                //echo $ConsultaDATA;

                $datos = utf8_decode($ConsultaDATA);				
                $array = json_decode($datos, true);
                echo "<div id='combo' name='combo' style='width: 100%;'>" ;
                echo "<label for='de'>Seleccione la delegación donde se ejecutará la consulta:";
                echo "<select id='del' name='del'>";
                
				echo "<option>Seleccione una opcion...</option>";
                if(is_array($array))
                {
                    foreach ($array as $value) 
                    {
                        if ($del==$value['IDDELEGACION'])
                            {
                                    $entro=true;
                                    echo "<option value='".$value['IDDELEGACION']."' selected='selected'>".$value['DELEGACION']."</option>";						
                            }
                            else
                            {
                               echo "<option value='".$value['IDDELEGACION']."'>".$value['DELEGACION']."</option>";		
                            }					
					}
                }
                else
                {
					echo "no es un array";
                }
                 echo "</select>";
                 echo "</label>";   
                 echo "</div>" ;
     }
        
?>