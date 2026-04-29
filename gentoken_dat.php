<?php
require("config.php");
require("seguridad.php");
require("var_clean.php");
require("lib/funciones.php");
// require("lib/gentoken.php");
// require_once("lib/flor_funciones.php");

// $search = VarClean($_POST['search']);
$TokenInput = $_POST['TokenInput'];
$idapp = $_POST['idapp'];
GenToken_EquipoSave($TokenInput, $idapp);
GenToken_Save($TokenInput);

if (GenToken_Check($TokenInput)==TRUE){

} else {
    echo "
    <script>
    var TokenInput = window.prompt('Token Invalido, Introduzaca un token Valido:', '".$TokenInput."');
    window.location.href = '?tkn='+TokenInput
    </script>
    ";
}



?>