<?php
    require("seguridad.php");
    //require("lib/funciones.php");
    //require("config.php");
    if (isset($_POST["id"]))
    {
        $idmanzana=$_POST["id"];
        $idlote=$_POST["id2"];

        
       // $consulta = "select IdColonia , Colonia from catcolonia where IdMunicipio=".$idmun ;
        $consulta="SELECT     NombreCompleto, Programa, Municipio, Colonia, manzana, lote
        FROM         busqueda_vivienda_informacioncontratos
        WHERE     (IdMunicipio = 22) AND (IdColonia = 1) AND (manzana = '1') AND (lote = '1')";

       // echo $consulta;
                $ConsultaDATA = DatosVivienda(0, "WS", "Test1", $consulta);
                //echo $ConsultaDATA;

                $datos = utf8_decode($ConsultaDATA);
				$resultado = str_replace("?", "Ñ", $datos);
                $arraycol = json_decode($resultado, true);
               /* echo "<label for='col'>Seleccione una Colonia:";
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
                 echo "</label>";       */
    }
        
?>