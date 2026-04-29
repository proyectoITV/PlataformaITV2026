<?php
$FechaNacimiento = TramiteFechaNacimiento($idTramite);
$edad = CalcularEdad($FechaNacimiento);
$acta = TramiteActaHijos($idTramite);

if (($edad < 30) and ($acta == FALSE or $acta=='') ){ // Ejemplo de Test, la variable $Edad esta declarada en archivo donde se esta incluyendo este
    $Continuo = 'ERROR: No puedes continuar con la solicitud ya que el requisito es que personas solteras menores de 30 años no se admiten. A excepciòn de madres y padres solteros que demuestren con acta de nacimiento tener hijos(as)';
  // $Continuo='FALSE';
}else{ 
    $Continuo = 'TRUE';
    
}


?>