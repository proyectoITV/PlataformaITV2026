<?php include ("./unica/body_head.php"); include ("./unica/body_menu.php"); ?>
<?php
require("unica/config.php");
$id_aplicacion = 'ap50';
echo "<h5>".app_detalle($id_aplicacion)."</h5>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap50"; //ap07=Permisos de Aplicacion
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if ( isset($_GET['busqueda'])){} else {echo "<div class='centrar_padreReportes' >"."<div class='centrar_hijoReportes'>";}
buscar("estatus_reporte.php","¿Que reporte buscas? o escribe el ID",'');

$existe = 0;
//Buscamos un reporte
if ( isset($_GET['busqueda']) ){} else {echo "</div></div>";}
if ( isset($_GET['busqueda'])){
    if($existe==0){
        $sql="SELECT  * FROM reportes  WHERE  id_rep_consulta='".$_GET['busqueda']."' OR nombre like '%".$_GET['busqueda']."%'
        OR  descripcion like'%".$_GET['busqueda']."%'";
        // echo $sql;
        $rc= $conexion -> query($sql);
        if ($rc->num_rows>0){
            historia($nitavu,'Busco un reporte '.$_GET['busqueda']);
            echo "<h3 class=''>Resultados de <b class='normal'>".$_GET['busqueda']."</b></h3>";
            echo "<table id='estatusTabla' class='tabla'>";
            echo "<th width='10%'>Id</th>";
            echo "<th width='30%'>Nombre</th>";
            echo "<th>Descripcion</th>";
            echo "<th>Estado</th>";
            echo "<th width='10%'>Solicitado por</th>";
            while($r = $rc -> fetch_array()){//AGREGAMOS QUIEN PODRA VER EL REPORTE
                echo "<tr>";
                echo "<td>".$r['id_rep_consulta'];
                
                echo "</td>";
                echo "<td>".$r['nombre']."</td>";
                echo "<td>".$r['descripcion']."</td>";
                echo "<td>";
                echo "<b>[".$r['estado']." ]</b>";
                if($r['estado']  == 1){
                    echo "Reporte creado por informática. <br><p style='color:blue'>**En espera de que se envie al encargado de la información para aprobación.</p>";  
                }else if($r['estado'] == 2){
                    echo "Solicitando permiso con el encargado de la información del Reporte.";
                    echo "<br><ul><b>Estado del reporte con el encargado: </b>";
                    $sql2 = "SELECT * FROM reportes_autoriza where idRep =".$r['id_rep_consulta']."";
                    $rc2= $conexion -> query($sql2); while($f = $rc2 -> fetch_array()){
                        if($f['estado']==0){
                            
                            echo "<br><li style='color:blue'>Esperando autorización de ".nitavu_nombre($f['autoriza'])." para enviar el reporte al solicitante y pueda publicarlo.</li>";
                        }else if($f['estado']==1){
                            // echo "<br><li style='color:blue'>Reporte aprobado para publicar por ".$f['autoriza']."</li>";
                            echo "<br><li style='color:blue'>Reporte aprobado para publicar por ".nitavu_nombre($f['autoriza'])."</li>";
                        }else if($f['estado']==2){
                            // echo "<br><li style='color:red'>Reporte denegado para publicar por ".$f['autoriza']."</li>";
                            echo "<br><li style='color:red'>Reporte denegado para publicar por ".nitavu_nombre($f['autoriza'])."</li>";
                        }
                        echo "</ul>";
                        echo "";
                    }
                    
                }else if(($r['modificar']== 0) and($r['estado']==3)){
                    echo "Aprobado para publicación. <br><p style='color:blue'>**En este punto la persona que solicitó el reporte ya lo puede publicar.</p>";
                }else if(($r['modificar']== 1) and($r['estado']==3)){
                    echo "Se ha solicitado modificar el reporte.<br><p style='color:blue'>**Pendiente de realizar cambios por el departamento de informática.</p>";
                }else if($r['estado']==4){
                    echo "Reporte publicado";
                }
                echo "</td>";

                $archivo = "fotos/".$r['solicitante'].".jpg";
                echo "<td>".ponerfoto($archivo,'imagenPermiso')."<p style='font-size:15px'>".nitavu_nombre($r['solicitante'])."</p></td>";
            }
        echo "</tr>"; 
        echo "</table>";
        }else{ 
            $sql="SELECT  * FROM reportesConsultas  WHERE  idConsulta='".$_GET['busqueda']."' OR nombre like '%".$_GET['busqueda']."%'
            OR  descripcion like'%".$_GET['busqueda']."%'";
            $rc= $conexion -> query($sql);
           
            if ($rc->num_rows>0){

                historia($nitavu,'Busco un reporte '.$_GET['busqueda']);
                echo "<h3 class=''>Resultados de <b class='normal'>".$_GET['busqueda']."</b></h3>";
                echo "<table id='estatusTabla' class='tabla'>";
                echo "<th width='10%'>Id</th>";
                echo "<th width='30%'>Nombre</th>";
                echo "<th>Descripcion</th>";
                echo "<th>Estado</th>";
                echo "<th width='10%'>Solicitado por</th>";
                while($r = $rc -> fetch_array()){//AGREGAMOS QUIEN PODRA VER EL REPORTE
                    echo "<tr>";
                    echo "<td>".$r['idConsulta']."</td>";
                    // echo "<td>".$r['nombre']."</td>";
                    echo "<td>".$r['nombre']."<br><label>Solicitado el ".fecha_larga($r['fechasol'])." a las ".hora12($r['horasol'])."</label></td>";
                    echo "<td>".$r['descripcion']."</td>";
                    if($r['estado']  == 0){
                        echo "<td>Solicitud de reporte en espera. <br><p style='color:blue'>**El departamento de informática no ha creado las consultas para realizar el reporte.</p></td>";  
                    }
                    $archivo = "fotos/".$r['solicitante'].".jpg";
                    echo "<td>".ponerfoto($archivo,'imagenPermiso')."<p style='font-size:15px'>".nitavu_nombre($r['solicitante'])."</p></td>";
                }
                echo "</tr>"; 
                echo "</table>";
                $existe = 0;  
            }else{
                $msg="No se ha encontrado el reporte <b>".$_GET['busqueda']."</b>.";
                sentimental($msg);
            }
        }
    }
       
} 
echo "</div>";

?>
<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<br><br><br>
<br>
<br>
<?php include ("./unica/body_footer.php"); ?>