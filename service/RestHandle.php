<?php
/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/12/5
 * Description：
 */

require_once("Rest.php");
require_once("../service/HealthService.php");

$sport = RestUtils::processRequest();

switch ($sport->getMethod()) {
    // this is a request for all users, not one in particular
    case 'get':
        //获取
        getMethod($sport);
        break;
    // new user create
    case 'post':
        //增加
        postMethod($sport);
        break;
    case 'put':
        //修改
        putMethod($sport);
        break;
    case 'delete':
        deleteMethod($sport);
        break;
}

function getMethod($sport) {
    $userName = $sport->getRequestVars()["userName"];

    $healthService = new HealthService();
    $sports_list = $healthService->getSportData($userName);

    RestUtils::sendResponse(200, $sports_list, 'application/xml');
}

function postMethod($sport) {
    $userName = $sport->getRequestVars()["userName"];
    $date = $sport->getRequestVars()["date"];
    $meters = $sport->getRequestVars()["meters"];
    $minutes = $sport->getRequestVars()["minutes"];
    $speed = $sport->getRequestVars()["speed"];
    $calories = $sport->getRequestVars()["calories"];

    $sport = array();
    array_push($sport, $userName);
    array_push($sport, $date);
    array_push($sport, $meters);
    array_push($sport, $minutes);
    array_push($sport, $speed);
    array_push($sport, $calories);

    $data = array($sport);

    $healthService = new HealthService();
    $result = $healthService->setUserSportData($data);
    if ($result) {
        $message = "<result>上传数据成功</result>";
        RestUtils::sendResponse(201, $message);
    } else {
        $message = "<result>上传数据失败</result>";
        RestUtils::sendResponse(201, $message);
    }


}

function putMethod($sport) {
    $userName = $sport->getRequestVars()["userName"];
    $date = $sport->getRequestVars()["date"];
    $meters = $sport->getRequestVars()["meters"];
    $minutes = $sport->getRequestVars()["minutes"];
    $speed = $sport->getRequestVars()["speed"];
    $calories = $sport->getRequestVars()["calories"];

    $sports = array();
    array_push($sports, $userName);
    array_push($sports, $date);
    array_push($sports, $meters);
    array_push($sports, $minutes);
    array_push($sports, $speed);
    array_push($sports, $calories);

    $healthService = new HealthService();
    $result = $healthService->updateSportData($userName, $date, $sports);
    if ($result) {
        $message = "<result>更新数据成功</result>";
        RestUtils::sendResponse(200, $message);
    } else {
        $message = "<result>更新数据失败</result>";
        RestUtils::sendResponse(304, $message);
    }


}

function deleteMethod($sport) {
    $userName = $sport->getRequestVars()["userName"];
    $date = $sport->getRequestVars()["date"];

    $healthService = new HealthService();
    $result = $healthService->deleteSportData($userName, $date);
    if ($result) {
        $message = "<result>删除数据成功</result>";
        RestUtils::sendResponse(200, $message);
    } else {
        $message = "<result>删除数据失败</result>";
        RestUtils::sendResponse(200, $message);
    }


}