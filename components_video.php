<?php
if ($_GET['src']){
    // echo $_GET['src'];
    echo '
            <video src="'.$_GET['src'].'" controls style="width:100%; height:100%;">
                <p>Su navegador no soporta vídeos HTML5.</p>
            </video>';
}

?>