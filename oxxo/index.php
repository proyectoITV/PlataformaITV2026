
<?php 
    include "header.php";
    include "lib/variables.php"
?>

<div class="container my-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header" style="background-color: #ddc9a3;">
                        <b>Comprobantes de pago</b>
                    </div>
                    <div class="card-body">
                        <h2 class="card-title">Datos del ticket de pago</h2>
                        <form action="index.php" method="POST">
                            <div class="table-responsive">
                                <table >
                                    <tbody>
                                        <tr class="">
                                            <td style="width:300px;">
                                                <div class="mb-3">
                                                    <label for="txtbuscar" class="form-label">
                                                        Número de referencia OXXO 
                                                        <a href="#!" data-bs-toggle="modal" data-bs-target="#muestrareferencia">
                                                            <img src="lib/ayuda.png" alt="" width="30" height="30">
                                                        </a>
                                                    </label>
                                                    <input type="text" class="form-control" name="txtbuscar" id="txtbuscar" placeholder="#Referencia">
                                                </div>
                                            </td>
                                            <td style="width:10px;"></td>
                                            <td style="width:300px;">
                                                <div class="mb-3">
                                                    <label for="txtprimerapellido" class="form-label">Primer apellido</label>
                                                    <input type="text" class="form-control" name="txtprimerapellido" id="txtprimerapellido" placeholder="Primer apellido">
                                                </div>
                                            </td>
                                            <td style="width:10px;"></td>
                                            <td style="width:300px;">
                                                <button type="submit" class="btn btn-danger">Buscar</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p>Hay que considerar un período de 48 a 72 horas para que Tiendas OXXO, nos envie los pagos captados. </p> 
                            </div>
                        </form>

                        <hr>

                        <h2>Historial de pagos en TIENDAS OXXO</H2>
                        <table id="segmentos" class="table table-striped" style="width=100%">
                            <thead>
                                <th style="background-color:#ddc9a3; color:black;">NumMov</th>
                                <th style="background-color:#ddc9a3; color:black;">Fecha Operacion</th>
                                <th style="background-color:#ddc9a3; color:black;">Concepto</th>
                                <th style="background-color:#ddc9a3; color:black;">Importe</th>
                                <th style="background-color:#ddc9a3; color:black;">Tienda</th>
                                <th style="background-color:#ddc9a3; color:black;">Control Interno</th>
                                <th style="background-color:#ddc9a3; color:black;">Opciones</th>
                            </thead>
                            <tbody>
                                <?php
                                    include 'webservices_principal.php';
                                    if (empty($referencia)==0 and empty($validacion1)==0){
                                        include "conexionbd.php";
                                        $consulta = "select * from comprobantesoxxo_registro where referencia = '".$referencia."'";
                                        $resultado = mysqli_query($conexion, $consulta);
                                        $row_cnt = mysqli_num_rows($resultado);
                                        if ($row_cnt>0){
                                            $ch = curl_init();
                                            $peticion = "http://".$nomservidor."/".$nomwebservice."?method=GET&token=".$token."&sql=select%20*%20from%20Vivienda_Ws_PagosOXXO%20where%20paterno%20=%20%27".str_replace(' ', '', $validacion1)."%27%20and%20(numcontrato%20=%20%27".$numcontrato1."%27%20or%20numcontrato%20=%20%27".$numcontrato2."%27)%20order%20by%20NumMov";
                                            //echo $peticion;
                                            $array_options = array(CURLOPT_URL=>$peticion, CURLOPT_RETURNTRANSFER=>true,   );
                                            curl_setopt_array($ch,$array_options);
                                            $resp = curl_exec($ch);
                                            $final_decoded_data = json_decode($resp,true);
                                            $beneficiario = '';
                                            if(is_array($final_decoded_data)){
                                                $ControlUno = 1;
                                                foreach ($final_decoded_data as $value) {
                                                    if (empty($value['NumMov'])==0){

                                                        if ($ControlUno == 1) {
                                                            $beneficiario = $value['Beneficiario'];
                                                            echo "<b><h4><i class='fa-regular fa-user'></i>"." ".$beneficiario."</b></h4>";
                                                            echo "<br>";
                                                            $ControlUno = 2;
                                                        }

                                                        echo "<tr>";
                                                            echo "<td>".$value['NumMov']."</td>";
                                                            echo "<td>".$value['FechaOperacion']."</td>";
                                                            echo "<td>".$value['Concepto']."</td>";
                                                            echo "<td>$ ".number_format($value['Importe'], 2)." MN"."</td>";
                                                            echo "<td>".$value['Tienda']."</td>";
                                                            echo "<td>".$value['ControlInterno']."</td>";
                                                            echo "<td><a target='_blank' href='comprobante.php?referencia=".$referencia."&numcontrato=".$value['NumContrato']."&nummov=".$value['NumMov']."'><button class='btn btn-danger'>Mostrar</button></a></td>";
                                                        echo "</tr>";
                                                    }
                                                    else {
                                                        echo "<script>Swal.fire({icon: 'error', title: 'Error...', text: 'Sin coincidencias', footer: '<a>Verifique los datos y vuelva a intentarlo</a>'});</script>";
                                                    }
                                                }
                                            }
                                            else {
                                                echo "<script>Swal.fire({icon: 'info', title: 'Oops...', text: 'Inconsistencia de información', footer: '<a>Hubo problemas para localizar su petición</a>'});</script>";
                                            }
                                            curl_close($ch);
                                        }
                                        else {
                                            echo "<script>Swal.fire({icon: 'error', title: 'Referencia no registrada', text: 'Servicio suspendido', footer: '<a>Llene nuestro formulario de registro para ver su historial</a>'});</script>";
                                        }
                                    }
                                    else {
                                        if (empty($referencia)==0 or empty($validacion1)==0){
                                            echo "<H3> <font color='#ca1c1c'>Debe de proporcionar ambos datos solicitados. Vuelva a intentar</font></H3>";
                                        }
                                    }
                                ?>
                            </tbody>
                        </table>                    
                        
                    </div>
                    <div class="card-footer text-muted" style="text-align: center; vertical-align: middle;">
                        <?php echo $administracion; ?>
                    </div>
                </div>          
            </div>
        </div>
    </div>

    <div class="imagenytexto my-4">
        <img src="lib/email.jpg" width=100% height=700>
        <div class="textocentrado-negro1"><h1><b>Cambia tus ticket por comprobantes de pago</b></h1></div>
        <div class="textocentrado-negro2"><h4>Para recibir tus comprobantes de manera automática, es necesario registrarte.</h4></div>
        <div class="boton1">
            <button type="button" onclick="location.href='registro_comprobanteoxxo.php'" class="btn btn-danger" data-bs-toggle="button" aria-pressed="false" autocomplete="off">Registrate</button>
        </div>
    </div>

    <div class="modal" id="muestrareferencia">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ticket de pago <img src="lib/Oxxo_Logo.png" alt="" width="50" height="30"></h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body" >
                    <center>
                        <img src="lib/referencia.jpg" alt="" width="450" height="550">
                    </center>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

<?php include "footer.php";?>