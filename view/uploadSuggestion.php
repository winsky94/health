<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
    <title>在线发布建议</title>

    <!-- CSS  -->
    <link href="../css/material_icons.css" rel="stylesheet" media="screen,projection">
    <link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
    <link href="../css/stream-v1.css" rel="stylesheet" type="text/css">

    <style type="text/css">
        .row {
            margin-left: 14%;
            margin-right: 14%;
        }

        .main {
            margin-top: 40px;
        }

        .uploadFunction {
            margin-top: 10px;
            margin-left: 85px;
            margin-bottom: 10px;
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
        <div id="i_select_files">
        </div>

        <div id="i_stream_files_queue">
        </div>
        <a class="uploadFunction btn waves-effect waves-light" onclick="javascript:_t.upload();">开始上传</a>
        <a class="uploadFunction btn waves-effect waves-light" onclick="javascript:_t.stop();">停止上传</a>
        <a class="uploadFunction btn waves-effect waves-light" onclick="javascript:_t.cancel();"> 取　消 </a>
        <h6>Messages:</h6>
        <div id="i_stream_message_container" class="stream-main-upload-box" style="overflow: auto;height:200px;">
        </div>
    </div>
</div>

<div id="footer"></div>


<!--  javaScripts -->
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
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

<script type="text/javascript" src="../js/stream-v1.js"></script>
<script type="text/javascript">
    /**
     * 配置文件（如果没有默认字样，说明默认值就是注释下的值）
     * 但是，on*（onSelect， onMaxSizeExceed...）等函数的默认行为
     * 是在ID为i_stream_message_container的页面元素中写日志
     */
    var config = {
        browseFileId: "i_select_files", /** 选择文件的ID, 默认: i_select_files */
        browseFileBtn: "<div>请选择文件</div>", /** 显示选择文件的样式, 默认: `<div>请选择文件</div>` */
        dragAndDropArea: "i_select_files", /** 拖拽上传区域，Id（字符类型"i_select_files"）或者DOM对象, 默认: `i_select_files` */
        dragAndDropTips: "<span>把文件(文件夹)拖拽到这里</span>", /** 拖拽提示, 默认: `<span>把文件(文件夹)拖拽到这里</span>` */
        filesQueueId: "i_stream_files_queue", /** 文件上传容器的ID, 默认: i_stream_files_queue */
        filesQueueHeight: 200, /** 文件上传容器的高度（px）, 默认: 450 */
        messagerId: "i_stream_message_container", /** 消息显示容器的ID, 默认: i_stream_message_container */
        multipleFiles: true, /** 多个文件一起上传, 默认: false */
        autoUploading: false, /** 选择文件后是否自动上传, 默认: true */
        autoRemoveCompleted: true, /** 是否自动删除容器中已上传完毕的文件, 默认: false */
//		maxSize: 104857600//, /** 单个文件的最大大小，默认:2G */
//		retryCount : 5, /** HTML5上传失败的重试次数 */
//		postVarsPerFile : { /** 上传文件时传入的参数，默认: {} */
//			param1: "val1",
//			param2: "val2"
//		},
        swfURL: "../swf/FlashUploader.swf", /** SWF文件的位置 */
        tokenURL: "../service/upload.php?action=tk", /** 根据文件名、大小等信息获取Token的URI（用于生成断点续传、跨域的令牌） */
        frmUploadURL: "../service/upload.php?action=fd;", /** Flash上传的URI */
        uploadURL: "../service/upload.php?action=up", /** HTML5上传的URI */
//		simLimit: 200, /** 单次最大上传文件个数 */
//		extFilters: [".txt", ".rpm", ".rmvb", ".gz", ".rar", ".zip", ".avi", ".mkv", ".mp3"], /** 允许的文件扩展名, 默认: [] */
//		onSelect: function(list) {alert('onSelect')}, /** 选择文件后的响应事件 */
//		onMaxSizeExceed: function(size, limited, name) {alert('onMaxSizeExceed')}, /** 文件大小超出的响应事件 */
//		onFileCountExceed: function(selected, limit) {alert('onFileCountExceed')}, /** 文件数量超出的响应事件 */
//		onExtNameMismatch: function(name, filters) {alert('onExtNameMismatch')}, /** 文件的扩展名不匹配的响应事件 */
//		onCancel : function(file) {alert('Canceled:  ' + file.name)}, /** 取消上传文件的响应事件 */
//		onComplete: function(file) {alert('onComplete')}, /** 单个文件上传完毕的响应事件 */
//		onQueueComplete: function() {alert('onQueueComplete')}, /** 所以文件上传完毕的响应事件 */
//		onUploadError: function(status, msg) {alert('onUploadError')} /** 文件上传出错的响应事件 */
    };
    var _t = new Stream(config);
</script>

</body>
</html>