<?php 
	require_once('libs.php');

	session_start();


	$auth = new Auth();
	$auth->userLoggin(102);

	echo "<pre>";
	print_r($_SESSION);
	echo "</pre>";


 ?>