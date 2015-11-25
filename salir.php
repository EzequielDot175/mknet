<?php
	ob_start();
	session_start();

	session_destroy();

	if (isset($_GET['type'])) {
		header('Location: /control');
	}else{
		header('Location: /');
	}

 ?>


