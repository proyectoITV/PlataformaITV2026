<?php
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require_once("lib/yes_funciones.php");

$NumContrato = $_POST['NumContrato'];
$OriginData = $_POST['OriginData'];

$sql = "
SELECT
c.NumContrato,
CONCAT(
problemas ( c.NumContrato, c.OriginData, 1 ),
problemas ( c.NumContrato, c.OriginData, 2 ),
problemas ( c.NumContrato, c.OriginData, 3 ),
problemas ( c.NumContrato, c.OriginData, 4 ),
problemas ( c.NumContrato, c.OriginData, 5 ),
problemas ( c.NumContrato, c.OriginData, 6 ),
problemas ( c.NumContrato, c.OriginData, 7 ),
problemas ( c.NumContrato, c.OriginData, 8 ),
problemas ( c.NumContrato, c.OriginData, 9 ),
problemas ( c.NumContrato, c.OriginData, 10),
problemas ( c.NumContrato, c.OriginData, 11 ),
problemas ( c.NumContrato, c.OriginData, 12 ),
problemas ( c.NumContrato, c.OriginData, 13 ),
problemas ( c.NumContrato, c.OriginData, 14 ),
problemas ( c.NumContrato, c.OriginData, 15 ),
problemas ( c.NumContrato, c.OriginData, 16 ),
problemas ( c.NumContrato, c.OriginData, 17 ),
problemas ( c.NumContrato, c.OriginData, 18 ),
problemas ( c.NumContrato, c.OriginData, 19 ),
problemas ( c.NumContrato, c.OriginData, 20 ),
problemas ( c.NumContrato, c.OriginData, 21 ),
problemas ( c.NumContrato, c.OriginData, 22 )
)
    AS problemas 
FROM
contratos c  
WHERE NumContrato ='".$NumContrato."' and OriginData='".$OriginData."'



";	
// echo $sql;
$r= $Vivienda -> query($sql);	    				
// var_dump($Vivienda);
// var_dump($r);
echo "<hr>";    
if($f = $r -> fetch_array())
{
    if ($f['problemas']==''){
        Toast("Sin problemas detectadas",4,"");
        echo "<p class='alert alert-success'><b>La plataforma no ha identificado problemas conocidos</b>. </p>";
       
        
    }else {
        Toast("Se han encontrado problemas ".$f['problemas'],2,"");
        echo "<p class='alert alert-danger'>".$f['problemas']."</p>";
        ContratoVisita($NumContrato, $OriginData, $nitavu,'Vio Estado de Cuenta con la IdApp='.$id_aplicacion." con los sig. problemas ".$f['problemas']);
    }
    
    
} else {
    Toast("No encontro problema con ".ProblemaName($IdProblema),0,"");
}
} else {
echo "<p class='alert alert-info'>Se omitio la busqueda de problema, debido a que ya tiene un VoBo. <a style='text-decoration:underline;' onclick='AnalizarProblema(".$OriginData.", 0,1);'>Analizar nuevamente?</a></p>";
}

echo '
        
        
<div class="accordion accordion-flush" id="accordionFlushExample">
<div class="accordion-item">
<h2 class="accordion-header" id="flush-headingOne">
<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
   ¿Que problemas detecta la Plataforma?
</button>
</h2>
<div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
<div class="accordion-body">
';

echo '<table class="tabla">';
echo '<th>IdProblema</th>';
echo '<th>Problema</th>';
echo '<th>Descripcion</th>';    
$rp = $Vivienda -> query("select * from cat_problemasdevivienda where IdProblema>0");
while($p = $rp -> fetch_array()) {
    echo '<tr>';
    echo '<td>'.$p['IdProblema'].'</td>';
    echo '<td>'.$p['Problema'].'</td>';
    echo '<td>'.$p['Descripcion'].'</td>';

    echo '</tr>';
    
}
echo '</table>';
echo '

</div>
</div>
</div>


</div>

';

// Leyenda Informatica
echo "";


echo "<p class='alert alert-warning'>Es importante revisar el Edo. de Cuenta, Si encuentras un error reportarlo al departamento correspondiente. </p>";


?>