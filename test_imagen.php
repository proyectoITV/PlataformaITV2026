<?php
$archivo="img/digital.jpg";
header("Content-type: image/jpeg");
readfile($archivo);


// * Otra opcion seria guardar desde el form donde se suba el tipo
// eso lo obtienes con   $_FILES["nombredelinput"]["type"];
//lo guardarias en donde guardas la tabla de archivos y despues lo escribirias en el header("Conten-type: ".$f['tipo].")"
?>
