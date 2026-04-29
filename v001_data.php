<?php
// require("seguridad.php"); 
require_once("config.php");
require_once("lib/funciones.php");
require_once("lib/flor_funciones.php");
require("lib/curp_fun.php");
$id_aplicacion ="v001";
error_reporting(0); //<-- para simular produccion
$Search = $_GET['search']; if (ValidaVAR($Search)==TRUE){$Search = LimpiarVAR($Search);} else {$Search = "";}
$nitavu = $_GET['nitavu']; if (ValidaVAR($nitavu)==TRUE){$nitavu = LimpiarVAR($nitavu);} else {$nitavu = "";}
$mode = $_GET['mode']; 

echo "<script>$('#Data').css('background-color','#fff');</script>";
historia($nitavu,"[V001] ".$Search.", Busco beneficiario");

$sql = "INSERT INTO busquedas
		(busqueda, IdEmpleado, fecha, hora,  idApp)
		VALUES
		('$Search','$nitavu', '$fecha',  '$hora', '$id_aplicacion');";
if ($Vivienda->query($sql) == TRUE){}


// echo "Search = ".$Search." y nitavu = ".$nitavu;
$sql="select * from busqueda_buscar_beneficiarios  where 
        NombreCompleto like'%".$Search."%'
    or  NumContrato like'%".$Search."%'
    limit 1000";



		

//  echo $sql;
// sleep(5);

$r= $Vivienda -> query($sql);

// var_dump($Vivienda);
$registros = $r->num_rows;
$c=0;

echo "<h3 style='font-size:9pt;'>Se han encontrado ".$registros."  con <b>".$Search."</b> resultados</h3>";
echo "<table class='tabla   table table-striped table-bordered' style='width:98%;'>";
if ($mode ==1) {} 
else {
    echo "<th style='width:90px:'>Foto</th>";
}

echo "<th>Persona</th>";
echo "<th>Solicitud</th>";
echo "<th >Contrato</th>";
if ($mode ==1) {
    echo "<th >Seleccionar</th>";
} 
else {
    echo "<th >Lote</th>";
}

// echo "<th>Accion</th>";

