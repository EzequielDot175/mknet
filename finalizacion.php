<?php
ob_start();
if (!isset($_SESSION)) {
  session_start();
}


require_once('libs.php'); 
require_once('includes/class.compras.php');
error_reporting(E_ALL);
ini_set('display_errors', 'On');

/**
 * Verifico los puntos disponibles
 */

if(!Usuario::sCheckPoints()):
	@header('Location: carrito.php');
	exit();
endif;

/**
 * Seteo datos para el envio del email
 */

$user = Auth::User();
$seller = Vendedor::EmailById($user->vendedor);
$shop = new ShoppingCart();

$image_url = "http://nufarm-maxx.com/marketingNet/images-clientes/";

$template = new Template('pedido',array(
	"nombre" => $user->strNombre,
	"apellido" => $user->strApellido,
	"empresa" => $user->strEmpresa,
	"fecha" => date('d/m/Y'),
	"items" => Template::itemPedido($shop->all()),
	"total" => $shop->getTotal(),
	"direccion" => (!empty($user->domicilio_entrega) ? "Domicilio de entrega: ".$user->domicilio_entrega : ""),
	"ciudad" => (!empty($user->ciudad) ? "Ciudad: ".$user->ciudad: ""),
	"codigo_postal" => (!empty($user->cp) ? "Codigo Postal: ".$user->cp : ""),
	"telefono" => (!empty($user->telefono) ? "Telefono: ".$user->telefono : "" ),
	"logo" => (!empty($user->logo) ? $image_url.$user->logo : "")
));


/**
 * Checkeo el vencimiento
 * @var TempStock
 */
$checkVencimiento = new TempStock();
$can = $checkVencimiento->fechaVencimiento($_SESSION['MM_IdUsuario']);
	if($can):
		header('Location: catalogo.php');
	endif;



/**
 * Confirmo la compra
 */
if( !(new Compra())->confirm() ){
	header('Location: catalogo.php');
}


	
/**
 * Envio el email, se desactiva si debug es true
 */
if(!Debug\DBParameters::$debug){



		require("classes/PHPMailerAutoload.php");

		
		$mail = new PHPMailer;
	
		
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = 'mail.productosnufarm.com';  // Specify main and backup server
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'mknet@productosnufarm.com';                            // SMTP username
		$mail->Password = 'mkn1243';                           // SMTP password
		$mail->SMTPSecure = 'tls';                              // Enable encryption, 
		$mail->From = 'maxx@nufarm-maxx.com';
		$mail->FromName = 'MarketingNet ';
		// $mail->addAddress('mknet@productosnufarm.com', '--');
		$mail->addAddress($user->strEmail, '--');


		//$mail->addAddress($email_user, '--');
		 // $mail->addAddress('facundo@dot175.com', '--');		// Add a recipient
		// $mail->addBCC($email_user, '--');
		$mail->isHTML(true);                                  // Set email format to 
		
		$mail->Subject =  'Nufarm Maxx';
		$mail->Body    = $template->get();

		$mail->send();

		$mail->clearAddresses();
		$mail->addAddress('maxx@nufarm-maxx.com', '--');

		$mail->send();

		$mail->clearAddresses();
		$mail->addAddress('ezequiel@dot175.com', '--');

		$mail->send();


}



header('Location: confirmacion-carrito.php');

