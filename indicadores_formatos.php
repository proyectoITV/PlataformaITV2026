<?php
require("seguridad.php");
require("plantilla-core.php");
require("lib/funciones.php");
require("config.php");
require("var_clean.php");

$IdPlantilla = 2;
$IdTrimestre = VarClean($_POST['IdTrimestre']);
$Formato = VarClean($_POST['Formato']);
$Anio = VarClean($_POST['Anio']);

// $Formato = "Lotes"; //Viviendas o Creditos

$id_aplicacion ="indicadores"; 
$nivel = aplicacion_nivel($id_aplicacion, $nitavu);
// $nivel = 1; //<--- Administrador completo
// $nivel = 2; //<--- Delegacion (Delegado)
// $nivel = 3; //<--- Oficinas Centrales
// $nivel = 4; //<-- Capturista
if (isset($_GET['IdDelegacion'])){
    $IdDelegacion = VarClean($_GET['IdDelegacion']);
} else {
    $IdDelegacion = "";
}

if (sanpedro($id_aplicacion, $nitavu)==TRUE){
    $sql = "select 
    CONCAT((select Trimestre from indicadorestrimestrales_trimestres where IdTrimestre = a.IdTrimestre),' ',a.Anio) as Trimestre,
    a.Delegacion,
    a.Vivienda_total as Viviendas_Existentes,
    a.Vivienda_costo as Viviendas_Costo,
    a.Vivienda_vendidas as Viviendas_Vendidas,
    a.Vivienda_enganches as Viviendas_Vendidas_Enganches,
    a.Vivienda_creditos as Viviendas_Vendidas_Costo_de_Venta,
    a.Vivienda_subsidioEstatal as ViviendasVendidas_SubEstatal,
    a.Vivienda_subsidioFederal as ViviendasVendidas_SubFederal,
    a.Vivienda_Saldo as ViviendasVendidas_Saldo,
    a.Creditos_Contratado,
    a.Creditos_Contratos,
    a.Lotes_Libres,
    a.Lotes_Asignados,
    a.Lotes_Regularizados,
    a.Lotes_AhorroContratado,
    a.Lotes_Credito,
    a.Lotes_Saldo
    
    
    from indicadorescapturados a where Anio=".$Anio." and IdTrimestre=".$IdTrimestre;
    // echo $sql;

    TablaDinamica_MySQL("",$sql, "MiIdDivTabla2", "IdTabla2", "", 2); //0 = Basica, 1 = ScrollVertical, 2 = Scroll Horizontal


} else {
    echo "Sin acceso ";
}






?>