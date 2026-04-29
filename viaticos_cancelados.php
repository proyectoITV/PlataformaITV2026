<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); 
require_once("config.php");
require("viaticos_fun.php");
?>
<?php

$id_aplicacion ="viaticos"; //tabla aplicaciones
$nivel = aplicacion_nivel($id_aplicacion, $nitavu); //tabla aplicaciones permisos
//Niveles
// 1 = Crear y Editar
// 2 = Consulta

//Ajusta esta variable para ver el comportamiento


if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";

    $nitavu_dir=quienEsmiDireccion(nitavu_dpto($nitavu));

    echo '<br>';    
    echo "<h4 style='color: black;'>VIATICOS CANCELADOS</h4>";
    echo "<hr>";

    if($nivel==2)
    { $sql = "SELECT
        a.IdViatico,
        a.NEmpleado,
        a.CapturaFecha,
        (select nombre from empleados where nitavu= a.NEmpleado) as Empleado,
        IFNULL((select CONCAT(Origen,'-',Destino) from viaticosrecorridos WHERE IdViatico = a.IdViatico limit 1),'Sin Definir') as Ruta,
        a.SalidaFecha,
        a.RegresoFecha,
        a.FechaCancelacion,
        (select Observaciones from viaticosseguimiento where   IdViatico=a.IdViatico order by IdSegViatico desc limit 1) as Observacion
       
        FROM
            viaticos a
        WHERE
            estatus = 9
          
        ORDER BY
            NEmpleado,
            CapturaFecha";

    }else{
        // $sql = "SELECT
        // a.IdViatico,
        // a.NEmpleado,
        // a.CapturaFecha,
        // (select nombre from empleados where nitavu= a.NEmpleado) as Empleado,
        // IFNULL((select CONCAT(Origen,'-',Destino) from viaticosrecorridos WHERE IdViatico = a.IdViatico limit 1),'Sin Definir') as Ruta,
        // a.SalidaFecha,
        // a.RegresoFecha
        
        // FROM
        //     viaticos a
        // WHERE
        //     estatus = 0 
        //     and a.NEmpleado='".$nitavu."'
        // ORDER BY
        //     NEmpleado,
        //     CapturaFecha";


            $sql = "SELECT
        a.IdViatico,
        a.NEmpleado,
       a.CapturaFecha,
        (select nombre from empleados where nitavu= a.NEmpleado) as Empleado,
        IFNULL((select CONCAT(Origen,'-',Destino) from viaticosrecorridos WHERE IdViatico = a.IdViatico limit 1),'Sin Definir') as Ruta,
        a.SalidaFecha,
        a.RegresoFecha,
        a.estatus,
        e.dpto,
				cg.IdDireccion,
                a.FechaCancelacion,
                (select Observaciones from viaticosseguimiento where   IdViatico=a.IdViatico order by IdSegViatico desc limit 1) as Observacion
        FROM
            viaticos a inner join empleados as e on e.nitavu=a.NEmpleado
						inner join cat_gerarquia as cg on cg.id=e.dpto
        WHERE
            Activa=1 and (estatus= 9 and (cg.IdDireccion='".$nitavu_dir."' or cg.id='".$nitavu_dir."'))
        ORDER BY
            NEmpleado,
            CapturaFecha,  a.estatus desc";
    }
