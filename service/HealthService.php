<?php

/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/12/3
 * Description：
 */

require_once("../utils/SqliteHelper.php");

class HealthService {
    var $db_name_goal = "goal";
    var $db_name_body = "userBody";
    var $db_name_sleep = "userSleep";
    var $db_name_sport = "userSport";
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

        if (sizeof($result) > 0) {
            $sports = array("data1" => $result[0]["meters"],
                "data2" => $result[1]["meters"],
                "data3" => $result[2]["meters"],
                "data4" => $result[3]["meters"],
                "data5" => $result[4]["meters"],
                "data6" => $result[5]["meters"],
                "data7" => $result[6]["meters"]);
        } else {
            $sports = array("data1" => 0,
                "data2" => 0,
                "data3" => 0,
                "data4" => 0,
                "data5" => 0,
                "data6" => 0,
                "data7" => 0);
        }


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

        if (sizeof($data) == 1) {
            $meters_total = $data[0]["meters_total"];
            $minutes_total = $data[0]["minutes_total"];
            $calories_total = $data[0]["calories_total"];
        } else {
            $meters_total = 0;
            $minutes_total = 0;
            $calories_total = 0;
        }


        if ($meters_total == "") {
            $meters_total = 0;
        }
        if ($calories_total == "") {
            $calories_total = 0;
        }

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
        if (sizeof($data) == 1) {
            $type = $data[0]["type"];
            $value = $data[0]["value"];
        } else {
            $type = "距离(公里)";
            $value = 0;
        }


        $result = array("goal_type" => $type, "value" => $value);

