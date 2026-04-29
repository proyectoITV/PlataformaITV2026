<?php
require("lib/funciones.php");
 $IdFoto = rand(1, 5);
 // echo "background-image: url('img/wallpaper/".$IdFoto.".jpg');";
 $Foto = "img/wallpaper/".$IdFoto.".jpg";
 
 // $Size = rand(150, 200);
 // SonidoBoop();

 echo "
 <script>

	 $('body').fadeTo('slow', 1, function()
	 {
    	$(this).css('background-image', 'url(' + '".$Foto."' + ')');
    	
    	 	
	}).delay(1000).fadeTo('slow', 1);

 	
 </script>";

 // $(this).css('background-size', '".$Size."%');
 //    	$(this).css('background-color', '#717070');
?>

