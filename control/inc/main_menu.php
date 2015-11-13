<?php 
if(isset($_SESSION['logged_id'])){

$activo = (isset($_GET['activo']) ? $_GET['activo'] : 0);
$sub = ( isset($_GET['sub']) ? $_GET['sub'] : 1);

echo'


<div class="menu">
        <a href="../filtros.php">
            <li class="">REPORTES</li>
        </a>
        <a href="../compras/v_compras.php?activo=1&sub=c"  >
        	<li class="'; if ($activo==1){echo " seleccionado";}echo'">PRODUCTOS CANJEADOS</li>
        </a>
        <a href="../productos/v_productos.php?activo=2&sub=d">
       	 <li class="'; if ($sub=="d"){echo " seleccionado";} echo'">CARGA DE PRODUCTOS</li>
        </a>
        <a href="../usuarios/v_usuarios.php?activo=2&sub=e&vert=1">
        	<li class="'; if ($sub=="e"){echo " seleccionado";}echo'">CLIENTES</li>
        </a>
        <a href="../personal/v_personal.php?activo=2&sub=h">
        	<li class="'; if ($sub=="h"){echo " seleccionado";}echo'">VENDEDORES</li>
        </a>
        <a href="../consultas/v_consultas.php?activo=2&sub=f&orden=1">
            <li class="';if ($sub=="f"){echo " seleccionado";} echo'">CONSULTAS</li>
        </a>
  </div>

';

}
?>





