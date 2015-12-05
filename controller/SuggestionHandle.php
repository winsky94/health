<?php
/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/11/28
 * Description：
 */
require_once("../service/SuggestionService.php");
require_once("../model/Suggestion.php");


$suggestionService = new SuggestionService();

$action = $_POST["action"];


if ($action == "getSuggestionsPageNum") {
    if (isset($_POST["userName"])) {
        $userName = $_POST["userName"];
        echo $suggestionService->getPageNum($userName);
    } else {
        echo $suggestionService->getPageNum();
    }

} elseif ($action == "getSuggestions") {
    $pageNum = $_POST["pageNum"];
    if (isset($_POST["userName"])) {
        $userName = $_POST["userName"];
        $suggestions = $suggestionService->getSuggestionsByPage($pageNum, $userName);
    } else {
        $suggestions = $suggestionService->getSuggestionsByPage($pageNum);
    }

    header('Content-Type: text/xml');

    // 写xml信息
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;
    $rootElement = $dom->createElement("suggestions");
    foreach ($suggestions as $suggestion) {
        $suggestionElement = $dom->createElement("suggestion");
        $title = $dom->createElement("title", $suggestion->getTitle());
        $content = $dom->createElement("content", $suggestion->getContent());
        $author = $dom->createElement("author", $suggestion->getAuthor());
        $type = $dom->createElement("type", $suggestion->getType());
        $email = $dom->createElement("email", $suggestion->getEmail());
        $telephone = $dom->createElement("telephone", $suggestion->getTelephone());
        $time = $dom->createElement("time", $suggestion->getTime());
        $goalUser = $dom->createElement("goalUser", $suggestion->getGoalUser());

        $suggestionElement->appendChild($title);
        $suggestionElement->appendChild($content);
        $suggestionElement->appendChild($author);
        $suggestionElement->appendChild($type);
        $suggestionElement->appendChild($email);
        $suggestionElement->appendChild($telephone);
        $suggestionElement->appendChild($time);
        $suggestionElement->appendChild($goalUser);

        $rootElement->appendChild($suggestionElement);
    }

    $dom->appendChild($rootElement);
    echo $dom->saveXML();

} elseif ($action == "release") {
    //发布建议——在线填写
    $title = $_POST["title"];
    $content = $_POST["content"];
    $author = $_POST["author"];
    $type = $_POST["type"];
    $email = $_POST["email"];
    $telephone = $_POST["telephone"];

    $goalUser = $_POST["goalUser"];

    if ($title == "") {
        $message = "<message>请输入建议标题</message>";
        echo $message;
    } elseif ($content == "") {
        $message = "<message>请输入建议内容</message>";
        echo $message;
    } else {
        $suggestion = new Suggestion($title, $content, $author, $type, $email, $telephone, $goalUser);
        $result = $suggestionService->insert($suggestion);
        if ($result == true) {
            $message = "<message>success</message>";
        } else {
            $message = "<message>发布失败</message>";
        }

        echo $message;
    }

} elseif ($action = "search") {
    $type = $_POST["type"];
    $keyword = $_POST["keyword"];

    $suggestions = $suggestionService->search($type, $keyword);

    // 写xml信息
    $dom = new DOMDocument('1.0', 'UTF-8');
    $dom->formatOutput = true;
    $rootElement = $dom->createElement("suggestions");
    foreach ($suggestions as $suggestion) {
        $suggestionElement = $dom->createElement("suggestion");
        $title = $dom->createElement("title", $suggestion->getTitle());
        $content = $dom->createElement("content", $suggestion->getContent());
        $author = $dom->createElement("author", $suggestion->getAuthor());
        $type = $dom->createElement("type", $suggestion->getType());
        $email = $dom->createElement("email", $suggestion->getEmail());
        $telephone = $dom->createElement("telephone", $suggestion->getTelephone());
        $time = $dom->createElement("time", $suggestion->getTime());
        $goalUser = $dom->createElement("goalUser", $suggestion->getGoalUser());

        $suggestionElement->appendChild($title);
        $suggestionElement->appendChild($content);
        $suggestionElement->appendChild($author);
        $suggestionElement->appendChild($type);
        $suggestionElement->appendChild($email);
        $suggestionElement->appendChild($telephone);
        $suggestionElement->appendChild($time);
        $suggestionElement->appendChild($goalUser);

        $rootElement->appendChild($suggestionElement);
    }

    $dom->appendChild($rootElement);
    echo $dom->saveXML();
}