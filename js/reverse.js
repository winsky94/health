/**
 * Created by Administrator on 2015/12/5.
 */
function reverse(e) {

    if (confirm("确认预约吗？")) {
        doReverse(e);
    }

}

function doReverse(e) {
    var followerName = document.getElementById("userName").innerText;
    var cells = e.parentNode.parentNode.cells;
    var followedName = cells[0].innerHTML;

    var xmlHttp = "";
    // 创建XMLHttprequest对象
    // 需要针对IE和其他类型的浏览器建议这个对象的不同方式写不同的代码
    if (window.XMLHttpRequest) {
        // 针对FireFox,Mozillar,opera,safari,ie7,ie8
        xmlHttp = new XMLHttpRequest();
        // 针对某些特定版本的moziller浏览器的BUG进行修正
        if (xmlHttp.overrideMimeType) {
            xmlHttp.overrideMimeType("text/xml");
        }
    } else if (window.ActiveXObject) {
        // 针对IE6,ie5.5 ie5
        // 两个可以用于创建XMLHTTPREQUEST对象控件名称，保存在一个JS数组中
        // 排在前面的版本较新
        var activexName = new ActiveXObject["MSXML2.XMLHTTP",
            "Microsoft.XMLHTTP"];
        for (var i = 0; i < activexName.length; i++) {
            try {
                // 取出一个控件名进行创建，如果创建成功就终止循环
                // 如果创建失败，会抛出异常，然后可以继续循环，继续尝试创建
                xmlHttp = new ActiveXObject(activexName[i]);
                break;
            } catch (e) {

            }
        }

    }

    if (xmlHttp != null) {
        xmlHttp.onreadystatechange = function () {
            on_reverse_response(xmlHttp, followedName)
        };
        xmlHttp.open("POST", "../controller/userHandle.php");
        //post方式需要自己设置http的请求头
        xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        //post方式发送数据
        xmlHttp.send("action=reverse" + "&followerName=" + followerName + "&followedName=" + followedName);

    }
}


function on_reverse_response(xmlHttp, followedName) {
    if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
        var result = xmlHttp.responseText;
        if (result == true) {
            //location.reload();
        } else {
            alert("您已预约过“ " + followedName + " ”");
        }
    } else {
    }
}