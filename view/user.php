<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>个人信息</title>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
    <link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/showEvents.css" type="text/css" rel="stylesheet" media="screen,projection"/>

    <style type="text/css">
        .row {
            margin-left: 9%;
            margin-right: 9%;
        }

        .main {
            margin-top: 40px;
        }

        h4 {
            color: #26A69A;
        }

        #info {
            display: table;
            border-spacing: 10px;
        }

        .table-row {
            display: table-row;
        }

        .property {
            display: table-cell;
        }

        .value {
            display: table-cell;
        }
    </style>

</head>
<body onload="write_header();write_footer();get_user_info();write_quick_back_button();" id="top">
<header></header>

<div class="main container">
    <br>

    <?php
    $userName=$_GET['userName'];
    ?>

    <div class="row">
        <!-- 左侧 用户信息 3列-->
        <div class="col s12 l3">
            <ul class="collection with-header">
                <li class="collection-header">
                    <img src="../images/back1.jpg" width="150px" height="150px">
                    <h5 id="username"><?php echo $userName; ?></h5>
                </li>
                <p class="collection-item">最近登录时间：<br> &nbsp;&nbsp;&nbsp;&nbsp; 2015-10-19 20:20:20</p>

            </ul>
        </div>
        <!-- 左侧 3列 结束-->

        <div class="col s12 l9">
            <div class="row" style="margin-left: 15px">
                <div class="col s4">
                    <ul class="tabs">
                        <li class="tab col s3"><a href="#info">个人信息</a></li>
                        <li class="tab col s3"><a href="#events">我的动态</a></li>
                    </ul>
                </div>

                <div id="info" class="col s12 l9"></div>

                <div id="events" class="col s12 l10">
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
                    <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
                    <script src="../js/writeHTML.js"></script>
                    <script>
                        write_pagination(1,10,5,5);
                    </script>

                </div>
                <!--右侧快速返回顶部-->
                <div id="back-up"></div>
                <!--右侧快速返回顶部结束-->
            </div>
        </div>


    </div>
</div>

<div id="footer"></div>

<!--  javaScripts -->

<script src="../js/materialize.js"></script>
<script src="../js/cookie.js"></script>

<script src="../js/xmlhttp.js"></script>
<script type="text/javascript" src="../js/LoginAjax.js"></script>
<script src="../js/jQuery.js"></script>
<script src="../js/ChangeUserInfoAjax.js"></script>
<script src="../js/ChangePWAjax.js"></script>
<script src="../js/materialize.js"></script>
<script src="../js/LoginAjax.js"></script>
<script src="../js/userAjax.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('ul.tabs').tabs();
    });
</script>

</body>
</html>