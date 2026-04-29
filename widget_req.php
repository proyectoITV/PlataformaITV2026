<?php


//WIDGET PROTOTIPO


$Widget_nombre="<img src='icon/Autorizada.png' style='width:23px;'><b class='pc'>Estadísticas de Requisiciones</b><b class='movil'>E.Requisciones</b>";
$wc="";

//require("config.php");

//$wc = $wc.'<section name="promos" id="promos2">';
$wc = $wc.'<div id="slider_widReq" >';
$sql = "SELECT req_estatusreq.IdEstatus,req_estatusreq.DesEstatus, COUNT(req_requisiciones.IdEstatus) as Cantidad from req_requisiciones
 inner join req_estatusreq on req_requisiciones.IdEstatus=req_estatusreq.IdEstatus
 and  req_requisiciones.IdEstatus <>6
group by req_estatusreq.IdEstatus,req_estatusreq.DesEstatus,req_requisiciones.IdEstatus";
$r = $conexion -> query($sql);

while($f = $r -> fetch_array())
{
    
    $wc = $wc."<div class='centrar'>"; 
    $wc = $wc. "<table border=0 width=90% height=90%  ><tr>";
    $wc = $wc.'<td class="centrar" colspan="2" >';
    if ($f['IdEstatus']==2 or $f['IdEstatus']==5 or $f['IdEstatus']==7)
    {
      $wc=$wc."<br><span class='tenue pc'>  <b class='tgrande normal'>".$f['DesEstatus']."S"."<b/></span><span class='tenue movil menu_font_n'  > ESTATUS: <b class='  normal'>".$f['DesEstatus']."S"."<b/></span><br>";
     }
     else
     {
      $wc = $wc."<br><span class='tenue pc'  >  <b class='tgrande normal'>".$f['DesEstatus']."<b/></span><span class='tenue movil menu_font_n'  > ESTATUS: <b class=' normal'>".$f['DesEstatus']."<b/></span><br>"; 
     } 
  
    $wc = $wc.'</td></tr>'; 
      
    $tamaño=strlen($f['Cantidad']);
       
    $wc = $wc. "<tr><td class='centrar' colspan='2'>";
    if($tamaño<=6)
    {
    $wc = $wc."<br><b class='pc'  style='font-size:5em; font-weight: bold;' >".$f['Cantidad']."</b><b class='movil tgrande' >".$f['Cantidad']."</b>";
    }else
    {
      $wc = $wc."<br><b class='pc'  style='font-size:2em; font-weight: bold;'  >".$f['Cantidad']."</b><b class='movil tmediano' >".$f['Cantidad']."</b>";
    }
    $wc = $wc."<br></td></tr>"; 
    $wc = $wc."<tr height=15px;></tr>";      
  

    $valores=RezagadosPorEstatus($f['IdEstatus']);
    if(empty ($valores[0] ))
      {
        //wc = $wc. "Rezagadas: 0" ; 
      }

    else 
      {
      $wc = $wc."<tr><td  class='centrar normal menu_font_n'  style=' color:white; background-color: #DF0101;'  >";
      $wc = $wc. "<b >N° de Rezagadas:<br><b>";
      $wc = $wc. "<b >".$valores[0]."<b>";     
      $wc = $wc. "</td>";
      $wc = $wc. "<td class='normal menu_font_n centrar' style =' background-color: #f2f2f2;' <br>";
      $wc = $wc. "<b >Tiempo maximo de rezago:<br><b>";
      $wc = $wc. "<b class='tenue centrar'>".tiempoTranscurridoFechas($valores[1],$valores[2])."</b>";  
      $wc = $wc. "</td>";
      }
    $wc = $wc. "</tr></table>";
    $wc = $wc."</div>";


}
$wc = $wc."</div>";


	


	   


$tmp="";
$tmp = $tmp."<section id='aplicaciones' class='widget'>";
$tmp = $tmp. "<label>".$Widget_nombre."</label>";
$tmp = $tmp."<div id='widgetReq' style='background-color:#dcf1ff; margin: 5px;' width=100% height=100% >";

$tmp = $tmp. "<table id='tablawidget' border='0'  width=100%><tr><td>";
$tmp = $tmp.$wc."<br>";
$tmp = $tmp. "</td></tr></table></div>";

echo $tmp."</section>";

?>