        return json_encode($result);

    }

    /**
     * 用户上传自己的身体健康数据
     * @param $userName
     * @param $height
     * @param $weight
     * @param $weightGoal
     * @param $heart
     * @param $blood
     * @return bool
     */
    public function setUserBodyData($userName, $height, $weight, $weightGoal, $heart, $blood) {
        $sql = "insert into " . $this->db_name_body . " values(:id,:userName,:height,:weight,:weightGoal,:heart,:blood,datetime('now','localtime'))";
        $stmt = $this->DB->conn->prepare($sql);
        $stmt->bindValue(":id", null);
        $stmt->bindValue(":userName", $userName);
        $stmt->bindValue(":height", $height);
        $stmt->bindValue(":weight", $weight);
        $stmt->bindValue(":weightGoal", $weightGoal);
        $stmt->bindValue(":heart", $heart);
        $stmt->bindValue(":blood", $blood);
        $result = $stmt->execute();
        return $result;
    }

    /**
     * 得到用户的身体数据
     * @param $userName 用户名
     * @param $num 数据量
     * @return string 身体数据
     */
    public function getUserBodyData($userName, $num) {
        $sql = "select * from " . $this->db_name_body . " where userName='" . $userName . "' order by upLoadTime desc";

        if ($num > 0) {
            $sql = $sql . " limit " . $num . ";";
        }
        $result = $this->DB->getList($sql);

        $data = array();
        foreach ($result as $rt) {
            $height = $rt["height"];
            $weight = $rt["weight"];
            $weightGoal = $rt["weightGoal"];
            $heart = $rt["heart"];
            $blood = $rt["blood"];
            $upLoadTime = $rt["upLoadTime"];

            $bodyData = array("height" => $height, "weight" => $weight, "weightGoal" => $weightGoal, "heart" => $heart, "blood" => $blood, "upLoadTime" => $upLoadTime);

            array_push($data, $bodyData);
        }
        return $data;
    }

    /**
     * 用户上传自己的运动数据
     * @param $data
     * @return bool
     */
    public function setUserSportData($data) {
        $sql = "insert into " . $this->db_name_sport . " values(:id,:userName,:time,:meters,:minutes,:speed,:calories)";

        $conn = $this->DB->conn;
        $conn->beginTransaction();
        try {
            foreach ($data as $row) {
                $userName = $row[0];
                $time = $row[1];
                $meters = $row[2];
                $minutes = $row[3];
                $speed = $row[4];
                $calories = $row[5];
                $stmt = $this->DB->conn->prepare($sql);
                $stmt->bindValue(":id", null);
                $stmt->bindValue(":userName", $userName);
                $stmt->bindValue(":time", $time);
                $stmt->bindValue(":meters", $meters);
                $stmt->bindValue(":minutes", $minutes);
                $stmt->bindValue(":speed", $speed);
                $stmt->bindValue(":calories", $calories);
                $stmt->execute();
            }
            $conn->commit();
            return true;
        } catch (PDOException $ex) {
            $conn->rollBack();
            return false;
        }


    }

    /**
     * 得到用户运动数据
     * @param $userName 用户名
     * @return string 数据
     */
    public function getSportData($userName) {
        $sql = "select * from " . $this->db_name_sport . " where userName='" . $userName . "'";
        $result = $this->DB->getList($sql);

        $doc = new DOMDocument("1.0", "utf-8");  #声明文档类型
        $doc->formatOutput = true;               #设置可以输出操作

        $root = $doc->createElement("sportData");    #创建节点对象实体
        $doc->appendChild($root);      #把节点添加进来

        for ($i = 0; $i < sizeof($result); $i++) {
            $rt = $result[$i];
            $id = $rt["id"];
            $upLoadTime = $rt["upLoadTime"];
            $meters = $rt["meters"];
            $minutes = $rt["minutes"];
            $speed = $rt["speed"];
            $calories = $rt["calories"];


            $data = $doc->createElement("data");  #创建节点对象实体
            $data = $root->appendChild($data);    #把节点添加到root节点的子节点

            $dataId = $doc->createAttribute("id");  #创建节点属性对象实体
            $data->appendChild($dataId);  #把属性添加到节点info中
            $dataId->appendChild($doc->createTextNode($id));

            $dateNode = $doc->createElement("date", $upLoadTime);    #创建节点对象实体
            $data->appendChild($dateNode);

            $metersNode = $doc->createElement("meters", $meters);
            $data->appendChild($metersNode);

            $minutesNode = $doc->createElement("minutes", $minutes);
            $data->appendChild($minutesNode);

            $speedNode = $doc->createElement("speed", $speed);
            $data->appendChild($speedNode);

            $caloriesNode = $doc->createElement("calories", $calories);
            $data->appendChild($caloriesNode);
        }

        return $doc->saveXML();
    }

    /**
     * 用户上传自己的睡眠数据
     * @param $data
     */
    public function setSleepData($data) {
        $sql = "insert into " . $this->db_name_sleep . " values(:id,:userName,:startTime,:endTime,:dsNum,:lsNum,:wakeNum,:wakeTime,:score)";

        $conn = $this->DB->conn;
        $conn->beginTransaction();
        try {
            foreach ($data as $row) {
                $userName = $row[0];
                $startTime = $row[1];
                $endTime = $row[2];
                $dsNum = $row[3];
                $lsNum = $row[4];
                $wakeNum = $row[5];
                $wakeTime = $row[6];
                $score = $row[7];

                $stmt = $this->DB->conn->prepare($sql);
                $stmt->bindValue(":id", null);
                $stmt->bindValue(":userName", $userName);
                $stmt->bindValue(":startTime", $startTime);
                $stmt->bindValue(":endTime", $endTime);
                $stmt->bindValue(":dsNum", $dsNum);
                $stmt->bindValue(":lsNum", $lsNum);
                $stmt->bindValue(":wakeNum", $wakeNum);
                $stmt->bindValue(":wakeTime", $wakeTime);
                $stmt->bindValue(":score", $score);

                $stmt->execute();
            }
            $conn->commit();
        } catch (PDOException $ex) {
            $conn->rollBack();
        }
    }

    /**
     * 得到用户的睡眠数据
     * @param $userName
     * @param $num
     * @param $date
     * @return array
     */
    public function getSleepData($userName, $num, $date) {
        if ($date == "今天") {
            $date = date('y-m-d', time());
        }
        $sql = "select * from " . $this->db_name_sleep . " where userName='" . $userName . "' and substr(startTime,0,11)<='" . $date . "' order by startTime desc";
        if ($num > 0) {
            $sql = $sql . " limit " . $num;
        }
        $result = $this->DB->getList($sql);

        $data = array();

        foreach ($result as $row) {
            $startTime = $row["startTime"];
            $endTime = $row["endTime"];
            $dsNum = $row["dsNum"];
            $lsNum = $row["lsNum"];
            $wakeNum = $row["wakeNum"];
            $wakeTime = $row["wakeTime"];
            $score = $row["score"];

            $sleepData = array("startTime" => $startTime,
                "endTime" => $endTime,
                "dsNum" => $dsNum,
                "lsNum" => $lsNum,
                "wakeNum" => $wakeNum,
                "wakeTime" => $wakeTime,
                "score" => $score
            );

            array_push($data, $sleepData);
        }

        return json_encode($data);
    }

    public function getSleepDataByDay($userName, $day) {
        $sql = "select * from " . $this->db_name_sleep . " where userName='" . $userName . "' and substr(startTime,0,11)='" . $day . "' limit 1";
        $result = $this->DB->getList($sql);

        if (sizeof($result) == 1) {
            $startTime = $result[0]["startTime"];
            $endTime = $result[0]["endTime"];
            $wakeTime = $result[0]["wakeTime"];

            $total = (strtotime($endTime) - strtotime($startTime)) - $wakeTime;

            $hour = floor($total % 86400 / 3600);
            $minute = floor($total % 86400 % 3600 / 60);

            $validPerCent = $total / (strtotime($endTime) - strtotime($startTime));
        } else {
            $startTime = 0;
            $endTime = 0;

            $hour = 0;
            $minute = 0;
            $validPerCent = 0;
        }

        $data = array("startTime" => $startTime, "endTime" => $endTime, "hour" => $hour, "minute" => $minute, "validPerCent" => $validPerCent);

        return json_encode($data);

    }

    public function updateSportData($userName, $date, $data) {
        $sql = "update " . $this->db_name_sport . " set meters=:meters,minutes=:minutes,speed=:speed,calories=:calories where userName=:userName and upLoadTime='" . $date . "';";
        $meters = $data[2];
        $minutes = $data[3];
        $speed = $data[4];
        $calories = $data[5];

        $stmt = $this->DB->conn->prepare($sql);
        $stmt->bindValue(":meters", $meters);
        $stmt->bindValue(":minutes", $minutes);
        $stmt->bindValue(":speed", $speed);
        $stmt->bindValue(":calories", $calories);
        $stmt->bindValue(":userName", $userName);

        $result = $stmt->execute();
        return $result;
    }

    public function deleteSportData($userName, $date) {
        $sql = "delete from " . $this->db_name_sport . " where userName=:userName and upLoadTime='" . $date . "'";
        $stmt = $this->DB->conn->prepare($sql);
        $stmt->bindValue(":userName", $userName);
        $result = $stmt->execute();
        return $result;
    }

    public function getRank($userName) {
        $data = array();
        $my_data = $this->getStaticsPerWeek($userName)["meters_total"];
        array_push($data, (int)$my_data);

        $sql = "select friends from friends where name='" . $userName . "';";
        $friends = $this->DB->getList($sql);

        foreach ($friends as $friend) {
            foreach ($friend as $myFriend) {
                $friend_data = $this->getStaticsPerWeek($myFriend);
                $meter_total = $friend_data["meters_total"];
                array_push($data, (int)$meter_total);
            }

        }

        rsort($data);
        $rank = 1;
        for ($i = 1; $i <= sizeof($data); $i++) {
            if ($data[$i - 1] == $my_data) {
                $rank = $i;
                break;
            }
        }
        return $rank;
    }
}

$service = new HealthService();
//echo json_encode($service->getSportsData("winsky", "2015-12-02 20:12:11"));

//$service->getStaticsPerWeek();

//$service->getStaticsPerWeek("winsky");

//$service->createGoalTable();

//echo $service->setWeekGoal("winsky","距离(公里)",22);

//echo $service->getWeekGoal("winsky");

//print_r($service->getUserBodyData("winsky",5));

//$service->getSleepDataByDay("winsky","2015-12-02");

//print_r($service->getSleepData("winsky",7,"2015-12-04"));

//$data=array("winsky","2002-03-28 14:47:0","1.34","20.24","13.48","200");
//echo $service->updateSportData("winsky","2002-03-28 14:47:0",$data);

//echo $service->setWeekGoal("winsky","时长(小时)",7);
//echo $service->deleteSportData("winsky","2002-03-27 15:15:41");

// print_r($service->getStaticsPerWeek("winsky"));

//$data=array("winsky","2015-12-06 14:47:0","1.34","20.24","13.48","200");
//$d=array();
//array_push($d,$data);
//echo $service->setUserSportData($d);

//print_r($service->getUserBodyData("winsky",1));