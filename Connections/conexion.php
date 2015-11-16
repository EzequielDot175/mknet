<?php if (!isset($_SESSION)) {
  session_start();
}?>
<?php



require_once(realpath(__DIR__ . '/..').'/core/pdo/debug.db.php');

use Debug\DBParameters;

if($_SERVER['HTTP_HOST'] == "localhost"):
	define('LOGIN_NUFARM', 'http://localhost/ftp/loginNufarm');
else:
	define('LOGIN_NUFARM', "http://".$_SERVER['HTTP_HOST']);
endif;

DBParameters::construct();

// NUFARM MAX
$hostname_conexion = DBParameters::Hostname();
$database_conexion = DBParameters::Dbname();
$username_conexion = DBParameters::Username();
$password_conexion = DBParameters::Password();

$conexion = mysql_connect($hostname_conexion, $username_conexion, $password_conexion) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("SET NAMES 'utf8'", $conexion);
?>
<?php 
if (is_file ("includes/funciones.php")){
    include("includes/funciones.php"); 
}
else 
{
	include("../includes/funciones.php"); 
}
?>