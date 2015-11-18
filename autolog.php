<?php 
	require_once('libs.php');

	session_start();


	$auth = new Auth();
	$auth->userLoggin(102);

	$_SESSION["logged_id"] =  10;

	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";


 ?>