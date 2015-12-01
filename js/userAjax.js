/**
 * Created by Administrator on 2015/10/28.
 */

function get_user_info() {
    var userName = $("#user-name").attr("title");
    var xmlhttp = getXmlHttp();
    if (xmlhttp != null) {
        xmlhttp.onreadystatechange = function () {
            onUserInfoResponse(xmlhttp)
        };

        // post方式请求的代码并访问
        xmlhttp.open("POST", "../controller/userHandle.php", true);
        // post方式需要自己设置http的请求头
        xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        // post方式发送数据
        xmlhttp.send("action=getUserInfo" + "&userName=" + userName);
        // 4.发送数据，开始和服务器端进行交互
        // 同步方式下，send这句话全在服务器端数据回来后才执行完
        // 异步方式下，send这句话会立即完成执行
        // xmlHttp.send(null);

    } else {
        alert("Your browser does not support XMLHttpRequest.");
    }
}

function onUserInfoResponse(xmlhttp) {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var text = xmlhttp.responseText;
        try {
            var xmlDoc = new ActiveXObject("Microsoft.XMLDOM");
            xmlDoc.async = "false";
            xmlDoc.loadXML(text);
        } catch (e) {
            try {
                var parser = new DOMParser();
                xmlDoc = parser.parseFromString(text, "text/xml");
            } catch (e) {
                alert(e.message);
            }
        }

        var user_info = xmlDoc.getElementsByTagName("user")[0];
        var txt = write_user_info(user_info);
        $("#info").html(txt);
    }
}