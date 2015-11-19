<?php
  
ob_start();


  require_once('Connections/conexion.php');
  require_once('libs.php');

 ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// require_once('/control/resources/pdo.php');
require_once('control/productos/classes/class.tallesColores.php');

?>
<?php


$cond =  (  isset($_GET['recordID']) && !empty($_GET['recordID']) && !isset($_GET['talle_colores'])  );


$tempMaxCompra = new TempMaxCompra();
$tempMaxCompra->storeRemains($_GET['recordID']);


if ( isset($_GET['require'])) {
    switch ($_GET['require']) {
      case '1':
         try {
          $x = new TempStock();
          $x->liberarStockTalle($_GET['recordID'],$_SESSION['MM_IdUsuario']);
        } catch (Exception $e) {
          echo($e->getMessage());
        }

        break;
      case '2':
        try {
          $x = new TempStock();
          $x->liberarStockColor($_GET['recordID'],$_SESSION['MM_IdUsuario']);
        } catch (Exception $e) {
          echo($e->getMessage());
        }

        break;
      case '3':
        try {
          $x = new TempStock();
          $x->liberarStockColorTalle($_GET['recordID'],$_SESSION['MM_IdUsuario']);
        } catch (Exception $e) {
          echo($e->getMessage());
        }
        break;
      
      default:
         try {
          $x = new TempStock();
          $x->liberarStockComunes($_GET['recordID'],$_SESSION['MM_IdUsuario']);
        } catch (Exception $e) {
          echo($e->getMessage());
        }
        break;
    }
}


if ($cond) {
  $deleteSQL = sprintf("DELETE FROM carrito WHERE intContador=%s LIMIT 1",
                       GetSQLValueString($_GET['recordID'], "int"));

  mysql_select_db($database_conexion, $conexion);
  $Result1 = mysql_query($deleteSQL, $conexion) or die(mysql_error());


 //Reintegro al stock el producto.
  include_once("includes/class.productos.php");
  
  //Traigo stock actual
  // $productos= new productos();
  // $productos->select($_GET['recordID']);
  // $StockActual=$productos->getintStock();

  //actualizo el stock
  // $productos= new productos();
  // $productos->select($_GET['recordID']);
  // $productos->intStock=$intStock = $StockActual + 1;
  // $productos->update($_GET['recordID']);





  
  
}elseif (   isset($_GET['talle_colores'])  ) {
 
    $productos = new tallesColores();
    $sub = $_GET['sub'];
    $talle = $_GET['talle'];
    
    $delete = $productos->deleteItem($_GET['recordID'],$sub,$talle);
    
}



header('Location: carrito.php');

?>
