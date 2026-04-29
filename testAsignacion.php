
<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php");?>
<?php

		/* $consultaguarda="update IngresosDiarios set FormaPago=80 where IdDelegacion=1 and IdPrograma=78 and IdSemana=19 and Tipo='IE'
        select @@ROWCOUNT as resultado;
         set nocount off	
        "; */

        $consultaguarda="update IngresosDiarios set FormaPago=99 where IdDelegacion=1 and IdPrograma=78 and IdSemana=19 and TIPO='IE'select @@ROWCOUNT as resultado";
        //$consultaguarda="select @@version";
		$ConsultaDATA = DatosViviendaLarge(0, "WS", "Test1", $consultaguarda);
				var_dump($ConsultaDATA);
                //echo $ConsultaDATA;                
				/* $arraycol = json_decode($resultado, true);
				echo "<div id='tablaresultado' style='display:inline-block; width: 50%;'>";
				echo "<center><table class='tabla' >";
				//var_dump($arraycol);
				if(is_array($arraycol)){
					
					foreach ($arraycol as $value) {
					if (isset($value['r'])){
							
							mensaje("No se encontraron resultados","CartaAsignacion.php");
						}
						else								
						{
						//	echo "ok";
						echo "<br><br>";
						echo "<th colspan='2'>Resultados de la búsqueda</th>";
						
						echo "<tr><td>IdLote</td><td>".$value['resultado']."</td></tr>";
						
						}
							
					}
				}else{
					echo "no es un array";
				}
	}	  */
    
 include ("./lib/body_footer.php"); ?>