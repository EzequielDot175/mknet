<?php 
	
	require_once('libs.php');

	$db = new DB();

	$result = $db->query("SELECT * FROM facturacion")->fetchAll();


	foreach($result as $key => $val):

		$data = json_decode($val->data);

		$add = (Object)array("facturacion_total" => 0,"facturacion_prod_clave" => 0);
		$data->{'Abril'} = $add;
		$data->{'Mayo'} = $add;
		$data->{'Junio'} = $add;
		$data->{'Julio'} = $add;

		$newData = json_encode($data);

		$upd = $db->prepare('UPDATE facturacion SET data = :data WHERE id_user = :id');
		$upd->bindParam(':data', $newData, PDO::PARAM_STR);
		$upd->bindParam(':id', $val->id_user, PDO::PARAM_INT);
		$upd->execute();


		echo "Rowcount ".$upd->rowCount()."\n";

	endforeach;


	// echo "<pre>";
	// print_r($result);
	// echo "</pre>";

 ?>