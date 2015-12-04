/**
 * Created by Administrator on 2015/12/3.
 */

function initStaticsData() {
    var userName = document.getElementById("userName").value;
    // 创建XMLHttprequest对象
    // 需要针对IE和其他类型的浏览器建议这个对象的不同方式写不同的代码
    var xmlHttp = "";
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
            on_total_data_response(xmlHttp)
        };
        xmlHttp.open("POST", "../controller/healthHandle.php");
        //post方式需要自己设置http的请求头
        xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        //post方式发送数据
        xmlHttp.send("action=totalStatics" + "&userName=" + userName);
    }
}

function on_total_data_response(xmlHttp) {
    if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
        var text = jQuery.parseJSON(xmlHttp.responseText);
        document.getElementById("meters_total").value = text.meters_total;
        document.getElementById("minutes_total_hour").value = text.minutes_total_hour;
        document.getElementById("minutes_total_minute").value = text.minutes_total_minute;
        document.getElementById("calories_total").value = text.calories_total;
    }
}

function setGoal() {
    var userName = document.getElementById("userName").value;
    var type = document.getElementById("type").value;
    var value = document.getElementById("value").value;

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
            on_set_response(xmlHttp)
        };
        xmlHttp.open("POST", "../controller/healthHandle.php");
        //post方式需要自己设置http的请求头
        xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        //post方式发送数据
        xmlHttp.send("action=setWeekGoal" + "&type=" + type + "&value=" + value + "&userName=" + userName);

    }
}

function on_set_response(xmlHttp) {
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
                    //alert("success");
                    var goal_value = document.getElementById("value").value;
                    var obj = document.getElementById("type"); //定位id
                    var type = obj.options[obj.options.selectedIndex].value;
                    if (type == "距离(公里)") {
                        var true_value = document.getElementById("meters_total").value;
                    } else if (type == "时长(小时)") {
                        var true_value = document.getElementById("minutes_total_hour").value + document.getElementById("minutes_total_minute").value / 60;
                    } else if (type == "热量(卡路里)") {
                        var true_value = document.getElementById("calories_total").value;
                    }

                    updateRate(true_value, goal_value);
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

function updateRate(true_value, goal_value) {
    var radialObj = $("#indicatorContainer").data("radialIndicator");
    var perCent = true_value / goal_value * 100;
    radialObj.animate(perCent);
}