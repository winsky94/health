<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>用户详情</title>

    <!-- CSS  -->
    <link href="../css/material_icons.css" rel="stylesheet" media="screen,projection">
    <link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>


    <!--    <script type="text/javascript">-->
    <!--        $(document).ready(function () {-->
    <!--            //首先将#back-to-top隐藏-->
    <!--            $("#back-to-top").hide();-->
    <!--            //当滚动条的位置处于距顶部100像素以下时，跳转链接出现，否则消失-->
    <!--            $(function () {-->
    <!--                $(window).scroll(function () {-->
    <!--                    var button_top=$("#back-to-top").offset().top;-->
    <!--                    var footer_top=$("#footer").offset().top;-->
    <!--                    var x=footer_top-button_top;-->
    <!--                    if ($(window).scrollTop() > 100 ) {-->
    <!--                        $("#back-to-top").fadeIn(1500);-->
    <!--                        if(x<81.5){-->
    <!--                            $("#back-to-top").fadeOut(1500);-->
    <!--                        }-->
    <!--                    }-->
    <!--                    else {-->
    <!--                        $("#back-to-top").fadeOut(1500);-->
    <!--                    }-->
    <!---->
    <!---->
    <!--                });-->
    <!--                //当点击跳转链接后，回到页面顶部位置-->
    <!--                $("#back-to-top").click(function () {-->
    <!--                    $('body,html').animate({scrollTop: 0}, 1000);-->
    <!--                    return false;-->
    <!--                });-->
    <!--            });-->
    <!--        });-->
    <!--    </script>-->

</head>
<body onload="write_header();write_footer();verify_showAllInterest('');write_quick_back_button();" id="top">

<header></header>

<?php
$userName = $_GET['userName'];

require_once("../service/UserService.php");

$userService = new UserService();
$user = $userService->getUserByName($userName);
$sex = $user->getSex();
$age = $user->getAge();
$height = $user->getHeight();
$weight = $user->getWeight();
$email = $user->getEmail();
$telephone = $user->getTelephone();
$lastLoadTime = $user->getLastLoadTime();

?>


<div class="main container">
    <div class="row">
        <!--左部个人信息栏-->
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
        <!--结束左部个人信息栏-->

        <!-- 中间个人动态正文 -->
        <div id="interests_list" class="col s12 l8" id="content-on-middle">

        </div>
        <!-- 中间动态内容结束 -->

        <!--右侧快速返回顶部-->
        <div id="back-up"></div>
        <!--右侧快速返回顶部结束-->


    </div>
</div>


<div id="footer"></div>
<!--  javaScripts -->
<script src="../js/jquery-2.1.1.min.js"></script>
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
<script src="../js/showInterestAjax.js"></script>
</body>
</html>