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
        $sql = "select * from " . $this->db_name;


        $paramNum = func_num_args();    #获取参数个数
        $params = func_get_args();    #获取参数值

        if ($paramNum == 2) {
            $sql = $sql . " where author='" . $params[1] . "'";
        }

        $sql = $sql . " order by time desc limit " . $start . "," . numPerPage;

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

        $paramNum = func_num_args();    #获取参数个数
        $params = func_get_args();    #获取参数值

        if ($paramNum != 0) {
            $sql = $sql . " where author='" . $params[0] . "'";
        }
        $result = $this->DB->getList($sql);
        $num = $result[0][0];
        $result = ceil($num / numPerPage);
        return $result;
    }

    public function search($type, $keyword) {
        $sql = "select * from " . $this->db_name;
        if ($keyword != "") {
            if ($type == "content") {
                $sql = $sql . " where content like '%" . $keyword . "%'";
            } elseif ($type == "title") {
                $sql = $sql . " where title like '%" . $keyword . "%'";
            } else {
                $sql = $sql . " where content like '%" . $keyword . "%' or title like '%" . $keyword . "%'";
            }
        }

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

}

$service = new SuggestionService();
//
//$service->createTable();
//
//for ($i = 0; $i < 2; $i++) {
//    $suggestion=new Suggestion("多跑步".$i."~","跑步有益于身心健康","捕风","医生","1195413185@qq.com","17766088236");
//    $service->insert($suggestion);
//}

//echo $service->getPageNum("捕风");

//print_r($service->getSuggestionsByPage(1,"捕风"));
