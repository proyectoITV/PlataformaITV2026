<?php
/*FUNCIONES PERSONALIZADAS */


/*eJEMPLO */
function mifuncion($variable){
require("config.php"); /*No mover*/

$sql = "SELECT * FROM empleados WHERE nitavu='".$variable."'";
$rc= $conexion -> query($sql);
	if($f = $rc -> fetch_array())
	{
		return $f['nombre'];
							
	}
	else
	{
		return FALSE;
	}
/* Return regresa el valor a la funcion*/	
}

function listapaquetes($listaids,$tabla){


	
}


function buscaidconcepto($campo, $tabla,$campoigual, $idconcepto){
	require("config.php");
	$sql="";
	$sql="select ".$campo." as descripcion from ".$tabla." where ".$campoigual."=".$idconcepto;
	//echo $sql;
	$rr=$Vivienda->query($sql);
	if ($rrr=$rr->fetch_array()){
		return $rrr['descripcion'];
		//return $sql;
	}else{
		return FALSE;
	}
}

//paquete material
         /* listapaq = cPrograma.ListaIdPaqueteMat
           Do While listapaq <> ""
                pos = InStr(1, listapaq, ",")
                If pos > 0 Then
                    idpaq = Mid(listapaq, 1, pos - 1)
                Else
                    idpaq = listapaq
                    listapaq = ""
                End If
                Dim numpaq As Integer
                numpaq = idpaq - 1
                If idpaq <> 0 Then LstPaquetes.Selected(numpaq) = True
                'marcar el valor id de la lista??
                listapaq = Mid(listapaq, pos + 1, Len(listapaq))
           Loop */

           
         /*   
         $mystring = $f['ListaIdPaqueteMat'];
         $findme   = ',';
         $listapaquetes="";
         $tablabusqueda="PAQUETEMATERIAL";
         //$pos = strpos($mystring, $findme);
           
         while ($mystring !=""){
            $pos = strpos($mystring, $findme);
           // Nótese el uso de ===. Puesto que == simple no funcionará como se espera
           // porque la posición de 'a' está en el 1° (primer) caracter.
           if ($pos === false) {
               //echo "La cadena '$findme' no fue encontrada en la cadena '$mystring'";
               $dato=$mystring;
               $listapaquetes=$mystring;
               $mystring="";
             
           } else {
               $dato=substr($mystring, 0, $pos-1);
               echo $dato;
               print_r $dato;
               //echo "La cadena '$findme' fue encontrada en la cadena '$mystring'";
               //echo " y existe en la posición $pos";
           }
           $sql="";
           $sql="select * from ".$tablabusqueda." where IdPaqueteMaterial=".$dato;
           echo $sql;
           //$pm= $Vivienda -> query($sql);
           //$r_count = $pm -> num_rows;
           //echo $r_count;
            //$paq = $pm -> fetch_array();
           $listapaquetes=$paq['PaqueteMaterial'].',';
           $mystring=substr($mystring,$pos+1,strlen($mystring));
        } */
