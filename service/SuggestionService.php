<?php

/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/11/28
 * Description：
 */

require_once("../utils/SqliteHelper.php");
require_once("../model/Suggestion.php");
require_once("../utils/FinalVar.php");

class SuggestionService {
    var $db_name = "suggestion";
    var $DB = null;

    public function __construct() {
        //创建实例
        $this->DB = new SqliteHelper('../data.db'); //这个数据库" title="数据库" >数据库文件名字任意
    }

    public function createTable() {
        $sql = "drop table if exists " . $this->db_name;
        $this->DB->query($sql);
        $sql = "create table " . $this->db_name . "(id integer primary key,title varchar(40),content varchar(200),author varchar(20),type varchar(20),email varchar(20),telephone varchar(20),time varchar(20));";
        $this->DB->query($sql);
    }

    public function insert($suggestion) {
        $title = $suggestion->getTitle();
        $content = $suggestion->getContent();
        $author = $suggestion->getAuthor();
        $type = $suggestion->getType();
        $email = $suggestion->getEmail();
        $telephone = $suggestion->getTelephone();
        $time = $suggestion->getTime();

        if ($time == null || $time == "") {
            $time = date('Y-m-d H:i:s');
        }

        //将身份换为英文存储
        if ($type == "医生") {
            $type = "doctor";
        } elseif ($type == "教练") {
            $type = "coach";
        } elseif ($type == "用户") {
            $type = "user";
        }


        $sql = "insert into " . $this->db_name . " values(:id,:title,:content,:author,:type,:email,:telephone,:time)";
        $stmt = $this->DB->conn->prepare($sql);
        $stmt->bindValue(":id", null);
        $stmt->bindValue(":title", $title);
        $stmt->bindValue(":content", $content);
        $stmt->bindValue(":author", $author);
        $stmt->bindValue(":type", $type);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":telephone", $telephone);
        $stmt->bindValue(":time", $time);

        $stmt->execute();
        return true;
    }


    /**
     * 获得全部的建议信息，按创建日期降序排列
     * @return array 建议对象数组
     */
    public function getAllSuggestions() {
        $sql = "select * from " . $this->db_name . " order by time desc";
        $result = $this->DB->getList($sql);

        $suggestions = array();
        foreach ($result as $rt) {
            $title = $rt["title"];
            $content = $rt["content"];
            $author = $rt["author"];
            $type = $rt["type"];
            $email = $rt["email"];
            $telephone = $rt["telephone"];
            $time = $rt["time"];
            $suggestion = new Suggestion($title, $content, $author, $type, $email, $telephone);
            $suggestion->setTime($time);
            array_push($suggestions, $suggestion);
        }

        return $suggestions;
    }

    public function getSuggestionsByPage($pageNum) {
        $start = ($pageNum - 1) * numPerPage;
        $sql = "select * from " . $this->db_name . " order by time desc limit " . $start . "," . numPerPage;
        $result = $this->DB->getList($sql);

        $suggestions = array();
        foreach ($result as $rt) {
            $title = $rt["title"];
            $content = $rt["content"];
            $author = $rt["author"];
            $type = $rt["type"];
            $email = $rt["email"];
            $telephone = $rt["telephone"];
            $time = $rt["time"];
            $suggestion = new Suggestion($title, $content, $author, $type, $email, $telephone);
            $suggestion->setTime($time);
            array_push($suggestions, $suggestion);
        }
        return $suggestions;
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
}

//$service = new SuggestionService();

//$service->createTable();

//for ($i = 0; $i < 27; $i++) {
//    $suggestion=new Suggestion("多跑步".$i."~","跑步有益于身心健康","捕风","医生","1195413185@qq.com","17766088236");
//    $service->insert($suggestion);
//}

//echo date('Y-m-d H:i:s');
