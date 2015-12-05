<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>预约</title>

    <!-- CSS  -->
    <link href="../css/material_icons.css" rel="stylesheet" media="screen,projection">
    <link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>

    <style type="text/css">
        .row {
            margin-left: 9%;
            margin-right: 9%;
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
        <?php
        $type = $_GET["type"];
        ?>
        <div class="userType">
            <ul style="list-style:none;" onchange="chooseType()">
                <?php
                if ($type == "doctor-coach") {
                    echo '
                    <li style="float: left;margin-left: 110px;">
                        <input class="with-gap" name="types" type="radio" id="doctor-coach" value="doctor-coach" checked/>
                        <label for="doctor-coach">全部</label>
                    </li>
                    <li style="float: left;margin-left: 110px;">
                        <input class="with-gap" name="types" type="radio" id="doctor" value="doctor"/>
                        <label for="doctor">医生</label>
                    </li>
                    <li style="float: left;margin-left: 110px;">
                        <input class="with-gap" name="types" type="radio" id="coach" value="coach" />
                        <label for="coach">教练</label>
                    </li>
                ';
                } elseif ($type == "doctor") {
                    echo '
                    <li style="float: left;margin-left: 110px;">
                        <input class="with-gap" name="types" type="radio" id="doctor-coach" value="doctor-coach"/>
                        <label for="doctor-coach">全部</label>
                    </li>
                    <li style="float: left;margin-left: 110px;">
                        <input class="with-gap" name="types" type="radio" id="doctor" value="doctor" checked/>
                        <label for="doctor">医生</label>
                    </li>
                    <li style="float: left;margin-left: 110px;">
                        <input class="with-gap" name="types" type="radio" id="coach" value="coach" />
                        <label for="coach">教练</label>
                    </li>
                ';
                } elseif ($type == "coach") {
                    echo '
                   <li style="float: left;margin-left: 110px;">
                        <input class="with-gap" name="types" type="radio" id="doctor-coach" value="doctor-coach"/>
                        <label for="doctor-coach">全部</label>
                    </li>
                    <li style="float: left;margin-left: 110px;">
                        <input class="with-gap" name="types" type="radio" id="doctor" value="doctor"/>
                        <label for="doctor">医生</label>
                    </li>
                    <li style="float: left;margin-left: 110px;">
                        <input class="with-gap" name="types" type="radio" id="coach" value="coach" checked/>
                        <label for="coach">教练</label>
                    </li>
                ';
                } else {
                    echo "获得的type值为：", $type, "，显示单选按钮组失败";
                }
                ?>
            </ul>
        </div>
        <div>
            <table class="striped centered responsive-table">
                <thead>
                <tr>
                    <th data-field="userName">用户名</th>
                    <th data-field="type">类型</th>
                    <th data-field="sex">性别</th>
                    <th data-field="lastLoadTime">上次登录时间</th>
                    <th data-field="action">操作</th>
                </tr>
                </thead>

                <tbody>
                <?php
                require_once("../service/UserService.php");

                $user = new UserService();

                $result = $user->getUserList($type);
                foreach ($result as $row) {
                    $userName = $row['userName'];
                    $userType = $row['type'];
                    $sex = $row['sex'];
                    $lastLoadTime = $row['lastLoadTime'];
                    if ($lastLoadTime == "") {
                        $lastLoadTime = "—";
                    }
                    ?>
                    <tr>
                        <td onclick='showDetail(this)'><?php echo $userName; ?></td>
                        <td onclick='showDetail(this)'><?php echo $userType; ?></td>
                        <td onclick='showDetail(this)'><?php echo $sex; ?></td>
                        <td onclick='showDetail(this)'><?php echo $lastLoadTime; ?></td>
                        <td>
                            <button class="btn" onclick="reverse(this);">预约</button>
                        </td>
                    </tr>

                    <?php
                }

                ?>

                </tbody>
            </table>
        </div>

    </div>
    <!-- 中间 9列 结束-->
</div>


<div id="footer"></div>


<!--  javaScripts -->
<script src="../js/jquery-2.1.1.min.js"></script>
<script src="../js/materialize.js"></script>
<script src="../js/cookie.js"></script>
<script src="../js/writeHTML.js"></script>
<script src="../js/xmlhttp.js"></script>
<script src="../js/LoginAjax.js"></script>
<script src="../js/jQuery.js"></script>
<script src="../js/ChangeUserInfoAjax.js"></script>
<script src="../js/ChangePWAjax.js"></script>
<script src="../js/materialize.js"></script>
<script src="../js/LoginAjax.js"></script>
<script src="../js/userAjax.js"></script>
<script src="../js/reverse.js"></script>

<script type="text/javascript">
    // 表格单击一行跳转
    function showDetail(td) {
        var cells = td.parentNode.cells;
        var userName = cells[0].innerHTML;
        window.location.href = "../view/userInfo.php?userName=" + userName;
    }

    //单选按钮的跳转监听
    function chooseType() {
        var type = "sd";
        var userName = document.getElementById("userName").innerText;
        var radios = document.getElementsByName("types");
        for (var i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                type = radios[i].value;
            }
        }
        window.location.href = "../view/reserve.php?type=" + type + "&userName=" + userName;
    }

    $(document).ready(function () {
        $('.userType').pushpin({top: 70});
    });

</script>

</body>
</html>