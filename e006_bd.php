<?php
require("seguridad.php"); 
require_once("config.php");
// require_once("lib/funciones.php");
require_once("lib/yes_funciones.php");
require_once("lib/funciones.php");

    $nitavu= $_POST['nitavu'];
    $accion = $_POST['Accion'];
    $seleccion = $_POST['Selected'];
    $op = $_POST['Opcion'];

    $direccion=quienEsmiDireccion(nitavu_dpto($nitavu));   
    $paso = ObtenerPaso($direccion,$accion);
    $llenos= ObtenerQueCamposDeberiaEstarLlenos($paso,$op);


    $sql = 'SELECT " 1" as elegido, movescrituras.NumEscritura, delegaciones.Delegacion,municipios.Municipio, catcolonia.NOMBRE_OFICIAL as Colonia, REPLACE(lotes.manzana, @ ," ") AS Manzana, lotes.Lote,CONCAT ( if(ISNULL(solicitantes.Nombre), "", solicitantes.Nombre), " ",
    if(ISNULL(solicitantes.Paterno), " " ,solicitantes.Paterno), " ", if(isnull(solicitantes.Materno)," ",solicitantes.Materno)) AS Persona, if(ISNULL(lotes.seccion),lotes.seccion,"0")as seccion, if(ISNULL( lotes.Fila),lotes.Fila,"0") as Fila , municipios.Municipio , contratos.NumContrato,catcolonia.Colonia, catcolonia.NOMBRE_OFICIAL 
    FROM solicitudes INNER JOIN  contratos ON solicitudes.IdDelegacion = contratos.IdDelegacion 
    AND solicitudes.IdPrograma = contratos.IdPrograma    AND solicitudes.Folio = contratos.Folio  
    INNER JOIN   solicitantes ON solicitudes.IdSolicitante = solicitantes.IdSolicitante
    INNER JOIN delegaciones ON solicitudes.IdDelegacion = delegaciones.IdDelegacion
    AND contratos.IdDelegacion = delegaciones.IdDelegacion        
    INNER JOIN   lotes ON  contratos.IdLote = lotes.idLote AND contratos.NumContrato = lotes.NumContrato 
    INNER JOIN movescrituras ON lotes.idLote = movescrituras.idlote and lotes.NumEscritura=movescrituras.NumEscritura  and contratos.idlote=movescrituras.idlote   
    INNER JOIN catcolonia   ON lotes.IdMunicipio = catcolonia.IdMunicipio AND lotes.IdColonia = catcolonia.IdColonia
    INNER JOIN municipios ON catcolonia.IdMunicipio = municipios.IdMunicipio';

    $sql = $sql . ' WHERE '.$llenos;


    //echo $sql;

    if($op == 'enviar'){

        echo "<div id='Lista' style='background-color:#EEEEEE; width:95%; display:inline-block;
        border-radius:5px; padding:10px; margin-top:20px;'>";
        echo "<h2>".strtoupper ("Lista de escrituras para ".$seleccion)."</h2>";
        TablaDinamica_MySQLVivienda("",$sql, "EscriturasDiv", "TablaEscrituras", "", 2); 

        echo "<table style='width:100%;'><tr><td colspan='2'>";
            echo "<label>Notario</label>";
            echo "<select  name='notario' style='margin-left: 0px;' id='notario' style='display:inline-block'  >";
            // if($seleccion == 6){
                $sql2="select CONCAT(RTRIM(LTRIM(Nombre)),' N°',Convert(NumNotaria, NCHAR)) as Nombre, idNotario from catnotarios where Estatus=1 order by IdNotario";
            //}else if($seleccion == 12){
            //  $sql2 = "";
            //}
            $r2 = $Vivienda -> query($sql2);
            echo '<option value="0" >Seleccione una opcion...</option>';
            while($f = $r2 -> fetch_array())
            {
                    echo "<option value='".$f['idNotario']."'>".$f['Nombre']."</option>";
            } 
            echo "</select>";  

        echo "</td></tr><tr><td>";
            echo "<label>Oficio</label>";
            echo "<input type='text' id='oficio' name='oficio'>";
        echo "</td><td>";
            echo "<label>Observaciones</label>";
            echo "<input type='text' id='observaciones' name='observaciones'>";
        echo "</td></tr></table>";
        echo "<input type='hidden' id='selected' name='selected' value='$seleccion'>";
        echo "<br><br>";
        echo "<center><input style='width:30%;' class='Mbtn btn-primary' type='submit' value='Enviar paquete' ></center>";
        echo "</div>";
    }else{

        echo "<div id='busquedaContrato'>";
        echo "<form action='e006.php' method='POST'>";
            echo "<input type='hidden' id='accion' name='accion' value='".$accion."'>";
            echo "<input type='hidden' id='seleccion' name='seleccion' value='".$seleccion."'>";
            echo "<input type='hidden' id='opcion' name='opcion' value='".$op."'>";
            echo "<label>Número contrato</label>";
            echo "<input id='numoficio' name='numoficio'>";
            echo "<input type='submit' id='buscaContrato' value='Buscar' class='Mbtn btn-default'>";
        echo "</form>";
        echo "</div>";
    }




?>

