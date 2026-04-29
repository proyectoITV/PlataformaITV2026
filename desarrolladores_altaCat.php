<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); 
require_once("config.php");

?>
<?php
$id_aplicacion ="ap117"; //tabla aplicaciones
$nivel = aplicacion_nivel($id_aplicacion, $nitavu); //tabla aplicaciones permisos

//Niveles
// 1 = Crear y Editar
// 2 = Consulta

//Ajusta esta variable para ver el comportamiento
//$nivel=1;

echo "<script>$('body').css('background-color','rgb(108, 116, 119)');</script>";
// echo "<script>$('body').css('background-size','150%');</script>";

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
    echo "<script>$('#AppDetalle').css('background-color','rgba(2, 2, 2, 0.41)');</script>";    
    // viaticosMenu();
    
    if (isset($_GET['id'])){
        $IdDesarrollador = VarClean($_GET['id']);
        $VInfo = Desarrollador_Info($IdDesarrollador);
        echo "<div style='
        background: rgb(33,116,166);
        background: linear-gradient(180deg, rgba(33,116,166,1) 0%, rgba(33,116,166,1) 14%, rgba(108,116,119,1) 71%); 
        margin-top:-8px;
        padding:10px;
        
        '
     
        >";
            echo "<table width=100%>";
            echo "<tr>";
            echo "<td style='text-align-last: left';><h3 style='color:white;'>Clave de Desarrollador: ".$IdDesarrollador."</h3></td>";
            echo "<td align=right>";
            echo "<a  class='btn btn-primary' href='?='>Regresar</a>";
            echo "</td>";
            echo "</tr>";
            echo "</table>";
        echo "</div>";

        echo "<div id='Form' class='container' style='background-color: #fff;
        border-radius: 5px;
        padding: 15px;
        margin-top:20px;
        '>";
        
        $sql="Select * from catdesarrolladores where IdDesarrollador=".$IdDesarrollador;
        
        //echo $sql;
        $rc= $Vivienda -> query($sql);
        if($f = $rc -> fetch_array())
            {
                $NomDesarrollador=$f['Nombre'];
                echo "<table width=100%><tr>";
               
                echo "<form method='POST' enctype='multipart/form-data' id='VForm'>";
               
                 echo "</form>";                               

                echo "<td valign=top >";
                FormElement_input("R.F.C ",$f['RFC'],"", "","text","VRFC",TRUE);
                FormElement_input("CURP ",$f['CURP'],"", "","text","VCURP",TRUE);
                FormElement_input("Teléfono ",$f['Telefono'],"Telefono para localizar", "","text","VTelefono",TRUE);
                echo "</td></tr>";

                echo "<tr><td>";    
                text_largo('VNombre','Desarrollador','Nombre del Desarrollador','text',$f['Nombre'],'','True');
                text_largo('VRepresentante','Representante Legal','Sin Representante Legal Registrado','text',$f['Representante_Legal'],'','True');
                text_largo('VDomicilio','Domicilio Fiscal','Sin domicilio registrado','text',$f['DomicilioFiscal'],'','True');
                echo "</td></tr>";

                echo "<tr><td>";    
                text_largo('VContacto','Nombre del contato en empresa','Sin contacto registrado','text',$f['Contacto_empresa'],'','True');
                FormElement_input("Correo Electronico",$f['CorreoElectronico'],"", "","text","VCorreo",TRUE);
                FormElement_input("Teléfono de Contacto",$f['TelContacto'],"Sin telefono de contacto", "","text","VTelContacto",TRUE);
                echo "</td></tr>";
                echo "<tr><td>";  
               
               echo "</td></tr>";
               echo "</td></tr></table>";

                echo "<div id='Botones' style='text-align:center;'>";
                echo "<button class='btn btn-success' onclick='VEditar();' style='margin:10px;'>Editar</button>";
                echo "<button class='btn btn-success' onclick='VGuardar();' style='margin:10px;'>Guardar</button>";
               // echo "<button class='btn btn-danger' onclick='VEliminar();' style='margin:10px;'>Eliminar</button>";
                
                echo "</div>";
                
            }
        else {return FALSE;}
        //unset($rc,$f);
        echo "</div>";


                
       /*  if (isset($_GET['newb'])){

            echo "<div id='Form' class='container' style='background-color: #fafbde;
            border-radius: 5px;
            padding: 15px;
            margin-top:20px;
            '>";
            
            echo "<h3 style='
                font-size: 10pt;
                color: black;
                '>Bitacora <b>Nueva Bitacoraaaa para '.$VInfo.'</b></h3>";
                echo "<form method='POST' enctype='multipart/form-data' id='VFormB'>";
            
            FormElement_input("Fecha de Solicitud",$fecha,"", "","text","Fecha_solicitud");
            FormElement_input("Fecha de ejecucion",$fecha,"", "","date","Fecha_ejecucion");
            FormElement_input("Km_prog","","", "","text","Km_prog");
            FormElement_input("Km_real","","", "","text","Km_real");
            FormElement_input("Num. de solicitud","","", "","text","num_solicitud");
            FormElement_input("Num. de Factura","","", "","text","num_factura");
            FormElement_input("Km_real","","", "","number","Km_real");
            FormElement_input("Costo de mano de obra","","", "","number","Costo_mano_obra");
            FormElement_input("Costo de refaccion","","", "","number","Costo_refaccion");            
           
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

            echo "<button class='btn btn-success' onclick='GuardarBit();'><img src='icon/aprobados.png' style='width:20px; margin-right:10px;'>Guardar Bitacora</button>";
            echo "</div>";

            echo "</div>";

            
        }
 */


        echo "<div id='Form' class='container' style='background-color: #fff;
        border-radius: 5px;
        padding: 15px;
        margin-top:20px;
        '>";
        
        echo "<h3>Convenios del Desarrollador: ".$f['Nombre']." </h3>";
        //<img src='icon/loading.png' style='width:18px; cursor:pointer;' onclick='VBReload();'>
        unset($rc,$f);
        echo "<div id='RBitacoras'>";
        echo "</div>";
        echo "</div>";
    } else {

        if (isset($_GET['new'])){
            //Form para Nuevo
            echo "<div style='
            background: rgb(33,116,166);
            background: linear-gradient(180deg, rgba(33,116,166,1) 0%, rgba(33,116,166,1) 14%, rgba(108,116,119,1) 71%); 
            margin-top:-8px;
            padding:10px;
            
            '
         
            >";
                echo "<table width=100%>";
                echo "<tr>";
                echo "<td align=center><h3 style='color:white;'></h3></td>";
                echo "<td align=right>";
                echo "<a  class='btn btn-primary' href='?='>Regresar</a>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
            echo "</div>";
            
        echo "<div id='Form' class='container' style='background-color: #fff;
        border-radius: 5px;
        padding: 15px;
        margin-top:20px;
        '>
        <h3>NUEVO DESARROLLADOR</h3>
        ";


        echo "<table width=100%><tr><td width=40% valign=top>";
        echo "<form method='POST' enctype='multipart/form-data' id='VForm'>";
        
        echo "</form>";
        echo "</td></tr>";
        echo "<td valign=top >";
        FormElement_input("R.F.C ","","", "","text","VRFC");
        FormElement_input("CURP ","","", "","text","VCURP");
        FormElement_input("Teléfono ","","Telefono Empresa", "","text","VTelefono");
        echo "</td></tr>";

        echo "<tr><td>";    
        text_largo('VNombre','Desarrollador','Nombre del Desarrollador','text',"","",'FALSE');
        text_largo('VRepresentante','Representante Legal','','text','','','FALSE');
        text_largo('VDomicilio','Domicilio Fiscal','','text','','','FALSE');
        echo "</td></tr>";
       

        echo "<tr><td>";    
        text_largo('VContacto','Nombre del contato en empresa','','text','','','FALSE');
        FormElement_input("Correo Electronico","","", "","text","VCorreo");
        FormElement_input("Teléfono de Contacto","","", "","text","VTelContacto");
        echo "</td></tr>";
        echo "<tr><td>";  
       
       echo "</td></tr>";
       echo "</td></tr></table>";
        

        echo "<div id='Botones' style='text-align:center;'>";
        echo "<button class='btn btn-success' onclick='VGuardarNuevo();' style='margin:10px;'>Guardar</button>";
        
        
        echo "</div>";
        
        echo "</div>";
        } else {
            //lista de desarrolladores
            echo "<div style='
            background: rgb(33,116,166);
            background: linear-gradient(180deg, rgba(33,116,166,1) 0%, rgba(33,116,166,1) 14%, rgba(108,116,119,1) 71%); 
            margin-top:-8px;
            padding:10px;
            
            '>";
                echo "<table width=100%>";
                echo "<tr>";
                echo "<td align=center><h3 style='color:white;'></h3></td>";
                echo "<td align=right>";
                echo "<a  class='btn btn-primary' href='?new='>Nuevo</a>";
                echo "</td>";
                echo "</tr>";
                echo "</table>";
            
            echo "</div>";

            echo "<div id='Resultado' class='container' style='background-color: #fff;
            border-radius: 5px;
            padding: 15px;
            margin-top:20px;
            '></div>";
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
                url: "desarrolladores_dat_buscar.php",
            type: "post",        
            data: {search:search},
            success: function(data){                
                $("#Resultado").html(data+"");                    
                $('#progressbar').hide();
            }
            });

            
}

