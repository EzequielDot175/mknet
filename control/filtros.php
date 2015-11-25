<?php 
	require_once('../libs.php');
	Auth::checkAdmin();
 ?>

<!DOCTYPE html>
<html lang="es" ng-app="nufarmMaxx">
	<head>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
		<title>Marketing Net</title>

		<!-- librerías opcionales que activan el soporte de HTML5 para IE8 -->
		<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
		<![endif]-->

		<!-- CSS de -->
		<link rel="stylesheet" type="text/css" media="all" href="layout/main.css" />
		<link rel="stylesheet" type="text/css" media="all" href="layout/tables.css" />

		<style>
			.resultados{
				margin-top: 20px;
			}
			.item{
				width: 100%;
				min-height: 50px;
				background: #F3F3F3;
			}
			.dataCompra{
				width: 15%;
				display: inline-block;

			}
			.dtCompra{
				width: 75%;
				display: inline-block;
			}
			.row{
				display: inline-block;
				width: calc( 100% / 7 ); 
			}
		</style>
	</head>
<body>
	
<!-- Header -->
<header>
<!--[if lt IE 9]>
<script type="text/javascript">
   document.createElement("nav");
   document.createElement("header");
   document.createElement("footer");
   document.createElement("section");
   document.createElement("article");
   document.createElement("aside");
   document.createElement("hgroup");
</script>
<![endif]-->

<!--[if lt IE 8]>
<script type="text/javascript">
   document.createElement("nav");
   document.createElement("header");
   document.createElement("footer");
   document.createElement("section");
   document.createElement("article");
   document.createElement("aside");
   document.createElement("hgroup");
</script>
<![endif]-->

<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<div id="top"></div>
<div id="logo">
	<a href="../index.php"><img src="../imagenes/logo2-02.png" alt="Nufarm"> </a>
</div>
<div id="header_bg_img"><div class="subheader"><span class="adminwelcome">Administrador Marketingnet </span>
	<!--<div class="prop"></div>-->
</div></div>
<ul><li class="cerrar_sesion"><a href="logout.php">Cerrar sesion X</a></li></ul>		
</header>
<div class="main_menu">
				



<div class="menu">
        <a href="filtros.php">
            <li class="seleccionado">REPORTES</li>
        </a>
        <a href="compras/v_compras.php?activo=1&amp;sub=c">
        	<li >PRODUCTOS CANJEADOS</li>
        </a>
        <a href="productos/v_productos.php?activo=2&amp;sub=d">
       	 <li >CARGA DE PRODUCTOS</li>
        </a>
        <a href="usuarios/v_usuarios.php?activo=2&amp;sub=e&amp;vert=1">
        	<li >CLIENTES</li>
        </a>
        <a href="personal/v_personal.php?activo=2&amp;sub=h">
        	<li >VENDEDORES</li>
        </a>
        <a href="consultas/v_consultas.php?activo=2&amp;sub=f&amp;orden=1">
            <li >CONSULTAS</li>
        </a>
  </div>







				
				<!--<div class="search_box">
				<form action="http://localhost/ftp/nufarmMaxx/control//busquedas/busquedas.php" method="post">
				<input type="text" value="BUSCAR" name="busqueda" id="busqueda" />
				</form>
				</div>-->
</div>

