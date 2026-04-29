<?php
require("unica/seguridad.php"); 
require_once("unica/config.php");
require_once("unica/funciones.php");
require_once("unica/flor_funciones.php");

error_reporting(0); //<-- para simular produccion


 //Parametros
 
 $sql= "select 
 id as IdDelegacion,
 nombre as Delegacion
 
 from cat_delegaciones
 where dpto_id <> ''";
 $r= $conexion -> query($sql);
 $tbT= "<table class='tabla'><th>Delegacion</th>";
 $tb=""; $c = 1; $GranMoratorio = 0; $SutotalMoratorio = 0;
 while($f = $r -> fetch_array()) {    
    $tb = $tb."<tr>";
    $tb = $tb."<td>".$f['Delegacion']."</td>";
    $IdDelegacion = $f['IdDelegacion'];
    $rprg= $conexion -> query("select Ejercicio, IdPrograma, Programa from cat_programa order by Ejercicio DESC");
    $style=""; $title=""; $error="";
    while($prgs = $rprg -> fetch_array()) {
        if ($c == 1){
             $tbT= $tbT."<th>".LimpiarVAR($prgs['Programa'])."</th>"; 
            }
            

            $tb = $tb."<td id='".$IdDelegacion."_".$prgs['IdPrograma']."'></td>";
            $div = $IdDelegacion."_".$prgs['IdPrograma'];
            echo "
            <script>
                SolicitarMoratorio(".$IdDelegacion.", '".$IdPrograma."', '".$div."');
            </script>
            ";

    }
    $tb = $tb."<td title='".$SubtotalMoratorio."'>$".number_format($SubtotalMoratorio,2,'.',',')."</td>";
    $tb = $tb."</tr>";

    $GranMoratorio = $GranMoratorio + $SubtotalMoratorio;
    $c = $c + 1;
 }
 $tbT= $tbT."<th>Moratorio/Deleg</th>"; 
 
 $tb = $tb."</tr>";

 $tb = $tbT.$tb."</table>";
 $tb = $tb."<table><tr><td>Total:</td><td title='".$GranMoratorio."'>$".number_format($GranMoratorio,2,'.',',')."</td></tr></table>";


 echo $tb;
 $str_loader = "<img src='img/loader.gif' style='width:50px;'>";
 echo '
 <script>

 function SolicitarMoratorio(IdDelegacion, IdPrograma, div){
    NPush("Calculando Moratorio de el Programa " + IdPrograma + " de la Delegacion Id " + IdDelegacion,"Moratorio ITAVU");
    console.log("Calculando Moratorio de el Programa " + IdPrograma + " de la Delegacion Id " + IdDelegacion);
     
     $("#" + div).html("'.$str_loader.'");
     $.ajax({
         url: "contratos_dat4dat.php",
     type: "get",        
     data: {IdDelegacion:IdDelegacion, IdPrograma:IdPrograma},
     success: function(data){                                
         $("#" + div).html(data+"\n");            
     }
     });
 }
 </script>
 ';

 $impimir = "<h1>Saldo Moratorio por Programa y por Delegaciones</h1>".$tb;
 echo "
 <form action='print.php' method='POST' target=_blank>";
echo '<input type="hidden" name="data" value="'.$tb.'">';
echo "
<input type='submit' value='Imprimir' class='btn btn-grisTam' style='width:200px;'>
 </form>
 ";
 













?>

