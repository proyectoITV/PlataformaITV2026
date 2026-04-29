<?php

require("config.php");
require_once('seguridad.php');
require_once('pdf/tcpdf.php');
//$nitavu="2809";
require('lib/yes_funciones.php');
require('lib/funciones.php');

error_reporting(0);
require_once('seguridad.php');
require_once('pdf/tcpdf.php');
//$nitavu="2809";
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require_once("lib/yes_funciones.php");
error_reporting(0);


if (isset($_GET['NumContrato'])) {  
  
  

    $idtipousosuelo=$_POST['usodesuelo'];
    $costoescritura=$_POST['costoescritura'];
    $observaciones=$_POST['observaciones'];
    $causahabientemenor=$_POST['causahabientemenor'];
    $causahabiente=$_POST['causahabiente'];
    $numcontrato=$_GET['NumContrato']; 
    $descuentoesc=$_POST['descuentoescritura']; 
    $saldoesc=  $_POST['saldoescritura']; 
    $numescritura="";
    $nombre="";;
    $lugarnacsol="";
    $FNacimiento="";
    $domicilio="";
    $ocupacion="";
    $sexo="";
    $seccion="";
    $fila="";
    $manzana="";
    $lote="";
    $superficie="";
    $col1="";
    $conquien1="";
    $col2="";
    $conquien2="";
    $col3="";
    $conquien3="";
    $col4="";
    $conquien4="";
    $estadocivil="";
    $municipio="";
    $colonia="";        
    $nombreconyuge="";   
    $ocupacionconyuge="";   
    $idlote="";
    $directoradmon="";
    $directorsuelo="";
    $delegado="";
    $correccion_saldo_negativo=0;


    
    $nummov=0;    
    $idempmodificaContrato="";
    $fechaultimamodContrato="";
    $fechaultimamodControlContrato="";
    $idempmodificaControlContrato="";
    $estatausCuentaControlContratos = "";
    

    $sql="Select * from vivienda_informacioncontratos where numcontrato='".$numcontrato."'";

    $rc= $Vivienda -> query($sql);
    $row_cnt = $rc->num_rows;
        
        if($row_cnt>0)
        {
          while($datos = $rc -> fetch_array())
          {
            
            $numescritura=strtoupper($datos['NumEscritura']);
            $nombre=strtoupper($datos['NombreCompleto']);
            $lugarnacsol=strtoupper($datos['LugarNac']);
            $FNacimiento=strtoupper($datos['FNacimiento']);
            $domicilio=strtoupper($datos['Domicilio_Calle']);
            $ocupacion=strtoupper($datos['ocupacion']);
            $sexo=strtoupper($datos['sexo']);
            $seccion=strtoupper($datos['seccion']);
            $fila=strtoupper($datos['fila']);
            $manzana=strtoupper($datos['manzana']);
            $lote=strtoupper($datos['lote']);
            $superficie=strtoupper($datos['superficie']);
            $col1=strtoupper($datos['colin1']);
            $conquien1=strtoupper($datos['con_quien1']);
            $col2=strtoupper($datos['colin2']);
            $conquien2=strtoupper($datos['con_quien2']);
            $col3=strtoupper($datos['colin3']);
            $conquien3=strtoupper($datos['con_quien3']);
            $col4=strtoupper($datos['colin4']);
            $conquien4=strtoupper($datos['con_quien4']);
            $estadocivil=strtoupper($datos['estadocivil']);
            $municipio=strtoupper($datos['MunicipioL']);
            $colonia=strtoupper($datos['ColoniaL']);           
            $nombreconyuge=strtoupper($datos['conyuge']);     
            $ocupacionconyuge=strtoupper($datos['ocupacioncon']);      
            $idlote=$datos['IdLote'];
          }   
       
        }
        $usodesuelo=UsoDeSuelo($idtipousosuelo);
        $preciolote=PrecioLotes($idlote);  
        $costoescritura1=str_replace(',','',$costoescritura); // SE QUITA LA COMA DE LA CANTIDAD PARA QUE PUEDA ALMACENARSE EN LA BASE DE DATOS.  
        $sql="Select * from version";
        $rc= $Vivienda -> query($sql);
        $row_cnt = $rc->num_rows;
            
            if($row_cnt>0)
            {
              while($datos = $rc -> fetch_array())
              {
                
                $directoradmon=strtoupper($datos['DirectorDeAdministracionyFinanzas']);
                $directorsuelo=strtoupper($datos['DirectorDeProgramasySuelo']);

            }
            }


          $iddelegacion=IdDelegacionNumContrato($numcontrato);
          $idprograma=IdProgramaNumContrato($numcontrato);
          $sql="Select * from delegaciones where iddelegacion=".$iddelegacion;
          $rc= $Vivienda -> query($sql);
          $row_cnt = $rc->num_rows;
              
              if($row_cnt>0)
              {
                while($datos = $rc -> fetch_array())
                {
                  $delegado=strtoupper($datos['NombreDel']).' '.strtoupper($datos['paternoDel']).' '.strtoupper($datos['MaternoDel'] );
                  $resAreaTecDel=strtoupper($datos['ResponsableAreaTecnica']);
                  $resAreaAdmonDel=strtoupper($datos['ResponsableAreaAdmon']);
              }
            }

 if (isset($_GET['sol'])) 
{
  class MyCustomPDFWithWatermark extends TCPDF {
    public function Header() {
        // Obtener el margen de salto de página actual
        $bMargin = $this->getBreakMargin();
  
        // Obtener el modo actual de salto de página automático
        $auto_page_break = $this->AutoPageBreak;
  
        // Deshabilitar el salto de página automático
        $this->SetAutoPageBreak(false, 0);
  
        // Defina la ruta a la imagen que desea usar como marca de agua.
        $img_file = '';
  
        // Renderizar la imagen
        $this->Image($img_file, 0, 0, 223, 280, '', '', '', false, 300, '', false, false, 0);
  
        // Restaurar el estado de salto de página automático
        //$this->SetAutoPageBreak($auto_page_break, $bMargin);
  
        // Establecer el punto de partida para el contenido de la página
        $this->setPageMark();
    }
  }
}else 
{
  class MyCustomPDFWithWatermark extends TCPDF {
    public function Header() {
        // Obtener el margen de salto de página actual
        $bMargin = $this->getBreakMargin();
  
        // Obtener el modo actual de salto de página automático
        $auto_page_break = $this->AutoPageBreak;
  
        // Deshabilitar el salto de página automático
        $this->SetAutoPageBreak(false, 0);
  
        // Defina la ruta a la imagen que desea usar como marca de agua.
      
        $img_file = './icon/cotejo.png';
        // Renderizar la imagen
        $this->Image($img_file, 0, 0, 223, 280, '', '', '', false, 300, '', false, false, 0);
  
        // Restaurar el estado de salto de página automático
        //$this->SetAutoPageBreak($auto_page_break, $bMargin);
  
        // Establecer el punto de partida para el contenido de la página
        $this->setPageMark();
    }
  }
}



// style="border:1px solid black;
$Vale1='<table width="100%" >
<tr>  
    <td rowspan="3"><img src="img/logotam.jpg" style="width:120px; Height:30px;" /></td>
    <td colspan="3"><p style="text-align: center;vertical-align:middle; font-weight:bold;  font-size:11pt;">SECRETARIA DE DESARROLLO URBANO Y MEDIO AMBIENTE</p></td>
</tr>
<tr>    
  <td width="70%"><p style="text-align: center;vertical-align:middle; font-weight:bold;   font-size:9pt;" >SOLICITUD DE TRAMITE DE ESCRITURACION</p></td>
</tr>
</table><br><br>';


$datos='<table >

<tr>
<td width="80%"><p style="text-align: right;vertical-align:middle; font-weight:bold;  font-size:7.5pt;"></p></td>  
<td width="20%"><p style="text-align: right;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">IVU-RP-PO-02-RE-09</p></td>  
</tr>
<tr>
<td width="80%"><p style="text-align: right;vertical-align:middle; font-weight:bold;  font-size:8pt;">Num Escritura</p></td>  
<td width="20%"><p style="text-align: right;vertical-align:middle;   font-size:7.5pt;">'.$numescritura.'</p></td>  
</tr>
<tr>
<td width="80%"><p style="text-align: right;vertical-align:middle; font-weight:bold;  font-size:8pt;">Fecha Impresion</p></td>  
<td width="20%"><p style="text-align: right;vertical-align:middle;   font-size:7.5pt;">'.$fecha.'</p></td>  
</tr>
</table><br><br>';

$datospersonales='<table width="100%"   style="border:1px solid black; padding: 2px;">
<tr >
    <td  width="5%" rowspan="7"  ><img src="img/datospersonales.png" style="width:30px; Height:126px;" /></td>
    <td  width="15%" Height="20px" ><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Nombre</p></td>
    <td  width="80%" Height="20px"><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.$nombre.'</p></td>
</tr>
<tr>
    <td  width="15%" Height="20px" ><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Ocupacion</p></td>
    <td  width="80%" Height="20px"><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.$ocupacion.'</p></td>
</tr>
<tr>
  <td  width="15%" Height="20px" ><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Domicilio</p></td>
  <td  width="80%" Height="20px"><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.$domicilio.'</p></td>
</tr>
<tr>
  <td  width="20%" Height="20px" ><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Fecha de Nacimiento</p></td>
  <td  width="20%" Height="20px" ><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.$FNacimiento.'</p></td>
  <td  width="20%" Height="20px" ><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Lugar de Nacimiento</p></td>
  <td  width="35%" Height="20px"><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.$lugarnacsol.'</p></td>
</tr>
<tr>
  <td  width="15%" Height="20px"><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Sexo</p></td>
  <td  width="25%" Height="20px"><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.$sexo.'</p></td>
  <td  width="20%" Height="20px"><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Estado Civil</p></td>
  <td  width="35%" Height="20px"><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.$estadocivil.'</p></td>
</tr>
<tr>
  <td  width="20%" Height="20px"><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Nombre del conyuge</p></td>
  <td  width="35%" Height="20px"><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.$nombreconyuge.'</p></td>
  <td  width="15%" Height="20px"><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Ocupacion</p></td>
  <td  width="25%" Height="20px"><p style="text-align: left;vertical-align:middle;font-size:7.5pt;">'.$ocupacionconyuge.'</p></td>
</tr>
</tr></table><br>';
$nota='<table width="100%"   >
<tr>
  <td  width="100%" height="50px;"><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;"><br>Bajo protesta de decir verdad, solicito ante el Instituto Tamaulipeco de Vivienda y Urbanismo, la regularización del lote, cuyos datos son los siguientes:</p></td>
</tr></table><br>';

$datosterrno='<table width="100%"   style="border:1px solid black; padding: 2px;">
<tr>
 <td  width="5%" rowspan="10"  ><img src="img/datosdelterreno.png" style="width:30px; Height:175px;" /></td>
  <td  width="10%" Height="15px"><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Municipio</p></td>
  <td  width="35%" Height="15px"><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.$municipio.'</p></td>
  <td  width="10%" Height="15px"><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Colonia</p></td>
  <td  width="40%" Height="15px"><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.$colonia.'</p></td>
</tr>
<tr>
  <td  width="8%" Height="15px"><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Seccion</p></td>
  <td  width="9%" Height="15px"><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.$seccion.'</p></td>
  <td  width="8%" Height="15px"><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Fila</p></td>
  <td  width="10%" Height="15px"><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.$fila.'</p></td>
  <td  width="10%" Height="15px"><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Manzana</p></td>
  <td  width="10%" Height="15px"><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.$manzana.'</p></td>
  <td  width="10%" Height="15px"><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Lote</p></td>
  <td  width="10%" Height="15px"><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.$lote.'</p></td>
  <td  width="10%" Height="15px"><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Superficie</p></td>
  <td  width="10%" Height="15px"><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.$superficie.'</p></td>
</tr>

<tr>
  <td  width="5%" Height="15px"><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Al</p></td>
  <td  width="30%" Height="15px"><p style="text-align: left;vertical-align:middle;  font-size:7.5pt;">'.$col1.'</p></td>
  <td  width="60%" Height="15px"><p style="text-align: left;vertical-align:middle;  font-size:7.5pt;">'.$conquien1.'</p></td> 
</tr>
<tr>
  <td  width="5%" Height="15px"><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Al</p></td>
  <td  width="30%" Height="15px"><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.$col2.'</p></td>
  <td  width="60%" Height="15px"><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.$conquien2.'</p></td> 
</tr>
<tr>
  <td  width="5%" Height="15px"><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Al</p></td>
  <td  width="30%"Height="15px" ><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.$col3.'</p></td>
  <td  width="60%" Height="15px"><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.$conquien3.'</p></td> 
</tr>
<tr>
  <td  width="5%" Height="15px"><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Al</p></td>
  <td  width="30%" Height="15px"><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.$col4.'</p></td>
  <td  width="60%" Height="15px"><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.$conquien4.'</p></td> 
</tr>
<tr>
  <td  width="48%" Height="20px"><p style="text-align: center;vertical-align:text-bottom; font-size:7.5pt;"><br>'.$resAreaTecDel.'</p></td>
  <td  width="47%" Height="20px"><p style="text-align: center;vertical-align:text-bottom; font-size:7.5pt;"><br>'.$directorsuelo.'</p></td>
</tr>
<tr>
  <td  width="48%" Height="20px"><p style="text-align: center;vertical-align:text-bottom; font-size:7.5pt;"><br>________________________________________</p></td>
  <td  width="47%" Height="20px"><p style="text-align: center;vertical-align:text-bottom; font-size:7.5pt;"><br>________________________________________</p></td>
</tr>
<tr>
  <td  width="48%" Height="15px"><p style="text-align: center;vertical-align:middle; font-size:7.5pt;">RESPONSABLE DEL AREA TECNICA EN LA DELEGACION</p></td>
  <td  width="47%" Height="15px"><p style="text-align: center;vertical-align:middle; font-size:7.5pt;">DIRECTOR DE PROGRAMAS DE SUELO Y VIVIENDA</p></td>
  </tr></table><br><br>';
$adjudicacion='<table style="border:1px solid black; padding: 2px;">
<tr >
  <td  width="5%" rowspan="8"  ><img src="img/adjudicacion.png" style="width:30px; Height:164px;" /></td>
  <td  width="10%" Height="20px"  ><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Contrato</p></td>
  <td  width="85%" Height="20px" ><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.$numcontrato.'</p></td>
</tr>
<tr>
  <td  width="20%" Height="20px"  ><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Tipo de Operacion</p></td>
  <td  width="25%" Height="20px"  ><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">CONTADO</p></td>
  <td  width="20%" Height="20px"  ><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Uso de Suelo</p></td>
  <td  width="30%" Height="20px"  ><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.strtoupper($usodesuelo).'</p></td>
</tr>
<tr>
  <td  width="20%" Height="20px"  ><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Costo del Predio</p></td>
  <td  width="25%" Height="20px"  ><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.$preciolote.'</p></td>
  <td  width="50%" Height="20px"  ><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">('.strtoupper(numtoletras($preciolote)).')</p></td>
</tr>
<tr>
  <td  width="20%" Height="20px"  ><p style="text-align: left;vertical-align:middle; font-weight:bold;  font-size:7.5pt;">Costo del Escrituracion</p></td>
  <td  width="25%" Height="20px"  ><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">'.$costoescritura.'</p></td>
  <td  width="50%" Height="20px"  ><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">('.strtoupper(numtoletras($costoescritura1)).')</p></td>
</tr>
<tr>
  <td  width="48%" Height="20px"><p style="text-align: center;vertical-align:top; font-size:7.5pt;"><br>'.$resAreaAdmonDel.'</p></td>
  <td  width="47%" Height="20px"><p style="text-align: center; font-size:7.5pt;"><br>'.$directoradmon.'</p></td>
</tr>
<tr>
  <td  width="48%" Height="20px"><p style="text-align: center;vertical-align:top; font-size:7.5pt;"><br>________________________________________</p></td>
  <td  width="47%" Height="20px"><p style="text-align: center; font-size:7.5pt;"><br>________________________________________</p></td>
</tr>
<tr>
  <td  width="48%" Height="20px" ><p style="text-align: center;vertical-align:middle; font-size:7.5pt;">RESPONSABLE DEL AREA ADMINISTRATIVA EN LA DELEGACION</p></td>
  <td  width="47%" Height="20px" ><p style="text-align: center;vertical-align:middle; font-size:7.5pt;">DIRECTOR DE ADMINISTRACION Y FINANZAS</p></td>
</tr>
</tr></table><br><br>';
$datosreserva='<table width="100%"  style="border:1px solid black; padding: 2px;" >
<tr>
<td  width="5%" rowspan="13"  ><img src="img/datosreserva.png" style="width:30px; Height:298px;" /></td>
<td  width="95%"><p style=" font-size:7.5pt;">Señalando  como  causa - habiente,
    solo  para  los casos de interdiccion o muerte superviniente del  titular, antes  de  concluido  el tramite de regularización, a efecto que se expida titulo a favor de: <b>'.strtoupper($causahabiente).'</b></p></td>
</tr>
<tr>
  <td  width="95%" ><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">El  solicitante  queda  obligado  de informar a su causa-habiente, que de aceptar la sucesión o tutoría, deberá de  continuar  con  el pago de su adeudo.</p></td>
</tr>
<tr>
  <td  width="95%"><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">En caso de que el causa-habiente sea menor de edad, el tutor del mismo sera: <b>'.strtoupper($causahabientemenor).'</b></p></td>
</tr>
<tr>
  <td  width="95%"><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">Por  este  conducto,  autorizo para  que  el Instituto Tamaulipeco de Vivienda y Urbanismo designe un  gestor  a  titulo  gratuito para tramite y la firma de mi escritura.</p></td>
</tr>
<tr>
  <td  width="95%"><p style="text-align: left;vertical-align:middle; font-size:7.5pt;">Conforme a lo anterior, tramitese y apruébese esta solicitud.</p></td>
</tr>
<tr>
  <td  width="95%"><p style="text-align: center;vertical-align:middle; font-size:7.5pt; font-weight:bold;"><br>ATENTAMENTE EL (LOS) SOLICITANTE (S).</p></td>
</tr>
<tr>
  <td  width="95%"><p style="text-align: center;vertical-align:top; font-size:7.5pt;"><br>________________________________________</p></td>
</tr>
<tr>
  <td  width="95%"><p style="text-align: center;vertical-align:top; font-size:7.5pt;">NOMBRE(S) FIRMA(S)</p></td>
</tr>
<tr>
  <td  width="48%" Height="20px" ><p style="text-align: center;vertical-align:middle; font-size:7.5pt;"><br>ATENDIO Y COTEJÓ DOCUMENTACIÓN</p></td>
  <td  width="47%" Height="20px" ><p style="text-align: center;vertical-align:middle; font-size:7.5pt;"><br>APROBADO POR EL DELEGADO</p></td>
</tr>
<tr>
  <td  width="48%" Height="20px"><p style="text-align: center;vertical-align:top; font-size:7.5pt;">'.strtoupper(nitavu_nombre($nitavu)).'</p></td>
  <td  width="47%" Height="20px"><p style="text-align: center; font-size:7.5pt;">'.$delegado. '</p></td>
</tr>
<tr>
  <td  width="48%" Height="20px"><p style="text-align: center;vertical-align:top; font-size:7.5pt;"><br>________________________________________</p></td>
  <td  width="47%" Height="20px"><p style="text-align: center; font-size:7.5pt;"><br>________________________________________</p></td>
</tr>
<tr>
  <td  width="48%" Height="20px" ><p style="text-align: center;vertical-align:middle; font-size:7.5pt;">NOMBRE(S) FIRMA(S)</p></td>
  <td  width="47%" Height="20px" ><p style="text-align: center;vertical-align:middle; font-size:7.5pt;">NOMBRE(S) FIRMA(S)</p></td>
</tr>
</table><br><br>';

$observaciones='<table width="100%"   style="border:1px solid black; padding: 2px;"  >
<tr>
<td  width="5%" ><img src="img/nota.png" style="width:30px; Height:44px;" /></td>
<td  width="95%" >'.$observaciones.'</td>
</tr></table><br>';
$tabla=$Vale1.$datos.$datospersonales.$nota.$datosterrno.$adjudicacion.$datosreserva.$observaciones;


}else{
  $tabla="No existe informacion";
}