$c =1   ;           
while($f = $r -> fetch_array()) {
    echo "<tr>";

    if ($mode ==1) {
        // echo "<td>";
        // echo "<button>Seleccionar</button>";
        // echo "</td>";
    } else {

        echo "<td style=''>";
        $ArchivoDeFoto = "";
        if (file_exists($ArchivoDeFoto)==TRUE){

        } else {
            echo "<img src='icon/beneficiario_user.png' style='width:80px;'>";
        }
    
        echo "</td>";
    }

    echo "<td>";

    

    echo "<b style='font-size:12pt; colorblack;font-family: ExtraBold;'>".cortaFrase($f['NombreCompleto'],2,0)."</b><b style='font-size:12pt; font-family:Light;'> ".cortaFrase($f['NombreCompleto'],2,1)."</b>";
    $Edad = edad($f['FNacimiento']) + 1;
    if ($Edad>125){$Edad = 0;}

    if ($Edad>0){
        echo "<br><label style='font-size:8pt; margin:0px;cursor:pointer;font-style: regular;' title='Fecha Nacimiento registrada en Sistema: ".$f['FNacimiento']."'><b>Edad<b>: ".$Edad." años</label>";
    }

    $Curp = $f['Curp'];
    if ($Curp<>''){
        // $FNacimiento_Curp = Curp_FNacimiento($Curp);
        // list($dia,$mes,$ano) = explode("/",$FNacimiento_Curp);
        // // echo "Año curp ".$ano;
        // $EdadCurp  = date("Y") - $ano;

        // // $Edad_Curp = edad_curp(Curp_FNacimiento($Curp));
        // if ($Edad === $Edad_Curp){
        // } else {
        //     echo "<br><label style='font-size:8pt; cursor:pointer;font-style: regular;' title='Fecha de Nacimiento segun CURP: ".$FNacimiento_Curp."'><img src='icon/alerta.png' style='width:18px;'>(<b>Edad desde Curp<b>: ".$EdadCurp." años)</label>";
        // }
        


        $Fallecido = Curp_Fallecido($Curp);
        // var_dump($Fallecido);
        if ($Fallecido===TRUE){
            echo "<br><label style='font-size:8pt; margin:0px;color:red; cursor:pointer;font-style: regular;'><img src='icon/alerta.png' style='width:18px;'><b>CURP: ".$Curp." (ES POSIBLE QUE ESTA PERSONA HAYA FALLECIDO)! </label>";
        } else {
            echo "<br><label style='font-size:8pt; margin:0px; font-style: regular;' title=''><b>CURP<b>: ".$Curp." </label>";
        }
        
        
        
    }
    if ($f['TelCelular']<>''){
        echo "<br><label style='font-size:9pt; font-style: italic; margin:0px;'><img src='icon/tel.png' style='width:18px;'> ".$f['TelCelular'].", ".$f['Telefono']."</label>";
    }
    echo "<br><label style='font-size:8pt; color:black;  margin:0px; font-weight: normal; font-family:Compacta'><img src='icon/placeholder.png' style='width:18px;'> ".$f['Domicilio']."</label>";
    if ($f['Delegacion']<>$f['OriginData_Delegacion']){
        echo "<br><img src='icon/alerta_roja.png' style='width:18px;'><label style='font-size:8pt; color:red; margin:0px; font-weight: normal; font-family:Compacta'margin:0px; cursor:pointer;' title='IdDelegacion= ".$f['IdDelegacion']."'><b style='cursor:pointer;'>Delegacion ".$f['Delegacion']."</b>, Registrado en la Delegacion <b style='cursor:pointer;' title='OriginData=".$f['OriginData']."'>".$f['OriginData_Delegacion']."</b></label>";
    } else {
        echo "<br><label style='font-size:8pt;  margin:0px;color: black; font-weight: normal; font-family:Compacta'margin:0px; cursor:pointer;' title='IdDelegacion=".$f['IdDelegacion']."'><b style='cursor:pointer;'>Delegacion ".$f['Delegacion']."</b>.</label>";
    }
    
    echo "</td>";

    echo "<td valign=top align=left>";
    echo "<br><label style='font-size:8pt; color:black; font-style: italic; margin:0px;'>Solicitud de <b style='cursor:pointer;' title='IdPrograma = ".$f['IdPrograma']."'>".$f['Programa']." </b><br>con Folio <a target=_blank href='pdfDatosSolicitud.php?IdDelegacion=".$f['IdDelegacion']."&IdPrograma=".$f['IdPrograma']."&Folio=".$f['Folio']."&OriginData=".$f['OriginData_Delegacion']."'>".$f['Folio']."</a> registrada el ".$f['Solicitud_FechaCaptura']."
    <br><br>Informacion actualizada el ".$f['FechaActualizacion']."
    </label>";

    echo "</td>";

    echo "<td valign=top align=left width=200px>";
    $Contratos = $f['Contratos'];
    if ($Contratos > 1 ){
        echo "<br><img src='icon/alerta_roja.png' style='width:18px;'><label style='font-size:8pt; font-style: italic; color:blackM margin:0px;'>Este Folio tiene ".$Contratos." contratos registrados!</label>";
    }

    if ($Contratos >0 ){        
        echo "<br><label style='font-size:8pt; font-style: italic; color:black; margin:0px;'>
        <b>Contrato: </b> <b><a target=_blank href='EdoCuenta.php?NumContrato=".$f['NumContrato']."'>".$f['NumContrato']."</a> </b><br>
        Fecha: </b>".$f['Contrato_FechaEmision']." <br>        
        <b>Beneficio</b>; <b>".Pesos($f['MontoCredito'])."</b>. 
        <br><b>Saldo</b>: <b>".Pesos($f['Saldo'])."</b> ";

        if ($f['Saldo_Moratorio']>0){
            echo "<br><b style='color:red'>Moratorios</b>: ".Pesos($f['Saldo_Moratorio'])."
                <br> (Atraso ".$f['MesesDeAtraso']." Meses)</b>"."";
        }
        
        echo "</label>";
    }else{
        echo "<a target=_blank href='EdoCuentaAhorro.php?IdDelegacion=".$f['IdDelegacion']."&IdPrograma=".$f['IdPrograma']."&Folio=".$f['Folio']."&OriginData=".$f['OriginData']."'>Estado de Cuenta de Ahorro</a>";

    }

    echo "</td>";

    if ($mode ==1) {
        echo "<td>";
        echo "<button class='btn btn-primary' onclick='Seleccion(\"".$f['NumContrato']."\", ".$f['OriginData'].", ".$f['IdDelegacion'].", ".$f['IdPrograma'].", ".$f['Folio'].");'>Seleccionar</button>";
        echo "</td>";

    } 
    else {
        
        echo "<td>";
        if ($f['IdLote']<>0){
            echo "<br><label style='font-size:8pt; font-style: italic; color:black; margin:0px;'>Lote Asignado a la ".$f['Lote_ML']." de la Colonia ".$f['Lote_Colonia']." en ".$f['Lote_Municipio'].". El Lote se encuentra con Estatus ".$f['Lote_Estatus'].".<br><b> IdLote:<a>".$f['IdLote']."</a></b></label>";

        }
        echo "</td>";
    }

    
    $c= $c+1;
}

