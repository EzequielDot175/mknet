<?php

include_once("../resources/class.database.php");

/* CLASS DECLARATION */


class usuarios{ 
// class : begin
/* ATTRIBUTE DECLARATION */
var $idUsuario;   // KEY ATTR. WITH AUTOINCREMENT
var $strNombre;
var $strApellido;
var $strEmail;
var $strEmpresa;
var $strCargo;
var $strPassword;
var $dblCredito;

var $direccion;
var $telefono;
var $nombre_contacto1;
var $apellido_contacto1;
var $email_contacto1;
var $nombre_contacto2;
var $apellido_contacto2;
var $email_contacto2;
var $logo;
var $vigencia_credito;
var $vendedor;

var $database; // Instance of class database


/* CONSTRUCTOR METHOD */

function usuarios(){

$this->database = new Database();

}


/* GETTER METHODS */
function getidUsuario(){return $this->idUsuario;}
function getstrNombre(){return $this->strNombre;}
function getstrApellido(){return $this->strApellido;}
function getstrEmail(){return $this->strEmail;}
function getstrEmpresa(){return $this->strEmpresa;}
function getstrCargo(){return $this->strCargo;}
function getstrPassword(){return $this->strPassword;}
function getdblCredito(){return $this->dblCredito;}

function getdireccion(){return $this->direccion;}
function gettelefono(){return $this->telefono;}
function getnombre_contacto1(){return $this->nombre_contacto1;}
function getapellido_contacto1(){return $this->apellido_contacto1;}
function getemail_contacto1(){return $this->email_contacto1;}
function getnombre_contacto2(){return $this->nombre_contacto2;}
function getapellido_contacto2(){return $this->apellido_contacto2;}
function getemail_contacto2(){return $this->email_contacto2;}
function getlogo(){return $this->logo;}
function getvigencia_credito(){return $this->vigencia_credito;}
function getvendedor(){return $this->vendedor;}


/* SETTER METHODS */
function setidUsuario($val){ $this->idUsuario =  $val;}
function setstrNombre($val){ $this->strNombre =  $val;}
function setstrApellido($val){ $this->strApellido =  $val;}
function setstrEmail($val){ $this->strEmail =  $val;}
function setstrEmpresa($val){ $this->strEmpresa =  $val;}
function setstrCargo($val){ $this->strCargo =  $val;}
function setstrPassword($val){ $this->strPassword =  $val;}
function setdblCredito($val){ $this->dblCredito =  $val;}



function setdireccion($val){ $this->direccion =  $val;}
function settelefono($val){ $this->telefono =  $val;}
function setnombre_contacto1($val){ $this->nombre_contacto1 =  $val;}
function setapellido_contacto1($val){ $this->apellido_contacto1 =  $val;}
function setemail_contacto1($val){ $this->email_contacto1 =  $val;}
function setnombre_contacto2($val){ $this->nombre_contacto2 =  $val;}
function setapellido_contacto2($val){ $this->apellido_contacto2 =  $val;}
function setemail_contacto2($val){ $this->email_contacto2 =  $val;}
function setlogo($val){ $this->logo =  $val;}
function setvigencia_credito($val){ $this->vigencia_credito =  $val;}
function setvendedor($val){ $this->vendedor =  $val;}





/* SELECT METHOD / LOAD */
function select($id){

$sql =  "SELECT * FROM usuarios WHERE idUsuario = $id;";
$result =  $this->database->query($sql);
$result = $this->database->result;
$row = mysql_fetch_object($result);

$this->idUsuario = $row->idUsuario;
$this->strNombre = $row->strNombre;
$this->strApellido = $row->strApellido;
$this->strEmail = $row->strEmail;
$this->strEmpresa = $row->strEmpresa;
$this->strCargo = $row->strCargo;
$this->strPassword = $row->strPassword;
$this->dblCredito = $row->dblCredito;

$this->direccion = $row->direccion;
$this->telefono = $row->telefono;
$this->nombre_contacto1 = $row->nombre_contacto1;
$this->apellido_contacto1 = $row->apellido_contacto1;
$this->email_contacto1 = $row->email_contacto1;
$this->nombre_contacto2 = $row->nombre_contacto2;
$this->apellido_contacto2 = $row->apellido_contacto2;
$this->email_contacto2 = $row->email_contacto2;
$this->logo = $row->logo;
$this->vigencia_credito = $row->vigencia_credito;
$this->vendedor = $row->vendedor;


}

/* SELECT ALL */
function select_busqueda($search){

$sql ="SELECT * FROM usuarios WHERE strNombre LIKE '%$search%' OR strapellido LIKE '%$search%' ORDER BY strNombre ASC;";
$result = $this->database->query($sql);
$result = $this->database->result;

$count_resultados=0;

while($row = mysql_fetch_array($result)){
$idUsuario = $row['idUsuario'];
$strNombre = $row['strNombre'];
$strApellido = $row['strApellido'];
$strEmail = $row['strEmail'];
$strEmpresa = $row['strEmpresa'];
$strCargo = $row['strCargo'];
$strPassword = $row['strPassword'];
$dblCredito = $row['dblCredito'];


$direccion = $row['direccion'];
$telefono = $row['telefono'];
$nombre_contacto1 = $row['nombre_contacto1'];
$apellido_contacto1 = $row['apellido_contacto1'];
$email_contacto1 = $row['email_contacto1'];
$nombre_contacto2 = $row['nombre_contacto2'];
$apellido_contacto2 = $row['apellido_contacto2'];
$email_contacto2 = $row['email_contacto2'];
$logo = $row['logo'];
$vigencia_credito = $row['vigencia_credito'];
$vendedor = $row['vendedor'];



$item_usuario .= '<div class="item">

<h4>'.$strNombre.' '.$strApellido.'</h4>
<p>'.$strEmail.' - '.$strEmpresa.'</p>
<p>'.$strCargo.' - Credito:'.$dblCredito.'</p>
<p>
<a href="'.BASEURL.'/usuarios/e_usuario.php?id='.$idUsuario.'">Editar</a>
<a href="'.BASEURL.'/usuarios/d_usuario.php?id='.$idUsuario.'">Borrar</a>
</p>

</div>';
$count_resultados++;
}
echo '<p>Resultados: '.$count_resultados.'</p>';

echo $item_usuario;

}


/* SELECT ALL */
function select_all($pagina, $orden){
include('../resources/paginator.class.php');
$sql ="SELECT * FROM usuarios ;";
$result = $this->database->query($sql);
$result = $this->database->result;
$quantity= mysql_num_rows($result);
		if($quantity < 1)
		{echo '<div class="notify">
			<p>No hay usuario en el sistema!</p>
		</div>';}
		else{
$count=0;
while($row = mysql_fetch_array($result)){
$count++;
}

$pages = new Paginator;
$pages->items_total = $count;
$pages->mid_range = 10;
$pages->paginate();
$pages->display_pages();

include_once('../historiales/classes/class.historiales.php');


$sql ="SELECT * FROM usuarios ORDER BY $orden $pages->limit;";
$result = $this->database->query($sql);
$result = $this->database->result;
while($row = mysql_fetch_array($result)){
$idUsuario = $row['idUsuario'];
$strNombre = $row['strNombre'];
$strApellido = $row['strApellido'];
$strEmail = $row['strEmail'];
$strEmpresa = $row['strEmpresa'];
$strCargo = $row['strCargo'];
$strPassword = $row['strPassword'];
$dblCredito = $row['dblCredito'];

$direccion = $row['direccion'];
$telefono = $row['telefono'];
$nombre_contacto1 = $row['nombre_contacto1'];
$apellido_contacto1 = $row['apellido_contacto1'];
$email_contacto1 = $row['email_contacto1'];
$nombre_contacto2 = $row['nombre_contacto2'];
$apellido_contacto2 = $row['apellido_contacto2'];
$email_contacto2 = $row['email_contacto2'];
$logo = $row['logo'];
$vigencia_credito = $row['vigencia_credito'];
$vendedor = $row['vendedor'];

$usuarioitem ="";
//si tiene imagen
if(strlen($logo) >2 ){
$usuarioitem .= '

<div class="item">
	<div class="divideritemuno" >
		<img src="'.BASEURLRAIZ.'/images_usuarios/'.$logo.'" alt="" width="120"/>
		
	</div>
	
	<div class="divideritemdos" >
		<h5>'.$strEmpresa.' </h5>
		<p>'.$strApellido.' '.$strNombre.' </p>
		<p>'.$strEmail.'</p>
		<p> '.$direccion.' - '.$telefono.' </p>
	</div>
	
	<div class="divideritemtres" >
		<p>Credito disponible: <br />$ '.$dblCredito.' </p>
	</div>
	<div class="itemfull">
	<a href="e_usuario.php?id='.$idUsuario.'">Editar</a>
	<a href="d_usuario.php?id='.$idUsuario.'">Borrar</a>
	</div>
</div>

';


}else{

$usuarioitem .= '

<div class="item">
	<div class="divideritemuno" >
		<div class="no_img"></div>
		
	</div>
	
	<div class="divideritemdos">
		<h5>'.$strEmpresa.' </h5>
		<p>'.$strApellido.' '.$strNombre.' </p>
		<p>'.$strEmail.'</p>
		<p> '.$direccion.' - '.$telefono.' </p>
	</div>
	
	<div class="divideritemtres" >';

	$hist = new historiales();
	
	$usuarioitem .= $hist->show_by_usuario($idUsuario);	
	
$usuarioitem .='<p>Credito disponible: <br />$ '.$dblCredito.' </p>
	</div>
	<div class="itemfull">
	<a href="e_usuario.php?id='.$idUsuario.'">Editar</a>
	<a href="d_usuario.php?id='.$idUsuario.'">Borrar</a>
	</div>
</div>

';

}
echo $usuarioitem;

}




echo '<div class="navigate">';
echo $pages->display_pages();


 // Optional call which will display the page numbers after the results.
//$pages->display_jump_menu(); // Optional � displays the page jump menu
//echo $pages->display_items_per_page(); //Optional � displays the items per
//echo  $pages->current_page . ' of ' .$pages->num_pages.'';
echo '</div>';
}

}

/* SELECT DROP LIST */
function usuarios_drop_list(){

$sql ="SELECT * FROM usuarios ;";
$result = $this->database->query($sql);
$result = $this->database->result;
while($row = mysql_fetch_array($result)){
$id= $row['id_usuarios'];
$name= $row['name_usuarios'];
echo '<option value='.$id.'>'.$name.'</option>';
}
}


/* DELETE */
function delete($id){
$sql = "DELETE FROM usuarios WHERE idUsuario = $id;";
$result = $this->database->query($sql);

}


/* INSERT */

function insert(){
$this->idUsuario = ""; // clear key for autoincrement

$sql = "INSERT INTO usuarios ( strNombre,strApellido,strEmail,strEmpresa,strCargo,strPassword,dblCredito, direccion, telefono, nombre_contacto1, apellido_contacto1, email_contacto1, nombre_contacto2, apellido_contacto2, email_contacto2, logo, vigencia_credito, vendedor ) VALUES ( 
'$this->strNombre',
'$this->strApellido',
'$this->strEmail',
'$this->strEmpresa',
'$this->strCargo',
'$this->strPassword',
'$this->dblCredito','$this->direccion', '$this->telefono', '$this->nombre_contacto1', '$this->apellido_contacto1', '$this->email_contacto1', '$this->nombre_contacto2', '$this->apellido_contacto2', '$this->email_contacto2', '$this->logo', '$this->vigencia_credito', '$this->vendedor' )";
$result = $this->database->query($sql);
$this->idUsuario = mysql_insert_id($this->database->link);

}


/* UPDATE */

function update($id){

$sql = " UPDATE usuarios SET  strNombre = '$this->strNombre',strApellido = '$this->strApellido',strEmail = '$this->strEmail',strEmpresa = '$this->strEmpresa',strCargo = '$this->strCargo',strPassword = '$this->strPassword',dblCredito = '$this->dblCredito',
direccion = '$this->direccion', telefono = '$this->telefono', nombre_contacto1 = '$this->nombre_contacto1', apellido_contacto1 = '$this->apellido_contacto1', email_contacto1 = '$this->email_contacto1', nombre_contacto2 = '$this->nombre_contacto2', apellido_contacto2 = '$this->apellido_contacto2', email_contacto2 = '$this->email_contacto2', logo = '$this->logo', vigencia_credito = '$this->vigencia_credito', vendedor = '$this->vendedor', strApellido = '$this->strApellido'WHERE idUsuario = $id ";

$result = $this->database->query($sql);

}

} // class : end

?>