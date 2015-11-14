<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>我的建议</title>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
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
<body onload="write_header();write_footer();write_quick_back_button();" id="top">
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

        <!-- 中间建议 -->
        <div class="col s12 l8">
            <div>
                <input type="text" name="keyword" onkeydown='if(event.keyCode==13){search_function()}'>
                &nbsp;&nbsp; &nbsp;&nbsp;
                <a class="btn btn-primary" onclick="alert('监听监听')">搜索</a>

                <div>

                    <input class="with-gap" type="radio" name="type" id="uploader" value="uploader">
                    <label for="uploader">标题</label>
                    <input class="with-gap" type="radio" name="type" id="customName" value="customName"
                           checked="checked">
                    <label for="customName">内容</label>
                    <input class="with-gap" type="radio" name="type" id="tag" value="tag">
                    <label for="tag">全部</label>
                </div>
            </div>
            <br>
            <ul class="collection">
                <li class="collection-item avatar">
                    <img src="../images/back1.jpg" class="circle">
                    <span class="title" style="font-weight: bold;">标题：多跑步喔~</span>

                    <p>跑步有益于身心健康 <br>
                        珍爱生命，勤于跑步！
                    </p>
                </li>
                <li class="collection-item avatar">
                    <i class="mdi-file-folder circle"></i>
                    <span class="title">Title</span>

                    <p>First Line <br>
                        Second Line
                    </p>
                </li>
                <li class="collection-item avatar">
                    <i class="mdi-action-assessment circle green"></i>
                    <span class="title">Title</span>

                    <p>First Line <br>
                        Second Line
                    </p>
                </li>
                <li class="collection-item avatar">
                    <i class="mdi-av-play-arrow circle red"></i>
                    <span class="title">Title</span>

                    <p>First Line <br>
                        Second Line
                    </p>
                </li>
            </ul>

            <!-- 页数导航 -->
            <br>

            <div class="pagination" style="text-align: center">
            </div>
        </div>
        <!--中间建议结束-->


        <!--右侧快速返回顶部-->
        <div id="back-up"></div>
        <!--右侧快速返回顶部结束-->
    </div>
</div>


<div id="footer"></div>

<!--  javaScripts -->
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="../js/materialize.js"></script>
<script src="../js/cookie.js"></script>
<script src="../js/writeHTML.js"></script>
<script src="../js/xmlhttp.js"></script>
<script type="text/javascript" src="../js/LoginAjax.js"></script>
<script src="../js/jQuery.js"></script>
<script src="../js/ChangeUserInfoAjax.js"></script>
<script src="../js/ChangePWAjax.js"></script>
<script src="../js/materialize.js"></script>
<script src="../js/LoginAjax.js"></script>

<!--显示页码-->
<script>
    write_pagination(1, 10, 5, 5);
</script>

</body>
</html>