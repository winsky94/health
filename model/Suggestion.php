<?php

/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/11/28
 * Description：
 */
class Suggestion {
    private $title;//标题
    private $content;//内容
    private $author;//发布者
    private $type;//角色
    private $email;//邮箱
    private $telephone;//联系电话
    private $time;//发布时间
    private $goalUser;//目标客户

    public function __construct($title, $content, $author, $type, $email, $telephone, $goalUser) {
        $this->title = $title;
        $this->content = $content;
        $this->author = $author;
        $this->type = $type;
        $this->email = $email;
        $this->telephone = $telephone;
        $this->goalUser = $goalUser;
    }

    public function getTime() {
        return $this->time;
    }

    public function setTime($time) {
        $this->time = $time;
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

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getGoalUser() {
        return $this->goalUser;
    }

    public function setGoalUser($goalUser) {
        $this->time = $goalUser;
    }
}