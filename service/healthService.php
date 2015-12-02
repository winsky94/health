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

        return $sports;
    }
}

$service = new healthService();
//echo json_encode($service->getSportsData("winsky","2015-12-02 20:12:11"));