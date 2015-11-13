<?php
    require_once('/home/nmaxx/public_html/marketingNet/libs.php');

    $stock = new TempMaxCompra();
    $expiredShoppingCart = $stock->getExpiredShoppingCard();
    $shoppingCart = new ShoppingCart();



    if(!empty($expiredShoppingCart)){

        foreach ($expiredShoppingCart as $k => $v) {

            $type = $shoppingCart->getType($v->talle,$v->color);
            $user = $v->idUsuario;
            $id = $v->intContador;
            $stock->storeRemains($type);

            if ( isset($type)) {
                switch ($type) {
                    case '1':
                        try {
                            $x = new TempStock();
                            $x->liberarStockTalle($id,$user);
                        } catch (Exception $e) {
                            echo($e->getMessage());
                        }

                        break;
                    case '2':
                        try {
                            $x = new TempStock();
                            $x->liberarStockColor($id,$user);
                        } catch (Exception $e) {
                            echo($e->getMessage());
                        }

                        break;
                    case '3':
                        try {
                            $x = new TempStock();
                            $x->liberarStockColorTalle($id,$user);
                        } catch (Exception $e) {
                            echo($e->getMessage());
                        }
                        break;

                    default:
                        try {
                            $x = new TempStock();
                            $x->liberarStockComunes($id,$user);
                        } catch (Exception $e) {
                            echo($e->getMessage());
                        }
                        break;
                }
            }


           echo "Items carrito liberados :".$shoppingCart->remove($id);




        }
    }



    die;

