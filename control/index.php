<?php  session_start();
ob_start();
// Requires 
// 
$_SESSION['basecontrol'] = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$_SESSION['baseurl'] = str_replace('/control/', '', $_SESSION['basecontrol']);
$_SESSION['root'] = dirname(__FILE__);

// session controller
if (isset($_SESSION['logged_id'])) {
  if($_SESSION['logged_id'] != ""){
  header('Location: compras/v_compras.php?activo=1&sub=c');

  }
}else{
    header('Location: /control'); }


