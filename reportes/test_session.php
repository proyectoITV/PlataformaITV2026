<?php
  session_start();
  session_regenerate_id();    
  echo "Id: ".session_id();            


  $_SESSION['nitavu'] = "admin";
  
    echo   $_SESSION['nitavu'];
?>