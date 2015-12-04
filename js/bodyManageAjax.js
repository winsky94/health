/**
 * Created by Administrator on 2015/12/4.
 */
function updateBody() {
    var userName = document.getElementById("userName").value;
    height = document.getElementById("height").value;
    weight = document.getElementById("weight").value;
    var weightGoal = document.getElementById("weightGoal").value;
    var heart = document.getElementById("heart").value;
    var blood = document.getElementById("blood").value;

    var xmlHttp = "";
    if (window.XMLHttpRequest) {
        xmlHttp = new XMLHttpRequest();
        if (xmlHttp.overrideMimeType) {
            xmlHttp.overrideMimeType("text/xml");
        }
    } else if (window.ActiveXObject) {
        var activexName = new ActiveXObject["MSXML2.XMLHTTP",
            "Microsoft.XMLHTTP"];
        for (var i = 0; i < activexName.length; i++) {
            try {
                xmlHttp = new ActiveXObject(activexName[i]);
                break;
            } catch (e) {

            }
        }

    }

    if (xmlHttp != null) {
        xmlHttp.onreadystatechange = function () {
            on_update_response(xmlHttp)
        };
        xmlHttp.open("POST", "../controller/healthHandle.php");
        //post方式需要自己设置http的请求头
        xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        //post方式发送数据
        xmlHttp.send("action=updateBody" + "&userName=" + userName + "&height=" + height + "&weight=" + weight + "&weightGoal=" + weightGoal + "&heart=" + heart + "&blood=" + blood);
    }
}

function on_update_response(xmlHttp) {
    if (xmlHttp.readyState == 4) {
        // 判断http的交互是否成功
        if (xmlHttp.status == 200) {
            // 使用responseXML的方式来接收xml数据对象的DOM对象
            var domObj = xmlHttp.responseXML;
            var text = xmlHttp.responseText;
            // <message>ggggg</message>
            // getElementsByTagName根据标签名获取元素节点,返回的是一个数组
            var messageNodes = domObj.getElementsByTagName("message");

            if (messageNodes.length > 0) {
                // 获取message节点的文本内容
                var textNode = messageNodes[0].firstChild;
                var responseMessage = textNode.nodeValue;

                if (responseMessage == 'success') {
                    //window.location.href = "../view/user.php?userName=" + userName;

                    //修改理想体重
                    document.getElementById("idealWeight").innerHTML = (21.2 * height * height / 10000).toFixed(1);
                }
                else {
                    // 将数据显示在页面上
                    // 通过dom的方式到div标签所对应的元素节点
                    var divNode = document.getElementById("result");
                    // 设置元素节点中的html内容
                    divNode.innerHTML = responseMessage;
                }
            } else {
                alert("XML数据格式错误，原始文本内容为：" + xmlHttp.responseText);
            }
        } else {
            alert(xmlHttp.status);
            alert("出错了");
        }
    }
}