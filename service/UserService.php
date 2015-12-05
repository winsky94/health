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
require_once("../utils/FinalVar.php");

//header('Content-Type: text/xml');

class UserService {
    var $db_user_base_info = "user";
    var $db_user_body_info = "userBody";
    var $db_user_sleep_info = "userSleep";
    var $db_user_sport_info = "userSport";
    var $db_user_reverse_info = "reverse";
    var $DB = null;

    public function __construct() {
        //创建实例
        $this->DB = new SqliteHelper('../data.db'); //这个数据库" title="数据库" >数据库文件名字任意
    }

    public function createReverseTable() {
        $sql = "drop table if exists " . $this->db_user_reverse_info;
        $this->DB->query($sql);
        $sql = "create table " . $this->db_user_reverse_info . "(id integer primary key,followerName varchar(20),followedName varchar(20));";
        $this->DB->query($sql);
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

    //用户名不可以改，密码，身份不是通过这个方法修改
    public function modifyInfo($user) {
        $userName = $user->getUserName();
        $telephone = $user->getTelephone();
        $email = $user->getEmail();
        $age = $user->getAge();
        $sex = $user->getSex();
        $height = $user->getHeight();
        $weight = $user->getWeight();

        $sql = "update " . $this->db_user_base_info . " set age=:age,sex=:sex,height=:height,weight=:weight,telephone=:telephone,email=:email where userName=:userName";
        $stmt = $this->DB->conn->prepare($sql);
        $stmt->bindValue(":age", "$age");
        $stmt->bindValue(":sex", "$sex");
        $stmt->bindValue(":height", "$height");
        $stmt->bindValue(":weight", "$weight");
        $stmt->bindValue(":telephone", "$telephone");
        $stmt->bindValue(":email", "$email");
        $stmt->bindValue(":userName", $userName);
        $stmt->execute();

        return true;
    }

    /**
     * 修改密码
     * @param $userName 用户名
     * @param $password 原密码
     * @param $newPassword 新密码
     * @return bool
     */
    public function modifyPassword($userName, $password, $newPassword) {
        $encryptP = $this->encrypt($password, 'ENCODE');
        $encryptNP = $this->encrypt($newPassword, 'ENCODE');

        $sql = "update " . $this->db_user_base_info . " set password=:newPassword where userName=:userName and password=:password";
        $stmt = $this->DB->conn->prepare($sql);
        $stmt->bindValue(":userName", $userName);
        $stmt->bindValue(":newPassword", $encryptNP);
        $stmt->bindValue(":password", $encryptP);
        $result = $stmt->execute();

        return $result;
    }

    public function delete($userName) {
        $sql = "delete from " . $this->db_user_base_info . " where userName=:userName;";
        $stmt = $this->DB->conn->prepare($sql);
        $stmt->bindValue(":userName", $userName);
        $result = $stmt->execute();
        return $result;
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
        if (sizeof($result) > 0) {
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
        }

        return $user;
    }

    private function encrypt($password, $type) {
        //加密
        $p = new PasswordEncrypt();
        $password = $p->process($password, $type);
        return $password;
    }

    /**
     * 建立预约关系
     * @param $followerName 发起预约的人
     * @param $followedName 被预备的对象
     * @return array|bool
     */
    public function reverse($followerName, $followedName) {
        $sql = "select * from " . $this->db_user_reverse_info . " where followerName='" . $followerName . "' and followedName='" . $followedName . "' limit 1;";
        $result = $this->DB->getList($sql);
        if (empty($result)) {
            $sql = "insert into " . $this->db_user_reverse_info . " values(:id,:followerName,:followedName);";
            $stmt = $this->DB->conn->prepare($sql);
            $stmt->bindValue(":id", null);
            $stmt->bindValue(":followerName", $followerName);
            $stmt->bindValue(":followedName", "$followedName");
            $result = $stmt->execute();
            return $result;
        } else {
            return false;
        }
    }

    public function getReverseCustomer($userName) {
        $sql = "select userName,sex,height,weight,lastLoadTime from " . $this->db_user_reverse_info . "," . $this->db_user_base_info . " where followedName='" . $userName . "' and userName=followerName;";
        $result = $this->DB->getList($sql);
        return $result;
    }

    public function getPageNum() {
        $sql = "select count(*) from " . $this->db_user_base_info . " where type='user'";
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

    public function getUsersByPage($pageNum) {
        $start = ($pageNum - 1) * numPerPage;
        $sql = "select * from " . $this->db_user_base_info . " where type='user' order by lastLoadTime desc limit " . $start . "," . numPerPage;
        $result = $this->DB->getList($sql);

        $users = array();
        foreach ($result as $rt) {
            $name = $rt["userName"];
            $sex = $rt["sex"];
            $age = $rt["age"];
            $lastLoadTime = $rt["lastLoadTime"];
            $user = new User($name, $age, $sex, -1, "", "", "", "", "");
            $user->setLastLoadTime($lastLoadTime);
            array_push($users, $user);
        }
        return $users;
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

//$newUser = new User("winsky","22","男","user","12345a",177,76,"1195413185@qq.com","18013878511");
//$user->modifyInfo($newUser);

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

//$u=$user->getUserByName("winsky");
//echo $u->getLastLoadTime();

//$user->createReverseTable();

//echo $user->reverse("winsky","bufeng");

//print_r($user->getUsersByPage(1));

//echo $user->getPageNum();