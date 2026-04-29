<?php
// require("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");

error_reporting(0); //<-- para simular produccion
$Search = $_GET['search']; if (ValidaVAR($Search)==TRUE){$Search = LimpiarVAR($Search);} else {$Search = "";}
$nitavu = $_GET['nitavu']; if (ValidaVAR($nitavu)==TRUE){$nitavu = LimpiarVAR($nitavu);} else {$nitavu = "";}

historia($nitavu,"[V001] ".$Search.", Busco beneficiario");

// echo "Search = ".$Search." y nitavu = ".$nitavu;
$sql="
select
	*

from programa a 
where Programa like '%".$Search."%'
order by IdPrograma DESC
";

// echo $sql;
$r= $Vivienda -> query($sql);
$c=0;


$t = "<table class='tabla'>";
$t = $t."<th width=10%>Ejercicio</th><th>Programa</th><th width=250px>Estadistica</th><th width=50px></th>";

while($f = $r -> fetch_array()) {
    if ($f['Activo']==1){
        $t =$t."<tr style='background-color:green;'>";
    } else {
        $t =$t."<tr>";
    }
    
    
    $t =$t."<td style='font-size:18pt;' align=center valing=midle>".$f['Ejercicio']."</td>";
    $t =$t."<td>";
    $t =$t."<b style='font-size:12pt;' title='IdPrograma = ".$f['IdPrograma']."'>".$f['Programa']."</b><br>";
    $t =$t."<cite style='font-size:8pt;'>".$f['Descripcion']."</cite><br>";
    $t =$t."</td>";
    
    $t =$t."<td>";
    // if ($f['Actualizacion']<>''){
    // $t =$t."<span title='Informacion calculada el ".$f['Actualizacion']." en la informacion de la base de datos Vivienda de la Plataforma ITAVU'
    // style='
    //     font-size: 8pt;
    //     display: inline-block;
    //     margin: 0px;
        
    //     border-radius: 5px;
    //     padding: 3px; cursor:pointer; width:100%;
    // '><b>Saldo</b>: ".Pesos($f['Saldo'])."</span>";

    // $t =$t."<span title='Informacion calculada el ".$f['Actualizacion']." en la informacion de la base de datos Vivienda de la Plataforma ITAVU'
    // style='
    //     font-size: 8pt;
    //     display: inline-block;
    //     margin: 0px;
        
    //     border-radius: 5px;
    //     padding: 3px; cursor:pointer; width:100%;
    // '><b>Moratorios</b>: ".Pesos($f['Moratorios'])."</span>";

    // $t =$t."<span title='Informacion calculada el ".$f['Actualizacion']." en la informacion de la base de datos Vivienda de la Plataforma ITAVU'
    // style='
    //     font-size: 8pt;
    //     display: inline-block;
    //     margin: 0px;
        
    //     border-radius: 5px;
    //     padding: 3px; cursor:pointer; width:100%;
    // '><b>solicitudes Pendientes de Contratar</b>: ".$f['SolicitudesPendientes']."</span>";

    // $t =$t."<span title='Informacion calculada el ".$f['Actualizacion']." en la informacion de la base de datos Vivienda de la Plataforma ITAVU'
    // style='
    //     font-size: 8pt;
    //     display: inline-block;
    //     margin: 0px;
        
    //     border-radius: 5px;
    //     padding: 3px; cursor:pointer; width:100%;
    // '><b>Ahorro (Sin Contrato)</b>: ".Pesos($f['SolicitudesPendientes_ahorro'])."</span>";

    
    // $t =$t."<span title='Informacion calculada el ".$f['Actualizacion']." en la informacion de la base de datos Vivienda de la Plataforma ITAVU'
    // style='
    //     font-size: 8pt;
    //     display: inline-block;
    //     margin: 0px;
        
    //     border-radius: 5px;
    //     padding: 3px; cursor:pointer; width:100%;
    // '><b>Contratos: </b>: ".$f['Contratos']."</span>";

    // } else {
    //     // $t=$t."Sin calculo de Estadistica";

    // }
    
    $t =$t."</td>";

    
    $t =$t."<td>";
    $t =$t."<a title='Haga clic aqui para ver la información del programa ' href='programas.php?IdPrograma=".$f['IdPrograma']."' class='btn btn-primary' style='height:100%;'>";
    $t =$t."<img src='icon/entrarwhite.png' style='width:40px;'>";
    $t =$t."</a>";
    $t =$t."</td>";
    
    
    $t =$t."</tr>";




    $c= $c+1;
}
$t = $t."</table>";


if ($c > 0){
    echo $t;
} else {
    Toast("Sin resultados en la busqueda, intentelo nuevamente",2,"");
}




















?>

