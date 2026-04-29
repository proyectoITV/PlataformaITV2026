<?php
// error_reporting(0);
// require("src/config.php");

if (Conecta('http://172.16.91.5:8120')==TRUE){
    // header('Location: http://172.16.91.5:8120/login.php');
    echo "<script>
    window.location='http://172.16.91.5:8120/login.php';
    </script>";
    

} else {
    echo "Error al conectar con http://172.16.91.5:8120 <br>";
    if (Conecta('http://192.168.159.5')==TRUE){
        // header('Location: http://192.168.159.5/login.php');
        echo "<script>
        window.location='http://192.168.159.5/login.php';
        </script>";
    
    } else {
        echo "Error al conectar con http://192.168.159.5 <br>";
        if (Conecta('http://192.168.158.4')==TRUE){
            // header('Location: http://192.168.158.4/login.php');
            echo "<script>
            window.location='http://192.168.158.4/login.php';
            </script>";
        
        } else {
            echo "Error al conectar con http://192.168.158.4 <br>";
            if (Conecta('http://10.50.15.0')==TRUE){
                // header('Location: http://10.50.15.0/login.php');
                echo "<script>
                window.location='http://10.50.15.0/login.php';
                </script>";
            
            } else {
                // echo "Error al conectar con http://10.50.15.0 <br>";
                echo "<div id='comentarios'><h1><b>Por el momento no esta disponible la plataforma</b>.</h1>        <p><b>Intentelo mas tarde. </b>Recuerde que solo se puede accesar si esta en una red autorizada del Instituto; para mas información comunicarse con el Departamento de Informatica.        al Tel.(834) 318 55 07 Ext. <b>46612</b>;  </p>        </div>";
            //    header('Location: '.$IpDelServidorLocal.'/index2.php'); //<-- Redireccionamos al servidor local
               
            }
        
        }
    
    }

}







function Conecta($IpServer){
    
    
    if (file_get_contents($IpServer."/ping.png", false) === FALSE) {
        return FALSE;
    } else {
        return TRUE;
    }
}
?>