<?php
include ("./unica/body_head.php"); include ("./unica/body_menu.php");

?>
<script>

function histosen(){   
   $("#preloader").css({'display':'inline-block'});   
    ipx = $('#ip').val();
    console.log(ipx);
   $.ajax({
	   url: "ipinfo_histosen.php",
	  type: "get",   
	  data: {ip: ipx },
	  success: function(data){	   
	   $('#histosen').html(data+"\n");	   
	   $("#preloader").css({'display':'none','color':'gray'});
	  }
   });
   
}


</script>
<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$id_aplicacion ="ap80"; //Id de la aplicacion a cargar
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<h5>".app_detalle($id_aplicacion)."</h5>";

    if (isset($_POST['ip_save'])){
        //guardamos la nueva ip
        $Resultado = IPguardar ($nitavu, $_POST['ip'], $_POST['empleado'], $_POST['macaddress'], $_POST['ipgateway'], $_POST['ipmask'], $_POST['pc_name'], $_POST['pc_marca'], $_POST['pc_modelo'], $_POST['pc_memoria'], $_POST['pc_hd'], $_POST['pc_descripcion'], $_POST['pc_serie'],$_POST['pc_inventario'], $_POST['comentarios'] );
        if ($Resultado == TRUE){
            mensaje("IP guardada correctamente",'./ipinfo.php?=');
        } else {
            mensaje("ERROR al intentar guardar la ip; ",'./ipinfo.php?=');

        }
    }

    if (isset($_POST['ip_edit'])){
        //actualizamos la nueva ip
        $Resultado = IPupdate ($nitavu, $_POST['ip'], $_POST['empleado'], $_POST['macaddress'], $_POST['ipgateway'], $_POST['ipmask'], $_POST['pc_name'], $_POST['pc_marca'], $_POST['pc_modelo'], $_POST['pc_memoria'], $_POST['pc_hd'], $_POST['pc_descripcion'], $_POST['pc_serie'],$_POST['pc_inventario'], $_POST['comentarios'] );
        if ($Resultado == TRUE){
            mensaje("IP actualizada correctamente",'./ipinfo.php?=');
        } else {
            mensaje("ERROR al intentar actualizar la ip; ",'./ipinfo.php?=');

        }
    }

    if (isset($_GET['delete']) and $_GET['delete']<>'' ){
        $Resultado = IPdelete($nitavu, $_GET['delete']);
        if ($Resultado == TRUE ){
            mensaje("IP eliminada; apartir de este momento no podra accederse a la plataforma desde esta ip ".$_GET['delete'],'./ipinfo.php?=');
        } else {
            mensaje("ERROR al intentar eliminar la ip; ".$_GET['delete'],'./ipinfo.php?=');
        }

    }
    if ( isset($_GET['info']) and ($_GET['info']<>'') ){
        echo "<h3 style='color: #8A8A7B; margin-top:35px;'><img src='icon/red1.png' style='width:20px;'> Información encontrada sobre ".$_GET['info']."</h3>";

        echo "<div class='Ventana' style='width: 97%;'>";
        $sql="
        select usuario as UserIP,
        (select nombre from empleados where nitavu=userIP)as nombre,
        (select dpto from empleados where nitavu=userIP) as DptoId,
        (select nombre from cat_gerarquia where id = DptoID) as Dpto,

        sessiones.* from sessiones where ipcliente='".$_GET['info']."'
        order by fecha DESC

        ";
        $r3= $conexion -> query($sql);
        // echo $sql;
        echo "<h3 style='color: red; font-size:9pt;'>Sessiones de ".$_GET['info']."</h3>";
        echo "<table class='tabla'>";
        while($f3 = $r3 -> fetch_array()) {
        echo "<tr style='font-size:8pt;'>";
        echo "<td width=30%>";
        echo "Apertura: ".fecha_larga($f3['fecha'])." | ".$f3['hora'];
        if ($f3['cierre_fecha']=='0000-00-00'){
            echo "<br>Sin cierre de session";
        } else{
            echo "<br>Cierre: ".fecha_larga($f3['cierre_fecha'])." | ".$f3['cierre_hora'];
        }

        echo "</td>";
        echo "<td width=30%>".$f3['nombre']."</td>";
        echo "<td><code>".$f3['comentarios']."</code></td>";


        echo "</tr>";
        }
        echo "</table>";
        echo "</div>";



        
        echo "<div class='Ventana' style='background-color: #FFFFBF; width: 97%;'>";
        $sql="
        SELECT
            nitavu as NEmpleado,
            (select nombre from empleados where nitavu=NEmpleado) as Empleado,
            (select puesto from empleados where nitavu=NEmpleado) as Puesto,
            (select dpto from empleados where nitavu=NEmpleado) as DptoID,
            (select nombre from cat_gerarquia where id = DptoID) as Dpto,
            
            historia.* 
        FROM
            historia 
        WHERE
            descripcion LIKE '%".$_GET['info']."%' 
            AND descripcion NOT LIKE 'Acceso%' 
            AND descripcion NOT LIKE 'Usando%'
        
        order by fecha DESC
        ";
        $r4= $conexion -> query($sql);
        // echo $sql;
        echo "<h3 style='color: red; font-size:9pt;'>Historia refente a  ".$_GET['info']."</h3>";
        echo "<table class='tabla'>";
        while($f4 = $r4 -> fetch_array()) {
        echo "<tr style='font-size:8pt;'>";
        echo "<td width=30%>";
        echo $f4['Empleado']."<br><label>".$f4['Puesto'].", ".$f4['Dpto']."<br>NITAVU: ".$f4['NEmpleado'];
        echo "</td>";

        echo "<td width=30%>
        Fecha: ".fecha_largA($f4['fecha']).", Hora: ".$f4['hora']."<br>
        <code>".$f4['descripcion']."</code></td>";
        
        echo "</tr>";
        }
        echo "</table>";
        echo "</div>";

    }

    if ( isset($_GET['edit']) and ($_GET['edit']<>'') ){
        echo "<h3 style='margin-top:35px;'><img src='icon/red1.png' style='width:20px;'> Editando ".$_GET['edit']."</h3>";
        $sql = "SELECT * FROM ipinterface WHERE ipcliente='".$_GET['edit']."'";
        $rc= $conexion -> query($sql);        
        if($fip = $rc -> fetch_array())
        {
            echo "<br><form action='ipinfo.php' method='post' class='Ventana' style='width:97%;'>";
            
            // echo "<div><label>Seleccione una IP:</label><select name='ip' id='ip' onmouseout=histosen();>";
            // $sql="select DISTINCT ipcliente from sessiones where ipcliente<>''";
            // $r2= $conexion -> query($sql);
            // // echo $sql;
            // while($ips = $r2 -> fetch_array()) {
            //     echo "<option value='".$ips['ipcliente']."'>".$ips['ipcliente']."</option>";
            // }
            // echo "</select></div>";

            echo "<input type='hidden' value='".$_GET['edit']."' name='ip' id='ip' >";

            echo "<div>";            
            echo "<label>Empleado Asignado:</label><select name='empleado' id='empleado'>";
            $sql="select * from empleados where estado='' order by nombre";
            $r3= $conexion -> query($sql);
            // echo $sql;
            
            while($f2 = $r3 -> fetch_array()) {
                if ($fip['username']== $f2['nitavu']){
                    echo "<option value='".$f2['nitavu']."' selected>".$f2['nombre']."</option>";
                }
                echo "<option value='".$f2['nitavu']."'>".$f2['nombre']."</option>";
            }
            echo "</select></div>";
            
            echo "<div style='background-color:#DFDFD0; color: #8A8A7B; font-size:9pt;'>Network:<br>"  ;      
            echo "<div><label>macaddress:</label><input type='text' value='".$fip['macaddress']."' name='macaddress' id='macaddress'></div>";
            echo "<div><label>ipgateway:</label><input type='text' value='".$fip['ipgateway']."' name='ipgateway' id='ipgateway'></div>";
            echo "<div><label>ipmask:</label><input type='text'  value='".$fip['ipmask']."' name='ipmask' id='ipmask'></div>";
            echo "</div>";
            
            echo "<hr><div><label>PCNAME:</label><input type='text' value='".$fip['pc_name']."' name='pc_name' id='pc_name'></div>";
            echo "<div><label>Marca del Equipo:</label><input type='text' value='".$fip['pc_marca']."' name='pc_marca' id='pc_marca'></div>";            

            echo "<div><label>Modelo del Equipo:</label><input type='text' value='".$fip['pc_modelo']."' name='pc_modelo' id='pc_modelo'></div>";
            echo "<div><label>Memoria (Gb):</label><input type='number' name='pc_memoria' value='".$fip['pc_memoria']."' id='pc_memoria'></div>";
            echo "<div><label>Disco Duro (Gb):</label><input type='number' name='pc_hd' id='pc_hd' value='".$fip['pc_hd']."' ></div>";
            echo "<div><label>Descripcion:</label><input type='text' name='pc_descripcion' id='pc_descripcion' value='".$fip['pc_descripcion']."'></div>";
            echo "<div><label>Serie:</label><input type='text' name='pc_serie' id='pc_serie' value='".$fip['pc_serie']."'></div>";
            echo "<div><label>No. de Inventario:</label><input type='text' name='pc_inventario' id='pc_inventario' value='".$fip['pc_inventario']."'></div>";
            
            echo "<hr><span><label>Comentarios:</label><textarea style='height:100px;' type='text' name='comentarios' id='comentarios'>".$fip['comentarios']."</textarea></span>";
            
            
            
            echo "<div><input type='submit' class='btn btn-default' value='Guardar' name='ip_edit'></div>";
            
            echo "<div><a href='?delete=".$fip['ipcliente']."' class='btn btn-cancel'> <img src='icon/papelera.png' style='width:20px;'></a></div>";
            

            echo "</form>";
        }
    }


    if (isset($_GET['ip']) and ($_GET['ip']=='')  ){        
            //IP nueva (solamente que las que la plataforma haya detectado)
            echo "<br><form action='ipinfo.php' method='post' class='Ventana' style='width:97%;'>";
            echo "<h3>Agregar una nueva IP</h3>";
        
            echo "<div><label>Seleccione una IP: <a href='?ip=&ipwrite='><img title='Haz clic aqui para escribir el IP que requieras' src='icon/alerta3.png' style='width:15px;'></a></label>";
            if (isset($_GET['ipwrite'])){
                echo "<input type='text' name='ip' id='ip'  placeholder='Escriba el ip con puntos' value=''>";

            } else {            
                echo "<select name='ip' id='ip' onmouseout=histosen();>";
                $sql="select DISTINCT ipcliente from sessiones where ipcliente<>''";
                $r2= $conexion -> query($sql);
                // echo $sql;
                while($ips = $r2 -> fetch_array()) {
                    echo "<option value='".$ips['ipcliente']."'>".$ips['ipcliente']."</option>";
                }
             
            }
            echo "</select></div>";


            echo "<div><label>Empleado Asignado:</label><select name='empleado' id='empleado'>";
            $sql="select * from empleados where estado='' order by nombre";
            $r3= $conexion -> query($sql);
            // echo $sql;
            while($f2 = $r3 -> fetch_array()) {
                echo "<option value='".$f2['nitavu']."'>".$f2['nombre']."</option>";
            }
            echo "</select></div>";
            
            echo "<div id='histosen' style='background-color:#DEE4CB; overflow:auto; width:97%; height:200px;'>"; //historial de ip
           
            echo "</div>";
            
            echo "<div style='background-color:#DFDFD0; color: #8A8A7B; font-size:9pt; width:97%;'>Network:<br>"  ;      
            echo "<div style='width:30%;'><label>macaddress:</label><input type='text' name='macaddress' id='macaddress'></div>";
            echo "<div style='width:30%;'><label>ipgateway:</label><input type='text' name='ipgateway' id='ipgateway'></div>";
            echo "<div style='width:30%;'><label>ipmask:</label><input type='text' name='ipmask' id='ipmask'></div>";
            echo "</div>";
            
            echo "<hr><div><label>PCNAME:</label><input type='text' name='pc_name' id='pc_name'></div>";
            echo "<div><label>Marca del Equipo:</label><input type='text' name='pc_marca' id='pc_marca'></div>";            

            echo "<div><label>Modelo del Equipo:</label><input type='text' name='pc_modelo' id='pc_modelo'></div>";
            echo "<div><label>Memoria (Gb):</label><input type='number' name='pc_memoria' id='pc_memoria'></div>";
            echo "<div><label>Disco Duro (Gb):</label><input type='number' name='pc_hd' id='pc_hd'></div>";
            echo "<div><label>Descripcion:</label><input type='text' name='pc_descripcion' id='pc_descripcion'></div>";
            echo "<div><label>Serie:</label><input type='text' name='pc_serie' id='pc_serie'></div>";
            echo "<div><label>No. de Inventario:</label><input type='text' name='pc_inventario' id='pc_inventario'></div>";
            
            echo "<hr><span><label>Comentarios:</label><textarea style='height:100px;' type='text' name='comentarios' id='comentarios'></textarea></span>";
            
            
            
            echo "<div><input type='submit' class='btn btn-default' value='Guardar' name='ip_save'></div>";
            
            echo "<div><a href='?=' class='btn btn-secundario'> Ver lista de IPS</a></div>";
            

            echo "</form>";




    }
    

    
    if (!isset($_GET['ip']) and !isset($_GET['edit']) and !isset($_GET['info']) )
    {
    echo "<hr><a href='?ip=' class='btn-g'><img src='icon/mas2.png' ></a>";
    $sql='select 
    username as Nusername,
    (select nombre from empleados where nitavu=Nusername) as Empleado,

    ipinterface.* from ipinterface order by ipcliente';
    $rx= $conexion -> query($sql);
    echo "<h3>Lista de IP autorizadas para acceso </h3>";
    echo "<table class='tabla'><th>IP</th><th>pcname</th><th>Usuario</th><th></th>";
    while($fx = $rx -> fetch_array()) {
        echo "<tr>";
        echo "<td>".$fx['ipcliente']."</td>";
        echo "<td>".$fx['pc_name']."</td>";
        echo "<td>".$fx['Empleado']." (".$fx['username'].")</td>";
        echo "<td width=150px>";
        //botones
        echo "<a href='?edit=".$fx['ipcliente']."' class='btn btn-default'><img src='icon/pluma.png' style='width:20px; '></a> ";
        echo "<a href='?info=".$fx['ipcliente']."' class='btn btn-default'><img src='icon/ojo.png' style='width:20px; height:20px; '></a> ";
        // echo "<a href='?stop=".$fx['ipcliente']."' class='btn btn-cancel'><img src='icon/stop.png' style='width:20px;'></a>";

        echo "</td>";
        echo "</tr>";
    }
    echo "</table>";
    }




}else{mensaje("ERROR: Sin autorizacion para esta aplicacion",'./index.php?home=');}

?>

<?php include ("./unica/body_footer.php"); ?>