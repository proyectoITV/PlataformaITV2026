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
				select * from ArchivosDeTransparencia
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
		<form method='POST' enctype='multipart/form-data' id='FormSubir' style='width:100%; background-color:transparent;'>
		<div style='color:black;'>
		<!-- accept=".zip" -->
		<span>Seleccione el archivo PDF <input type='file' name='archivo'  id='archivo' accept='.pdf' required></span>
		<span>Descripcion:<br> <textarea name='FileDescripcion' style='width:100%;' required></textarea></span><br>
		<center><input type='submit' class='btn btn-Primary' value='Subir'></center>
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
