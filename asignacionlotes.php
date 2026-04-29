<?php
include("./lib/body_head.php");
include("./lib/body_menu.php"); 

$id_aplicacion = 'ap97';
echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){

    echo "<br><br>";
    echo '<form id="opciones">';
    echo '<label>Busqueda por:</label>
    <label><input type="radio" id="nombre" name="opcion" value="nombre">Nombre
    <input type="radio" id="contrato" name="opcion" value="contrato">Contrato
    <input type="radio" id="folio" name="opcion" value="folio">Folio</label>';
    echo '</form>';
    //buscar por nombre
    echo "<div id='busquedaNombre' style='display:none;'>";
    echo "<form action='asignacionlotes.php' method='POST'>";
        echo "<div style='width:100%;'>";
            echo "<div>";
            echo "<label for='delegaciones'>Seleccione una delegación:";
            echo "<select name='delegaciones'>";
            
            //$sql = "SELECT * FROM delegaciones where tipo = 0 ORDER by Delegacion ASC";

                $sql = "SELECT * FROM delegaciones ORDER by Delegacion ASC";
                $r = $Vivienda -> query($sql);
                while($f = $r -> fetch_array())
                { // resultado de la busqueda.................
                    echo "<option value='".$f['IdDelegacion']."'>".$f['Delegacion']. "</option>";
                }
            
            echo "</select>";
            echo "</div>";
            echo "<div>";
            echo "<label for='programas'>Seleccione una delegación:";
            echo "<select name='programas'>";
            
            //$sql = "SELECT * FROM delegaciones where tipo = 0 ORDER by Delegacion ASC";

                $sql = "SELECT * FROM programa ORDER by Programa ASC";
                $r = $conexion -> query($sql);
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
    echo "<form action='asignacionlotes.php' method='POST'>";
        echo "<label>Número contrato</label>";
        echo "<input id='numcontrato' name='numcontrato'>";
        echo "<input type='submit' id='buscaContrato' value='Buscar' class='Mbtn btn-default'>";
    echo "</form>";
    echo "</div>";


    //buscar por folio
    echo "<div id='busquedaFolio' style='display:none;'>";
    echo "<form action='asignacionlotes.php' method='POST'>";
        echo "<label>Folio</label>";
        echo "<input id='numfolio' name='numfolio'>";
        echo "<input type='submit' id='buscaFolio' value='Buscar' class='Mbtn btn-default'>";
    echo "</form>";
    echo "</div>";

   

    echo "<div>";
    echo "<div id='AppDetalle'>Datos del terreno</div>";
    echo "<form action='asignacionlotes.php' method='POST'>";
        echo "<label>Oficio de autorización</label>";
        echo "<input id='oficioAutorizacion' name='oficioAutorizacion' required>";
        echo "<label>En caso de fallecimiento del titular. El titular será</label>";
        echo "<input id='fallecimiento' required>";
        echo "<label>Parentesco (Conyuge, Hijo, Hija, etc)</label>";
        echo "<input id='parentesco' name='parentesco' required>";
    echo '</form>';
    echo "</div>";
}else{
    mensaje('No tiene permiso para usar esta aplicación.','index.php');
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
    
   //echo $consulta;
   
	$Usuario = $nitavu; // Usuario que la Ejecutara
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
    }

}





















?>
<script>

$('#opciones input').on('change', function() {
    if(($('input:radio[name=opcion]:checked').val()=='nombre')){
        $("#busquedaNombre").css({'display':'inline-block',});
        $("#busquedaContrato").css({'display':'none',});
        $("#busquedaFolio").css({'display':'none',});
	}else if(($('input:radio[name=opcion]:checked').val()=='contrato')){
        $("#busquedaNombre").css({'display':'none',});
        $("#busquedaContrato").css({'display':'inline-block',});
        $("#busquedaFolio").css({'display':'none',});
	}else if(($('input:radio[name=opcion]:checked').val()=='folio')){
        $("#busquedaNombre").css({'display':'none',});
        $("#busquedaContrato").css({'display':'none',});
        $("#busquedaFolio").css({'display':'inline-block',});
    }
});


</script>
<?php include ("./lib/body_footer.php"); ?>