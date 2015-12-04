<?php
/**
 * Created with PhpStorm.
 * User: $严顺宽
 * Date: 2015/12/2
 * Description：
 */

require_once("../service/healthService.php");

$service = new HealthService();
$action = $_POST["action"];

if ($action == "detailStatics") {
    $date = $_POST["date"];
    $userName = $_POST["userName"];

    $data = $service->getSportsData($userName, $date);

    echo json_encode($data);
} elseif ($action == "totalStatics") {
    $userName = $_POST["userName"];
    echo json_encode($service->getStaticsPerWeek($userName));
} elseif ($action == "setWeekGoal") {
    $type = $_POST["type"];
    $value = $_POST["value"];
    $userName = $_POST["userName"];

    if ($value == "") {
        $message = "<message>请输入目标值</message>";
    } else {
        $result = $service->setWeekGoal($userName, $type, $value);
        if ($result) {
            $message = "<message>success</message>";
        } else {
            $message = "<message>修改失败</message>";
        }
    }

    echo $message;
} elseif ($action == "updateBody") {
    $userName = $_POST["userName"];
    $height = $_POST["height"];
    $weight = $_POST["weight"];
    $weightGoal = $_POST["weightGoal"];
    $heart = $_POST["heart"];
    $blood = $_POST["blood"];

    if ($height == "") {
        $message = "<message>请输入身高</message>";
    } elseif ($weight == "") {
        $message = "<message>请输入体重</message>";
    } elseif ($weightGoal == "") {
        $message = "<message>请输入目标体重</message>";
    } elseif ($heart == "") {
        $message = "<message>请输入心率</message>";
    } elseif ($blood == "") {
        $message = "<message>请输入血压</message>";
    } else {
        $result = $service->setUserBodyData($userName, $height, $weight, $weightGoal, $heart, $blood);
        if ($result) {
            $message = "<message>success</message>";
        } else {
            $message = "<message>修改失败</message>";
        }
    }

    echo $message;

} elseif ($action == "getSleepData") {
    $userName = $_POST["userName"];
    $day = $_POST["date"];
    $data_json = $service->getSleepDataByDay($userName, $day);

    echo $data_json;
}


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