<?php

/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/10/22
 * Description： 活动的相关数据操作
 */

require_once("../utils/SqliteHelper.php");
require_once("../model/Event.php");

class EventsService {
    var $db_name = "events";
    var $DB = null;

    public function __construct() {
        //创建实例
        $this->DB = new SqliteHelper('../data.db'); //这个数据库" title="数据库" >数据库文件名字任意
    }

    public function createTable() {
        $sql = "drop table if exists " . $this->db_name;
        $this->DB->query($sql);
        $sql = "create table " . $this->db_name . "(id integer primary key,name varchar(40),introduction varchar(40),startDate varchar(20),endDate varchar(20),detail varchar(200),peopleNum int);";
        $this->DB->query($sql);
    }

    public function insert($event) {
        $name = $event->getName();

        $sql = "select * from " . $this->db_name . " where name='" . $name . "' limit 1";
        $result = $this->DB->getList($sql);
        if (empty($result)) {
            $introduction = $event->getIntroduction();
            $startDate = $event->getStartDate();
            $endDate = $event->getEndDate();
            $detail = $event->getDetail();
            $peopleNum = $event->getPeopleNum();

            $sql = "insert into " . $this->db_name . " values(:id,:name,:introduction,:startDate,:endDate,:detail,:peopleNum)";
            $stmt = $this->DB->conn->prepare($sql);
            $stmt->bindValue(":id", null);
            $stmt->bindValue(":name", $name);
            $stmt->bindValue(":introduction", $introduction);
            $stmt->bindValue(":startDate", $startDate);
            $stmt->bindValue(":endDate", $endDate);
            $stmt->bindValue(":detail", $detail);
            $stmt->bindValue(":peopleNum", $peopleNum);
            $stmt->execute();
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获得全部的活动信息，按创建日期降序排列
     * @return array 活动对象数组
     */
    public function getAllEvents() {
        $sql = "select * from " . $this->db_name . " order by startDate desc";
        $result = $this->DB->getList($sql);

        $events = array();
        for ($i = 0; $i < sizeof($result); $i++) {
            $rt = $result[$i];
            $name = $rt["name"];
            $introduction = $rt["introduction"];
            $startDate = $rt["startDate"];
            $endDate = $rt["endDate"];
            $detail = $rt["detail"];
            $peopleNum = $rt["peopleNum"];
            $event = new Event($name, $introduction, $startDate, $endDate, $detail, $peopleNum);
            $event->setState($this->judgeStateByTime($startDate,$endDate));//每次获得活动时动态设置活动状态
            array_push($events, $event);
        }

        return $events;
    }

    private function judgeStateByTime($startDate, $endDate) {
        $curDate = date("Y-m-d");
        if ($curDate <= $endDate && $curDate >= $startDate) {
            return "进行中";
        } elseif ($curDate < $startDate) {
            return "未开始";
        } else {
            return "已结束";
        }
    }
}

//$eventsService = new EventsService();

//$eventsService->createTable();

//$event = new Event("浦发银行，为爱开跑4", "浦发银行，为爱开跑", "2015-11-10", "2015-11-20", "我们是一个公益活动哦~",0);
//if ($eventsService->insert($event) == true) {
//    echo "success";
//} else {
//    echo "failed";
//}

//print_r($eventsService->getAllEvents());

