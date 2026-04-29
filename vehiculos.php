
<link href="css/style.css" rel="stylesheet">
<link href="css/slick.css" rel="stylesheet">
<link href="css/responsive.css" rel="stylesheet">
<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); 
require_once("config.php");
require("vehiculos_fun.php");
?>

<?php
$id_aplicacion ="apVeh"; //tabla aplicaciones
$nivel = aplicacion_nivel($id_aplicacion, $nitavu); //tabla aplicaciones permisos
//Niveles
// 1 = Crear y Editar
// 2 = Consulta

//Ajusta esta variable para ver el comportamiento

echo "<script>$('body').css('background-color','rgb(108, 116, 119)');</script>";
// echo "<script>$('body').css('background-size','150%');</script>";

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
    echo "<script>$('#AppDetalle').css('background-color','rgba(2, 2, 2, 0.41)');</script>";    
    // viaticosMenu();
    
    if (isset($_GET['id'])){
        $IdVehiculo = VarClean($_GET['id']);
        $VInfo = Vehiculo_Info($IdVehiculo);
        echo "<div style='
        margin-top:-8px;
        padding:10px;
        '
        >";
            echo "<table width=100%>";
            echo "<tr>";
            echo "<td align=center><h3 style='color:white;'>".$IdVehiculo."</h3></td>";
            echo "<td align=right>";
            echo "<a  class='btn btn-danger' href='?='>Regresar</a>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
        echo "</div>";

        echo "<div id='Form' class='container' style='background-color: #fff;
        border-radius: 5px;
        padding: 15px;
        margin-top:20px;
        '>";
        
        

        $sql="select 

        v.Num_economico as NEconomico,
        v.Serie as Serie,
        (select cat_marcasvehiculos.Marca from cat_marcasvehiculos where Clave_Marca = v.Clave_Marca) as Marca,
        v.Tipo,
        (select cat_colores.Color from cat_colores where cat_colores.Clave_Color = v.Clave_Color) as Color,
        v.Placas,
        v.Clave_Marca,
        v.Clave_Color,
        v.IdEstatus,
        v.Comentario,
        v.Modelo,
        v.Cilindros,
        (
            SELECT
                cat_unidadesresponsables.IdResponsable 
            FROM
                vehiculos_periododeuso INNER JOIN cat_unidadesresponsables 
                ON  vehiculos_periododeuso.IdResponsable = cat_unidadesresponsables.IdResponsable 
            WHERE
                vehiculos_periododeuso.Num_economico =v.Num_economico 
                AND vehiculos_periododeuso.Num_economico= v.Num_economico 
                AND vehiculos_periododeuso.Cancelado = 0 
            ) AS IdResponsable ,

            v.IdPropietario
        
        from vehiculos  v where Num_economico='$IdVehiculo'";
        //echo $sql;
        $rc= $conexion -> query($sql);
        if($f = $rc -> fetch_array())
            {

                echo "<table width=100%><tr><td width=40% valign=top>";
                echo "<form method='POST' enctype='multipart/form-data' id='VForm'>";
                echo '
                
                <div class="form-group" id="FotoVehiculo" style="margin: 4px;
                padding: 4px;
                border-radius: 5px;
                background-color:#d9dadb;
                width:100%;
                vertical-align: top;">';
                $archivo = 'fotos_vehiculos/'.$IdVehiculo.'.jpg';
                if (file_exists($archivo)){
                    echo '<img name="foto" id="foto" src="'.$archivo.'" style="width:100%; border-radius:10px;">';
                } else {
                    echo '<img name="foto" id="foto" src="icon/vnofoto.png" style="width:100%; border-radius:10px;">';
                }


                echo '
                    <label for="VFile" style="font-size:8pt;">Fotografia:</label>
                    ';    
                        echo "<input type='file' id='VFile' name='VFile' class='form-control' style='font-size:9pt; margin-top:-7px;' accept='.jpg'>";
                echo "</div>";
                echo "</form>";
                

                echo "</td>";

                echo "<td valign=top >";
                FormElement_input("Serie ",$f['Serie'],"", "","text","VSerie");
                FormElement_input("Tipo ",$f['Tipo'],"", "","text","VTipo");
                FormElement_input("Placas ",$f['Placas'],"", "","text","VPlacas");

                FormElement_input("Cilindraje ",$f['Cilindros'],"Cantidad de Cilindros", "","number","VCilindros");
                
                echo '
                <div class="form-group" id="DivValoracion" style="margin: 4px;
                padding: 4px;
                border-radius: 5px;
                vertical-align: top;">';
    
                echo '
                    <label for="CreditoValoracion" style="font-size:8pt;">Marca</label>
                    ';
    
                echo "<select id='VMarca' class='form-control' style='font-size:9pt; margin-top:-7px;'>";
                
                $rx= $conexion -> query("select * from cat_marcasvehiculos ");                
                while($fx = $rx -> fetch_array()) {
                    if ($f['Clave_Marca']==$fx['Clave_Marca']){
                        echo "<option value='".$fx['Clave_Marca']."' selected>".$fx['Marca']."</option>";
                    } else {
                        echo "<option value='".$fx['Clave_Marca']."'>".$fx['Marca']."</option>";
                    }
                    
                }
                unset($rx, $fx);
                echo "</select>";
                echo '<small class="form-text text-muted" style="font-size: 7pt;
                margin-top: -2px;">Si no esta en la lista, comunicarse al Dpto. de Informatica</small>';
                echo "</div>";


                echo '
                <div class="form-group" id="DivValoracion2" style="margin: 4px;
                padding: 4px;
                border-radius: 5px;
                vertical-align: top;">';
    
                echo '
                    <label for="CreditoValoracion" style="font-size:8pt;">Color</label>
                    ';
    
                echo "<select id='VColor' class='form-control' style='font-size:9pt; margin-top:-7px;'>";
                
                $rx= $conexion -> query("select * from cat_colores ");                
                while($fx = $rx -> fetch_array()) {
                    if ($f['Clave_Color']==$fx['Clave_Color']){
                        echo "<option value='".$fx['Clave_Color']."' selected>".$fx['Color']."</option>";
                    } else {
                        echo "<option value='".$fx['Clave_Color']."'>".$fx['Color']."</option>";
                    }
                    
                }
                unset($rx, $fx);
                echo "</select>";
                echo '<small class="form-text text-muted" style="font-size: 7pt;
                margin-top: -2px;">Si no esta en la lista, comunicarse al Dpto. de Informatica</small>';
                echo "</div>";

                FormElement_textarea("Comentario",$f['Comentario'],"", "","text","VComentario");
                FormElement_input("Modelo",$f['Modelo'],"Año del vehiculo", "","number","VModelo");


                echo '
                <div class="form-group" id="DivValoracion3" style="margin: 4px;
                padding: 4px;
                border-radius: 5px;
                vertical-align: top;">';
    
                echo '
                    <label for="VEstatus" style="font-size:8pt;">Estado actual:</label>
                    ';
    
                echo "<select id='VEstatus' class='form-control' style='font-size:9pt; margin-top:-7px;'>";
                
                $rx= $conexion -> query("select * from cat_vehiculoestatus");                
                while($fx = $rx -> fetch_array()) {
                    if ($f['IdEstatus']==$fx['IdEstatus']){
                        echo "<option value='".$fx['IdEstatus']."' selected>".$fx['Estatus']."</option>";
                    } else {
                        echo "<option value='".$fx['IdEstatus']."' >".$fx['Estatus']."</option>";
                    }
                    
                }
                unset($rx, $fx);
                echo "</select>";

                echo "</div>";

                echo '
                <div class="form-group" id="DivAdscripcion" style="margin: 4px;
                padding: 4px;
                border-radius: 5px;
                vertical-align: top;">';
    
                echo '
                    <label for="VAdscripcion" style="font-size:8pt;">Adscripción:</label>
                    ';
    
                echo "<select id='VAdscripcion' class='form-control' style='font-size:9pt; margin-top:-7px;'>";
                
                $rx= $conexion -> query("select * from cat_unidadesresponsables");                
                while($fx = $rx -> fetch_array()) {
                    if ($f['IdResponsable']==$fx['IdResponsable']){
                        echo "<option value='".$fx['IdResponsable']."' selected>".$fx['Responsable']."</option>";
                    } else {
                        echo "<option value='".$fx['IdResponsable']."' >".$fx['Responsable']."</option>";
                    }
                    
                }
                unset($rx, $fx);
                echo "</select>";

                echo "</div>";
                echo '
                <div class="form-group" id="DivValoracion4" style="margin: 4px;
                padding: 4px;
                border-radius: 5px;
                vertical-align: top;">';
    
                echo '
                    <label for="VIdPropietario" style="font-size:8pt;">Propietario:</label>
                    ';
    
                echo "<select id='VIdPropietario' class='form-control' style='font-size:9pt; margin-top:-7px;'>";
                
                $rx= $conexion -> query("select * from cat_vehiculopropietario");                
                while($fx = $rx -> fetch_array()) {
                    if ($f['IdPropietario']==$fx['IdPropietario']){
                        echo "<option value='".$fx['IdPropietario']."' selected>".$fx['Propietario']."</option>";
                    } else {
                        echo "<option value='".$fx['IdPropietario']."' >".$fx['Propietario']."</option>";
                    }
                    
                }
                unset($rx, $fx);
                echo "</select>";

                echo "</div>";

                echo "</td></tr></table>";

                echo "<div id='Botones' style='text-align:center;'>";
                echo "<button class='btn btn-danger' onclick='VGuardar();' style='margin:10px;'>Guardar</button>";
                echo "<button class='btn btn-danger' onclick='VEliminar();' style='margin:10px;'>Eliminar</button>";
                
                echo "</div>";
                
            }
        else {return FALSE;}
        unset($rc,$f);
        echo "</div>";


                
        if (isset($_GET['newb'])){

            echo "<div id='Form' class='container' style='background-color: #fafbde;
            border-radius: 5px;
            padding: 15px;
            margin-top:20px;
            '>";
            
            echo "<h3 style='
                font-size: 10pt;
                color: black;
                '>Bitacora <b>Nueva Bitacora para '.$VInfo.'</b></h3>";
                echo "<form method='POST' enctype='multipart/form-data' id='VFormB'>";
            
            // FormElement_input("Clave de Servicio ","","", "","text","Clave_servicio", TRUE);
            // FormElement_input("Fecha de Solicitud",$fecha,"", "","text","Fecha_solicitud",TRUE);
            FormElement_input("Fecha de Solicitud",$fecha,"", "","date","Fecha_solicitud");
            FormElement_input("Fecha de ejecucion",$fecha,"", "","date","Fecha_ejecucion");
            FormElement_input("Km_prog","","", "","text","Km_prog");
            FormElement_input("Km_real","","", "","text","Km_real");
            FormElement_input("Num. de solicitud","","", "","text","num_solicitud");
            FormElement_input("Num. de Factura","","", "","text","num_factura");
           // FormElement_input("Km_real","","", "","number","Km_real");
            FormElement_input("Costo de mano de obra","","", "","number","Costo_mano_obra");
            FormElement_input("Costo de refaccion","","", "","number","Costo_refaccion");
            FormElement_input("Importe factura","","", "","number","Importe_factura");
            // FormElement_input("TipoServicio",$f2['TipoServicio'],"", "","text","clave_tipo_mant", TRUE);
            echo '
            <div class="form-group" id="DivTipoServicio" style="margin: 4px;
            padding: 4px;
            border-radius: 5px;
            vertical-align: top;">';
            echo '<label for="clave_tipo_mant" style="font-size:8pt;">Tipo de Servicio</label>';
            echo "<select id='clave_tipo_mant' class='form-control' style='font-size:9pt; margin-top:-7px;'>";
            $rx= $conexion -> query("select * from cat_tiposdemantenimiento");                
            while($fx = $rx -> fetch_array()) {    
                    echo "<option value='".$fx['clave_tipo_mant']."' selected>".$fx['Tipo_Mantenimiento']."</option>";
            }
                
            
            unset($rx, $fx);
            echo "</select>";
            echo '<small class="form-text text-muted" style="font-size: 7pt;
            margin-top: -2px;"></small>';
            echo "</div>";
            
            
            
            // FormElement_input("Proveedor",$f2['Proveedor'],"", "","text","clave_proveedor", TRUE);
            echo '
            <div class="form-group" id="DivProveedor" style="margin: 4px;
            padding: 4px;
            border-radius: 5px;
            vertical-align: top;">';
            echo '<label for="clave_proveedor" style="font-size:8pt;">Proveedor</label>';
            echo "<select id='clave_proveedor' class='form-control' style='font-size:9pt; margin-top:-7px;'>";
            $rx= $conexion -> query("select * from cat_proveedoresvehiculos");                
            while($fx = $rx -> fetch_array()) {    
                    echo "<option value='".$fx['clave_proveedor']."' selected>".$fx['Nombre_proveedor']."</option>";
            }
            unset($rx, $fx);
            echo "</select>";
            echo '<small class="form-text text-muted" style="font-size: 7pt;
            margin-top: -2px;"></small>';
            echo "</div>";
            
            
            FormElement_textarea("Descripcion","","", "","text","Descripcion");
            
            echo '
            <div class="form-group" id="DivFiles" style="margin: 4px;
            padding: 4px;
            border-radius: 5px;
            vertical-align: top;">';
            echo '<label for="FileFoto" style="font-size:8pt;">Fotografia</label>';
            echo "<input type='file' id='FileFoto' name='FileFoto' class='form-control' style='font-size:9pt; margin-top:-7px;' Accept='.jpg'>";
            echo '<small class="form-text text-muted" style="font-size: 7pt;
            margin-top: -2px;"></small>';
            echo "</div>";
            
            
            echo '
            <div class="form-group" id="DivFiles2" style="margin: 4px;
            padding: 4px;
            border-radius: 5px;
            vertical-align: top;">';
            echo '<label for="FileDoc" style="font-size:8pt;">Documento (pdf)</label>';
            echo "<input type='file' id='FileDoc' name='FileDoc' class='form-control' style='font-size:9pt; margin-top:-7px;' Accept='.pdf'>";
            echo '<small class="form-text text-muted" style="font-size: 7pt;
            margin-top: -2px;"></small>';
            echo "</div>";
            echo "</form>";
            
            echo '<div class="form-group" id="DivProveedor" style="margin: 4px;
            padding: 4px; width:100%;
            border-radius: 5px; text-align:center;
            vertical-align: top;">';

            echo "<button class='btn btn-danger' onclick='GuardarBit();'><img src='icon/aprobados.png' style='width:20px; margin-right:10px;'>Guardar Bitacora</button>";
            echo "</div>";

            echo "</div>";

            
        }



        echo "<div id='Form' class='container' style='background-color: #fff;
        border-radius: 5px;
        padding: 15px;
        margin-top:20px;
        '>";
        
        echo "<h3>Bitacoras: <img src='icon/loading.png' style='width:18px; cursor:pointer;' onclick='VBReload();'></h3>";

        echo "<div id='RBitacoras'>";
        echo "</div>";
        echo "</div>";
    } else {

        if (isset($_GET['new'])){
            //Form para Nuevo
            echo "<div style='
            margin-top:-8px;
            padding:10px;
            
            '
         
            >";
                echo "<table width=100%>";
                echo "<tr>";
                echo "<td align=center><h3 style='color:white;'></h3></td>";
                echo "<td align=right>";
                echo "<a  class='btn btn-danger' href='?='>Regresar</a>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
            echo "</div>";
            
        echo "<div id='Form' class='container' style='background-color: #fff;
        border-radius: 5px;
        padding: 15px;
        margin-top:20px;
        '>
        <h3>NUEVO VEHICULO</h3>
        ";


        echo "<table width=100%><tr><td width=40% valign=top>";
        echo "<form method='POST' enctype='multipart/form-data' id='VForm'>";
        echo '
        
        <div class="form-group" id="FotoVehiculo" style="margin: 4px;
        padding: 4px;
        border-radius: 5px;
        background-color:#d9dadb;
        width:100%;
        vertical-align: top;">';
        $archivo = 'fotos_vehiculos/no.jpg';
        if (file_exists($archivo)){
            echo '<img name="foto" id="foto" src="'.$archivo.'" style="width:100%; border-radius:10px;">';
        } else {
            echo '<img name="foto" id="foto" src="icon/vnofoto.png" style="width:100%; border-radius:10px;">';
        }


        echo '
            <label for="VFile" style="font-size:8pt;">Fotografia:</label>
            ';    
                echo "<input type='file' id='VFile' name='VFile' class='form-control' style='font-size:9pt; margin-top:-7px;' accept='.jpg'>";
        echo "</div>";
        echo "</form>";
        

        echo "</td>";

        echo "<td valign=top >";
        FormElement_input("No. Economico ","","", "","text","IdVehiculo");
        FormElement_input("Serie ","","", "","text","VSerie");
        FormElement_input("Tipo ","","", "","text","VTipo");
        FormElement_input("Placas ","","", "","text","VPlacas");
        FormElement_input("Cilindraje ","","Cantidad de Cilindros", "","number","VCilindros");
        echo '
        <div class="form-group" id="DivValoracion" style="margin: 4px;
        padding: 4px;
        border-radius: 5px;
        vertical-align: top;">';

        echo '
            <label for="CreditoValoracion" style="font-size:8pt;">Marca</label>
            ';

        echo "<select id='VMarca' class='form-control' style='font-size:9pt; margin-top:-7px;'>";
        
        $rx= $conexion -> query("select * from cat_marcasvehiculos ");                
        while($fx = $rx -> fetch_array()) {
            
                echo "<option value='".$fx['Clave_Marca']."'>".$fx['Marca']."</option>";
            
            
        }
        unset($rx, $fx);
        echo "</select>";
        echo '<small class="form-text text-muted" style="font-size: 7pt;
        margin-top: -2px;">Si no esta en la lista, comunicarse al Dpto. de Informatica</small>';
        echo "</div>";


        echo '
        <div class="form-group" id="DivValoracion2" style="margin: 4px;
        padding: 4px;
        border-radius: 5px;
        vertical-align: top;">';

        echo '
            <label for="CreditoValoracion" style="font-size:8pt;">Color</label>
            ';

        echo "<select id='VColor' class='form-control' style='font-size:9pt; margin-top:-7px;'>";
        
        $rx= $conexion -> query("select * from cat_colores ");                
        while($fx = $rx -> fetch_array()) {
          
                echo "<option value='".$fx['Clave_Color']."'>".$fx['Color']."</option>";
          
            
        }
        unset($rx, $fx);
        echo "</select>";
        echo '<small class="form-text text-muted" style="font-size: 7pt;
        margin-top: -2px;">Si no esta en la lista, comunicarse al Dpto. de Informatica</small>';
        echo "</div>";

        FormElement_textarea("Comentario","","", "","text","VComentario");
        FormElement_input("Modelo ",$f['Modelo'],"Año del vehiculo", "","number","VModelo");

        echo '
        <div class="form-group" id="DivValoracion23" style="margin: 4px;
        padding: 4px;
        border-radius: 5px;
        vertical-align: top;">';

        echo '
            <label for="VEstatus" style="font-size:8pt;">Estado actual:</label>
            ';

        echo "<select id='VEstatus' class='form-control' style='font-size:9pt; margin-top:-7px;'>";
        
        $rx= $conexion -> query("select * from cat_vehiculoestatus");                
        while($fx = $rx -> fetch_array()) {
          
                echo "<option value='".$fx['IdEstatus']."' >".$fx['Estatus']."</option>";
          
            
        }
        unset($rx, $fx);
        echo "</select>";

        echo "</div>";

        echo '
        <div class="form-group" id="DivAdscripcion" style="margin: 4px;
        padding: 4px;
        border-radius: 5px;
        vertical-align: top;">';

        echo '
            <label for="VAdscripcion" style="font-size:8pt;">Adscripción:</label>
            ';

        echo "<select id='VAdscripcion' class='form-control' style='font-size:9pt; margin-top:-7px;'>";
        
        $rx= $conexion -> query("select * from cat_unidadesresponsables");                
        while($fx = $rx -> fetch_array()) {
            if ($f['IdResponsable']==$fx['IdResponsable']){
                echo "<option value='".$fx['IdResponsable']."' selected>".$fx['Responsable']."</option>";
            } else {
                echo "<option value='".$fx['IdResponsable']."' >".$fx['Responsable']."</option>";
            }
            
        }
        unset($rx, $fx);
        echo "</select>";

        echo "</div>";

        echo '
        <div class="form-group" id="DivValoracion4" style="margin: 4px;
        padding: 4px;
        border-radius: 5px;
        vertical-align: top;">';

        echo '
            <label for="VIdPropietario" style="font-size:8pt;">Propietario:</label>
            ';

        echo "<select id='VIdPropietario' class='form-control' style='font-size:9pt; margin-top:-7px;'>";
        
        $rx= $conexion -> query("select * from cat_vehiculopropietario");                
        while($fx = $rx -> fetch_array()) {
            if ($f['IdPropietario']==$fx['IdPropietario']){
                echo "<option value='".$fx['IdPropietario']."' selected>".$fx['Propietario']."</option>";
            } else {
                echo "<option value='".$fx['IdPropietario']."' >".$fx['Propietario']."</option>";
            }
            
        }
        unset($rx, $fx);
        echo "</select>";

        echo "</div>";
        echo "</td></tr></table>";

        echo "<div id='Botones' style='text-align:center;'>";
        echo "<button class='btn btn-danger' onclick='VGuardarNuevo();' style='margin:10px;'>Guardar</button>";
        
        
        echo "</div>";
        
        echo "</div>";
        } else {
            //lista de vehiculos
            echo "<div style='
            margin-top:-8px;
            padding:10px;
            
            '>";
                echo "<table width=100%>";
                echo "<tr>";
                echo "<td align=center><h3 style='color:white;'></h3></td>";
                echo "<td align=right>";
                echo "<a  class='btn btn-danger' href='?new='>Nuevo</a>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
            
            echo "</div>";

            echo " <center><div style='
            width: 85%; padding-top: 0px; padding-bottom: 13px; margin-top: 7px;'>
            <table width=100%><tr><td width=90%>";
            echo "<input style=' height: 65px; border-radius: 5px; font-size: 18pt; font-family: Light; margin-left: 12px; padding: 10px; margin-right: 20px;
            'type='text' name='search' id='search' placeholder='Ingrese el número de placas, económico, serie o tipo del vehiculo'>";
            echo "</td><td>
            <button type='submit' onclick='VReload();' class='Mbtn btn-danger' id='indicaciones2' style='font-size: 8pt;  height: 60px; margin-top: -3px;
            margin-left: 5px;' > <img src='icon/buscar2.png' style='width:40px;'>
            </button></td></tr></table></td>
            </div>"; 


            echo "<div id='Resultado' class='container' style='background-color: #fff;
            border-radius: 5px;
            padding: 15px;
            margin-top:20px;
            '></div> </center>";
        }
       

    }


    

}
else {MsgBox_Lite("No tiene permiso para ver esta aplicacion",'');}	 


