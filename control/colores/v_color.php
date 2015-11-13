<?php header('Content-Type: text/html; charset=utf-8');
include_once('../resources/control.php');
include_once('helper_titulos.php');
require_once("../../libs.php");

$colours = new \Factory\Colours();
$all = $colours->getAll();
?>
<!DOCTYPE html>
<html>
<head>

	<title></title>



	<!-- charset -->
	<meta charset="utf-8">
	<!-- Mobile Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<!-- Description -->
	<meta name="description" content="">

	<?php include_once('../resources/includes.php'); ?>




</head>


<body>

<!-- Header -->

	<?php include_once('../inc/header.php') ?>


<div class="block">

<div class="three_4">



<?php

if($_SESSION['msg_ok']){echo '<div class="notify_ok"><p>'.$_SESSION['msg_ok'].'</p></div>'; unset($_SESSION['msg_ok']);}
if($_SESSION['msg_error']){echo '<div class="notify_error"><p>'.$_SESSION['msg_error'].'</p></div>'; unset($_SESSION['msg_error']);}
if($_SESSION['msg_warning']){echo '<div class="notify_warning"><p>'.$_SESSION['msg_warning'].'</p></div>'; unset($_SESSION['msg_warning']);}

?>

	<!-- CONTENT -->
	<div id="content-prod" class="color-content">
		<div class="barra-prod">
			<span>ADMINISTRAR COLORES</span>
		</div>

		<?php foreach($all as $k => $v): ?>
		<div class="item-box-talles">

			<div class="box-t">
				<div class="box-dt"></div>
				<span><?php echo $v->nombre_color ?></span>
			</div>

			<a class="BtnTalle" href="e_color.php?id=<?php echo $v->id_color ?>">ADMINISTRAR</a>
			<a class="BtnTalle" href="d_color.php?id=<?php echo $v->id_color ?>">ELIMINAR</a>

		</div>
		<?php endforeach ?>
		<a  class="cat-add" href="n_color.php">CREAR NUEVO</a>
	</div>
	<!-- CONTENT -->

</div>
	<?php include_once('../inc/footer.php') ?>
	</div><!-- end block -->
</body>
</html>

