<?php
/**
 * Created by PhpStorm.
 * User: dot175
 * Date: 22/10/2015
 * Time: 05:05 PM
 */

namespace Factory;


class Colours extends \DB
{


    public function getAll(){
        $sel = $this->query(self::COLOURS_ALL)->fetchAll();
        return $sel;
    }


}