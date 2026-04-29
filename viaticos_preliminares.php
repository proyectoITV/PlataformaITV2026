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





    if(isset($_GET['idviatico'])){
        //if (isset($_GET['idactividad'])){
            $idviatico = $_GET['idviatico'];           
    
            $sql = "Update viaticos set estatus=9, FechaCancelacion=NOW() where IdViatico = ".$idviatico;
            echo $sql ;
                if ($conexion->query($sql) == TRUE){ 
                    if(isset($_GET['del'])){
                        mensaje('Se canceló con exito el viatico','viaticos.php');  
                    }
                    else
                    {
                        mensaje('Se canceló con exito el viatico preliminar','viaticos_preliminares.php');  
                    }

                }else{
                    if(isset($_GET['del'])){
                        mensaje('Ocurrio un error al intentar cancelar el viatico , favor de intentarlo nuevamente.','viaticos.php');
                    }else
                    {
                        mensaje('Ocurrio un error al intentar cancelar el viatico preliminar, favor de intentarlo nuevamente.','viaticos_preliminares.php');
                    }
                }           
    }
      
   
    echo '<br>';    
    echo "<h4 style='color: black;'>VIATICOS EN FASE PRELIMINAR</h4>";
    echo "<hr>";

    if($nivel==2)
    { $sql = "SELECT
        a.IdViatico,
        a.NEmpleado,
        a.CapturaFecha,
        (select nombre from empleados where nitavu= a.NEmpleado) as Empleado,
        IFNULL((select CONCAT(Origen,'-',Destino) from viaticosrecorridos WHERE IdViatico = a.IdViatico limit 1),'Sin Definir') as Ruta,
        a.SalidaFecha,
        a.RegresoFecha
        
        FROM
            viaticos a
        WHERE
            estatus = 0 
          
        ORDER BY
        a.IdViatico desc";

     } else if($nivel==6)
     {
        $sql = "SELECT
        a.IdViatico,
        a.NEmpleado,
        a.CapturaFecha,
        (select nombre from empleados where nitavu= a.NEmpleado) as Empleado,
        IFNULL((select CONCAT(Origen,'-',Destino) from viaticosrecorridos WHERE IdViatico = a.IdViatico limit 1),'Sin Definir') as Ruta,
        a.SalidaFecha,
        a.RegresoFecha
        
        FROM
        viaticos a inner join empleados as e on e.nitavu=a.NEmpleado
						inner join cat_gerarquia as cg on cg.id=e.dpto
        WHERE
         (estatus= 0 ) and (cg.id=19 and  cg.IdDireccion=1) or (cg.IdDireccion=19 )
        ORDER BY a.IdViatico desc ";
     }

    else{
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
				cg.IdDireccion
        FROM
            viaticos a inner join empleados as e on e.nitavu=a.NEmpleado
						inner join cat_gerarquia as cg on cg.id=e.dpto
        WHERE
            Activa=1 and (estatus= 0 and (cg.IdDireccion='".$nitavu_dir."' or cg.id='".$nitavu_dir."'))
        ORDER BY
        a.IdViatico desc ";
    }
//echo $sql;

        $r= $conexion -> query($sql);  
        echo '<br>';
        echo '<center>';
        echo '<table class="tabla" style="font-size:9pt;width:90%">';
        echo "<th style = 'background-color: #ddc9a3; color: black;'><center>Num.Viático</center></th>";
        echo "<th style = 'background-color: #ddc9a3; color: black;'>Empleado</th>";
        echo "<th style = 'background-color: #ddc9a3; color: black;'><center>Ruta</center></th>";
        echo "<th style = 'background-color: #ddc9a3; color: black;'><center>Fechas Elaboracion</center></th>";  
        echo "<th colspan=2 style = 'background-color: #ddc9a3; color: black;'><center>Acciones</center></th>";
        
        while($f = $r -> fetch_array()) {
            echo "<tr>";
            echo "<td><center>";
            echo "<a class='btn btn-danger' style='background-color: #ab0033; box-shadow:0 3px  #c1c1c1; color:white; width:80%;' href='viaticos.php?new=".$f['NEmpleado']."&IdViatico=".$f['IdViatico']."'>";
            echo $f['IdViatico']."</center></a>";
            echo "</td>";
            echo "<td width=40%>".$f['Empleado']."</td>";
            echo "<td width=30%><center>".$f['Ruta']."</center></td>";
            // if ($f['SalidaFecha']=='0000-00-00'){
            //     echo "<td>Sin definir</td>";
            // } else {              
            //     echo "<td><center>Salida:".date_format(date_create($f['SalidaFecha']), 'd-M-y')." - ".date_format(date_create($f['RegresoFecha']), 'd-M-y')."</center></td>";
               
            // }
            echo "<td width=20%>".$f['CapturaFecha']."</td>";
           
            echo ' <td style="text-align:center;">';
            // echo "<a  title='Elimar Viatico' href='viaticos_preliminares.php?idviatico=".$f['IdViatico']."'>";                    
            // echo "<img src='icon/eliminar.png' style='width:35px; padding:5px; '>";
            echo "<a class='pc' href='#delete".$f['IdViatico']."' rel='MyModal:open' title='Cancelar Viatico'>";                    
            echo "<img src='icon/eliminar.png' style='width:35px; padding:5px;'> </a>";
            echo "<div id='delete".$f['IdViatico']."' class='MyModal' style='width:30%' >";      
            $mensaje="¿Esta seguro de cancelar el viatico N° ".$f['IdViatico']."?";
            $link='viaticos_preliminares.php?idviatico='.$f['IdViatico'];
            $link1='viaticos_preliminares.php';
            echo "<center>";
            echo '<p style="font-family: Regular; font-size:13pt;">'.$mensaje.'</p>';

            echo "<table>";
            echo "<tr>";
            echo "<td style='width: 44%;'>";
            echo '<a class="Mbtn btn-Danger" style="text-decoration: unset;" href="'.$link.'">Aceptar</a>';
            echo "</td>";
            echo "<td  style='width: 45%;'>";
            echo '<a class="Mbtn btn-Danger" style="text-decoration: unset;" href="'.$link1.'">Cancelar</a>';
            echo "</td>";
            echo "</tr>";
            echo "</table>";
            echo "</center>";
            echo "</div>"; 
            echo "</td>";
            echo "</tr>";

        }
        echo "</table>";
        echo '</center>';
        unset($r,$f,$sql);
        echo "</div>";

    }
    
    else {MsgBox_Lite("No tiene permiso para ver esta aplicacion",'');}	 
        
    ?>


<?php include ("./lib/body_footer.php"); ?>