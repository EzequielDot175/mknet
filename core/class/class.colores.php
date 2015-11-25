<?php 
	/**
	* 
	*/
	class Color
	{
		private $db = "";

		public function __construct()
		{
			$this->db = new DB();
		}

		public static function get($color){
			$colores = array(
				'verde' => "#009448",
				'negro' => "#000000",
				'gris oscuro' => "#414141",
				'gris' => "#E6E6E6",
				'verde seco' => "#54B649"
			);

			return ( isset($colores[strtolower($color)]) ? "style='background-color: ".$colores[strtolower($color)]."!important;'" : ''	);
		}

		public function getAllColours(){
			echo "<pre>";
			print_r($this->db);
			echo "<pre>";
			die;;
			/*$sel = $this->db->prepare(DBInterface::COLOURS_ALL);
			echo "<pre>";
			print_r($sel);
			echo "<pre>";
			die;*/
		}

	}

 ?>