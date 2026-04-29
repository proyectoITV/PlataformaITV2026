<?php
require("config.php");
require("lib/funciones.php");

$nitavu = $_POST['usuario'];
$Widget_contenido = "";
$Widget_contenido = $Widget_contenido."<table border=0 width='100%' s><tr>";
$salida = comida_salida($nitavu);

if ($salida==FALSE){
	
	$Widget_contenido = $Widget_contenido.'<td>';
	$Widget_contenido = $Widget_contenido.'<label>A que hora saldras a comer?</label>';
	$Widget_contenido = $Widget_contenido."<input type='text' name='oficial_hr_salida' id='oficial_hr_salida' onchange='tiempo()'   value='".$hora."' required='required' placeholder='HH:MM:SS' ></td>";
	$Widget_contenido = $Widget_contenido.'<td valign=center><label>Espere autorizacion</label><button  onclick=SolicitaPase("'.$nitavu.'","COMIDA"); class="Mbtn btn-default">Solicitar</button></td>';
	$Widget_contenido = $Widget_contenido.'';

	

} else {
//$Widget_contenido = $Widget_contenido.'Salio: '.hora12($salida);
$pase_estado = comida_estado($nitavu);
if ($pase_estado==TRUE){	
	$trestante = comida_trestante($nitavu);	
	//echo $trestante;
	if (substr($trestante, 0,1)=='-'){//se retraso
		$Widget_contenido = $Widget_contenido. "<td  width=12% rowspan=3 align=center valign=center><img src='icon/emo_triste.gif' style='width:50px; height:50px;'></td>";

		$Widget_contenido = $Widget_contenido."<td align=left class='tenue' style='font-size: 7pt;'> <span >Tiempo autorizado para comida ".comida_aut($nitavu)."</span></td>";
		$Widget_contenido = $Widget_contenido."</tr>";
		$Widget_contenido = $Widget_contenido."<tr><td align=left valign=center style='font-size: 10pt;'>Se ha retrasado <b class='alerta'>".$trestante."m</b>.</td></tr>";
	}
	else {
		
		if (substr($trestante, 0,1)=='+'){//PASE REALIZADO
		$Widget_contenido = $Widget_contenido. "<td  width=12% rowspan=2 align=center valign=center><img src='icon/emo_cafe.gif' style='width:50px; height:50px;'></td>";

		$Widget_contenido = $Widget_contenido."<td align=left class='tenue' style='font-size: 7pt;'> <span >PASE REALIZADO<br></span></td>";
		$Widget_contenido = $Widget_contenido."</tr>";
		$Widget_contenido = $Widget_contenido."<tr><td align=left valign=center style='font-size: 10pt;'><b class=''>".$trestante."</b>.</td></tr>";
		}
	
		if (substr($trestante, 0,1)=='*'){//PASE REALIZADO
		$Widget_contenido = $Widget_contenido. "<td  width=12% rowspan=2 align=center valign=center><img src='icon/emo_cafe.gif' style='width:50px; height:50px;'></td>";

		$Widget_contenido = $Widget_contenido."<td align=left class='tenue' style='font-size: 7pt;'> <span >Tiempo autorizado para comida ".comida_aut($nitavu).".<br></span></td>";
		$Widget_contenido = $Widget_contenido."</tr>";
		$Widget_contenido = $Widget_contenido."<tr><td align=left valign=center style='font-size: 10pt;'><b class=''>".$pase_estado."</b></td></tr>";
		}

		if (substr($trestante, 0,1)=='0'){//PASE REALIZADO
		$Widget_contenido = $Widget_contenido. "<td  width=12% rowspan=3 align=center valign=center><img src='icon/emo_cafe.gif' style='width:50px; height:50px;'></td>";

		$Widget_contenido = $Widget_contenido."<td align=left class='tenue' style='font-size: 7pt;'> <span >Tiempo autorizado para comida ".comida_aut($nitavu)."</span></td>";
		$Widget_contenido = $Widget_contenido."</tr>";
		$Widget_contenido = $Widget_contenido."<tr><td align=left valign=center style='font-size: 10pt;'>Le quedan  <b class='normal'>".$trestante."m</b> Buen Provecho!.</td></tr>";
		}

	}
}
else {
	$Widget_contenido = $Widget_contenido." <label>".$pase_estado."</label>";
}

}
$Widget_contenido = $Widget_contenido. "<tr><td class='tchico' align=right>
<a href=''></a></td></tr></table>";





echo $Widget_contenido;

?>