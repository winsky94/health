<?php
/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/12/6
 * Description：
 */
require_once("../model/Interest.php");
require_once("../service/InterestService.php");

$action = $_POST["action"];

$interestService = new InterestService();

if ($action == "release") {
    $userName = $_POST["userName"];
    $content = $_POST["content"];
    $time = date("Y-m-d h:i:s", time());
    $interest = new Interest($userName, $content, $time);
    $result = $interestService->insert($interest);


    if ($result) {
        $message = "<message>success</message>";
    } else {
        $message = "<message>fail</message>";
    }

    echo $message;
} elseif ($action == "show") {
    $userName = $_POST["userName"];
    if ($userName == "") {
        $result = $interestService->getAllInterest();
    } else {
        $result = $interestService->getAllInterest($userName);
    }

    header('Content-Type: text/xml');

    // 写xml信息
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;
    $rootElement = $dom->createElement("interests");

    foreach ($result as $interest) {
        $userName = $interest->getUserName();
        $content = $interest->getContent();
        $time = $interest->getTime();

        $interestElement = $dom->createElement("interest");
        $userNameElement = $dom->createElement("userName", $userName);
        $contentElement = $dom->createElement("content", $content);
        $timeElement = $dom->createElement("time", $time);

        $interestElement->appendChild($userNameElement);
        $interestElement->appendChild($contentElement);
        $interestElement->appendChild($timeElement);

        $rootElement->appendChild($interestElement);
    }

    $dom->appendChild($rootElement);
    echo $dom->saveXML();
}