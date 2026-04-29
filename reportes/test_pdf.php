<?php
include ("head.php");

// $sql = "SELECT * FROM reportes WHERE id_rep='".$id_rep."' ";
// $rc= $db0 -> query($sql);if($f = $rc -> fetch_array()){ 
//     $orientacion = $f['orientacion'];
//     $autor = $f['IdUser'];
//     $titulo = $f['rep_name'];
//     $descripcion = $f['rep_description'];
//     $IdCon = $f['IdCon'];                    
//     $PageSize = $f['PageSize'];
//     $out_type = $f['out_type'];
//     echo "OK PDF";
// } else {
//     return "Parametros insuficientes, por favor complete correctamente el reporte.";
// }


$TablaHTML = '
<table id="2nDDyGO6l85MqAii"  style="width:100%" class="tabla" border=1 style="font-size:8pt;">  
            <thead>
            <tr>
                <th >nitavu</th><th >nombre</th>  
            </tr>
            </thead><tbody class=""><tr><td >1002</td><td >Victor Hugo Salas Arias</td></tr><tr><td >1047</td><td >Marina Nereyda Castillo Padilla</td></tr><tr><td >1114</td><td >Patricia Guadalupe Alvizo Arciniega</td></tr><tr><td >1116</td><td >Maria Del Rosario Bautista Hernandez</td></tr><tr><td >1119</td><td >Silvia Esthela Navarro Sanchez</td></tr><tr><td >1143</td><td >Isidro Barron Castañon</td></tr><tr><td >1144</td><td >Jorge Torres Rodriguez</td></tr><tr><td >1145</td><td >Jose Refugio Quintero Martinez</td></tr><tr><td >1199</td><td >Imelda Lopez Herrera</td></tr><tr><td >1201</td><td >Gladyz Elizabeth Garcia Marquez</td></tr></tbody></table>
';

// $TablaHTML ="<table><tr><td>Hola</td><td>Mundo</td></tr></table>";
$IdUser = $nitavu;
$titulo = "Titulo del Reporte";
$descripcion = "La Descripcion";
$PageSize = "0"; // 0= carta y 1 == oficio
$orientacion = "L";
$id_rep = 0;
$info_leyenda = "x";
$ArchivoDelReporte = TableToPDF($TablaHTML, $IdUser, $titulo, $descripcion, $PageSize, $orientacion,$id_rep,$info_leyenda);



echo "<iframe src='".$ArchivoDelReporte."'
style='
    width:100%;
    height:500px;
'
></iframe>";
// echo $TablaHTML;



// TabletoPDF($TablaHTML, $IdUser,$titulo,$descripcion,$PageSize,$orientacion);



include ("footer.php");
?>