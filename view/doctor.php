<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>个人信息</title>

    <!-- CSS  -->
    <link href="../css/material_icons.css" rel="stylesheet" media="screen,projection">
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
<body onload="write_header();write_footer();get_user_info();"
      id="top">
<header></header>

<div class="main container">
    <br>

    <?php
    $userName = $_GET['userName'];
    ?>

    <div class="row">
        <!-- 左侧 用户信息 3列-->
        <div class="col s12 l3">
            <ul class="collection with-header">
                <li class="collection-header">
                    <img src="../images/back1.jpg" width="150px" height="150px">
                    <h5 id="userName"><?php echo $userName; ?></h5>
                </li>
                <p class="collection-item">最近登录时间：<br> &nbsp;&nbsp;&nbsp;&nbsp; 2015-10-19 20:20:20</p>

            </ul>
        </div>
        <!-- 左侧 3列 结束-->

        <div class="col s12 l9">
            <div class="row" style="margin-left: 15px">

                <div id="info" class="col s12 l9"></div>
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
<script src="../js/userAjax.js"></script>
<script src="../js/showInterestAjax.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('ul.tabs').tabs();
    });

</script>

</body>
</html>