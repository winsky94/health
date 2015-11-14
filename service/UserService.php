<?php
/**
 * Created with PhpStorm.
 * User: $winsky
 * Date: 2015/10/14
 * Description：进行用户信息的持久化存储和操作
 */

require_once('../utils/SqliteHelper.php');
require_once('../model/User.php');
require_once("../utils/PasswordEncrypt.php");
//header('Content-Type: text/xml');

class UserService {
    var $db_user_base_info = "user";
    var $db_user_body_info = "userBody";
    var $db_user_sleep_info = "userSleep";
    var $db_user_sport_info = "userSport";
    var $DB = null;

    public function __construct() {
        //创建实例
        $this->DB = new SqliteHelper('../data.db'); //这个数据库" title="数据库" >数据库文件名字任意
    }

    public function createTable() {
        $sql = "drop table if exists " . $this->db_user_base_info;
        $this->DB->query($sql);
        $sql = "create table " . $this->db_user_base_info . "(id integer primary key,userName varchar(40),password int, type varchar(20) ,age int,sex varchar(20),height int,weight int,telephone varchar(40), email varchar(40),lastLoadTime date default '—')";
        $this->DB->query($sql);

        $sql = "drop table if exists " . $this->db_user_body_info;
        $this->DB->query($sql);
        $sql = "create table " . $this->db_user_body_info . "(id integer primary key,userName varchar(40),height int,weight int,weightGoal,heart int,blood varchar(20),upLoadTime date)";
        $this->DB->query($sql);

        $sql = "drop table if exists " . $this->db_user_sleep_info;
        $this->DB->query($sql);
        $sql = "create table " . $this->db_user_sleep_info . "(id integer primary key,userName varchar(40),startTime varchar(80),endTime varchar(80),dsNum int,lsNum int,wakeNum int,wakeTime int,score double)";
        $this->DB->query($sql);

        $sql = "drop table if exists " . $this->db_user_sport_info;
        $this->DB->query($sql);
        $sql = "create table " . $this->db_user_sport_info . "(id integer primary key,userName varchar(40),upLoadTime date,meters double,minutes double,speed double ,calories double)";
        $this->DB->query($sql);
    }

    public function insert($user) {
        $username = $user->getUserName();

        $sql = "select * from " . $this->db_user_base_info . " where userName='" . $username . "'";
        $result = $this->DB->getList($sql);
        if (empty($result)) {
            $password = $this->encrypt($user->getPassword(), 'ENCODE');
            $type = $user->getType();
            $telephone = $user->getTelephone();
            $email = $user->getEmail();
            $age = $user->getAge();
            $sex = $user->getSex();
            $height = $user->getHeight();
            $weight = $user->getWeight();

            $sql = "insert into " . $this->db_user_base_info . " values(:id,:userName,:password,:type,:age,:sex,:height,:weight,:telephone,:email,datetime('now','localtime'))";
            $stmt = $this->DB->conn->prepare($sql);
            $stmt->bindValue(":id", null);
            $stmt->bindValue(":userName", $username);
            $stmt->bindValue(":password", "$password");
            $stmt->bindValue(":type", "$type");
            $stmt->bindValue(":age", "$age");
            $stmt->bindValue(":sex", "$sex");
            $stmt->bindValue(":height", "$height");
            $stmt->bindValue(":weight", "$weight");
            $stmt->bindValue(":telephone", "$telephone");
            $stmt->bindValue(":email", "$email");
            $stmt->execute();
            return true;
        } else {
            return false;
        }
    }

    public function modify($id, $user) {
        $userName = $user->getUserName();
        $password = $this->encrypt($user->getPassword(), 'ENCODE');
        $type = $user->getType();
        $telephone = $user->getTelephone();
        $email = $user->getEmail();
        $age = $user->getAge();
        $sex = $user->getSex();
        $height = $user->getHeight();
        $weight = $user->getWeight();

        $sql = "update " . $this->db_user_base_info . " set userName=:userName,password=:password,type=:type,age=:age,sex=:sex,height=:height,weight=:weight,telephone=:telephone,email=:email where id=:id";
        $stmt = $this->DB->conn->prepare($sql);
        $stmt->bindValue(":userName", $userName);
        $stmt->bindValue(":password", "$password");
        $stmt->bindValue(":type", "$type");
        $stmt->bindValue(":age", "$age");
        $stmt->bindValue(":sex", "$sex");
        $stmt->bindValue(":height", "$height");
        $stmt->bindValue(":weight", "$weight");
        $stmt->bindValue(":telephone", "$telephone");
        $stmt->bindValue(":email", "$email");
        $stmt->bindValue(":id", $id);
        $stmt->execute();
    }

