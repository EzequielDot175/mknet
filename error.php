

<?php require('inc/header.php'); @session_start(); ?>
<!-- header -->


	<!--detalle productos-->
	<div class="confirmacion-carrito carrito-productos col-xs-12 col-sm-12 col-md-12 ol-lg-12">

		<!--head-page-->
		<div class="head-page col-xs-12 col-sm-12 col-md-12 ol-lg-12">
			<h3><?php echo (isset($_SESSION['notification']) ? $_SESSION['notification'] : '') ?></h3>
		</div>
		<!--end / head-page-->

		<!-- footer carrito -->
		<div class="footer-carrito col-xs-12 col-sm-12 col-md-12 ol-lg-12">
			<!-- botones -->
			<div class="col-xs-12 col-sm-9 col-md-9 ol-lg-9">
				<div class='block-botones'>
					<a href="carrito.php"><button class="boton" type="">VOLVER</button></a>
				</div>
			</div>
			<!--end /  botones -->
		</div>
		<!-- end / footer carrito -->


	</div>
	<!--end / historial productos-->

	<?php 

		unset($_SESSION['notification']);

	 ?>

<!-- Footer -->
<?php require('inc/footer.php') ?>