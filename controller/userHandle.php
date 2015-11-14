<?php
/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/10/28
 * Description：
 */

require_once("../service/UserService.php");
require_once("../model/User.php");
header('Content-Type: text/xml');

$userName = $_GET['userName'];

$userService = new UserService();
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