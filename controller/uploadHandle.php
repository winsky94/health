<?php
/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/12/5
 * Description：
 */

require_once("../service/CToSql.php");
$action = $_POST["action"];

if ($action == "exportToSql") {
    //文件路径
    $file_path = "../uploads/files.txt";
    //判断是否有这个文件
    if (file_exists($file_path)) {
        $content = file($file_path);                 //得到数组
        $upload = new CToSql();
        foreach ($content as $fileName) {
            $fileName = trim($fileName);
            $arr = explode(".", $fileName);
            $type = $arr[3];
            if ($type == "xml") {
                $upload->xmlToSql($fileName);
            } else {
                $upload->excelToSql($fileName);
            }
            //删除上传的文件
            @unlink($fileName);

        }

        $fp = fopen($file_path, 'w');
        flock($fp, LOCK_EX);
        fwrite($fp, "");
        flock($fp, LOCK_UN);
        fclose($fp);
    }
}
