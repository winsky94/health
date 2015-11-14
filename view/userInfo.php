<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>用户详情</title>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>

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
<body onload="write_header();write_footer();write_quick_back_button();" id="top">

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
        <div class="col s12 l8" id="content-on-middle">
            <!--动态内容-->
            <div class="card-panel grey lighten-5 z-depth-1">
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

            <!--动态内容-->
            <div class="card-panel grey lighten-5 z-depth-1">
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

            <!--动态内容-->
            <div class="card-panel grey lighten-5 z-depth-1">
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
            <!--动态结束-->

            <!-- 页数导航 -->
            <br>
            <div class="pagination" style="text-align: center">
            </div>
            <!--显示页码-->
            <script>
                write_pagination(1,10,5,5);
            </script>

        </div>
        <!-- 中间动态内容结束 -->

        <!--右侧快速返回顶部-->
        <div id="back-up"></div>
        <!--右侧快速返回顶部结束-->


    </div>
</div>


<div id="footer"></div>

</body>
</html>