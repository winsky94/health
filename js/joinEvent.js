/**
 * Created by Administrator on 2015/12/1.
 */
function join(userName, title) {
    var xmlHttp = getXmlHttp();
    if (xmlHttp != null) {
        xmlHttp.onreadystatechange = function () {
            on_join_response(xmlHttp, title)
        };
        xmlHttp.open("POST", "../controller/EventHandle.php");
        //post方式需要自己设置http的请求头
        xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        //post方式发送数据
        xmlHttp.send("action=joinEvent" + "&userName=" + userName + "&title=" + title);

    }
}

function on_join_response(xmlHttp, title) {
    if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
        var result = xmlHttp.responseText;
        if (result == true) {
            location.reload();
        } else {
            alert("您已参加过“ " + title + " ”， 不能重复参加");
        }
    } else {
    }
}