?>

<SCRIPT>

function CancelarBitacora(Clave_servicio){		            
        // search = $('#search').val();
        // console.log($ClaveServicio);
        $('#progressbar').show();
            $.ajax({
                url: "vehiculos_dat_cancelarbit.php",
            type: "post",        
            data: {Clave_servicio:Clave_servicio},
            success: function(data){                
                $("#RV").html(data+"");                    
                $('#progressbar').hide();
            }
            });

            
}

function VReload(){		            
        search = $('#search').val();
        $('#progressbar').show();
            $.ajax({
                url: "vehiculos_dat_buscar.php",
            type: "post",        
            data: {search:search},
            success: function(data){                
                $("#Resultado").html(data+"");                    
                $('#progressbar').hide();
            }
            });

            
}

function VBReload(){		            
    IdVehiculo = "<?php if (isset($IdVehiculo)) {echo $IdVehiculo;} else {}?>";            
        $('#progressbar').show();
            $.ajax({
                url: "vehiculos_dat_bitacoras_buscar.php",
            type: "post",        
            data: {IdVehiculo:IdVehiculo},
            beforeSend:function(){
                $("#RBitacoras").html("<div style='width:100%; padding-left:50%; padding-top:50px;'><img src='img/loader.gif'></div>");                    
            },
            success: function(data){                
                $("#RBitacoras").html(data+"");                    
                $('#progressbar').hide();
            }
            });

            
}

