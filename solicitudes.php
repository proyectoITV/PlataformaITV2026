<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>


<?php
require("config.php");
$id_aplicacion = 'ap101';
xd_update('ap101',$nitavu);//guarda la experiencia del usuario
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){

    echo '<input type="hidden" id="nitavu" name="nitavu" value="'.$nitavu.'">';
   echo "<br><br>";
    echo '<form id="opciones">';
    echo '<label>Busqueda por:</label>
    <label><input type="radio" id="nombre" name="opcion" value="nombre">Nombre
    <input type="radio" id="contrato" name="opcion" value="contrato">Contrato
    <input type="radio" id="folio" name="opcion" value="folio">Folio
    <input type="radio" id="nuevo" name="opcion" value="nuevo">Nuevo
    </label>';
    echo '</form>';
    //buscar por nombre
    echo "<div id='busquedaNombre' style='display:none;'>";
    echo "<form action='solicitudes.php' method='POST'>";
        echo "<div style='width:100%;'>";
            echo "<div>";
            echo "<label for='delegaciones'>Seleccione una delegación:";
            echo "<select name='delegaciones'>";
            
            $sql = "SELECT * FROM delegaciones where Tipo = 0 ORDER by Delegacion ASC";

            //$sql = "SELECT * FROM delegaciones ORDER by Delegacion ASC";
            
                $r = $Vivienda -> query($sql);
                while($f = $r -> fetch_array())
                { // resultado de la busqueda.................
                    echo "<option value='".$f['IdDelegacion']."'>".$f['Delegacion']. "</option>";
                }
            
            echo "</select>";
            echo "</div>";
            echo "<div>";
            echo "<label for='programas'>Seleccione un programa:";
            echo "<select name='programas'>";
            
            //$sql = "SELECT * FROM delegaciones where tipo = 0 ORDER by Delegacion ASC";

                $sql = "SELECT * FROM programa WHERE Activo=1 ORDER by Programa ASC";
                $r = $Vivienda -> query($sql);
                while($f = $r -> fetch_array())
                { // resultado de la busqueda.................
                    echo "<option value='".$f['IdPrograma']."'>".$f['Programa']. "</option>";
                }
            
            echo "</select>";
            echo "</label>";
            echo "</div>";
        echo "</div>";

        echo "<div class='contenedor-tabla'>";
        echo "<div class='contenedor-fila'>";
            echo "<div class='contenedor-columna'>";
                echo "<label>Nombre</label>";
                echo "<input id='nom' name='nom'>";
            echo "</div>";
            echo "<div class='contenedor-columna'>";
                echo "<label>Apellido Paterno</label>";
                echo "<input id='apaterno' name='apaterno'>";
            echo "</div>";
            echo "<div class='contenedor-columna'>";
                echo "<label>Apellido Materno</label>";
                echo "<input id='amaterno' name='amaterno'>";
            echo "</div>";
            echo "<div class='contenedor-columna'>";
               
                echo "<input type='submit' id='buscaNombre' name='buscaNombre' value='Buscar' class='Mbtn btn-default'>";
            echo "</div>";
        echo "</div>";
    echo "</div>";

       
       
        
    echo "</form>";
    echo "</div>";

     //buscar por contrato
    echo "<div id='busquedaContrato' style='display:none;'>";
    echo "<form action='solicitudes.php' method='POST'>";
        echo "<label>Número contrato</label>";
        echo "<input id='numcontrato' name='numcontrato'>";
        echo "<input type='submit' id='buscaContrato' value='Buscar' class='Mbtn btn-default'>";
    echo "</form>";
    echo "</div>";


    //buscar por folio
    echo "<div id='busquedaFolio' style='display:none;'>";
    echo "<form action='solicitudes.php' method='POST'>";
        echo "<label>Folio</label>";
        echo "<input id='numfolio' name='numfolio'>";
        echo "<input type='submit' id='buscaFolio' value='Buscar' class='Mbtn btn-default'>";
    echo "</form>";
    echo "</div>";

    //Nuevo
    echo "<div id='nuevaSolicitud' style='display:none;'>";
    echo "<form action='solicitudes.php' method='POST'>";
        echo "<div style='width:90%;'>";
            echo "<table><tr>";
            echo "<td style='width:40%;'>";
            echo "<div style='width:95%;'>";
            echo "<label for='delegaciones2'>Seleccione una delegación:";
            echo "<select name='delegaciones2' id='delegaciones2'>";
            
            $sql = "SELECT * FROM delegaciones where Tipo = 0 ORDER by Delegacion ASC";

            //$sql = "SELECT * FROM delegaciones ORDER by Delegacion ASC";
            
                $r = $Vivienda -> query($sql);
                while($f = $r -> fetch_array())
                { // resultado de la busqueda.................
                    echo "<option value='".$f['IdDelegacion']."'>".$f['Delegacion']. "</option>";
                }
            
            echo "</select>";
            echo "</div>";
            echo "</td>";
            echo "<td style='width:40%;'>";
            echo "<div style='width:95%;'>";
            echo "<label for='programas2'>Seleccione un programa:";
            echo "<select name='programas2' id='programas2'  onchange='idTipoSolicitud()'>";
            //id='programas'
            $sql = "SELECT * FROM programa WHERE Activo=1 ORDER by Programa ASC";

            //$sql = "SELECT * FROM delegaciones ORDER by Delegacion ASC";
            
                $r = $Vivienda -> query($sql);
                while($f = $r -> fetch_array())
                { // resultado de la busqueda.................
                    echo "<option value='".$f['IdPrograma']."'>".$f['Programa']. "</option>";
                }
            
            echo "</select>";
            echo "</div>";
            echo "</td>";
            echo "<td style='width:20%;'>";
            echo "<div style='width:95%;'>";
            echo "<input type='submit' value='Crear' class='Mbtn btn-default'>";
            echo "</div>";
            echo "</td></tr></table>";
            // echo "<div>";
            // echo "<label for='programas'>Seleccione un programa:";
            // echo "<select id='programas' name='programas' onchange='idTipoSolicitud()'>";
            // //$sql = "SELECT * FROM delegaciones where tipo = 0 ORDER by Delegacion ASC";
            //     $sql = "SELECT * FROM programa ORDER by Programa ASC";
            //     $r = $conexion -> query($sql);
            //     while($f = $r -> fetch_array())
            //     { // resultado de la busqueda.................
            //         echo "<option value='".$f['IdPrograma']."'>".$f['Programa']. "</option>";
            //     }
            
            // echo "</select>";
            // echo "</label>";
            // echo "</div>";
        echo "</div>";

        echo "<div id='Formulario' style ='width:100%;'></div>";
     /*   
        $idTipoSolicitud =  solicitudaCrear();
        $sql2 = 'SELECT * from solicitudeslistareq WHERE IdTipoSolicitud ='.$idTipoSolicitud.'';
        echo $sql2;*/

    echo "</form>";
    echo "</div>";

//CREAR SOLICITUD
if (isset($_POST['programas2']) and isset($_POST['delegaciones2'])){

    $idPrograma = $_POST['programas2'];
    $sql ='select idTipoSolicitud from cat_programa where IdPrograma = '.$idPrograma.'';
    //echo $sql;
    $r= $conexion -> query($sql);
    echo "<div id='SolicitudDeDatos'>";
    echo '<table class=""><tbody><tr style="background-color:white;">
        <td align="center" valign="middle" width="50%" style="background-color:white;"><img src="img/logo_copia.jpg" style="width:70%;"></td><td>
        </td><td valign="middle">    
        <b style="font-weight: bold;
        font-size: 22pt;    
        color: #337db2;"><b style="font-size:18pt;">'.NombrePrograma($idPrograma).'</b><br><label style="font-size:8pt;">'.DescripcionPrograma($idPrograma).'</label><br>
        
        <b style="font-size:12pt; font-color:orange; font-weight:bold;">Folio de Tramite: 241</b>
    </b></td></tr></tbody></table>';
    //<b style="font-size:10pt;">'.DescripcionPrograma($idPrograma).'</b>
    while($f = $r -> fetch_array()) {
        $idTipoSolicitud = $f['idTipoSolicitud'];
        echo '<form action="solicitudes.php" method="POST" enctype="multipart/form-data">';
            echo constriurFormulario($idTipoSolicitud);
            echo "<div style='width:95%;'>";
            echo "<input type='submit' value='Guardar' class='Mbtn btn-default'>";
            echo "</div>";
        echo "</form>";

    }
    echo "</div>";
}


//BUSQUEDA POR NOMBRE
if(isset($_POST['buscaNombre'])){
    $nombres = $_POST['nom'];
    $apaterno = $_POST['apaterno'];
    $amaterno = $_POST['amaterno'];
    $delegacion = $_POST['delegaciones'];
    $programa = $_POST['programas'];

    $consulta = "SELECT (CASE WHEN Contratos.NumContrato IS NULL THEN (CASE WHEN solicitudes.Cancelado = 0 THEN 'Solicitud vigente' ELSE 'Solicitud cancelada' END)
    Else 'Contrato ' + CONVERT(varchar(15), estatuscuentas.Descripcion, 103) END) AS EstatusCuenta, solicitudes.IdDelegacion, delegaciones.Delegacion,
    solicitudes.IdPrograma, programa.Programa, solicitudes.Folio, case when contratos.NumContrato is null then solicitudes.FechaCaptura else contratos.FechaEmision end As FechaCaptura, 
    solicitantes.Paterno, solicitantes.Materno, solicitantes.Nombre,
    solicitantes.FNacimiento, datosconyuge.Paterno AS Paterno_Conyuge, datosconyuge.Materno AS Materno_Conyuge, datosconyuge.Nombre AS Nombre_Conyuge,
    datosconyuge.FNacimiento AS FechaN_Conyuge, estatus.Estatus
FROM estatuscuentas RIGHT OUTER JOIN
    controlcontratos ON estatuscuentas.idEstatusCuenta = controlcontratos.EstatusCuenta RIGHT OUTER JOIN
    contratos ON controlcontratos.NumContrato = contratos.NumContrato RIGHT OUTER JOIN
    solicitudes ON contratos.IdDelegacion = solicitudes.IdDelegacion AND contratos.IdPrograma = solicitudes.IdPrograma AND
    contratos.Folio = solicitudes.Folio LEFT OUTER JOIN
    delegaciones ON solicitudes.IdDelegacion = delegaciones.IdDelegacion LEFT OUTER JOIN
    programa ON solicitudes.IdPrograma = programa.IdPrograma LEFT OUTER JOIN
    estatus RIGHT OUTER JOIN
    solestatus ON estatus.IdEstatus = solestatus.IdEstatus ON solicitudes.IdDelegacion = solestatus.IdDelegacion AND
    solicitudes.IdPrograma = solestatus.IdPrograma AND solicitudes.Folio = solestatus.Folio LEFT OUTER JOIN
    datosconyuge ON solicitudes.IdDelegacion = datosconyuge.IdDelegacion AND solicitudes.IdPrograma = datosconyuge.IdPrograma AND
    solicitudes.Folio = datosconyuge.Folio LEFT OUTER JOIN
    solicitantes ON solicitudes.IdSolicitante = solicitantes.IdSolicitante
WHERE     (1 = 1)";

if ($delegacion == 1){
    $consulta = $consulta."And solicitudes.iddelegacion = ".$delegacion."";
}    
if(strlen($apaterno) > 0){
    $consulta = $consulta."and (solicitantes.Paterno + ' ' + solicitantes.Materno + ' ' + solicitantes.Nombre) like '%".$apaterno."%'";
}
if(strlen($amaterno) > 0){
    $consulta = $consulta."and (solicitantes.Paterno + ' ' + solicitantes.Materno + ' ' + solicitantes.Nombre) like '%".$amaterno."%'";
} 
if(strlen($nombres) > 0){
    $consulta = $consulta."and (solicitantes.Paterno + ' ' + solicitantes.Materno + ' ' + solicitantes.Nombre) like '%".$nombres."%'";
}
$consulta = $consulta."Union

SELECT     (CASE WHEN Contratos.NumContrato IS NULL THEN (CASE WHEN solicitudes.Cancelado = 0 THEN 'Solicitud vigente' ELSE 'Solicitud cancelada' END)
    Else 'Contrato ' + CONVERT(varchar(15), estatuscuentas.Descripcion, 103) END) AS EstatusCuenta, solicitudes.IdDelegacion, delegaciones.Delegacion,
    solicitudes.IdPrograma, programa.Programa, solicitudes.Folio, case when contratos.NumContrato is null then solicitudes.FechaCaptura else contratos.FechaEmision end As FechaCaptura, 
    solicitantes.Paterno, solicitantes.Materno, solicitantes.Nombre,
    solicitantes.FNacimiento, datosconyuge.Paterno AS Paterno_Conyuge, datosconyuge.Materno AS Materno_Conyuge, datosconyuge.Nombre AS Nombre_Conyuge,
    datosconyuge.FNacimiento AS FechaN_Conyuge, estatus.Estatus
FROM         estatuscuentas RIGHT OUTER JOIN
    controlcontratos ON estatuscuentas.idEstatusCuenta = controlcontratos.EstatusCuenta RIGHT OUTER JOIN
    contratos ON controlcontratos.NumContrato = contratos.NumContrato RIGHT OUTER JOIN
    solicitudes ON contratos.IdDelegacion = solicitudes.IdDelegacion AND contratos.IdPrograma = solicitudes.IdPrograma AND
    contratos.Folio = solicitudes.Folio LEFT OUTER JOIN
    delegaciones ON solicitudes.IdDelegacion = delegaciones.IdDelegacion LEFT OUTER JOIN
    programa ON solicitudes.IdPrograma = programa.IdPrograma LEFT OUTER JOIN
    estatus RIGHT OUTER JOIN
    solestatus ON estatus.IdEstatus = solestatus.IdEstatus ON solicitudes.IdDelegacion = solestatus.IdDelegacion AND
    solicitudes.IdPrograma = solestatus.IdPrograma AND solicitudes.Folio = solestatus.Folio LEFT OUTER JOIN
    datosconyuge ON solicitudes.IdDelegacion = datosconyuge.IdDelegacion AND solicitudes.IdPrograma = datosconyuge.IdPrograma AND
    solicitudes.Folio = datosconyuge.Folio LEFT OUTER JOIN
    solicitantes ON solicitudes.IdSolicitante = solicitantes.IdSolicitante
Where 1 = 1";
if($delegacion == 1){
    $consulta = $consulta."And solicitudes.iddelegacion = ".$delegacion."";
}
if(strlen($apaterno) > 0){
    $consulta = $consulta."and (datosconyuge.Paterno + ' ' + datosconyuge.Materno + ' ' + datosconyuge.Nombre) like '%".$apaterno. "%'";
}
if(strlen($amaterno) > 0){
    $consulta = $consulta." and (datosconyuge.Paterno + ' ' + datosconyuge.Materno + ' ' + datosconyuge.Nombre) like '%".$amaterno."%'";
}   
if(strlen($nombres) > 0){
    $consulta = $consulta."  and (datosconyuge.Paterno + ' ' + datosconyuge.Materno + ' ' + datosconyuge.Nombre) like '%".$nombres."%'";
}
$consulta = $consulta." Order by FechaCaptura Desc";
    
echo $consulta;
/*$r = $conexion -> query($consulta); 
while($f = $r -> fetch_array()){
    
}  */
   
/*$Usuario = $nitavu; // Usuario que la Ejecutara
	$DescripcionDeUso = "Test"; // en que programa o uso
    //echo $consulta;

  $ConsultaDATA = DatosViviendaLarge($delegacion, $Usuario, $DescripcionDeUso, $consulta);
   if ($ConsultaDATA == TRUE){
    //echo $ConsultaDATA;0
    $array = json_decode($ConsultaDATA, true);
        if(is_array($array)){
            echo "<table>";
            
            foreach ($array as $value) {
                if (isset($value['r'])){// si hay un error
                    echo "Error: ".$value['r'];
                } else {
                    echo "<tr>";
                        echo "<td>";
                        $value['EstatusCuenta'];
                        echo "</td>";
                        echo "<td>";
                        $value['IdDelegacion'];
                        echo "</td>";
                        echo "<td>";
                        $value['Delegacion'];
                        echo "</td>";
                        echo "<td>";
                        $value['IdPrograma'];
                        echo "</td>";
                        echo "<td>";
                        $value['Programa'];
                        echo "</td>";
                        echo "<td>";
                        $value['Folio'];
                        echo "</td>";
                        echo "<td>";
                        $value['FechaCaptura'];
                        echo "</td>";
                        echo "<td>";
                        $value['Paterno'];
                        echo "</td>";
                        echo "<td>";
                        $value['Materno'];
                        echo "</td>";
                        echo "<td>";
                        $value['Nombre'];
                        echo "</td>";
                        echo "<td>";
                        $value['FNacimiento'];
                        echo "</td>";
                        echo "<td>";
                        $value['Paterno_Conyuge'];
                        echo "</td>";
                        echo "<td>";
                        $value['Materno_Conyuge'];
                        echo "</td>";
                        echo "<td>";
                        $value['Nombre_Conyuge'];
                        echo "</td>";
                        echo "<td>";
                        $value['FechaN_Conyuge'];
                        echo "</td>";
                        echo "<td>";
                        $value['Estatus'];
                        echo "</td>";
                    echo "</tr>";
                }
            }
            echo "</table>";
        } else {
            echo "ERROR: No es posible construir los datos: ".$ConsultaDATA;
        }
    }else{ //sin coneccion                                                                                                            
        // que hacer aqui sino hay conexion;
        echo "ERROR: no hay conexión a esta Delegación";
    }*/

}






}else{
    mensaje("No tiene acceso a ".$id_aplicacion,'');
}

