<?php

        $ancho=60; $n=134; $a=0; $b=$ancho; $lineas=3; $salto=5; 
        for ($i = 1; $i <= $lineas; $i++) {
            //$pdf->Text(8, $n, ''.substr($f['descripcion'],$a,$b).""); 
            echo "a=".$a." | b=".$b." | n=".$n." | <br>";
            $n = $n + $salto; $a=$b; $b = $b + $ancho;
        }

?>        