VBReload();
function VEliminar(){		        
        IdVehiculo = "<?php if (isset($IdVehiculo)) {echo $IdVehiculo;} else {}?>";            
        $('#progressbar').show();
            $.ajax({
                url: "vehiculos_dat_eliminar.php",
            type: "post",        
            data: {
                IdVehiculo: IdVehiculo                
            },
            success: function(data){
                
                $("#RV").html(data+"");    
                
                $('#progressbar').hide();
            }
            });

            
}


function VGuardar(){
        IdVehiculo = "<?php if (isset($IdVehiculo)) {echo $IdVehiculo;} else {}?>";    
        VSerie = $('#VSerie').val();
        VTipo = $('#VTipo').val();
        VPlacas = $('#VPlacas').val();
        VMarca = $('#VMarca').val();
        VColor = $('#VColor').val();
        VComentario = $('#VComentario').val();
        VModelo= $('#VModelo').val();
        VEstatus = $('#VEstatus').val();
        VAdscripcion = $('#VAdscripcion').val();
        VCilindros = $('#VCilindros').val();
        VIdPropietario = $('#VIdPropietario').val();

    $('#VFile').html($('#VFile').val());        
    var formData = new FormData(document.getElementById('VForm'));        
        formData.append('IdVehiculo',  IdVehiculo);
        formData.append('VSerie',VSerie);
        formData.append('VTipo',VTipo);
        formData.append('VPlacas',VPlacas);
        formData.append('VMarca', VMarca);
        formData.append('VColor', VColor);
        formData.append('VComentario',  VComentario);
        formData.append('VModelo',  VModelo);
        formData.append('VEstatus', VEstatus);
        formData.append('VAdscripcion', VAdscripcion);       
        formData.append('VCilindros', VCilindros);
        formData.append('VIdPropietario', VIdPropietario);

$('#progressbar').show();
$.ajax({
    url: 'vehiculos_dat_guardar.php',
    type: 'post',
    dataType: 'html',
    data: formData,             
    cache: false,
    contentType: false,
    processData: false,
    beforeSend:function(){
        // console.log('Cargando..');
    },
    success:function(data){
        // console.log(data);
        $('#R').html(data);
        $('#progressbar').hide();
    }
});


}



