<?php

/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/10/14
 * Description：
 */
class SqliteHelper {
    function __construct($file) {
        try {
            $this->conn = new PDO('sqlite:' . $file);
        } catch (PDOException $e) {
            try {
                $this->conn = new PDO('sqlite2:' . $file);
            } catch (PDOException $e) {
                exit('error!');
            }
        }
    }

    function __destruct() {
        $this->conn = null;
    }

    //直接运行SQL，可用于更新、删除数据
    function query($sql) {
        return $this->conn->query($sql);
    }

    //取得记录列表
    function getList($sql) {
        $recordList = array();
        foreach ($this->RecordArray($sql) as $rstmp) {
            $recordList[] = $rstmp;
        }
        return $recordList;
    }

    function Execute($sql) {
        return $this->query($sql)->fetch();
    }

    function RecordArray($sql) {
        return $this->query($sql)->fetchAll();
    }

    function RecordCount($sql) {
        return count($this->RecordArray($sql));
    }

    function RecordLastID() {
        return $this->conn->lastInsertId();
    }

    /**
     * 返回sql语句执行后受影响的行数
     * @param $sql
     * @return mixed
     */
    function getEffectedNum($sql){
        $result=$this->conn->prepare($sql);
        $result->execute();
        $num=$result->rowCount();
        return $num;
    }

}