<?php
session_start();
include 'patrimonio_funciones.php';
$patrimonio = new Patrimonio();

if(!empty($_POST['action']) && $_POST['action'] == 'catalogodemarcas') {
	$patrimonio->getBrandList();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'addBrand'){
	$patrimonio->saveBrand();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'getBrand'){
	$patrimonio->getBrand();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'updateBrand'){
	$patrimonio->updateBrand();
}
if(!empty($_POST['btn_action']) && $_POST['btn_action'] == 'deleteBrand'){
	$patrimonio->deleteBrand();
}
