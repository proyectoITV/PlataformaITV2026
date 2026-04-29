<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>
<?php
$id_aplicacion ="ap100"; 
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
docdigital_no(FALSE, 1); 
historia($nitavu, "[ap100] notfisicas inicio");


$nivel=1;
if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";

    if ($nivel == 1){//Oficinas Centrales | Monitoreo | Cancelacion del candado para reimprimir
        

        echo "<div id='Delegaciones' style='
            display: inline-block;
            width: 150px;        
            margin: 5px;        
            position: absolute;        
            right: 10px;'
        >";
        $sql = "select * from cat_delegaciones where cp<>'' order by nombre";
        $r= $conexion -> query($sql);
        echo "<table class='tabla'>";
        while($f = $r -> fetch_array()) {
            echo "<tr>";
            echo "<td><a style='display:block;' href='?IdDelegacion=".$f['id']."'>".$f['nombre']."</a></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "</div>";


        if (isset($_GET['IdDelegacion'])){ 
            $IdDelegacion = $_GET['IdDelegacion']; if (ValidaVAR($IdDelegacion)==TRUE){$IdDelegacion = LimpiarVAR($IdDelegacion);} else {$IdDelegacion = "";}
            $sql = "
                select  count(*) as n, IFNULL(Fecha,'') as Fecha

                from carteravencida_seguimiento
                WHERE Fecha = (select MAX(Fecha) from carteravencida_seguimiento)
                AND IdDelegacion = ".$IdDelegacion."
            
            ";
            // echo $sql;
            $rc= $conexion -> query($sql);                    
            if($f = $rc -> fetch_array()){
                $ContratosConCalculo = $f['n'];
                $UltimaFecha = $f['Fecha'];
            } else{
            
            }


            if ($ContratosConCalculo > 0 ){
                echo "<div id='EstadisticaPorColonia' style='
                    display:inline-block; 
                    width:50%; 
                    margin:5px;'>";
                    $sql = "
                    select  DISTINCT a.IdColonia, a.Colonia from carteravencida_seguimiento a
                        WHERE Fecha = (select MAX(Fecha) from carteravencida_seguimiento) AND IdDelegacion = ".$IdDelegacion."
                    ";
                    $r2= $conexion -> query($sql);
                    echo "<table class='tabla'>";
                    while($f2 = $r2 -> fetch_array()) {
                        echo "<tr>";
                        echo "<td><a style='display:block;' href='?IdDelegacion=".$IdDelegacion."&IdColonia=".$f2['IdColonia']."'>".$f2['Colonia']."</a></td>";
                        echo "</tr>";
                    }
                    echo "</table>";

                    echo "<label>Fecha Ultima Actualizacion: ".$f['Fecha']."</label>";


                    echo "</div>";
            } else  {
                Toast("Está delegación no cuenta con un calculo de la cartera vencida en la Plataforma, comuniquese con el Dpto de Informatica para solicitarlo",2,"");

            }


        }

        
    }

    if ($nivel == 2){//Delegaciones | Impresion y Captura
        $MiIdDelegacion = MiIdDelegacion($nitavu);

        echo "<div id='EstadiscaPorCol'>";
        echo "<h2>Estadistica por Colonias</h2>";
        // $sql="select * from cat_colonias where IdDelegacion  = ".$MiIdDelegacion." Order by Municipio, Colonia";
        // $r= $conexion -> query($sql);
        // echo "<table class='tabla'>";
        // while($f = $r -> fetch_array()) {
        //     echo "<tr>";
        //     echo "<td><b>".$f['Colonia']."</b><cite>".$f['Municipio']."</cite></td>";
        //     echo "<td><div id='Contratos".$f['IdMunicipio']."_".$f['IdColonia']."'></div></td>";

        //     echo "</tr>";
        // }
        // echo "</table>";
        echo "</div>";






        echo "<label>Tu IdDelegacion = ".$MiIdDelegacion."</label>";
    }



} else {mensaje("ERROR; sin acceso a esta aplicacion","");}
?>
<?php include ("./lib/body_footer.php"); ?>