$orientacion='P';
$autor="Instituto Tamualipeco de Vivienda y Urbanismo";
$titulo="";
$descripcion="";



// create new PDF document
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, 'LEGAL', true, 'UTF-8', false);
$pdf = new MyCustomPDFWithWatermark(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
  ob_end_clean();   
// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor($autor);
$pdf->SetTitle(strtoupper($titulo));
$pdf->SetSubject($descripcion);
$pdf->SetKeywords('Solicitud de Tramite de Escritura');


$pdf->SetHeaderData('pdf_logo.jpg', '20',strtoupper($titulo).'', strtoupper($descripcion));

// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, strtoupper($titulo).'', strtoupper($descripcion));
// set header and footer fonts
//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'pdf/lang/eng.php')) {
	require_once(dirname(__FILE__).'pdf/lang/eng.php');
	$pdf->setLanguageArray($l);
}



// set font
$pdf->SetFont('helvetica', '', 8);
// add a page
$pdf->AddPage($orientacion); //en la tabla de reporte L o P
$html = $tabla;
//echo $html;
//aqui escribe el contenido de la consulta


$pdf->writeHTML($html, true, false, true, false, '');

//ob_end_clean();
 if($orientacion == 'P'){

	$pdf->lastPage();
	//Close and output PDF document}
$pdf->Output('reporte.pdf', 'I');
}


?>