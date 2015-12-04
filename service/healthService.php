<?php

/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/12/3
 * Description：
 */

require_once("../utils/SqliteHelper.php");

class healthService {
    var $db_name_sport = "userSport";
    var $db_name_goal = "goal";
    var $DB = null;

    public function __construct() {
        //创建实例
        $this->DB = new SqliteHelper('../data.db'); //这个数据库" title="数据库" >数据库文件名字任意
    }

    function createGoalTable() {
        $sql = "drop table if exists " . $this->db_name_goal;
        $this->DB->query($sql);
        $sql = "create table " . $this->db_name_goal . "(id integer primary key,userName varchar(20), type varchar(10),value int);";
        $this->DB->query($sql);
    }

    public function getSportsData($userName, $date) {
        $sql = "select * from " . $this->db_name_sport . " where userName='" . $userName . "' and upLoadTime<='" . $date . "' limit 7";
        $result = $this->DB->getList($sql);

        $sports = array("data1" => $result[0]["meters"],
            "data2" => $result[1]["meters"],
            "data3" => $result[2]["meters"],
            "data4" => $result[3]["meters"],
            "data5" => $result[4]["meters"],
            "data6" => $result[5]["meters"],
            "data7" => $result[6]["meters"]);

//        $dates = array("date1" => $this->handleDate($result[0]["upLoadTime"]),
//            "date2" => $this->handleDate($result[1]["upLoadTime"]),
//            "date3" => $this->handleDate($result[2]["upLoadTime"]),
//            "date4" => $this->handleDate($result[3]["upLoadTime"]),
//            "date5" => $this->handleDate($result[4]["upLoadTime"]),
//            "date6" => $this->handleDate($result[5]["upLoadTime"]),
//            "date7" => $this->handleDate($result[6]["upLoadTime"]));

//        $data = array("sports" => $sports,
//            "dates" => $dates);
//        return $data;

        return $sports;
    }

    public function getStaticsPerWeek($userName) {
        $today = date("Y-m-d", time());
        $week = $this->getCurWeekDay($today);
        $sunday = $week[0];
        $saturday = $week[6];

        $sql = "select sum(meters) as meters_total,sum(minutes) as minutes_total,sum(calories) as calories_total from " . $this->db_name_sport . " where userName='" . $userName . "' and upLoadTime<='" . $saturday . "' and upLoadTime>='" . $sunday . "'";
        $data = $this->DB->getList($sql);

        $meters_total = $data[0]["meters_total"];
        $minutes_total = $data[0]["minutes_total"];
        $calories_total = $data[0]["calories_total"];

        $minutes_total_hour = floor($minutes_total / 24);
        $minutes_total_minute = $minutes_total % 24;

        $result = array("meters_total" => $meters_total,
            "minutes_total_hour" => $minutes_total_hour,
            "minutes_total_minute" => $minutes_total_minute,
            "calories_total" => $calories_total
        );
        return $result;
    }

    private function getCurWeekDay($today) {
        $whichD = date('w', strtotime($today));
        $weeks = array();
        for ($i = 0; $i < 7; $i++) {
            if ($i < $whichD) {
                $date = strtotime($today) - ($whichD - $i) * 24 * 3600;
            } else {
                $date = strtotime($today) + ($i - $whichD) * 24 * 3600;
            }
            $weeks[$i] = date('Y-m-d', $date);

        }
        return $weeks;
    }

    public function setWeekGoal($userName, $type, $value) {
        $sql = "update " . $this->db_name_goal . " set value=:value,type=:type where userName=:userName;";
        $stmt = $this->DB->conn->prepare($sql);

        $stmt->bindValue(":value", $value);
        $stmt->bindValue(":type", $type);
        $stmt->bindValue(":userName", $userName);
        $result = $stmt->execute();
        return $result;
    }

    public function getWeekGoal($userName) {
        $sql = "select * from " . $this->db_name_goal . " where userName='" . $userName . "' limit 1;";
        $data = $this->DB->getList($sql);
        $type = $data[0]["type"];
        $value = $data[0]["value"];

        $result = array("goal_type" => $type, "value" => $value);

        return json_encode($result);

    }


}

$service = new healthService();
//echo json_encode($service->getSportsData("winsky", "2015-12-02 20:12:11"));

//$service->getStaticsPerWeek();

//$service->getStaticsPerWeek("winsky");

//$service->createGoalTable();

//echo $service->setWeekGoal("winsky","距离(公里)",22);

//echo $service->getWeekGoal("winsky");