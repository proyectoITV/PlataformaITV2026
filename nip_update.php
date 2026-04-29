<?php include ("./lib/body_head.php"); include ("./lib/body_menu.php"); ?>

<?php
$id_aplicacion = "ap01";


// echo "<script>$('body').css('background-image','url(img/wall_ayuda3.jpg)');</script>";
echo "<script>$('body').css('background-position','top');</script>";
// echo "<script>$('body').css('background-size','120%');</script>";

echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
echo "<script>$('#AppDetalle').css('background-color','rgba(2, 2, 2, 0.41)');</script>";    


	echo "<script>$('body').css('background-color','rgb(225, 225, 225)');</script>";	


echo "<script>$('tr').css('background-color','transparent');</script>";
echo "<script>$('td').css('background-color','transparent');</script>";

?>


<div id='Forma' style='margin:20px;'>
	<div class="mb-3">
		<label for="NipActual" class="form-label">Contraseña actual</label>
		<input type="text" class="form-control" id="NipActual" placeholder="">
	</div>

	<div class="mb-3">
		<label for="NipNuevo1" class="form-label">Contraseña nueva</label>
		<input type="text" class="form-control" id="NipNuevo1" placeholder="">
	</div>

	<div class="mb-3">
		<label for="NipNuevo2" class="form-label">Confirme contraseña</label>
		<input type="text" class="form-control" id="NipNuevo2" placeholder="">
	</div>

	<div class="mb-3">
		<button class="btn-identidad-color1" onclick="NipUpdate();" id='btnActualizar'>Actualizar ahora</button>
	</div>
</div>

<div id='consejos' style='margin:40px; padding:10px; color:#665f5f'>
			<b>CONSEJOS DE SEGURIDAD</b>
		<lu>
			<li>Elige una CONTRASEÑA que personalmente sea fácil de identificar pero difícil de adivinar para otros. No optes por fechas de nacimiento, aniversarios de boda o números telefónicos, ya que son obvios y podrían ocasionar un robo de identidad.</li>
			<li>Tiene una longitud maxima de 20 caracteres, puedes incluir números y letras, mayusculas y minusculas</li>
			<li>No guardes contraseña en el navegador si no es tu dispositivo personal</li>
			<li>IMPORTANTE: todas las operaciones realizadas con tu nip son tu responsabilidad. </li>
			<li>Para cualquier duda llama al Departamento de Informática 8343185516 extensión 46516</li>
		</lu>
</div>



<script>

function NipUpdate(){		                    
    $('#progressbar').show();
	NipActual = $('#NipActual').val();
	NipNuevo1 = $('#NipNuevo1').val();
	NipNuevo2 = $('#NipNuevo2').val();
	
    $.ajax({
    url: "nip_update_dat_save.php",
    type: "post",        
    data: {NipActual: NipActual, NipNuevo1:NipNuevo1, NipNuevo2:NipNuevo2},
    success: function(data){                
        $("#R").html(data+"");     
        console.log('Status...');
        $('#progressbar').hide();
    }
    });

            
}
</script>
<?php include ("./lib/body_footer.php"); ?>