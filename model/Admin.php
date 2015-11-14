<?php

/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/10/14
 * Description：系统管理员,type编号为3
 */
class Admin extends User{

    public function __construct(){
        $this->setType(3);
    }
}