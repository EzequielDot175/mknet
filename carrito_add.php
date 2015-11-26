<?php 
ob_start();
require_once('libs.php');
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";



if(!isset($_SESSION)):
	@session_start();
endif;


$tempMaxCompra = new TempMaxCompra();




 	require_once('Connections/conexion.php');

 	// ================================= Cantida minima de producto ============================== //
 	$query = mysql_query("SELECT intMinCompra FROM productos WHERE idProducto = '".$_POST['idProducto']."'");
 	while ($row = mysql_fetch_array($query)) {
 		$minCantidad = $row["intMinCompra"];
 	}

 	// if ($_POST['cantidad'] < $minCantidad) {
		// header("Location: index.php?activo=1&prod=1"); 		
 	// }
 	/**
 	* Objetivo : Proteger por php la cantidad minima requerida de producto a comprar
 	**/
	// =========================================================================================== //
  	$id_producto = $_POST['idProducto'];
	$cantidad_elegida = $_POST['cantidad'];

  	include_once("includes/class.productos.php");
  	$productos= new productos();
	$productos->select($id_producto);
	$categoria=$productos->getintCategoria();
	$StockActual=$productos->getintStock();
	
	include_once("includes/class.categorias.php");
	$cat = new categorias();
	$cat->select($categoria);
	$requiere_talles = $cat->gettalles();
	$talles_seleccionados = $_POST['talle'];
	$colores_seleccionados = $_POST['color'];



	if($requiere_talles==1){


		

		$talles = new Core\Talles();
		$shoppingcart = new shoppingcart();

		$current_size = $talles->getAllById($id_producto);

		/**
		 * Compruebo que pueda pedir estos talles en este momento
		 */
		foreach($current_size as $ckey => $cval):

			if(array_key_exists($cval->id_talle, $talles_seleccionados)){

				$iwant = $talles_seleccionados[$cval->id_talle];
				$ihave = $cval->cantidad;

				if($iwant > $ihave){
					unset($talles_seleccionados[$cval->id_talle]);
				}
				
			}
		endforeach;

		/**
		 * @internal Limpio los talles vacios
		 */
		
		foreach($talles_seleccionados as $key => $val):
			if((int)$val < 1){
				unset($talles_seleccionados[$key]);
			}else{
				$total += (int)$val;
			}
		endforeach;

		/**
		 * Agrego al carrito
		 */

		foreach($talles_seleccionados as $key => $val):
			$shoppingcart->addClothingSizeProduct($id_producto,$val,$key);
		endforeach;

		$tempMaxCompra->storeSum($id_producto,$total);
		// die;
		try {
			$stock = new TempStock();
			$stock->setTalles($id_producto,$talles_seleccionados,$_SESSION['MM_IdUsuario']);	
		} catch (Exception $e) {
			echo($e->getMessage());
		}
		

		
		@header('location: carrito.php');
		
		
	}else if($requiere_talles==2){
		//requiere talles

		$total = 0;
		foreach($colores_seleccionados as $k => $v):
			$total += (int)$v;
		endforeach;
		$tempMaxCompra->storeSum($id_producto,$total);

		try {
			$stock = new TempStock();
			$stock->colores($id_producto,$colores_seleccionados);
		} catch (Exception $e) {
			echo($e->getMessage());
		}


		

		#echo '<h1>SESSION USUSARIO'.$_SESSION['MM_IdUsuario'].'</h1>';
	
		foreach($colores_seleccionados as $id_color => $cantidad_elegida){
			
			
			//prevengo insert with 0
				if($cantidad_elegida > 0 ){
						#echo 'HERE?';
						$id_usuario = $_SESSION['MM_IdUsuario'];
						//primero chequeo si el producto ya existe en el carrito del usuario.
						include_once("includes/class.carrito.php");
						$carr =  new carrito();
						$cantidad_en_carrito = $carr->chequear_producto_con_color($id_usuario,$id_producto, $id_color);
		
						if($cantidad_en_carrito > 0){
																
							//El producto ya existe en el carrito del usuario, solo actualizo la cantidad
							$traigo_id = new carrito();
							$traigo_id->select_by_usuario_producto_color($_SESSION['MM_IdUsuario'],$id_producto,$id_color );
							$id_row = $traigo_id->getintContador();
																
							//Actualizo cantidad
							$update_carrito = new carrito();
							$update_carrito->select($id_row);
							$update_carrito->intCantidad = $cantidad_en_carrito + $cantidad_elegida;
							$update_carrito->update($id_row);
																
							@header('location: carrito.php');
							
							
							
																
															
				}else{
															
															
					//necesito guardarlo desde cero
					include_once("includes/class.carrito.php");
					$carr =  new carrito();
					$carr->idUsuario = $_SESSION['MM_IdUsuario'];
					$carr->idProducto = $id_producto;
					$carr->intCantidad = $cantidad_elegida;
					$carr->color = $id_color;
					$carr->insert();

				}
														
														//hay en stock y guarda la compra.	
									
			}
			
		}
		
		@header('location: carrito.php');
		
		
		
		// echo "<script>window.location.href = 'mi_cuenta.php?activo=2'</script>";



	}
	else if($requiere_talles==3){



		require_once('control/productos/classes/class.tallesColores.php');

		$pedido = $_POST['pedido'];

		$canTotal = 0;



		

		foreach($pedido as $kz => $vz):
			foreach($vz['talle'] as $k => $v):
				$limitSizeColour = $tempMaxCompra->getCurrentStockColourSize($id_producto,$kz,$k);
				var_dump((int)$v);
				if($v <= (int)$limitSizeColour){
					$canTotal += (int)$v;
				}else{
					unset($pedido[$kz]['talle'][$k]);
				}
			endforeach;
		endforeach;


		$limite = $tempMaxCompra->getMaxCompra($id_producto);

		if((int)$canTotal > (int)$limite):
			$_SESSION["notification"] = "Disculpe, no se encuentra disponible la cantidad seleccionada.";
	  		@header('location: carrito.php');
	  		
		endif;

		$tempMaxCompra->storeSum($id_producto,$canTotal);
		

		try {
			$stock = new TempStock();
			$stock->setTallesColores($id_producto,$pedido,$_SESSION['MM_IdUsuario']);
		} catch (Exception $e) {
			echo($e->getMessage());
		}
		

		$id_usuario = $_SESSION['MM_IdUsuario'];
		//primero chequeo si el producto ya existe en el carrito del usuario.
		include_once("includes/class.carrito.php");
		// $carr =  new carrito();
		$x = new tallesColores();



		foreach($pedido as $k => $v):

			foreach($v['talle'] as $kt => $vt):

					if ((int)$vt > 0) {
						if(!$x->productExist($id_usuario,$id_producto,$kt,$k)) {

							$x->usuario = $id_usuario;
							$x->producto = $id_producto;
							$x->color = $k;
							$x->talle = $kt;
							$x->cantidad = $vt;
							$x->insert();
						}else{
							$x->updateShoppingCartItem($vt,$id_usuario,$id_producto,$kt,$k);
						}
					}
			endforeach;
		endforeach;

		@header('location: carrito.php');
		
		
		


	}
	else{
	





		//Hay stock 
		//No requiere talles		
	  	if($cantidad_elegida <= $StockActual){
			
			$tempMaxCompra->storeSum($id_producto,$cantidad_elegida);
			try {
				$stock = new TempStock();
				$stock->setComunes($id_producto,$cantidad_elegida,$_SESSION['MM_IdUsuario']);
			} catch (Exception $e) {
				echo($e->getMessage());
			} 
			//hay en stock y guarda la compra.
			
			//primero chequeo si el producto ya existe en el carrito del usuario.
			include_once("includes/class.carrito.php");
			$carr =  new carrito();
			$cantidad_en_carrito = $carr->chequear_producto($_SESSION['MM_IdUsuario'],$id_producto);
			
			
									if($cantidad_en_carrito > 0){
									
									
										//El producto ya existe en el carrito del usuario, solo actualizo la cantidad
										$traigo_id = new carrito();
										$traigo_id->select_by_usuario_producto($_SESSION['MM_IdUsuario'],$id_producto);
										$id_row = $traigo_id->getintContador();
										
										//Actualizo cantidad
										$update_carrito = new carrito();
										$update_carrito->select($id_row);
										$update_carrito->intCantidad = $cantidad_en_carrito + $cantidad_elegida;
										$update_carrito->update($id_row);
										
										@header('location: carrito.php');
										
										
										
										
									}else{
										//No hay de este producto en el carrito, lo ingreso como nuevo
											
										include_once("includes/class.carrito.php");
									
										$carr =  new carrito();
										$carr->idUsuario = $_SESSION['MM_IdUsuario'];
										$carr->idProducto = $id_producto;
										$carr->intCantidad = $cantidad_elegida;
										$carr->insert();
									
										@header('location: carrito.php');
										
										
										
									}
			
			
			
	  		
	  	}else{

	  		
			
			//No hay stock disponible
			$_SESSION["notification"] = "Disculpe, no se encuentra disponible la cantidad seleccionada.";
	  		@header('location: error.php');
	  		
	  		
	  		

			
	  	}//end else stock
		
	}//end else (requiere talles)


	// header('location: http://nufarm-maxx.com/marketingNetDesarrollo/carrito.php');
@header('location: carrito.php');



?>