<header>


<!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

<script type="text/javascript" src="../js/modernizr.custom.29057.js"></script>
<script type="text/javascript">
$(document).ready(function(){
$('.three_444 .item .olive-bar_new2').click(function(){
$(this).next("form").slideToggle('fast');
 });
 $('.three_44 .item .olive-bar_new2').click(function(){
$(this).next("div").slideToggle('fast');
 });
$(".search_box").find('input').click(function(){
 $(this).val(''); 
});

// comprobacion estado canje para que no se repitan los quites de creditos
// $( "#estado" ).change(function() {
 // if($(this).val() == "1" || $(this).val() == "2"){
// $("#monto2").fadeIn();
    // } else {
// $("#monto2").fadeOut();
    // }
 });

</script>
    <?php
        $current_admin = Auth::UserAdmin();
    ?>
<div id="top"></div>
<div id="logo">
<a href="../index.php"><img src="../../imagenes/logo2-02.png" alt="Nufarm"> </a>
</div>
<div id="header_bg_img"><div class="subheader"><span class="adminwelcome">Administrador: <?php echo $current_admin->nombre." ".$current_admin->apellido ?></span>
<!--<div class="prop"><?php  
/*include_once("../propuestas/classes/class.propuestas.php");
$prop= new propuestas();
$prop->sin_responder();*/
?></div>-->
</div></div>
<ul>
    <li class="cerrar_sesion">
        <a  href="<?php  echo BASEURL.'/logout.php'?>">Cerrar sesion X</a>
    </li>
    <li class="li-switcher">
        <div class="switcher">
            <img class="icon-select " src="<?php echo BASEURL ?>layout/flecha-select.png" id="Nufarm" title="Nufarm" alt="Imagen no encontrada">
            <select class="form-control" id="select-navigator">
                <option value="/control">HOME</option>
                <option selected="" value="/marketingNet/control">MARKETING NET</option>
                <option value="/vendedor-estrella/control/">VENDEDOR ESTRELLA</option>
            </select>
        </div>
    </li>
</ul>
</header>
<script>
    $(document).ready(function(){
        $("#select-navigator").change(function(event){
            event.preventDefault();
            var val = $(this).val();

            window.location.href = val;

        });
    });
</script>
<div class="main_menu">
				<?php include('../inc/main_menu.php'); ?>

				
				<!--<div class="search_box">
				<form action="<?php  echo BASEURL.'/busquedas/busquedas.php'; ?>" method="post">
				<input type="text" value="BUSCAR" name="busqueda" id="busqueda" />
				</form>
				</div>-->
</div>

