<?php

/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/12/6
 * Description：
 */

require_once("../model/Interest.php");
require_once("../utils/SqliteHelper.php");

class InterestService {
    var $db_name = "interests";
    var $DB = null;

    public function __construct() {
        //创建实例
        $this->DB = new SqliteHelper('../data.db'); //这个数据库" title="数据库" >数据库文件名字任意
    }

    public function createTable() {
        $sql = "drop table if exists " . $this->db_name;
        $this->DB->query($sql);
        $sql = "create table " . $this->db_name . "(id integer primary key,userName varchar(40),content varchar(400),time varchar(20));";
        $this->DB->query($sql);
    }

    public function insert($interest) {
        $userName = $interest->getUserName();
        $content = $interest->getContent();
        $time = $interest->getTime();

        $sql = "insert into " . $this->db_name . " values(:id,:userName,:content,:time)";
        $stmt = $this->DB->conn->prepare($sql);
        $stmt->bindValue(":id", null);
        $stmt->bindValue(":userName", $userName);
        $stmt->bindValue(":content", $content);
        $stmt->bindValue(":time", $time);

        $result = $stmt->execute();
        return $result;
    }

    public function getAllInterest() {
        $sql = "select * from " . $this->db_name;

        $paramNum = func_num_args();    #获取参数个数
        if ($paramNum == 1) {
            $params = func_get_args();    #获取参数值
            $userName = $params[0];
            $sql = $sql . " where userName='" . $userName . "'";
        }

        $sql = $sql . " order by time desc;";

        $data = $this->DB->getList($sql);

        $interests = array();
        foreach ($data as $row) {
            $userName = $row["userName"];
            $content = $row["content"];
            $time = $row["time"];

            $interest = new Interest($userName, $content, $time);
            array_push($interests, $interest);
        }

        return $interests;
    }
}

$service = new InterestService();
//$service->createTable();

//print_r($service->getAllInterest("winsky"));