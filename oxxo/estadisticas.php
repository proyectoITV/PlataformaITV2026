<?php 
    include "header.php";
    include "lib/variables.php";
?>

<div class="container my-4">
    <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header" style="background-color: #ddc9a3;">
                        <b>Comprobantes de pago</b>
                    </div>
                    <div class="card-body">
                        <h2 class="card-title"><img src="/lib/estadisticas.png" class="img-fluid rounded-top" alt="" width="40px"/>Estadisticas</h2>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="card" style="background-color: #ddc9a3;">
                                    <img class="card-img-top" src="holder.js/100x180/" alt="Beneficiarios" />
                                    <div class="card-body">
                                        <h2 class="card-title" style="text-align:center">
                                        <?php
                                            include "conexionbd.php";
                                            $sql = "select count(id) As Total from comprobantesoxxo_registro where year(fechaoperacion) = year(now())";
                                            $r = $conexion -> query($sql);
                                            $row_cnt = $r->num_rows;
                                            if ($row_cnt>0) {
                                                while($f = $r -> fetch_array()) {
                                                    echo $f['Total'];
                                                }
                                            }
                                            else {
                                                echo "---";
                                            }
                                        ?>
                                        </h2>
                                        <p class="card-text" style="text-align:center">Número de beneficiarios registrados</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card" style="background-color: #ddc9a3;">
                                    <img class="card-img-top" src="holder.js/100x180/" alt=" Comprobantes" />
                                    <div class="card-body">
                                        <h2 class="card-title" style="text-align:center">
                                            <?php
                                                include "conexionbd.php";
                                                $sql = "select count(id) As Total from comprobantesoxxo_peticiones where year(fechaoperacion) = year(now())";
                                                $r = $conexion -> query($sql);
                                                $row_cnt = $r->num_rows;
                                                if ($row_cnt>0) {
                                                    while($f = $r -> fetch_array()) {
                                                        echo $f['Total'];
                                                    }
                                                }
                                                else {
                                                    echo "---";
                                                }
                                            ?>
                                        </h2>
                                        <p class="card-text" style="text-align:center">Número de comprobantes emitidos</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card" style="background-color: #ddc9a3;">
                                    <img class="card-img-top" src="holder.js/100x180/" alt="Resumen anual" />
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-primary" style="background-color: white;">
                                                <tbody>
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Año</th>
                                                            <th scope="col">Beneficiarios</th>
                                                            <th scope="col">Comprobantes</th>
                                                        </tr>
                                                    </thead>

                                                    <?php
                                                        include "conexionbd.php";
                                                        $sql = "select year(fechaoperacion) As año, 
                                                        (select count(id) As Registro from comprobantesoxxo_registro where year(fechaoperacion) = year(comprobantesoxxo_peticiones.fechaoperacion)) As Beneficiarios,
                                                        count(id) as comprobantes 
                                                        from comprobantesoxxo_peticiones group by year(fechaoperacion)
                                                        order by year(fechaoperacion)";
                                                        $r = $conexion -> query($sql);
                                                        $row_cnt = $r->num_rows;
                                                        if ($row_cnt>0) {
                                                            while($f = $r -> fetch_array()) {
                                                                echo "
                                                                <tr class=''>
                                                                <td scope='row'>".$f['año']."</td>
                                                                <td style='text-align:center'>".$f['Beneficiarios']."</td>
                                                                <td style='text-align:center'>".$f['comprobantes']."</td>
                                                                </tr>                                                                
                                                                ";
                                                            }
                                                        }
                                                        else {
                                                            echo "
                                                            <tr class=''>
                                                            <td scope='row'>---</td>
                                                            <td style='text-align:center'>---</td>
                                                            <td style='text-align:center'>---</td>
                                                            </tr>";
                                                            }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="card-footer text-muted" style="text-align: center; vertical-align: middle;">
                        <?php echo $administracion; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include "footer.php";?>