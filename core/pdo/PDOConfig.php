<?php 
	/**
	* 
	*/
	use Debug\DBParameters;



	class PDOConfig extends PDO implements SqlConstant
	{
		private $dbname = "";
		private $dbuser = "";
		private $dbpass = "";

		public function __construct()
		{
			DBParameters::construct();

			parent::__construct('mysql:host='.DBParameters::Hostname().';dbname='.DBParameters::Dbname(), DBParameters::Username(), DBParameters::Password());
		}

		/**
		* @param sql string
		* @return SQL results (many)
		*/
		protected function result($sql){
			return $this->query($sql)->fetchAll(PDO::FETCH_OBJ);
		}
		/**
		* @param sql string
		* @return SQL result (one)
		*/
		protected function get($sql){
			return $this->query($sql)->fetch(PDO::FETCH_OBJ);
		}

	}


 ?>


 