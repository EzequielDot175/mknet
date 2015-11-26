<?php 
	require_once('libs.php');



	session_start();


	$_SESSION["logged_id"] =  10;
	$_SESSION['MM_IdUsuario'] = 104;
	$_SESSION['MM_Username'] = 'user';


	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";


 ?>