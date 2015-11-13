<?php 
	require_once('libs.php');

	session_start();


	$auth = new Auth();
	$auth->userLoggin(104);

	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";


 ?>