?>
<script>
var k = 0;
$('#opciones input').on('change', function() {
    if(($('input:radio[name=opcion]:checked').val()=='nombre')){
        $("#busquedaNombre").css({'display':'inline-block',});
        $("#busquedaContrato").css({'display':'none',});
        $("#busquedaFolio").css({'display':'none',});
        $("#nuevaSolicitud").css({'display':'none',});
        $("#SolicitudDeDatos").css({'display':'none',});
	}else if(($('input:radio[name=opcion]:checked').val()=='contrato')){
        $("#busquedaNombre").css({'display':'none',});
        $("#busquedaContrato").css({'display':'inline-block',});
        $("#busquedaFolio").css({'display':'none',});
        $("#nuevaSolicitud").css({'display':'none',});
	}else if(($('input:radio[name=opcion]:checked').val()=='folio')){
        $("#busquedaNombre").css({'display':'none',});
        $("#busquedaContrato").css({'display':'none',});
        $("#busquedaFolio").css({'display':'inline-block',});
        $("#nuevaSolicitud").css({'display':'none',});
    }else if(($('input:radio[name=opcion]:checked').val()=='nuevo')){
        $("#busquedaNombre").css({'display':'none',});
        $("#busquedaContrato").css({'display':'none',});
        $("#busquedaFolio").css({'display':'none',});
        $("#nuevaSolicitud").css({'display':'inline-block',});
    }
});

