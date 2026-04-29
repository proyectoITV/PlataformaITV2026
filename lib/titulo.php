	<?php 
	
		$titulo="[".$red."]";
		if (isset($nitavu)){
			$titulo = $titulo."[".$nitavu."]";
		}
		$titulo = $titulo.".".$versiondeplataforma.".".$pyme_text; 
		echo $titulo;
	?>