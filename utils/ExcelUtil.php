<?php

/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/11/30
 * Description：
 */
require_once "../utils/PHPExcel_1.8.0/Classes/PHPExcel.php";//修改为自己的目录

class ExcelUtil {

    /**
     * 读取excel文件内容
     * @param $file excel地址
     * @return array 二维数组
     */
    public static function getContents($file) {
        $content = array();

        $objReader = PHPExcel_IOFactory::createReaderForFile($file);
        $objPHPExcel = $objReader->load($file);
        $objWorksheet = $objPHPExcel->getActiveSheet();
        $head = true;

        foreach ($objWorksheet->getRowIterator() as $row) {
            if ($head) {
                $head = false;
                continue;
            }
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(false);

            $cellContent = array();
            foreach ($cellIterator as $cell) {
                array_push($cellContent, $cell->getValue());
            }
            array_push($content, $cellContent);
        }

        return $content;
    }

    /**
     * 将excel的时间转为正常的日期时间格式
     * @param $date 读取的时间
     * @param bool|false $time 是否要显示时间
     * @return string 正常的日期时间格式
     */
    public static function excelTime($date, $time = false) {
        $n = intval(($date - 25569) * 3600 * 24); //转换成1970年以来的秒数
        if ($time) {
            $result = gmdate('Y-m-d', $n);//格式化时间
        } else {
            $result = gmdate('Y-m-d H:i:s', $n);//格式化时间
        }
        return $result;
    }
}

//$file="../uploads/files/20151205/suggestion.xls ";
//$result = ExcelUtil::getContents($file);
//print_r($result);