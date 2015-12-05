<?php
/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/12/5
 * Description：
 */

require_once("../service/FriendsService.php");
require_once("../service/UserService.php");
require_once("../model/User.php");

$friendService = new FriendsService();
$userService = new UserService();

$action = $_POST["action"];

error_log($action . "\r\n", 3, "./log.txt");

if ($action == "getFriends") {
    $pageNum = $_POST["pageNum"];
    $name = $_POST["name"];
    $friends = $friendService->getFriendsByPage($name, $pageNum);

    header('Content-Type: text/xml');

    // 写xml信息
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;
    $rootElement = $dom->createElement("friends");
    error_log(sizeof($friends) . "\r\n", 3, "./log.txt");
    foreach ($friends as $user) {
        $userElement = $dom->createElement("friend");
        $name = $dom->createElement("name", $user->getUserName());
        $sex = $dom->createElement("sex", $user->getSex());
        $age = $dom->createElement("age", $user->getAge());
        $lastLoadTime = $dom->createElement("lastLoadTime", $user->getLastLoadTime());

        $userElement->appendChild($name);
        $userElement->appendChild($sex);
        $userElement->appendChild($age);
        $userElement->appendChild($lastLoadTime);

        $rootElement->appendChild($userElement);
    }

    $dom->appendChild($rootElement);
    echo $dom->saveXML();
} elseif ($action == "getUsersPageNum") {
    echo $userService->getPageNum();
} elseif ($action == "getFriendsPageNum") {
    echo $friendService->getPageNum();
} elseif ($action == "getUsers") {
    $pageNum = $_POST["pageNum"];
    $users = $userService->getUsersByPage($pageNum);

    header('Content-Type: text/xml');

    // 写xml信息
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;
    $rootElement = $dom->createElement("friends");
    foreach ($users as $user) {
        $userElement = $dom->createElement("user");
        $name = $dom->createElement("name", $user->getUserName());
        $sex = $dom->createElement("sex", $user->getSex());
        $age = $dom->createElement("age", $user->getAge());
        $lastLoadTime = $dom->createElement("lastLoadTime", $user->getLastLoadTime());

        $userElement->appendChild($name);
        $userElement->appendChild($sex);
        $userElement->appendChild($age);
        $userElement->appendChild($lastLoadTime);

        $rootElement->appendChild($userElement);
    }

    $dom->appendChild($rootElement);
    echo $dom->saveXML();
} elseif ($action == "makeFriends") {
    $name = $_POST["name"];
    $friend = $_POST["friend"];
    $result = $friendService->makeFriends($name, $friend);
    echo $result;
}