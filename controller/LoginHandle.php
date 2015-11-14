<?php

/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/10/14
 * Description：
 */

require_once("../service/UserService.php");
$user=new UserService();
$userName=$_POST["userName"];
$password=$_POST["password"];

$result=$user->checkLogin($userName,$password);
if(!$result){
    echo "用户名或密码错误";
}else{
    $type=$user->getType($userName);
    echo "success&",$type;
}