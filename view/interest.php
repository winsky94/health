<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>兴趣组</title>

    <!-- CSS  -->
    <link href="../css/material_icons.css" rel="stylesheet" media="screen,projection">
    <link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/showEvents.css" type="text/css" rel="stylesheet" media="screen,projection"/>

    <style type="text/css">
        input {
            max-width: 80%;
        }

        .btn {
            max-width: 30%;
        }

        .row {
            margin-left: 9%;
            margin-right: 9%;
        }

        label {
            margin: 5px;
        }
    </style>

</head>
<body onload="write_header();write_footer();" id="top">
<header></header>

<div class="main container">
    <br>

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

        <!-- 中间建议 -->
        <div class="col s12 l9 row">
            <!-- 发布帖子 -->
            <div class="grey">
                <div class="input-field col s12 l6">
                    <i class="mdi-editor-mode-edit prefix"></i>
                    <textarea id="content" class="materialize-textarea" length="140"></textarea>
                    <label for="content">发布兴趣贴...</label>
                </div>

                <div class="table-container col s12 l6 center">
                    <div class="row-container">
                        <div class="input-field cell">
                            <button class="btn btn-primary" onclick="alert('监听')">发布</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 发布帖子结束-->

            <!-- 展示帖子-->
            <div>
                <!--动态内容-->
                <div class="card-panel grey lighten-5 z-depth-1" style="margin-top:150px; ">
                    <div class="row">
                        <div class="col s2 left-align">
                            <img src="../images/back2.jpg" width="80" height="80" alt="" style="border-radius: 50%">
                        </div>
                        <div class="col s10">
                            <div class="section green-text" style="font-weight: 800;font-size: 18px">
                                winsky
                            </div>
                        <span>
                            这里是动态的正文；这里是动态的正文；这里是动态的正文；这里是动态的正文；这里是动态的正文；这里是动态的正文；这里是动态的正文；这里是动态的正文；这里是动态的正文；
                        </span><br>
                        <span>
                            <img src="../images/back1.jpg " width="100px" height="100px">
                        </span><br>
                        <span class="left green-text">
                            2015-10-20 21:32:20
                        </span>
                        <span class="right green-text">
                            评论(0) 赞(0)
                        </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- 展示帖子结束-->
        </div>
        <!--中间建议结束-->

    </div>
</div>


<div id="footer"></div>

<!--  javaScripts -->
<script src="../js/jquery-2.1.1.min.js"></script>
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

</body>
</html>