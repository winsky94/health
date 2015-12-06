<?php

/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/12/6
 * Description：
 */
class Interest {
    private $userName;//发布者
    private $content;//内容
    private $time;//发布时间

    public function __construct($userName, $content, $time) {
        $this->userName = $userName;
        $this->content = $content;
        $this->time = $time;
    }

    public function getUserName() {
        return $this->userName;
    }

    public function setUserName($userName) {
        $this->userName = $userName;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getTime() {
        return $this->time;
    }

    public function setTime($time) {
        $this->time = $time;
    }


}