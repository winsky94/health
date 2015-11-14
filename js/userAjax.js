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
        xmlhttp.open("GET", "../controller/userHandle.php?userName=" + userName, true);
        xmlhttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xmlhttp.send();
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