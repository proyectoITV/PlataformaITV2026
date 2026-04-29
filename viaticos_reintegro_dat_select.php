<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("viaticos_fun.php");
// require_once("lib/flor_funciones.php");

$IdViatico = VarClean($_POST['IdViatico']);
echo "<table width=100%>";
echo "<tr><td width=40%>"; //Informacion sobre el Viatico
echo "<div style='
        background-color: #c4c1c1;
        border-radius:5px;
        padding:10px;

    '>";
    $sqlC = "select * from viaticoscomprobaciones  WHERE IdViatico='".$IdViatico."'";		
	$rC= $conexion -> query($sqlC);					
	if($fc = $rC -> fetch_array())
	{
        echo "<table width=100% class='tabla' style='font-size:15pt;'>";
        echo "<tr>";
            echo "<td align=right>Gasto: </td><td align=left><b>".Pesos($fc['Gasto'])."</b></td> 
            ";
        echo "</tr>";

        echo "<tr>";
            echo "<td align=right>Gasto Comprobado: </td><td align=left><b>".Pesos($fc['GastoComprobado'])."</b></td> ";
        echo "</tr>";

        echo "<tr>";
            $Faltante = $fc['Faltante'];
            if ($Faltante <0){$Faltante = 0;}
            echo "<td align=right>Faltante: </td><td align=left><b style='color:red;'>".Pesos($Faltante)."</b></td> ";
        echo "</tr>";

        echo "<tr>";
            echo "<td align=right>Reintegro: </td><td align=left><b>".Pesos($fc['Reintegro'])."</b></td> ";
        echo "</tr>";

        if ($fc['Comprobacion']=='COMPROBADO'){
            echo "<tr><td colspan=2 valing=middle align=center style='
                background-color:green;
                '>";}
        else {
            echo "<tr><td colspan=2 valing=middle align=center style='
            background-color:orange; color:white;
            '>";

        }
                echo "
            <label style='color:white;'>Estado de la Comprobacion:</label><br>
            <b style='color:white; font-size:20pt;'>".$fc['Comprobacion']."</b>";

            if ($fc['Comprobacion']=='COMPROBADO'){
                //Documento de Comprobacion de viaticos
            }

            echo "</td></tr>";

        echo "</table>";


		
	}  else {
        echo "ESTE VIATICO <b>[".$IdViatico."] </b>NO ESTA LISTO PARA LA COMPROBACION";
    }  
    unset($sqlC, $rC, $fc);
    echo "</div>";


    echo "</div>";

echo "</td><td style='vertical-align:top;' align=center>"; //Captura del Reintegro
if (isset($Faltante)){
if ($Faltante>0){//Abrimos la Caja
    echo "<div id='ReintegroDiv' style='
    background-color:white; width:90%; margin:10px; border-radius:5px;
    padding:10px;
    '>";
    echo "<h3>Captura del Reintegro:</h3>";

    echo "<label>Reintegro:</label><br>";
    echo "<input type='number' style='font-size:14pt;' id='ReintegroCantidad' value='".$Faltante."' class='form-control' min=0 max=".$Faltante."><br><br>";
    

    
    echo "<button class='btn btn-success' onclick='RecibirReintegro();'>Recibir</button><br><br>";
    
    
    echo "<div id='DivRecibo'></div>";
    echo "</div>";
    


}}


echo "</td></tr>";

echo "</table>";



echo "<div style='
background-color: #ffffff91;
border-radius:5px;
padding:10px;
margin-top:10px;
'>";
echo "<b>Recibos de reintegro: </b><br>";

$sql = "
select * from viaticosreintegros where IdViatico='".$IdViatico."' order by IdReintegro DESC;
";
echo "<table width=100% class='tabla'>
<th>IdReintegro</th>
<th>Fecha </th>
<th>Cantidad </th>
<th>Recibo</th>
";
$r= $conexion -> query($sql);    
$n = 0;
while($f = $r -> fetch_array()) {
if ($n==0){
    echo "<tr style='background-color:green'><td>".$f['IdReintegro']."</td>";
    echo "<td>".fecha_larga($f['Fecha'])."</td>";
    echo "<td>".Pesos($f['Reintegro'])."</td>";
    echo "<td>
    <a href='viaticor_printrecibo.php?id=".$f['IdReintegro']."'  class='btn btn-secondary'
    download='".EasyName("Recibo"."4").".pdf'><img src='icon/pdf.png' style='width:32px;'></a></td></tr>";

}
else {
    echo "<tr><td>".$f['IdReintegro']."</td>";
    echo "<td>".fecha_larga($f['Fecha'])."</td>";
    echo "<td>".Pesos($f['Reintegro'])."</td>";
    echo "<td>
    <a target=_blank title='Haz clic aquí para descargar el recibo'    
    href='viaticor_printrecibo.php?id=".$f['IdReintegro']."'  class='btn btn-secondary'
    download='".EasyName("Recibo"."4").".pdf' ><img src='icon/pdf.png' style='width:32px;'></a></td></tr>";

    



}
$n= $n+1;
}
echo "</table>";

?>