/*function idTipoSolicitud(){
    var prog = document.getElementById("programas2").value;
    var deleg = document.getElementById("delegaciones2").value;
    
    $.ajax({
       url: "sol_construyeFormulario.php",
      type: "post",
      data: {programa: prog, delegacion:deleg},
      success: function(data){
       $('#Formulario').html(data);
       
      }
   });

}*/

function BuscaCURP(IdRequisito, IdCat, tipo){
   
    var nitavu =  document.getElementById("nitavu").value;
    if(tipo==2){
        var div = IdRequisito + "_curp" + IdCat; 
         
        console.log(div);   
        var txtCURP = $("#"+div).val().toUpperCase();
    }else{
        var div = IdRequisito + "_" + IdCat;    
        var txtCURP = $("#"+div).val().toUpperCase();
    }
    
    //alert(txtCURP);

    //$("#"+div).val(txtCURP);
    var Len = $("#"+div).val().length;
    //console.log("Tamaño del CURP: " + Len);

    
    if (Len == 18){
        $("#Loader" + IdRequisito + "_" + IdCat).show();
        $.ajax({
            url: "sol_curp.php",
            type: "POST",        
            data: {IdCat:IdCat, IdRequisito:IdRequisito, txtCURP: txtCURP, nitavu:nitavu},
            success: function(data){  
                console.log(data);   

                if(data.includes('Error')!=true)                            
                {
                    //console.log('entro');
                    var cadena = data;
                    var variables = cadena.split(",");

                    if(tipo ==1){
                        for (var i = 0; i < variables.length; i++) {
                       
                            if(i==4){
                                //console.log(i);
                            // $("#"+ i + "_" + IdCat).val(variables[i]);
                                if(variables[i]=='M'){
                                    $("#"+ i + "_" + IdCat+" option[value=1]").attr("selected",true);
                                    
                                }else{
                                    $("#"+ i + "_" + IdCat+" option[value=2]").attr("selected",true);
                                }
                                $("#"+i + "_" + IdCat).attr("readonly","readonly");
                                $("#"+ i + "_" + IdCat+" option:not(:selected)").attr('disabled',true);
                                //console.log(i + IdCat+variables[i]);
                            }else if(i==5){
                                var fecha = variables[i].split("/");
                                var fechanueva = fecha[2]+'-'+fecha[1]+'-'+fecha[0];
                                $("#"+ i + "_" + IdCat).val(fechanueva);
                                $("#"+i + "_" + IdCat).attr("readonly","readonly");
                            }/*else if(i==7){
                                //console.log(i);
                            // $("#"+ i + "_" + IdCat).val(variables[i]);
                                
                                    $("#"+ i + "_" + IdCat+" option[value="+variables[i]+"]").attr("selected",true);
                                    
                                
                                //$("#"+i + "_" + IdCat).attr("readonly","readonly");
                                $("#"+ i + "_" + IdCat+" option:not(:selected)").attr('disabled',true);
                                //console.log(i + IdCat+variables[i]);
                        }*/else{
                                console.log(i);
                                $("#"+ i + "_" + IdCat).val(variables[i]);
                                $("#"+i + "_" + IdCat).attr("readonly","readonly");
                                console.log(i + IdCat+variables[i]);
                            }
                        $("#Loader" + IdRequisito + "_" + IdCat).hide(); 
                    }
               }else{
                    console.log('entro al 2');
                    for (var i = 0; i < variables.length; i++) {
                            
                        
                            if(i==1){
                                $("#"+ i + "_nombre"  + IdCat).val(variables[i]);
                                $("#"+i + "_nombre"  + IdCat).attr("readonly","readonly");
                                console.log(i + '_nombre'  + IdCat);
                            }else if(i==2){
                                $("#"+ i + "_ap" + IdCat).val(variables[i]);
                                $("#"+i + "_ap" + IdCat).attr("readonly","readonly");
                                console.log(i + '_ap'  + IdCat);
                            }else if(i==3){
                                $("#"+ i + "_am" + IdCat).val(variables[i]);
                                $("#"+i + "_am" + IdCat).attr("readonly","readonly");
                            }else if(i==4){
                                //console.log(i);
                            // $("#"+ i + "_" + IdCat).val(variables[i]);
                                if(variables[i]=='M'){
                                    $("#"+ i + "_sexo" + IdCat +" option[value=1]").attr("selected",true);
                                    
                                }else{
                                    $("#"+ i + "_sexo" + IdCat+" option[value=2]").attr("selected",true);
                                }
                                $("#"+i + "_sexo" + IdCat).attr("readonly","readonly");
                                $("#"+ i + "_sexo" + IdCat+" option:not(:selected)").attr('disabled',true);
                                //console.log(i + IdCat+variables[i]);
                            }else if(i==5){
                                var fecha = variables[i].split("/");
                                var fechanueva = fecha[2]+'-'+fecha[1]+'-'+fecha[0];
                                $("#"+ i + "_fechan" + IdCat).val(fechanueva);
                                $("#"+i + "_fechan" + IdCat).attr("readonly","readonly");
                            }else if(i==6){
                                //console.log(i);
                                $("#"+ i + "_nacionalidad" + IdCat).val(variables[i]);
                                $("#"+i + "_nacionalidad" + IdCat).attr("readonly","readonly");
                                //console.log(i + IdCat+variables[i]);
                            }else if(i==7){
                                $("#"+ i + "_entidadf" + IdCat).val(variables[i]);
                                $("#"+i + "_entidadf" + IdCat).attr("readonly","readonly");
                            }else if(i==8){
                                $("#"+ i + "_status" + IdCat).val(variables[i]);
                                $("#"+i + "_status" + IdCat).attr("readonly","readonly");
                                
                            }
                        }
                        
                        
                    }
                   // $("#R" + IdRequisito + "_" + IdCat).html(data+"\n");   
                
                   
                // $("#Loader" + IdRequisito + "_" + IdCat).hide();  
               
                        
                        
                    
                }



                


                //$('#' + IdRequisito + '_' + IdClase).hide();
                //location.href="solicitudes.php";
                //location.reload();

                //Agregar require al resto de los input


            }
         });
 
    }

    console.log("->" + txtCURP);

}

