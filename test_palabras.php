<?php


function cortaFrase($frase, $maxPalabras, $f) {
    $noTerminales = ["de"];
    $palabras = explode(" ", $frase);
    $numPalabras = count($palabras);
    if ($f == 0){
        if ($numPalabras > $maxPalabras) {
            $offset = $maxPalabras - 1;
            while (in_array($palabras[$offset], $noTerminales) && $offset < $numPalabras) { $offset++; }
            return implode(" ", array_slice($palabras, 0, $offset+1));
        } 
    } else {
        if ($numPalabras > $maxPalabras) {
            $offset = $maxPalabras - 1;
            while (in_array($palabras[$offset], $noTerminales) && $offset > $numPalabras) { $offset++; }
            return implode(" ", array_slice($palabras, $maxPalabras, $offset+4));
        } 
    }

    return $frase;
}


$nombre = "Juan Cepeda";

$Fraccion = cortaFrase($nombre,2,0);
$Resto = cortaFrase($nombre,2,1);


echo "<b>".$Fraccion."</b> - ".$Resto;

?>