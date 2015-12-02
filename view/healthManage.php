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
            width: 87px;
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

</head>
<body onload="write_header();write_footer()">
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
            <div style="display: inline-block;margin-left: 5px;">
                <div>
                    <script src="../js/dateButton.js"></script>
                    <input id="date" class="btn" type="button" onclick="HS_setDate(this)" value="今天">
                </div>

                <!--绘制目标完成百分比图-->
                <div style="margin-left: 50px; padding-top: 40px">
                    <div class="prg-cont rad-prg" id="indicatorContainer" style="display: inline;float: left"></div>
                    <script>
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

                        // 修改数字
                        var radialObj = $("#indicatorContainer").data("radialIndicator");
                        radialObj.animate(23);
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
                            <span class="f30 co6">0</span>公里
                        </li>
                        <li class="rp_contentBox co6 tc">
                            <span class="co8">运动时长</span>
                            <br/>
                            <span class="f30 co6">0</span>小时
                            <span class="f30 co6">0</span>分钟
                        </li>
                        <li class="rp_contentBoxL co6 tc">
                            <span class="co8">燃烧热量</span>
                            <br/>
                            <span class="f30 co6">0</span>大卡
                        </li>

                        <li class="rp_contentBoxLast co6 tc" style="padding-top:0;">
                            <span class="co8">运动步数</span>
                            <br/>
                            <span class="f30 co6">0</span>步
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
<script src="../js/jquery-2.1.1.min.js"></script>
<script src="../js/materialize.js"></script>
<script src="../js/cookie.js"></script>
<script src="../js/writeHTML.js"></script>
<script src="../js/xmlhttp.js"></script>
<script type="text/javascript" src="../js/LoginAjax.js"></script>

<script src="../js/ChangeUserInfoAjax.js"></script>
<script src="../js/ChangePWAjax.js"></script>
<script src="../js/materialize.js"></script>
<script src="../js/LoginAjax.js"></script>
<script src="../js/userAjax.js"></script>

<script type="text/javascript">
    // 根据左侧的导航栏点击刷新右侧界面
    function change(e) {
        if(e=="events"){
            window.location.href = "healthManage.php?userName=<?php echo $userName ?>";
        }else if(e=="body"){
            window.location.href = "bodyManage.php?userName=<?php echo $userName ?>";
        }else if(e=="upload"){
            window.location.href = "uploadSports.php?userName=<?php echo $userName ?>";
        }else if(e=="statics"){
            window.location.href = "staticsAnalysis.php?userName=<?php echo $userName ?>";
        }
    }
</script>

</body>
</html>