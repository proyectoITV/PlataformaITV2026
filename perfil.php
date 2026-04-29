<?php
require ("./lib/body_head.php");
require ("./lib/body_menu.php");
// contenido:
?>
<?php
//PROCESO PARA TOCAR LA PUERTA DE SAN PEDRO
$idDepartamento=nitavu_dpto($nitavu);
$id_aplicacion ="Perfil";
$nivel =aplicacion_nivel($id_aplicacion, $nitavu);
 echo "<div id='AppDetalle'>".app_detalle($id_aplicacion, $nitavu)."</div>";
	
?>




<form id="FormUser"  name="FormUser" enctype='multipart/form-data'  method='POST'>

  <div class="form-group">
	
	<?php echo ponerfoto("fotos/".$nitavu.".jpg",'FotoPerfil'); ?>
    <div class="custom-file ">
		<input type="file" class="custom-file-input" id="archivo" class="form-control" name="archivo" accept="image/jpeg">
		<label class="custom-file-label" for="archivo">Archivo a Subir</label>
	</div>
  </div>

  	<div class="form-group">

	  	<div class="form-group col-12">
		  	<fieldset disabled>
				<label for="Nombre2">Nombre</label>
				<input type="text" class="form-control" id="Nombre2" value="<?php echo nitavu_nombre($nitavu);?>">
			</fieldset>
		</div>

		<div class="form-group col-12">
		  	<fieldset disabled>
				<label for="Dpto">Departamento</label>
				<input type="text" class="form-control" id="Dpto" value="<?php echo nitavu_dpto_nombre($nitavu);?>">
			</fieldset>
		</div>
	</div>
	
	<div class="form-group">	
		<label for="Correo">Correo Electronico:</label>
		<input type="mail" class="form-control" id="Correo" value="<?php echo nitavu_correo($nitavu);?>">
			
	</div>

	<div class="form-group">	
		<label for="Movil">Telefono Personal:</label>
		<input type="tel" class="form-control" id="Movil" value="<?php echo nitavu_celular($nitavu);?>">
			
	</div>

	<div class="form-group">	
		<label for="Nacimiento">Fecha de nacimiento:</label>
		<input type="date" class="form-control" id="Nacimiento" value="<?php echo nacimiento($nitavu);?>">			
	</div>

	<div class="form-group">	
		<label for="Profesion">Profesion:</label>
		<input type="text" class="form-control" id="Profesion" value="<?php echo nitavu_profesionfull($nitavu);?>">			
	</div>


	<!-- <div class="form-group" style='background-color:orange; color:white;'>	
		<label for="Profesion">NIP:</label>
		<input type="text" class="form-control" id="NIP" value="<?php echo nitavu_nip($nitavu);?>">			
	</div> -->


	<div class="form-group">	
		<input type='submit' value='Guardar' class='btn btn-success'>
		
		
	</div>



</form>
<script>
	 $("#FormUser").on("submit", function(e){
            // alert('Click');
            e.preventDefault();
			Correo = $('#Correo').val();
			Movil = $('#Movil').val();
			Nacimiento = $('#Nacimiento').val();
			Profesion = $('#Profesion').val();
		//	NIP = $('#NIP').val();
			
            var f = $(this);
            var formData = new FormData(document.getElementById("FormUser"));
                formData.append("Correo", Correo);
				formData.append("Movil", Movil);
				formData.append("Nacimiento", Nacimiento);
				formData.append("Profesion", Profesion);
				//formData.append("NIP", NIP);
                formData.append("nitavu", "<?php echo $nitavu; ?>");
                

            $.ajax({
                url: "perfil_data.php",
                type: "post",
                dataType: "html",
                data: formData,             
                cache: false,
                contentType: false,
                processData: false,
                beforeSend:function(){
                    // $('#loader').html('<img src="icon/loaderDir.gif" style="width:80%; border-radius:15px;">Guardando...');
                    $('#preloader').show();
                },
                success:function(data){
                    
                    $('#preloader').hide();
                    $('#R').html(data);
                }
            });
        
        });
	</script>

<?php
include ("./lib/body_footer.php");
?>