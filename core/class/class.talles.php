<?php 
	
	namespace Core;

	use \PDO;
	/**
	* 
	*/
	class Talles extends \DB  
	{
		
		function __construct()
		{
			parent::__construct();
		}

		public function getAllById($id){
			$sel = $this->prepare(self::TALLES_GETBYID);
			$sel->bindParam(':id',$id, PDO::PARAM_INT);
			$sel->execute();

			return $sel->fetchAll();
		}

		public function getStock($id_prod,$size){
			$sel = $this->prepare(self::TALLES_GETSTOCK);
			$sel->bindParam(':prod',$id_prod);
			$sel->bindParam(':size',$size);
			$sel->execute();

			$result = $sel->fetch();
			if($result){
				return $result->cantidad;
			}else{
				return false;
			}
		}

		public function takeStock($id_prod,$size,$count){
			
			$current = $this->getStock($id_prod,$size);
			$stock = $current - $count;

		
			
			$sel = $this->prepare(self::TALLES_TAKESIZECHOTHING);
			$sel->bindParam(':prod',$id_prod,PDO::PARAM_INT);
			$sel->bindParam(':size',$size,PDO::PARAM_INT);
			$sel->bindParam(':count',$stock,PDO::PARAM_INT);
			$sel->execute();

			return $sel->rowCount();
		}

	}

 ?>