echo "</table>";




// echo "<div style='background-color:white; padding:10px; border-radius:5px; width:98%;'>
// Se han detectado algunos errores; pero aun así es posible que la información mas antigua contenga errores debido a multiples migraciones; favor de verificar e informar a los Dptos. Correspondientes para su correccion.
// </div>";



// $IdTabla = "TablaDeBeneficiarios";
// echo sql_to_table($sql, "Vivienda", $IdTabla);

// echo '
// <script>
// $(document).ready(function() {
//     $("#'.$IdTabla.'").DataTable( {
//         "scrollY":        "200px",
//         "scrollCollapse": true,
//         "paging":         false,
//         "language": {
//             "decimal": ",",
//             "thousands": "."
//         }
//     } );
// } );
// </script>';
// $r= $Vivienda -> query($sql);
// $c=0;

// $t = "<table class='tabla'>";
// $t = $t."   <th style='width:40%;'>Beneficiario</th>
//             <th style='width:20%;'>Solicitud</th>
//             <th style='width:20%;'>Contrato</th>
//             <th style='width:20%;'>Delegacion</th><th></th>";
// $c =0;           
// while($f = $r -> fetch_array()) {
//     $c = $c+1;
// if ($f['IdDelegacion'] == $f['OriginData']){ //El Data es de la misma delegacion
//     if ($f['Cancelado'] == 0){
//         $t = $t."<tr>";
//         if ($f['Saldo'] < 0){
//             $t = $t."<tr style='background-color:orange; ' title='ERROR: Saldo negativo'>";
//         }

//     } else {        
//         $t = $t."<tr style='background-color:red; ' title='Solicitud Cancelada'>";
//     }
// } else {
//     $t = $t."<tr style='background-color:purple; ' title='Dato Foraneo'>";
// }    
//     $t = $t."<td>";
//     $t = $t."<b style='font-size:14pt; font-family: ExtraBold;'>".cortaFrase($f['NombreCompleto'],2,0)."</b><b style='font-size:14pt; font-family:Light;'> ".cortaFrase($f['NombreCompleto'],2,1)."</b>";
    
//     if ($f['IdSexo']<>"SIN ESPECIFICAR"){
//         $t = $t."<br><span style='cursor:pointer; font-size:10pt; font-family:Compacta;'><b>".$f['IdSexo']."</b></span> ";
//     }

//     if ($f['Edad']>0){
//         $t = $t.". <span style='cursor:pointer; font-size:10pt; font-family:Compacta;'".$f['FNacimiento']."'><b>".$f['Edad']." años</b></span> ";
//     }

//     if ($f['CURP']<>''){
//         $t = $t."<br><span style='font-size:9pt;'>CURP: 
//         <a href='consultacurp.php?curp=".$f['CURP']."' title='Haga clic aquí para validar el CURP' target=_blank>        
//         <b>".$f['CURP']."</a></b></span> | ";
//     } else {
//         $t = $t."<br>";
//     }

    
//     if ($f['IFE']<>''){
//         $t = $t."<span style='font-size:9pt;'>IFE: <b>".$f['IFE']."</b></span>";
//     }

//     $t = $t."<br><span style='font-size:7pt;'>Domicilio: ".$f['Domicilio'].", ".$f['Colonia'].", CP:".$f['CP'].", ".$f['Delegacion']."</span>";
//     if ($f['Telefono']<>''){
//     $t = $t."<br>
//         <span style='font-size: 10pt;background-color:#82cee6;padding: 2px;padding-right: 2px;padding-left: 2px;margin: 2px;
//         border-radius: 4px;padding-left: 5px;padding-right: 5px;'>
//         <img src='icon/tel.png' style='width:13px;'><b>".$f['Telefono']."</b></span>";
//     }
//     if ($f['TelCelular']<>''){
//     $t = $t."
//         <span style='font-size: 10pt;background-color:#82e6b7;padding: 2px;padding-right: 2px;padding-left: 2px;margin: 2px;
//         border-radius: 4px;padding-left: 5px;padding-right: 5px;'> <img src='icon/cel.png' style='width:13px;'><b>".$f['TelCelular']."</b></span>
//     ";
//     }