    public function delete($id) {
        $sql = "delete from " . $this->db_user_base_info . " where id=" . $id;
        $this->DB->query($sql);
    }

    public function show() {
        $sql = "select * from " . $this->db_user_base_info;
        $result = $this->DB->getList($sql);
        foreach ($result as $row) {
            echo "userName = " . $row['userName'] . "<br>";
            echo "password = " . $row['password'] . "<br>";
            echo "type = " . $row['type'] . "<br>";
            echo "age = " . $row['age'] . "<br>";
            echo "sex = " . $row['sex'] . "<br>";
            echo "height = " . $row['height'] . "<br>";
            echo "weight = " . $row['weight'] . "<br>";
            echo "telephone =  " . $row['telephone'] . "<br>";
            echo "email =  " . $row['email'] . "<br><br>";
        }

    }

    public function checkLogin($userName, $password) {
//        $sql = "select * from " . $this->db_name . " where userName='" . $userName . "' and password='" . $password . "' limit 1";
//        $sql="update " .$this->db_name. " set lastLoadTime=datetime('now','localtime') where userName='" . $userName . "' and password='" . $password . "'";
//        $result = $this->DB->getEffectedNum($sql);
        $sql = "select password from " . $this->db_user_base_info . " where userName='" . $userName . "'";
        $result = $this->DB->getList($sql);
        if (sizeof($result) == 0) {
            return false;
        } else {
            $pass = $result[0][0];
            if ($password == $this->encrypt($pass, 'DECODE')) {
                $sql = "update " . $this->db_user_base_info . " set lastLoadTime=datetime('now','localtime') where userName='" . $userName . "'";
                $this->DB->query($sql);
                return true;
            } else {
                return false;
            }

        }
    }

    /**
     * 得到某一身份的所有用户
     * @param $type 用户身份 用户：user 医生-教练：doctor-coach 医生：doctor 教练：coach 管理员：admin
     * @return array 如果不是已定义的几种身份就返回全部数据
     */
    public function getUserList($type) {
        if ($type === 'doctor-coach') {
            $sql = "select * from " . $this->db_user_base_info . " where type ='doctor' or type='coach'";
        } else if ($type != "user" && $type != "admin" && $type != "doctor" && $type != "coach") {
            $sql = "select * from " . $this->db_user_base_info;
        } else {
            $sql = "select * from " . $this->db_user_base_info . " where type ='" . $type . "'";
        }

        return $this->DB->getList($sql);
    }

    /**
     * 根据用户名得到该用户的身份类型
     * @param $userName 用户名
     * @return 用户类型
     */
    public function getType($userName) {
        $sql = "select type from " . $this->db_user_base_info . " where userName='" . $userName . "' limit 1";
        $result = $this->DB->getList($sql);
        return $result[0]["type"];
    }

    /**
     * 得到用户的全部信息
     * @param $userName 用户名
     * @return User
     */
    public function getUserByName($userName) {
        $sql = "select * from " . $this->db_user_base_info . " where userName='" . $userName . "' limit 1";
        $result = $this->DB->getList($sql);
        $rt = $result[0];
        $password = $rt["password"];
        $type = $rt["type"];
        $age = $rt["age"];
        $sex = $rt["sex"];
        $height = $rt["height"];
        $weight = $rt["weight"];
        $telephone = $rt["telephone"];
        $email = $rt["email"];
        $lastLoadTime = $rt["lastLoadTime"];

        $user = new User($userName, $age, $sex, $type, $password, $height, $weight, $email, $telephone);
        $user->setLastLoadTime($lastLoadTime);
        return $user;
    }

