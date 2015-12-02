<?php

/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/12/2
 * Description：
 */
class DataCreator {
    public static function createSportData() {
        $dom = new DomDocument('1.0', 'utf-8');
        //  创建根节点
        $dom->formatOutput = true;
        $rootElement = $dom->createElement('sportsData');
        $dom->appendchild($rootElement);
        for ($i = 0; $i < 5000; $i++) {
            $item = $dom->createElement('data');
            $rootElement->appendchild($item);

            //  创建属性节点
            $ID = $dom->createAttribute("id");
            $item->appendchild($ID);
            // 创建属性值节点
            $val = $dom->createTextNode(($i + 1));
            $ID->appendChild($val);

            $userNameElement = $dom->createElement("userName", "winsky");
            $item->appendChild($userNameElement);

            $date = date('Y-m-d', strtotime('-' . $i . ' day'));
            $time = rand(6, 18) . ":" . rand(0, 60) . ":" . rand(0, 60);
            $date = $date . " " . $time;
            $dateElement = $dom->createElement("date", $date);
            $item->appendChild($dateElement);

            $meter = rand(0, 5) . "." . rand(0, 100);
            $meterElement = $dom->createElement("meters", $meter);
            $item->appendChild($meterElement);

            $minute = rand(0, 20) . "." . rand(0, 100);
            $minuteElement = $dom->createElement("minute", $minute);
            $item->appendChild($minuteElement);

            $speed = rand(10, 15) . "." . rand(0, 100);
            $speedElement = $dom->createElement("speed", $speed);
            $item->appendChild($speedElement);

            $calories = rand(0, 300) . "." . rand(0, 100);
            $caloriesElement = $dom->createElement("calories", $calories);
            $item->appendChild($caloriesElement);

            echo "正在创建第" . ($i + 1) . "条记录<br>";
        }
        $dom->save("data_sport.xml");

    }


    public static function createSleepData() {
        $dom = new DomDocument('1.0', 'utf-8');
        //  创建根节点
        $dom->formatOutput = true;
        $rootElement = $dom->createElement('sportsData');
        $dom->appendchild($rootElement);
        for ($i = 0; $i < 5000; $i++) {
            $item = $dom->createElement('data');
            $rootElement->appendchild($item);

            //  创建属性节点
            $ID = $dom->createAttribute("id");
            $item->appendchild($ID);
            // 创建属性值节点
            $val = $dom->createTextNode(($i + 1));
            $ID->appendChild($val);

            $userNameElement = $dom->createElement("userName", "winsky");
            $item->appendChild($userNameElement);

            $startDate = date('Y-m-d', strtotime('-' . $i . ' day'));
            $time = rand(21, 24) . ":" . rand(0, 60) . ":" . rand(0, 60);
            $startTime = $startDate . " " . $time;
            $startTimeElement = $dom->createElement("startTime", $startTime);
            $item->appendChild($startTimeElement);

            $endDate = date('Y-m-d', strtotime('-' . ($i - 1) . ' day'));
            $time = rand(5, 9) . ":" . rand(0, 60) . ":" . rand(0, 60);
            $endTime = $endDate . " " . $time;
            $endTimeElement = $dom->createElement("endTime", $endTime);
            $item->appendChild($endTimeElement);

            $dsNum = rand(0, 200);
            $dsNumElement = $dom->createElement("dsNum", $dsNum);
            $item->appendChild($dsNumElement);

            $lsNum = rand(300, 500);
            $lsNumElement = $dom->createElement("lsNum", $lsNum);
            $item->appendChild($lsNumElement);

            $wakeNum = rand(0, 10);
            $wakeNumElement = $dom->createElement("wakeNum", $wakeNum);
            $item->appendChild($wakeNumElement);

            $wakeTimes = $wakeNum * rand(1, 10);
            $wakeTimesElement = $dom->createElement("wakeTimes", $wakeTimes);
            $item->appendChild($wakeTimesElement);

            $score = rand(0, 9) . "." . rand(0, 9);
            $scoreElement = $dom->createElement("score", $score);
            $item->appendChild($scoreElement);

            echo "正在创建第" . ($i + 1) . "条记录<br>";
        }
        $dom->save("data_sleep.xml");
    }
}

//DataCreator::createSportData();
//echo "<br>";
//DataCreator::createSleepData();
