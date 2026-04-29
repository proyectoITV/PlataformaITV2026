<?php 	require("lib/funciones.php"); ?>
<?php 	require("config.php"); ?>

<?php
if (isset($_GET['ip'])){
$sql="
                select usuario as UserIP,
                (select nombre from empleados where nitavu=userIP)as nombre,
                (select dpto from empleados where nitavu=userIP) as DptoId,
                (select nombre from cat_gerarquia where id = DptoID) as Dpto,

                sessiones.* from sessiones where ipcliente='".$_GET['ip']."'
            ";
            $r3= $conexion -> query($sql);
            // echo $sql;
            echo "<h3 style='color: red; font-size:9pt;'>Sessiones de ".$_GET['ip']."</h3>";
            echo "<table class='tabla'>";
            while($f3 = $r3 -> fetch_array()) {
                echo "<tr style='font-size:8pt;'>";
                echo "<td>";
                echo "Apertura: ".$f3['fecha']." | ".$f3['hora'];
                if ($f3['cierre_fecha']=='0000-00-00'){
                    echo "<br>Sin cierre de session";
                } else{
                    echo "<br>Cierre: ".$f3['cierre_fecha']." | ".$f3['cierre_hora'];
                }
                
                echo "</td>";
                echo "<td>".$f3['nombre']."</td>";
                echo "<td><pre>".$f3['comentarios']."</pre></td>";
                
                
                echo "</tr>";
            }
            echo "</table>";
}            

?>            