<?php
/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/12/2
 * Description：
 */

//$newObj = array("data1" => 6500, "data2" => 2000, "data3" => 3000, "data4" => 4000, "data5" => 5000, "data6" => 6000, "data7" => 7000);
//echo json_encode($newObj);

require_once("../service/healthService.php");


$date = $_POST["date"];
$userName = $_POST["userName"];

//$date="2015-12-02 11:11:11";
//$userName="winsky";

$service = new healthService();
$data = $service->getSportsData($userName, $date);

echo json_encode($data);


/**
 * @param $rule {0}米
 * @param $data 12
 * @return mixed|void 输出结果 12米
 */
function format($rule, $data) {
    $args = func_get_args();
    if (count($args) == 0) {
        return;
    }

    if (count($args) == 1) {
        return $args[0];
    }

    $str = array_shift($args);
    $str = preg_replace_callback('/\\{(0|[1-9]\\d*)\\}/', create_function('$match', '$args = ' . var_export($args, true) . '; return isset($args[$match[1]]) ? $args[$match[1]] : $match[0];'), $str);
    return $str;
}