function VGuardarNuevo(){
        IdVehiculo =   $('#IdVehiculo').val();
        VSerie = $('#VSerie').val();
        VTipo = $('#VTipo').val();
        VPlacas = $('#VPlacas').val();
        VMarca = $('#VMarca').val();
        VColor = $('#VColor').val();
        VComentario = $('#VComentario').val();
        VEstatus = $('#VEstatus').val();
        VAdscripcion = $('#VAdscripcion').val();
        VIdPropietario = $('#VIdPropietario').val();

    $('#VFile').html($('#VFile').val());        
    var formData = new FormData(document.getElementById('VForm'));        
        formData.append('IdVehiculo',  IdVehiculo);
        formData.append('VSerie',VSerie);
        formData.append('VTipo',VTipo);
        formData.append('VPlacas',VPlacas);
        formData.append('VMarca', VMarca);
        formData.append('VColor', VColor);
        formData.append('VComentario',  VComentario);
        formData.append('VEstatus', VEstatus);
        formData.append('VAdscripcion', VAdscripcion);
        formData.append('VIdPropietario', VIdPropietario);

$('#progressbar').show();
$.ajax({
    url: 'vehiculos_dat_guardar_nuevo.php',
    type: 'post',
    dataType: 'html',
    data: formData,             
    cache: false,
    contentType: false,
    processData: false,
    beforeSend:function(){
        // console.log('Cargando..');
    },
    success:function(data){
        // console.log(data);
        $('#RV').html(data);
        $('#progressbar').hide();
    }
});


}

