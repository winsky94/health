/**
 * Created by Administrator on 2015/12/4.
 */

function updateSleep() {
    WdatePicker({
        onpicking: function (dp) {
            var newDate = dp.cal.getNewDateStr();
            getSleepData(newDate);
        }
    })
}

function getSleepData(date) {
    var userName = document.getElementById("userName").value;
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
            on_sleep_data_response(xmlHttp)
        };
        xmlHttp.open("POST", "../controller/healthHandle.php");
        //post方式需要自己设置http的请求头
        xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        //post方式发送数据
        xmlHttp.send("action=getSleepData" + "&userName=" + userName + "&date=" + date);
    }
}

function on_sleep_data_response(xmlHttp) {
    if (xmlHttp.readyState == 4) {
        // 判断http的交互是否成功
        if (xmlHttp.status == 200) {
            // 使用responseXML的方式来接收xml数据对象的DOM对象
            var json = xmlHttp.responseText;
            var text = jQuery.parseJSON(xmlHttp.responseText);
            var startTime = text.startTime;
            var endTime = text.endTime;
            var hour = text.hour;
            var minute = text.minute;
            var validPerCent = text.validPerCent;

            document.getElementById("startTime").innerHTML = startTime;
            document.getElementById("endTime").innerHTML = endTime;
            document.getElementById("valid_hour").innerHTML = hour;
            document.getElementById("valid_minute").innerHTML = minute;

            updateValidRate(validPerCent * 100);
        } else {
            alert(xmlHttp.status);
            alert("出错了");
        }
    }
}

function updateValidRate(rate) {
    var radialObj = $("#indicatorContainer").data("radialIndicator");
    radialObj.animate(rate);
}