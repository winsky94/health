<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>查看全部用户</title>

    <!-- CSS  -->
    <link href="../css/material_icons.css" rel="stylesheet" media="screen,projection">
    <link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/showEvents.css" type="text/css" rel="stylesheet" media="screen,projection"/>

</head>
<body onload="write_header();write_footer();">
<header></header>
<?php
$userLogIn = $_GET["userName"];
?>
<div class="main container row">
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
        <div style="margin-left: 20px;">
            <div class="blank10"></div>

            <div id="users_list"></div>

            <!-- 页数导航 -->
            <br>

            <!--            <div class="pagination" style="text-align: center"></div>-->

        </div>
    </div>
    <!--中间9列结束-->
</div>
<div id="footer"></div>

<!--  javaScripts -->
<script src="../js/jquery-2.1.1.min.js"></script>
<script src="../js/materialize.js"></script>
<script src="../js/cookie.js"></script>
<script src="../js/writeHTML.js"></script>
<script src="../js/xmlhttp.js"></script>
<script type="text/javascript" src="../js/LoginAjax.js"></script>
<!--<script src="../js/jQuery.js"></script>-->
<script src="../utils/TableSort.js"></script>
<script src="../js/FriendsAjax.js"></script>


<!--显示页码-->
<script>
    get_user_page_num();
</script>

</body>
</html>