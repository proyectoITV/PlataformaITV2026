<?php
  session_start();  
  echo   "1".$_SESSION['nitavu'];
  session_regenerate_id();
echo   "2".$_SESSION['nitavu'];
?>