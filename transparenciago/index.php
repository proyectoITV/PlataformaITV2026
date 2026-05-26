<?php
include("seguridad.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transparencia Go</title>
    <script src="lib/jquery-3.3.1.js"></script> 	
	<link rel="stylesheet" href="estilo.css<?php echo '?'.time();?>" />
	<link rel="stylesheet" href="lib/jquery.toast.min.css">
	<script type="text/javascript" src="lib/jquery.toast.min.js"></script>
	<link rel="stylesheet" type="text/css" href="lib/datatables.min.css"/> 
	<script type="text/javascript" src="lib/datatables.min.js"></script>
	<script src="lib/jquery.modalpdz.js"></script> <link rel="stylesheet" href="lib/jquery.modalcsspdz.css" />
	<style>
		/* Custom Modal Glassmorphism */
		#Archivos {
			background: rgba(255, 255, 255, 0.95) !important;
			backdrop-filter: blur(15px);
			-webkit-backdrop-filter: blur(15px);
			border-radius: 20px !important;
			border: 1px solid rgba(255, 255, 255, 0.3) !important;
			box-shadow: 0 15px 35px rgba(0,0,0,0.2) !important;
			padding: 30px !important;
			max-width: 500px !important;
		}
		#Archivos h1 {
			color: #59141b;
			font-family: 'Open Sans', 'Helvetica Neue', sans-serif;
			font-weight: bold;
			font-size: 24px;
			margin-top: 0;
			margin-bottom: 25px;
			text-align: center;
			border-bottom: 2px solid #59141b;
			padding-bottom: 10px;
		}
		.modern-form-group {
			margin-bottom: 20px;
			text-align: left;
		}
		.modern-form-group label {
			display: block;
			font-weight: 600;
			color: #333;
			margin-bottom: 8px;
			width: 100%;
			font-family: 'Open Sans', sans-serif;
			font-size: 14px;
		}
		.file-upload-wrapper {
			position: relative;
			width: 100%;
			height: 60px;
			border: 2px dashed #b59378;
			border-radius: 10px;
			display: flex;
			align-items: center;
			justify-content: center;
			background: rgba(181, 147, 120, 0.1);
			transition: all 0.3s ease;
			cursor: pointer;
		}
		.file-upload-wrapper:hover {
			background: rgba(181, 147, 120, 0.2);
			border-color: #59141b;
		}
		.file-upload-wrapper input[type="file"] {
			position: absolute;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			opacity: 0;
			cursor: pointer;
		}
		.file-upload-text {
			color: #59141b;
			font-weight: bold;
			font-size: 14px;
			pointer-events: none;
		}
		.modern-textarea {
			width: 100%;
			border: 1px solid #ccc;
			border-radius: 10px;
			padding: 12px;
			font-size: 14px;
			font-family: 'Open Sans', sans-serif;
			resize: vertical;
			min-height: 80px;
			transition: border 0.3s ease;
			box-sizing: border-box;
		}
		.modern-textarea:focus {
			border-color: #59141b;
			outline: none;
			box-shadow: 0 0 5px rgba(89, 20, 27, 0.3);
		}
		.modern-btn-submit {
			background: linear-gradient(135deg, #59141b 0%, #892330 100%);
			color: white;
			border: none;
			border-radius: 25px;
			padding: 12px 30px;
			font-size: 16px;
			font-weight: bold;
			cursor: pointer;
			box-shadow: 0 4px 15px rgba(89, 20, 27, 0.4);
			transition: all 0.3s ease;
			width: 100%;
			text-transform: uppercase;
			letter-spacing: 1px;
		}
		.modern-btn-submit:hover {
			transform: translateY(-2px);
			box-shadow: 0 6px 20px rgba(89, 20, 27, 0.6);
		}
		.modern-btn-submit:active {
			transform: translateY(1px);
			box-shadow: 0 2px 10px rgba(89, 20, 27, 0.4);
		}
		#FormSubir {
			background-color: transparent !important;
			padding: 0 !important;
			width: 100% !important;
			box-shadow: none !important;
		}
	</style>
