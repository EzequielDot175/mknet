<?php 
// error_reporting(E_ALL);
// ini_set('display_errors', 'On');

include_once('../resources/control.php');
include_once('helper_titulos.php');
require_once('../../libs.php');

?>
<!DOCTYPE html>
<html>
<head>

  <title></title>
  <link rel="stylesheet" type="text/css" media="all" href="../layout/tables.css" />
  <link rel="stylesheet" type="text/css" media="all" href="../layout/base.css" />
  <link rel="stylesheet" type="text/css" media="all" href="../layout/header-footer-columns.css" />
  <link rel="stylesheet" type="text/css" media="all" href="../layout/forms.css" />
  <!-- charset -->
  <meta charset="utf-8">
  <!-- Mobile Meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
  <!-- Description -->
  <meta name="description" content="">

  <?php include_once('../resources/includes.php'); ?>

</head>
<body>
  <!-- Header -->

  <?php include_once('../inc/header.php') ?>


  <div class="block">
     <?php
        $vSelected = Filter::idSelected('vendedor');
        $cSelected = Filter::idSelected('cliente');
        $eSelected = Filter::idSelected('estado');
        ?>
    <input type="hidden" name="client" value="<?php echo $cSelected ?>">

    <div class="filtros_container" style="width: 105.38%;margin-bottom: 2px" clone-width-child>
       <div class="filtros-Default filtros-100">   
            <form action="" method="POST"> 
            <input type="hidden" name="filter"> 
                  <h3> FILTRAR POR:</h3>   
                  <select name="vendedor" id="svendedor">                     
                    <option value="">VENDEDOR</option>   
                    <?php Vendedor::options($vSelected); ?>  
                 </select>    
                  
                  <select name="cliente"  id="scliente">    
                    <option value="">CLIENTE</option>    
                     <?php Cliente::options() ?> 
                  </select>  

                  <select name="estado"  id="sestado">   
                    <option value="">ESTADO</option>   
                    <?php Compra::optionsEstado($eSelected); ?>    
                  </select>    
     
                  <button class="button-image" type="submit" ><img src="../layout/ver.png" alt=""> VER LISTADO DE RESULTADOS </button>     
            </form>    
      </div>   
  </div>

    <div class="prod_container" clone-width-parent>

      <div class="contenedor-default">
        <!-- /////////////////////////////////////////////BACKEND CANJES //////////////////////////////////////////////////////////-->
       



        <hr class="separador">

        <div class="menuorden"><a href="v_compras.php?orden=1&activo=1&sub=c"><img src="../layout/btn-orden1.png" alt="desc"/></a><a href="v_compras.php?orden=2&activo=1&sub=c"><img src="../layout/btn-orden2.png" alt="desc"/></a></div>
        
        <section class="prods-table">
            <div id="table-header">
                <div>
                    <p>fecha</p>
                </div>
                <div>
                    <p>total puntos</p>
                </div>
                <div>
                    <p>producto</p>
                </div>
                <div>
                    <p>cantidad</p>
                </div>
                <div>
                    <p>color</p>
                </div>
                <div>
                    <p>talle</p>
                </div>
                <div>
                    <p>remito</p>
                </div>
                <div>
                    <p>estado</p>
                </div>
            </div>

            <?php

                if(isset($_POST['filter'])):
                    $collection = Filter::Compras($_POST);
                else:
                    $collection = Compra::all();
                endif;

              
                foreach($collection as $key => $v):
            ?>

            <div class="table-item">
                <div class="item-top">
                    <div class="user collapse-bar" id="trigger-toggle-collapse-<?php echo $v[0]->id_compra ?>">
                        <p>
                            usuario: <?php echo $v[0]->v_nombre ?> <?php echo $v[0]->v_apellido ?></span> / <?php echo $v[0]->empresa ?> / <?php echo $v[0]->email ?>
                        </p>
                    </div>
                </div>
            </div>

            <div  aria-expanded="false" aria-controls="collapseExample" class="toggle-collapse-hidden table-item" id="toggle-item-collapse-<?php echo $v[0]->id_compra ?>">
                <div class="item-top">
                    <div class="user pointer" id="toggle-btn-item-collapse-<?php echo $v[0]->id_compra ?>">
                        <p>
                            usuario: <?php echo $v[0]->v_nombre ?> <?php echo $v[0]->v_apellido ?></span> / <?php echo $v[0]->empresa ?> / <?php echo $v[0]->email ?>
                        </p>
                    </div>

                    <div class="save">
                        <label for="submit-form-<?php echo $v[0]->id_compra ?>">guardar</label>
                    </div>
                </div>

                <form name="listado_productos" id="estform" action="update_proceso.php" method="post">

                  <input type="hidden" name="id_compra" value="<?php echo $v[0]->id_compra ?> "/>
                  <input type="submit" id="submit-form-<?php echo $v[0]->id_compra ?>" style="display: none;"/>

                  <?php $i = 0;$z = 0;  foreach($v as $itemk => $itemv): ?>
                  <div class="table-detail">
                      <div class="datime">
                          <p>
                            <?php
                              $date = preg_split("/[\s-]/", $itemv->fthCompra);
                              $year = $date[0];
                              $month = $date[1];
                              $day = $date[2];
                              $hour = $date[3];

                              if($i == 0):
                                echo($year.'-'.$month.'-'.$day.'<br><span>'.$hour.'</span>');
                              $i++;
                              endif;
                          ?>
                          </p>
                      </div>
                      <div class="pts">
                          <p>
                            <?php
                                if($z == 0):
                                echo($itemv->dblTotal);
                                $z++;
                                else:
                                    echo "&nbsp;";
                                endif;
                            ?>
                          </p>
                      </div>
                      <div class="prod-list">
                        <!-- for each start -->
                        <div class="prod-item">
                          <div class="prod-det">
                              <img src="../../images_productos/<?php echo $itemv->prod_imagen ?>">
                              <p>
                                <?php echo $itemv->precio_pagado ?> <span><?php echo $itemv->prod_nombre ?></span>
                              </p>
                          </div>
                          <div class="cant">
                              <p>
                                <?php echo $itemv->cantidad ?> U
                              </p>
                          </div>
                          <div class="color">
                              <p>
                                <?php echo $itemv->color ?>&nbsp;
                              </p>
                          </div>
                          <div class="size">
                              <p>
                                <?php echo $itemv->talle ?>&nbsp;
                              </p>
                          </div>
                          <div class="pre-bill">
                              <input type="text" name="remito[<?php echo $itemv->id_detalle ?>]" value="<?php echo $itemv->remito ?>">
                          </div>
                          <div class="status">
                            <select name="detalles[<?php echo $itemv->id_detalle ?>]" id="estado2">
                             <?php Compra::optionsEstado($itemv->estado_detalle); ?>
                            </select>
                          </div>
                          <div class="controls" style="right:-30px;">
                            <!--<a href="edit_compra.php?id=<?php echo $itemv->id_detalle ?>">
                              <img src="../layout/editar.png" alt="">
                            </a>-->

                            <a  id="delete-item-<?php echo $itemv->id_detalle ?>" href="delete_compras.php?id=<?php echo $itemv->id_detalle ?>">
                              <img src="../layout/borrar.png" alt="">
                            </a>
                          </div>
                        </div>
                        <!-- for each end -->
                      </div>
                  </div>
                  <?php endforeach; ?>
                </form>
            </div>
          <?php endforeach; ?>
        </section>



      <div class="navigate">
        <?php/*
        Compra::sBarPag();
        //var_dump(Compra::sBarPag());
        $current = (isset($_GET['page']) ? $_GET['page'] : 1 );
        for ($i=1; $i <= Compra::sBarPag(); $i++): ?>
        <a class="<?php echo( $i == $current ? 'current' : 'paginate') ?>" href="?page=<?php echo($i) ?>&activo=1&sub=c"><?php echo($i) ?></a>
      <?php endfor;*/ ?>
    </div>


  </div>