//echo $sql;

        //$r= $conexion -> query($sql);  


        $r = $conexion -> query($sql);
			
        $r_count = $r -> num_rows;
        
    if ($r_count<=0)
        { 	// en caso de haya resultados, hacer uno nuevo
            
            // echo "<br><h3> Lo sentimos no se han encontrado resultados sobre <b class='normal'></b>
            //  <br>vuelva a intentarlo utilizando otras palabras de busqueda</h3>";
            //mensaje($msg,"./req.php");
        }
    else
        {
            /// PARA PAGINAR
            //Comprueba si está seteado el GET de HTTP
            if (isset($_GET["p"])) {
                //Si el GET de HTTP SÍ es una string / cadena, procede
                if (is_string($_GET["p"])) {
                    //Si la string es numérica, define la variable 'pagina'
                    if (is_numeric($_GET["p"])) {
                        //Si la petición desde la paginación es la página uno
                        //en lugar de ir a 'index.php?pagina=1' se iría directamente a 'index.php'
                            $pagina = $_GET["p"];
                        
                    } 
                    else
                    { //Si la string no es numérica, redirige al index (por ejemplo: index.php?pagina=AAA)
                        header("Location: ./index.php");
                        die();
                    };
                };
            } else { //Si el GET de HTTP no está seteado, lleva a la primera página (puede ser cambiado al index.php o lo que sea)
                $pagina = 1;
            };
            //Define el número 0 para empezar a paginar multiplicado por la cantidad de resultados por página
            $empezar_desde = ($pagina-1) * $paginacion;
            // agregamos limite a la consulta
            $sql = $sql." LIMIT ".$empezar_desde.", ".$paginacion;
            //echo $sql;
                $r = $conexion -> query($sql);
               //historia($nitavu,'Req_Busqueda de '.$search);
                
            
            $paginas = intval(($r_count / $paginacion))+1;
                
        }
        echo '<br>';
        echo '<center>';
        echo '<table class="tabla" style="font-size:9pt;width:90%">';
        echo "<th style = 'background-color: #ddc9a3; color: black;'><center>Num.Viático</center></th>";
        echo "<th style = 'background-color: #ddc9a3; color: black;'>Empleado</th>";
        echo "<th style = 'background-color: #ddc9a3; color: black;'><center>Ruta</center></th>";
        echo "<th style = 'background-color: #ddc9a3; color: black;'><center>Fecha Elaboración</center></th>";  
        echo "<th style = 'background-color: #ddc9a3; color: black;'><center>Fecha Cancelación</center></th>";  
        echo "<th style = 'background-color: #ddc9a3; color: black;'><center>Observacion</center></th>"; 
        // echo "<th colspan=2><center>Acciones</center></th>";
        
        while($f = $r -> fetch_array()) {
            echo "<tr>";
            echo "<td><center>";
            echo "<a class='btn btn-danger' style='background-color: #ab0033; box-shadow:0 3px  #c1c1c1; color:white; width:80%;' href='viaticos.php?new=".$f['NEmpleado']."&IdViatico=".$f['IdViatico']."'>";
            echo $f['IdViatico']."</center></a>";
            echo "</td>";
            echo "<td width=40%>".$f['Empleado']."</td>";
            echo "<td width=30%><center>".$f['Ruta']."</center></td>";
            
            echo "<td width=20% style='text-align:center;'>".date_format( date_create($f['CapturaFecha']), 'd/m/Y')."</td>";
            echo "<td width=20%  style='text-align:center;'>".date_format( date_create($f['FechaCancelacion']), 'd/m/Y')."</td>";
            echo "<td width=20%  style='text-align:center;'>".$f['Observacion']."</td>";
            echo "</tr>";

        }
        echo "</table>";
        echo '</center>';
        unset($r,$f,$sql);
        echo "</div>";


        if ($r_count >= $paginacion)
				{
					echo "<center><div id='barra_paginacion'>";
						echo "Paginas: ";
							//Crea un bucle donde $i es igual 1, y hasta que $i sea menor o igual a X, a sumar (1, 2, 3, etc.)
							//Nota: X = $total_paginas
							for ($i=1; $i<=$paginas; $i++) 
							{
								//En el bucle, muestra la paginación
								if ($pagina==$i)
								{
									echo "<span id='pagina_actual'>".$pagina."</span>";
								
										 //para el CSS span = a pagina actual
								}
								else
								{
									echo "<span id='pagina_proxima'><a href='?p=".$i."'>".$i."</a></span>"; //CSS span a = link a paginas
								}
							}
						
					echo "</div></center>";

				}

    }
    
    else {MsgBox_Lite("No tiene permiso para ver esta aplicacion",'');}	 
        
    ?>


<?php include ("./lib/body_footer.php"); ?>