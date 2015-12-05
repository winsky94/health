<?php
/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/10/28
 * Description：
 */

require_once("../service/UserService.php");
require_once("../model/User.php");
$userService = new UserService();

$action = $_POST["action"];

if ($action == "getUserInfo") {
    header('Content-Type: text/xml');
    $userName = $_POST['userName'];

    $user = $userService->getUserByName($userName);

    // 写xml信息
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;
    $rootElement = $dom->createElement("users");
    $userElement = $dom->createElement("user");
    $userName = $dom->createElement("userName", $user->getUserName());
    $sex = $dom->createElement("sex", $user->getSex());
    $age = $dom->createElement("age", $user->getAge());
    $height = $dom->createElement("height", $user->getHeight());
    $weight = $dom->createElement("weight", $user->getWeight());
    $telephone = $dom->createElement("telephone", $user->getTelephone());
    $email = $dom->createElement("email", $user->getEmail());

    $userElement->appendChild($userName);
    $userElement->appendChild($sex);
    $userElement->appendChild($age);
    $userElement->appendChild($height);
    $userElement->appendChild($weight);
    $userElement->appendChild($telephone);
    $userElement->appendChild($email);

    $rootElement->appendChild($userElement);

    $dom->appendChild($rootElement);

    echo $dom->saveXML();
} elseif ($action == "changeUserInfo") {
    header('Content-Type: text/xml');

    $userName = $_POST["userName"];
    $sex = $_POST["sex"];
    $age = $_POST["age"];
    $height = $_POST["height"];
    $weight = $_POST["weight"];
    $telephone = $_POST["telephone"];
    $email = $_POST["email"];

    if ($userName == "") {
        $message = "<message>请输入用户名</message>";
    } elseif ($age == "") {
        $message = "<message>请输入年龄</message>";
    } elseif ($sex == "") {
        $message = "<message>请选择性别</message>";
    } elseif ($height == "") {
        $message = "<message>请输入身高</message>";
    } elseif ($weight == "") {
        $message = "<message>请输入体重</message>";
    } elseif ($email == "") {
        $message = "<message>请输入常用邮箱</message>";
    } elseif ($telephone == "") {
        $message = "<message>请输入联系方式</message>";
    } else {
        //密码和角色类型为空
        $user = new User($userName, $age, $sex, -1, "", $height, $weight, $email, $telephone);
        error_log($user->getTelephone() . "\r\n", 3, "../log.txt");
        $result = $userService->modifyInfo($user);
        if ($result == true) {
            $message = "<message>success</message>";
        } else {
            $message = "<message>修改失败</message>";
        }

    }
    echo $message;

} elseif ($action == "changePW") {
    header('Content-Type: text/xml');
    $userName = $_POST["userName"];
    $password = $_POST["password"];
    $newPassword = $_POST["newPassword"];

    $result = $userService->modifyPassword($userName, $password, $newPassword);

    if ($result == true) {
        $message = "<message>success</message>";
    } else {
        $message = "<message>修改失败</message>";
    }

    echo $message;
} elseif ($action == "reverse") {
    $followedName = $_POST["followedName"];
    $followerName = $_POST["followerName"];

    $result = $userService->reverse($followerName, $followedName);
    echo $result;
}
