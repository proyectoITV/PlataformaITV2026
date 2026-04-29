<?php
require("unica/seguridad.php"); 
require_once("unica/config.php");
require_once("unica/funciones.php");
require_once("unica/flor_funciones.php");

error_reporting(0); //<-- para simular produccion


 //Parametros
 if ( isset($_GET['IdDelegacion']) and isset($_GET['IdPrograma']) and isset($_GET['Saldo']) and isset($_GET['Moratorios'])  and isset($_GET['Fora']) and isset($_GET['Hasta']) and isset($_GET['Desde']) ){
    $IdDelegacion = $_GET['IdDelegacion'];
    $Delegacion = DelegacionNombre($IdDelegacion);
    $IdPrograma = $_GET['IdPrograma'];
    $Programa = ProgramaNombre($IdPrograma);
    $Saldo = $_GET['Saldo'];
    $Moratorios = $_GET['Moratorios'];
    $Foraneos = $_GET['Fora'];
    $Desde = $_GET['Desde'];
    $Hasta = $_GET['Hasta'];
    if ($Hasta == 0){
        $Hasta = 1000000000; // si va 0 en desde y hasta, mostrar todo, ponemos un numero como limite grande
    }

    $tb= "";
    if ($Saldo == 0 and $IdDelegacion <> "" and $IdPrograma <> "" ) { // Mostrar sin Saldo de la Delegacion y Programa
        if (isset($_GET['Col']) ){
            historia($nitavu, "Entro a la aplicacion Explorador Financiero, buscando contratos saldados en la colonia ".$_GET['Col']." de ".$Delegacion." del Programa ".$Programa);
            $tb = "<h3 style='color:#005BA0;'>Contratos sin Saldo del Programa <b style='color:#B5D130;'>".ProgramaNombre($IdPrograma)."</b> de la Delegacion ".DelegacionNombre($IdDelegacion)." de la Colonia ".$_GET['Col']."</h3>";
            $MSSQL = "SELECT * FROM ( SELECT (select Delegacion from DELEGACIONES WHERE DELEGACIONES.IdDelegacion = Vivienda_InformacionFinanciera.IdDelegacion) as Delegacion,Vivienda_InformacionFinanciera.*,(SELECT NombreCompleto FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS NombreCompleto,(SELECT EstadoCivil FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS EstadoCivil,(SELECT NCElector FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS NElector,(SELECT Colonia FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS Colonia,(SELECT Telefono FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS Telefono,(SELECT Curp FROM Vivienda_DatosGenerales WHERE Folio=Vivienda_InformacionFinanciera.Folio AND IdDelegacion=Vivienda_InformacionFinanciera.IdDelegacion AND IdPrograma=Vivienda_InformacionFinanciera.IdPrograma) AS CURP, ROW_NUMBER() OVER (ORDER BY Vivienda_InformacionFinanciera.NumContrato) as row FROM Vivienda_InformacionFinanciera WHERE saldo<=0 AND IdPrograma=".$IdPrograma." AND IdDelegacion=".$IdDelegacion."  ) a WHERE  Colonia='".$_GET['Col']."'	Order by row";
        } else {
            $tb = "<h3 style='color:#005BA0;'>Contratos sin Saldo del Programa <b style='color:#B5D130;'>".ProgramaNombre($IdPrograma)."</b> de la Delegacion ".DelegacionNombre($IdDelegacion)."</h3>";
            $MSSQL = "SELECT * FROM ( SELECT (select Delegacion from DELEGACIONES WHERE DELEGACIONES.IdDelegacion = Vivienda_InformacionFinanciera.IdDelegacion) as Delegacion, Vivienda_InformacionFinanciera.*,(SELECT NombreCompleto FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS NombreCompleto,(SELECT EstadoCivil FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS EstadoCivil,(SELECT NCElector FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS NElector,(SELECT Colonia FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS Colonia,(SELECT Telefono FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS Telefono,(SELECT Curp FROM Vivienda_DatosGenerales WHERE Folio=Vivienda_InformacionFinanciera.Folio AND IdDelegacion=Vivienda_InformacionFinanciera.IdDelegacion AND IdPrograma=Vivienda_InformacionFinanciera.IdPrograma) AS CURP, ROW_NUMBER() OVER (ORDER BY Vivienda_InformacionFinanciera.NumContrato) as row FROM Vivienda_InformacionFinanciera WHERE saldo<=0 AND IdPrograma=".$IdPrograma." AND IdDelegacion=".$IdDelegacion." ) a WHERE row > ".$Desde." and row <= ".$Hasta." 	Order by row";
            historia($nitavu, "Entro a la aplicacion Explorador Financiero, buscando contratos saldados de ".$Delegacion." del Programa ".$Programa);
        }
    }

    if ($Saldo == 1 and $IdDelegacion <> "" and $IdPrograma <> "" ) { // Mostrar con Saldo de la Delegacion y Programa
        if (isset($_GET['Col']) ){
            historia($nitavu, "Entro a la aplicacion Explorador Financiero, buscando contratos con Saldo en la colonia ".$_GET['Col']." de ".$Delegacion." del Programa ".$Programa);
            $tb = "<h3 style='color:#005BA0;'>Contratos con Saldo del Programa <b style='color:#B5D130;'>".ProgramaNombre($IdPrograma)." </b>de la Delegacion ".DelegacionNombre($IdDelegacion)." de la Colonia ".$_GET['Col']."</h3>";
            $MSSQL = "SELECT * FROM ( SELECT (select Delegacion from DELEGACIONES WHERE DELEGACIONES.IdDelegacion = Vivienda_InformacionFinanciera.IdDelegacion) as Delegacion, Vivienda_InformacionFinanciera.*,(SELECT NombreCompleto FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS NombreCompleto,(SELECT EstadoCivil FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS EstadoCivil,(SELECT NCElector FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS NElector,(SELECT Colonia FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS Colonia,(SELECT Telefono FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS Telefono,(SELECT Curp FROM Vivienda_DatosGenerales WHERE Folio=Vivienda_InformacionFinanciera.Folio AND IdDelegacion=Vivienda_InformacionFinanciera.IdDelegacion AND IdPrograma=Vivienda_InformacionFinanciera.IdPrograma) AS CURP, ROW_NUMBER() OVER (ORDER BY Vivienda_InformacionFinanciera.NumContrato) as row FROM Vivienda_InformacionFinanciera WHERE saldo>0 AND IdPrograma=".$IdPrograma." AND IdDelegacion=".$IdDelegacion." ) a WHERE  Colonia='".$_GET['Col']."'	Order by row";
        }
        else {
            historia($nitavu, "Entro a la aplicacion Explorador Financiero, buscando contratos con Saldo de ".$Delegacion." del Programa ".$Programa);            
            $tb = "<h3 style='color:#005BA0;'>Contratos con Saldo del Programa <b style='color:#B5D130;'>".ProgramaNombre($IdPrograma)." </b>de la Delegacion ".DelegacionNombre($IdDelegacion)."</h3>";
            $MSSQL = "SELECT * FROM ( SELECT (select Delegacion from DELEGACIONES WHERE DELEGACIONES.IdDelegacion = Vivienda_InformacionFinanciera.IdDelegacion) as Delegacion, Vivienda_InformacionFinanciera.*,(SELECT NombreCompleto FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS NombreCompleto,(SELECT EstadoCivil FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS EstadoCivil,(SELECT NCElector FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS NElector,(SELECT Colonia FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS Colonia,(SELECT Telefono FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS Telefono,(SELECT Curp FROM Vivienda_DatosGenerales WHERE Folio=Vivienda_InformacionFinanciera.Folio AND IdDelegacion=Vivienda_InformacionFinanciera.IdDelegacion AND IdPrograma=Vivienda_InformacionFinanciera.IdPrograma) AS CURP, ROW_NUMBER() OVER (ORDER BY Vivienda_InformacionFinanciera.NumContrato) as row FROM Vivienda_InformacionFinanciera WHERE saldo>0 AND IdPrograma=".$IdPrograma." AND IdDelegacion=".$IdDelegacion." ) a WHERE row > ".$Desde." and row <= ".$Hasta." 	Order by row";
        }
    }

    if ($Moratorios == 1 and $IdDelegacion <> ""  ) { // Mostrar solos los que tienen moratorios de la Delegacion y Programa
        if (isset($_GET['Col']) ){
            if ($IdPrograma == '0.0'){//viene de la principal | Mostrar todos los moratorios de la colonia
                $tb = "<h3 style='color:#005BA0;'>Contratos con Moratorio de la Colonia ".$_GET['Col']." de ".DelegacionNombre($IdDelegacion)."</h3>";
                $MSSQL = "SELECT * FROM ( SELECT (select Delegacion from DELEGACIONES WHERE DELEGACIONES.IdDelegacion = Vivienda_InformacionFinanciera.IdDelegacion) as Delegacion, Vivienda_InformacionFinanciera.*,(SELECT NombreCompleto FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS NombreCompleto,(SELECT EstadoCivil FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS EstadoCivil,(SELECT NCElector FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS NElector,(SELECT Colonia FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS Colonia,(SELECT Telefono FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS Telefono,(SELECT Curp FROM Vivienda_DatosGenerales WHERE Folio=Vivienda_InformacionFinanciera.Folio AND IdDelegacion=Vivienda_InformacionFinanciera.IdDelegacion AND IdPrograma=Vivienda_InformacionFinanciera.IdPrograma) AS CURP, ROW_NUMBER() OVER (ORDER BY Vivienda_InformacionFinanciera.NumContrato) as row FROM Vivienda_InformacionFinanciera WHERE Saldo_Moratorio > 0 AND IdDelegacion=".$IdDelegacion."  ) a WHERE  Colonia='".$_GET['Col']."' 	Order by row";
            } else {
                historia($nitavu, "Entro a la aplicacion Explorador Financiero, buscando contratos con Moratorio en la colonia ".$_GET['Col']." de ".$Delegacion." del Programa ".$Programa);
                $tb = "<h3 style='color:#005BA0;'>Contratos con Moratorio del Programa <b style='color:#B5D130;'>".ProgramaNombre($IdPrograma)."</b> de la Delegacion ".DelegacionNombre($IdDelegacion)." de la Colonia ".$_GET['Col']."</h3>";
                $MSSQL = "SELECT * FROM ( SELECT (select Delegacion from DELEGACIONES WHERE DELEGACIONES.IdDelegacion = Vivienda_InformacionFinanciera.IdDelegacion) as Delegacion, Vivienda_InformacionFinanciera.*,(SELECT NombreCompleto FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS NombreCompleto,(SELECT EstadoCivil FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS EstadoCivil,(SELECT NCElector FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS NElector,(SELECT Colonia FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS Colonia,(SELECT Telefono FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS Telefono,(SELECT Curp FROM Vivienda_DatosGenerales WHERE Folio=Vivienda_InformacionFinanciera.Folio AND IdDelegacion=Vivienda_InformacionFinanciera.IdDelegacion AND IdPrograma=Vivienda_InformacionFinanciera.IdPrograma) AS CURP, ROW_NUMBER() OVER (ORDER BY Vivienda_InformacionFinanciera.NumContrato) as row FROM Vivienda_InformacionFinanciera WHERE Saldo_Moratorio > 0 AND IdPrograma=".$IdPrograma." AND IdDelegacion=".$IdDelegacion."  ) a WHERE  Colonia='".$_GET['Col']."' 	Order by row";
            }
        }
        else {
            historia($nitavu, "Entro a la aplicacion Explorador Financiero, buscando contratos Moratorio  de ".$Delegacion." del Programa ".$Programa);
        $tb = "<h3 style='color:#005BA0;'>Contratos con Moratorio del Programa <b style='color:#B5D130;'>".ProgramaNombre($IdPrograma)."</b> de la Delegacion ".DelegacionNombre($IdDelegacion)."</h3>";
        $MSSQL = "SELECT * FROM ( SELECT (select Delegacion from DELEGACIONES WHERE DELEGACIONES.IdDelegacion = Vivienda_InformacionFinanciera.IdDelegacion) as Delegacion, Vivienda_InformacionFinanciera.*,(SELECT NombreCompleto FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS NombreCompleto,(SELECT EstadoCivil FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS EstadoCivil,(SELECT NCElector FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS NElector,(SELECT Colonia FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS Colonia,(SELECT Telefono FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS Telefono,(SELECT Curp FROM Vivienda_DatosGenerales WHERE Folio=Vivienda_InformacionFinanciera.Folio AND IdDelegacion=Vivienda_InformacionFinanciera.IdDelegacion AND IdPrograma=Vivienda_InformacionFinanciera.IdPrograma) AS CURP, ROW_NUMBER() OVER (ORDER BY Vivienda_InformacionFinanciera.NumContrato) as row FROM Vivienda_InformacionFinanciera WHERE Saldo_Moratorio > 0 AND IdPrograma=".$IdPrograma." AND IdDelegacion=".$IdDelegacion." ) a WHERE row > ".$Desde." and row <= ".$Hasta." 	Order by row";
        }
    }

    if ($Foraneos == 1 and $IdDelegacion <> "" and $IdPrograma <> "" ) { // Mostrar contratos que no son de la delegacion de la Delegacion y Programa        
        historia($nitavu, "Entro a la aplicacion Explorador Financiero, buscando contratos Foraneos de ".$Delegacion." del Programa ".$Programa);
        $tb = "<h3 style='color:#005BA0;'>Contratos que no son de esta Delegación del Programa <b style='color:#B5D130;'>".ProgramaNombre($IdPrograma)."</b> de la Delegacion ".DelegacionNombre($IdDelegacion)."</h3>";
        $MSSQL = "SELECT * FROM ( SELECT (select Delegacion from DELEGACIONES WHERE DELEGACIONES.IdDelegacion = Vivienda_InformacionFinanciera.IdDelegacion) as Delegacion, Vivienda_InformacionFinanciera.*,(SELECT NombreCompleto FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS NombreCompleto,(SELECT EstadoCivil FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS EstadoCivil,(SELECT NCElector FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS NElector,(SELECT Colonia FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS Colonia,(SELECT Telefono FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS Telefono,(SELECT Curp FROM Vivienda_DatosGenerales WHERE Folio=Vivienda_InformacionFinanciera.Folio AND IdDelegacion=Vivienda_InformacionFinanciera.IdDelegacion AND IdPrograma=Vivienda_InformacionFinanciera.IdPrograma) AS CURP, ROW_NUMBER() OVER (ORDER BY Vivienda_InformacionFinanciera.NumContrato) as row FROM Vivienda_InformacionFinanciera WHERE IdPrograma=".$IdPrograma." AND IdDelegacion<>".$IdDelegacion.") a WHERE row > ".$Desde." and row <= ".$Hasta." 	Order by row ";
    }
    
    if ($IdPrograma == '0.0') {
        if (isset($_GET['Col']) ){
            if ($Moratorios ==1){
                $tb = "<h3 style='color:#005BA0;'>Contratos con Moratorio de la Colonia ".$_GET['Col']." de ".DelegacionNombre($IdDelegacion)."</h3>";
                $MSSQL = "SELECT * FROM ( SELECT (select Delegacion from DELEGACIONES WHERE DELEGACIONES.IdDelegacion = Vivienda_InformacionFinanciera.IdDelegacion) as Delegacion, Vivienda_InformacionFinanciera.*,(SELECT NombreCompleto FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS NombreCompleto,(SELECT EstadoCivil FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS EstadoCivil,(SELECT NCElector FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS NElector,(SELECT Colonia FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS Colonia,(SELECT Telefono FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS Telefono,(SELECT Curp FROM Vivienda_DatosGenerales WHERE Folio=Vivienda_InformacionFinanciera.Folio AND IdDelegacion=Vivienda_InformacionFinanciera.IdDelegacion AND IdPrograma=Vivienda_InformacionFinanciera.IdPrograma) AS CURP, ROW_NUMBER() OVER (ORDER BY Vivienda_InformacionFinanciera.NumContrato) as row FROM Vivienda_InformacionFinanciera WHERE Saldo_Moratorio > 0 AND IdDelegacion=".$IdDelegacion."  ) a WHERE  Colonia='".$_GET['Col']."' 	Order by row";
         
            } else {
                if ($Saldo==1){
                    $tb = "<h3 style='color:#005BA0;'>Contratos con Saldo de la Colonia ".$_GET['Col']." de ".DelegacionNombre($IdDelegacion)."</h3>";
                    $MSSQL = "SELECT * FROM ( SELECT (select Delegacion from DELEGACIONES WHERE DELEGACIONES.IdDelegacion = Vivienda_InformacionFinanciera.IdDelegacion) as Delegacion, Vivienda_InformacionFinanciera.*,(SELECT NombreCompleto FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS NombreCompleto,(SELECT EstadoCivil FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS EstadoCivil,(SELECT NCElector FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS NElector,(SELECT Colonia FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS Colonia,(SELECT Telefono FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS Telefono,(SELECT Curp FROM Vivienda_DatosGenerales WHERE Folio=Vivienda_InformacionFinanciera.Folio AND IdDelegacion=Vivienda_InformacionFinanciera.IdDelegacion AND IdPrograma=Vivienda_InformacionFinanciera.IdPrograma) AS CURP, ROW_NUMBER() OVER (ORDER BY Vivienda_InformacionFinanciera.NumContrato) as row FROM Vivienda_InformacionFinanciera WHERE Saldo > 0 AND IdDelegacion=".$IdDelegacion."  ) a WHERE  Colonia='".$_GET['Col']."' 	Order by row";
                }  else {
                    $tb = "<h3 style='color:#005BA0;'>Contratos sin Saldo de la Colonia ".$_GET['Col']." de ".DelegacionNombre($IdDelegacion)."</h3>";
                    $MSSQL = "SELECT * FROM ( SELECT (select Delegacion from DELEGACIONES WHERE DELEGACIONES.IdDelegacion = Vivienda_InformacionFinanciera.IdDelegacion) as Delegacion, Vivienda_InformacionFinanciera.*,(SELECT NombreCompleto FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS NombreCompleto,(SELECT EstadoCivil FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS EstadoCivil,(SELECT NCElector FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS NElector,(SELECT Colonia FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS Colonia,(SELECT Telefono FROM Vivienda_InformacionContratos WHERE NumContrato=Vivienda_InformacionFinanciera.NumContrato) AS Telefono,(SELECT Curp FROM Vivienda_DatosGenerales WHERE Folio=Vivienda_InformacionFinanciera.Folio AND IdDelegacion=Vivienda_InformacionFinanciera.IdDelegacion AND IdPrograma=Vivienda_InformacionFinanciera.IdPrograma) AS CURP, ROW_NUMBER() OVER (ORDER BY Vivienda_InformacionFinanciera.NumContrato) as row FROM Vivienda_InformacionFinanciera WHERE Saldo <= 0 AND IdDelegacion=".$IdDelegacion."  ) a WHERE  Colonia='".$_GET['Col']."' 	Order by row";
                }
            }

                
        }
    }
    // echo "<br><br><br><hr>".$MSSQL."<hr>";

    $tb = $tb. "<table class='tabla'>";
    $tb = $tb."<th>N</th><th>Beneficiario</th><th>Contrato</th><th
    >Saldo</th><th>Moratorios</th>";
    $ConsultaDATA = DatosVivienda($IdDelegacion, "WSContratos", "Test", $MSSQL);
    
    $array = json_decode($ConsultaDATA, true);
    // var_dump($array);
    $error = 0;
    if(is_array($array)){            
        foreach ($array as $value) {
            if (isset($value['r'])){// si hay un error
                echo "*Error: ".$value['r'];
                $error = $value['r'];
            } else {//si no hay errores escribimos
                if (    $value['Errores'] >0 ){
                    $tb = $tb."<tr style='background-color:#f280db;'>";
                } else {
                    $tb = $tb."<tr>";
                }
                
                $tb = $tb."<td title='Errores: ".$value['Errores']."'>".$value['row']."</td>";
                $tb = $tb."<td>";
                    $tb = $tb."<b style='font-size:14pt;'>".$value['NombreCompleto']."</b><br>";
                    $tb = $tb."<span style='font-size:8pt;'><b>CURP:  </b>".$value['CURP']."</span> ";
                    $tb = $tb."<span style='font-size:8pt;'><b>Telefono:  </b>".$value['Telefono']."</span><br>";
                    $tb = $tb."<span style='font-size:8pt;'><b>Colonia:  </b>".$value['Colonia']."</span><br>";
                    $tb = $tb."<span style='font-size:8pt;'><b>Delegacion:  </b>".$value['Delegacion']."</span><br>";

                $tb = $tb."</td>";

                $tb = $tb."<td>";
                    $tb = $tb."<b style='font-size:10pt;'>";
                    $tb = $tb."<a title='Haz clic aqui para ver el Estado de Cuenta' target=_blank href='estadodecuenta.php?contrato=".$value['NumContrato']."&del=".$IdDelegacion."'>";
                    $tb = $tb."".$value['NumContrato']."</a></b><br>";
                    $tb = $tb."<span style='font-size:8pt;'><b>Tasa Anual de Financiamiento:  </b>".$value['TasaAnualFin']."%</span><br>";
                    $tb = $tb."<span style='font-size:8pt;'><b>Tasa Int. Moratorio:  </b>".$value['TasaIntMora']."%</span><br>";
                $tb = $tb."</td>";

                $tb = $tb."<td>";
                    $tb = $tb."<b style='font-size:10pt;' title='".$value['Saldo']."'>$ ".number_format($value['Saldo'],2,'.',',')."</b><br>";
                    $tb = $tb."<span style='font-size:8pt;' title='".$value['FechaUltimoPago']."'><b>Ultimo Pago:  </b> ".$value['FechaUltimoPAGO']."</span><br>";
                    
                $tb = $tb."</td>";

                $tb = $tb."<td>";
                    $tb = $tb."<b style='font-size:10pt;' title='".$value['Saldo_Moratorio']."'>$ ".number_format($value['Saldo_Moratorio'],2,'.',',')."</b><br>";
                    $tb = $tb."<span style='font-size:8pt;' title='".$value['MesesDeAtraso']."'><b>Meses de Atraso:  </b>".round($value['MesesDeAtraso'])."</span><br>";
                    
                $tb = $tb."</td>";

                $tb = $tb."</tr>";
            }
            
        }
        $tb = $tb."</table>";
        echo $tb;
        
    } else {
        echo "ERROR: No es un array";
    }



    //Contruccion 


} else {
    echo "ERROR: faltan parametros!";
}
















?>

