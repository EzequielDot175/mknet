<?php 
	
	/**
	* Historial Credito
	*/
	class HistorialCredito extends DB
	{
		
		public function __construct()
		{
			parent::__construct();
		}

		public function getByUser(){

		}

		public function add($id,$mounth = 0){
			$date =  date('Y-m-d');
			$by = 'Administracion';
			$modif = 'Puntos reembolsados por eliminacion de compra :'.$mounth;
			$ins = $this->prepare(self::HISTORIAL_ADD);
			$ins->bindParam(':id',$id,PDO::PARAM_INT);
			$ins->bindParam(':date',$date, PDO::PARAM_STR);
			$ins->bindParam(':by',$by, PDO::PARAM_STR);
			$ins->bindParam(':modif',$modif, PDO::PARAM_STR);
			$ins->bindParam(':mounth',$mounth, PDO::PARAM_INT);
			$ins->execute();


			if($ins->rowCount() < 1){
				throw new Exception("Error al insertar historial", 1);
			}
		}

	}

 ?>