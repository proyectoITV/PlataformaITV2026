

<?php
//REPORTEADOR

function reporte_sql($id){
require("config.php");
$sql = "SELECT * FROM reportes WHERE id_rep='".$id."'";
//echo $sql;
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{ return $f['sql'];} else {return "";}
}

function reporte_titulo($id){
require("config.php");
$sql = "SELECT * FROM reportes WHERE id_rep='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{ return "".$f['nombre']." [".$f['id_rep']."]";} else {return "";}
}

function reporte_descripcion($id){
require("config.php");
$sql = "SELECT * FROM reportes WHERE id_rep='".$id."'";
$rc= $conexion -> query($sql);
if($f = $rc -> fetch_array())
	{ return $f['descripcion'];} else {return "";}
}



function reporte_tabla($id){
require("config.php");
$sql = reporte_sql($id);
$cuantas_columnas=0;
$tabla_titulos = "";
$r2 = $conexion -> query($sql); while($finfo = $r2->fetch_field())
{//OBTENER LAS COLUMNAS

        /* obtener posición del puntero de campo */
        $currentfield = $r2->current_field;       
       	$tabla_titulos=$tabla_titulos."<th>".$finfo->name."</th>";
       	$cuantas_columnas = $cuantas_columnas + 1;        
}

$tabla_contenido=""; $cuantas_filas=0;
$r = $conexion -> query($sql); while($f = $r-> fetch_row())
{//LISTAR COLUMNAS

    $tabla_contenido = $tabla_contenido."<tr>";        
    for ($i = 1; $i <= $cuantas_columnas; $i++) {      
        $tabla_contenido = $tabla_contenido."<td>".$f[$i-1]."</td>";       
        }

    $tabla_contenido = $tabla_contenido."</tr>";
    $cuantas_filas = $cuantas_filas + 1;        
}


$t = "<h3>".reporte_titulo($id)."</h3>";
$t = $t."<label class='reporte_descripcion'
>".reporte_descripcion($id)."</label>";

$t = $t."<table class='tabla'>".$tabla_titulos.$tabla_contenido."</table>";
return $t;

}





function reporte_tabla2($id){
require("config.php");
$sql = reporte_sql($id);
$cuantas_columnas=0;
$tabla_titulos = "<tr>";
$r2 = $conexion -> query($sql); while($finfo = $r2->fetch_field())
{//OBTENER LAS COLUMNAS

        /* obtener posición del puntero de campo */
        $currentfield = $r2->current_field;       
       	$tabla_titulos=$tabla_titulos."<td>".$finfo->name."</td>";
       	$cuantas_columnas = $cuantas_columnas + 1;        
}
$tabla_titulos = $tabla_titulos."</tr>";
$tabla_contenido=""; $cuantas_filas=0;
$r = $conexion -> query($sql); while($f = $r-> fetch_row())
{//LISTAR COLUMNAS

    $tabla_contenido = $tabla_contenido."<tr>";        
    for ($i = 1; $i <= $cuantas_columnas; $i++) {      
        $tabla_contenido = $tabla_contenido."<td>".$f[$i-1]."</td>";       
        }

    $tabla_contenido = $tabla_contenido."</tr>";
    $cuantas_filas = $cuantas_filas + 1;        
}


$t = "<h3>".reporte_titulo($id)."</h3>";
$t = $t."<label 
>".reporte_descripcion($id)."</label>";

$t = $t."<table >".$tabla_titulos.$tabla_contenido."</table>";
return $t;

}

?>