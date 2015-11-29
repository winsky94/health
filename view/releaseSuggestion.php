<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>在线发布建议</title>

    <!-- CSS  -->
    <!--    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">-->
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

    </style>
</head>
<body onload="write_header();write_footer();">
<header></header>

<div class="container main row">
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
                $height = $user->getHeight()."cm";
                $weight = $user->getWeight()."kg";
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
        <div class="col s12l9">
            <div class="row">
                <div class="input-field col s12 m12 l12">
                    <div class="input-field col s6 ">
                        <input id="author" type="text" name="author" class="validate" value="捕风" disabled>
                        <label for="author">昵　称</label>
                    </div>

                    <div class="input-field col s6 ">
                        <input id="type" type="text" name="type" class="validate" value="医生" disabled>
                        <label for="type">角  色</label>
                    </div>
                </div>

                <div class="input-field col s12">
                    <div class="input-field col s6">
                        <input id="email" type="email" name="email" class="validate" value="1195413185@qq.com">
                        <label for="email">邮  箱</label>
                    </div>

                    <div class="input-field col s6">
                        <input id="phoneNumber" type="tel" name="phoneNumber" class="validate" value="18013878510">
                        <label for="phoneNumber">电  话</label>
                    </div>
                </div>

                <div class="input-field col s12">
                    <i class="mdi-editor-mode-edit prefix"></i>
                    <input id="title" type="text" length="10">
                    <label for="title">请输入标题...</label>
                </div>

                <div class="input-field col s12">
                    <i class="mdi-editor-mode-edit prefix"></i>
                    <textarea id="content" class="materialize-textarea" length="100"></textarea>
                    <label for="content">请输入您的建议...</label>
                </div>


            </div>

            <div class="table-container col s12">
                <div class="row-container">
                    <div class="input-field cell">
                        <a class="btn btn-primary" style="margin-left: 30px;"
                           onclick="verify_releaseSuggestions()">发布</a>
                        <font color="red" size="3"><span id="result" style="margin-left: 100px;"></span></font>
                    </div>

                </div>

            </div>
            <div class="col s12 m4 l2"></div>
        </div>
    </div>
</div>

<div id="footer"></div>


<!--  javaScripts -->
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<!--注销是为了使用字符计数功能-->
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
<script src="../js/userAjax.js"></script>

<script src="../js/releaseSuggestionsAjax.js"></script>

</body>
</html>