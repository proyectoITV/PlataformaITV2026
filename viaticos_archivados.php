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
echo "<script>$('body').css('background-color','white');</script>";
echo "<script>$('body').css('background-image','url(img/recorridos.jpg)');</script>";
echo "<script>$('body').css('background-size','100% 100%');</script>";
echo "<script>$('body').css('background-repeat','repeat');</script>";
echo "<script>$('body').css('background-position','left top');</script>";

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";

    // if(isset($_GET['idviatico'])){
    //     //if (isset($_GET['idactividad'])){
    //         $idviatico = $_GET['idviatico'];           
    
    //         $sql = "Delete  from viaticos   where IdViatico = ".$idviatico;
    //         echo $sql ;
    //             if ($conexion->query($sql) == TRUE){ 
    //                 mensaje('Se eliminó con exito el viatico preliminar','viaticos_preliminares.php');    
    //             }else{
    //                 mensaje('Ocurrio un error al intentar eliminar el viatico preliminar, favor de intentarlo nuevamente.','viaticos_preliminares.php');
    //             }           
    // }
    

 echo "<br>";
 buscarSinRequired('viaticos_archivados.php','Busqueda por Departamento e Empleado','');
    // historia($nitavu, "Entro a buscar un empleado");
 
 //echo "</div>";
 //echo "</div>";
 
 
 if (isset($_GET['busqueda']))
 {
     
     $search = $_GET['busqueda'];
     
 }
  else {$search='';
         
 }
 
 $nitavu_dir=quienEsmiDireccion(nitavu_dpto($nitavu));
    echo '<br>';    
    echo "<h3 style='color: black;'>VIATICOS ARCHIVADOS</h3>";

    if($nivel==2)
    { $sql = "SELECT
        a.IdViatico,
        a.NEmpleado,
        a.CapturaFecha,
        empleados.nombre as Empleado,
        IFNULL((select CONCAT(Origen,'-',Destino) from viaticosrecorridos WHERE IdViatico = a.IdViatico limit 1),'Sin Definir') as Ruta,
        a.SalidaFecha,
        a.RegresoFecha, 
        a.estatus
        
        FROM
        viaticos a inner join empleados as e on e.nitavu=a.NEmpleado
						inner join cat_gerarquia as cg on cg.id=e.dpto
						inner join empleados on empleados.nitavu= a.NEmpleado
                       
              
        WHERE
            Activa = 0 and  empleados.nombre like '%".$search."%'
          
        ORDER BY
            NEmpleado,
            CapturaFecha";

    }else{
        $sql = "SELECT
        a.IdViatico,
        a.NEmpleado,
        a.CapturaFecha,
        (select nombre from empleados where nitavu= a.NEmpleado) as Empleado,
        IFNULL((select CONCAT(Origen,'-',Destino) from viaticosrecorridos WHERE IdViatico = a.IdViatico limit 1),'Sin Definir') as Ruta,
        a.SalidaFecha,
        a.RegresoFecha,
        a.estatus
    
        FROM
        viaticos a inner join empleados as e on e.nitavu=a.NEmpleado
						inner join cat_gerarquia as cg on cg.id=e.dpto
						inner join empleados on empleados.nitavu= a.NEmpleado
        WHERE
            Activa = 0    and cg.IdDireccion='".$nitavu_dir."' and  empleados.nombre like '%".$search."%'
       
       ORDER BY
            NEmpleado,
            CapturaFecha";

            if ( EstoyenDelegacion($nitavu) =='del'){
                $sql = "SELECT
                a.IdViatico,
                a.NEmpleado,
                a.CapturaFecha,
                (select nombre from empleados where nitavu= a.NEmpleado) as Empleado,
                IFNULL((select CONCAT(Origen,'-',Destino) from viaticosrecorridos WHERE IdViatico = a.IdViatico limit 1),'Sin Definir') as Ruta,
                a.SalidaFecha,
                a.RegresoFecha,
                a.estatus
                viaticos a inner join empleados as e on e.nitavu=a.NEmpleado
						inner join cat_gerarquia as cg on cg.id=e.dpto
						inner join empleados on empleados.nitavu= a.NEmpleado
                WHERE
              
                    Activa=0  and e.dpto='". nitavu_dpto($nitavu)."'  and  empleados.nombre like '%".$search."%'
                ORDER BY
                    NEmpleado,
                    CapturaFecha,  a.estatus desc";
                } 
    }
