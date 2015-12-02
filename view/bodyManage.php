<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>身体管理</title>

    <!-- CSS  -->
    <link href="../css/material_icons.css" rel="stylesheet" media="screen,projection">
    <link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>

    <style type="text/css">
        .row {
            margin-left: 14%;
            margin-right: 14%;
        }

        .main {
            margin-top: 40px;
        }

        .table-container {
            display: table;
            border-spacing: 10px;
        }

        .row-container {
            display: table-row;

        }

        .cell {
            display: table-cell;
        }

    </style>

</head>
<body onload="write_header();write_footer()">
<header></header>

<div class="main container">
    <div class="row">
        <!-- 左侧 3列-->
        <div class="col s12 l3">
            <div class="collection black-text">
                <a class="collection-item waves-effect waves-light" onclick="return change('events')">
                    <i class="small grey-text mdi-editor-insert-emoticon"></i>
                    我的运动
                </a>
                <a class="collection-item waves-effect waves-light" onclick="return change('body')">
                    <i class="small grey-text mdi-action-perm-contact-cal"></i>
                    身体管理
                </a>
                <a class="collection-item waves-effect waves-light" onclick="return change('upload')">
                    <i class="small grey-text mdi-file-file-upload"></i>
                    数据上传
                </a>
                <a class="collection-item waves-effect waves-light" onclick="return change('statics')">
                    <i class="small grey-text mdi-editor-functions"></i>
                    数据分析
                </a>
            </div>
        </div>
        <!-- 左侧 3列 结束-->


        <!-- 右侧 9列 -->
        <div class="col s12 l9" id="right-content">
            <!-- 身体基本数据 -->
            <div class="card grey lighten-4">
                <h5 style="margin-left: 20px;font-weight: 100;font-family: '微软雅黑';color:#545454;">基本数据</h5>

                <div class="input-field col s12">
                    <div class="input-field col s4 l3">
                        <input id="height" type="text" name="sex" value="177">
                        <label for="height" class="active">身　高：</label>
                    </div>

                    <div class="input-field col s4 l3">
                        <input id="weight" type="text" name="sex" value="76">
                        <label for="weight" class="active">体　重：</label>
                    </div>

                    <div class="input-field col s4 l3">
                        <input id="heart" type="text" name="heart," value="100">
                        <label for="heart" class="active">心　率：</label>
                    </div>

                    <div class="input-field col s4 l3">
                        <input id="blood" type="text" name="blood" class="validate" value="120/78">
                        <label for="blood" class="active">血　压：</label>
                    </div>

                    <div class="col s8 table-container">
                        <div class="row-container">
                            <div class="input-field cell">
                                <input id="flag" type="hidden" name="flag" value="userinfo">
                                <input type="submit" value="保存" onclick="alert('监听')" class="btn btn-primary">
                            </div>
                            <div class="input-field cell">
                                <font color="red" size="2"><span id="result"></span></font>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="color:#545454;font-size: 18px;padding-left: 20px;float: left">
                    你的理想体重<span style="font-size: 36px;font-weight: bold;" id="idealWeight">67.4</span>公斤...干巴爹~~~
                </div>
            </div>
            <!-- 身体基本数据 结束-->

            <!-- 体重变化表-->
            <div class="card grey lighten-4">
                <table class="striped centered responsive-table">
                    <thead>
                    <tr>
                        <th data-field="date">日　期</th>
                        <th data-field="weight">体　重(kg)</th>
                        <th data-field="rate">变化率</th>
                        <th data-field="gap">距离目标体重差(kg)</th>
                    </tr>
                    </thead>

                    <tbody>
                    <tr>
                        <td>2015-10-31</td>
                        <td>76</td>
                        <td>0%</td>
                        <td>8.6</td>
                    </tr>

                    <tr>
                        <td>2015-10-31</td>
                        <td>76</td>
                        <td>0%</td>
                        <td>8.6</td>
                    </tr>

                    <tr>
                        <td>2015-10-31</td>
                        <td>76</td>
                        <td>0%</td>
                        <td>8.6</td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <!-- 体重变化表结束 -->

        </div>
        <!-- 右侧 9列 结束 -->

    </div>
    <!--class row 结束-->

</div>
<!--class main container 结束-->

<div id="footer"></div>

<!--  javaScripts -->
<script src="../js/jquery-2.1.1.min.js"></script>
<script src="../js/materialize.js"></script>
<script src="../js/cookie.js"></script>
<script src="../js/writeHTML.js"></script>
<script src="../js/xmlhttp.js"></script>
<script type="text/javascript" src="../js/LoginAjax.js"></script>

<script src="../js/ChangeUserInfoAjax.js"></script>
<script src="../js/ChangePWAjax.js"></script>
<script src="../js/materialize.js"></script>
<script src="../js/LoginAjax.js"></script>
<script src="../js/userAjax.js"></script>

<script type="text/javascript">
    // 根据左侧的导航栏点击刷新右侧界面
    function change(e) {
       if(e=="events"){
           window.location.href="healthManage.php";
       }else if(e=="body"){
           window.location.href="bodyManage.php";
       }else if(e=="upload"){
           window.location.href="sportsUpload.php";
       }else if(e=="statics"){
           window.location.href="staticsAnalysis.php";
       }
    }
</script>

</body>
</html>