//     $t = $t."</td>";
    
//     $t = $t."<td style='background-color:#91b79c94;'>

//     <h2 style='font-size:9pt; font-family:Light; text-align:center; color:black;'>Solicitud:</h2>
//     <table width=100% style='background-color:transparent;'>
//     <tr><td>";
//     if ($f['Anio'] >= 2017 AND $f['Anio']<=2022){
//         $t = $t."<div style='
//         display:inline-block; vertical-align:top;
//         font-size:14pt; padding:4px; 
//         background-color:#3dbcdb; 
//         color:white;
//         border-radius:3px;
//         width:50px;
//         height:60px;
//         padding-top:20px; cursor:pointer;
//     '>".$f['Anio']."</div>";
//     } else {
//     $t = $t."<div style='
//         display:inline-block; vertical-align:top;
//         font-size:14pt; padding:4px; 
//         background-color:#acd0b9; color:#56755e;
//         border-radius:3px;
//         width:50px;
//         height:60px;
//         padding-top:20px; cursor:pointer;
//     ' title='Fecha Captura = ".$f['FechaCaptura']."'>".$f['Anio']."</div>";
//     }
//     $t = $t."</td><td style='font-size:8pt;'>
    
//     ";

//     $t = $t."Folio: <b style='color: #0788c8;'> ".$f['Folio']."</b> de <b style='color:#0788c8;'
//     >
//     <a target=_blank href='contratos.php?IdPrograma=".$f['IdPrograma']."&IdDelegacion=".$f['IdDelegacion']."' style='display:block;' title='Haga clic aqui para ver los contratos de este programa, de esta delegacion'>
//     ".$f['Programa']."</a></b>, <b style='font-size:8pt; color:orange;'>
    
//     ".$f['ProgramaGral']."</b><br></td></tr>
//     <tr ><td colspan='2' style='background-color:transparent;'>";
//     if ($$f['SaldoAhoro'] > 0 ){
//         $t = $t."<table><tr><td><img src='icon/ahorro.png' style='width:20px;'></td><td>".Pesos($f['SaldoAhorro'])."</td></tr></table><br>";
//     }
//     if ($f['IdEmpCrea']==0){
//         $t=$t."<label class='pc' style='font-size:7pt;'>Sin log de creación, en algunos casos es por migración de sistemas anteriores como SICO, COMPRED, Dupport, LOTES, etc.</label>";
//     } else {
//         $t=$t."<label class='pc' style='font-size:7pt;'>Soliciud capturada el ".$f['FechaCaptura']." por ".$f['IdEmpCrea']." - ".$f['Empleado']." en ".$f['Delegacion']."</label>";
//     }

//     $t = $t."</td></tr></table>";


//     $t = $t."";

//     $t = $t."</td>";
    

//     $t = $t."<td>"; //----------CONTRATO
//     if ($f['NumContrato']<>''){
//         $t = $t."<table width=100%><tr><td>";
//         if ($f['ContratoCancelado']==1){
//             $t = $t."<div style='
//             display:inline-block; vertical-align:top;
//             font-size:14pt; padding:4px; 
//             background-color:red; color:white;
//             border-radius:3px;
//             width:50px;
//             height:60px;
//             padding-top:20px; cursor:pointer;
//         '>".$f['ContratoAnio']."</div>";
//         } else{
//             if ($f['ContratoAnio'] >= 2017 AND $f['Anio']<=2022){
//                 $t = $t."<div style='
//                 display:inline-block; vertical-align:top;
//                 font-size:14pt; padding:4px; 
//                 background-color:#3dbcdb; color: white;
//                 border-radius:3px;
//                 width:50px;
//                 height:60px;
//                 padding-top:20px; cursor:pointer;
//             '>".$f['ContratoAnio']."</div>";
//             } else {
//             $t = $t."<div style='
//                 display:inline-block; vertical-align:top;
//                 font-size:14pt; padding:4px; 
//                 background-color:#acd0b9; color:#56755e;
//                 border-radius:3px;
//                 width:50px;
//                 height:60px;
//                 padding-top:20px; cursor:pointer;
//             ' title='Fecha Emision del Contrato = ".$f['FechaEmision']."'>".$f['ContratoAnio']."</div>";
//             }
//         }
//         $t = $t."</td><td><div style='
//             display:inline-block; vertical-align:top;
//             font-size:8pt; padding:4px; 
            