var x = 0;
//$('#btn-Add').click(function() {
function agregarDependiente(){
    x = x+1;
    $.ajax({
        url: "sol_dat1.php",
        type: "POST",        
        data: {x:x},
        success: function(data){  
           // console.log(data);   
            $('#Categoria30').append(data);
            var acc = document.getElementsByClassName("accordion1");
            var i;

            for (i = 0; i < acc.length; i++) {
                acc[i].addEventListener("click", function() {
                    /* Toggle between adding and removing the "active" class,
                    to highlight the button that controls the panel */
                    this.classList.toggle("active");

                    /* Toggle between hiding and showing the active panel */
                    var panel = this.nextElementSibling;
                    if (panel.style.display === "block") {
                        panel.style.display = "none";
                    } else {
                        panel.style.display = "block";
                    }
                });
            }
           
        }
    });

   

    /*console.log(select);
    var item = `
    <h1 class='accordion' style='width:100%; margin: 0px;font-size: 10pt;font-family:Light; text-transform: uppercase;'>Datos Dependientes<img src='icon/flecha_abajo.png' style='width:18px; opacity:0.5;'></h1>
    <div class='panel'>
    <div class='elemento' style='background-color:#ffdea1;'><table width=100%><tr><td style='width:95%;'><label><b>CURP</b><br> <cite></cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>
    <tr><td><input  maxlength='18'  type='text' onkeypress='BuscaCURP(0,30);'  name='0_30' id='0_30' ></td><td width=13px><div style='display:none;' id='Loader0_30'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='R0_30'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>
    <div class='elemento'><label>*<b>Nombre</b><br> <cite></cite></label>
    <table width=100%><tr><td><input type='text' name='1_30' id='1_30' required ></td><td width=13px><div style='display:none;' id='Loader1_30'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK1_30'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>
    <div class='elemento'><label>*<b>Apellido Paterno</b><br> <cite></cite></label>
    <table width=100%><tr><td><input type='text' name='2_30' id='2_30' required ></td><td width=13px><div style='display:none;' id='Loader1_30'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK1_30'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>
    <div class='elemento'><label>*<b>Apellido Materno</b><br> <cite></cite></label>
    <table width=100%><tr><td><input type='text' name='3_30' id='3_30' required ></td><td width=13px><div style='display:none;' id='Loader1_30'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK1_30'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table></div>
    ${select}
    </div>
    `;

    $('#Categoria30').append(item);*/
    
    // Añadir caja de <texto class=""></texto>
    /*$('#Categoria30').append("<h1 class='accordion' style='width:100%; margin: 0px;font-size: 10pt;font-family:Light; text-transform: uppercase;'>Datos Dependientes<img src='icon/flecha_abajo.png' style='width:18px; opacity:0.5;'></h1>");
    $('#Categoria30').append("<div class='panel'>");
       
        $('#Categoria30').append("<div class='elemento' style='background-color:#ffdea1;'><table width=100%><tr><td style='width:95%;'><label><b>CURP</b><br> <cite></cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr>");
        $('#Categoria30').append("<tr><td><input  maxlength='18'  type='text' onkeypress='BuscaCURP(0,30);'  name='0_30' id='0_30' ></td><td style='width:13px;'><div style='display:none;' id='Loader0_30'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='R0_30'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>");																		                        
        $('#Categoria30').append("</div>");

        $('#Categoria30').append("<div class='elemento'><label>*<b>Nombre</b><br> <cite></cite></label>");
        $('#Categoria30').append("<table width=100%><tr><td><input type='text' name='1_30' id='1_30' required ></td><td width=13px><div style='display:none;' id='Loader1_30'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='LoaderOK1_30'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table>");
        $('#Categoria30').append("</div>");

    $('#Categoria30').append("</div>");*/

    
   
    //$('#Categoria30').append("<div class='panel'><div class='elemento' style='background-color:#ffdea1;'><table width=100%><tr><td style='width:95%;'><label><b>CURP</b><br> <cite></cite></label></td><td align='center' style='width:5%;'><img src='./icon/ok.png' align='center' style='width:8px;'></td></tr><tr><td><input  maxlength='18'  type='text' onkeypress='BuscaCURP(0,30);'  name='0_30' id='0_30' ></td><td width=13px><div style='display:none;' id='Loader0_30'><img src='img/loader_bar.gif' style='width:13px;'></div><div style='display:none;' id='R0_30'><img src='icon/ok.png' style='width:13px;'></div></td></tr></table> </div> </div>");																                        
        
    
 
       																		
    
    
//});
}

</script>
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
<?php include ("./lib/body_footer.php"); ?>