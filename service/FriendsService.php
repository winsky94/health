<?php

/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/12/5
 * Description：
 */

require_once("../utils/SqliteHelper.php");
require_once("../model/User.php");
require_once("../utils/FinalVar.php");

class FriendsService {
    var $db_name = "friends";
    var $DB = null;

    public function __construct() {
        //创建实例
        $this->DB = new SqliteHelper('../data.db'); //这个数据库" title="数据库" >数据库文件名字任意
    }

    public function createTable() {
        $sql = "drop table if exists " . $this->db_name;
        $this->DB->query($sql);
        $sql = "create table " . $this->db_name . "(id integer primary key,name varchar(40),friends varchar(40));";
        $this->DB->query($sql);
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

    public function getFriendsByPage($userName, $pageNum) {
        $start = ($pageNum - 1) * numPerPage;
        $sql = "select userName,sex,age,lastLoadTime from " . $this->db_name . ",user where name='" . $userName . "' and userName=friends order by lastLoadTime desc limit " . $start . "," . numPerPage;
        $result = $this->DB->getList($sql);

        $friends = array();
        foreach ($result as $rt) {
            $name = $rt["userName"];
            $sex = $rt["sex"];
            $age = $rt["age"];
            $lastLoadTime = $rt["lastLoadTime"];
            $friend = new User($name, $age, $sex, -1, "", "", "", "", "");
            $friend->setLastLoadTime($lastLoadTime);
            array_push($friends, $friend);
        }
        return $friends;
    }

    public function makeFriends($name, $friend) {
        $sql = "select count(id) from " . $this->db_name . " where name='" . $name . "' and friends='" . $friend . "';";
        $hasJoined = $this->DB->getList($sql);
        if ($hasJoined[0][0] != 0) {
            return false;
        } else {
            $sql = "insert into " . $this->db_name . " values(:id,:name,:friend)";
            $stmt = $this->DB->conn->prepare($sql);
            $stmt->bindValue(":id", null);
            $stmt->bindValue(":name", $name);
            $stmt->bindValue(":friend", $friend);
            $result = $stmt->execute();
            return $result;
        }
    }
}

$friend = new FriendsService();
//$friend->createTable();

//$friend->makeFriends("winsky","testUser");

//print_r($friend->getFriendsByPage("winsky",1));