//             border-radius:3px;
//         '>";
//         if ($f['ContratoCancelado']==1){
//             $t = $t."<b style='color:red'>(Cancelado) Num. Contrato: <a href='v002.php?numcontrato=".$f['NumContrato']."' title='Haga clic aqui para ver el contrato'><b style='color: #0788c8; font-size:11pt;'> ".$f['NumContrato']."</b></a></b> <br>";
//         } else {
//             $t = $t."Num. Contrato: <a href='v002_init.php?numcontrato=".$f['NumContrato']."&origindata=".$f['OriginData']."' target=_blank title='Haga clic aqui para ver el contrato'><b style='color: #0788c8; font-size:11pt;'> ".$f['NumContrato']."</b></a> <br>";
//         }
        
//         $t = $t."<b style='font-size:9pt;'>Saldo:  ".Pesos($f['Saldo'])."</b> | <b style='font-size:9pt;'>Moratorio: ".Pesos($f['Saldo_Moratorio'])."</b>";
//         if ($f['FechaUltimoPAGO'] <> ''){
//             $t = $t."<br><b style='padding-lefT:5px; padding-right:5px; background-color:gray; color:white; font-size:10pt; '>Ultimo Pago:". fecha_larga($f['FechaUltimoPAGO'])."</b>";
//         }

//         if ($$f['SaldoAhoro'] > 0 ){
//             $t = $t."<table><tr><td><img src='icon/ahorro.png' style='width:20px;'></td><td>".Pesos($f['SaldoAhorro'])."</td></tr></table><br>";
//         }
//         if ($f['Contrato_IdEmpCrea']==0){
//             $t=$t."<label style='font-size:7pt;'>Sin log de creación, en algunos casos es por migración de sistemas anteriores como SICO, COMPRED, Dupport, LOTES, etc.</label>";
//         } else {
//             $t=$t."<label style='font-size:7pt;'>Contrato capturado el ".$f['FechaEmision']." por ".$f['Contrato_IdEmpCrea']." - ".$f['Contrato_Empleado']." en ".$f['Delegacion']."</label>";
//         }

//         $t = $t."<div></td></tr></table>";


//         $t = $t."";
        

//     } else {
//         $t = $t."Sin contrato";
//     }











//     $t = $t."</td>";
//     $t = $t."<td>";
//     if ($f['IdDelegacion'] == $f['OriginData']){ //El Data es de la misma delegacion
//         $t = $t."<b  style='cursor:pointer; font-size:13pt;' title='IdDelegacion = ".$f['IdDelegacion']."'>".$f['Delegacion']."</b><br>";
//         $t = $t."<b 
//         style='font-size:9pt; color:gray;'
//         title='IdDelegacion de Origen de Datos = ".$f['OriginData']."'>Origen de los Datos: ".$f['OriginData_Delegacion']."</b><br>";
//     } else { // El dato es de otra delegacion pero esta guardado en OriginData
//         $t = $t."<b style='cursor:pointer; font-size:13pt;' title='IdDelegacion = ".$f['IdDelegacion']."'>".$f['Delegacion']."</b><br>";
//         $t = $t."<b  style=''
//         title='IdDelegacion de Origen de Datos = ".$f['OriginData']."'>Origen de los Datos: ".$f['OriginData_Delegacion']."</b><br>";
//         $t  = $t."<label style='font-size:7pt;'>NOTA: Hay datos foraneos que estuvieron guardadas en la misma delegacion (".$f['OriginData_Delegacion'].") que eran de otra (".$f['Delegacion'].")
//         . Si desea eliminar o corregir este dato incorrecto, solicitelo a la Direccion General con atención al Dpto de Informática por oficio.
//         </label>";
//     }
    
//     $t = $t."</td>";
//     //PERMISO EN CAJA PARA COBRAR AGREGAMOS BOTON PARA COBRO
//     if(permisoCaja($nitavu)==$nitavu){
//         $t = $t."<td>";
//             $t = $t."<a href='caja.php?IdDelegacion=".$f['IdDelegacion']."&IdPrograma=".$f['IdPrograma']."&NumContrato=".$f['NumContrato']."&Folio=".$f['Folio']."&OriginData=".$f['OriginData']."' class='btn btn-Primary' title='Clic para recibir pago en caja...'> <img src='icon/caja.png'></a>";
//         $t = $t."</td>"; 
//     }
//     $t = $t."</tr>";
//     $c= $c + 1;
// }
// $t = $t."</table>";


// if ($c > 0){
//     echo $t;
// } else {
//     sentimental("No se han podido obtener datos con la busqueda <b>".$Search."</b>");
// }




















?>

