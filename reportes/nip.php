<?php 
include("head.php");
// include("header.php");

// $("body").css("background-color", "#919191");
//     $("body").css("background-blend-mode", "screen");

echo '
<script>
    $("body").css("background-image", "var(--RinteraBackground)");
    $("body").css("background-size", "200%");
    
</script>
';



echo '  <div id="Login">
    
    
            <div id="FormNIP" class="form-signin" style="text-align:center;" >    
                <b>RINTERA: Es necesario actualizar tu NIP:<br></b>                
                
                <label for="txtNIPnew" class="sr-only">Nuevo NIP</label><br>
                <input type="password" id="txtNIPnew" name="txtNIPnew" class="form-control" placeholder="Nuevo NIP" required>
                <br>
                <buttom name="FormLogin"  class="btn btn-lg btn-primary btn-block" onclick="Guardar();" >Guardar</buttom>
                <br><br>
            </div>

            <div id="ResultadoNIP">
            </div>
    
            </div>';





?>

<script>
function Guardar(){
 
    nip = $('#txtNIPnew').val();
    if (nip == ''){
        $.toast({
                heading: 'Error',
                text: 'Escribe un nip',
                showHideTransition: 'slide',
                icon: 'error'
            })
    }else {
        $('#PreLoader').show();
        $.ajax({
            url: 'nip_data.php',
            type: 'post',
            data: {
                nip:nip
            },
            success: function(data) {
                $('#ResultadoNIP').html(data);
                $('#PreLoader').hide();
                
            }
        });
    }
}
</script>
<?
include ("footer.php");
?>
