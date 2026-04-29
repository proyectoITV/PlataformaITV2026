<?php

include ("lib/body_head.php");
    
$id_aplicacion ="ap113"; 
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";        
    xd_update($id_aplicacion,$nitavu); historia($nitavu, $id_aplicacion." | Entro a contratación");
    echo "<br><br>";

    //PRIMERA VALIDACION SERIA VER SI ES POR PROGRAMAS TIPO TERRENO O CUALQUIER OTRO 

    //NIVELES


    //SI ES NECESARIO BUSCARLO ANTES
    //LO PRIMERO SERIA ESCOGER DELEGACION, PROGRAMA SOCIAL, NUMERO DE FOLIO
    echo "<center>";
    echo "<div style='width:80%; padding-top: 30px;  padding-bottom: 30px;'>";
    echo "<form id='formularioContrato' action='contratar.php' method='GET' style='border: 1px #C0C5BE solid; padding-top: 20px;
    padding-right: 10px;
    padding-bottom: 20px;
    padding-left: 10px;'>";
    echo "<center><table style='width:100%;'><tr><td style='width:20%;'>";
    
    echo "<center><label for='delegaciones'>Seleccione una delegación:";
    echo "<select name='delegaciones' id='delegaciones' required>";
        $sql = "SELECT * FROM delegaciones where Tipo = 0 ORDER by Delegacion ASC";
        echo "<option value=''>Seleccione una opción</option>";
        $r = $Vivienda -> query($sql);
        while($f = $r -> fetch_array())
        { // resultado de la busqueda.................
            echo "<option value='".$f['IdDelegacion']."'>".$f['Delegacion']. "</option>";
        }
    echo "</select></center>";
    echo "</td>";
    echo "<td style='width:50%;'>";
    echo "<center><label for='programa'>Seleccione un programa:";
    echo "<select name='programa' id='programa'  required>";
    echo "<option value=''>Seleccione una opción</option>";
    //id='programas'
    $sql = "SELECT * FROM programa WHERE Activo=1 ORDER by Programa ASC";
        $r = $Vivienda -> query($sql);
        while($f = $r -> fetch_array())
        { // resultado de la busqueda.................
            echo "<option value='".$f['IdPrograma']."'>".$f['Programa']. "</option>";
        }

    echo "</select></center>";  
    echo "</td>";
    
    echo "<td style='width:20%;'>";
    echo "<center><label for='_folio'>Folio";
    echo "<input id='_folio' name='_folio' value=''   placeholder='Folio del solicitante' required>";
    echo "</center></td></tr>";
    echo "<tr><td colspan=3 style='width:30%;'><center>";    
    echo "<button type='submit'  class='btn btn-info' title='Buscar' > <center>
    <table><tr><td valign='middle' align='center'>
    <img src='icon/buscar2.png'> 
    </td>
    <td valign='middle' align='center' style='color:white;' >
    Buscar
    </td></tr></table>  </center> 
    </button>";  

    echo "</center></td></tr></table></center>";
    echo "</form>";   
    echo "</div>";

    
    echo "<center>";

    $midpto = nitavu_dpto($nitavu);
   
    $del =  midelegacion_id($nitavu);
    //echo $del;
    //EMPEZAMOS LA PANTALLA PONIENDO PENDIENTES PARA ACTIVAR CONTRATACIÓN
    if($nivel == 1 ){
        $sql = "select * 
    from vivienda_ahorroprevio as vap
    INNER JOIN programa as prog ON vap.IdPrograma = prog.IdPrograma and prog.AhorroPrevio = 1
    INNER JOIN solicitudes as sol ON sol.IdDelegacion = vap.IdDelegacion and sol.IdPrograma = vap.IdPrograma and sol.Folio = vap.Folio and sol.AprobadoContratar = 0
    WHERE Saldo >= AhorroPactado and AhorroPactado > 0 and NumContrato = ''";
    }else{
        if($del <> ''){
            $sql = 'select sol1.*, sol.Nombre, sol.Paterno, sol.Materno
            from solicitudes as sol1
            inner join solicitantes as sol on sol.IdSolicitante = sol1.IdSolicitante
            where sol1.AprobadoContratar = 1 and IdDelegacion = '.$del.'';
        }else{
            $sql = 'select sol1.*, sol.Nombre, sol.Paterno, sol.Materno
            from solicitudes as sol1
            inner join solicitantes as sol on sol.IdSolicitante = sol1.IdSolicitante
            where sol1.AprobadoContratar = 1 limit 0';
        }
    }
    
    //echo $sql;
    $r = $Vivienda -> query($sql);
    $r_count = $r -> num_rows;

    if ($r -> num_rows >0){
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
                
            } else { //Si la string no es numérica, redirige al index (por ejemplo: index.php?pagina=AAA)
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
    // echo $sql;
    $r = $Vivienda -> query($sql);
    echo "<h4>Resultados ".$r_count. ", agrupados de ".$paginacion." </h4>";
    $paginas = intval(($r_count / $paginacion));
    }
    if ($r -> num_rows >0){
        echo "<h2>Pendientes de contratar</h2>";
            echo "<center>";
            echo "<table class='tabla' style='width:80%;'>";
            echo "<th>Folio</th>";
            echo "<th>Descripción</th>";
            echo "<th>Ver</th>";
        while($f = $r -> fetch_array()){
            echo "<tr>";
                echo "<td width='5%'>";
                echo $f['Folio'];
                echo "</td>";
                echo "<td >";
                    echo "<div style ='display: table-cell; vertical-align: middle; width: 80%'>";
                        echo '<span style="font-size: 14px; color:#848484; font-family:sans-serif;"><b>'.$f['IdSolicitante'].'</b><br>';
                        echo ''.$f['Nombre'].' '.$f['Paterno'].' '.$f['Materno'].'</span>';
                        echo "<br><span>Programa: ".$f['IdPrograma']."-".NombrePrograma($f['IdPrograma'])."     Delegación: ".$f['IdDelegacion']."-".nombreDelegacionVivienda($f['IdDelegacion'])." </span>";
                        //echo '<br><hr><span style="color:blue;">Creado por:   ['.$f['NitavuCaptura'].'] - '.nitavu_nombre($f['NitavuCaptura']).'</span>';
                        //echo "<br><label style='font-size:7pt; margin:0px; padding:0px;'>Capturado por ".nitavu_nombre($f['NitavuCaptura'])." - ".$f['Fecha']." : ".$f['Hora']." en ".DptoNombre($f['DptoCaptura'])." </label>";

                        echo "</div>";
                   
                echo "</td>";
                echo "<td >";
                echo '<form action="contratar.php" method="GET">';
                echo "<input type='hidden' name='_folio' id='_folio' value=".$f['Folio'].">";
                echo "<input type='hidden' name='programa' id='programa' value=".$f['IdPrograma'].">";
                echo "<input type='hidden' name='delegaciones' id='delegaciones' value=".$f['IdDelegacion'].">";
                echo "<input type='hidden' name='idlote' id='idlote' value=".$f['IdLote'].">";
                echo "<button  id='editar' name='ediar' class='Mbtn btn-default' title='Clic para seguir editando la solicitud'><img src='icon/btn_derecha.png' style='widht:15px; height:15px;'></button>";
                echo "</form>";
                echo "</td>";
                echo "</tr>";
        }
        echo "</table>";
        echo "</center>";

        if ($r_count >= $paginacion)
        {
        echo "<center><div id='barra_paginacion'>";
            echo "Paginas: ";
                //Crea un bucle donde $i es igual 1, y hasta que $i sea menor o igual a X, a sumar (1, 2, 3, etc.)
                //Nota: X = $total_paginas
                for ($i=1; $i<=$paginas+1; $i++) {
                    //En el bucle, muestra la paginación
                    if ($pagina==$i)
                    {
                        echo "<span id='pagina_actual'>".$pagina."</span>"; //para el CSS span = a pagina actual
                    }
                    else
                    {
                    //	echo "<span id='pagina_proxima'><a href='?search=".$search."&p=".$i."'>".$i."</a></span>"; //CSS span a = link a paginas
                        echo "<span id='pagina_proxima'><a href='?p=".$i."'>".$i."</a></span>"; //CSS span a = link a paginas
                    }
                }
        echo "</div></center>";
        }
    }/*else{
        echo "No hay pendientes por contratar";

    }*/



}else{
    mensaje("ERROR: no tienes acceso a este modulo","");
}


?>
<script>

</script>

<?php include ("lib/body_footer.php"); ?>

