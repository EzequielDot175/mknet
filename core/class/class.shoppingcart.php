<?php 
	
	/**
	* @internal Clase controladorea del carrito
	*/
	class ShoppingCart extends DB
	{

		private $total = 0;
		private $count = 0;
		private $user_id;

		public function __construct()
		{
			parent::__construct();
			$this->user_id = Auth::id();
		}


		/**
		 * Metodo en el que llama todos los productos del carrito con el usuario logueado
		 * @internal Este metodo tambien setea la cantidad total en credito y la cantidad de productos los cuales son
		 * @param  private $total
		 * @param  private $count
		 */
		public function all(){
			$all = $this->prepare(self::SHOPPINGCART_ALL);
			$all->bindParam(':id',$this->user_id,PDO::PARAM_INT);
			$all->execute();
			$data = $all->fetchAll();

			foreach($data as $key => $val):

				if(is_null($val->talle) && !is_null($val->color)):
					$data[$key]->{'type'} = 2;
				elseif (!is_null($val->talle) && is_null($val->color)):
					$data[$key]->{'type'} = 1;
				elseif (!is_null($val->talle) && !is_null($val->color)):
					$data[$key]->{'type'} = 3;
				else:
					$data[$key]->{'type'} = 0;
				endif;

				$this->total += $val->cantidad * $val->precio;
				$this->count += $val->cantidad;
			endforeach;
			return $data;
		}


		public function total(){
			echo $this->total;
		}
		public function getTotal(){
			return $this->total;
		}

		public  function getType($size, $colour){
			if($this->emptyOrNull($size) && !$this->emptyOrNull($colour)):
				return 2;
			elseif (!$this->emptyOrNull($size) && $this->emptyOrNull($colour) ):
				return 1;
			elseif (!$this->emptyOrNull($size) && !$this->emptyOrNull($size)):
				return 3;
			else:
				return 0;
			endif;
		}

		public function cantidad(){
			echo $this->count;
		}

		public  function emptyOrNull($param){
			if(is_null($param) || $param != ""){
				return false;
			}else{
				return true;
			}
		}


		public function getSum(){
			$sum = $this->prepare(self::SHOPPINGCART_SUM);
			$sum->bindParam(':id', $this->user_id, PDO::PARAM_INT);
			$sum->execute();
			return $sum->fetch()->cantidad;
		}

		public function  remove($id = null){
			if(!is_null($id)){
				$del = $this->prepare(self::SHOPPINGCART_REMOVE);
				$del->bindParam(":id",$id, PDO::PARAM_INT);
				$del->execute();
				return $del->rowCount();
			}
		}

		public function addClothingSizeProduct($prod_id,$count,$size,$user = null){
			
			$user_id = (is_null($user) ? $this->user_id : $user);

			if($this->clothingSizeProductExist($prod_id,$size,$user_id)){
				
				$this->chothingSizeSumByParams($prod_id,$size,$user_id,$count);
			}else{
				
				$this->chotingSizeInsert($user_id,$prod_id,$count,$size);
			}
		}


		public function clothingSizeProductExist($prod_id,$size,$user){
			$sel = $this->prepare(self::SHOPPINGCART_CHECKSIZE);
			$sel->bindParam(':user', $user, PDO::PARAM_INT);
			$sel->bindParam(':prod', $prod_id , PDO::PARAM_INT);
			$sel->bindParam(':size', $size , PDO::PARAM_INT);
			$sel->execute();


			return (Boolean)$sel->fetch()->exist;
		}

		public function chothingSizeSumByParams($prod_id,$size,$user,$count){
			$upd = $this->prepare(self::SHOPPINGCART_SUMSTOCK);
			$upd->bindParam(':user', $user, PDO::PARAM_INT);
			$upd->bindParam(':prod', $prod_id , PDO::PARAM_INT);
			$upd->bindParam(':size', $size , PDO::PARAM_INT);
			$upd->bindParam(':cant', $count , PDO::PARAM_INT);
			$upd->execute();

			return $upd->rowCount();
		}

		public function chotingSizeInsert($user,$prod,$count,$size){
			$ins = $this->prepare(self::SHOPPINGCART_CLOTHINGSIZEINSERT);
			$ins->bindParam(':id',$user,PDO::PARAM_INT);
			$ins->bindParam(':prod',$prod,PDO::PARAM_INT);
			$ins->bindParam(':count',$count,PDO::PARAM_INT);
			$ins->bindParam(':size',$size,PDO::PARAM_INT);
			$ins->execute();

			return $ins->rowCount();
		}



		public static function sum(){
			return (new ShoppingCart())->getSum();
		}








	}

 ?>