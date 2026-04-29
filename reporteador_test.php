<?php
include('/seguridad.php');
//include('lib/body_head.php');
require('config.php');
require('lib/funciones.php');

define('FPDF_FONTPATH','fpdf/font');
require('fpdf/html2pdf.php');

$id_aplicacion ="ap50";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
if (sanpedro($id_aplicacion, $nitavu)==TRUE and $nivel==1)
{ 
$id=1;


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

$tabla_contenido=""; 

$cuantas_filas=0;
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
echo  $t;




}
else{echo " <br><br>";echo "No tiene acceso a ".$id_aplicacion;}
?>