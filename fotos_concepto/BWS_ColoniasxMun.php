<?php
    require("unica/seguridad.php");
    //require("unica/funciones.php");
    //require("unica/config.php");
    if (isset($_POST["idclase"]))
    {
        $idmun=$_POST["idclase"];    
        
        $consulta = "select IdColonia , Colonia from CatColonia where IdMunicipio=".$idmun.
                    "order by Colonia";
       // echo $consulta;
                $ConsultaDATA = DatosVivienda(0, "WS", "Test1", $consulta);
                //echo $ConsultaDATA;

                $datos = utf8_decode($ConsultaDATA);
                $datos = utf8_decode($datos);
				$resultado = str_replace("?", "Ñ", $datos);
                $arraycol = json_decode($resultado, true);
                echo "<label for='col'>Seleccione una Colonia:";
				echo "<select id='col' name='col'>";
				echo "<option>Seleccione una opcion...</option>";
                if(is_array($arraycol)){
							foreach ($arraycol as $valuecol) {
								echo "<option value='".$valuecol['IdColonia']."'>".$valuecol['Colonia']."</option>";
							}
						}else{
							echo "no es un array";
                        }
                 echo "</select>";
                 echo "</label>";       
    }
        
?>