<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>查看活动</title>

    <!-- CSS  -->
    <link href="../css/material_icons.css" rel="stylesheet" media="screen,projection">
    <link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/showEvents.css" type="text/css" rel="stylesheet" media="screen,projection"/>


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
                    require_once("../service/EventsService.php");
                    $eventService = new EventsService();
                    $result = $eventService->getJoinedEvents($userName);
                    ?>
                    <h5 id="userName"><?php echo $userName; ?></h5>
                </li>

                <li>
                    <?php
                    if (sizeof($result) == 0) {
                        ?>
                        <p class="collection-item" style="font-size: 18px;font-weight: 900;">尚未参加过活动...</p>
                        <?php
                    } else {
                        ?>
                        <p class="collection-item" style="font-size: 18px;font-weight: 900;">已参加的活动有：</p>
                        <?php
                        foreach ($result as $eventTitle) {
                            ?>
                            <p class="collection-item" style="margin-left: 10px;"><?php echo $eventTitle ?></p>
                            <?php
                        }
                    }
                    ?>
                </li>
            </ul>
        </div>
        <!-- 左侧 3列 结束-->

        <!--中间活动列表-->
        <div class="col s12 l8" id="content-on-middle">
            <div style="margin-left: 20px;">
                <div class="font16">最新活动</div>
                <div class="blank10"></div>

                <div id="events_list"></div>

                <!-- 页数导航 -->
                <br>

                <div class="pagination" style="text-align: center">
                </div>

            </div>
        </div>
        <!--中间活动列表结束-->

        <!--右侧快速返回顶部-->
        <div id="back-up"></div>
        <!--右侧快速返回顶部结束-->

    </div>
    <!--12列结束-->
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
<script src="../js/eventAjax.js"></script>
<script src="../js/joinEvent.js"></script>
<script>
    var jQ = jQuery.noConflict();
    var $ = jQ;
</script>

<!--显示页码-->
<script>
    get_page_num();
</script>

<!-- 滚动显示 -->
<script type="text/javascript" src="../js/TweenMax.min.js"></script>
<script type="text/javascript">

    function joinEvent(title) {
        var state = document.getElementById("state").innerHTML;
        if (state.indexOf("已结束") > 0) {
            alert("活动已结束，不能参加~~~");
            return;
        }

        if (window.confirm('你确定要参加该活动吗？')) {
            var userName = document.getElementById("login_user").innerText;
            join(userName, title);
            return true;
        } else {
            return false;
        }
    }
</script>

</body>
</html>