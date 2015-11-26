<?php
ob_start();
if (!isset($_SESSION)) {
  session_start();
}


require_once('libs.php'); 
require_once('includes/class.compras.php');
error_reporting(E_ALL);
ini_set('display_errors', 'On');


if(!Usuario::sCheckPoints()):
	@header('Location: carrito.php');
	exit();
endif;


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


$checkVencimiento = new TempStock();
$can = $checkVencimiento->fechaVencimiento($_SESSION['MM_IdUsuario']);
	if($can):
		header('Location: catalogo.php');
	endif;


(new Compra())->confirm();




die;


//este checkout y mensaje ponerlo dentro de la confirmacion!




 /**
  * Updateo el dblConsumido directamente desde el carrito de compras
  */
// Usuario::sumConsumido();

//Aqui comienza el proceso posterior al pago, si existe la como TRUE la variable checkout se realiza la tarea de ingresar pago a la tabla, descontar credito del usuario, etc.
 

	
	//HAY PAGO REALIZADO
	//$tipoDePago = 2; //cambiar el valor a los medios de pagos posibles. puede pasarse el valor directamente a la clase en su llamado de la funcion.
	
	//require_once("includes/class.carrito.php");
	//$carrito= new carrito();
	//$carrito->select_by_user($_SESSION["MM_IdUsuario"],$tipoDePago, ObtenerIVA());
	
	
	#informacion del usuario
	

	// require_once("includes/class.usuarios.php");
	// $dtuser = new usuarios();
	// $dtuser->select($_SESSION["MM_IdUsuario"]);
	// $nombre_user = $dtuser->getstrNombre();
	// $apellido_user = $dtuser->getstrApellido();
	// $empresa_user = $dtuser->getstrEmpresa();
	// $email_user = $dtuser->getstrEmail();
	

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
		$mail->addAddress($email_user, '--');


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