<!-- Header -->



	<!-- PAGE -->
	<div class="block">
		
		<div class="prod_container block-filtros ">

			<!--FILTROS-->
			<div class="filtro">
				<div class="panel filtros-Default filtros-Violeta" ng-controller="FiltroController" >

					<!-- form-->
					<form ng-submit="filter();">

						<div class="filtros-w100 filtros-Verde ">			
							<div class="radio">
								<input type="radio" checked value="1" name="fetchBy">
								<label for="" >Ver filtros en resultados</label>
							</div>
							<!-- <div class="radio">
								<input type="radio" value="2" name="fetchBy">
								<label for="">Ver filtros en estadisticas</label>
							</div> -->
						</div>


					<div>
							<div class="filtros-Default filtros-100">
				            	<h3> FILTRAR POR:</h3>
								<select name="" id="" ng-model="select_vendedores" ng-change="setCliente()" ng-options="v.value as v.text for (k, v) in vendedores" >
									<option value="">TODOS LOS VENDEDORES</option>
								</select> 
								<select name="" id="" ng-model="filtro.clientes"  ng-options="v.value as v.text for (k, v) in clientes track by v.text">
									<option value="">TODOS LOS CLIENTES</option>
								</select>
							</div>

							<!--<div class="filtros-Default filtros-50">
				            			<h3> FILTRAR CANJES POR :</h3>
								<select name="" id="" ng-model="filtro.cant_canjes">
									<option value="" selected>CANTIDAD DE CANJES</option>
									<option value="10">Hasta 10 canjes</option>
									<option value="20">Hasta 20 canjes</option>
									<option value="30">Hasta 30 canjes</option>
								</select>
								<select name="" id="" ng-model="filtro.punt_disponibles">
									<option value="" selected>Puntos disponibles</option>
									<option value="0">Entre 0 y 1000</option>
									<option value="1">Entre 1000 y 2000</option>
									<option value="2">Entre 2000 y 3000</option>
									<option value="3">Entre 3000 y 4000</option>
									<option value="4">Entre 4000 y 5000</option>
									<option value="5">Mas de 5000</option>
								</select>
							</div>-->
						</div>

						<div class="filtros-Default filtros-100 filtro-bottom">
			            			<h3> FILTRAR ACTIVIDAD POR:</h3>
							<div class="filtros-w100 filtros-A">
								<select name="" id="" ng-model="filtro.prod_canjeado" ng-options="v.value as v.text for (k, v) in select_prod_canjeado">
									<option value="">Producto canjeado</option>
								</select>
								<select name="" id="" ng-model="filtro.estado">
									<option value="">ESTADO</option>
									<option value="1">PEDIDO REALIZADO</option>
									<option value="2">PEDIDO EN PROCESO</option>
									<option value="3">PEDIDO ENVIADO</option>
									<option value="4">PEDIDO ENTREGADO</option>
								</select>
							</div>
							<div class="filtros-w100 filtros-B">
								<label class="fecha" for="">Desde</label>
								<input type="date" ng-model="filtro.desde" class="typeDate" ng-change="clearByType();" placeholder="Date">
								<label class="fecha"  for="">Hasta</label>
								<input type="date" ng-model="filtro.hasta" class="typeDate" ng-change="clearByType();">
								<div class="radio">
									<!--<input type="radio" name="typeSearch" ng-model="filtro.typeSearch" value="byWeek" class="typeSelection" >-->
									<input type="checkbox" ng-model="byWeek"  class="typeSelection" ng-change="setSearchType()">
									<label for="">Ultimo semana</label>
								</div>
								<div class="radio">
									<!--<input type="radio" name="typeSearch" ng-model="filtro.typeSearch" value="byMonth" class="typeSelection" >-->
									<input type="checkbox" ng-model="byMonth" class="typeSelection" ng-change="setSearchType()">
									<label for="">Ultimo mes</label>
								</div>	
							</div>	
						</div>
						
						<div class="block-botones">
							<button class="button-image" type="submit" ><img src="layout/ver.png" alt=""> VER LISTADO DE RESULTADOS </button> 
							<button class="button-image" ng-click="excel()" prevent-default> <img src="layout/excel.png" alt="">DESCARGAR RESULTADOS EN EXCEL </button>
						</div>
					</form>
					<!-- end / form-->

				</div>
			</div>
			<!--END / FILTROS-->

		</div>
		<div class="prod_container block-resultados" ng-controller="ResultsController" style="margin-top: 4px;">
			<section class="filters-table">
	            <h3>
	            	Resultados:
	            </h3>
	            <div id="table-header">
	                <div>
	                    <p>producto</p>
	                </div>
	                <div>
	                    <p>total puntos</p>
	                </div>
	                <div>
	                    <p>color</p>
	                </div>
	                <div>
	                    <p>cantidad</p>
	                </div>
	                <div>
	                    <p>talle</p>
	                </div>
	                <div>
	                    <p>remito</p>
	                </div>
	                <div>
	                    <p>estado</p>
	                </div>
	            </div>

	            <div class="table-item" ng-repeat="(k,v) in results">
	            	<div class="item-top">
	            		<p>
	            			<!--30/07/2015 21:44-->
							{{v.date | date:'dd/MM/yyyy hh:mm'}}
	            		</p>
	            		<p>
            				{{v.company}} <span>|</span> VENDEDOR RTC: {{v.seller}}
	            		</p>
	            	</div>

	            	<div class="prod-list">

	            		<div class="prod-item" ng-repeat="(key, prod) in v.details">

	            			<div class="prod-det">
	            				<div>
		            				<img ng-src="../images_productos/{{prod.img}}"/>
		            				<p class="name">
		            					<span class="span-name">
		            						{{prod.name}}
		            					</span>

		            					<span class="price">
		            						{{prod.price}}
		            					</span>
		            				</p>
	            				</div>
	            			</div>

	            			<div class="pts">
	            				<p>
									{{prod.total}}
            					</p>
	            			</div>

	            			<div class="color">
	            				<p>
									{{prod.colour}}
        						</p>
	            			</div>

	            			<div class="cant">
	            				<p>
									{{prod.count}} U
            					</p>
	            			</div>

	            			<div class="size">
	            				<p>
									{{prod.size}}
            					</p>
	            			</div>

	            			<div class="pre-bill">
	            				<p>
									{{prod.refer}}
            					</p>
	            			</div>

	            			<div class="status">
	            				<p>
									{{prod.status}}
	            				</p>
	            			</div>
	            		</div>

	            	</div>

	            </div>
            </section>
		</div>
	</div>
	<!-- END / PAGE -->


	<script src="js/jquery-1.11.3.min.js"></script>
	<script src="js/angular/angular.min.js"></script>
	<script src="js/angular/app_filtro.js"></script>
	<script src="js/angular/services.js"></script>
	<script src="js/angular/directives.js"></script>
	<script src="js/angular/controller.js"></script>
	<script>
	jQuery(document).ready(function($) {
		$('.typeDate').on('change', function(event) {
			event.preventDefault();
			$('.typeSelection').prop('checked', false);
		});
		$('.typeSelection').on('change', function(event) {
			event.preventDefault();
			$('.typeDate').val("");
		});
	});
	</script>

</body>
</html>