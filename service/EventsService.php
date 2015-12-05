<?php

/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/10/22
 * Description： 活动的相关数据操作
 */

require_once("../utils/SqliteHelper.php");
require_once("../model/Event.php");
require_once("../utils/FinalVar.php");


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
        foreach ($result as $rt) {
            $name = $rt["name"];
            $introduction = $rt["introduction"];
            $startDate = $rt["startDate"];
            $endDate = $rt["endDate"];
            $detail = $rt["detail"];
            $peopleNum = $rt["peopleNum"];
            $event = new Event($name, $introduction, $startDate, $endDate, $detail, $peopleNum);
            $event->setState($this->judgeStateByTime($startDate, $endDate));//每次获得活动时动态设置活动状态
            array_push($events, $event);
        }

        return $events;
    }

    public function getEventsByPage($pageNum) {
        $start = ($pageNum - 1) * numPerPage;
        $sql = "select * from " . $this->db_name . " order by startDate desc limit " . $start . "," . numPerPage;
        $result = $this->DB->getList($sql);

        $events = array();
        foreach ($result as $rt) {
            $name = $rt["name"];
            $introduction = $rt["introduction"];
            $startDate = $rt["startDate"];
            $endDate = $rt["endDate"];
            $detail = $rt["detail"];
            $peopleNum = $rt["peopleNum"];
            $event = new Event($name, $introduction, $startDate, $endDate, $detail, $peopleNum);
            $event->setState($this->judgeStateByTime($startDate, $endDate));//每次获得活动时动态设置活动状态
            array_push($events, $event);
        }
        return $events;
    }

    public function getPageNum() {
        $sql = "select count(*) from " . $this->db_name;
        $result = $this->DB->getList($sql);
        $num = $result[0][0];

        //注意，php中/得到的是完整的结果

        //附：php对数的保留位数操作操作
        //float ceil ( float value ) 返回不小于 value 的下一个整数，value 如果有小数部分则进一位。ceil() 返回的类型仍然是 float
        //float floor ( float value ) 返回不大于 value 的下一个整数，将 value 的小数部分舍去取整。floor() 返回的类型仍然是 float
        //float round ( float val [, int precision] ) 返回将 val 根据指定精度 precision（十进制小数点后数字的数目）进行四舍五入的结果

        $result = ceil($num / numPerPage);
        return $result;
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

    public function joinEvent($userName, $title) {
        $sql = "select count(id) from event_user where userName='" . $userName . "' and eventTitle='" . $title . "';";
        $hasJoined = $this->DB->getList($sql);
        if ($hasJoined[0][0] != 0) {
            return false;
        } else {
            $sql = "update " . $this->db_name . " set peopleNum=peopleNum+1 where name=:title;";
            $stmt = $this->DB->conn->prepare($sql);
            $stmt->bindValue(":title", $title);
            $result = $stmt->execute();

            if ($result == true) {
                $sql = "insert into event_user values(:id,:userName,:eventTitle)";
                $stmt = $this->DB->conn->prepare($sql);
                $stmt->bindValue(":id", null);
                $stmt->bindValue(":userName", $userName);
                $stmt->bindValue(":eventTitle", $title);
                $result = $stmt->execute();
            }
            return $result;
        }
    }

    public function getJoinedEvents($userName) {
        $sql = "select eventTitle from event_user where userName='" . $userName . "'";
        $result = $this->DB->getList($sql);

        $eventTitles = array();
        foreach ($result as $rt) {
            $title = $rt["eventTitle"];
            array_push($eventTitles, $title);
        }
        return $eventTitles;

    }

    function createUserEventTable() {
        $sql = "drop table if exists event_user";
        $this->DB->query($sql);
        $sql = "create table event_user(id integer primary key,userName varchar(40),eventTitle varchar(40));";
        $this->DB->query($sql);
    }

    public function deleteEvent($title) {
        $sql = "delete from " . $this->db_name . " where name='" . $title . "';";
        $stmt = $this->DB->conn->prepare($sql);
        $result = $stmt->execute();
        if ($result) {
            $sql = "delete from event_user where eventTitle='" . $title . "';";
            $stmt = $this->DB->conn->prepare($sql);
            $stmt->execute();
        }

        return $result;
    }

    public function updateEvent($event) {
        $sql = "update " . $this->db_name . " set introduction=:introduction,startDate=:startDate,endDate=:endDate,detail=:detail where name=:name;";

        $name = $event->getName();
        $introduction = $event->getIntroduction();
        $startDate = $event->getStartDate();
        $endDate = $event->getEndDate();
        $detail = $event->getDetail();

        $stmt = $this->DB->conn->prepare($sql);
        $stmt->bindValue(":name", $name);
        $stmt->bindValue(":introduction", $introduction);
        $stmt->bindValue(":startDate", $startDate);
        $stmt->bindValue(":endDate", $endDate);
        $stmt->bindValue(":detail", $detail);

        $result = $stmt->execute();
        return $result;
    }

    public function getEventsByTitle($title) {
        $sql = "select * from " . $this->db_name . " where name= '" . $title . "' limit 1;";
        $result = $this->DB->getList($sql);

        $events = array();
        foreach ($result as $rt) {
            $name = $rt["name"];
            $introduction = $rt["introduction"];
            $startDate = $rt["startDate"];
            $endDate = $rt["endDate"];
            $detail = $rt["detail"];
            $peopleNum = $rt["peopleNum"];
            $event = new Event($name, $introduction, $startDate, $endDate, $detail, $peopleNum);
            $event->setState($this->judgeStateByTime($startDate, $endDate));//每次获得活动时动态设置活动状态
            array_push($events, $event);
        }
        return $events;
    }
}

$eventsService = new EventsService();

//$eventsService->createTable();

//for ($i = 25; $i < 35; $i++) {
//    $event = new Event("浦发银行，为爱开跑" . $i, "浦发银行，为爱开跑", "2015-11-10", "2015-11-20", "我们是一个公益活动哦~", 0);
//    if ($eventsService->insert($event) == true) {
//        echo "success<br>";
//    } else {
//        echo "failed<br>";
//    }
//}


//print_r($eventsService->getAllEvents());

//echo $eventsService->getPageNum();

//print_r($eventsService->getEventsByPage(2));

//$eventsService->createUserEventTable();

//echo $eventsService->joinEvent("winsky","浦发银行，为爱开跑");

