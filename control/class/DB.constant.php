<?php 
	// require_once('../../core/pdo/debug.db.php');
	//echo realpath(__DIR__ . '/../..').'/core/pdo/debug.db.php';
	require_once(realpath(__DIR__ . '/../..').'/core/pdo/debug.db.php');
	use Debug\DBParameters;
	/**
	* 
	*/
	class DB extends PDO implements DBInterface
	{
		private $dbname = "";
		private $dbuser = "";
		private $dbpass = "";
		

		public function __construct()
		{
			DBParameters::construct();

			parent::__construct('mysql:host='.DBParameters::Hostname().';dbname='.DBParameters::dbname(), DBParameters::Username(), DBParameters::password(),array(
			    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
			  ));
			// parent::setFetchMode(PDO::FETCH_OBJ);
			$this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
		}

		/**
		 * @internal Method: Trae los atributos definidos por la clase que no esten vacios y sean publicos
		 */

		protected function getAttributes(){
			$attributes = new ReflectionClass($this);
	 		$attr = $attributes->getProperties(ReflectionProperty::IS_PUBLIC);
	 		$props = [];
	 		foreach ($attr as $key => $value) {
	 			$props[$value->name] = $this->{$value->name};
	 		}
	 		return $props;
		}

		protected function select(){
			$all = $this->prepare(self::QUERY_ALL_TABLE);
			$all->bindParam(':tb',$this->table,PDO::PARAM_STR);
			$all->execute();
			return $all->fetchAll();
		}

		/**
		 * @return: Devuelve un resultado
		 */
		protected function getRow($sql){
			$sel = $this->prepare($sql)->execute()->fetch();
		}
		/**
		 * @return: Devuelve todos los resultados
		 */
		protected function getRows($sql){
			$sel = $this->prepare($sql);
			$sel->execute();
			return $sel->fetchAll();
		}



	}
 ?>