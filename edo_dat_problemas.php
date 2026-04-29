<?php
// require("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require("lib/curp_fun.php");
require("var_clean.php");
$id_aplicacion ="v002";
// error_reporting(0); //<-- para simular produccion
$IdProblema = VarClean($_POST['IdProblema']);
$OriginData = VarClean($_POST['OriginData']);
$NumContrato = VarClean($_POST['_NumContrato']);
$ejecuta = VarClean($_POST['ejecuta']);
$nitavu = VarClean($_POST['nitavu']);
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
// sleep(10);
// echo ProblemaName($IdProblema);
$VoBo = NumContrato_Vobo($NumContrato, $OriginData);
ContratoVisita($NumContrato, $OriginData, $nitavu,'Vio Estado de Cuenta con la IdApp='.$id_aplicacion);
if ($VoBo=='' or $ejecuta ==1){
    sleep(3);
    // echo $IdProblema;

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
    //  echo $sql;
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
    
    if ($VoBo == ''){
        
    } else {        
        echo "<p class='alert alert-danger'>Este Edo. de Cuenta ha sido marcado como <b title='Ha dado el VoBo ".$VoBo."'>Correcto</b> y esta listo para la versión al publico.</p>";
    }

    //si es Nivel 2 = Puede ajustar el VoBo y Reportar Problema (AutoTicket - Guardado)
    if ($nivel==2){
        echo "<div class='alert alert-dark'>";
        // echo "<b style='width:100%; text-align:center; font-size:15pt;'>¿".nitavu_nombre($nitavu)." este Edo. de Cuenta es?</b>";
        
            echo "<b style='width:100%; text-align:center; font-size:15pt;'>¿Este Edo. de Cuenta es?</b>";    
        
        
        echo "<br>";
        echo "<button class='btn btn-success' onclick='VoBo(1,".$OriginData.");'> Correcto</button> ";
        echo "<button class='btn btn-danger' onclick='VoBo(0,".$OriginData.");'> Incorrecto</button>";
        
        if ($VoBo == ''){
            echo "<label>Actualmente no esta disponible al publico; ya que aun o se le ha dado el VoBo.</label>";
        } else {
            echo "<label>Actualmente esta disponible al publico; ya que se le ha dado el VoBo. ".$VoBo."</label>";
        }
        
        echo "</div>";
    } else {
        
    }
    unset($rp, $p);

    //Boton para la Caja
    //1.- Checar que el Usuario Tenga Permiso
    $sql = "SELECT count(*) as n FROM aplicaciones_permisos where nitavu='".$nitavu."' and idapp = 'caja'";		
    // echo $sql;
	$rp= $conexion -> query($sql);		
    // var_dump($conexion);
    // var_dump($rp);
	if($fp = $rp -> fetch_array())
	{
		if ($fp['n']>=1){
            echo "<a title='Haga clic aqui para ir a Caja al Contrato ".$NumContrato." de la Delegacion Origen ".$OriginData." "."' class='btn btn-primary' href='caja.php?NumContrato=".$NumContrato."&OriginData=".$OriginData."' target=blank'>
            CAJA".": ".$NumContrato." (Origen en ".DelegacionNombre($OriginData).")</a>";
        } else {
            "sin permiso para caja";
        }
	} else {
        "sin permisos para caja";
	}
    


?>

