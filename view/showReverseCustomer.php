<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>查看预约客户</title>

    <!-- CSS  -->
    <link href="../css/material_icons.css" rel="stylesheet" media="screen,projection">
    <link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>

</head>
<body onload="write_header();">
<header></header>
<?php
$userLogIn = $_GET["userName"];
?>
<div class="main container">
    <table class="striped centered responsive-table" id="userInfo">
        <thead>
        <tr>
            <th data-field="userName" onclick="sortTable('userInfo',0,0);" id="userName">用户名</th>
            <th data-field="sex" onclick=" sortTable('userInfo',2,0);" id="sex">性别</th>
            <th data-field="height" onclick=" sortTable('userInfo',3,'int');" id="height">身高(cm)</th>
            <th data-field="weight" onclick=" sortTable('userInfo',4,'int');" id="weight">体重(kg)</th>
            <th data-field="lastLoadTime" onclick=" sortTable('userInfo',5,'date');" id="lastLoadTime">上次登录时间</th>
        </tr>
        </thead>

        <tbody>
        <?php

        require_once("../service/UserService.php");

        $user = new UserService();

        $result = $user->getReverseCustomer($userLogIn);
        foreach ($result as $row) {
            $userName = $row['userName'];
            $sex = $row['sex'];
            $height = $row['height'];
            $weight = $row['weight'];
            $lastLoadTime = $row['lastLoadTime'];
            if ($lastLoadTime == "") {
                $lastLoadTime = "—";
            }

            echo "<tr onclick='showDetail(this)'>";
            echo "<td>$userName</td>";
            echo "<td>$sex</td>";
            echo "<td>$height</td>";
            echo "<td>$weight</td>";
            echo "<td>$lastLoadTime</td>";
            echo "</tr>";
        }

        ?>
        </tbody>
    </table>
</div>


<!--  javaScripts -->
<script src="../js/jquery-2.1.1.min.js"></script>
<script src="../js/materialize.js"></script>
<script src="../js/cookie.js"></script>
<script src="../js/writeHTML.js"></script>
<script type="text/javascript" src="../js/LoginAjax.js"></script>
<!--<script src="../js/jQuery.js"></script>-->
<script src="../utils/TableSort.js"></script>
<script>
    // 表格单击一行跳转
    function showDetail(tr) {
        var cells = tr.cells;
        var userName = cells[0].innerHTML;
        window.location.href = "../view/userInfo.php?userName=" + userName;
    }

</script>

</body>
</html>