    private function encrypt($password, $type) {
        //加密
        $p = new PasswordEncrypt();
        $password = $p->process($password, $type);
        return $password;
    }

    /**
     * 用户上传自己的身体健康数据
     * @param $userName
     * @param $height
     * @param $weight
     * @param $weightGoal
     * @param $heart
     * @param $blood
     */
    public function setUserBodyData($userName, $height, $weight, $weightGoal, $heart, $blood) {
        $sql = "insert into " . $this->db_user_body_info . " values(:id,:userName,:height,:weight,:weightGoal,:heart,:blood,datetime('now','localtime'))";
        $stmt = $this->DB->conn->prepare($sql);
        $stmt->bindValue(":id", null);
        $stmt->bindValue(":userName", $userName);
        $stmt->bindValue(":height", $height);
        $stmt->bindValue(":weight", $weight);
        $stmt->bindValue(":weightGoal", $weightGoal);
        $stmt->bindValue(":heart", $heart);
        $stmt->bindValue(":blood", $blood);
        $stmt->execute();
    }

    /**
     * 得到用户的身体数据
     * @param $userName 用户名
     * @return string 身体数据
     */
    public function getUserBodyData($userName) {
        $sql = "select * from " . $this->db_user_body_info . " where userName='" . $userName . "'";
        $result = $this->DB->getList($sql);

        $doc = new DOMDocument("1.0", "utf-8");  #声明文档类型
        $doc->formatOutput = true;               #设置可以输出操作

        $root = $doc->createElement("sportData");    #创建节点对象实体
        $doc->appendChild($root);      #把节点添加进来

        for ($i = 0; $i < sizeof($result); $i++) {
            $rt = $result[$i];
            $id = $rt["id"];
            $height = $rt["height"];
            $weight = $rt["weight"];
            $weightGoal = $rt["weightGoal"];
            $heart = $rt["heart"];
            $blood = $rt["blood"];
            $upLoadTime = $rt["upLoadTime"];

            $data = $doc->createElement("data");  #创建节点对象实体
            $root->appendChild($data);    #把节点添加到root节点的子节点

            $dataId = $doc->createAttribute("id");  #创建节点属性对象实体
            $data->appendChild($dataId);  #把属性添加到节点info中
            $dataId->appendChild($doc->createTextNode($id));

            $dateNode = $doc->createElement("date", $upLoadTime);    #创建节点对象实体
            $data->appendChild($dateNode);

            $heightNode = $doc->createElement("height", $height);
            $data->appendChild($heightNode);

            $weightNode = $doc->createElement("weight", $weight);
            $data->appendChild($weightNode);

            $weightGoalNode = $doc->createElement("weightGoal", $weightGoal);
            $data->appendChild($weightGoalNode);

            $heartNode = $doc->createElement("heart", $heart);
            $data->appendChild($heartNode);

            $bloodNode = $doc->createElement("blood", $blood);
            $data->appendChild($bloodNode);
        }

        return $doc->saveXML();
    }

    /**
     * 用户上传自己的运动数据
     * @param $userName
     * @param $meters
     * @param $minutes
     * @param $speed
     * @param $calories
     */
    public function setUserSportData($userName, $meters, $minutes, $speed, $calories) {
        $sql = "insert into " . $this->db_user_sport_info . " values(:id,:userName,datetime('now','localtime'),:meters,:minutes,:speed,:calories)";
        $stmt = $this->DB->conn->prepare($sql);
        $stmt->bindValue(":id", null);
        $stmt->bindValue(":userName", $userName);
        $stmt->bindValue(":meters", $meters);
        $stmt->bindValue(":minutes", $minutes);
        $stmt->bindValue(":speed", $speed);
        $stmt->bindValue(":calories", $calories);
        $stmt->execute();
    }

