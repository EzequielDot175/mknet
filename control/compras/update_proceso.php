<?php session_start();
ob_start();
require_once("../../libs.php");

$collection = array();

$id = $_POST['id_compra'];
$remito = $_POST['remito'];
$detalles = $_POST['detalles'];

foreach($remito as $rem => $val){
	array_push($collection,array(
		"id" => $rem,
		"remito" => $val,
		"estado" => $detalles[$rem]
	));
}

foreach($collection as $key => $val):
	DetalleCompra::upd($val["id"],$val['estado'],$val['remito']);
endforeach;



@header('Location: v_compras.php?activo=1&sub=c');

?>