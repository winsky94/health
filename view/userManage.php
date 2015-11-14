<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>用户管理</title>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
    <link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>

    <script src="../js/jquery-2.1.1.min.js"></script>

    <script src="../js/cookie.js"></script>
    <script src="../js/writeHTML.js"></script>
    <script src="../js/xmlhttp.js"></script>
    <script type="text/javascript" src="../js/LoginAjax.js"></script>

    <script>
        // 表格单击一行跳转
        function showDetail(tr){
            var cells= tr.cells;
            var userName=cells[0].innerHTML;
            window.location.href="../view/userInfo.php?userName="+userName;
        }

        //单选按钮的跳转监听
        function chooseType(){
            var type="sd";
            var radios = document.getElementsByName("types");
            for(var i=0;i<radios.length;i++){
                if(radios[i].checked){
                    type = radios[i].value;
                }
            }
            window.location.href="../view/userManage.php?type="+type;
        }

        $(document).ready(function(){
            $('.userType').pushpin({top: 0});
        });

    </script>

</head>
<body onload="write_header();">
<header></header>
<div class="main container">
    <?php
    $type=$_GET['type'];
    ?>
    <div class="userType">
        <ul style="list-style:none;" onchange="chooseType()">
            <?php
            if($type=="all"){
                echo '
                    <li style="float: left;margin-left: 150px;">
                        <input class="with-gap" name="types" type="radio" id="all" value="all" checked/>
                        <label for="all">全部</label>
                    </li>
                    <li style="float: left;margin-left: 200px;">
                        <input class="with-gap" name="types" type="radio" id="user"value="user"/>
                        <label for="user">个人用户</label>
                    </li>
                    <li style="float: left;margin-left: 200px;">
                        <input class="with-gap" name="types" type="radio" id="doctor-coach" value="doctor-coach" />
                        <label for="doctor-coach">医生教练</label>
                    </li>
                ';
            }elseif($type=="user"){
                echo '
                    <li style="float: left;margin-left: 150px;">
                        <input class="with-gap" name="types" type="radio" id="all" value="all"/>
                        <label for="all">全部</label>
                    </li>
                    <li style="float: left;margin-left: 200px;">
                        <input class="with-gap" name="types" type="radio" id="user"value="user" checked/>
                        <label for="user">个人用户</label>
                    </li>
                    <li style="float: left;margin-left: 200px;">
                        <input class="with-gap" name="types" type="radio" id="doctor-coach" value="doctor-coach" />
                        <label for="doctor-coach">医生教练</label>
                    </li>
                ';
            }elseif($type=="doctor-coach"){
                echo '
                    <li style="float: left;margin-left: 150px;">
                        <input class="with-gap" name="types" type="radio" id="all" value="all"/>
                        <label for="all">全部</label>
                    </li>
                    <li style="float: left;margin-left: 200px;">
                        <input class="with-gap" name="types" type="radio" id="user"value="user"/>
                        <label for="user">个人用户</label>
                    </li>
                    <li style="float: left;margin-left: 200px;">
                        <input class="with-gap" name="types" type="radio" id="doctor-coach" value="doctor-coach" checked/>
                        <label for="doctor-coach">医生教练</label>
                    </li>
                ';
            }else{
                echo "获得的type值为：",$type,"，显示单选按钮组失败";
            }
            ?>

        </ul>
    </div>
    <table class="striped centered responsive-table">
        <thead>
        <tr>
            <th data-field="userName">用户名</th>
            <?php

            if($type=="all"){
                echo '<th data-field="type">类型</th>';
            }

            ?>
            <th data-field="sex">性别</th>
            <th data-field="height">身高(cm)</th>
            <th data-field="weight">体重(kg)</th>
            <th data-field="lastLoadTime">上次登录时间</th>
        </tr>
        </thead>

        <tbody>
        <?php

        require_once("../service/UserService.php");

        $user = new UserService();

        $result = $user->getUserList($type);
        foreach ($result as $row) {
            $userName=$row['userName'];
            if($type=="all"){
                $userType=$row['type'];
            }
            $sex=$row['sex'];
            $height=$row['height'];
            $weight=$row['weight'];
            $lastLoadTime=$row['lastLoadTime'];
            if($lastLoadTime==""){
                $lastLoadTime="—";
            }

            echo "<tr onclick='showDetail(this)'>";
            echo "<td>$userName</td>";
            if($type=="all"){
                echo "<td>$userType</td>";
            }
            echo "<td>$sex</td>";
            echo "<td>$height</td>";
            echo "<td>$weight</td>";
            echo "<td>$lastLoadTime</td>";
            echo "</tr>";
        }

        ?>

        <tr>
            <td>Alvin</td>
            <td class="test">Eclair</td>
            <td class="test">$0.87</td>
        </tr>

        <tr>
            <td>Alvin</td>
            <td class="test">Eclair</td>
            <td class="test">$0.87</td>
        </tr>

        <tr>
            <td>Alvin</td>
            <td class="test">Eclair</td>
            <td class="test">$0.87</td>
        </tr>

        <tr>
            <td>Alvin</td>
            <td class="test">Eclair</td>
            <td class="test">$0.87</td>
        </tr>

        <tr>
            <td>Alvin</td>
            <td class="test">Eclair</td>
            <td class="test">$0.87</td>
        </tr>

        <tr>
            <td>Alvin</td>
            <td class="test">Eclair</td>
            <td class="test">$0.87</td>
        </tr>

        <tr>
            <td>Alvin</td>
            <td class="test">Eclair</td>
            <td class="test">$0.87</td>
        </tr>

        </tbody>
    </table>
</div>

<!--  javaScripts -->
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="../js/materialize.js"></script>
</body>
</html>