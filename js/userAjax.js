/**
 * Created by Administrator on 2015/10/28.
 */

function get_user_info() {
    var userName = document.getElementById("username").innerText;
    var xmlHttp = getXmlHttp();
    if (xmlHttp != null) {
        xmlHttp.onreadystatechange = function () {
            onUserInfoResponse(xmlHttp)
        };

        // post方式请求的代码并访问
        xmlHttp.open("POST", "../controller/userHandle.php", true);
        // post方式需要自己设置http的请求头
        xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        // post方式发送数据
        xmlHttp.send("action=getUserInfo" + "&userName=" + userName);
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


//=============================================================================
//删除
function deleteUser(e) {
    if (!confirm("确认要删除吗？")) {
        return;
    }
    var userName = e.parentNode.parentNode.cells[0].innerHTML;
    var login_user = document.getElementById("login_user").innerHTML;

    if (userName == login_user) {
        alert("不能删除自己呢！");
        return;
    }
    var xmlHttp = getXmlHttp();
    if (xmlHttp != null) {
        xmlHttp.onreadystatechange = function () {
            onDeleteResponse(xmlHttp)
        };

        // post方式请求的代码并访问
        xmlHttp.open("POST", "../controller/userHandle.php", true);
        // post方式需要自己设置http的请求头
        xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        // post方式发送数据
        xmlHttp.send("action=delete" + "&userName=" + userName);
        // 4.发送数据，开始和服务器端进行交互
        // 同步方式下，send这句话全在服务器端数据回来后才执行完
        // 异步方式下，send这句话会立即完成执行
        // xmlHttp.send(null);

    } else {
        alert("Your browser does not support XMLHttpRequest.");
    }
}

function onDeleteResponse(xmlHttp) {
    if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
        var text = xmlHttp.responseText;
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

        if (xmlDoc) {
            window.location.reload();
        } else {
            alert("删除失败~");
        }

    }
}