</div>







<?php include_once('../inc/footer.php') ?></div>

<script src="../js/modal.nufarm.js"></script>



<div class="modal-alert" id="modal-alert">
  <div class="box-alert">
    <h3>¿Desea eliminar el siguiente Canje Realizado? <br> <span class="low-words">Atención: El stock del producto, y los puntos del cliente serán restablecidos.</span></h3>
      <div class="box-alert-content">
         <div class="box-alert-left">
            <img class="logo" src="http://placehold.it/350x150" alt="" id="sub-content-prod-image">
         </div>
          <div class="box-alert-right">
              <div class="sub-content">
                  <h4 id="sub-content-prod-name"></h4>
                  <p id="sub-content-prod-reference"></p>
                  <p id="sub-content-prod-username"></p>
                  <p id="sub-content-prod-seller"></p>
                  <p id="sub-content-prod-colour"></p>
                  <p id="sub-content-prod-size"></p>
                  <p id="sub-content-prod-count"></p>
                  <p id="sub-content-prod-price"></p>
                  <p id="sub-content-prod-refund"></p>
              </div>
          </div>
      </div>
    <div class="box-alert-menu-bottom">
      <div class="left">
        <button class="box-alert-accept">Aceptar</button>
      </div>
      <div class="right">
        <button class="box-alert-deny">Cancelar</button>
      </div>
    </div>
  </div>
</div>
<script>
  jQuery(document).ready(function($) {

      $.fn.modalNufarm();

      $.fn.cloneWidth({
          padLeft: 30,
          padRight: 45
      });

      $.fn.collapseById({
          btn: "trigger-toggle-collapse-",
          item: "toggle-item-collapse-",
          item_btn: "toggle-btn-item-collapse-"
      });





      $('#svendedor').change(function(event) {
        event.preventDefault();
        $.post('ajax.php', {comboFiltro: '' , vendedor: $(this).val()}, function(data, textStatus, xhr) {
          $('#scliente').html(data);
          $('input[name="client"]').trigger('click'); 
        });
      });

      var client_val = $('input[name="client"]').val();
      if (client_val != "") {
        $('#svendedor').trigger('change');
        // $('option[value="'+client_val+'"]').attr('selected', 'true');
        $('input[name="client"]').on('click', function(event) {
            $('option[value="'+client_val+'"]').attr('selected', '');
        });
      };


      $('#svendedor').trigger('change');


      $('.confirm-link').click(function(event) {
        if (!confirm('¿Esta seguro que desea borrar este item?')) {
          event.preventDefault();
        };
      });

  });
</script>


</body>
</html>