VReload();

function ActualizaFoto(){
    d = new Date();
    
    IdVehiculo = "<?php if (isset($IdVehiculo)) {echo $IdVehiculo.'.jpg';} else { echo "icon/vnofoto.png";}?>";    
    src='fotos_vehiculos/'+IdVehiculo+'?';
    $("#foto").attr("src",src+d.getTime());
}


function GuardarBit(){		            
    IdVehiculo = "<?php if (isset($IdVehiculo)) {echo $IdVehiculo;} else {}?>";            
    VTipo = $('#VTipo').val();
    Clave_servicio = $('#Clave_servicio').val();
    Num_economico = $('#Num_economico').val();
    Fecha_solicitud = $('#Fecha_solicitud').val();
    Fecha_ejecucion = $('#Fecha_ejecucion').val();
    clave_tipo_mant = $('#clave_tipo_mant').val();
    Km_prog = $('#Km_prog').val();
    Km_real = $('#Km_real').val();
    num_solicitud = $('#num_solicitud').val();
    num_factura = $('#num_factura').val();
    clave_proveedor = $('#clave_proveedor').val();
    Descripcion = $('#Descripcion').val();
    Costo_mano_obra = $('#Costo_mano_obra').val();
    Costo_refaccion = $('#Costo_refaccion').val();
    Importe_Factura = $('#Importe_factura').val();

    var formData = new FormData(document.getElementById('VFormB'));        
        formData.append('IdVehiculo',  IdVehiculo);        
        formData.append('Clave_servicio', Clave_servicio);
        formData.append('Num_economico', Num_economico);
        formData.append('Fecha_solicitud', Fecha_solicitud);
        formData.append('Fecha_ejecucion', Fecha_ejecucion);
        formData.append('clave_tipo_mant', clave_tipo_mant);
        formData.append('Km_prog', Km_prog);
        formData.append('Km_real', Km_real);
        formData.append('num_solicitud', num_solicitud);
        formData.append('num_factura', num_factura);
        formData.append('clave_proveedor', clave_proveedor);
        formData.append('Descripcion', Descripcion);
        formData.append('Costo_mano_obra', Costo_mano_obra);
        formData.append('Costo_refaccion', Costo_refaccion);
        formData.append('Importe_factura', Importe_Factura);

        $('#progressbar').show();
            $.ajax({
                url: "vehiculos_dat_savebit.php",    
            type: 'post',
            dataType: 'html',
            data: formData,             
            cache: false,
            contentType: false,
            processData: false,
            beforeSend:function(){
                // $('#progressbar').show();        
            },
            success: function(data){     
                         
                $("#RV").append(data+"");                                    
                $('#progressbar').hide();
            }
            });

            
}

</SCRIPT>


<?php include ("./lib/body_footer.php"); ?>