//echo $sql;



       


        $r = $conexion -> query($sql);
			
        $r_count = $r -> num_rows;
        
    if ($r_count<=0)
        { 	// en caso de haya resultados, hacer uno nuevo
           
            echo "<br><h3> Lo sentimos no se han encontrado resultados sobre <b class='normal'>[ ".$search." ]</b>
             <br>vuelva a intentarlo utilizando otras palabras de busqueda</h3>";
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
                // historia($nitavu,'Req_Busqueda de '.$search);
                // if ($search==''){
                //     echo "<br><h3>Se han encontrado ".$r_count. " viaticos: </h3>";
                // }else 
                // {
                    

                //     echo "<br><h3>Se han encontrado ".$r_count. " viaticos, con la busqueda  <b class='normal'>[ ".$search." ]</b>  </h3>";	
                // }
            
            $paginas = intval(($r_count / $paginacion))+1;
        }

        echo '<br>';
        echo '<center>';
        echo '<table class="table bordered" align="center" style="font-size:14; width:90%">';
        echo "<th style='bacKground:#ddc9a3; color:black;'><center>Num.Viático</center></th>";
        echo "<th style='bacKground:#ddc9a3; color:black;'>Empleado</th>";
        echo "<th style='bacKground:#ddc9a3; color:black;'><center>Ruta</center></th>";
        echo "<th style='bacKground:#ddc9a3; color:black;'><center>Fechas Elaboración</center></th>";  
        echo "<th style='bacKground:#ddc9a3; color:black;'><center>Estatus</center></th>";  
        echo "<th style='bacKground:#ddc9a3; color:black;'><center>Seguimiento</center></th>";  
        
        while($f = $r -> fetch_array()) {
            echo "<tr>";
            echo "<td><center>";
            echo "<a class='btn btn-danger' style='color:white; width:80%;' href='viaticos.php?new=".$f['NEmpleado']."&IdViatico=".$f['IdViatico']."'>";
            echo $f['IdViatico']."</center></a>";
            echo "</td>";
            echo "<td width=25%>".$f['Empleado']."</td>";
            echo "<td width=25%><center>".$f['Ruta']."</center></td>";
            echo "<td style='width=20%;'><center>".$f['CapturaFecha']."</center></td>";
            if ($f['estatus']=='1'){
                echo "<td style='width=20%;'><center>En Tramite</center></td>";
            } else if ($f['estatus']=='2'){
                echo "<td style='width=20%;'><center>VoBo Viáticos</center></td>";
            } else if ($f['estatus']=='3'){
                echo "<td style='width=20%;'><center>Impreso</center></td>";
            }else if ($f['estatus']=='4'){
                echo "<td style='width=20%;'><center>Firmas</center></td>";
            }else if ($f['estatus']=='5'){
                echo "<td style='width=20%;'><center>Pagar Viatico</center></td>";
            }else if ($f['estatus']=='6'){
                echo "<td style='width=20%;'><center>Comprobado</center></td>";
            }else if ($f['estatus']=='7'){
                echo "<td style='width=20%;'><center>VoBo Comisaría</center></td>";
            }else if ($f['estatus']=='8'){
                echo "<td style='color:#f50202; font-weight: bold; width=20%;'><center>Sin Presupuesto</center></td>";
            }else if ($f['estatus']=='9'){
                echo "<td style=' color: #f50202; font-weight: bold; width=20%;'><center>Cancelado-Comprobacion</center></td>";
            }else if ($f['estatus']=='10'){
                echo "<td style=' color: #f50202; font-weight: bold; width=20%;'><center>Rechazado</center></td>";
            }

            echo "<td><center>";
       
            echo "<a href='#modalHistorial".$f['IdViatico']."' rel='MyModal:open' style='font-size:11px;'>";
            echo "<img src='icon/seguimiento.png' style='width:35px; padding:5px; '> </center>";
            echo "</a>";
           //              /*MODAL   HISTORIAL*/
                         echo "<div id='modalHistorial".$f['IdViatico']."' class='MyModal' >"; 
                         echo '<h1 class="card-header h5" style="text-transform: uppercase;font-size: 10pt; color: #ab0033;">IdViatico N°'.$f['IdViatico'].' '.$f['Empleado'].' '.$f['Ruta'].'</h1><br>';
                           echo '<table class="tabla_punteada tabla"  align="center" style="font-size: 12; vertical-align: middle; ">
                        <thead>
                        <tr  align="center" style=" bacKground:#E75F54; color:white;">                   
                            <th style="width:10%;">Id</th>
                            <th  style=" vertical-align: middle; width:10%;">Fecha</th>
                            <th>Empleado</th>   
                            <th colspan="2">Estatus</th>   
                           
                            <th>Comentario</th>          
                       </tr>
                        </thead>
                        <tbody>';
                        $sql2=" Select * from viaticosseguimiento where IdViatico=".$f['IdViatico']."";
                   //echo $sql2;
                        $r2= $conexion -> query($sql2);                         
                         while($fx = $r2 -> fetch_array()) 
                        {
                            echo ' <tr>';    
                            echo ' <td><center>'.$fx["IdSegViatico"] .'</center></td>';                           
                            echo ' <td><center>'.date_format(date_create($fx["FechaCrea"]), 'd/m/Y').'</center></td>';
                            echo ' <td>'.nitavu_nombre($fx["NitavuCrea"]) .'</td>';
                           if ($fx['IdEstatus']=='0'){
                               echo "<td>Creado</td><td ></td> ";                            }
                           else if ($fx['IdEstatus']=='1'){
                               echo "<td>En Tramite</td><td ></td> ";
                           } else if ($fx['IdEstatus']=='2'){
                               echo "<td>VoBo Viáticos</td><td ></td> ";
                           } 
                           else if ($fx['IdEstatus']=='3'){
                               echo "<td>Impreso </td>";
                               echo '<td style="width: 10px;"><a  class="btn btn-secondary" href=Viaticos_Formato.php?id='.$f['IdViatico'].' ><img src="icon/pdf.png" style="width:18px;"</a>
                               <a  class="btn btn-secondary" href=oficio_viaticos.php?id='.$f['IdViatico'].' title="Oficio Viaticos"><img src="icon/pdf.png" style="width:18px;>"</a>
                               </td>';
                           }else if ($fx['IdEstatus']=='4'){
                               echo "<td>Firmas</td> <td ></td> ";
                           }else if ($fx['IdEstatus']=='5'){
                               echo "<td>Pagar Viactico</td><td ></td> ";
                           }else if ($fx['IdEstatus']=='6'){
                               echo "<td>Comprobado</td><td ></td> ";
                           }else if ($fx['IdEstatus']=='7'){
                               echo "<td>VoBo Comisaría</td><td ></td> ";
                           }else if ($fx['IdEstatus']=='9'){
                               echo "<td>Cancelado ** Comprobacion**</td><td ></td> ";
                           }
               
                            echo ' <td>'.$fx["Observaciones"] .'</td>';        
                        
                            echo ' </tr>';
                        }
           //              echo '</td>';
           //              echo '</tr>';
                          
                           echo '</tbody>
                           </table>';
                           echo "</div>"; 
             
           echo "</td>";
            echo "</tr>";

        }
        echo "</table>";
        echo '</center>';
        unset($r,$f,$sql);

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
                            echo "<span id='pagina_proxima'><a href='?busqueda=".$search."&p=".$i."'>".$i."</a></span>"; //CSS span a = link a paginas
                        }
                    }
                
            echo "</div></center>";

        }
        echo "</div>";

 


    }
    else {MsgBox_Lite("No tiene permiso para ver esta aplicacion",'');}	 
        
    ?>


<?php include ("./lib/body_footer.php"); ?>