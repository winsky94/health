<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>修改活动</title>

    <!-- CSS  -->
    <link href="../css/material_icons.css" rel="stylesheet" media="screen,projection">
    <link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/showEvents.css" type="text/css" rel="stylesheet" media="screen,projection"/>


</head>
<body onload="write_header();write_footer();" id="top">
<header></header>

<div class="main container">
    <div class="row">
        <!-- 左侧 用户信息 3列-->
        <div class="col s12 l3">
            <ul class="collection with-header">
                <li class="collection-header">
                    <img src="../images/back1.jpg" width="150px" height="150px">
                    <?php
                    $userName = $_GET["userName"];
                    require_once("../service/UserService.php");
                    $userService = new UserService();
                    $user = $userService->getUserByName($userName);
                    $lastLoadTime = $user->getLastLoadTime();
                    $height = $user->getHeight() . "cm";
                    $weight = $user->getWeight() . "kg";
                    $age = $user->getAge();
                    $sex = $user->getSex();
                    $telephone = $user->getTelephone();
                    $email = $user->getEmail();
                    ?>
                    <h5 id="userName"><?php echo $userName; ?></h5>
                </li>
                <p class="collection-item">最近登录时间：<br> &nbsp;&nbsp;&nbsp;&nbsp; <?php echo $lastLoadTime ?></p>

                <p class="collection-item">身高：<?php echo $height ?></p>

                <p class="collection-item">体重：<?php echo $weight ?></p>

                <p class="collection-item">年龄：<?php echo $age ?></p>

                <p class="collection-item">性别：<?php echo $sex ?></p>

                <p class="collection-item">电话：<?php echo $telephone ?></p>

                <p class="collection-item">邮箱： <br> &nbsp; <?php echo $email ?></p>
            </ul>
        </div>
        <!-- 左侧 3列 结束-->

        <!-- 中间 9列 -->
        <div class="col s12 l9">

            <div class="col s12">
                <h4 style="font-family: '楷体';margin-left: 30px;">
                    发布活动
                </h4>
            </div>
            <?php
            $title = $_GET["title"];

            require_once("../service/EventsService.php");
            $eventService = new EventsService();
            $event = $eventService->getEventsByTitle($title)[0];
            $name = $event->getName();
            $introduction = $event->getIntroduction();
            $startDate = $event->getStartDate();
            $endDate = $event->getEndDate();
            $detail = $event->getDetail();
            ?>
            <div class="row" style="margin-left: 30px;">
                <div class="input-field col s12 m12 l12">
                    <div class="input-field col s6">
                        <input id="name" type="text" name="name" class="validate" value="<?php echo $name; ?>" disabled>
                        <label for="name">活动名称</label>
                    </div>
                </div>

                <div class="input-field col s12">
                    <div class="input-field col s6">
                        <input id="introduction" type="text" name="introduction" class="validate" length="10"
                               value="<?php echo $introduction; ?>">
                        <label for="introduction">活动简介</label>
                    </div>
                </div>

                <div class="input-field col s12">
                    <div class="input-field col s3">
                        <label for="startDate">开始日期</label>
                        <input id="startDate" type="date" class="datePicker" value="<?php echo $startDate; ?>">
                    </div>


                    <div class="input-field col s3">
                        <label for="endDate">结束日期</label>
                        <input id="endDate" type="date" class="datePicker" value="<?php echo $endDate; ?>">
                    </div>
                </div>

                <div class="input-field col s6">
                    <textarea id="detail" class="materialize-textarea"><?php echo $detail; ?></textarea>
                    <label for="detail">活动详情</label>
                </div>

            </div>

            <div class="col s12">
                <div class="row-container">
                    <div class="input-field cell">
                        <a class="btn btn-primary" style="margin-left: 30px;" onclick="verify_updateEvents()">修改</a>
                        <font color="red" size="3"><span id="result" style="margin-left: 100px;"></span></font>
                    </div>

                </div>

            </div>
            <div class="col s12 m4 l2"></div>
        </div>
        <!-- 中间 9列 -->

    </div>
</div>

<div id="footer"></div>

<!--  javaScripts -->

<!--<script src="../js/materialize.js"></script>-->
<script src="../js/cookie.js"></script>
<script src="../js/writeHTML.js"></script>
<script src="../js/xmlhttp.js"></script>
<script type="text/javascript" src="../js/LoginAjax.js"></script>
<script src="../js/jQuery.js"></script>
<script src="../js/ChangeUserInfoAjax.js"></script>
<script src="../js/ChangePWAjax.js"></script>
<script src="../js/materialize.js"></script>
<script src="../js/LoginAjax.js"></script>
<script src="../js/releaseEventsAjax.js"></script>

<script type="text/javascript">
    $(function () {
        $('.datePicker').pickadate({
            selectMonths: true, // Creates a dropdown to control month
            selectYears: 15, // Creates a dropdown of 15 years to control year
            format: 'yyyy-mm-dd ',
        });
    });

</script>

</body>

</html>