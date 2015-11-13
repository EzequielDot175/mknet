<?php header('Content-Type: text/html; charset=utf-8');
include_once('../resources/control.php');
include_once('helper_titulos.php');
require_once('../../libs.php');
?>
<!DOCTYPE html>
<html>
<head>

	<?php include_once('../resources/includes.php'); ?>
	
	
	<style type="text/css">
	.item_respuesta{
		width: 93%; float: left; margin: .5em 0;padding: 0; 
	}
	</style>
	

	<!-- charset -->
	<meta charset="utf-8">
	<!-- Mobile Meta -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<!-- Description -->
	<meta name="description" content="">

<?php include_once('../resources/includes.php'); ?>
<script type="text/javascript">
function changueoferta(div){
$('#oferta'+div).load('changue_oferta.php?id='+div);
}
</script>
<script type="text/javascript"> 
$(document).ready(function(){
    $("#simpleform").validate({
      event: "blur",
      rules: {
       nombre: { 
		required: true, 
		minlength: 2 
		},
		     
      
      },
      messages: {
        nombre: { 
		required: " Complete nombre de tipo", 
		minlength: "* 2 caracteres minimo." 
		},
			
             
        },
      debug: true,
      errorElement: "p",
      submitHandler: function(form){
         //alert('Los datos seran enviados');
          form.submit();
      }
   });
});

$(document).ready(function(){$('#strCampo').focus()});
</script> 
<script type="text/javascript">
$(function() {
$("#fecha").datepicker({altFormat: 'yy-mm-dd'});

});



</script>
</head>
<body>
<!-- Header -->

	<?php include_once('../inc/header.php') ?>	

<div class="block">

<div class="prod_container">
<div class="three_444 contenedor-default">
		<div class="">


<?php

$id =$_GET['id'];
$consultas = new Consulta();
$cons = $consultas->getFullById($id);


?>

			<div id="content-consultas">
				<div class="left"><!-- left -->
					<div class="receipt "> <?php echo $cons[$id]->strEmpresa ?> <span class="span-right"> Asunto: <span><?php echo $cons[$id]->strAsunto ?></span> </span></div>
					<div class="qry">
						<div class="date">
							<p> <?php echo Consulta::formatDate($cons[$id]->fecha) ?>
								<br>
								<span> <?php echo Consulta::formatTime($cons[$id]->fecha) ?></span>
							</p>
						</div>
						<div class="message">
							<p> <span> consulta </span> <?php echo($cons[$id]->strCampo) ?>  </p>
						</div>
					</div>

					<?php foreach($cons[$id]->respuestas as $k => $v ): ?>
					<div class="answer">
						<div class="date">
							<p> <?php Consulta::formatDate($v->fecha) ?>	<br>
					<span>
						<?php echo Consulta::formatTime($v->fecha) ?>					</span>
							</p>
						</div>
						<div class="message">
							<p>
						<span>
							respuesta
						</span>
								<?php echo $v->strCampo ?>				</p>
						</div>
					</div>
					<?php endforeach; ?>




				</div>

			</div>


			<div id="content-consultas">

				<div class="form-response">
					<form method="post" action="process_consulta.php" id="simpleform"  >
						<div >
							<div class="form-item-consultas">
								<div class="tiform6">Respuesta:</div>

								<textarea name="strCampo" id="strDetalle-consulta" rows="10"></textarea>
							</div>
							<input type="hidden" name="idConsulta" id="idConsulta" value="<?php echo $id; ?>" />
							<div class="form-item">
								<p>
									<button type="submit" class="button">Enviar</button>
									<button type="button" class="button" onclick="javascript:history.back(1)">Cancelar</button>
							</div>


					</form>
				</div>
			</div>


		</div>

</div></p></div></div>
	
	</div>
	
	
<?php include_once('../inc/footer.php') ?></div>


</body>
</html>