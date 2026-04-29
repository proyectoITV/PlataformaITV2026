<?php
//include (".//seguridad.php"); 
include ("./lib/body_head.php");
include ("./lib/body_menu.php");


// contenido:
historia ($nitavu,"Vio Actualizar el NIP");	
?>

<?php 

$id_aplicacion ="ap01"; //Id de la aplicacion a cargar
//if (sanpedro($id_aplicacion, $nitavu)==TRUE){
	echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";




	
	echo '
	<div>
	<label for="nip_old"> NIP Actual:
		<input type="text" name="nip_old"> 
	</label></div>

	<div>
	<label for="nip_new"> NIP Nuevo:
		<input type="text" name="nip_new"> 
	</label></div>
	
	<div>
	<input type="submit" value="Guardar" class="Mbtn btn-default">
	</div>
</form>
</div></div>

	';

echo "<div id='consejos' style='margin:40px; padding:10px;'>
			<b class='tmediano ejecutandose'>CONSEJOS DE SEGURIDAD</b>
		<lu>
			<li>Elige un NIP (contraseña) que personalmente sea fácil de identificar pero difícil de adivinar para otros. No optes por fechas de nacimiento, aniversarios de boda o números telefónicos, ya que son obvios y podrían ocasionar un robo de identidad.</li>

			<li>Tiene una longitud maxima de 20 caracteres, puedes incluir números y letras, mayusculas y minusculas</li>

			<li>No guardes contraseña en el navegador si no es tu dispositivo personal</li>

			<li>IMPORTANTE: todas las operaciones realizadas con tu nip son tu responsabilidad. </li>

			</li>Para cualquier duda llama al Dpto. de Informatica</li>
		</lu>
		
		</div>";

//lse {mensaje("No tiene acceso a esta aplicacion",'');}

?>







<?php
include ("./lib/body_footer.php");
?>