function VBReload(){		            
    IdDesarrollador = "<?php if (isset($IdDesarrollador)) {echo $IdDesarrollador; } else {}?>";        
    NomDesarrollador = "<?php if (isset($IdDesarrollador)) {echo  $NomDesarrollador;} else {}?>";        
        
        $('#progressbar').show();
            $.ajax({
                url: "desarrolladores_dat_convenios_buscar.php",
            type: "post",        
            data: {IdDesarrollador:IdDesarrollador, NomDesarrollador:NomDesarrollador},
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

function VEditar(){
    //alert('editar');
        //IdVehiculo = "
         //if (isset($id)) {echo $id;} else {}?>";  
         IdDesarrollador = "<?php if (isset($IdDesarrollador)) {echo $IdDesarrollador;} else {}?>";  
         $('#VNombre').prop('disabled', false);
         $('#VRepresentante').prop('disabled', false);
         $('#VCURP').removeAttr("readonly");
         $('#VRFC').removeAttr("readonly");
         //$('#VRFC').prop('disabled', false);
         $('#VTelefono').prop('disabled', false);
         $('#VDomicilio').prop('disabled', false);
         $('#VContacto').prop('disabled', false);
         $('#VCorreo').removeAttr("readonly");
         $('#VTelContacto').removeAttr("readonly");
         
        //VTipo = $('#VTipo').val();
        
        //VIdPropietario = $('#VIdPropietario').val();
}
function VGuardar(){
    IdDesarrollador = "<?php if (isset($IdDesarrollador)) {echo $IdDesarrollador;} else {}?>";
        //alert ('desarrollador'+IdDesarrollador);
        //IdVehiculo = "
        //</?php if (isset($IdVehiculo)) {echo $IdVehiculo;} else {}?>";  
         VIdDesarrollador=IdDesarrollador;
         VNombre=$('#VNombre').val();
         //alert('nombre '+VNombre);
         VRepresentante=$('#VRepresentante').val();
         VCURP=$('#VCURP').val();
        // alert(VCURP);
         VRFC=$('#VRFC').val();
         VTelefono=$('#VTelefono').val();
         VDomicilio=$('#VDomicilio').val();
         VContacto=$('#VContacto').val();
         VCorreo=$('#VCorreo').val();
         VTelContacto=$('#VTelContacto').val();

        
        //VIdPropietario = $('#VIdPropietario').val();

    $('#VFile').html($('#VFile').val());        
    var formData = new FormData(document.getElementById('VForm'));      
    //var formData = new FormData(VForm);      
        formData.append('VIdDesarrollador',  VIdDesarrollador);
        formData.append('VNombre',  VNombre);
        formData.append('VRepresentante',VRepresentante);
        formData.append('VCURP',VCURP);
        formData.append('VRFC',VRFC);
        formData.append('VTelefono', VTelefono);
        formData.append('VDomicilio', VDomicilio);
        formData.append('VContacto',  VContacto);
        formData.append('VCorreo', VCorreo);
        formData.append('VTelContacto', VTelContacto);       
       //alert('baje');
       // formData.append('VIdPropietario', VIdPropietario);

$('#progressbar').show();
$.ajax({
    url: 'desarrolladores_dat_guardar.php',
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
        alert('aquinuevo');
        //VIdDesarrollador=IdNuevo('CatDesarrolladores','IdDesarrollador');
        alert('nuevo 69');
         VNombre=$('#VNombre').val();
         alert('nombre '+VNombre);
         VRepresentante=$('#VRepresentante').val();
         VCURP=$('#VCURP').val();         
         VRFC=$('#VRFC').val();
         VTelefono=$('#VTelefono').val();
         VDomicilio=$('#VDomicilio').val();
         VContacto=$('#VContacto').val();
         VCorreo=$('#VCorreo').val();
         VTelContacto=$('#VTelContacto').val();
       

    $('#VFile').html($('#VFile').val());     
    var formData = new FormData(document.getElementById('VForm'));      
        formData.append('VNombre',  VNombre);
        formData.append('VRepresentante',VRepresentante);
        formData.append('VCURP',VCURP);
        formData.append('VRFC',VRFC);
        formData.append('VTelefono', VTelefono);
        formData.append('VDomicilio', VDomicilio);
        formData.append('VContacto',  VContacto);
        formData.append('VCorreo', VCorreo);
        formData.append('VTelContacto', VTelContacto);   
    
$('#progressbar').show();
$.ajax({
    url: 'desarrolladores_dat_guardar_nuevo.php',
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