</head>
<body>
    <div id='BarraMenu'>
		<table style='width:100%;'>
			
			<tr>
				
				<td>
				<?php 
				echo "<cite style='color:#892330;'>Generador de Hipervinculos para Transparencia</cite><br>";
				echo "<span style='font-size:11pt; color:#892330'>Bienvenido <b>".nitavu_nombre($nitavu)."</b><br>";
				
				?>
				</td>
				<td>
					
				
				</td>

				<td><img src='img/logo.png' style='width:250px;'></td>
			</tr>

		</table>
		
	
	</div>
	

	<div id='FileList' style='margin-top:60px'>
		<?php



				$sql="
				select * from ArchivosDeTransparencia  where year(fecha)=year(CURDATE())
				";
				echo "<div id='Ayudas' class='container' style='
				background-color: #ffffffb0;
				padding: 20px;
				border-radius: 10px;
				margin-top: 30px;
				
				'>";
				TablaDinamica_MySQL("",$sql, "AyudaLista", "AyudaTabla", "Tabla", 2,"AyudaTabla"); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal
				echo "</div>";
				

				// echo "<table class='tabla ' width=50% style='color:black;' id='Mirame'>";
				// echo "<th width=5%>IdFile</th>";
				// echo "<th width=30%>Nombre del Archivo<br>Descripcion</th>";
				// echo "<th >HiperVinculo</th>";
				// echo "<th width=10%>Info. de Subida</th>";				
				// $r = $conexion -> query($sql); 				
				// while($f = $r -> fetch_array()) 
				// {
				// 	$WebFile="https://plataformaitavu.tamaulipas.gob.mx/transparenciago/files/".$f['IdFile'].".zip";	
				// 	echo "<tr>";
				// 	echo "<td>".$f['IdFile']."</td>";
				// 	echo "<td><b>".$f['FileNombre']."</b>: <br><cite style='font-size:8pt;'>".$f['FileDescripcion']."</cite></td>";
				// 	echo "<td>
				// 	<button onclick='Copiar(this);' 
				// 	style='color:white;'
				// 	title='Haga clic aqui para copiar el Hipervinculo' class='btn btn-Gray'>".$WebFile."</button>
					
					
					
				// 	</td>";
				// 	echo "<td><b>"."(".$f['IdUser'].") ".nitavu_nombre($f['IdUser'])."</b><br>".fecha_larga($f['fecha'])." a ".hora12($f['hora'])."</td>";
				// 	echo "</tr>";
				// }
				// echo "</table>";
		?>

		</div>



	<div id='Mas'>
		<button class='btn btn-Primary'>
			<a href='#Archivos'  rel='modal:open'> <img src='icon/mas2.png' style='width:30px'></a>
		</button>

	</div>

	<div class='modal' id='Archivos'>
		<h1>Subir Archivos PDF</h1>
		<form method='POST' enctype='multipart/form-data' id='FormSubir'>
			<div class="modern-form-group">
				<label>Seleccione uno o varios archivos PDF:</label>
				<div class="file-upload-wrapper">
					<span class="file-upload-text" id="file-upload-text">📁 Haga clic o arrastre sus PDF aquí</span>
					<input type='file' name='archivo[]' id='archivo' accept='.pdf' multiple required onchange="document.getElementById('file-upload-text').innerText = this.files.length + ' archivo(s) seleccionado(s)';">
				</div>
			</div>
			
			<div class="modern-form-group">
				<label>Descripción (aplica a todos los archivos):</label>
				<textarea name='FileDescripcion' class="modern-textarea" placeholder="Escriba una breve descripción..." required></textarea>
			</div>
			
			<div style="margin-top: 30px;">
				<button type='submit' class='modern-btn-submit'>Subir Archivos</button>
			</div>
		</form>
	</div>


	
<div id="preloader" style='background-color:white; color:#4E4E4E; opacity: 0.9; display:none;'>

<div id="loader">
		
		<img src="img/ajax-loader.gif" class='cargando_img' style='width:800px'><br>
		   <span style='
		   color: rgba(0,0,0,0.7);
		margin: 0px;
		margin-top: 0px;
		margin-left: 0px;
		padding: 0px;
		font-size: 8pt;
		margin-top: -200px;
		position: absolute;
		margin-left: -80px;
		font-size: 11pt;
		   '><cite>Cargando</cite><br><b> Espera por favor...</b></span>
</div>
</div>

<script>
$("#FormSubir").on("submit", function(e){
            // alert('Click');
			var filename = $('#archivo').val();
            e.preventDefault();
            var f = $(this);
            var formData = new FormData(document.getElementById("FormSubir"));                
			formData.append("nitavu", "<?php echo $nitavu; ?>");
			formData.append("FileNombre", filename);
            

            $.ajax({
                url: "data_subir.php",
                type: "post",
                dataType: "html",
                data: formData,             
                cache: false,
                contentType: false,
                processData: false,
                beforeSend:function(){
                    $('#preloader').show();
                },
                success:function(data){
                    console.log(data);
					$('#preloader').hide();
					location.reload();
                    $('#R').html(data);
                }
            });
        
        });



function Copiar(element) {
       //creamos un input que nos ayudara a guardar el texto temporalmente
       var $temp = $("<input>");
       //lo agregamos a nuestro body
       $("body").append($temp);
       //agregamos en el atributo value del input el contenido html encontrado
       //en el td que se dio click
       //y seleccionamos el input temporal
       $temp.val($(element).html()).select();
       //ejecutamos la funcion de copiado
       document.execCommand("copy");

	   $.toast('Hipervinculo Copiado ');  

       //eliminamos el input temporal
       $temp.remove();
   }
</script>

<?php
echo "<div id='Salir'><a  href='logout.php' class='btn btn-Warning'>Salir</a></div></span>";

?>
		
<div id='R' style='display:none;'></div>

</body>
</html>
