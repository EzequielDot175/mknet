<?php 
	
	/**
	* @internal Comentarios del usuario
	*/
	class Consulta extends DB
	{

		/**
		 * Traits
		 */
		use Facade;

		private $auth;

		public function __construct()
		{
			parent::__construct();
			$this->auth = Auth::id();
		}

		/**
		 * @internal public method
		 */
		public function consultaByAuth(){
			$id = Auth::id();
			$sel = $this->prepare(self::CONSULTA_GET);
			$sel->bindParam(':id', $id, PDO::PARAM_INT );
			$sel->execute();

			return $sel->fetchAll();
		}

		public function respuestas($id){
			$sel = $this->prepare(self::CONSULTA_GETRESPONSE);
			$sel->bindParam(':id', $id, PDO::PARAM_INT);
			$sel->execute();
			return $sel->fetchAll();
		}

		public function create($vars){
			$consulta = (Object)$vars;
			$ins = $this->prepare(self::CONSULTA_NEW);
			$ins->bindParam(':asunto',$consulta->asunto,PDO::PARAM_STR);
			$ins->bindParam(':id',$this->auth,PDO::PARAM_INT);
			$ins->bindParam(':campo',$consulta->descripcion,PDO::PARAM_STR);
			$ins->execute();
		}

		public function getById($id){
			$sel = $this->prepare(self::CONSULTA_BY_ID);
			$sel->bindParam(':id',$id,PDO::PARAM_INT);
			$sel->execute();
			return $sel->fetch();
		}
		public function getFullById($id){
			$sel = $this->prepare(self::CONSULTA_FULL_BY_ID);
			$sel->bindParam(":id", $id, PDO::PARAM_INT);
			$sel->execute();
			$sel = $sel->fetchAll();

			return self::formatCollection($sel);
		}
		public function response($params){
			$obj = (Object)$params;

			$insert = $this->prepare(self::CONSULTA_CREATE_RESPONSE);
			$insert->bindParam(':msg', $obj->msg, PDO::PARAM_STR);
			$insert->bindParam(':id',$obj->id,PDO::PARAM_INT);
			$insert->execute();
			if($insert->rowCount() > 0){
				$this->updateStatus($obj->id);
			}

		}

		public function updateStatus($id = 0){
			$upd = $this->prepare(self::CONSULTA_UPDATE_STATUS);
			$upd->bindParam(':id',$id,PDO::PARAM_INT);
			$upd->execute();
			return ($upd->rowCount() > 0 ? true : false);
		}


		public static  function formatCollection($collection){
			$consultas = array();
			foreach($collection as $key => $val):
				if($val->tipo == 1):
					$consultas[$val->idConsulta] = $val;
					$consultas[$val->idConsulta]->{'respuestas'} = array();
				endif;
			endforeach;

			foreach($collection as $key => $val):
				if($val->tipo == 2):
					if(isset($consultas[$val->respuesta_de])){
						$consultas[$val->respuesta_de]->{'respuestas'}[] = $val;
					}
				endif;
			endforeach;

			return $consultas;
		}

		public function getAdmin(){
			$sel = $this->query(self::CONSULTA_ALL)->fetchAll();

			return self::formatCollection($sel);

			
		}

		public function getAdminByVendedor($id,$status){
			$sel = $this->prepare(self::CONSULTA_BY_ID_AND_STATUS);
			$sel->bindParam(":seller", $id, PDO::PARAM_INT);
			$sel->bindParam(":status", $status, PDO::PARAM_INT);
			$sel->execute();
			$sel = $sel->fetchAll();


			return self::formatCollection($sel);
		}

		public function getBySeller($id){
			$sel = $this->prepare(self::CONSULTA_BYSELLER);
			$sel->bindParam(":seller", $id, PDO::PARAM_INT);
			$sel->execute();
			$sel = $sel->fetchAll();

			return self::formatCollection($sel);

		}

		public static function formatDate($input){
			$date = new DateTime($input);
			echo $date->format('d/m/Y');
		}

		public static function formatTime($input){
			$date = new DateTime($input);
			echo $date->format('H:i:s');
		}

		/**
		 * @internal public method
		 */

		public function lastConsulta(){

			$sel = $this->prepare(self::CONSULTA_LAST);
			$sel->bindParam(':id',$this->auth, PDO::PARAM_INT);
			$sel->execute();
			return $sel->fetch();
		}

		public function userByConsulta($id){
			$sel = $this->prepare(self::CONSULTA_GET_USER_BY_CONS);
			$sel->bindParam(':id',$id, PDO::PARAM_INT);
			$sel->execute();
			return $sel->fetch();
		}

		public function getByStatus($id){
			$sel = $this->prepare(self::CONSULTA_BYSTATE);
			$sel->bindParam(":status", $id, PDO::PARAM_INT );
			$sel->execute();
			$sel = $sel->fetchAll();

			return self::formatCollection($sel);
		}

		public function filtro(){


				$vendedores =  ( isset($_POST['vendedores']) ? (string)$_POST['vendedores'] : '');
				$estado = ( isset($_POST['estado']) ? (string)$_POST['estado'] : '');


				if( $vendedores == "" && $estado != "" ):
					return $this->getByStatus($estado);
				elseif( $vendedores != "" && $estado == "" ):

					return $this->getBySeller($vendedores);
				elseif( $vendedores != "" && $estado != "" ):
					return $this->getAdminByVendedor($vendedores,$estado);
				else:
					return $this->getAdmin();
				endif;
		}


		/**
		 * @internal INTERFAZ STATICA
		 */


		/**
		 * @internal public static method from create
		 */
		public static function newConsulta($vars){
			return self::method('create', $vars);
		}
		/**
		 * @internal public static method from lastConsulta
		 */

		public static function all(){
			return self::method('consultaByAuth');
		}
		/**
		 * @internal public static method from lastConsulta
		 */
		public static function respuesta($id){
			return self::method('respuestas',$id);
		}

		/**
		 * @todo
		 * Create a new response
		 */
		public static  function newResponse($msg = "",$id){
			return self::method('response',array(
				"msg" => $msg,
				"id" =>$id
			));
		}

		/**
		 * @internal public static method from lastConsulta
		 */
		public static function last(){
			return self::method('lastConsulta');
		}
		/**
		 * @internal public static method from lastConsulta
		 */
		public static function getUserByConsulta($id){
			return self::method('userByConsulta', $id);
		}

		/**
		 * @internal public static method from lastConsulta
		 */
		public static function byId($id){
			return self::method('getById', $id);
		}
		
	}

 ?>