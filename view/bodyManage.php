<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>身体管理</title>

    <!-- CSS  -->
    <link href="../css/material_icons.css" rel="stylesheet" media="screen,projection">
    <link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>

    <style type="text/css">
        .row {
            margin-left: 14%;
            margin-right: 14%;
        }

        .main {
            margin-top: 40px;
        }

        .table-container {
            display: table;
            border-spacing: 10px;
        }

        .row-container {
            display: table-row;

        }

        .cell {
            display: table-cell;
        }

    </style>

</head>
<body onload="write_header();write_footer()">
<header></header>
<?php
$userName = $_GET["userName"];
?>

<input type="hidden" id="userName" value="<?php echo $userName ?>">

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
                <a class="collection-item waves-effect waves-light" onclick="return change('sleep')">
                    <i class="small grey-text mdi-editor-functions"></i>
                    睡眠分析
                </a>
                <a class="collection-item waves-effect waves-light" onclick="return change('upload')">
                    <i class="small grey-text mdi-file-file-upload"></i>
                    数据上传
                </a>
            </div>

            <div class="collection black-text">
                <a class="collection-item waves-effect waves-light">
                    <i class="small grey-text mdi-editor-insert-emoticon"></i>
                    周运动总量好友排名
                </a>
                <a class="collection-item waves-effect waves-light center">
                    第<span class="red-text" style="font-size: 36px;font-weight: bold;">
                        <?php
                        require_once("../service/HealthService.php");
                        $healthService = new HealthService();
                        $rank = $healthService->getRank($userName);
                        echo $rank;
                        ?>
                    </span>名
                </a>
            </div>
        </div>
        <!-- 左侧 3列 结束-->


        <!-- 右侧 9列 -->
        <div class="col s12 l9" id="right-content">
            <!-- 身体基本数据 -->
            <?php
            require_once("../service/healthService.php");
            $healthService = new HealthService();
            $data = $healthService->getUserBodyData($userName, 1);
            $height = $data[0]["height"];
            $weight = $data[0]["weight"];
            $weightGoal = $data[0]["weightGoal"];
            $heart = $data[0]["heart"];
            $blood = $data[0]["blood"];

            ?>
            <div class="card grey lighten-4">
                <h5 style="margin-left: 20px;font-weight: 100;font-family: '微软雅黑';color:#545454;">基本数据</h5>

                <div class="input-field col s12">
                    <div class="input-field col s4 l2">
                        <input id="height" type="text" name="height" value="<?php echo $height; ?>">
                        <label for="height" class="active">身　高：</label>
                    </div>

                    <div class="input-field col s4 l2">
                        <input id="weight" type="text" name="weight" value="<?php echo $weight; ?>">
                        <label for="weight" class="active">体　重：</label>
                    </div>

                    <div class="input-field col s4 l2">
                        <input id="weightGoal" type="text" name="weightGoal" value="<?php echo $weightGoal; ?>">
                        <label for="weightGoal" class="active">目标体重：</label>
                    </div>

                    <div class="input-field col s4 l2">
                        <input id="heart" type="text" name="heart" value="<?php echo $heart; ?>">
                        <label for="heart" class="active">心　率：</label>
                    </div>

                    <div class="input-field col s4 l2">
                        <input id="blood" type="text" name="blood" class="validate" value="<?php echo $blood; ?>">
                        <label for="blood" class="active">血　压：</label>
                    </div>

                    <div class="col s8 table-container">
                        <div class="row-container">
                            <div class="input-field cell">
                                <input type="submit" value="保存" onclick="updateBody();" class="btn btn-primary">
                            </div>
                            <div class="input-field cell">
                                <font color="red" size="3"><span id="result" style="margin-left: 100px;"></span></font>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="color:#545454;font-size: 18px;padding-left: 20px;float: left">
                    你的理想体重<span style="font-size: 36px;font-weight: bold;"
                                id="idealWeight"><?php echo round(21.2 * $height * $height / 10000, 1); ?></span>公斤...干巴爹~~~
                </div>
            </div>
            <!-- 身体基本数据 结束-->

            <!-- 体重变化表-->
            <div class="card grey lighten-4">
                <table class="striped centered responsive-table display" id="example">
                    <thead>
                    <tr>
                        <th data-field="date">日　期</th>
                        <th data-field="weight">体　重(kg)</th>
                        <th data-field="gap">距离目标体重差(kg)</th>
                        <th data-field="idealGap">距离理想体重差(kg)</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php
                    $bodyData = $healthService->getUserBodyData($userName, 5);

                    foreach ($bodyData as $row) {
                        $date = $row["upLoadTime"];
                        $weight = $row["weight"];
                        $weightGoal = $row["weightGoal"];
                        $gap = $weight - $weightGoal;

                        $height = $row["height"];
                        $idealGap = round($weight - 21.2 * $height * $height / 10000, 1);
                        ?>

                        <tr>
                            <td><?php echo $date; ?></td>
                            <td><?php echo $weight; ?></td>
                            <td><?php echo $gap; ?></td>
                            <td><?php echo $idealGap; ?></td>
                        </tr>

                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <!-- 体重变化表结束 -->

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
<script src="../js/bodyManageAjax.js"></script>

<script type="text/javascript">
    // 根据左侧的导航栏点击刷新右侧界面
    function change(e) {
        if (e == "events") {
            window.location.href = "healthManage.php?userName=<?php echo $userName ?>";
        } else if (e == "body") {
            window.location.href = "bodyManage.php?userName=<?php echo $userName ?>";
        } else if (e == "upload") {
            window.location.href = "uploadSports.php?userName=<?php echo $userName ?>";
        } else if (e == "sleep") {
            window.location.href = "sleepManage.php?userName=<?php echo $userName ?>";
        }
    }
</script>

</body>
</html>