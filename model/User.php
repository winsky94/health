<?php

/**
 * Created with PhpStorm.
 * User: $winsky
 * Date: 2015/10/14
 * Description：网站注册用户的超类
 */
class User {
    private $userName = "";//用户名
    private $password = "";//密码
    private $type = "";//用户类型：0：个人用户（默认） 1：教练 2：医生 3：管理员
    private $telephone = "";// 联系电话
    private $email = "";//邮箱
    private $age = "";//年龄
    private $sex = "";//性别
    private $height = "";//身高
    private $weight = "";//体重
    private $lastLoadTime="";//最后一次登录时间

    /**
     * User constructor.
     * @param string $userName
     * @param string $password
     * @param int $type
     * @param string $telephone
     * @param string $email
     * @param string $age
     * @param string $sex
     * @param string $height
     * @param string $weight
     */
    public function __construct($userName, $age, $sex, $type, $password, $height, $weight, $email, $telephone) {
        $this->userName = $userName;
        $this->password = $password;
        $this->type = $type;
        $this->telephone = $telephone;
        $this->email = $email;
        $this->age = $age;
        $this->sex = $sex;
        $this->height = $height;
        $this->weight = $weight;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function setUserName($userName) {
        $this->userName = $userName;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getTelephone() {
        return $this->telephone;
    }

    public function setTelephone($telephone) {
        $this->telephone = $telephone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getAge() {
        return $this->age;
    }

    public function setAge($age) {
        $this->age = $age;
    }

    public function getSex() {
        return $this->sex;
    }

    public function setSex($sex) {
        $this->sex = $sex;
    }

    public function getHeight() {
        return $this->height;
    }

    public function setHeight($height) {
        $this->height = $height;
    }

    public function getWeight() {
        return $this->weight;
    }

    public function setWeight($weight) {
        $this->weight = $weight;
    }

    public function getLastLoadTime() {
        return $this->lastLoadTime;
    }

    public function setLastLoadTime($lastLoadTime) {
        $this->lastLoadTime = $lastLoadTime;
    }


}