<?php 
    include "header.php";
    include "lib/variables.php";
?>

<div class="parent my-4">
    <img src="lib/atencion.jpg" alt="" width=100% height=450>
    <div class="textocentrado-blanco1"><h2><b>Atención personalizada</b></h2></div>
    <div class="textocentrado-blanco2"><h4>Personal capacitado para la atención</h4></div>
</div>

<div class="container my-4">
    <div class="container my-4">
        <p align="right"> <input type="button" onclick="location.href='index.php'" class="btn btn-danger" value="Regresar"/> </p>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header" style="background-color: #ddc9a3;">
                    <b>Comprobantes de pago</b>
                </div>
                <div class="card-body">
                    <h2 class="card-title">Registro de beneficiarios</h2>
                    <br>
                    <script lang="JavaScript">
                        function obtiene_numcontrato(control)
                            {
                                var referencia = control.value
                                var numcontrato1 = referencia.substr(4, 11)
                                var numcontrato2 = referencia.substr(3, 12)
                                
                                document.registro.txtnumcontrato.value = obtienecontrato(numcontrato1, numcontrato2)
                                document.registro.txtnombre.value = obtienenombre(numcontrato1, numcontrato2)
                                document.registro.txtprimerapellido.value = obtienepaterno(numcontrato1, numcontrato2)
                                document.registro.txtsegundoapellido.value = obtienematerno(numcontrato1, numcontrato2)
                                
                                // "<?php 
                                //     include "lib/variables.php";
                                //     $ch = curl_init();
                                //     $peticion="http://".$nomservidor."/".$nomwebservice."?method=GET&token=".$token."&sql=select%20*%20from%20Vivienda_Ws_PagosOXXO%20where%20numcontrato=%2706784106463%27%20or%20numcontrato%20=%20%27006784106463%27";
                                //     $array_options = array(CURLOPT_URL=>$peticion, CURLOPT_RETURNTRANSFER=>true,   );
                                //     curl_setopt_array($ch,$array_options);
                                //     $resp = curl_exec($ch);
                                //     $final_decoded_data = json_decode($resp,true);
                                //     if(is_array($final_decoded_data)){
                                //         foreach ($final_decoded_data as $value) {
                                //             if (empty($value['NumMov'])==0){
                                //                 echo $value['NumContrato'];
                                //             }
                                //             else {
                                //                 echo "NOLOCALIZADO";
                                //             }
                                //         }
                                //     }
                                //     else {
                                //         echo "NOCONEXION";
                                //     }
                                //     curl_close($ch);
                                // ?>";
                        }
                    </script>
                    <form name="registro" id="registro" action="" method="post">
                        <div class="table-responsive">
                            <table style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <td style="width: 33%;">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Número de referencia OXXO</label>
                                                <a href="#!" data-bs-toggle="modal" data-bs-target="#muestrareferencia">
                                                    <img src="lib/ayuda.png" alt="" width="30" height="30">
                                                </a>
                                                <input type="text" class="form-control" name="txtreferencia" id="txtreferencia" onfocus= "" onblur="obtiene_numcontrato(this)">
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
                                        </td>
                                        <td style="width: 33%;">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Número de contrato ITAVU</label>
                                                <input type="text" class="form-control" name="txtnumcontrato" id="txtnumcontrato" style="background-color: #bfbfbf;" readonly >
                                            </div>
                                        </td>
                                        <td style="width: 34%;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>


                            <table style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <td style="width: 33%;">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Nombre(s)</label>
                                                <input type="text" class="form-control" name="txtnombre" id="txtnombre" style="background-color: #bfbfbf;" readonly>
                                            </div>                                            
                                        </td>
                                        <td style="width: 33%;">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Primer apellido</label>
                                                <input type="text" class="form-control" name="txtprimerapellido" id="txtprimerapellido" style="background-color: #bfbfbf;" readonly>
                                            </div>                                            
                                        </td>
                                        <td style="width: 34%;">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Segundo apellido</label>
                                                <input type="text" class="form-control" name="txtsegundoapellido" id="txtsegundoapellido" style="background-color: #bfbfbf;" readonly>
                                            </div>                                            
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <td style="width: 66%;">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Correo electrónico</label>
                                                <input type="email" class="form-control" name="txtemail" id="txtemail" placeholder="micorreo@dominio.com">
                                            </div>                                            
                                        </td>
                                        <td style="width: 34%;">
                                            <div class="mb-3">
                                                <label for="" class="form-label">Teléfono</label>
                                                <input type="text" class="form-control" name="txttelefono" id="txttelefono" maxlength="10" required>
                                            </div>                                            
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <table style="width: 100%;">
                                <tbody>
                                    <tr>
                                        <td style="width: 33%;">
                                            <div class="mb-3" style="height: 330px;">
                                                <label for="" class="form-label">Municipio donde reside</label>
                                                <select multiple class="form-select form-select-lg" name="cbomunicipios" id="cbomunicipios" style="height: 300px;">
                                                    <option selected>Seleccione un elemento</option>
                                                    <option value="1">ABASOLO</option>
                                                    <option value="2">ALDAMA</option>
                                                    <option value="3">ALTAMIRA</option>
                                                    <option value="4">ANTIGUO MORELOS</option>
                                                    <option value="5">BURGOS</option>
                                                    <option value="6">BUSTAMANTE</option>
                                                    <option value="7">CAMARGO</option>
                                                    <option value="8">VILLA DE CASAS</option>
                                                    <option value="9">MADERO</option>
                                                    <option value="10">CRUILLAS</option>
                                                    <option value="11">GOMEZ FARIAS</option>
                                                    <option value="12">GONZALEZ</option>
                                                    <option value="13">GÜEMEZ</option>
                                                    <option value="14">GUERRERO</option>
                                                    <option value="15">DIAZ ORDAZ</option>
                                                    <option value="16">HIDALGO</option>
                                                    <option value="17">JAUMAVE</option>
                                                    <option value="18">JIMENEZ</option>
                                                    <option value="19">LLERA</option>
                                                    <option value="20">MAINERO</option>
                                                    <option value="21">MANTE</option>
                                                    <option value="22">MATAMOROS</option>
                                                    <option value="23">MENDEZ</option>
                                                    <option value="24">MIER</option>
                                                    <option value="25">MIGUEL ALEMAN</option>
                                                    <option value="26">MIQUIHUANA</option>
                                                    <option value="27">NUEVO LAREDO</option>
                                                    <option value="28">NUEVO MORELOS</option>
                                                    <option value="29">OCAMPO</option>
                                                    <option value="30">PADILLA</option>
                                                    <option value="31">PALMILLAS</option>
                                                    <option value="32">REYNOSA</option>
                                                    <option value="33">RIO BRAVO</option>
                                                    <option value="34">SAN CARLOS</option>
                                                    <option value="35">SAN FERNANDO</option>
                                                    <option value="36">SAN NICOLAS</option>
                                                    <option value="37">SOTO LA MARINA</option>
                                                    <option value="38">TAMPICO</option>
                                                    <option value="39">TULA</option>
                                                    <option value="40">VALLE HERMOSO</option>
                                                    <option value="41">VICTORIA</option>
                                                    <option value="42">VILLAGRAN</option>
                                                    <option value="43">XICOTENCATL</option>
                                                    <option value="44">RIO BRAVO (Nvo Progreso)</option>
                                                </select>
                                            </div>
                                        </td>
                                        <td style="width: 67%;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <button name="almacena_comprobanteoxxo" type="submit" class="btn btn-danger">Almacenar información</button>
                        </div>
                    </form>
                    
                    <?php include("registro_comprobanteoxxo_insert.php"); ?>
                </div>
                <div class="card-footer text-muted" style="text-align: center; vertical-align: middle;">
                    <?php echo $administracion; ?>
                </div>
            </div>
        </div>
    </div>
</div>    

<?php include "footer.php";?>

<script>
    function obtienecontrato(referencia1, referencia2){
            $.ajax({
                url: "desglosacontrato.php",
                type: "get",
                data: {referencia1: referencia1, referencia2:referencia2},
                success: function(data){
                    $('#txtnumcontrato').val(data);     
                }
            });
    }

    function obtienenombre(referencia1, referencia2){
            $.ajax({
                url: "desglosanombre.php",
                type: "get",
                data: {referencia1: referencia1, referencia2:referencia2},
                success: function(data){
                    $('#txtnombre').val(data);     
                }
            });
    }

    function obtienepaterno(referencia1, referencia2){
            $.ajax({
                url: "desglosapaterno.php",
                type: "get",
                data: {referencia1: referencia1, referencia2:referencia2},
                success: function(data){
                    $('#txtprimerapellido').val(data);     
                }
            });
    }

    function obtienematerno(referencia1, referencia2){
            $.ajax({
                url: "desglosamaterno.php",
                type: "get",
                data: {referencia1: referencia1, referencia2:referencia2},
                success: function(data){
                    $('#txtsegundoapellido').val(data);     
                }
            });
    }
</script>