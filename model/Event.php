<?php

/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/11/8
 * Description：
 */
class Event {
    private $name = "";//活动名称
    private $introduction = "";//活动简介
    private $startDate = "";//开始日期
    private $endDate = "";//结束日期
    private $detail = "";//活动详情
    private $state = "";//活动状态：已结束——进行中
    private $peopleNum;//参与人数

    /**
     * Event constructor.
     * @param string $name
     * @param string $introduction
     * @param string $startDate
     * @param string $endDate
     * @param string $detail
     * @param $peopleNum
     */
    public function __construct($name, $introduction, $startDate, $endDate, $detail, $peopleNum) {
        $this->name = $name;
        $this->introduction = $introduction;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->detail = $detail;
        $this->peopleNum = $peopleNum;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getIntroduction() {
        return $this->introduction;
    }

    public function setIntroduction($introduction) {
        $this->introduction = $introduction;
    }

    public function getStartDate() {
        return $this->startDate;
    }

    public function setStartDate($startDate) {
        $this->startDate = $startDate;
    }

    public function getEndDate() {
        return $this->endDate;
    }

    public function setEndDate($endDate) {
        $this->endDate = $endDate;
    }

    public function getDetail() {
        return $this->detail;
    }

    public function setDetail($detail) {
        $this->detail = $detail;
    }

    public function getState() {
        return $this->state;
    }

    public function setState($state) {
        $this->state = $state;
    }

    public function getPeopleNum() {
        return $this->peopleNum;
    }

    public function setPeopleNum($peopleNum) {
        $this->peopleNum = $peopleNum;
    }

}