<?php 

	/**
	* @internal Clase que controla las compras
	*/

if(!class_exists('compra')):


	class Compra extends DB
	{
		use Facade;
		
		public function __construct()
		{
			parent::__construct();

			/**
			 * @param [INT] $[limit] [LIMIT {n}]
			 */
			$this->limit = 200;
		}
		public function byId(){

		}

		/**
		 * @param :num {Numero del total} 
		 * @param :user {id User} 
		 * @param :id {id compra} 
		 */
		public function setTotal($num, $user, $id){
			$upd = $this->prepare(self::DTCOMPRA_SET_TOTAL);
			$upd->bindParam(':num', $num,PDO::PARAM_INT);
			$upd->bindParam(':user', $user,PDO::PARAM_INT);
			$upd->bindParam(':id', $id,PDO::PARAM_INT);
			if(!$upd->execute()):
				throw new PDOException("Error, setTotal not work", 1);
			endif;
		}

		/**
		 * This function create a new Compra
		 * @return [int] [id] on success
		 * @return [boolean] on error
		 */
		public function create($user,$total){
			date_default_timezone_set('America/Argentina/Buenos_Aires');
			$date = date('Y-m-d H:i:s');


			$this->beginTransaction();
			
			$result = array('success' => false,'id' => 0);
			try {
				$ins = $this->prepare(self::COMPRA_CREATE);
				$ins->bindParam(':user',$user,PDO::PARAM_INT);
				$ins->bindParam(':date',$date,PDO::PARAM_INT);
				$ins->bindParam(':total',$total,PDO::PARAM_INT);
				$ins->execute();

				$result['success'] = ($ins->rowCount() > 0 ? true : false );
				$result['id'] = $this->lastInsertId();
				$this->commit();

			} catch (Exception $e) {
				$this->rollback();
				echo $e->getMessage();
			}

			return (Object)$result;
		}


		/**
		 * 
		 */
		public function Confirm(){
			$auth =  new Auth();
			$shop = new ShoppingCart();
			$user = $auth->id();
			$myShop = $shop->all();
			$objDetails = new DetalleCompra();

			$total = 0;

			if(empty($myShop)){
				return false;
			}
			foreach($myShop as $key => $val):
				$total += ($val->precio * $val->cantidad);
			endforeach;

			$result_insert = $this->create($user, $total);

			if ($result_insert->success) {
				foreach($myShop as $k => $v):

					try {
						$objDetails->create($result_insert->id, $v->id_prod, $v->name, $v->cantidad, $v->precio, $v->talle, $v->color);
						//$stock = new TempStock();
						//echo $stock->removeTempStock($user,$v->id_prod,$v->id_talle,$v->id_color,$v->type);
					} catch (Exception $e) {
						echo($e->getMessage());
					}

				endforeach;
				$auth->restPoints($total);
				$auth->sumConsumed($total);
				$shop->removeAll();
				return true;
			}

		}

		/**
		 * @internal id : id compra
		 */
		public function delete($id){
			$del = $this->prepare(self::COMPRA_DELETE);
			$del->bindParam(':id', $id, PDO::PARAM_INT);
			if(!$del->execute()):
				throw new PDOException("Error, no se pudo borrar la compra id".$id, 1);
			endif;
		}

		public function isEmpty($id){
			$sel = $this->prepare(self::COMPRA_EMPTY);
			$sel->bindParam(':id', $id, PDO::PARAM_INT);
			$sel->execute();
			return (Boolean)$sel->fetch(PDO::FETCH_OBJ)->empty;
		}

		public function allCompras(){
			$compras = array();
			$collection = $this->query(self::COMPRA_ALL)->fetchAll();

			foreach($collection as $key => $val):
				$compras[$val->id_compra][] = $val;
			endforeach;

			return array_reverse($compras);
		}

		public function paginator(){
			
			if(isset($_GET['page'])):
				$page = ( $_GET['page'] > 1 ? $_GET['page'] : 0);
				return ' LIMIT '.$this->limit*$page.','.$this->limit;
			else:
				return ' LIMIT 0,'.$this->limit;
			endif;
		}

		public function barPag(){

			/*echo "<pre>";
			var_dump($this->cantidad());
			var_dump($this->limit);
			echo "<pre>";
			die;*/

			$paginas = ceil(($this->cantidad() / $this->limit));
			return $paginas;

		}

		public function cantidad(){
			return $this->query(self::COMPRA_COUNT)->fetch()->count;
		}

		public function estados(){
			return array(
            	'1' =>  'PEDIDO REALIZADO',
            	'2' =>  'PEDIDO EN PROCESO',
            	'3' =>  'PEDIDO ENVIADO',
            	'4' =>  'PEDIDO ENTREGADO'
			);
		}

		public function orderBy(){
			return " ORDER BY compra.idCompra DESC ";
		}

		public static function all(){
			return self::method('allCompras');
		}

		public static function optionsEstado($selected = null){
			$array = self::method('estados');
			$html = "";
			foreach($array as $key => $val):
				if(!is_null($selected)):
					if($selected == $key):
						$html .= '<option selected="" value="'.$key.'">'.$val.'</option>';
					else:
						$html .= '<option value="'.$key.'">'.$val.'</option>';
					endif;
				else:
					$html .= '<option value="'.$key.'">'.$val.'</option>';
				endif;
			endforeach;
			echo($html);
		}

		public static function sBarPag(){
			return self::method('barPag');
		}


	}


