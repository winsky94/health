<?php
/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/12/5
 * Description：
 */
require_once("../utils/ExcelUtil.php");
require_once("../service/SuggestionService.php");
//文件路径
$file_path = "../uploads/files.txt";
//判断是否有这个文件
if (file_exists($file_path)) {
    $content = file($file_path);                 //得到数组
    $upload = new q();
    foreach ($content as $fileName) {
        $fileName = trim($fileName);
        $arr = explode(".", $fileName);
        $type = $arr[3];
        echo $fileName;
        if (file_exists($fileName)) {
            if ($type == "xml") {
                $upload->xmlToSql($fileName);
            } else {
                $upload->excelToSql($fileName);
            }
        } else {
            echo "文件不存在";
        }
        //删除上传的文件
//        @unlink($fileName);

    }

//    $fp = fopen($file_path, 'w');
//    flock($fp, LOCK_EX);
//    fwrite($fp, "");
//    flock($fp, LOCK_UN);
//    fclose($fp);

} else {
    echo "没有这个文件";
}

class q {
    public function excelToSql($file) {
        $result = ExcelUtil::getContents($file);
        $this->toSql($result, false);
    }

    public function xmlToSql($file) {
        if (strpos($file, "suggestion")) {
            $data = $this->suggestionXml($file);
            $this->toSql($data, true);
        } elseif (strpos($file, "sport")) {
            $this->sportXmlToSql($file);
        } elseif (strpos($file, "sleep")) {
            $this->sleepXmlToSql($file);
        }


    }

    /**
     * 处理建议的xml文件
     * @param $file
     * @return array
     */
    private function suggestionXml($file) {
        $doc = new DOMDocument();
        $doc->load($file); //读取xml文件
        $suggestions = $doc->getElementsByTagName("suggestion"); //取得humans标签的对象数组

        $data = array();
        foreach ($suggestions as $suggestion) {
            $titles = $suggestion->getElementsByTagName("title");
            $title = $titles->item(0)->nodeValue;

            $contents = $suggestion->getElementsByTagName("content");
            $content = $contents->item(0)->nodeValue;

            $authors = $suggestion->getElementsByTagName("author");
            $author = $authors->item(0)->nodeValue;

            $types = $suggestion->getElementsByTagName("type");
            $type = $types->item(0)->nodeValue;

            $emails = $suggestion->getElementsByTagName("email");
            $email = $emails->item(0)->nodeValue;

            $telephones = $suggestion->getElementsByTagName("telephone");
            $telephone = $telephones->item(0)->nodeValue;

            $times = $suggestion->getElementsByTagName("time");
            $time = $times->item(0)->nodeValue;

            $row = array();
            array_push($row, $title);
            array_push($row, $content);
            array_push($row, $author);
            array_push($row, $type);
            array_push($row, $email);
            array_push($row, $telephone);
            if ($time != null || $time != "") {
                array_push($row, $time);
            }
            array_push($data, $row);
        }

        return $data;
    }

    /**
     *处理运动的xml文件
     * @param $file
     * @return array
     */
    private function sportXmlToSql($file) {
        $doc = new DOMDocument();
        $doc->load($file); //读取xml文件
        $sports = $doc->getElementsByTagName("data"); //取得humans标签的对象数组
        $service = new HealthService();

        $data = array();
        foreach ($sports as $sport) {
            $row = array();
            $userNames = $sport->getElementsByTagName("userName");
            $userName = $userNames->item(0)->nodeValue;

            $dates = $sport->getElementsByTagName("date");
            $date = $dates->item(0)->nodeValue;

            $meter = $sport->getElementsByTagName("meters");
            $meters = $meter->item(0)->nodeValue;

            $minute = $sport->getElementsByTagName("minute");
            $minutes = $minute->item(0)->nodeValue;

            $speeds = $sport->getElementsByTagName("speed");
            $speed = $speeds->item(0)->nodeValue;

            $caloriesS = $sport->getElementsByTagName("calories");
            $calories = $caloriesS->item(0)->nodeValue;

            array_push($row, $userName);
            array_push($row, $date);
            array_push($row, $meters);
            array_push($row, $minutes);
            array_push($row, $speed);
            array_push($row, $calories);

            array_push($data, $row);
        }

        $service->setUserSportData($data);

    }

    /**
     *处理睡眠的xml文件
     * @param $file
     * @return array
     */
    private function sleepXmlToSql($file) {
        $doc = new DOMDocument();
        $doc->load($file); //读取xml文件
        $sleeps = $doc->getElementsByTagName("data"); //取得humans标签的对象数组

        $service = new HealthService();
        $data = array();
        foreach ($sleeps as $sleep) {
            $row = array();

            $userNames = $sleep->getElementsByTagName("userName");
            $userName = $userNames->item(0)->nodeValue;

            $startTimes = $sleep->getElementsByTagName("startTime");
            $startTime = $startTimes->item(0)->nodeValue;

            $endTimes = $sleep->getElementsByTagName("endTime");
            $endTime = $endTimes->item(0)->nodeValue;

            $dsNums = $sleep->getElementsByTagName("dsNum");
            $dsNum = $dsNums->item(0)->nodeValue;

            $lsNums = $sleep->getElementsByTagName("lsNum");
            $lsNum = $lsNums->item(0)->nodeValue;

            $wakeNums = $sleep->getElementsByTagName("wakeNum");
            $wakeNum = $wakeNums->item(0)->nodeValue;

            $wakeTimes = $sleep->getElementsByTagName("wakeTimes");
            $wakeTime = $wakeTimes->item(0)->nodeValue;

            $scores = $sleep->getElementsByTagName("score");
            $score = $scores->item(0)->nodeValue;

            array_push($row, $userName);
            array_push($row, $startTime);
            array_push($row, $endTime);
            array_push($row, $dsNum);
            array_push($row, $lsNum);
            array_push($row, $wakeNum);
            array_push($row, $wakeTime);
            array_push($row, $score);

            array_push($data, $row);
        }

        $service->setSleepData($data);

    }

    private function toSql($data, $xml) {
        $service = new SuggestionService();
        foreach ($data as $row) {
            $title = $row[0];
            $content = $row[1];
            $author = $row[2];
            $type = $row[3];
            $email = $row[4];
            $telephone = $row[5];
            $suggestion = new Suggestion($title, $content, $author, $type, $email, $telephone);
            if (sizeof($row) > 6) {
                if ($xml) {
                    $time = $row[6];
                } else {
                    $time = ExcelUtil::excelTime($row[6]);
                }

                $suggestion->setTime($time);
            }
            $result = $service->insert($suggestion);
        }
    }
}