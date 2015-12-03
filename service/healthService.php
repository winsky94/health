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
    var $DB = null;

    public function __construct() {
        //创建实例
        $this->DB = new SqliteHelper('../data.db'); //这个数据库" title="数据库" >数据库文件名字任意
    }


    private function handleDate($date) {
        $arr = explode(" ", $date);
        $result = substr($arr[0], 5);

//        $newArr=explode(":",$arr[1]);
//        $result=$result." ".$newArr[0].":".$newArr[1];
        return $result;
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

        $dates = array("date1" => $this->handleDate($result[0]["upLoadTime"]),
            "date2" => $this->handleDate($result[1]["upLoadTime"]),
            "date3" => $this->handleDate($result[2]["upLoadTime"]),
            "date4" => $this->handleDate($result[3]["upLoadTime"]),
            "date5" => $this->handleDate($result[4]["upLoadTime"]),
            "date6" => $this->handleDate($result[5]["upLoadTime"]),
            "date7" => $this->handleDate($result[6]["upLoadTime"]));

        $data = array("sports" => $sports,
            "dates" => $dates);
        return $data;
    }


}

//$service = new healthService();
//echo json_encode($service->getSportsData("winsky", "2015-12-02 20:12:11"));