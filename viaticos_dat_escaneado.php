<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
require("viaticos_fun.php");
// require_once("lib/flor_funciones.php");

$IdViatico = VarClean($_POST['IdViatico']);

$ArchivoEscaneado = viaticos_pdf($IdViatico);
if ($ArchivoEscaneado<>''){
    echo "<a title='Haz Clic aqui para descargar' href='".$ArchivoEscaneado."' download='".EasyName("Viatico",4)."'>"."<img src='icon/pdf.png' style='width:32px; cursor:pointer;'>"."</a>";
} else {
    echo ""."<img src='icon/pdf2.png' style='width:32px;'>"."";
}

?>
