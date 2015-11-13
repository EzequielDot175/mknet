<?php

/**
 * Created by PhpStorm.
 * User: dot175
 * Date: 13/11/2015
 * Time: 11:44 AM
 */
class productStockHistory extends DB
{
    private  $id;
    private  $current_stock;
    private  $next_stock;

    private function getStock($id){
        $sel = $this->prepare(self::PSH_GETSTOCK);
        $sel->bindParam(":id",$id,PDO::PARAM_INT);
        $sel->execute();

        $res = $sel->fetch();
        if(isset($res->intStock)){
            return $res->intStock;
        }else{
            return 999999;
        }
    }

    public  function after($id_product = null){
        if(!is_null($id_product)){
            $this->id = $id_product;
            $this->current_stock = $this->getStock($id_product);
        }
    }

    public  function before(){
        $this->next_stock = $this->getStock($this->id);
    }

    public function commit(){
        $this->beginTransaction();
        $ins = $this->prepare(self::PSH_INSERT);
        $ins->bindParam(":after",$this->current_stock);
        $ins->bindParam(":before",$this->next_stock);
        $ins->bindParam(":id",$this->id);
        $ins->execute();
    }

}