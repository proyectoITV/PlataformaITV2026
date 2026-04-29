<?php
require ("config.php");
require ("lib/funciones.php");

if (isset($_GET['user'])){$usuario = $_GET['user'];}

$n= misnotificaciones_n($usuario);


if ($n<=0){
    echo "<span     id='NotisW'
    title='Haz clic aquí para ver tus notificaciones'
    onclick='barra_contactos();'  class='parpadear' style='
            cursor:pointer; text-align:center; width:50px;
'>0</span>";
}else
{
    // echo "<img src='icon/chat_top2.png' style='opacity: 1; cursor: pointer; z-index: 10; width: 40px; height: 40px;' class='parpadear' onclick='barra_contactos();' >";echo "<img src='icon/chat_top2.png' style='opacity: 1; cursor: pointer; z-index: 10; width: 40px; height: 40px;' class='parpadear' onclick='barra_contactos();' >";
    
    echo "<span  id='NotisW'
    title='Haz clic aquí para ver tus notificaciones'
     onclick='barra_contactos();'  class='parpadear' style='
     cursor:pointer; text-align:center; width:50px;
           
'>";
//echo '<audio src="audios/mensaje.wav" autoplay preload="auto" ></audio>';
echo $n;
echo "</span>";
}


// if ($n<=0)
//     {echo "<div id='misnotificaciones' class='notifi_cero'>".$n."</div>";}
// else
// 	{echo "<div id='misnotificaciones' class='notifi_activas'>".$n."</div>";}

?>
