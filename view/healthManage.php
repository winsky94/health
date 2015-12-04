<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>我的运动</title>

    <!-- CSS  -->
    <link href="../css/material_icons.css" rel="stylesheet" media="screen,projection">
    <link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>

    <style type="text/css">
        .row {
            margin-left: 9%;
            margin-right: 9%;
        }

        .main {
            margin-top: 40px;
        }

        .steps_report_data {
            width: 468px;
            height: 60px;
            margin-top: 35px;
        }

        .steps_report_data li {
            float: left;
        }

        .steps_report_data .rp_contentBoxFirst {
            border-right: 1px solid #E9E9E9;
            height: 52px;
            width: 112px;
        }

        .steps_report_data .rp_contentBox {
            border-right: 1px solid #E9E9E9;
            width: 140px;
        }

        .steps_report_data .rp_contentBoxLast {
            height: 44px;
            width: 160px;
            padding-top: 8px;
        }

        .steps_report_data .rp_contentBoxL {
            height: 52px;
            width: 120px;
            border-right: 1px solid #E9E9E9;
        }

        .co6 {
            color: #666666;
        }

        .co8 {
            color: #999999;
        }

        .f30 {
            font-size: 30px;
        }

        .tl {
            text-align: left
        }

        .tc {
            text-align: center
        }

    </style>

    <script src="../js/healManageAjax.js"></script>

    <!-- 这个位置不能移到后面去，否则百分比的图在更新目标后画不出来 -->
    <script src="../js/jquery-2.1.1.min.js"></script>

</head>
<body onload="write_footer();initStaticsData();write_header();">
<header></header>
<?php
$userName = $_GET["userName"];
?>