    /**
     * 得到用户运动数据
     * @param $userName 用户名
     * @return string 数据
     */
    public function getSportData($userName) {
        $sql = "select * from " . $this->db_user_sport_info . " where userName='" . $userName . "'";
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
     * @param $userName
     * @param $startTime
     * @param $endTime
     * @param $dsNum
     * @param $lsNum
     * @param $wakeNum
     * @param $wakeTime
     * @param $score
     */
    public function setSleepData($userName, $startTime, $endTime, $dsNum, $lsNum, $wakeNum, $wakeTime, $score) {
        $sql = "insert into " . $this->db_user_sleep_info . " values(:id,:userName,:startTime,:endTime,:dsNum,:lsNum,:wakeNum,:wakeTime,:score)";
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

    /**
     * 得到用户的睡眠数据
     * @param $userName 用户名
     * @return string 数据
     */
    public function getSleepData($userName) {
        $sql = "select * from " . $this->db_user_sleep_info . " where userName='" . $userName . "'";
        $result = $this->DB->getList($sql);

        $doc = new DOMDocument("1.0", "utf-8");  #声明文档类型
        $doc->formatOutput = true;               #设置可以输出操作

        $root = $doc->createElement("sleepData");    #创建节点对象实体
        $doc->appendChild($root);      #把节点添加进来

        for ($i = 0; $i < sizeof($result); $i++) {
            $rt = $result[$i];
            $id = $rt["id"];
            $startTime = $rt["startTime"];
            $endTime = $rt["endTime"];
            $dsNum = $rt["dsNum"];
            $lsNum = $rt["lsNum"];
            $wakeNum = $rt["wakeNum"];
            $wakeTime = $rt["wakeTime"];
            $score = $rt["score"];

            $data = $doc->createElement("data");  #创建节点对象实体
            $data = $root->appendChild($data);    #把节点添加到root节点的子节点

            $dataId = $doc->createAttribute("id");  #创建节点属性对象实体
            $data->appendChild($dataId);  #把属性添加到节点info中
            $dataId->appendChild($doc->createTextNode($id));

            $startTimeNode = $doc->createElement("startTime", $startTime);    #创建节点对象实体
            $data->appendChild($startTimeNode);

            $endTimeNode = $doc->createElement("endTime", $endTime);
            $data->appendChild($endTimeNode);

            $dsNumNode = $doc->createElement("dsNum", $dsNum);
            $data->appendChild($dsNumNode);

            $lsNumNode = $doc->createElement("lsNum", $lsNum);
            $data->appendChild($lsNumNode);

            $wakeNumNode = $doc->createElement("wakeNum", $wakeNum);
            $data->appendChild($wakeNumNode);

            $wakeTimeNode = $doc->createElement("wakeTime", $wakeTime);
            $data->appendChild($wakeTimeNode);

            $scoreNode = $doc->createElement("score", $score);
            $data->appendChild($scoreNode);
        }

        return $doc->saveXML();
    }
}

$user = new UserService();

//$user->createTable();

//$newUser = new User("winsky","22","男","user","12345a",177,76,"1195413185@qq.com","18013878510");
//$user->insert($newUser);
//$newUser = new User("捕风","22","男","doctor","12345a",177,76,"1195413185@qq.com","18013878510");
//$user->insert($newUser);
//$newUser = new User("捉影","22","男","coach","12345a",177,76,"1195413185@qq.com","18013878510");
//$user->insert($newUser);
//$newUser = new User("admin","22","男","admin","admin",177,76,"1195413185@qq.com","18013878510");
//$user->insert($newUser);

//$user->modify(1,$newUser);
//$user->delete(1);

//$user->show();

//if($user->checkLogin("admin","admin")==true){
//    echo "success";
//}
//else {
//    echo "failed";
//}

//echo $user->getType("捕风");

//$result=$user->getUserList("doctor-coach");
//print_r($result);

//$u=$user->getUserByName("admin");
//echo $u->getLastLoadTime();

//$user->setUserBodyData("winsky",177,68,60,75,"128/78");

//echo $user->getUserBodyData("winsky");

//$user->setUserSportData("winsky",0.62,19.6,1.90,39.9);

//echo $user->getSportData("winsky");

//$user->setSleepData("winsky", "2015-11-06 12:30:00", "2015-11-07 08:45:00", 113, 384, 0, 0, 3.0);

//echo $user->getSleepData("winsky");