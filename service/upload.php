<?php

require_once("../utils/ExcelUtil.php");
require_once("../model/Suggestion.php");
require_once("../service/SuggestionService.php");

$action = $_GET['action'];
$actions = array('tk', 'up', 'fd');
//判断是否正确的请求
if (!in_array($action, $actions)) {
    //错误
    exit;
}

$upload = new upload();
$upload->$action();

/**
 * 上传类
 */
class upload {
    private $_tokenPath = '../uploads/tokens/';            //令牌保存目录
    private $_filePath = '../uploads/files/';              //上传文件保存目录

    /**
     * 获取令牌
     */
    public function tk() {

        $file['name'] = $_GET['name'];                  //上传文件名称
        $file['size'] = $_GET['size'];                  //上传文件总大小
        $file['token'] = md5(json_encode($file['name'] . $file['size']));
        //判断是否存在该令牌信息
        if (!file_exists($this->_tokenPath . $file['token'] . '.token')) {

            $file['up_size'] = 0;                       //已上传文件大小
            $pathInfo = pathinfo($file['name']);
            $path = $this->_filePath . date('Ymd') . '/';
            //生成文件保存子目录
            if (!is_dir($path)) {
                mkdir($path, 0700);
            }
            //上传文件保存目录
            $file['filePath'] = $path . $file['name'];//. '.' . $pathInfo['extension'];
            $file['modified'] = $_GET['modified'];      //上传文件的修改日期
            //保存令牌信息
            $this->setTokenInfo($file['token'], $file);
        }
        $result['token'] = $file['token'];
        $result['success'] = true;
        //$result['server'] = '';

        echo json_encode($result);
        exit;
    }


    /**
     * 上传接口
     */
    public function up() {
        if ('html5' == $_GET['client']) {
            $this->html5Upload();
            error_log("up" . "\r\n", 3, "../log.txt");
        } elseif ('form' == $_GET['client']) {
            $this->flashUpload();
        } else {
            //错误
            exit;
        }

    }

    /**
     * HTML5上传
     */
    protected function html5Upload() {
        $token = $_GET['token'];
        $fileInfo = $this->getTokenInfo($token);

        if ($fileInfo['size'] > $fileInfo['up_size']) {
            //取得上传内容
            $data = file_get_contents('php://input', 'r');
            if (!empty($data)) {
                //上传内容写入目标文件
                $file_name = iconv("utf-8", "gb2312", $fileInfo['filePath']);   //解决中文乱码问题
                $fp = fopen($file_name, 'a');
                flock($fp, LOCK_EX);
                fwrite($fp, $data);
                flock($fp, LOCK_UN);
                fclose($fp);
                //累积增加已上传文件大小
                $fileInfo['up_size'] += strlen($data);
                if ($fileInfo['size'] > $fileInfo['up_size']) {
                    $this->setTokenInfo($token, $fileInfo);
                } else {
                    //上传完成后删除令牌信息
                    @unlink($this->_tokenPath . $token . '.token');

                    //======================================
                    $path = $fileInfo['filePath'];
                    $arr = explode(".", $path);
                    $type = $arr[3];
                    if ($type == "xml") {
                        $this->xmlToSql($file_name);
                    } else {
                        $this->excelToSql($file_name);
                    }

                    //======================================
                }
            }
        }
        $result['start'] = $fileInfo['up_size'];
        $result['success'] = true;

        echo json_encode($result);
        exit;
    }

    /**
     * FLASH上传
     */
    public function flashUpload() {

        //$result['start'] = $fileInfo['up_size'];
        $result['success'] = false;

        echo json_encode($result);
        exit;
    }

    /**
     * 生成文件内容
     */
    protected function setTokenInfo($token, $data) {
        file_put_contents($this->_tokenPath . $token . '.token', json_encode($data));
    }

    /**
     * 获取文件内容
     */
    protected function getTokenInfo($token) {
        $file = $this->_tokenPath . $token . '.token';
        if (file_exists($file)) {
            return json_decode(file_get_contents($file), true);
        }
        return false;
    }

    private function excelToSql($file) {
        error_log($file . "\r\n", 3, "../log.txt");
        $result = ExcelUtil::getContents($file);
        $this->toSql($result);
    }

    private function xmlToSql($file) {
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

        $this->toSql($data, true);
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
            error_log(sizeof($row) . "\r\n", 3, "../log.txt");
            if (sizeof($row) > 6) {
                error_log("1" . "\r\n", 3, "../log.txt");
                error_log($row[6] . "\r\n", 3, "../log.txt");
                if ($xml) {
                    $time = $row[6];
                } else {
                    $time = ExcelUtil::excelTime($row[6]);
                }

                error_log("2" . "\r\n", 3, "../log.txt");
                $suggestion->setTime($time);
                error_log("3" . "\r\n", 3, "../log.txt");
            }
            error_log("4" . "\r\n", 3, "../log.txt");
            $result = $service->insert($suggestion);
            error_log($result . "\r\n", 3, "../log.txt");
        }

        error_log("出去" . "\r\n", 3, "../log.txt");
    }


}//endclass