<?php 
    // pagina para obtener mas ejemplos de Swal.fire
    // https://sweetalert2.github.io/
    include "conexionbd.php";

    if (isset($_POST['almacena_comprobanteoxxo'])) {
        $referencia = trim($_POST['txtreferencia']);
        $numcontrato = trim($_POST['txtnumcontrato']);
        $nombre = strtoupper(trim($_POST['txtnombre']));
        $primerapellido = strtoupper(trim($_POST['txtprimerapellido']));
        $segundoapellido = trim($_POST['txtsegundoapellido']);
        $correoelectronico = trim($_POST['txtemail']);
        $telefono = trim($_POST['txttelefono']);
        $idmunicipio = $_POST['cbomunicipios'];

        if ($numcontrato<>'NOCONEXION' or isset($numcontrato)==false){
            $sql = "select referencia from comprobantesoxxo_registro where referencia = '".$referencia."'";
            $r = $conexion -> query($sql);
            $row_cnt = $r->num_rows;
            if ($row_cnt>0) {
                    echo "<script>Swal.fire({icon: 'warning', title: 'Oops...', text: 'Beneficiario ya registrado',footer: '<a>NO ES NECESARIO REALIZAR NUEVO REGISTRO</a>'});</script>";
                }
            else {
                if ($numcontrato<>'NOLOCALIZADO'){
                    $consulta = "Insert into comprobantesoxxo_registro (referencia, numcontrato, nombres, primerapellido, segundoapellido, email, telefono, idmunicipio) values ('$referencia', '$numcontrato', '$nombre', '$primerapellido', '$segundoapellido', '$correoelectronico', '$telefono', $idmunicipio)";
                    $resultado = mysqli_query($conexion, $consulta);
            
                    if ($resultado) {
                        echo "<script>Swal.fire({position: 'top-end', icon: 'success', title: 'Registro almacenado', showConfirmButton: false, timer: 2500})</script>";
                    }
                    else {
                        echo "<script>Swal.fire({icon: 'error', title: 'Error...', text: 'Fallo al grabar', footer: '<a>Hubo problemas para su almacenamiento</a>'});</script>";
                    }
                }
                else {
                    echo "<script>Swal.fire({icon: 'error', title: 'Fallo en referencia', text: 'No coinciden con convenio OXXO', footer: '<a>La referencia proporcionada no pertenece a ITAVU</a>'});</script>";
                }
            }
        }
        else {
            if ($numcontrato=='NOCONEXION'){
                echo "<script>Swal.fire({icon: 'error', title: 'Error...', text: 'Error de conexión', footer: '<a>No existe conexión con el servidor</a>'});</script>";            
            }
            else {
                if (isset($numcontrato)==true){
                    echo "<script>Swal.fire({icon: 'error', title: 'Error...', text: 'Falta información', footer: '<a>Complemente la información y vuelva a intentarlo</a>'});</script>";
                }
            }
        }
    }
?>