<?php
/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/11/8
 * Description：
 */
require_once("../service/EventsService.php");
require_once("../model/Event.php");

$eventService = new EventsService();

$action = $_POST["action"];

if ($action == "release") {
    //发布活动
    $name = $_POST["name"];
    $introduction = $_POST["introduction"];
    $startDate = $_POST["startDate"];
    $endDate = $_POST["endDate"];
    $detail = $_POST["detail"];

    if ($name == "") {
        $message = "<message>请输入活动名称</message>";
        echo $message;
    } elseif ($introduction == "") {
        $message = "<message>请输入活动简介</message>";
        echo $message;
    } elseif ($startDate == "") {
        $message = "<message>请选择活动开始日期</message>";
        echo $message;
    } elseif ($endDate == "") {
        $message = "<message>请选择活动结束日期</message>";
        echo $message;
    } elseif ($detail == "") {
        $message = "<message>请输入活动具体介绍</message>";
        echo $message;
    } elseif ($startDate > $endDate) {
        $message = "<message>请选择有效的活动开始和结束日期</message>";
        echo $message;
    } else {
        $event = new Event($name, $introduction, $startDate, $endDate, $detail,0);//新发布的活动参与人数为0
        $result = $eventService->insert($event);

        if ($result == true) {
            $message = "<message>success</message>";
        } else {
            $message = "<message>该活动名已被占用</message>";
        }

        echo $message;
    }


}