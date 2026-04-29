<?php
require("config.php");
require("components.php");

$nitavu = VarClean($_POST['nitavu']);
$IdApp = VarClean($_POST['IdApp']);

$MiApp = Preference($IdApp,$nitavu,'');
$IdFavorite = 0;
if ($MiApp == 'NoR'){ //No registrada
    $IdFavorite = 1;
} else{
    if ($MiApp == '0') { //No Favorita
        $IdFavorite = 1;
    } else {// Favorita
        $IdFavorite = 0;
    }
}



if (PreferenceUpdate($IdApp, $nitavu, '',$IdFavorite)==TRUE){
    Toast("Ahora ".app_nombre($IdApp)." - ".$IdApp." es una de tus favoritas",0,"");
    if ($IdFavorite == 0){
        echo '<script>	
        $("#fav_'.$IdApp.'").attr("src","icon/favorite0.png");
    </script>';
    } else {
        echo '<script>	
        $("#fav_'.$IdApp.'").attr("src","icon/favorite1.png");
    </script>';
    }
    
} else {
    Toast("Error al añadirla como aplicacion favorita ".$IdApp,2,"");
}


?>