<?php
    require("config.php");
    require("seguridad.php");
    require("var_clean.php");
    require("lib/funciones.php");
    require("vehiculos_fun.php");

    $id_aplicacion ="ci";
    $nivel =aplicacion_nivel($id_aplicacion, $nitavu);

    echo "<div>";
    if($nivel==2)
    {
        echo "
            <div class='content'>
                <h1 style = 'color:black; text-align: left;'>Agregar/Quitar archivos</h1>
            </div>

            <a href='subirarchivos_normatividad.php' class='theme-btn btn-style-one' >Administrar Documentos</a>
        ";
    }
    else {
        echo "
            <div class='content'>
                <h1 style = 'color:black; text-align: left;'>Archivos disponibles</h1>
            </div>
        ";
    }

    echo "<table class='styled-table' width='100%'>";
    echo "<thead>";
    echo "<tr>";
            echo "<th width='2%'>Cve</th>";
            echo "<th width='55%'>Nombre del documento</th>";
            echo "<th width='20%'>Descripcion</th>";
            echo "<th width='10%'>Vistas</th>";
            Echo "<th width='13%'>Publicación</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";
        require("config.php");
        $sql="select * from ci_html";
        $r = $conexion -> query($sql);
        while($f = $r-> fetch_array()) {
            echo "<tr>";
                echo "<td>".$f["IdCi"]."</td>";
                echo "<td>".$f["Documento"]."</td>";
                echo "<td>".$f["Descripcion"]."</td>";
                echo "<td>".$f["Vistas"]."</td>";
                echo "<td>".substr($f["fechadepublicacion"], 0, 16)."</td>";
            echo "</tr>";
        }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";   
?>