<div class="main container">
    <div class="row">
        <!-- 左侧 3列-->
        <div class="col s12 l3">
            <div class="collection black-text">
                <a class="collection-item waves-effect waves-light" onclick="return change('events')">
                    <i class="small grey-text mdi-editor-insert-emoticon"></i>
                    我的运动
                </a>
                <a class="collection-item waves-effect waves-light" onclick="return change('body')">
                    <i class="small grey-text mdi-action-perm-contact-cal"></i>
                    身体管理
                </a>
                <a class="collection-item waves-effect waves-light" onclick="return change('upload')">
                    <i class="small grey-text mdi-file-file-upload"></i>
                    数据上传
                </a>
                <a class="collection-item waves-effect waves-light" onclick="return change('statics')">
                    <i class="small grey-text mdi-editor-functions"></i>
                    数据分析
                </a>
            </div>
        </div>
        <!-- 左侧 3列 结束-->


        <!-- 右侧 9列 -->
        <div class="col s12 l9" id="right-content">
            <script src="../js/jQuery.js"></script>
            <script src="../js/radialIndicator.js"></script>
            <div style="margin-left: 10px;">
                <table>
                    <?php
                    require_once("../service/healthService.php");
                    $service = new healthService();
                    $data = json_decode($service->getWeekGoal($userName));
                    $type = $data->goal_type;
                    $value = $data->value;
                    ?>
                    <td>
                        <span style="float: right">周目标：</span>
                    </td>
                    <td>
                        <select class="browser-default" id="type">
                            <?php
                            if ($type == "距离(公里)") {
                                ?>
                                <option value="距离(公里)" selected>距离(公里)</option>
                                <option value="时长(小时)">时长(小时)</option>
                                <option value="热量(卡路里)">热量(卡路里)</option>

                                <?php
                            } elseif ($type == "时长(小时)") {
                                ?>
                                <option value="距离(公里)">距离(公里)</option>
                                <option value="时长(小时)" selected>时长(小时)</option>
                                <option value="热量(卡路里)">热量(卡路里)</option>

                                <?php
                            } elseif ($type == "calories") {
                                ?>
                                <option value="距离(公里)">距离(公里)</option>
                                <option value="时长(小时)">时长(小时)</option>
                                <option value="热量(卡路里)" selected>热量(卡路里)</option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <input id="value" type="text" value="<?php echo $value; ?>" placeholder="<?php echo $value; ?>">
                    </td>
                    <td>
                        <button type="button" class="btn" onclick="setGoal();">保存</button>
                    </td>
                    <td>
                        <font color="red" size="3"><span id="result" style="margin-right: 50px;"></span></font>
                    </td>
                </table>
            </div>

            <div style="display: inline-block;margin-left: 5px;">
                <!--                <div>-->
                <!--                    <script src="../js/dateButton.js"></script>-->
                <!--                    <input id="date" class="btn" type="button" onclick="HS_setDate(this)" value="今天">-->
                <!--                </div>-->

                <!--绘制目标完成百分比图-->
                <?php
                require_once("../service/healthService.php");
                $service = new healthService();
                $data = $service->getStaticsPerWeek($userName);
                $meters_total = $data["meters_total"];
                $minutes_total_hour = $data["minutes_total_hour"];
                $minutes_total_minute = $data["minutes_total_minute"];
                $calories_total = $data["calories_total"];
                ?>
                <div style="margin-left: 50px; padding-top: 40px">
                    <div class="prg-cont rad-prg" id="indicatorContainer" style="display: inline;float: left"></div>
                    <script>
                        // 修改数字
                        $("#indicatorContainer").radialIndicator({
                            barColor: {
                                0: "#FF0000",
                                33: "#FFFF00",
                                66: "#0066FF",
                                100: "#33CC33"
                            },
                            barWidth: 10,
                            initValue: 0,
                            roundCorner: true,
                            percentage: true
                        });

                        var type = "<?php echo $type; ?>";
                        var goal_value =<?php echo $value;?>;
                        var true_value = -1;

                        if (type == "距离(公里)") {
                            true_value =<?php echo $meters_total;?>;
                        } else if (type == "时长(小时)") {
                            true_value =<?php echo ($minutes_total_hour+$minutes_total_minute/60);?>;
                        } else if (type == "热量(卡路里)") {
                            true_value =<?php echo $calories_total;?>;
                        }
                        updateRate(true_value, goal_value);


                    </script>
                    <p style="margin-left: 30px;font-weight: bold;" class="co8">目标完成</p>
                </div>
                <!--绘制目标完成百分比图 结束-->

            </div>


            <!--统计数据-->

            <div style="display:inline-block;margin-left: 50px;padding-bottom: 60px;">
                <div class="steps_report_data" style="float:left;">
                    <ul>
                        <li class="rp_contentBoxFirst co6 tc">
                            <span class="co8">运动距离</span>
                            <br/>
                            <span class="f30 co6" id="meters_total"><?php echo $meters_total ?></span>公里
                        </li>
                        <li class="rp_contentBox co6 tc">
                            <span class="co8">运动时长</span>
                            <br/>
                            <span class="f30 co6"
                                  id="minutes_total_hour"><?php echo $minutes_total_hour ?></span>小时
                            <span class="f30 co6"
                                  id="minutes_total_minute"><?php echo $minutes_total_minute ?></span>分钟
                        </li>
                        <li class="rp_contentBoxLast co6 tc" style="padding-top:0;">
                            <span class="co8">燃烧热量</span>
                            <br/>
                            <span class="f30 co6" id="calories_total"><?php echo $calories_total ?></span>大卡
                        </li>
                    </ul>
                </div>
            </div>
            <!--统计数据 结束-->

            <!--运动曲线图-->
            <div style="margin-top: 10px;margin-left: 5px;">
                <div id="main" style="height:400px"></div>
                <div>
                    <input type="hidden" id="userName" value="<?php echo $userName ?>">
                    <!--                    <input type="button" onclick="refresh(true)" value="刷新">-->
                    <!--                    <button type="button" class="btn btn-sm btn-success" onclick="refresh(true)">刷 新</button>-->
                </div>
                <script src="../eChart-2.2.7/build/dist/echarts.js"></script>
                <script src="../js/eChartsConfig.js"></script>
            </div>
            <!--运动曲线图 结束-->

        </div>
        <!-- 右侧 9列 结束 -->

    </div>
    <!--class row 结束-->

</div>
<!--class main container 结束-->

<div id="footer"></div>

<!--  javaScripts -->

<script src="../js/materialize.js"></script>
<script src="../js/cookie.js"></script>
<script src="../js/writeHTML.js"></script>
<script src="../js/xmlhttp.js"></script>
<script src="../js/LoginAjax.js"></script>

<script src="../js/ChangeUserInfoAjax.js"></script>
<script src="../js/ChangePWAjax.js"></script>
<script src="../js/materialize.js"></script>
<script src="../js/LoginAjax.js"></script>
<script src="../js/userAjax.js"></script>

<script type="text/javascript">
    // 根据左侧的导航栏点击刷新右侧界面
    function change(e) {
        if (e == "events") {
            window.location.href = "healthManage.php?userName=<?php echo $userName ?>";
        } else if (e == "body") {
            window.location.href = "bodyManage.php?userName=<?php echo $userName ?>";
        } else if (e == "upload") {
            window.location.href = "uploadSports.php?userName=<?php echo $userName ?>";
        } else if (e == "statics") {
            window.location.href = "staticsAnalysis.php?userName=<?php echo $userName ?>";
        }
    }


</script>

</body>
</html>