
<?php
require ("config.php");
require ("lib/funciones.php");

if (isset($_GET['user'])){$usuario = $_GET['user'];}

$anterior = ultimoNumero($usuario);
$n= misnotificaciones_n($usuario);
$agregadas = $n - $anterior;

$contenido = traerContenidoNotificacion($usuario, $agregadas);
$porciones = explode("/", $contenido);
$noti='';
if($agregadas != 0){
    for ($i=0; $i<sizeof($porciones); $i++){
        if($porciones[$i]!=null){
            $porcion = explode(",",$porciones[$i]);
            for($j=0; $j<sizeof($porcion); $j++){
                if((($porcion[$j]!=null) and ($porcion[$j]!='')) and ((isset($porcion[$j+1])) and ($porcion[$j+1]!=null) and ($porcion[$j+1]!=''))){
                    // $noti =  $noti." ".nitavu_nombre($porcion[$j]).": ".$porcion[$j+1]."".',';
                    $noti =  $noti." ".nitavu_nombre($porcion[$j]).": ".strip_tags($porcion[$j+1])."".',';
                    
                }
            }
        }  
    }
    actualizarNuevoNumero($n,$usuario);
}
echo $noti;

?>
