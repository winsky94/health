<?php
/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/10/17
 * Description：
 */
require_once("../service/UserService.php");
require_once("../model/User.php");

$user=new UserService();
$userName=$_POST["userName"];
$password=$_POST["password"];
$email=$_POST["email"];
$telephone=$_POST["telephone"];
$type=$_POST["type"];
$age=$_POST["age"];
$sex=$_POST["sex"];
$height=$_POST["height"];
$weight=$_POST["weight"];

if($userName==""){
    $message="<message>请输入用户名</message>";
    echo $message;
}elseif($age==""){
    $message="<message>请输入年龄</message>";
    echo $message;
}elseif($sex==""){
    $message="<message>请选择性别</message>";
    echo $message;
}elseif($type==""){
    $message="<message>请选择角色</message>";
    echo $message;
}elseif($height==""){
    $message="<message>请输入身高</message>";
    echo $message;
}elseif($weight==""){
    $message="<message>请输入体重</message>";
    echo $message;
}elseif($password==""){
    $message="<message>请输入密码</message>";
    echo $message;
}elseif($email==""){
    $message="<message>请输入常用邮箱</message>";
    echo $message;
}elseif($telephone==""){
    $message="<message>请输入联系方式</message>";
    echo $message;
} else {
    $newUser = new User($userName,$age,$sex,$type,$password,$height,$weight,$email,$telephone);
    $result=$user->insert($newUser);
    if($result==true){
        $message="<message>success</message>";
    }else{
        $message="<message>该用户名已被注册</message>";
    }

    echo $message;
}