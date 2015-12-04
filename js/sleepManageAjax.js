/**
 * Created by Administrator on 2015/12/4.
 */

function updateSleep() {
    WdatePicker({
        onpicking: function (dp) {
            var newDate = dp.cal.getNewDateStr();
            document.getElementById("date").value = newDate;

            getSleepData(newDate);

            setTableData();

            getData("");
        }
    })
}

function getSleepData(date) {
    if (date == "") {
        date = getNowDate();
    }


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

function setTableData() {
    var userName = document.getElementById("userName").value;
    var date = document.getElementById("date").value;

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
            on_sleep_table_response(xmlHttp)
        };
        xmlHttp.open("POST", "../controller/healthHandle.php");
        //post方式需要自己设置http的请求头
        xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        //post方式发送数据
        xmlHttp.send("action=getSleepTableData" + "&userName=" + userName + "&date=" + date);
    }
}

function on_sleep_table_response(xmlHttp) {
    if (xmlHttp.readyState == 4) {
        // 判断http的交互是否成功
        if (xmlHttp.status == 200) {
            // 使用responseXML的方式来接收xml数据对象的DOM对象
            var json = xmlHttp.responseText;
            var data = jQuery.parseJSON(json);
            var txt = '';

            for (var i = 0; i < data.length; i++) {
                var row = data[i];
                var startTime = row["startTime"];
                var endTime = row["endTime"];
                var dsNum = row["dsNum"];
                var lsNum = row["lsNum"];
                var wakeNum = row["wakeNum"];
                var wakeTime = row["wakeTime"];
                var score = row["score"];

                txt += '<tr>\
                <td>' + startTime + '</td>\
                <td>' + endTime + '</td>\
                <td>' + dsNum + '</td>\
                <td>' + lsNum + '</td>\
                <td>' + wakeNum + '</td>\
                <td>' + wakeTime + '</td>\
                <td>' + score + '</td>\
                </tr>\
                ';
            }

            $('#tableData').html(txt);
        } else {
            alert(xmlHttp.status);
            alert("出错了");
        }
    }
}

function getNowDate() {
    var date = new Date();
    var seperator = "-";
    var month = date.getMonth() + 1;
    var strDate = date.getDate();
    if (month >= 1 && month <= 9) {
        month = "0" + month;
    }
    if (strDate >= 0 && strDate <= 9) {
        strDate = "0" + strDate;
    }
    var currentDate = date.getFullYear() + seperator + month + seperator + strDate;
    return currentDate;
}