endif;

if(!class_exists('DetalleCompra')):


	/**
	 * @internal Clase controladora de los items individuales por compra
	 */
	class DetalleCompra extends DB{

		use Facade;


		public function __construct()
		{
			parent::__construct();
		}

		public function refund($id){
			$compra = new Compra();
			$usuario = new Usuario();
			$stock = new Stock();
			$tempMaxCompra = new TempMaxCompra();
			$info = $this->joinCompra($id);
			/**
			 * @internal Resto de la compra
			 * @param num
			 * @param user
			 * @param id
			 */
			$newTotal = $info->total - $info->pagado;
			

			try {
				
				/**
				 * @php Seteo la devolucion del stock personal (maximos y minimos)
				 */
				
				$historial = new HistorialCredito();



				$remains = new stdClass();
				$remains->{'intCantidad'} =  $info->cantidad;
				$remains->{'idProducto'} =  $info->producto;
				$remains->{'idUsuario'} =  $info->user;
				$tempMaxCompra->setUser($info->user);
				$tempMaxCompra->storeRemains(null,$remains);

				$compra->setTotal($newTotal, $info->user , $info->compra);
				$usuario->sumarCredito($info->pagado,$info->user);
				/**
				 * Agrego historial de compra
				 */
				$historial->add($info->user,$info->pagado);
				/**
				 * Update Consumido 
				 */
				$this->updateConsumido($info->user,$info->pagado);

				$stock->sumStock($info->talle,$info->color,$info->cantidad,$info->producto);
				$this->delete($id);

				if($compra->isEmpty($info->compra)):
					$compra->delete($info->compra);
				endif;

				@header('location: v_compras.php?activo=1&sub=c');
				exit();
			} catch (PDOException $e) {
				echo $e->getMessage();
			}
			

		}

		public function create($id, $prod, $name, $count, $price, $size = "", $colour = ""){
			$this->beginTransaction();
			$result = false;

			if(is_null($size)){
				$size = "";
			}
			if(is_null($colour)){
				$colour = "";
			}


			try {
				$ins = $this->prepare(self::DTCOMPRA_CREATE);
				$ins->bindParam(':compra',$id,PDO::PARAM_INT);
				$ins->bindParam(':producto',$prod,PDO::PARAM_INT);
				$ins->bindParam(':nombre',$name,PDO::PARAM_STR);
				$ins->bindParam(':cantidad',$count,PDO::PARAM_INT);
				$ins->bindParam(':precio',$price,PDO::PARAM_INT);
				$ins->bindParam(':talle',$size,PDO::PARAM_STR);
				$ins->bindParam(':color',$colour,PDO::PARAM_STR);
				$ins->execute();
				$this->commit();

				$result = ($ins->rowCount() > 0 ? true : false );
			} catch (Exception $e) {
				$this->rollback();
				echo $e->getMessage();
			}

			return $result;
		}

		public function delete($id){
			$del = $this->prepare(self::DTCOMPRA_DELETE);
			$del->bindParam(':id',$id,PDO::PARAM_INT);
			if(!$del->execute()):
				throw new PDOException("Error, no se pudo borrar el detalle de la compra", 1);
			endif;
		}
		public function byId($id){
			$sel = $this->prepare(self::DTCOMPRA_BYID);
			$sel->bindParam(':id',$id,PDO::PARAM_INT);
			$sel->execute();
			return $sel->fetch(PDO::FETCH_OBJ);
		}
		public function allDetails($id){
			$sel = $this->prepare(self::DTCOMPRA_ALLDETAILSBYID);
			$sel->bindParam(':id',$id,PDO::PARAM_INT);
			$sel->execute();
			return $sel->fetch(PDO::FETCH_OBJ);
		}
		public function joinCompra($id){
			$sel = $this->prepare(self::DTCOMPRA_JOINCOMPRA);
			$sel->bindParam(':id',$id,PDO::PARAM_INT);
			$sel->execute();
			return $sel->fetch(PDO::FETCH_OBJ);
		}

		public function updateConsumido($user,$cant){
			$upd = $this->prepare(self::COMPRA_REFUND_CONS);
			$upd->bindParam(':cant',$cant, PDO::PARAM_INT);
			$upd->bindParam(':id', $user, PDO::PARAM_INT);
			$upd->execute();

			return $upd->rowCount();
		}


		public function updEstado($params){
			$estado = (int)$params->estado;
			$remito = (int)$params->remito;
			$id = (int)$params->id;
			$upd = $this->prepare(self::DTCOMPRA_UPDESTADO);
			$upd->bindParam(':estado', $estado);
			$upd->bindParam(':remito', $remito);
			$upd->bindParam(':dtid', $id);
			return $upd->execute();
		}

		public static function upd($id,$estado,$remito){

			$params = new stdClass();
			$params->{'estado'} = $estado;
			$params->{'remito'} = $remito;
			$params->{'id'} = $id;

			return self::method('updEstado',$params);
		}
	}

endif;

 ?>