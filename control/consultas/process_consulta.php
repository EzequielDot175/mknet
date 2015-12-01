<?php
ob_start();
include_once('../resources/control.php');
include_once('helper_titulos.php');
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once('../../libs.php');




$consulta = Consulta::byId($_POST['idConsulta']);
$mensaje = $_POST['strCampo'];
$usuario = Auth::UserAdmin();

$info_user = (new Usuario())->getById($consulta->idUsuario);


if($info_user[0]->vendedor != 16){

	Mail::informarRespuestaConsulta(
		array(
			'asunto' => $consulta->strAsunto,
			'nombre' => $usuario->nombre,
			'apellido' => $usuario->apellido,
			'mensaje' => $_POST['strCampo'],
			'user_id' => $consulta->idUsuario
			)
		);

}


Consulta::newResponse($_POST['strCampo'],$_POST['idConsulta']);



//$_SESSION['msg_ok'] = 'Mensaje enviado!';
header('Location: '.BASEURL.'consultas/responder_consulta.php?id='.$_POST['idConsulta']);

?>	